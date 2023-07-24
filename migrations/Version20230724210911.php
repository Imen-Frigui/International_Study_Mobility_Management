<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230724210911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_submission ADD passport TINYINT(1) DEFAULT NULL, ADD cv TINYINT(1) DEFAULT NULL, ADD recommendation_letter TINYINT(1) DEFAULT NULL, ADD english_language_certificate TINYINT(1) DEFAULT NULL, ADD other_documents TINYINT(1) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL, CHANGE program_id program_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_submission DROP passport, DROP cv, DROP recommendation_letter, DROP english_language_certificate, DROP other_documents, DROP email, DROP phone, CHANGE program_id program_id INT DEFAULT NULL');
    }
}
