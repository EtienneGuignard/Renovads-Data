<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804121129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leads ADD supplier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE leads ADD CONSTRAINT FK_179045522ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('CREATE INDEX IDX_179045522ADD6D8C ON leads (supplier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leads DROP FOREIGN KEY FK_179045522ADD6D8C');
        $this->addSql('DROP INDEX IDX_179045522ADD6D8C ON leads');
        $this->addSql('ALTER TABLE leads DROP supplier_id');
    }
}
