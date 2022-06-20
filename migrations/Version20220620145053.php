<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620145053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD country VARCHAR(255) DEFAULT NULL, ADD zip_code VARCHAR(8) DEFAULT NULL, ADD region VARCHAR(255) DEFAULT NULL, ADD registration_number VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD vatnumber VARCHAR(255) DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP country, DROP zip_code, DROP region, DROP registration_number, DROP city, DROP vatnumber, DROP is_verified');
    }
}
