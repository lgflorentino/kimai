<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Base class for all re-installation commands, which are not used during application runtime.
 * @codeCoverageIgnore
 */
abstract class AbstractResetCommand extends Command
{
    public function __construct(private string $kernelEnvironment)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp(
                <<<EOT
                        This command will drop and re-create the database and its schemas, load data and clear the cache.
                        Use the <info>-n</info> switch to skip the question.
                    EOT
            )
            ->addOption('no-cache', null, InputOption::VALUE_NONE, 'Skip cache flushing')
        ;
    }

    public function isEnabled(): bool
    {
        return $this->kernelEnvironment !== 'prod';
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /* Test other database connections by making the TEST_GROUP env var available.
         * Continue with default connection if TEST_GROUP not defined.
         * */
        if ($_ENV['TEST_GROUP'] == 'database')
        {
            $this->createTestDatabase($input, $output, $io, 'pgsql');
            $this->runMigrations($input, $output, $io, 'pgsql');
            dump('Created and ran the migrations for pgsql');
        }
        
        $this->createTestDatabase($input, $output, $io, 'default');
        $this->runMigrations($input, $output, $io, 'default');
        dd('Created and ran the migrations for default');



        try {
            $this->loadData($input, $output);
        } catch (Exception $ex) {
            $io->error('Failed to import data: ' . $ex->getMessage());

            return Command::FAILURE;
        }

        if (!$input->getOption('no-cache')) {
            $command = $this->getApplication()->find('cache:clear');
            try {
                $command->run(new ArrayInput([]), $output);
            } catch (Exception $ex) {
                $io->error('Failed to clear cache: ' . $ex->getMessage());

                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }

    protected function dropSchema(SymfonyStyle $io, OutputInterface $output): int
    {
        try {
            $command = $this->getApplication()->find('doctrine:schema:drop');
            $command->run(new ArrayInput(['--force' => true]), $output);
        } catch (Exception $ex) {
            $io->error('Failed to drop database schema: ' . $ex->getMessage());

            return Command::FAILURE;
        }

        try {
            $command = $this->getApplication()->find('doctrine:query:sql');
            $command->run(new ArrayInput(['sql' => 'DROP TABLE IF EXISTS migration_versions']), $output);
        } catch (Exception $ex) {
            $io->error('Failed to drop migration_versions table: ' . $ex->getMessage());

            return Command::FAILURE;
        }

        try {
            $command = $this->getApplication()->find('doctrine:query:sql');
            $command->run(new ArrayInput(['sql' => 'DROP TABLE IF EXISTS kimai2_sessions']), $output);
        } catch (Exception $ex) {
            $io->error('Failed to drop kimai2_sessions table: ' . $ex->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function askConfirmation(InputInterface $input, OutputInterface $output, string $question): bool
    {
        if (!$input->isInteractive()) {
            return true;
        }

        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelperSet()->get('question');
        $question = new ConfirmationQuestion('<question>' . $question . '</question>', false);

        return $questionHelper->ask($input, $output, $question);
    }

    private function createTestDatabase(InputInterface $input, OutputInterface $output, SymfonyStyle $io, string $dbdriver): int
    {
        if ($this->askConfirmation($input, $output, 'Do you want to create the database for connection  ' . $dbdriver . ' y/N ?')) {
            try {
                $command = $this->getApplication()->find('doctrine:database:create');
                $options = ['--if-not-exists' => true, '--connection' => $dbdriver];
                $command->run(new ArrayInput($options), $output);

                return Command::SUCCESS;
            } catch (Exception $ex) {
                $io->error('Failed to create database using ' . $dbdriver . ' driver: ' . $ex->getMessage());

                return Command::FAILURE;
            }
        }
    }

    private function runMigrations(InputInterface $input, OutputInterface $output, SymfonyStyle $io, string $dbdriver): int 
    {
        if ($this->askConfirmation($input, $output, 'Do you want to drop and re-create the schema for connection ' . $dbdriver . ' y/N ?')) {
            if (($result = $this->dropSchema($io, $output)) !== Command::SUCCESS) {
                return $result;
            }

            try {
                $command = $this->getApplication()->find('doctrine:migrations:migrate');
                $cmdInput = new ArrayInput([]);
                $cmdInput->setInteractive(false);
                $command->run($cmdInput, $output);

                return Command::SUCCESS;
            } catch (Exception $ex) {
                $io->error('Failed to execute the migrations for connection ' . $dbdriver . $ex->getMessage());

                return Command::FAILURE;
            }
        }
    }

    abstract protected function loadData(InputInterface $input, OutputInterface $output): void;
}
