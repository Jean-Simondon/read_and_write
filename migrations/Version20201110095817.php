<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110095817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapitre DROP FOREIGN KEY FK_8C62B025A767B8C7');
        $this->addSql('ALTER TABLE manuscrit DROP FOREIGN KEY FK_F4C162B560BB6FE6');
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDA1FBEEF7B');
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC413261E7C023C');
        $this->addSql('CREATE TABLE act (id INT AUTO_INCREMENT NOT NULL, manuscript_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_AFECF544A05723D9 (manuscript_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, last_name VARCHAR(30) DEFAULT NULL, first_name VARCHAR(30) DEFAULT NULL, pen_name VARCHAR(30) DEFAULT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cell (id INT AUTO_INCREMENT NOT NULL, scene_id INT NOT NULL, text_content LONGTEXT DEFAULT NULL, audio_content VARCHAR(255) DEFAULT NULL, type VARCHAR(20) DEFAULT NULL, published TINYINT(1) NOT NULL, INDEX IDX_CB8787E2166053B4 (scene_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapter (id INT AUTO_INCREMENT NOT NULL, act_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, introduction VARCHAR(255) DEFAULT NULL, published TINYINT(1) NOT NULL, INDEX IDX_F981B52ED1A55B28 (act_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manuscript (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, abstract VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_5AF919CDF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE act ADD CONSTRAINT FK_AFECF544A05723D9 FOREIGN KEY (manuscript_id) REFERENCES manuscript (id)');
        $this->addSql('ALTER TABLE cell ADD CONSTRAINT FK_CB8787E2166053B4 FOREIGN KEY (scene_id) REFERENCES scene (id)');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52ED1A55B28 FOREIGN KEY (act_id) REFERENCES act (id)');
        $this->addSql('ALTER TABLE manuscript ADD CONSTRAINT FK_5AF919CDF675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('DROP TABLE acte');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE cellule');
        $this->addSql('DROP TABLE chapitre');
        $this->addSql('DROP TABLE manuscrit');
        $this->addSql('DROP INDEX IDX_D979EFDA1FBEEF7B ON scene');
        $this->addSql('ALTER TABLE scene CHANGE chapitre_id chapter_id INT NOT NULL, CHANGE nom title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDA579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('CREATE INDEX IDX_D979EFDA579F4768 ON scene (chapter_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52ED1A55B28');
        $this->addSql('ALTER TABLE manuscript DROP FOREIGN KEY FK_5AF919CDF675F31B');
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDA579F4768');
        $this->addSql('ALTER TABLE act DROP FOREIGN KEY FK_AFECF544A05723D9');
        $this->addSql('CREATE TABLE acte (id INT AUTO_INCREMENT NOT NULL, manuscrit_id INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_9EC413261E7C023C (manuscrit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, nom_de_plume VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mail VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cellule (id INT AUTO_INCREMENT NOT NULL, scene_id INT NOT NULL, contenu_texte LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, contenu_audio LONGBLOB DEFAULT NULL, type VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, published TINYINT(1) NOT NULL, INDEX IDX_F493DEDF166053B4 (scene_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE chapitre (id INT AUTO_INCREMENT NOT NULL, acte_id INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, introduction VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, published TINYINT(1) NOT NULL, INDEX IDX_8C62B025A767B8C7 (acte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE manuscrit (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, resume VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, genre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_F4C162B560BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC413261E7C023C FOREIGN KEY (manuscrit_id) REFERENCES manuscrit (id)');
        $this->addSql('ALTER TABLE cellule ADD CONSTRAINT FK_F493DEDF166053B4 FOREIGN KEY (scene_id) REFERENCES scene (id)');
        $this->addSql('ALTER TABLE chapitre ADD CONSTRAINT FK_8C62B025A767B8C7 FOREIGN KEY (acte_id) REFERENCES acte (id)');
        $this->addSql('ALTER TABLE manuscrit ADD CONSTRAINT FK_F4C162B560BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id)');
        $this->addSql('DROP TABLE act');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE cell');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE manuscript');
        $this->addSql('DROP INDEX IDX_D979EFDA579F4768 ON scene');
        $this->addSql('ALTER TABLE scene CHANGE chapter_id chapitre_id INT NOT NULL, CHANGE title nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDA1FBEEF7B FOREIGN KEY (chapitre_id) REFERENCES chapitre (id)');
        $this->addSql('CREATE INDEX IDX_D979EFDA1FBEEF7B ON scene (chapitre_id)');
    }
}
