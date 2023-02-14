<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use App\Doctrine\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131123812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'PostgreSQL support starts from this migration';
    }

    public function up(Schema $schema): void
    {
        if (!$this->isPlatformMySQL())
        {
            $this->createActivitiesTable($schema);
            $this->createActivitiesMetaTable($schema);
            $this->createActivitiesRatesTable($schema);
            $this->createActivitiesTeamsTable($schema);
            $this->createBookmarksTable($schema);
            $this->createConfigurationTable($schema);
            $this->createCustomersTable($schema);
            $this->createCustomersCommentsTable($schema);
            $this->createCustomersMetaTable($schema);
            $this->createCustomersRatesTable($schema);
            $this->createCustomersTeamsTable($schema);
            $this->createInvoiceTemplatesTable($schema);
            $this->createInvoicesTable($schema);
            $this->createInvoicesMetaTable($schema);
            $this->createProjectsTable($schema);
            $this->createProjectsCommentsTable($schema);
            $this->createProjectsMetaTable($schema);
            $this->createProjectsRatesTable($schema);
            $this->createProjectsTeamsTable($schema);
            $this->createRolesTable($schema);
            $this->createRolesPermissionsTable($schema);
            $this->createSessionsTable($schema);
            $this->createTagsTable($schema);
            $this->createTeamsTable($schema);
            $this->createTimesheetTable($schema);
            $this->createTimesheetMetaTable($schema);
            $this->createTimesheetTagsTable($schema);
            $this->createUserPreferencesTable($schema);
            $this->createUsersTable($schema);
            $this->createUsersTeamsTable($schema);
            // $this->createMigrationVersionsTable($schema);
            $this->createForeignKeyConstraints($schema);
        }

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('kimai2_activities');
        $schema->dropTable('kimai2_activities_meta');
        $schema->dropTable('kimai2_activities_rates');
        $schema->dropTable('kimai2_activities_teams');
        $schema->dropTable('kimai2_bookmarks');
        $schema->dropTable('kimai2_configuration');
        $schema->dropTable('kimai2_customers');
        $schema->dropTable('kimai2_customers_comments');
        $schema->dropTable('kimai2_customers_meta');
        $schema->dropTable('kimai2_customers_rates');
        $schema->dropTable('kimai2_customers_teams');
        $schema->dropTable('kimai2_invoice_templates');
        $schema->dropTable('kimai2_invoices');
        $schema->dropTable('kimai2_invoices_meta');
        $schema->dropTable('kimai2_projects');
        $schema->dropTable('kimai2_projects_comments');
        $schema->dropTable('kimai2_projects_meta');
        $schema->dropTable('kimai2_projects_rates');
        $schema->dropTable('kimai2_projects_teams');
        $schema->dropTable('kimai2_roles');
        $schema->dropTable('kimai2_roles_permissions');
        $schema->dropTable('kimai2_sessions');
        $schema->dropTable('kimai2_tags');
        $schema->dropTable('kimai2_teams');
        $schema->dropTable('kimai2_timesheet');
        $schema->dropTable('kimai2_timesheet_meta');
        $schema->dropTable('kimai2_timesheet_tags');
        $schema->dropTable('kimai2_user_preferences');
        $schema->dropTable('kimai2_users');
        $schema->dropTable('kimai2_users_teams');
        $schema->dropTable('migration_versions');

    }
    
    public function isTransactional(): bool
    {
        return false;
    }
    
    /* 
    CREATE TABLE kimai2_activities (
        id INT AUTO_INCREMENT NOT NULL, 
        project_id INT DEFAULT NULL, 
        name VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
        comment TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        visible TINYINT(1) NOT NULL, 
        color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        time_budget INT DEFAULT 0 NOT NULL, 
        budget DOUBLE PRECISION DEFAULT '0' NOT NULL, 
        budget_type VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        billable TINYINT(1) DEFAULT 1 NOT NULL, 
        invoice_text LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        INDEX IDX_8811FE1C7AB0E8595E237E06 (visible, name), 
        INDEX IDX_8811FE1C166D1F9C (project_id), 
        INDEX IDX_8811FE1C7AB0E859166D1F9C5E237E06 (visible, project_id, name), 
        INDEX IDX_8811FE1C7AB0E859166D1F9C (visible, project_id), 
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createActivitiesTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_activities');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('project_id', 'integer', ['notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 150]);
        $table->addColumn('comment', 'text', ['notnull' => false]);
        $table->addColumn('visible', 'boolean'); // original=tinyint
        $table->addColumn('color', 'string', ['length' => 7, 'notnull' => false]);
        $table->addColumn('time_budget', 'integer', ['default' => 0]);
        $table->addColumn('budget', 'float', ['default' => 0]);
        $table->addColumn('budget_type', 'string', ['length' => 10, 'notnull' => false]);
        $table->addColumn('billable', 'boolean', ['default' => true]); // original=tinyint,default=1
        $table->addColumn('invoice_text', 'text', ['notnull' => false]);
        $table->addIndex(['visible', 'name'], 'IDX_8811FE1C7AB0E8595E237E06'); 
        $table->addIndex(['project_id'], 'IDX_8811FE1C166D1F9C');
        $table->addIndex(['visible', 'project_id', 'name'], 'IDX_8811FE1C7AB0E859166D1F9C5E237E06'); 
        $table->addIndex(['visible', 'project_id'], 'IDX_8811FE1C7AB0E859166D1F9C') ;
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_activities_meta (
            id INT AUTO_INCREMENT NOT NULL, 
            activity_id INT NOT NULL, 
            name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            visible TINYINT(1) DEFAULT 0 NOT NULL, 
            UNIQUE INDEX UNIQ_A7C0A43D81C060965E237E06 (activity_id, name), 
            INDEX IDX_A7C0A43D81C06096 (activity_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createActivitiesMetaTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_activities_meta');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('activity_id', 'integer');
        $table->addColumn('name', 'string', ['length' => 50]);
        $table->addColumn('value', 'text', ['notnull' => false]);
        $table->addColumn('visible', 'boolean', ['default' => 0]); // original=tinyint,default=0
        $table->addUniqueIndex(['activity_id', 'name'], 'UNIQ_A7C0A43D81C060965E237E06');
        $table->addIndex(['activity_id'], 'IDX_A7C0A43D81C06096');
        $table->setPrimaryKey(['id']);
    }
    
    /*
        CREATE TABLE kimai2_activities_rates (
            id INT AUTO_INCREMENT NOT NULL, 
            user_id INT DEFAULT NULL, 
            activity_id INT DEFAULT NULL, 
            rate DOUBLE PRECISION NOT NULL, 
            fixed TINYINT(1) NOT NULL, 
            internal_rate DOUBLE PRECISION DEFAULT NULL, 
            INDEX IDX_4A7F11BE81C06096 (activity_id), 
            INDEX IDX_4A7F11BEA76ED395 (user_id), 
            UNIQUE INDEX UNIQ_4A7F11BEA76ED39581C06096 (user_id, activity_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createActivitiesRatesTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_activities_rates');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer', ['notnull' => false]);
        $table->addColumn('activity_id', 'integer', ['notnull' => false]);
        $table->addColumn('rate', 'float');
        $table->addColumn('fixed', 'boolean'); // original=tinyint
        $table->addColumn('internal_rate', 'float', ['notnull' => false]);
        $table->addIndex(['activity_id'], 'IDX_4A7F11BE81C06096'); 
        $table->addIndex(['user_id'], 'IDX_4A7F11BEA76ED395'); 
        $table->addUniqueIndex(['user_id', 'activity_id'], 'UNIQ_4A7F11BEA76ED39581C06096');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_activities_teams (
            activity_id INT NOT NULL, 
            team_id INT NOT NULL, 
            INDEX IDX_986998DA296CD8AE (team_id), 
            INDEX IDX_986998DA81C06096 (activity_id), 
            PRIMARY KEY(activity_id, team_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createActivitiesTeamsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_activities_teams');
        $table->addColumn('activity_id', 'integer');
        $table->addColumn('team_id', 'integer');
        $table->addIndex(['team_id'], 'IDX_986998DA296CD8AE');
        $table->addIndex(['activity_id'], 'IDX_986998DA81C06096');
        $table->setPrimaryKey(['activity_id', 'team_id']);
    }
    
    /*
        CREATE TABLE kimai2_bookmarks (
            id INT AUTO_INCREMENT NOT NULL, 
            user_id INT NOT NULL, 
            type VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            INDEX IDX_4016EF25A76ED395 (user_id), 
            UNIQUE INDEX UNIQ_4016EF25A76ED3955E237E06 (user_id, name), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    public function createBookmarksTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_bookmarks');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer');
        $table->addColumn('type', 'string', ['length' => 20]);
        $table->addColumn('name', 'string', ['length' => 50]);
        $table->addIndex(['user_id'], 'IDX_4016EF25A76ED395'); 
        $table->addUniqueIndex(['user_id', 'name'], 'UNIQ_4016EF25A76ED3955E237E06');
        $table->setPrimaryKey(['id']);
    }

    /*   
        CREATE TABLE kimai2_configuration (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            UNIQUE INDEX UNIQ_1C5D63D85E237E06 (name), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
    */
    public function createConfigurationTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_configuration');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 100]);
        $table->addColumn('value', 'text', ['notnull' => false]);
        $table->addUniqueIndex(['name'], 'UNIQ_1C5D63D85E237E06'); 
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_customers (
            id INT AUTO_INCREMENT NOT NULL, 
            invoice_template_id INT DEFAULT NULL, 
            name VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            number VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            comment TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            visible TINYINT(1) NOT NULL, 
            company VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            contact VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            address TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            country VARCHAR(2) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            currency VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            phone VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            fax VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            mobile VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            email VARCHAR(75) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            homepage VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            timezone VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            time_budget INT DEFAULT 0 NOT NULL, 
            budget DOUBLE PRECISION DEFAULT '0' NOT NULL, 
            vat_id VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            budget_type VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            billable TINYINT(1) DEFAULT 1 NOT NULL, 
            invoice_text LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            INDEX IDX_5A97604412946D8B (invoice_template_id), 
            INDEX IDX_5A9760447AB0E859 (visible), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createCustomersTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_customers');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('invoice_template_id', 'integer', ['notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 150]);
        $table->addColumn('number', 'string', ['length' => 50, 'notnull' => false]);
        $table->addColumn('comment', 'text', ['notnull' => false]);
        $table->addColumn('visible', 'boolean'); //original=tinyint
        $table->addColumn('company', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('contact', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('address', 'text', ['notnull' => false]);
        $table->addColumn('country', 'string', ['length' => 2]);
        $table->addColumn('currency', 'string', ['length' => 3]);
        $table->addColumn('phone', 'string', ['length' => 30, 'notnull' => false]);
        $table->addColumn('fax', 'string', ['length' => 30, 'notnull' => false]);
        $table->addColumn('mobile', 'string', ['length' => 30, 'notnull' => false]);
        $table->addColumn('email', 'string', ['length' => 75, 'notnull' => false]);
        $table->addColumn('homepage', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('timezone', 'string', ['length' => 64]);
        $table->addColumn('color', 'string', ['length' => 7, 'notnull' => false]);
        $table->addColumn('time_budget', 'integer', ['default' => 0]);
        $table->addColumn('budget', 'float', ['default' => 0]);
        $table->addColumn('vat_id', 'string', ['length' => 50, 'notnull' => false]);
        $table->addColumn('budget_type', 'string', ['length' => 10, 'notnull' => false]);
        $table->addColumn('billable', 'boolean', ['default' => true]); //original=tinyint,default=1
        $table->addColumn('invoice_text', 'text', ['notnull' => false]);
        $table->addIndex(['invoice_template_id'], 'IDX_5A97604412946D8B');
        $table->addIndex(['visible'], 'IDX_5A9760447AB0E859'); 
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_customers_comments (
            id INT AUTO_INCREMENT NOT NULL, 
            customer_id INT NOT NULL, 
            created_by_id INT NOT NULL, 
            message LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime)', 
            pinned TINYINT(1) DEFAULT 0 NOT NULL, 
            INDEX IDX_A5B142D99395C3F3 (customer_id), 
            INDEX IDX_A5B142D9B03A8386 (created_by_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createCustomersCommentsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_customers_comments');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('customer_id', 'integer');
        $table->addColumn('created_by_id', 'integer');
        $table->addColumn('message', 'text');
        $table->addColumn('created_at', 'datetime');
        $table->addColumn('pinned', 'boolean', ['default' => false]); //original=tinyint,default=0
        $table->addIndex(['customer_id'], 'IDX_A5B142D99395C3F3');
        $table->addIndex(['created_by_id'], 'IDX_A5B142D9B03A8386'); 
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_customers_meta (
            id INT AUTO_INCREMENT NOT NULL, 
            customer_id INT NOT NULL, 
            name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            visible TINYINT(1) DEFAULT 0 NOT NULL, 
            UNIQUE INDEX UNIQ_A48A760F9395C3F35E237E06 (customer_id, name), 
            INDEX IDX_A48A760F9395C3F3 (customer_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createCustomersMetaTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_customers_meta');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('customer_id', 'integer');
        $table->addColumn('name', 'string', ['length' => 50]);
        $table->addColumn('value', 'text', ['notnull' => false]);
        $table->addColumn('visible', 'boolean', ['default' => false]); // original=tinyint,default=0
        $table->addUniqueIndex(['customer_id', 'name'], 'UNIQ_A48A760F9395C3F35E237E06'); 
        $table->addIndex(['customer_id'], 'IDX_A48A760F9395C3F3'); 
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_customers_rates (
            id INT AUTO_INCREMENT NOT NULL, 
            user_id INT DEFAULT NULL, 
            customer_id INT DEFAULT NULL, 
            rate DOUBLE PRECISION NOT NULL, 
            fixed TINYINT(1) NOT NULL, 
            internal_rate DOUBLE PRECISION DEFAULT NULL, 
            INDEX IDX_82AB0AEC9395C3F3 (customer_id), 
            UNIQUE INDEX UNIQ_82AB0AECA76ED3959395C3F3 (user_id, customer_id), 
            INDEX IDX_82AB0AECA76ED395 (user_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createCustomersRatesTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_customers_rates');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer', ['notnull' => false]);
        $table->addColumn('customer_id', 'integer', ['notnull' => false]);
        $table->addColumn('rate', 'float');
        $table->addColumn('fixed', 'boolean'); // original=tinyint
        $table->addColumn('internal_rate', 'float', ['notnull' => false]);
        $table->addIndex(['customer_id'], 'IDX_82AB0AEC9395C3F3'); 
        $table->addUniqueIndex(['user_id', 'customer_id'], 'UNIQ_82AB0AECA76ED3959395C3F3'); 
        $table->addIndex(['user_id'], 'IDX_82AB0AECA76ED395'); 
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_customers_teams (
            customer_id INT NOT NULL, 
            team_id INT NOT NULL, 
            INDEX IDX_50BD8388296CD8AE (team_id), 
            INDEX IDX_50BD83889395C3F3 (customer_id), 
            PRIMARY KEY(customer_id, team_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createCustomersTeamsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_customers_teams');
        $table->addColumn('customer_id', 'integer');
        $table->addColumn('team_id', 'integer');
        $table->addIndex(['team_id'], 'IDX_50BD8388296CD8AE'); 
        $table->addIndex(['customer_id'], 'IDX_50BD83889395C3F3');
        $table->setPrimaryKey(['customer_id', 'team_id']);
    }
    
    /*
        CREATE TABLE kimai2_invoice_templates (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            company VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            address TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            due_days INT NOT NULL, 
            vat DOUBLE PRECISION DEFAULT '0', 
            calculator VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            number_generator VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            renderer VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            payment_terms TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            vat_id VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            contact LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            payment_details LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            decimal_duration TINYINT(1) DEFAULT 0 NOT NULL, 
            language VARCHAR(6) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            UNIQUE INDEX UNIQ_1626CFE95E237E06 (name), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createInvoiceTemplatesTable($schema)
    {
        $table = $schema->createTable('kimai2_invoice_templates');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 60]);
        $table->addColumn('title', 'string', ['length' => 255]);
        $table->addColumn('company', 'string', ['length' => 255]);
        $table->addColumn('address', 'text', ['notnull' => false]);
        $table->addColumn('due_days', 'integer');
        $table->addColumn('vat', 'float', ['default' => 0]);
        $table->addColumn('calculator', 'string', ['length' => 20]);
        $table->addColumn('number_generator', 'string', ['length' => 20]);
        $table->addColumn('renderer', 'string', ['length' => 20]);
        $table->addColumn('payment_terms', 'text', ['notnull' => false]);
        $table->addColumn('vat_id', 'string', ['length' => 50, 'notnull' => false]);
        $table->addColumn('contact', 'text', ['notnull' => false]);
        $table->addColumn('payment_details', 'text', ['notnull' => false]);
        $table->addColumn('decimal_duration', 'boolean', ['default' => false]); // original=tinyint,default=0
        $table->addColumn('language', 'string', ['length' => 20, 'notnull' => false]);
        $table->addUniqueIndex(['name'], 'UNIQ_1626CFE95E237E06'); 
        $table->setPrimaryKey(['id']);
    }
    
/*
    CREATE TABLE kimai2_invoices (
        id INT AUTO_INCREMENT NOT NULL, 
        customer_id INT NOT NULL, 
        user_id INT NOT NULL, 
        invoice_number VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
        created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime)', 
        timezone VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
        total DOUBLE PRECISION NOT NULL, 
        tax DOUBLE PRECISION NOT NULL, 
        currency VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
        status VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
        due_days INT NOT NULL, 
        vat DOUBLE PRECISION NOT NULL, 
        invoice_filename VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
        payment_date DATE DEFAULT NULL, 
        comment LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        UNIQUE INDEX UNIQ_76C38E372DA68207 (invoice_number), 
        INDEX IDX_76C38E37A76ED395 (user_id), 
        UNIQUE INDEX UNIQ_76C38E372323B33D (invoice_filename), 
        INDEX IDX_76C38E379395C3F3 (customer_id), 
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createInvoicesTable($schema)
    {
        $table = $schema->createTable('kimai2_invoices');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('customer_id', 'integer');
        $table->addColumn('user_id', 'integer');
        $table->addColumn('invoice_number', 'string', ['length' => 50]);
        $table->addColumn('created_at', 'datetime');
        $table->addColumn('timezone', 'string', ['length' => 64]);
        $table->addColumn('total', 'float', ['default' => 0]);
        $table->addColumn('tax', 'float', ['default' => 0]);
        $table->addColumn('currency', 'string', ['length' => 3]);
        $table->addColumn('status', 'string', ['length' => 20]);
        $table->addColumn('due_days', 'integer');
        $table->addColumn('vat', 'integer', ['notnull' => false]);
        $table->addColumn('invoice_filename', 'string', ['length' => 150]);
        $table->addColumn('payment_date', 'date', ['notnull' => false]);
        $table->addColumn('comment', 'text', ['notnull' => false]);
        $table->addUniqueIndex(['invoice_number'], 'UNIQ_76C38E372DA68207'); 
        $table->addIndex(['user_id'], 'IDX_76C38E37A76ED395'); 
        $table->addUniqueIndex(['invoice_filename'], 'UNIQ_76C38E372323B33D');
        $table->addIndex(['customer_id'], 'IDX_76C38E379395C3F3');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_invoices_meta (
            id INT AUTO_INCREMENT NOT NULL, 
            invoice_id INT NOT NULL, 
            name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            visible TINYINT(1) DEFAULT 0 NOT NULL, 
            UNIQUE INDEX UNIQ_7EDC37D92989F1FD5E237E06 (invoice_id, name), 
            INDEX IDX_7EDC37D92989F1FD (invoice_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
    */
    /**
     * @param Schema $schema
     */
    public function createInvoicesMetaTable($schema)
    {
        $table = $schema->createTable('kimai2_invoices_meta');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('invoice_id', 'integer');
        $table->addColumn('name', 'string', ['length' => 50]);
        $table->addColumn('value', 'text', ['notnull' => false]);
        $table->addColumn('visible', 'boolean', ['default' => false]); //original=tinyint,default=0
        $table->addUniqueIndex(['invoice_id', 'name'], 'UNIQ_7EDC37D92989F1FD5E237E06');
        $table->addIndex(['invoice_id'], 'IDX_7EDC37D92989F1FD'); 
        $table->setPrimaryKey(['id']);
    }

    /*
    CREATE TABLE kimai2_projects (
        id INT AUTO_INCREMENT NOT NULL, 
        customer_id INT NOT NULL, 
        name VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
        order_number TINYTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        comment TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        visible TINYINT(1) NOT NULL, 
        budget DOUBLE PRECISION DEFAULT '0' NOT NULL, 
        color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        time_budget INT DEFAULT 0 NOT NULL, 
        order_date DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
        start DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
        end DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
        timezone VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        budget_type VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        billable TINYINT(1) DEFAULT 1 NOT NULL, 
        invoice_text LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
        global_activities TINYINT(1) DEFAULT 1 NOT NULL, 
        INDEX IDX_407F12069395C3F37AB0E8595E237E06 (customer_id, visible, name), 
        INDEX IDX_407F12069395C3F37AB0E859BF396750 (customer_id, visible, id), 
        INDEX IDX_407F12069395C3F3 (customer_id), 
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createProjectsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_projects');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('customer_id', 'integer');
        $table->addColumn('name', 'string', ['length' => 150]);
        $table->addColumn('order_number', 'text', ['notnull' => false]); // will map to tinytext https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/types.html#mapping-matrix
        $table->addColumn('comment', 'text', ['notnull' => false]);
        $table->addColumn('visible', 'boolean'); // original=tinyint
        $table->addColumn('budget', 'float', ['default' => 0]);
        $table->addColumn('color', 'string', ['length' => 7, 'notnull' => false]);
        $table->addColumn('time_budget', 'integer', ['default' => 0]);
        $table->addColumn('order_date', 'datetime', ['notnull' => false]);
        $table->addColumn('start', 'datetime', ['notnull' => false]);
        $table->addColumn('end', 'datetime', ['notnull' => false]);
        $table->addColumn('timezone', 'string', ['length' => 64, 'notnull' => false]);
        $table->addColumn('budget_type', 'string', ['length' => 10, 'notnull' => false]);
        $table->addColumn('billable', 'boolean', ['default' => true]); //original=tinyint,default=1
        $table->addColumn('invoice_text', 'text', ['notnull' => false]);
        $table->addColumn('global_activities', 'boolean', ['default' => true]); //original=tinyint,default=1
        $table->addIndex(['customer_id', 'visible', 'name'], 'IDX_407F12069395C3F37AB0E8595E237E06');
        $table->addIndex(['customer_id', 'visible', 'id'], 'IDX_407F12069395C3F37AB0E859BF396750');
        $table->addIndex(['customer_id'], 'IDX_407F12069395C3F3');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_projects_comments (
            id INT AUTO_INCREMENT NOT NULL, 
            project_id INT NOT NULL, 
            created_by_id INT NOT NULL, 
            message LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime)', 
            pinned TINYINT(1) DEFAULT 0 NOT NULL, 
            INDEX IDX_29A23638B03A8386 (created_by_id), 
            INDEX IDX_29A23638166D1F9C (project_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createProjectsCommentsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_projects_comments');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('project_id', 'integer');
        $table->addColumn('created_by_id', 'integer');
        $table->addColumn('message', 'text');
        $table->addColumn('created_at', 'datetime');
        $table->addColumn('pinned', 'boolean', ['default' => false]); //original=tinyint,default=0
        $table->addIndex(['created_by_id'], 'IDX_29A23638B03A8386'); 
        $table->addIndex(['project_id'], 'IDX_29A23638166D1F9C');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_projects_meta (
            id INT AUTO_INCREMENT NOT NULL, 
            project_id INT NOT NULL, 
            name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            visible TINYINT(1) DEFAULT 0 NOT NULL, 
            UNIQUE INDEX UNIQ_50536EF2166D1F9C5E237E06 (project_id, name), 
            INDEX IDX_50536EF2166D1F9C (project_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createProjectsMetaTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_projects_meta');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('project_id', 'integer');
        $table->addColumn('name', 'string', ['length' => 50]);
        $table->addColumn('value', 'text', ['notnull' => false]);
        $table->addColumn('visible', 'boolean', ['default' => false]); //original=tinyint,default=0
        $table->addUniqueIndex(['project_id', 'name'], 'UNIQ_50536EF2166D1F9C5E237E06');
        $table->addIndex(['project_id'], 'IDX_50536EF2166D1F9C');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_projects_rates (
            id INT AUTO_INCREMENT NOT NULL, 
            user_id INT DEFAULT NULL, 
            project_id INT DEFAULT NULL, 
            rate DOUBLE PRECISION NOT NULL, 
            fixed TINYINT(1) NOT NULL, 
            internal_rate DOUBLE PRECISION DEFAULT NULL, 
            INDEX IDX_41535D55166D1F9C (project_id), 
            UNIQUE INDEX UNIQ_41535D55A76ED395166D1F9C (user_id, project_id), 
            INDEX IDX_41535D55A76ED395 (user_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createProjectsRatesTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_projects_rates');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer', ['notnull' => false]);
        $table->addColumn('project_id', 'integer', ['notnull' => false]);
        $table->addColumn('rate', 'float');
        $table->addColumn('fixed', 'boolean'); //original=tinyint
        $table->addColumn('internal_rate', 'float', ['notnull' => false]);
        $table->addIndex(['project_id'], 'IDX_41535D55166D1F9C');
        $table->addUniqueIndex(['user_id', 'project_id'], 'UNIQ_41535D55A76ED395166D1F9C');
        $table->addIndex(['user_id'], 'IDX_41535D55A76ED395');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_projects_teams (
            project_id INT NOT NULL, 
            team_id INT NOT NULL, 
            INDEX IDX_9345D431296CD8AE (team_id), 
            INDEX IDX_9345D431166D1F9C (project_id), 
            PRIMARY KEY(project_id, team_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createProjectsTeamsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_projects_teams');
        $table->addColumn('project_id', 'integer');
        $table->addColumn('team_id', 'integer');
        $table->addIndex(['team_id'], 'IDX_9345D431296CD8AE'); 
        $table->addIndex(['project_id'], 'IDX_9345D431166D1F9C');
        $table->setPrimaryKey(['project_id', 'team_id']);
    }

    /*
        CREATE TABLE kimai2_roles (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            UNIQUE INDEX roles_name (name), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = ''
     */
    /**
     * @param Schema $schema
     */
    public function createRolesTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_roles');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 50]);
        $table->addUniqueIndex(['name'], 'roles_name');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_roles_permissions (
            id INT AUTO_INCREMENT NOT NULL, 
            role_id INT NOT NULL, 
            permission VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            allowed TINYINT(1) DEFAULT 0 NOT NULL, 
            UNIQUE INDEX role_permission (role_id, permission), 
            INDEX IDX_D263A3B8D60322AC (role_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createRolesPermissionsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_roles_permissions');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('role_id', 'integer');
        $table->addColumn('permission', 'string', ['length' => 50]);
        $table->addColumn('allowed', 'boolean', ['default' => false]); //original=tinyint,default=0
        $table->addUniqueIndex(['role_id', 'permission'], 'role_permission');
        $table->addIndex(['role_id'], 'IDX_D263A3B8D60322AC');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_sessions (
            id VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            data BLOB NOT NULL, 
            time INT UNSIGNED NOT NULL, 
            lifetime INT UNSIGNED NOT NULL, 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createSessionsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_sessions');
        $table->addColumn('id', 'string', ['length' => 128]);
        $table->addColumn('data', 'blob');
        $table->addColumn('time', 'integer', ['unsigned' => true]);
        $table->addColumn('lifetime', 'integer', ['unsigned' => true]);
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_tags (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            UNIQUE INDEX UNIQ_27CAF54C5E237E06 (name), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createTagsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_tags');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 100]);
        $table->addColumn('color', 'string', ['length' => 7, 'notnull' => false]);
        $table->addUniqueIndex(['name'], 'UNIQ_27CAF54C5E237E06');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_teams (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            UNIQUE INDEX UNIQ_3BEDDC7F5E237E06 (name), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createTeamsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_teams');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 100]);
        $table->addColumn('color', 'string', ['length' => 7, 'notnull' => false]);
        $table->addUniqueIndex(['name'], 'UNIQ_3BEDDC7F5E237E06');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_timesheet (
            id INT AUTO_INCREMENT NOT NULL, 
            user INT NOT NULL, 
            activity_id INT NOT NULL, 
            project_id INT NOT NULL, 
            start_time DATETIME NOT NULL COMMENT '(DC2Type:datetime)', 
            end_time DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
            duration INT DEFAULT NULL, 
            description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            rate DOUBLE PRECISION NOT NULL, 
            fixed_rate DOUBLE PRECISION DEFAULT NULL, 
            hourly_rate DOUBLE PRECISION DEFAULT NULL, 
            exported TINYINT(1) DEFAULT 0 NOT NULL, 
            timezone VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            internal_rate DOUBLE PRECISION DEFAULT NULL, 
            billable TINYINT(1) DEFAULT 1, 
            category VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT 'work' NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            modified_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
            date_tz DATE NOT NULL, 
            INDEX IDX_TIMESHEET_RESULT_STATS (user, id, duration), 
            INDEX IDX_4F60C6B1502DF587415614018D93D649 (start_time, end_time, user), 
            INDEX IDX_4F60C6B18D93D649 (user), 
            INDEX IDX_4F60C6B1166D1F9C (project_id), 
            INDEX IDX_4F60C6B1502DF58741561401 (start_time, end_time), 
            INDEX IDX_TIMESHEET_RECENT_ACTIVITIES (user, project_id, activity_id), 
            INDEX IDX_4F60C6B1BDF467148D93D649 (date_tz, user), 
            INDEX IDX_4F60C6B181C06096 (activity_id), 
            INDEX IDX_4F60C6B1415614018D93D649 (end_time, user), 
            INDEX IDX_4F60C6B18D93D649502DF587 (user, start_time), 
            INDEX IDX_TIMESHEET_TICKTAC (end_time, user, start_time), 
            INDEX IDX_4F60C6B1502DF587 (start_time), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createTimesheetTable($schema)
    {
        $table = $schema->createTable('kimai2_timesheet');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user', 'integer');
        $table->addColumn('activity_id', 'integer');
        $table->addColumn('project_id', 'integer');
        $table->addColumn('start_time', 'datetime');
        $table->addColumn('end_time', 'datetime', ['notnull' => false]);
        $table->addColumn('duration', 'integer', ['notnull' => false]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('rate', 'float');
        $table->addColumn('fixed_rate', 'float', ['notnull' => false]);
        $table->addColumn('hourly_rate', 'float', ['notnull' => false]);
        $table->addColumn('exported', 'boolean', ['default' => false]); //original=tinyint,default=0
        $table->addColumn('timezone', 'string', ['length' => 64]);
        $table->addColumn('internal_rate', 'float', ['notnull' => false]);
        $table->addColumn('billable', 'boolean', ['default' => true]); //original=tinyint,default=1
        $table->addColumn('category', 'string', ['length' => 10, 'default' => 'work']);
        $table->addColumn('modified_at', 'datetime', ['notnull' => false]);
        $table->addColumn('date_tz', 'date');
        $table->addIndex(['user', 'id', 'duration'], 'IDX_TIMESHEET_RESULT_STATS');
        $table->addIndex(['start_time', 'end_time', 'user'], 'IDX_4F60C6B1502DF587415614018D93D649');
        $table->addIndex(['user'], 'IDX_4F60C6B18D93D649');
        $table->addIndex(['project_id'], 'IDX_4F60C6B1166D1F9C');
        $table->addIndex(['start_time', 'end_time'], 'IDX_4F60C6B1502DF58741561401');
        $table->addIndex(['user', 'project_id', 'activity_id'], 'IDX_TIMESHEET_RECENT_ACTIVITIES');
        $table->addIndex(['date_tz', 'user'], 'IDX_4F60C6B1BDF467148D93D649');
        $table->addIndex(['activity_id'], 'IDX_4F60C6B181C06096');
        $table->addIndex(['end_time', 'user'], 'IDX_4F60C6B1415614018D93D649');
        $table->addIndex(['user', 'start_time'], 'IDX_4F60C6B18D93D649502DF587');
        $table->addIndex(['end_time', 'user', 'start_time'], 'IDX_TIMESHEET_TICKTAC'); 
        $table->addIndex(['start_time'], 'IDX_4F60C6B1502DF587'); 
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_timesheet_meta (
            id INT AUTO_INCREMENT NOT NULL, 
            timesheet_id INT NOT NULL, 
            name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            visible TINYINT(1) DEFAULT 0 NOT NULL, 
            UNIQUE INDEX UNIQ_CB606CBAABDD46BE5E237E06 (timesheet_id, name), 
            INDEX IDX_CB606CBAABDD46BE (timesheet_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createTimesheetMetaTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_timesheet_meta');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('timesheet_id', 'integer');
        $table->addColumn('name', 'string', ['length' => 50]);
        $table->addColumn('value', 'text', ['notnull' => false]);
        $table->addColumn('visible', 'boolean', ['default' => false]); //original=tinyint,default=0
        $table->addUniqueIndex(['timesheet_id', 'name'], 'UNIQ_CB606CBAABDD46BE5E237E06'); 
        $table->addIndex(['timesheet_id'], 'IDX_CB606CBAABDD46BE');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_timesheet_tags (
            timesheet_id INT NOT NULL, 
            tag_id INT NOT NULL, 
            INDEX IDX_E3284EFEBAD26311 (tag_id), 
            INDEX IDX_E3284EFEABDD46BE (timesheet_id), 
            PRIMARY KEY(timesheet_id, tag_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createTimesheetTagsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_timesheet_tags');
        $table->addColumn('timesheet_id', 'integer');
        $table->addColumn('tag_id', 'integer');
        $table->addIndex(['tag_id'], 'IDX_E3284EFEBAD26311');
        $table->addIndex(['timesheet_id'], 'IDX_E3284EFEABDD46BE');
        $table->setPrimaryKey(['timesheet_id', 'tag_id']);
    }

    /*
        CREATE TABLE kimai2_user_preferences (
            id INT AUTO_INCREMENT NOT NULL, 
            user_id INT DEFAULT NULL, 
            name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            value VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            INDEX IDX_8D08F631A76ED395 (user_id), 
            UNIQUE INDEX UNIQ_8D08F631A76ED3955E237E06 (user_id, name), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createUserPreferencesTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_user_preferences');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer', ['notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 50]);
        $table->addColumn('value', 'string', ['length' => 255, 'notnull' => false]);
        $table->addIndex(['user_id'], 'IDX_8D08F631A76ED395');
        $table->addUniqueIndex(['user_id', 'name'], 'UNIQ_8D08F631A76ED3955E237E06');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_users (
            id INT AUTO_INCREMENT NOT NULL, 
            username VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            alias VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            enabled TINYINT(1) NOT NULL, 
            registration_date DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
            title VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            avatar VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT '(DC2Type:array)', 
            last_login DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
            confirmation_token VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            password_requested_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
            api_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            auth VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            account VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            totp_secret VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, 
            totp_enabled TINYINT(1) DEFAULT 0 NOT NULL, 
            system_account TINYINT(1) DEFAULT 0 NOT NULL, 
            UNIQUE INDEX UNIQ_B9AC5BCEF85E0677 (username), 
            UNIQUE INDEX UNIQ_B9AC5BCEC05FB297 (confirmation_token), 
            UNIQUE INDEX UNIQ_B9AC5BCEE7927C74 (email), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createUsersTable(Schema $schema): void
    {
        /* addColumn( column_name , column_type, [portable_options, common_options, vendor_specific_options] )*/
        $table = $schema->createTable('kimai2_users');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('username', 'string', ['length' => 180]);
        $table->addColumn('email', 'string', ['length' => 190]);
        $table->addColumn('password', 'string', ['length' => 255]);
        $table->addColumn('alias', 'string', ['length' => 60, 'notnull' => false]);
        $table->addColumn('enabled', 'boolean'); //original=tinyint
        $table->addColumn('registration_date', 'datetime', ['notnull' => false]);
        $table->addColumn('title', 'string', ['length' => 50, 'notnull' => false]);
        $table->addColumn('avatar', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('roles', 'text');
        $table->addColumn('last_login', 'datetime', ['notnull' => false]);
        $table->addColumn('confirmation_token', 'string', ['length' => 180, 'notnull' => false]);
        $table->addColumn('password_requested_at', 'datetime', ['notnull' => false]);
        $table->addColumn('api_token', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('auth', 'string', ['length' => 20, 'notnull' => false]);
        $table->addColumn('color', 'string', ['length' => 7, 'notnull' => false]);
        $table->addColumn('account', 'string', ['length' => 30, 'notnull' => false]);
        $table->addColumn('totp_secret', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('totp_enabled', 'boolean', ['default' => false]); //original=tinyint,default=0
        $table->addColumn('system_account', 'boolean', ['default' => false]); //original=tinyint,default=0
        $table->addUniqueIndex(['username'], 'UNIQ_B9AC5BCEF85E0677');
        $table->addUniqueIndex(['confirmation_token'], 'UNIQ_B9AC5BCEC05FB297');
        $table->addUniqueIndex(['email'], 'UNIQ_B9AC5BCEE7927C74');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE kimai2_users_teams (
            id INT AUTO_INCREMENT NOT NULL, 
            user_id INT NOT NULL, 
            team_id INT NOT NULL, 
            teamlead TINYINT(1) DEFAULT 0 NOT NULL, 
            UNIQUE INDEX UNIQ_B5E92CF8A76ED395296CD8AE (user_id, team_id), 
            INDEX IDX_B5E92CF8A76ED395 (user_id), 
            INDEX IDX_B5E92CF8296CD8AE (team_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createUsersTeamsTable(Schema $schema)
    {
        $table = $schema->createTable('kimai2_users_teams');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer');
        $table->addColumn('team_id', 'integer');
        $table->addColumn('teamlead', 'boolean', ['default' => 0]); //original=tinyint,default=0
        $table->addUniqueIndex(['user_id', 'team_id'], 'UNIQ_B5E92CF8A76ED395296CD8AE');
        $table->addIndex(['user_id'], 'IDX_B5E92CF8A76ED395');
        $table->addIndex(['team_id'], 'IDX_B5E92CF8296CD8AE');
        $table->setPrimaryKey(['id']);
    }

    /*
        CREATE TABLE migration_versions (
            version VARCHAR(191) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, 
            executed_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
            execution_time INT DEFAULT NULL, 
            PRIMARY KEY(version)
        ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = '' 
     */
    /**
     * @param Schema $schema
     */
    public function createMigrationVersionsTable(Schema $schema)
    {
        $table = $schema->createTable('migration_versions');
        $table->addColumn('version', 'string', ['length' => 191]);
        $table->addColumn('executed_at', 'datetime', ['notnull' => false]);
        $table->addColumn('execution_time', 'integer', ['notnull' => false]);
        $table->setPrimaryKey(['version']);
    }

    /**
     * @param Schema $schema
     */
    public function createForeignKeyConstraints(Schema $schema)
    {
        $activitiesTable = $schema->getTable('kimai2_activities');
        $activitiesMetaTable = $schema->getTable('kimai2_activities_meta');
        $activitiesRatesTable = $schema->getTable('kimai2_activities_rates');
        $activitiesTeamsTable = $schema->getTable('kimai2_activities_teams');
        $bookmarksTable = $schema->getTable('kimai2_bookmarks');
        $customersTable = $schema->getTable('kimai2_customers');
        $customersCommentsTable = $schema->getTable('kimai2_customers_comments');
        $customersMetaTable = $schema->getTable('kimai2_customers_meta');
        $customersRatesTable = $schema->getTable('kimai2_customers_rates');
        $customersTeamsTable = $schema->getTable('kimai2_customers_teams');
        $invoicesTable = $schema->getTable('kimai2_invoices');
        $invoiceTemplatesTable = $schema->getTable('kimai2_invoice_templates');
        $invoicesMetaTable = $schema->getTable('kimai2_invoices_meta');
        $projectsTable = $schema->getTable('kimai2_projects');
        $projectsCommentsTable = $schema->getTable('kimai2_projects_comments');
        $projectsMetaTable = $schema->getTable('kimai2_projects_meta');
        $projectsRatesTable = $schema->getTable('kimai2_projects_rates');
        $projectsTeamsTable = $schema->getTable('kimai2_projects_teams');
        $rolesTable = $schema->getTable('kimai2_roles');
        $rolesPermissionsTable = $schema->getTable('kimai2_roles_permissions');
        $tagsTable = $schema->getTable('kimai2_tags');
        $teamsTable = $schema->getTable('kimai2_teams');
        $timesheetTable = $schema->getTable('kimai2_timesheet');
        $timesheetMetaTable = $schema->getTable('kimai2_timesheet_meta');
        $timesheetTagsTable = $schema->getTable('kimai2_timesheet_tags');
        $userPreferencesTable = $schema->getTable('kimai2_user_preferences');
        $usersTeamsTable = $schema->getTable('kimai2_users_teams');
        $usersTable = $schema->getTable('kimai2_users');

        // ALTER TABLE kimai2_activities ADD CONSTRAINT FK_8811FE1C166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
        $activitiesTable->addForeignKeyConstraint($projectsTable, ['project_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_8811FE1C166D1F9C');
        
        // ALTER TABLE kimai2_activities_meta ADD CONSTRAINT FK_A7C0A43D81C06096 FOREIGN KEY (activity_id) REFERENCES kimai2_activities (id) ON DELETE CASCADE
        $activitiesMetaTable->addForeignKeyConstraint($activitiesTable, ['activity_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_A7C0A43D81C06096');
        
        // ALTER TABLE kimai2_activities_rates ADD CONSTRAINT FK_4A7F11BE81C06096 FOREIGN KEY (activity_id) REFERENCES kimai2_activities (id) ON DELETE CASCADE
        $activitiesRatesTable->addForeignKeyConstraint($activitiesTable, ['activity_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_4A7F11BE81C06096');
        
        // ALTER TABLE kimai2_activities_rates ADD CONSTRAINT FK_4A7F11BEA76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
        $activitiesRatesTable->addForeignKeyConstraint($usersTable, ['user_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_4A7F11BEA76ED395');
        
        // ALTER TABLE kimai2_activities_teams ADD CONSTRAINT FK_986998DA296CD8AE FOREIGN KEY (team_id) REFERENCES kimai2_teams (id) ON DELETE CASCADE
        $activitiesTeamsTable->addForeignKeyConstraint($teamsTable, ['team_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_986998DA296CD8AE');
        
        // ALTER TABLE kimai2_activities_teams ADD CONSTRAINT FK_986998DA81C06096 FOREIGN KEY (activity_id) REFERENCES kimai2_activities (id) ON DELETE CASCADE
        $activitiesTeamsTable->addForeignKeyConstraint($activitiesTable, ['activity_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_986998DA81C06096');
        
        // ALTER TABLE kimai2_bookmarks ADD CONSTRAINT FK_4016EF25A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
        $bookmarksTable->addForeignKeyConstraint($usersTable, ['user_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_4016EF25A76ED395');
        
        // ALTER TABLE kimai2_customers ADD CONSTRAINT FK_5A97604412946D8B FOREIGN KEY (invoice_template_id) REFERENCES kimai2_invoice_templates (id) ON DELETE SET NULL
        $customersTable->addForeignKeyConstraint($invoiceTemplatesTable, ['invoice_template_id'], ['id'], ['onDelete' => 'SET NULL'], 'FK_5A97604412946D8B'); # need to check onDelete SET NULL correctness
        
        // ALTER TABLE kimai2_customers_comments ADD CONSTRAINT FK_A5B142D99395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
        $customersCommentsTable->addForeignKeyConstraint($customersTable, ['customer_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_A5B142D99395C3F3');
        
        // ALTER TABLE kimai2_customers_comments ADD CONSTRAINT FK_A5B142D9B03A8386 FOREIGN KEY (created_by_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
        $customersCommentsTable->addForeignKeyConstraint($usersTable, ['created_by_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_A5B142D9B03A8386');
        
        // ALTER TABLE kimai2_customers_meta ADD CONSTRAINT FK_A48A760F9395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
        $customersMetaTable->addForeignKeyConstraint($customersTable, ['customer_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_A48A760F9395C3F3');
        
        // ALTER TABLE kimai2_customers_rates ADD CONSTRAINT FK_82AB0AEC9395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
        $customersRatesTable->addForeignKeyConstraint($customersTable, ['customer_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_82AB0AEC9395C3F3');
        
        // ALTER TABLE kimai2_customers_rates ADD CONSTRAINT FK_82AB0AECA76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
        $customersRatesTable->addForeignKeyConstraint($usersTable, ['user_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_82AB0AECA76ED395');
        
        // ALTER TABLE kimai2_customers_teams ADD CONSTRAINT FK_50BD8388296CD8AE FOREIGN KEY (team_id) REFERENCES kimai2_teams (id) ON DELETE CASCADE
        $customersTeamsTable->addForeignKeyConstraint($teamsTable, ['team_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_50BD8388296CD8AE');

        // ALTER_TABLE kimai2_customers_teams ADD CONSTRAINT FK_50BD83889395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
        $customersTeamsTable->addForeignKeyConstraint($customersTable, ['customer_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_50BD83889395C3F3');

        // ALTER TABLE kimai2_invoices ADD CONSTRAINT FK_76C38E37A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
        $invoicesTable->addForeignKeyConstraint($usersTable, ['user_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_76C38E37A76ED395');

        // ALTER TABLE kimai2_invoices ADD CONSTRAINT FK_76C38E379395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
        $invoicesTable->addForeignKeyConstraint($customersTable, ['customer_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_76C38E379395C3F3');

        // ALTER TABLE kimai2_invoices_meta ADD CONSTRAINT FK_7EDC37D92989F1FD FOREIGN KEY (invoice_id) REFERENCES kimai2_invoices (id) ON DELETE CASCADE
        $invoicesMetaTable->addForeignKeyConstraint($invoicesTable, ['invoice_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_7EDC37D92989F1FD');

        // ALTER TABLE kimai2_projects ADD CONSTRAINT FK_407F12069395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
        $projectsTable->addForeignKeyConstraint($usersTable, ['customer_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_407F12069395C3F3');

        // ALTER TABLE kimai2_projects_comments ADD CONSTRAINT FK_29A23638166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
        $projectsCommentsTable->addForeignKeyConstraint($projectsTable, ['project_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_29A23638166D1F9C');

        // ALTER TABLE kimai2_projects_comments ADD CONSTRAINT FK_29A23638B03A8386 FOREIGN KEY (created_by_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
        $projectsCommentsTable->addForeignKeyConstraint($usersTable, ['created_by_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_29A23638B03A8386');

        // ALTER TABLE kimai2_projects_meta ADD CONSTRAINT FK_50536EF2166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
        $projectsMetaTable->addForeignKeyConstraint($projectsTable, ['project_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_50536EF2166D1F9C');

        // ALTER TABLE kimai2_projects_rates ADD CONSTRAINT FK_41535D55166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
        $projectsRatesTable->addForeignKeyConstraint($projectsTable, ['project_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_41535D55166D1F9C');

        // ALTER TABLE kimai2_projects_rates ADD CONSTRAINT FK_41535D55A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
        $projectsRatesTable->addForeignKeyConstraint($usersTable, ['user_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_41535D55A76ED395');

        // ALTER TABLE kimai2_projects_teams ADD CONSTRAINT FK_9345D431296CD8AE FOREIGN KEY (team_id) REFERENCES kimai2_teams (id) ON DELETE CASCADE
        $projectsTeamsTable->addForeignKeyConstraint($teamsTable, ['team_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_9345D431296CD8AE');

        // ALTER TABLE kimai2_projects_teams ADD CONSTRAINT FK_9345D431166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
        $projectsTeamsTable->addForeignKeyConstraint($projectsTable, ['project_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_9345D431166D1F9C');

        // ALTER TABLE kimai2_roles_permissions ADD CONSTRAINT FK_D263A3B8D60322AC FOREIGN KEY (role_id) REFERENCES kimai2_roles (id) ON DELETE CASCADE
        $rolesPermissionsTable->addForeignKeyConstraint($rolesTable, ['role_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_D263A3B8D60322AC');

        // ALTER TABLE kimai2_timesheet ADD CONSTRAINT FK_4F60C6B181C06096 FOREIGN KEY (activity_id) REFERENCES kimai2_activities (id) ON DELETE CASCADE
        $timesheetTable->addForeignKeyConstraint($activitiesTable, ['activity_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_4F60C6B181C06096');

        // ALTER TABLE kimai2_timesheet ADD CONSTRAINT FK_4F60C6B18D93D649 FOREIGN KEY (user) REFERENCES kimai2_users (id) ON DELETE CASCADE
        $timesheetTable->addForeignKeyConstraint($usersTable, ['user'], ['id'], ['onDelete' => 'CASCADE'], 'FK_4F60C6B18D93D649');

        // ALTER TABLE kimai2_timesheet ADD CONSTRAINT FK_4F60C6B1166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
        $timesheetTable->addForeignKeyConstraint($projectsTable, ['project_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_4F60C6B1166D1F9C');

        // ALTER TABLE kimai2_timesheet_meta ADD CONSTRAINT FK_CB606CBAABDD46BE FOREIGN KEY (timesheet_id) REFERENCES kimai2_timesheet (id) ON DELETE CASCADE
        $timesheetMetaTable->addForeignKeyConstraint($timesheetTable, ['timesheet_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_CB606CBAABDD46BE');

        // ALTER TABLE kimai2_timesheet_tags ADD CONSTRAINT FK_732EECA9ABDD46BE FOREIGN KEY (timesheet_id) REFERENCES kimai2_timesheet (id) ON DELETE CASCADE
        $timesheetTagsTable->addForeignKeyConstraint($timesheetTable, ['timesheet_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_732EECA9ABDD46BE');

        // ALTER TABLE kimai2_timesheet_tags ADD CONSTRAINT FK_732EECA9BAD26311 FOREIGN KEY (tag_id) REFERENCES kimai2_tags (id) ON DELETE CASCADE
        $timesheetTagsTable->addForeignKeyConstraint($tagsTable, ['tag_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_732EECA9BAD26311');

        // ALTER TABLE kimai2_user_preferences ADD CONSTRAINT FK_8D08F631A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
        $userPreferencesTable->addForeignKeyConstraint($usersTable, ['user_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_8D08F631A76ED395');

        // ALTER TABLE kimai2_users_teams ADD CONSTRAINT FK_B5E92CF8296CD8AE FOREIGN KEY (team_id) REFERENCES kimai2_teams (id) ON DELETE CASCADE
        $usersTeamsTable->addForeignKeyConstraint($teamsTable, ['team_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_B5E92CF8296CD8AE');

        // ALTER TABLE kimai2_users_teams ADD CONSTRAINT FK_B5E92CF8A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
        $usersTeamsTable->addForeignKeyConstraint($usersTable, ['user_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_B5E92CF8A76ED395');
    }
}
/**
 * This SQL was generated from the doctrine command
 * 'php bin/console doctrine:schema:update --dump-sql' 
 * around the time of commit 5711c15eac1082a2062a5f21d7c7b75f1d59eb06
 *
CREATE TABLE kimai2_activities (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, name VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, comment TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, visible TINYINT(1) NOT NULL, color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, time_budget INT DEFAULT 0 NOT NULL, budget DOUBLE PRECISION DEFAULT '0' NOT NULL, budget_type VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, billable TINYINT(1) DEFAULT 1 NOT NULL, invoice_text LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_8811FE1C7AB0E8595E237E06 (visible, name), INDEX IDX_8811FE1C166D1F9C (project_id), INDEX IDX_8811FE1C7AB0E859166D1F9C5E237E06 (visible, project_id, name), INDEX IDX_8811FE1C7AB0E859166D1F9C (visible, project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_activities_meta (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, visible TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_A7C0A43D81C060965E237E06 (activity_id, name), INDEX IDX_A7C0A43D81C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_activities_rates (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, activity_id INT DEFAULT NULL, rate DOUBLE PRECISION NOT NULL, fixed TINYINT(1) NOT NULL, internal_rate DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4A7F11BE81C06096 (activity_id), INDEX IDX_4A7F11BEA76ED395 (user_id), UNIQUE INDEX UNIQ_4A7F11BEA76ED39581C06096 (user_id, activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_activities_teams (activity_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_986998DA296CD8AE (team_id), INDEX IDX_986998DA81C06096 (activity_id), PRIMARY KEY(activity_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_bookmarks (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_4016EF25A76ED395 (user_id), UNIQUE INDEX UNIQ_4016EF25A76ED3955E237E06 (user_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_configuration (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_1C5D63D85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_customers (id INT AUTO_INCREMENT NOT NULL, invoice_template_id INT DEFAULT NULL, name VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, number VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, comment TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, visible TINYINT(1) NOT NULL, company VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, contact VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, address TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, country VARCHAR(2) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, currency VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, phone VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, fax VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, mobile VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(75) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, homepage VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, timezone VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, time_budget INT DEFAULT 0 NOT NULL, budget DOUBLE PRECISION DEFAULT '0' NOT NULL, vat_id VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, budget_type VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, billable TINYINT(1) DEFAULT 1 NOT NULL, invoice_text LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_5A97604412946D8B (invoice_template_id), INDEX IDX_5A9760447AB0E859 (visible), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_customers_comments (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, created_by_id INT NOT NULL, message LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime)', pinned TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_A5B142D99395C3F3 (customer_id), INDEX IDX_A5B142D9B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_customers_meta (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, visible TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_A48A760F9395C3F35E237E06 (customer_id, name), INDEX IDX_A48A760F9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_customers_rates (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, rate DOUBLE PRECISION NOT NULL, fixed TINYINT(1) NOT NULL, internal_rate DOUBLE PRECISION DEFAULT NULL, INDEX IDX_82AB0AEC9395C3F3 (customer_id), UNIQUE INDEX UNIQ_82AB0AECA76ED3959395C3F3 (user_id, customer_id), INDEX IDX_82AB0AECA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_customers_teams (customer_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_50BD8388296CD8AE (team_id), INDEX IDX_50BD83889395C3F3 (customer_id), PRIMARY KEY(customer_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_invoice_templates (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, company VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, address TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, due_days INT NOT NULL, vat DOUBLE PRECISION DEFAULT '0', calculator VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, number_generator VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, renderer VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, payment_terms TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, vat_id VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, contact LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, payment_details LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, decimal_duration TINYINT(1) DEFAULT 0 NOT NULL, language VARCHAR(6) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_1626CFE95E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_invoices (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, user_id INT NOT NULL, invoice_number VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime)', timezone VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, total DOUBLE PRECISION NOT NULL, tax DOUBLE PRECISION NOT NULL, currency VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, due_days INT NOT NULL, vat DOUBLE PRECISION NOT NULL, invoice_filename VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, payment_date DATE DEFAULT NULL, comment LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_76C38E372DA68207 (invoice_number), INDEX IDX_76C38E37A76ED395 (user_id), UNIQUE INDEX UNIQ_76C38E372323B33D (invoice_filename), INDEX IDX_76C38E379395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_invoices_meta (id INT AUTO_INCREMENT NOT NULL, invoice_id INT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, visible TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_7EDC37D92989F1FD5E237E06 (invoice_id, name), INDEX IDX_7EDC37D92989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_projects (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, name VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, order_number TINYTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, comment TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, visible TINYINT(1) NOT NULL, budget DOUBLE PRECISION DEFAULT '0' NOT NULL, color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, time_budget INT DEFAULT 0 NOT NULL, order_date DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', start DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', end DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', timezone VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, budget_type VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, billable TINYINT(1) DEFAULT 1 NOT NULL, invoice_text LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, global_activities TINYINT(1) DEFAULT 1 NOT NULL, INDEX IDX_407F12069395C3F37AB0E8595E237E06 (customer_id, visible, name), INDEX IDX_407F12069395C3F37AB0E859BF396750 (customer_id, visible, id), INDEX IDX_407F12069395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_projects_comments (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, created_by_id INT NOT NULL, message LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime)', pinned TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_29A23638B03A8386 (created_by_id), INDEX IDX_29A23638166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_projects_meta (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, visible TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_50536EF2166D1F9C5E237E06 (project_id, name), INDEX IDX_50536EF2166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_projects_rates (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, project_id INT DEFAULT NULL, rate DOUBLE PRECISION NOT NULL, fixed TINYINT(1) NOT NULL, internal_rate DOUBLE PRECISION DEFAULT NULL, INDEX IDX_41535D55166D1F9C (project_id), UNIQUE INDEX UNIQ_41535D55A76ED395166D1F9C (user_id, project_id), INDEX IDX_41535D55A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_projects_teams (project_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_9345D431296CD8AE (team_id), INDEX IDX_9345D431166D1F9C (project_id), PRIMARY KEY(project_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX roles_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_roles_permissions (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, permission VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, allowed TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX role_permission (role_id, permission), INDEX IDX_D263A3B8D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_sessions (id VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, data BLOB NOT NULL, time INT UNSIGNED NOT NULL, lifetime INT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_27CAF54C5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_teams (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_3BEDDC7F5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_timesheet (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, activity_id INT NOT NULL, project_id INT NOT NULL, start_time DATETIME NOT NULL COMMENT '(DC2Type:datetime)', end_time DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', duration INT DEFAULT NULL, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, rate DOUBLE PRECISION NOT NULL, fixed_rate DOUBLE PRECISION DEFAULT NULL, hourly_rate DOUBLE PRECISION DEFAULT NULL, exported TINYINT(1) DEFAULT 0 NOT NULL, timezone VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, internal_rate DOUBLE PRECISION DEFAULT NULL, billable TINYINT(1) DEFAULT 1, category VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT 'work' NOT NULL COLLATE `utf8mb4_unicode_ci`, modified_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', date_tz DATE NOT NULL, INDEX IDX_TIMESHEET_RESULT_STATS (user, id, duration), INDEX IDX_4F60C6B1502DF587415614018D93D649 (start_time, end_time, user), INDEX IDX_4F60C6B18D93D649 (user), INDEX IDX_4F60C6B1166D1F9C (project_id), INDEX IDX_4F60C6B1502DF58741561401 (start_time, end_time), INDEX IDX_TIMESHEET_RECENT_ACTIVITIES (user, project_id, activity_id), INDEX IDX_4F60C6B1BDF467148D93D649 (date_tz, user), INDEX IDX_4F60C6B181C06096 (activity_id), INDEX IDX_4F60C6B1415614018D93D649 (end_time, user), INDEX IDX_4F60C6B18D93D649502DF587 (user, start_time), INDEX IDX_TIMESHEET_TICKTAC (end_time, user, start_time), INDEX IDX_4F60C6B1502DF587 (start_time), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_timesheet_meta (id INT AUTO_INCREMENT NOT NULL, timesheet_id INT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, visible TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_CB606CBAABDD46BE5E237E06 (timesheet_id, name), INDEX IDX_CB606CBAABDD46BE (timesheet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_timesheet_tags (timesheet_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E3284EFEBAD26311 (tag_id), INDEX IDX_E3284EFEABDD46BE (timesheet_id), PRIMARY KEY(timesheet_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_user_preferences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_8D08F631A76ED395 (user_id), UNIQUE INDEX UNIQ_8D08F631A76ED3955E237E06 (user_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, alias VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, enabled TINYINT(1) NOT NULL, registration_date DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', title VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, avatar VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT '(DC2Type:array)', last_login DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', confirmation_token VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, password_requested_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', api_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, auth VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, account VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, totp_secret VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, totp_enabled TINYINT(1) DEFAULT 0 NOT NULL, system_account TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_B9AC5BCEF85E0677 (username), UNIQUE INDEX UNIQ_B9AC5BCEC05FB297 (confirmation_token), UNIQUE INDEX UNIQ_B9AC5BCEE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE kimai2_users_teams (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, team_id INT NOT NULL, teamlead TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_B5E92CF8A76ED395296CD8AE (user_id, team_id), INDEX IDX_B5E92CF8A76ED395 (user_id), INDEX IDX_B5E92CF8296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
CREATE TABLE migration_versions (version VARCHAR(191) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, executed_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', execution_time INT DEFAULT NULL, PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = '' 
ALTER TABLE kimai2_activities ADD CONSTRAINT FK_8811FE1C166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
ALTER TABLE kimai2_activities_meta ADD CONSTRAINT FK_A7C0A43D81C06096 FOREIGN KEY (activity_id) REFERENCES kimai2_activities (id) ON DELETE CASCADE
ALTER TABLE kimai2_activities_rates ADD CONSTRAINT FK_4A7F11BE81C06096 FOREIGN KEY (activity_id) REFERENCES kimai2_activities (id) ON DELETE CASCADE
ALTER TABLE kimai2_activities_rates ADD CONSTRAINT FK_4A7F11BEA76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
ALTER TABLE kimai2_activities_teams ADD CONSTRAINT FK_986998DA296CD8AE FOREIGN KEY (team_id) REFERENCES kimai2_teams (id) ON DELETE CASCADE
ALTER TABLE kimai2_activities_teams ADD CONSTRAINT FK_986998DA81C06096 FOREIGN KEY (activity_id) REFERENCES kimai2_activities (id) ON DELETE CASCADE
ALTER TABLE kimai2_bookmarks ADD CONSTRAINT FK_4016EF25A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
ALTER TABLE kimai2_customers ADD CONSTRAINT FK_5A97604412946D8B FOREIGN KEY (invoice_template_id) REFERENCES kimai2_invoice_templates (id) ON DELETE SET NULL
ALTER TABLE kimai2_customers_comments ADD CONSTRAINT FK_A5B142D99395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
ALTER TABLE kimai2_customers_comments ADD CONSTRAINT FK_A5B142D9B03A8386 FOREIGN KEY (created_by_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
ALTER TABLE kimai2_customers_meta ADD CONSTRAINT FK_A48A760F9395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
ALTER TABLE kimai2_customers_rates ADD CONSTRAINT FK_82AB0AEC9395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
ALTER TABLE kimai2_customers_rates ADD CONSTRAINT FK_82AB0AECA76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
ALTER TABLE kimai2_customers_teams ADD CONSTRAINT FK_50BD8388296CD8AE FOREIGN KEY (team_id) REFERENCES kimai2_teams (id) ON DELETE CASCADE
ALTER TABLE kimai2_customers_teams ADD CONSTRAINT FK_50BD83889395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
ALTER TABLE kimai2_invoices ADD CONSTRAINT FK_76C38E37A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
ALTER TABLE kimai2_invoices ADD CONSTRAINT FK_76C38E379395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
ALTER TABLE kimai2_invoices_meta ADD CONSTRAINT FK_7EDC37D92989F1FD FOREIGN KEY (invoice_id) REFERENCES kimai2_invoices (id) ON DELETE CASCADE
ALTER TABLE kimai2_projects ADD CONSTRAINT FK_407F12069395C3F3 FOREIGN KEY (customer_id) REFERENCES kimai2_customers (id) ON DELETE CASCADE
ALTER TABLE kimai2_projects_comments ADD CONSTRAINT FK_29A23638166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
ALTER TABLE kimai2_projects_comments ADD CONSTRAINT FK_29A23638B03A8386 FOREIGN KEY (created_by_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
ALTER TABLE kimai2_projects_meta ADD CONSTRAINT FK_50536EF2166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
ALTER TABLE kimai2_projects_rates ADD CONSTRAINT FK_41535D55166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
ALTER TABLE kimai2_projects_rates ADD CONSTRAINT FK_41535D55A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
ALTER TABLE kimai2_projects_teams ADD CONSTRAINT FK_9345D431296CD8AE FOREIGN KEY (team_id) REFERENCES kimai2_teams (id) ON DELETE CASCADE
ALTER TABLE kimai2_projects_teams ADD CONSTRAINT FK_9345D431166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
ALTER TABLE kimai2_roles_permissions ADD CONSTRAINT FK_D263A3B8D60322AC FOREIGN KEY (role_id) REFERENCES kimai2_roles (id) ON DELETE CASCADE
ALTER TABLE kimai2_timesheet ADD CONSTRAINT FK_4F60C6B181C06096 FOREIGN KEY (activity_id) REFERENCES kimai2_activities (id) ON DELETE CASCADE
ALTER TABLE kimai2_timesheet ADD CONSTRAINT FK_4F60C6B18D93D649 FOREIGN KEY (user) REFERENCES kimai2_users (id) ON DELETE CASCADE
ALTER TABLE kimai2_timesheet ADD CONSTRAINT FK_4F60C6B1166D1F9C FOREIGN KEY (project_id) REFERENCES kimai2_projects (id) ON DELETE CASCADE
ALTER TABLE kimai2_timesheet_meta ADD CONSTRAINT FK_CB606CBAABDD46BE FOREIGN KEY (timesheet_id) REFERENCES kimai2_timesheet (id) ON DELETE CASCADE
ALTER TABLE kimai2_timesheet_tags ADD CONSTRAINT FK_732EECA9ABDD46BE FOREIGN KEY (timesheet_id) REFERENCES kimai2_timesheet (id) ON DELETE CASCADE
ALTER TABLE kimai2_timesheet_tags ADD CONSTRAINT FK_732EECA9BAD26311 FOREIGN KEY (tag_id) REFERENCES kimai2_tags (id) ON DELETE CASCADE
ALTER TABLE kimai2_user_preferences ADD CONSTRAINT FK_8D08F631A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
ALTER TABLE kimai2_users_teams ADD CONSTRAINT FK_B5E92CF8296CD8AE FOREIGN KEY (team_id) REFERENCES kimai2_teams (id) ON DELETE CASCADE
ALTER TABLE kimai2_users_teams ADD CONSTRAINT FK_B5E92CF8A76ED395 FOREIGN KEY (user_id) REFERENCES kimai2_users (id) ON DELETE CASCADE
 */
