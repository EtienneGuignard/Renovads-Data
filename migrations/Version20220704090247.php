<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704090247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campaign_leads (id INT AUTO_INCREMENT NOT NULL, campaign_id_id INT DEFAULT NULL, lead_id_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_5995213D3141FA38 (campaign_id_id), INDEX IDX_5995213D19A353D8 (lead_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campaign_leads ADD CONSTRAINT FK_5995213D3141FA38 FOREIGN KEY (campaign_id_id) REFERENCES campaign (id)');
        $this->addSql('ALTER TABLE campaign_leads ADD CONSTRAINT FK_5995213D19A353D8 FOREIGN KEY (lead_id_id) REFERENCES leads (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE campaign_leads');
    }
}
