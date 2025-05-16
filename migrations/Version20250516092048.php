<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250516092048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE food ADD meal_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food ADD CONSTRAINT FK_D43829F7639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D43829F7639666D6 ON food (meal_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food DROP CONSTRAINT FK_D43829F7639666D6
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D43829F7639666D6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food DROP meal_id
        SQL);
    }
}
