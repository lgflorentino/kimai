<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Doctrine;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration as BaseAbstractMigration;

/**
 * Base class for all Doctrine migrations.
 *
 * @codeCoverageIgnore
 */
abstract class AbstractMigration extends BaseAbstractMigration
{
    /**
     * @see https://github.com/doctrine/migrations/issues/1104
     */
    public function isTransactional(): bool
    {
        return false;
    }

    /**
     * @param Schema $schema
     * @throws Exception
     */
    public function preUp(Schema $schema): void
    {
        $this->abortIfPlatformNotSupported();
    }

    /**
     * @param Schema $schema
     * @throws Exception
     */
    public function preDown(Schema $schema): void
    {
        $this->abortIfPlatformNotSupported();
    }

    /**
     * Abort the migration is the current platform is not supported.
     *
     * @throws Exception
     */
    protected function abortIfPlatformNotSupported()
    {
        $platform = $this->connection->getDatabasePlatform();
        if (!($platform instanceof MySQLPlatform) &&
            !($platform instanceof PostgreSQLPlatform)) {
            $this->abortIf(true, 'Unsupported database platform: ' . \get_class($platform));
        }
    }

    protected function isPlatformMySQL(): bool
    {
        $platform = $this->connection->getDatabasePlatform();

        return $platform instanceof MySQLPlatform;
    }

    protected function isPlatformPostgreSQL(): bool
    {
        $platform = $this->connection->getDatabasePlatform();

        return $platform instanceof MySQLPlatform;
    }

    protected function preventEmptyMigrationWarning(): void
    {
        if ($this->isPlatformMySQL()) {
            $this->addSql('#prevent empty warning - no SQL to execute');
        } elseif ($this->isPlatformPostgreSQL()) {
            $this->addSql('-- prevent empty warning - no SQL to execute');
        }
    }
}
