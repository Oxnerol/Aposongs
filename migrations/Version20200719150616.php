<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200719150616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, text_field LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artists CHANGE band_activity_start band_activity_start INT DEFAULT NULL, CHANGE band_activity_end band_activity_end INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE news');
        $this->addSql('ALTER TABLE artists CHANGE band_activity_start band_activity_start DATE DEFAULT NULL, CHANGE band_activity_end band_activity_end DATE DEFAULT NULL');
    }
}
