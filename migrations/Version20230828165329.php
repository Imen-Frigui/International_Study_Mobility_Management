<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828165329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED7784309D1878');
        $this->addSql('DROP INDEX IDX_92ED7784309D1878 ON program');
        $this->addSql('ALTER TABLE program DROP university_id, DROP documents_needed');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program ADD university_id INT DEFAULT NULL, ADD documents_needed VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('CREATE INDEX IDX_92ED7784309D1878 ON program (university_id)');
    }
}
