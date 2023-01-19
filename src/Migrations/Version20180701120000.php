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

final class Version20180701120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial database structure';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->createUsersTable($schema);
        $this->createUserPreferencesTable($schema);
        $this->createCustomersTable($schema);
        $this->createProjectsTable($schema);
        $this->createActivitiesTable($schema);
        $this->createTimesheetTable($schema);
        $this->createInvoiceTemplatesTable($schema);
        $this->createForeignKeyConstraints($schema);
    }
    
    public function down(Schema $schema): void
    {
        $schema->dropTable('kimai2_invoice_templates');
        $schema->dropTable('kimai2_timesheet');
        $schema->dropTable('kimai2_user_preferences');
        $schema->dropTable('kimai2_users');
        $schema->dropTable('kimai2_activities');
        $schema->dropTable('kimai2_projects');
        $schema->dropTable('kimai2_customers');
    }

    /* $this->addSql('CREATE TABLE kimai2_users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, mail VARCHAR(160) NOT NULL, password VARCHAR(254) DEFAULT NULL, alias VARCHAR(60) DEFAULT NULL, active TINYINT(1) NOT NULL, registration_date DATETIME DEFAULT NULL, title VARCHAR(50) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_B9AC5BCE5E237E06 (name), UNIQUE INDEX UNIQ_B9AC5BCE5126AC48 (mail), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'); */
    /**
     * @param Schema $schema
     */
    public function createUsersTable(Schema $schema): void
    {
        /* addColumn( column_name , column_type, [portable_options, common_options, vendor_specific_options] )*/
        $table = $schema->createTable("kimai2_users");
        $table->addColumn("id", "integer", ["autoincrement" => true]);
        $table->addColumn("name", "string", ["length" => 60]);
        $table->addColumn("mail", "string", ["length" => 160]);
        $table->addColumn("password", "string", ["length" => 254, "notnull" => false]);
        $table->addColumn("alias", "string", ["length" => 60, "notnull" => false]);
        $table->addColumn("active", "smallint"); #original=tinyint
        $table->addColumn("registration_date", "datetime", ["notnull" => false]);
        $table->addColumn("title", "string", ["length" => 60, "notnull" => false]);
        $table->addColumn("avatar", "string", ["length" => 255, "notnull" => false]);
        $table->addColumn("roles", "text", ["comment" => "(DC2Type:array)"]); #commonoption
        $table->addUniqueIndex(["name"], "UNIQ_B9AC5BCE5E237E06");
        $table->addUniqueIndex(["mail"], "UNIQ_B9AC5BCE5126AC48");
        $table->setPrimaryKey(["id"]);
    }

    /* $this->addSql('CREATE TABLE kimai2_user_preferences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(255) DEFAULT NULL, INDEX IDX_8D08F631A76ED395 (user_id), UNIQUE INDEX UNIQ_8D08F631A76ED3955E237E06 (user_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'); */
    /**
     * @param Schema $schema
     */
    public function createUserPreferencesTable(Schema $schema)
    {
        $table = $schema->createTable("kimai2_user_preferences");
        $table->addColumn("id", "integer", ["autoincrement" => true]);
        $table->addColumn("user_id", "integer", ["notnull" => false]);
        $table->addColumn("name", "string", ["length" => 50]);
        $table->addColumn("value", "string", ["length" => 255]);
        $table->addIndex(["user_id"], "IDX_8D08F631A76ED395");
        $table->addUniqueIndex(["user_id", "name"], "UNIQ_8D08F631A76ED3955E237E06");
        $table->setPrimaryKey(["id"]);
    }

    /* $this->addSql('CREATE TABLE kimai2_customers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, number VARCHAR(50) DEFAULT NULL, comment TEXT DEFAULT NULL, visible TINYINT(1) NOT NULL, company VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, address TEXT DEFAULT NULL, country VARCHAR(2) NOT NULL, currency VARCHAR(3) NOT NULL, phone VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, homepage VARCHAR(255) DEFAULT NULL, timezone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'); */
    /**
     * @param Schema $schema
     */
    public function createCustomersTable(Schema $schema) 
    {
        $table = $schema->createTable("kimai2_customers");
        $table->addColumn("id", "integer", ["autoincrement" => true]);
        $table->addColumn("name", "string", ["length" => 150]);
        $table->addColumn("number", "string", ["length" => 50, "notnull" => false]);
        $table->addColumn("comment", "text", ["notnull" => false]);
        $table->addColumn("visible", "smallint"); #original=tinyint
        $table->addColumn("company", "string", ["length" => 255, "notnull" => false]);
        $table->addColumn("contact", "string", ["length" => 255, "notnull" => false]);
        $table->addColumn("address", "text", ["notnull" => false]);
        $table->addColumn("country", "string", ["length" => 2]);
        $table->addColumn("currency", "string", ["length" => 3]);
        $table->addColumn("phone", "string", ["length" => 255, "notnull" => false]);
        $table->addColumn("fax", "string", ["length" => 255, "notnull" => false]);
        $table->addColumn("mobile", "string", ["length" => 255, "notnull" => false]);
        $table->addColumn("mail", "string", ["length" => 255, "notnull" => false]);
        $table->addColumn("homepage", "string", ["length" => 255, "notnull" => false]);
        $table->addColumn("timezone", "string", ["length" => 255]);
        $table->setPrimaryKey(["id"]);
        
    }

    /* $this->addSql('CREATE TABLE kimai2_projects (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, order_number TINYTEXT DEFAULT NULL, comment TEXT DEFAULT NULL, visible TINYINT(1) NOT NULL, budget NUMERIC(10, 2) NOT NULL, INDEX IDX_407F12069395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'); */
    /**
     * @param Schema $schema
     */
    public function createProjectsTable(Schema $schema)
    {
        $table = $schema->createTable("kimai2_projects");
        $table->addColumn("id", "integer", ["autoincrement" => true]);
        $table->addColumn("customer_id", "integer", ["notnull" => false]);
        $table->addColumn("name", "string", ["length" => 150]);
        $table->addColumn("order_number", "text", ["notnull" => false]); // will map to tinytext https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/types.html#mapping-matrix
        $table->addColumn("comment", "text", ["notnull" => false]);
        $table->addColumn("visible", "smallint"); // original=tinyint
        $table->addColumn("budget", "decimal", ["precision" => 10, "scale" => 2]); // decimal is saved as string in php
        $table->addIndex(["customer_id"], "IDX_407F12069395C3F3");
        $table->setPrimaryKey(["id"]);
    }

    /* $this->addSql('CREATE TABLE kimai2_activities (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, comment TEXT DEFAULT NULL, visible TINYINT(1) NOT NULL, INDEX IDX_8811FE1C166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'); */
    /**
     * @param Schema $schema
     */
    public function createActivitiesTable(Schema $schema)
    {
        $table = $schema->createTable("kimai2_activities");
        $table->addColumn("id", "integer", ["autoincrement" => true]);
        $table->addColumn("project_id", "integer", ["notnull" => false]);
        $table->addColumn("name", "string", ["length" => 150]);
        $table->addColumn("comment", "text", ["notnull" => false]);
        $table->addColumn("visible", "smallint"); // original=tinyint
        $table->addIndex(["project_id"], "IDX_8811FE1C166D1F9C");
        $table->setPrimaryKey(["id"]);
    }

    /* $this->addSql('CREATE TABLE kimai2_timesheet (id INT AUTO_INCREMENT NOT NULL, user INT DEFAULT NULL, activity_id INT DEFAULT NULL, start_time DATETIME NOT NULL, end_time DATETIME DEFAULT NULL, duration INT DEFAULT NULL, description TEXT DEFAULT NULL, rate NUMERIC(10, 2) NOT NULL, INDEX IDX_4F60C6B18D93D649 (user), INDEX IDX_4F60C6B181C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'); */
    /**
     * @param Schema $schema
     */
    public function createTimesheetTable($schema)
    {
        $table = $schema->createTable("kimai2_timesheet");
        $table->addColumn("id", "integer", ["autoincrement" => true]);
        $table->addColumn("user", "integer", ["notnull" => false]);
        $table->addColumn("activity_id", "integer", ["notnull" => false]);
        $table->addColumn("start_time", "datetime");
        $table->addColumn("end_time", "datetime", ["notnull" => false]);
        $table->addColumn("duration", "integer", ["notnull" => false]);
        $table->addColumn("description", "text", ["notnull" => false]);
        $table->addColumn("rate", "decimal", ["precision" => 10, "scale" => 2]);
        $table->addIndex(["user"], "IDX_4F60C6B18D93D649");
        $table->addIndex(["activity_id"], "IDX_4F60C6B181C06096");
        $table->setPrimaryKey(["id"]);
    }

    /* $this->addSql('CREATE TABLE kimai2_invoice_templates (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, title VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, address TEXT DEFAULT NULL, due_days INT NOT NULL, vat INT DEFAULT NULL, calculator VARCHAR(20) NOT NULL, number_generator VARCHAR(20) NOT NULL, renderer VARCHAR(20) NOT NULL, payment_terms TEXT DEFAULT NULL, UNIQUE INDEX UNIQ_1626CFE95E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'); */
    /**
     * @param Schema $schema
     */
    public function createInvoiceTemplatesTable($schema)
    {
        $table = $schema->createTable("kimai2_invoice_templates");
        $table->addColumn("id", "integer", ["autoincrement" => true]);
        $table->addColumn("name", "string", ["length" => 60]);
        $table->addColumn("title", "string", ["length" => 255]);
        $table->addColumn("company", "string", ["length" => 255]);
        $table->addColumn("address", "text", ["notnull" => false]);
        $table->addColumn("due_days", "integer");
        $table->addColumn("vat", "integer", ["notnull" => false]);
        $table->addColumn("calculator", "string", ["length" => 20]);
        $table->addColumn("number_generator", "string", ["length" => 20]);
        $table->addColumn("renderer", "string", ["length" => 20]);
        $table->addColumn("payment_terms", "text", ["notnull" => false]);
        $table->addUniqueIndex(["name"], "UNIQ_1626CFE95E237E06");
        $table->setPrimaryKey(["id"]);
    }
    
    /* 
       $this->addSql('ALTER TABLE kimai2_user_preferences ADD CONSTRAINT FK_8D08F631A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE');
       $this->addSql('ALTER TABLE kimai2_projects ADD CONSTRAINT FK_407F12069395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE');
       $this->addSql('ALTER TABLE kimai2_activities ADD CONSTRAINT FK_8811FE1C166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE');
       $this->addSql('ALTER TABLE kimai2_timesheet ADD CONSTRAINT FK_4F60C6B18D93D649 FOREIGN KEY (user) REFERENCES kimai2_users (id)');
       $this->addSql('ALTER TABLE kimai2_timesheet ADD CONSTRAINT FK_4F60C6B181C06096 FOREIGN KEY (activity_id) REFERENCES kimai2_activities (id) ON DELETE CASCADE');
     */
    /**
     * @param Schema $schema
     */
    public function createForeignKeyConstraints(Schema $schema)
    {
        $userPreferencesTable = $schema->getTable("kimai2_user_preferences");
        $usersTable = $schema->getTable("kimai2_users");
        $projectsTable = $schema->getTable("kimai2_projects");
        $customersTable = $schema->getTable("kimai2_customers");
        $activitiesTable = $schema->getTable("kimai2_activities");
        $timesheetTable = $schema->getTable("kimai2_timesheet");

        $userPreferencesTable->addForeignKeyConstraint($usersTable, ["user_id"], ["id"], ["onDelete" => "CASCADE"], "FK_8D08F631A76ED395");
        $projectsTable->addForeignKeyConstraint($usersTable, ["customer_id"], ["id"], ["onDelete" => "CASCADE"], "FK_407F12069395C3F3");
        $activitiesTable->addForeignKeyConstraint($usersTable, ["project_id"], ["id"], ["onDelete" => "CASCADE"], "FK_8811FE11C166D1F9C");
        $timesheetTable->addForeignKeyConstraint($usersTable, ["user"], ["id"], [], "FK_4F60C6B18D93D649");
        $timesheetTable->addForeignKeyConstraint($usersTable, ["activity_id"], ["id"], ["onDelete" => "CASCADE"], "FK_4F60C6B181C06096");
    }

}
