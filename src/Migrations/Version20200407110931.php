<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407110931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE video_data (id INT AUTO_INCREMENT NOT NULL, input_url_id INT NOT NULL, id_video VARCHAR(100) NOT NULL, img_site VARCHAR(255) NOT NULL, title LONGTEXT NOT NULL, description LONGTEXT NOT NULL, img_youtube LONGTEXT NOT NULL, valid VARCHAR(100) NOT NULL, date DATE NOT NULL, INDEX IDX_AA64AEBF4D7B53BA (input_url_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE video_data ADD CONSTRAINT FK_AA64AEBF4D7B53BA FOREIGN KEY (input_url_id) REFERENCES input_url (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE video_data');
    }
}
