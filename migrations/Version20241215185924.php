<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215185924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE _symfony_scheduler_tasks');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE _symfony_scheduler_tasks (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, task_name VARCHAR(255) NOT NULL COLLATE "BINARY", body CLOB NOT NULL COLLATE "BINARY")');
        $this->addSql('CREATE INDEX _symfony_scheduler_tasks_name ON _symfony_scheduler_tasks (task_name)');
    }
}
