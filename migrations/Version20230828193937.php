<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828193937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_submission DROP FOREIGN KEY FK_CD3FA7473EB8070A');
        $this->addSql('DROP INDEX IDX_CD3FA7473EB8070A ON program_submission');
        $this->addSql('ALTER TABLE program_submission DROP program_id, DROP passport_number, DROP cv, DROP passport_needed, DROP cv_needed, DROP recommendation_letter_needed, DROP english_language_certificate_needed, DROP other_documents_needed, DROP email, DROP phone, DROP nationality_needed');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_submission ADD program_id INT NOT NULL, ADD passport_number VARCHAR(255) NOT NULL, ADD cv VARCHAR(255) NOT NULL, ADD passport_needed TINYINT(1) NOT NULL, ADD cv_needed TINYINT(1) NOT NULL, ADD recommendation_letter_needed TINYINT(1) NOT NULL, ADD english_language_certificate_needed TINYINT(1) NOT NULL, ADD other_documents_needed TINYINT(1) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL, ADD nationality_needed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE program_submission ADD CONSTRAINT FK_CD3FA7473EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('CREATE INDEX IDX_CD3FA7473EB8070A ON program_submission (program_id)');
    }
}
