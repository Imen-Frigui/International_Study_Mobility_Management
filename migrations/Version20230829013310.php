<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829013310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_submission ADD student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program_submission ADD CONSTRAINT FK_CD3FA747CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_CD3FA747CB944F1A ON program_submission (student_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_submission DROP FOREIGN KEY FK_CD3FA747CB944F1A');
        $this->addSql('DROP INDEX IDX_CD3FA747CB944F1A ON program_submission');
        $this->addSql('ALTER TABLE program_submission DROP student_id');
    }
}
