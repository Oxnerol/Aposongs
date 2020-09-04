<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716224605 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alt_text_language DROP FOREIGN KEY FK_339D483E54A05007');
        $this->addSql('ALTER TABLE alt_text_language DROP FOREIGN KEY FK_339D483E9523AA8A');
        $this->addSql('DROP INDEX IDX_339D483E54A05007 ON alt_text_language');
        $this->addSql('DROP INDEX IDX_339D483E9523AA8A ON alt_text_language');
        $this->addSql('ALTER TABLE alt_text_language ADD target_id INT NOT NULL, ADD categori_name VARCHAR(255) NOT NULL, DROP artists_id, DROP musician_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alt_text_language ADD artists_id INT DEFAULT NULL, ADD musician_id INT DEFAULT NULL, DROP target_id, DROP categori_name');
        $this->addSql('ALTER TABLE alt_text_language ADD CONSTRAINT FK_339D483E54A05007 FOREIGN KEY (artists_id) REFERENCES artists (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE alt_text_language ADD CONSTRAINT FK_339D483E9523AA8A FOREIGN KEY (musician_id) REFERENCES musicians (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_339D483E54A05007 ON alt_text_language (artists_id)');
        $this->addSql('CREATE INDEX IDX_339D483E9523AA8A ON alt_text_language (musician_id)');
    }
}
