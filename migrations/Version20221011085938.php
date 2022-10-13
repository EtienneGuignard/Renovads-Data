<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011085938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data_across_header ADD campaign_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE data_across_header ADD CONSTRAINT FK_15E1A21B3141FA38 FOREIGN KEY (campaign_id_id) REFERENCES campaign (id)');
        $this->addSql('CREATE INDEX IDX_15E1A21B3141FA38 ON data_across_header (campaign_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data_across_header DROP FOREIGN KEY FK_15E1A21B3141FA38');
        $this->addSql('DROP INDEX IDX_15E1A21B3141FA38 ON data_across_header');
        $this->addSql('ALTER TABLE data_across_header DROP campaign_id_id');
    }
}
