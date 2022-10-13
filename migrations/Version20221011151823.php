<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011151823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data_across_header DROP INDEX IDX_15E1A21B3141FA38, ADD UNIQUE INDEX UNIQ_15E1A21B3141FA38 (campaign_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data_across_header DROP INDEX UNIQ_15E1A21B3141FA38, ADD INDEX IDX_15E1A21B3141FA38 (campaign_id_id)');
    }
}
