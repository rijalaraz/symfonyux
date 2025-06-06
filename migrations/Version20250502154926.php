<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250502154926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE food DROP CONSTRAINT FK_D43829F74B89032C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food ADD CONSTRAINT FK_D43829F74B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food DROP CONSTRAINT fk_d43829f74b89032c
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food ADD CONSTRAINT fk_d43829f74b89032c FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }
}
