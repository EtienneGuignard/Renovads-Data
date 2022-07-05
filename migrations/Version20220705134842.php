<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705134842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leads ADD address_1 VARCHAR(255) DEFAULT NULL, ADD address_2 VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD zip VARCHAR(5) DEFAULT NULL, ADD privacy_policy VARCHAR(255) DEFAULT NULL, ADD confirm_privacy VARCHAR(45) NOT NULL, ADD confirm_partners VARCHAR(45) DEFAULT NULL, ADD url VARCHAR(1000) DEFAULT NULL, ADD job VARCHAR(255) DEFAULT NULL, ADD children VARCHAR(3) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leads DROP address_1, DROP address_2, DROP city, DROP zip, DROP privacy_policy, DROP confirm_privacy, DROP confirm_partners, DROP url, DROP job, DROP children');
    }
}
