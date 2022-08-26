<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220805105029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE body_forwarder ADD fk_forwarder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE body_forwarder ADD CONSTRAINT FK_B4F6B74AC50234BA FOREIGN KEY (fk_forwarder_id) REFERENCES forwarder (id)');
        $this->addSql('CREATE INDEX IDX_B4F6B74AC50234BA ON body_forwarder (fk_forwarder_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE body_forwarder DROP FOREIGN KEY FK_B4F6B74AC50234BA');
        $this->addSql('DROP INDEX IDX_B4F6B74AC50234BA ON body_forwarder');
        $this->addSql('ALTER TABLE body_forwarder DROP fk_forwarder_id');
    }
}
