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
 * Update invoice with payment date
 *
 * @version 1.14
 */
final class Version20210320162820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update invoice with payment date';
    }

    public function up(Schema $schema): void
    {
        if ($this->isPlatformMySQL()) {
            $invoices = $schema->getTable('kimai2_invoices');
            $invoices->addColumn('payment_date', 'date', ['default' => null, 'notnull' => false]);
        } else {
            $this->preventEmptyMigrationWarning();
        }
    }

    public function down(Schema $schema): void
    {
        if ($this->isPlatformMySQL()) {
            $invoices = $schema->getTable('kimai2_invoices');
            $invoices->dropColumn('payment_date');
        } else {
            $this->preventEmptyMigrationWarning();
        }
    }
}
