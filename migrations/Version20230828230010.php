<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828230010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program_file (id INT AUTO_INCREMENT NOT NULL, program_submission_id INT NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_8179631744B459AB (program_submission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program_file ADD CONSTRAINT FK_8179631744B459AB FOREIGN KEY (program_submission_id) REFERENCES program_submission (id)');
        $this->addSql('ALTER TABLE uploaded_file DROP FOREIGN KEY FK_B40DF75D44B459AB');
        $this->addSql('DROP TABLE uploaded_file');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE uploaded_file (id INT AUTO_INCREMENT NOT NULL, program_submission_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_B40DF75D44B459AB (program_submission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE uploaded_file ADD CONSTRAINT FK_B40DF75D44B459AB FOREIGN KEY (program_submission_id) REFERENCES program_submission (id)');
        $this->addSql('ALTER TABLE program_file DROP FOREIGN KEY FK_8179631744B459AB');
        $this->addSql('DROP TABLE program_file');
    }
}
