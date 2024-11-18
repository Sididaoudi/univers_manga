<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008161830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manga_mangaka (manga_id INT NOT NULL, mangaka_id INT NOT NULL, INDEX IDX_5F48BF867B6461 (manga_id), INDEX IDX_5F48BF86302BA454 (mangaka_id), PRIMARY KEY(manga_id, mangaka_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE manga_mangaka ADD CONSTRAINT FK_5F48BF867B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manga_mangaka ADD CONSTRAINT FK_5F48BF86302BA454 FOREIGN KEY (mangaka_id) REFERENCES mangaka (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manga_mangaka DROP FOREIGN KEY FK_5F48BF867B6461');
        $this->addSql('ALTER TABLE manga_mangaka DROP FOREIGN KEY FK_5F48BF86302BA454');
        $this->addSql('DROP TABLE manga_mangaka');
    }
}
