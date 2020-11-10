<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110075810 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acte (id INT AUTO_INCREMENT NOT NULL, manuscrit_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, INDEX IDX_9EC413261E7C023C (manuscrit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, nom VARCHAR(30) DEFAULT NULL, prenom VARCHAR(30) DEFAULT NULL, nom_de_plume VARCHAR(30) DEFAULT NULL, password VARCHAR(255) NOT NULL, mail VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cellule (id INT AUTO_INCREMENT NOT NULL, scene_id INT NOT NULL, contenu_texte LONGTEXT DEFAULT NULL, contenu_audio LONGBLOB DEFAULT NULL, type VARCHAR(20) DEFAULT NULL, published TINYINT(1) NOT NULL, INDEX IDX_F493DEDF166053B4 (scene_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapitre (id INT AUTO_INCREMENT NOT NULL, acte_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, introduction VARCHAR(255) DEFAULT NULL, published TINYINT(1) NOT NULL, INDEX IDX_8C62B025A767B8C7 (acte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manuscrit (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, resume VARCHAR(255) DEFAULT NULL, genre VARCHAR(255) DEFAULT NULL, INDEX IDX_F4C162B560BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scene (id INT AUTO_INCREMENT NOT NULL, chapitre_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, published TINYINT(1) NOT NULL, INDEX IDX_D979EFDA1FBEEF7B (chapitre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC413261E7C023C FOREIGN KEY (manuscrit_id) REFERENCES manuscrit (id)');
        $this->addSql('ALTER TABLE cellule ADD CONSTRAINT FK_F493DEDF166053B4 FOREIGN KEY (scene_id) REFERENCES scene (id)');
        $this->addSql('ALTER TABLE chapitre ADD CONSTRAINT FK_8C62B025A767B8C7 FOREIGN KEY (acte_id) REFERENCES acte (id)');
        $this->addSql('ALTER TABLE manuscrit ADD CONSTRAINT FK_F4C162B560BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id)');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDA1FBEEF7B FOREIGN KEY (chapitre_id) REFERENCES chapitre (id)');
        $this->addSql('DROP TABLE product');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapitre DROP FOREIGN KEY FK_8C62B025A767B8C7');
        $this->addSql('ALTER TABLE manuscrit DROP FOREIGN KEY FK_F4C162B560BB6FE6');
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDA1FBEEF7B');
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC413261E7C023C');
        $this->addSql('ALTER TABLE cellule DROP FOREIGN KEY FK_F493DEDF166053B4');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price INT NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE acte');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE cellule');
        $this->addSql('DROP TABLE chapitre');
        $this->addSql('DROP TABLE manuscrit');
        $this->addSql('DROP TABLE scene');
    }
}
