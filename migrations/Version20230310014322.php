<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310014322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', folder_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) DEFAULT NULL, slug LONGTEXT NOT NULL, file_name VARCHAR(255) NOT NULL, file_size VARCHAR(255) NOT NULL, file_mime_type VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, file_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8C9F3610989D9B62 (slug), INDEX IDX_8C9F3610162CB942 (folder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610162CB942');
        $this->addSql('DROP TABLE file');
    }
}
