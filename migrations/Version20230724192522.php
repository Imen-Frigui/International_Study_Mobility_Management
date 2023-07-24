<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230724192522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program_submission (id INT AUTO_INCREMENT NOT NULL, program_id INT NOT NULL, nationality VARCHAR(255) NOT NULL, passport_number VARCHAR(255) NOT NULL, cv VARCHAR(255) NOT NULL, passport_needed TINYINT(1) NOT NULL, cv_needed TINYINT(1) NOT NULL, recommendation_letter_needed TINYINT(1) NOT NULL, english_language_certificate_needed TINYINT(1) NOT NULL, other_documents_needed TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, INDEX IDX_CD3FA7473EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program_submission ADD CONSTRAINT FK_CD3FA7473EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_submission DROP FOREIGN KEY FK_CD3FA7473EB8070A');
        $this->addSql('DROP TABLE program_submission');
    }
}
