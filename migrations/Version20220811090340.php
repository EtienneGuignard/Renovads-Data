<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220811090340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD fk_supplier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649432BC1B8 FOREIGN KEY (fk_supplier_id) REFERENCES supplier (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649432BC1B8 ON user (fk_supplier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649432BC1B8');
        $this->addSql('DROP INDEX UNIQ_8D93D649432BC1B8 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP fk_supplier_id');
    }
}
