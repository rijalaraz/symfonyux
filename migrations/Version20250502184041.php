<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250502184041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE post_food (post_id INT NOT NULL, food_id INT NOT NULL, PRIMARY KEY(post_id, food_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1D6D4EFC4B89032C ON post_food (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1D6D4EFCBA8E87C4 ON post_food (food_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post_food ADD CONSTRAINT FK_1D6D4EFC4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post_food ADD CONSTRAINT FK_1D6D4EFCBA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post_food DROP CONSTRAINT FK_1D6D4EFC4B89032C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post_food DROP CONSTRAINT FK_1D6D4EFCBA8E87C4
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE post_food
        SQL);
    }
}
