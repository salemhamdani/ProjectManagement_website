<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908004543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_AC74095A166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget_line (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, pourcentage DOUBLE PRECISION NOT NULL, INDEX IDX_ABD0B6A6166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, budgetline_id INT NOT NULL, name VARCHAR(255) NOT NULL, date VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_1981A66D81C06096 (activity_id), INDEX IDX_1981A66DE0FDD47D (budgetline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_trace (id INT AUTO_INCREMENT NOT NULL, operation_id INT NOT NULL, trace_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6612E31344AC3583 (operation_id), INDEX IDX_6612E313D410CF1C (trace_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_tranche (id INT AUTO_INCREMENT NOT NULL, operation_id INT NOT NULL, paymenttype_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, INDEX IDX_7F2E56AA44AC3583 (operation_id), INDEX IDX_7F2E56AA1947F086 (paymenttype_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, limitation DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, budget DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trace_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE budget_line ADD CONSTRAINT FK_ABD0B6A6166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DE0FDD47D FOREIGN KEY (budgetline_id) REFERENCES budget_line (id)');
        $this->addSql('ALTER TABLE payment_trace ADD CONSTRAINT FK_6612E31344AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE payment_trace ADD CONSTRAINT FK_6612E313D410CF1C FOREIGN KEY (trace_type_id) REFERENCES trace_type (id)');
        $this->addSql('ALTER TABLE payment_tranche ADD CONSTRAINT FK_7F2E56AA44AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE payment_tranche ADD CONSTRAINT FK_7F2E56AA1947F086 FOREIGN KEY (paymenttype_id) REFERENCES payment_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D81C06096');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DE0FDD47D');
        $this->addSql('ALTER TABLE payment_trace DROP FOREIGN KEY FK_6612E31344AC3583');
        $this->addSql('ALTER TABLE payment_tranche DROP FOREIGN KEY FK_7F2E56AA44AC3583');
        $this->addSql('ALTER TABLE payment_tranche DROP FOREIGN KEY FK_7F2E56AA1947F086');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A166D1F9C');
        $this->addSql('ALTER TABLE budget_line DROP FOREIGN KEY FK_ABD0B6A6166D1F9C');
        $this->addSql('ALTER TABLE payment_trace DROP FOREIGN KEY FK_6612E313D410CF1C');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE budget_line');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE payment_trace');
        $this->addSql('DROP TABLE payment_tranche');
        $this->addSql('DROP TABLE payment_type');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE trace_type');
    }
}
