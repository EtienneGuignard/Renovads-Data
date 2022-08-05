<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220805091500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forwarder ADD fk_campaign_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE forwarder ADD CONSTRAINT FK_215078089FCF5B40 FOREIGN KEY (fk_campaign_id) REFERENCES campaign (id)');
        $this->addSql('CREATE INDEX IDX_215078089FCF5B40 ON forwarder (fk_campaign_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forwarder DROP FOREIGN KEY FK_215078089FCF5B40');
        $this->addSql('DROP INDEX IDX_215078089FCF5B40 ON forwarder');
        $this->addSql('ALTER TABLE forwarder DROP fk_campaign_id');
    }
}
