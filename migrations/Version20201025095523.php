<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025095523 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, mark_id INT DEFAULT NULL, type_id INT DEFAULT NULL, specificity_id INT DEFAULT NULL, location_id INT DEFAULT NULL, status_id INT DEFAULT NULL, serial_number VARCHAR(255) NOT NULL, keywords VARCHAR(255) NOT NULL, manipulated_at DATETIME NOT NULL, deleted TINYINT(1) NOT NULL, INDEX IDX_D338D583A76ED395 (user_id), INDEX IDX_D338D5834290F12B (mark_id), INDEX IDX_D338D583C54C8C93 (type_id), INDEX IDX_D338D5835F69A929 (specificity_id), INDEX IDX_D338D58364D218E (location_id), INDEX IDX_D338D5836BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_D11814ABA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mark (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_user (role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_332CA4DDD60322AC (role_id), INDEX IDX_332CA4DDA76ED395 (user_id), PRIMARY KEY(role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specificity (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, present TINYINT(1) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D5834290F12B FOREIGN KEY (mark_id) REFERENCES mark (id)');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D5835F69A929 FOREIGN KEY (specificity_id) REFERENCES specificity (id)');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D58364D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D5836BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D58364D218E');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D5834290F12B');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D5835F69A929');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D5836BF700BD');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583C54C8C93');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583A76ED395');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814ABA76ED395');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP TABLE specificity');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
