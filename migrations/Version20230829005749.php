<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829005749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student ADD first_year_grade DOUBLE PRECISION NOT NULL, ADD second_year_grade DOUBLE PRECISION NOT NULL, ADD third_year_grade DOUBLE PRECISION NOT NULL, ADD fourth_year_grade DOUBLE PRECISION NOT NULL, DROP get_average_grade_year1, DROP get_average_grade_year2, DROP get_average_grade_year3, DROP get_average_grade_year4, DROP get_average_grade_year5');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student ADD get_average_grade_year1 DOUBLE PRECISION NOT NULL, ADD get_average_grade_year2 DOUBLE PRECISION NOT NULL, ADD get_average_grade_year3 DOUBLE PRECISION NOT NULL, ADD get_average_grade_year4 DOUBLE PRECISION NOT NULL, ADD get_average_grade_year5 DOUBLE PRECISION NOT NULL, DROP first_year_grade, DROP second_year_grade, DROP third_year_grade, DROP fourth_year_grade');
    }
}
