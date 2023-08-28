<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828195009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program_submission_documents (program_submission_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_E2A89FF344B459AB (program_submission_id), INDEX IDX_E2A89FF3C33F7837 (document_id), PRIMARY KEY(program_submission_id, document_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program_submission_documents ADD CONSTRAINT FK_E2A89FF344B459AB FOREIGN KEY (program_submission_id) REFERENCES program_submission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_submission_documents ADD CONSTRAINT FK_E2A89FF3C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_submission DROP FOREIGN KEY FK_CD3FA7475F0F2752');
        $this->addSql('DROP INDEX IDX_CD3FA7475F0F2752 ON program_submission');
        $this->addSql('ALTER TABLE program_submission DROP documents_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_submission_documents DROP FOREIGN KEY FK_E2A89FF344B459AB');
        $this->addSql('ALTER TABLE program_submission_documents DROP FOREIGN KEY FK_E2A89FF3C33F7837');
        $this->addSql('DROP TABLE program_submission_documents');
        $this->addSql('ALTER TABLE program_submission ADD documents_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program_submission ADD CONSTRAINT FK_CD3FA7475F0F2752 FOREIGN KEY (documents_id) REFERENCES document (id)');
        $this->addSql('CREATE INDEX IDX_CD3FA7475F0F2752 ON program_submission (documents_id)');
    }
}
