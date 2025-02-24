<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223143744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE joueur (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', modified_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souhait_joueur (souhait_id INT NOT NULL, joueur_id INT NOT NULL, INDEX IDX_47193748B1067C4 (souhait_id), INDEX IDX_47193748A9E2D76C (joueur_id), PRIMARY KEY(souhait_id, joueur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE souhait_joueur ADD CONSTRAINT FK_47193748B1067C4 FOREIGN KEY (souhait_id) REFERENCES souhait (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE souhait_joueur ADD CONSTRAINT FK_47193748A9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE souhait_joueur DROP FOREIGN KEY FK_47193748B1067C4');
        $this->addSql('ALTER TABLE souhait_joueur DROP FOREIGN KEY FK_47193748A9E2D76C');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('DROP TABLE souhait_joueur');
    }
}
