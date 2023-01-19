<?php

declare(strict_types=1)

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use App\Doctrine\AbstractMigration;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration for FOSUserBundle
 *
 * Changes the table structure of "users" table and migrates from json_array type to serialized array,
 * probably also fixing the higher required MariaDB version.
 *
 * This was fixed in earlier migrations for new installations, but it is still in here for users migrating up from a lower version.
 */
final class Version20180715160326 extends AbstractMigration
{
    /**
     * @var Index[]
     */
    protected $indexesOld = [];

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema): void
    {
        // delete all existing indexes
        $usersTable = $schema->getTable("kimai2_users");
        $indexesOld = $usersTable->getIndexes();
        foreach ($indexesOld as $index) {
            if (\in_array('name', $index->getColumns()) || \in_array('mail', $index->getColumns())) {
                $this->indexesOld[] = $index;
                $usersTable->dropIndex($index->getName());
            }
        }

        /* 
         $this->addSql('ALTER TABLE kimai2_users CHANGE name username VARCHAR(180) NOT NULL, ADD username_canonical VARCHAR(180) NOT NULL, CHANGE mail email VARCHAR(180) NOT NULL, ADD email_canonical VARCHAR(180) NOT NULL, ADD salt VARCHAR(255) DEFAULT NULL, ADD last_login DATETIME DEFAULT NULL, ADD confirmation_token VARCHAR(180) DEFAULT NULL, ADD password_requested_at DATETIME DEFAULT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE alias alias VARCHAR(60) DEFAULT NULL, CHANGE registration_date registration_date DATETIME DEFAULT NULL, CHANGE title title VARCHAR(50) DEFAULT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE active enabled TINYINT(1) NOT NULL'); 
        */
        $usersTable->changeColumn("name", ["name" => "username", "type" => "string", "length" => 180]);
        $usersTable->addColumn("username_canonical", "string", ["length" => 180]);
        $usersTable->changeColumn("mail", ["name" => "email", "type" => "string", "length" => 180]);
        $usersTable->addColumn("email_canonical", "string", ["length" => 180]);
        $usersTable->addColumn("salt", "string", ["length" => 255, "notnull" => false]);
        $usersTable->addColumn("last_login", "datetime", ["notnull" => false]);
        $usersTable->addColumn("confirmation_token", "string", ["length" => 180, "notnull" => false]);
        $usersTable->addColumn("password_requested_at", "datetime", ["notnull" => false]);
        $usersTable->changeColumn("password", ["name" => "password", "type" => "string", "length" => 255]);
        $usersTable->changeColumn("alias", ["name" => "alias", "type" => "string", "length" => 60, "notnull" => false]);
        $usersTable->changeColumn("registration_date", ["registration_date" => "email", "type" => "datetime", "notnull" => false]);
        $usersTable->changeColumn("title", ["name" => "title", "type" => "string", "length" => 50, "notnull" => false]);
        $usersTable->changeColumn("avatar", ["name" => "avatar", "type" => "string", "length" => 255, "notnull" => false]);
        $usersTable->changeColumn("roles", ["name" => "roles", "type" => "text", "comment" => "(DC2Type:array)"]);
        $usersTable->changeColumn("active", ["name" => "enabled", "type" => "smallint", "notnull" => false]); // original=tinyint
        dd();

        $this->addSql('UPDATE kimai2_users set username_canonical = username');
        $this->addSql('UPDATE kimai2_users set email_canonical = email');

        $this->addSql('UPDATE kimai2_users SET roles = \'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}\' WHERE roles LIKE \'%ROLE_SUPER_ADMIN%\'');
        $this->addSql('UPDATE kimai2_users SET roles = \'a:1:{i:0;s:10:"ROLE_ADMIN";}\' WHERE roles LIKE \'%ROLE_ADMIN%\'');
        $this->addSql('UPDATE kimai2_users SET roles = \'a:1:{i:0;s:13:"ROLE_TEAMLEAD";}\' WHERE roles LIKE \'%ROLE_TEAMLEAD%\'');
        $this->addSql('UPDATE kimai2_users SET roles = \'a:0:{}\' WHERE roles LIKE \'%ROLE_USER%\'');
        $this->addSql('UPDATE kimai2_users SET roles = \'a:1:{i:0;s:13:"ROLE_CUSTOMER";}\' WHERE roles LIKE \'%ROLE_CUSTOMER%\'');

        // $this->addSql('CREATE UNIQUE INDEX UNIQ_B9AC5BCE92FC23A8 ON kimai2_users (username_canonical)');
        $usersTable->addUniqueIndex(["username_canonical"], "UNIQ_B9AC5BCE92FC23A8");
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_B9AC5BCEA0D96FBF ON kimai2_users (email_canonical)');
        $usersTable->addUniqueIndex(["email_canonical"], "UNIQ_B9AC5BCEA0D96FBF");
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_B9AC5BCEC05FB297 ON kimai2_users (confirmation_token)');
        $usersTable->addUniqueIndex(["confirmation_token"], "UNIQ_B9AC5BCEC05FB297");
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_B9AC5BCEF85E0677 ON kimai2_users (username)');
        $usersTable->addUniqueIndex(["username"], "UNIQ_B9AC5BCEF85E0677");
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_B9AC5BCEE7927C74 ON kimai2_users (email)');
        $usersTable->addUniqueIndex(["email"], "UNIQ_B9AC5BCEE7927C74");
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function down(Schema $schema): void
    {
        $indexToDelete = ['UNIQ_B9AC5BCE92FC23A8', 'UNIQ_B9AC5BCEA0D96FBF', 'UNIQ_B9AC5BCEC05FB297', 'UNIQ_B9AC5BCEF85E0677', 'UNIQ_B9AC5BCEE7927C74'];
        foreach ($indexToDelete as $indexName) {
            $schema->getTable("kimai2_users")->dropIndex($indexName);
        }

        $this->addSql('ALTER TABLE kimai2_users CHANGE username name VARCHAR(60) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE email mail VARCHAR(160) NOT NULL COLLATE utf8mb4_unicode_ci, DROP username_canonical, DROP email_canonical, DROP salt, DROP last_login, DROP confirmation_token, DROP password_requested_at, CHANGE password password VARCHAR(254) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE alias alias VARCHAR(60) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE registration_date registration_date DATETIME DEFAULT NULL, CHANGE title title VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE enabled active TINYINT(1) NOT NULL');

        $this->addSql('UPDATE kimai2_users SET roles = \'["ROLE_SUPER_ADMIN"]\' WHERE roles LIKE \'%ROLE_SUPER_ADMIN%\'');
        $this->addSql('UPDATE kimai2_users SET roles = \'["ROLE_ADMIN"]\' WHERE roles LIKE \'%ROLE_ADMIN%\'');
        $this->addSql('UPDATE kimai2_users SET roles = \'["ROLE_TEAMLEAD"]\' WHERE roles LIKE \'%ROLE_TEAMLEAD%\'');
        $this->addSql('UPDATE kimai2_users SET roles = \'["ROLE_USER"]\' WHERE roles LIKE \'%ROLE_USER%\'');
        $this->addSql('UPDATE kimai2_users SET roles = \'["ROLE_CUSTOMER"]\' WHERE roles LIKE \'%ROLE_CUSTOMER%\'');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_B9AC5BCE5E237E06 ON kimai2_users (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B9AC5BCE5126AC48 ON kimai2_users (mail)');

        $usersTable = $schema->getTable('kimai2_users');
        foreach ($this->indexesOld as $index) {
            $usersTable->addIndex($index->getColumns(), $index->getName(), $index->getFlags(), $index->getOptions());
        }
    }
}
