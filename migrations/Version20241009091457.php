<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009091457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manga ADD type_manga_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE manga ADD CONSTRAINT FK_765A9E03CD84439D FOREIGN KEY (type_manga_id) REFERENCES types (id)');
        $this->addSql('CREATE INDEX IDX_765A9E03CD84439D ON manga (type_manga_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manga DROP FOREIGN KEY FK_765A9E03CD84439D');
        $this->addSql('DROP INDEX IDX_765A9E03CD84439D ON manga');
        $this->addSql('ALTER TABLE manga DROP type_manga_id');
    }
}
