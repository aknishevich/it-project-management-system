<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191112231437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__project AS SELECT id, owner, creating_date, tasks FROM project');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner INTEGER NOT NULL, creating_date DATETIME NOT NULL, tasks CLOB DEFAULT NULL --(DC2Type:array)
        )');
        $this->addSql('INSERT INTO project (id, owner, creating_date, tasks) SELECT id, owner, creating_date, tasks FROM __temp__project');
        $this->addSql('DROP TABLE __temp__project');
        $this->addSql('ALTER TABLE user ADD COLUMN name VARCHAR(180) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_6863C9EEA76ED395');
        $this->addSql('DROP INDEX IDX_6863C9EE166D1F9C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__projects_members AS SELECT user_id, project_id FROM projects_members');
        $this->addSql('DROP TABLE projects_members');
        $this->addSql('CREATE TABLE projects_members (user_id INTEGER NOT NULL, project_id INTEGER NOT NULL, PRIMARY KEY(user_id, project_id), CONSTRAINT FK_6863C9EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6863C9EE166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO projects_members (user_id, project_id) SELECT user_id, project_id FROM __temp__projects_members');
        $this->addSql('DROP TABLE __temp__projects_members');
        $this->addSql('CREATE INDEX IDX_6863C9EEA76ED395 ON projects_members (user_id)');
        $this->addSql('CREATE INDEX IDX_6863C9EE166D1F9C ON projects_members (project_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__project AS SELECT id, owner, creating_date, tasks FROM project');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner INTEGER NOT NULL, creating_date DATETIME NOT NULL, tasks CLOB DEFAULT \'NULL --(DC2Type:array)\' COLLATE BINARY --(DC2Type:array)
        )');
        $this->addSql('INSERT INTO project (id, owner, creating_date, tasks) SELECT id, owner, creating_date, tasks FROM __temp__project');
        $this->addSql('DROP TABLE __temp__project');
        $this->addSql('DROP INDEX IDX_6863C9EEA76ED395');
        $this->addSql('DROP INDEX IDX_6863C9EE166D1F9C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__projects_members AS SELECT user_id, project_id FROM projects_members');
        $this->addSql('DROP TABLE projects_members');
        $this->addSql('CREATE TABLE projects_members (user_id INTEGER NOT NULL, project_id INTEGER NOT NULL, PRIMARY KEY(user_id, project_id))');
        $this->addSql('INSERT INTO projects_members (user_id, project_id) SELECT user_id, project_id FROM __temp__projects_members');
        $this->addSql('DROP TABLE __temp__projects_members');
        $this->addSql('CREATE INDEX IDX_6863C9EEA76ED395 ON projects_members (user_id)');
        $this->addSql('CREATE INDEX IDX_6863C9EE166D1F9C ON projects_members (project_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password) SELECT id, email, roles, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
