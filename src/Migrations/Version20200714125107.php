<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714125107 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE alt_text_language (id INT AUTO_INCREMENT NOT NULL, artists_id INT DEFAULT NULL, musician_id INT DEFAULT NULL, language_id INT DEFAULT NULL, text LONGTEXT DEFAULT NULL, INDEX IDX_339D483E54A05007 (artists_id), INDEX IDX_339D483E9523AA8A (musician_id), INDEX IDX_339D483E82F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artists (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, band_activity_start DATE DEFAULT NULL, band_activity_end DATE DEFAULT NULL, logo_img VARCHAR(255) DEFAULT NULL, biography LONGTEXT DEFAULT NULL, alt_img VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_68D3801E5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artists_genre (artists_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_F37780F254A05007 (artists_id), INDEX IDX_F37780F24296D31F (genre_id), PRIMARY KEY(artists_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artists_sub_genre (artists_id INT NOT NULL, sub_genre_id INT NOT NULL, INDEX IDX_4D71343554A05007 (artists_id), INDEX IDX_4D713435F8393D46 (sub_genre_id), PRIMARY KEY(artists_id, sub_genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artists_disc (artists_id INT NOT NULL, disc_id INT NOT NULL, INDEX IDX_4FE8D03554A05007 (artists_id), INDEX IDX_4FE8D035C38F37CA (disc_id), PRIMARY KEY(artists_id, disc_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artists_video (artists_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_CE0692654A05007 (artists_id), INDEX IDX_CE0692629C1004E (video_id), PRIMARY KEY(artists_id, video_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contribution_language (id INT AUTO_INCREMENT NOT NULL, language VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disc (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cover VARCHAR(255) DEFAULT NULL, release_date DATE NOT NULL, alt_img VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE highlight_index (id INT AUTO_INCREMENT NOT NULL, target_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, artists_id INT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_36AC99F154A05007 (artists_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE musicians (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, nickname VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, born DATE DEFAULT NULL, death DATE DEFAULT NULL, musician_img VARCHAR(255) DEFAULT NULL, biography LONGTEXT DEFAULT NULL, alt_img VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE track (id INT AUTO_INCREMENT NOT NULL, disc_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lyric LONGTEXT DEFAULT NULL, INDEX IDX_D6E3F8A6C38F37CA (disc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user_role (user_id INT NOT NULL, user_role_id INT NOT NULL, INDEX IDX_2D084B47A76ED395 (user_id), INDEX IDX_2D084B478E0E3CA6 (user_role_id), PRIMARY KEY(user_id, user_role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_7CC7DA2C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cron_job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, command VARCHAR(1024) NOT NULL, schedule VARCHAR(191) NOT NULL, description VARCHAR(191) NOT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX un_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cron_report (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, run_at DATETIME NOT NULL, run_time DOUBLE PRECISION NOT NULL, exit_code INT NOT NULL, output LONGTEXT NOT NULL, INDEX IDX_B6C6A7F5BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alt_text_language ADD CONSTRAINT FK_339D483E54A05007 FOREIGN KEY (artists_id) REFERENCES artists (id)');
        $this->addSql('ALTER TABLE alt_text_language ADD CONSTRAINT FK_339D483E9523AA8A FOREIGN KEY (musician_id) REFERENCES musicians (id)');
        $this->addSql('ALTER TABLE alt_text_language ADD CONSTRAINT FK_339D483E82F1BAF4 FOREIGN KEY (language_id) REFERENCES contribution_language (id)');
        $this->addSql('ALTER TABLE artists_genre ADD CONSTRAINT FK_F37780F254A05007 FOREIGN KEY (artists_id) REFERENCES artists (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artists_genre ADD CONSTRAINT FK_F37780F24296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artists_sub_genre ADD CONSTRAINT FK_4D71343554A05007 FOREIGN KEY (artists_id) REFERENCES artists (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artists_sub_genre ADD CONSTRAINT FK_4D713435F8393D46 FOREIGN KEY (sub_genre_id) REFERENCES sub_genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artists_disc ADD CONSTRAINT FK_4FE8D03554A05007 FOREIGN KEY (artists_id) REFERENCES artists (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artists_disc ADD CONSTRAINT FK_4FE8D035C38F37CA FOREIGN KEY (disc_id) REFERENCES disc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artists_video ADD CONSTRAINT FK_CE0692654A05007 FOREIGN KEY (artists_id) REFERENCES artists (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artists_video ADD CONSTRAINT FK_CE0692629C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F154A05007 FOREIGN KEY (artists_id) REFERENCES artists (id)');
        $this->addSql('ALTER TABLE track ADD CONSTRAINT FK_D6E3F8A6C38F37CA FOREIGN KEY (disc_id) REFERENCES disc (id)');
        $this->addSql('ALTER TABLE user_user_role ADD CONSTRAINT FK_2D084B47A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user_role ADD CONSTRAINT FK_2D084B478E0E3CA6 FOREIGN KEY (user_role_id) REFERENCES user_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C12469DE2 FOREIGN KEY (category_id) REFERENCES video_category (id)');
        $this->addSql('ALTER TABLE cron_report ADD CONSTRAINT FK_B6C6A7F5BE04EA9 FOREIGN KEY (job_id) REFERENCES cron_job (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE alt_text_language DROP FOREIGN KEY FK_339D483E54A05007');
        $this->addSql('ALTER TABLE artists_genre DROP FOREIGN KEY FK_F37780F254A05007');
        $this->addSql('ALTER TABLE artists_sub_genre DROP FOREIGN KEY FK_4D71343554A05007');
        $this->addSql('ALTER TABLE artists_disc DROP FOREIGN KEY FK_4FE8D03554A05007');
        $this->addSql('ALTER TABLE artists_video DROP FOREIGN KEY FK_CE0692654A05007');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F154A05007');
        $this->addSql('ALTER TABLE alt_text_language DROP FOREIGN KEY FK_339D483E82F1BAF4');
        $this->addSql('ALTER TABLE artists_disc DROP FOREIGN KEY FK_4FE8D035C38F37CA');
        $this->addSql('ALTER TABLE track DROP FOREIGN KEY FK_D6E3F8A6C38F37CA');
        $this->addSql('ALTER TABLE artists_genre DROP FOREIGN KEY FK_F37780F24296D31F');
        $this->addSql('ALTER TABLE alt_text_language DROP FOREIGN KEY FK_339D483E9523AA8A');
        $this->addSql('ALTER TABLE artists_sub_genre DROP FOREIGN KEY FK_4D713435F8393D46');
        $this->addSql('ALTER TABLE user_user_role DROP FOREIGN KEY FK_2D084B47A76ED395');
        $this->addSql('ALTER TABLE user_user_role DROP FOREIGN KEY FK_2D084B478E0E3CA6');
        $this->addSql('ALTER TABLE artists_video DROP FOREIGN KEY FK_CE0692629C1004E');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C12469DE2');
        $this->addSql('ALTER TABLE cron_report DROP FOREIGN KEY FK_B6C6A7F5BE04EA9');
        $this->addSql('DROP TABLE alt_text_language');
        $this->addSql('DROP TABLE artists');
        $this->addSql('DROP TABLE artists_genre');
        $this->addSql('DROP TABLE artists_sub_genre');
        $this->addSql('DROP TABLE artists_disc');
        $this->addSql('DROP TABLE artists_video');
        $this->addSql('DROP TABLE contribution_language');
        $this->addSql('DROP TABLE disc');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE highlight_index');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE musicians');
        $this->addSql('DROP TABLE sub_genre');
        $this->addSql('DROP TABLE track');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_user_role');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE video_category');
        $this->addSql('DROP TABLE cron_job');
        $this->addSql('DROP TABLE cron_report');
    }
}
