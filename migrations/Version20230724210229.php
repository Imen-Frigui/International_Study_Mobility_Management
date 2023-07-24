<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230724210229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student_submission (id INT AUTO_INCREMENT NOT NULL, program_id INT DEFAULT NULL, INDEX IDX_36DAB7123EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_submission ADD CONSTRAINT FK_36DAB7123EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE program_submission CHANGE nationality nationality VARCHAR(255) NOT NULL, CHANGE passport_number passport_number VARCHAR(255) NOT NULL, CHANGE cv cv VARCHAR(255) NOT NULL, CHANGE passport_needed passport_needed TINYINT(1) NOT NULL, CHANGE cv_needed cv_needed TINYINT(1) NOT NULL, CHANGE recommendation_letter_needed recommendation_letter_needed TINYINT(1) NOT NULL, CHANGE english_language_certificate_needed english_language_certificate_needed TINYINT(1) NOT NULL, CHANGE other_documents_needed other_documents_needed TINYINT(1) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE phone phone VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_submission DROP FOREIGN KEY FK_36DAB7123EB8070A');
        $this->addSql('DROP TABLE student_submission');
        $this->addSql('ALTER TABLE program_submission CHANGE nationality nationality VARCHAR(255) DEFAULT NULL, CHANGE passport_number passport_number VARCHAR(255) DEFAULT NULL, CHANGE cv cv VARCHAR(255) DEFAULT NULL, CHANGE passport_needed passport_needed TINYINT(1) DEFAULT NULL, CHANGE cv_needed cv_needed TINYINT(1) DEFAULT NULL, CHANGE recommendation_letter_needed recommendation_letter_needed TINYINT(1) DEFAULT NULL, CHANGE english_language_certificate_needed english_language_certificate_needed TINYINT(1) DEFAULT NULL, CHANGE other_documents_needed other_documents_needed TINYINT(1) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL');
    }
}
