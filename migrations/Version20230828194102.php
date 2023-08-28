<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828194102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_submission ADD program_id INT DEFAULT NULL, ADD documents_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program_submission ADD CONSTRAINT FK_CD3FA7473EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE program_submission ADD CONSTRAINT FK_CD3FA7475F0F2752 FOREIGN KEY (documents_id) REFERENCES document (id)');
        $this->addSql('CREATE INDEX IDX_CD3FA7473EB8070A ON program_submission (program_id)');
        $this->addSql('CREATE INDEX IDX_CD3FA7475F0F2752 ON program_submission (documents_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_submission DROP FOREIGN KEY FK_CD3FA7473EB8070A');
        $this->addSql('ALTER TABLE program_submission DROP FOREIGN KEY FK_CD3FA7475F0F2752');
        $this->addSql('DROP INDEX IDX_CD3FA7473EB8070A ON program_submission');
        $this->addSql('DROP INDEX IDX_CD3FA7475F0F2752 ON program_submission');
        $this->addSql('ALTER TABLE program_submission DROP program_id, DROP documents_id');
    }
}
