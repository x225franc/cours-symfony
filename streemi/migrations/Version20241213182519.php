<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241213182519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, label VARCHAR(100) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_media (category_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_821FEE4512469DE2 (category_id), INDEX IDX_821FEE45EA9FDD75 (media_id), PRIMARY KEY(category_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, publisher_id INT NOT NULL, parent_comment_id INT DEFAULT NULL, media_id INT DEFAULT NULL, content LONGTEXT NOT NULL, status VARCHAR(255) DEFAULT \'pending\' NOT NULL, INDEX IDX_9474526C40C86FCE (publisher_id), INDEX IDX_9474526CBF2AF943 (parent_comment_id), INDEX IDX_9474526CEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, season_id INT NOT NULL, title VARCHAR(255) NOT NULL, duration TIME NOT NULL, release_at DATE NOT NULL, INDEX IDX_DDAA1CDA4EC001D1 (season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, code VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language_media (language_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_1574A55D82F1BAF4 (language_id), INDEX IDX_1574A55DEA9FDD75 (media_id), PRIMARY KEY(language_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, short_description LONGTEXT NOT NULL, long_description LONGTEXT NOT NULL, release_at DATE NOT NULL, cover_image VARCHAR(255) NOT NULL, staff JSON NOT NULL, casting JSON NOT NULL, rating INT DEFAULT NULL, mediaType VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D782112D61220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_media (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, playlist_id INT DEFAULT NULL, added_at DATETIME NOT NULL, INDEX IDX_C930B84FEA9FDD75 (media_id), INDEX IDX_C930B84F6BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_subscription (id INT AUTO_INCREMENT NOT NULL, playlist_id INT NOT NULL, subscriber_id INT NOT NULL, subscribed_at DATETIME NOT NULL, INDEX IDX_832940C6BBD148 (playlist_id), INDEX IDX_832940C7808B1AD (subscriber_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, serie_id INT NOT NULL, season_number INT NOT NULL, INDEX IDX_F0E45BA9D94388BD (serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, price INT NOT NULL, duration_in_months INT NOT NULL, quality VARCHAR(15) DEFAULT NULL, catchphrase VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_history (id INT AUTO_INCREMENT NOT NULL, subscriber_id INT NOT NULL, subscription_id INT DEFAULT NULL, start_at DATE NOT NULL, end_at DATE NOT NULL, INDEX IDX_54AF90D07808B1AD (subscriber_id), INDEX IDX_54AF90D09A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, account_status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE watch_history (id INT AUTO_INCREMENT NOT NULL, viewer_id INT NOT NULL, media_id INT NOT NULL, last_watched_at DATETIME NOT NULL, number_of_views INT NOT NULL, INDEX IDX_DE44EFD86C59C752 (viewer_id), INDEX IDX_DE44EFD8EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_media ADD CONSTRAINT FK_821FEE4512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_media ADD CONSTRAINT FK_821FEE45EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C40C86FCE FOREIGN KEY (publisher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CBF2AF943 FOREIGN KEY (parent_comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE language_media ADD CONSTRAINT FK_1574A55D82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE language_media ADD CONSTRAINT FK_1574A55DEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FBF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D61220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playlist_media ADD CONSTRAINT FK_C930B84FEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE playlist_media ADD CONSTRAINT FK_C930B84F6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940C6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940C7808B1AD FOREIGN KEY (subscriber_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA9D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334BF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D07808B1AD FOREIGN KEY (subscriber_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D09A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD86C59C752 FOREIGN KEY (viewer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD8EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_media DROP FOREIGN KEY FK_821FEE4512469DE2');
        $this->addSql('ALTER TABLE category_media DROP FOREIGN KEY FK_821FEE45EA9FDD75');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C40C86FCE');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CBF2AF943');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CEA9FDD75');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA4EC001D1');
        $this->addSql('ALTER TABLE language_media DROP FOREIGN KEY FK_1574A55D82F1BAF4');
        $this->addSql('ALTER TABLE language_media DROP FOREIGN KEY FK_1574A55DEA9FDD75');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FBF396750');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D61220EA6');
        $this->addSql('ALTER TABLE playlist_media DROP FOREIGN KEY FK_C930B84FEA9FDD75');
        $this->addSql('ALTER TABLE playlist_media DROP FOREIGN KEY FK_C930B84F6BBD148');
        $this->addSql('ALTER TABLE playlist_subscription DROP FOREIGN KEY FK_832940C6BBD148');
        $this->addSql('ALTER TABLE playlist_subscription DROP FOREIGN KEY FK_832940C7808B1AD');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA9D94388BD');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334BF396750');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D07808B1AD');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D09A1887DC');
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD86C59C752');
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD8EA9FDD75');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_media');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE language_media');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_media');
        $this->addSql('DROP TABLE playlist_subscription');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE subscription_history');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE watch_history');
    }
}
