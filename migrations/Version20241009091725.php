<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009091725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manga_genre (manga_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_1506CF9F7B6461 (manga_id), INDEX IDX_1506CF9F4296D31F (genre_id), PRIMARY KEY(manga_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE manga_genre ADD CONSTRAINT FK_1506CF9F7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manga_genre ADD CONSTRAINT FK_1506CF9F4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manga_genre DROP FOREIGN KEY FK_1506CF9F7B6461');
        $this->addSql('ALTER TABLE manga_genre DROP FOREIGN KEY FK_1506CF9F4296D31F');
        $this->addSql('DROP TABLE manga_genre');
    }
}
