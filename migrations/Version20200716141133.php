<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716141133 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('ALTER TABLE artists ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE musicians CHANGE last_name last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_user_role DROP FOREIGN KEY FK_2D084B47A76ED395');
        $this->addSql('ALTER TABLE user_user_role ADD CONSTRAINT FK_2D084B47A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE artists DROP slug');
        $this->addSql('ALTER TABLE musicians CHANGE last_name last_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user_user_role DROP FOREIGN KEY FK_2D084B47A76ED395');
        $this->addSql('ALTER TABLE user_user_role ADD CONSTRAINT FK_2D084B47A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
