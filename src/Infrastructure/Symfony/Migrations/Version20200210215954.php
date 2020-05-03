<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200210215954 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grower CHANGE identifier identifier VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE grower ADD CONSTRAINT FK_B35B3B9CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B35B3B9CA76ED395 ON grower (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grower DROP FOREIGN KEY FK_B35B3B9CA76ED395');
        $this->addSql('DROP INDEX UNIQ_B35B3B9CA76ED395 ON grower');
        $this->addSql('ALTER TABLE grower CHANGE identifier identifier CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:growerId)\'');
    }
}
