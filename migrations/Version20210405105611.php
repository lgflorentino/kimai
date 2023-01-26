<?php

declare(strict_types=1);

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use App\Doctrine\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Increase the configuration table column length
 *
 * @version 1.14
 */
final class Version20210405105611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Increase the configuration table column length';
    }

    public function up(Schema $schema): void
    {
        if ($this->isPlatformMySQL()) {
            $invoices = $schema->getTable('kimai2_configuration');
            $invoices->getColumn('value')->setLength(1024);
        } else {
            $this->preventEmptyMigrationWarning();
        }
    }

    public function down(Schema $schema): void
    {
        if ($this->isPlatformMySQL()) {
            $invoices = $schema->getTable('kimai2_configuration');
            $invoices->getColumn('value')->setLength(255);
        } else {
            $this->preventEmptyMigrationWarning();
        }
    }
}
