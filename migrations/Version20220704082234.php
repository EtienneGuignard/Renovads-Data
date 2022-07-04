<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704082234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rule_group_campaign (rule_group_id INT NOT NULL, campaign_id INT NOT NULL, INDEX IDX_438AF40332A83AEB (rule_group_id), INDEX IDX_438AF403F639F774 (campaign_id), PRIMARY KEY(rule_group_id, campaign_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rule_group_campaign ADD CONSTRAINT FK_438AF40332A83AEB FOREIGN KEY (rule_group_id) REFERENCES rule_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rule_group_campaign ADD CONSTRAINT FK_438AF403F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rule_group_campaign');
    }
}
