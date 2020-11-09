CREATE TABLE auteur (
    idauteur INT(11) AUTO_INCREMENT,
    login VARCHAR(30),
    nom VARCHAR(30),
    prenom VARCHAR(30) NULL,
    nom_de_plume VARCHAR(30) NULL,
    password VARCHAR(30),
    mail VARCHAR(30) UNIQUE,
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_auteur PRIMARY KEY (idauteur),
    CONSTRAINT nn_login_auteur CHECK (login IS NOT NULL),
    CONSTRAINT nn_nom_auteur CHECK (nom IS NOT NULL),
    CONSTRAINT nn_password_auteur CHECK (password IS NOT NULL),
    CONSTRAINT nn_mail_auteur CHECK (mail IS NOT NULL)
);

CREATE TABLE manuscrit (
    idmanuscrit INT(11) AUTO_INCREMENT,
    titre VARCHAR(30) NULL,
    4eme_de_couverture TEXT NULL,
    idauteur INT(11),
    genre VARCHAR(30) NULL,
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_manuscrit PRIMARY KEY (idmanuscrit),
    CONSTRAINT fk_idauteur_manuscrit FOREIGN KEY (idauteur) REFERENCES auteur (idauteur)
);

CREATE TABLE acte (
    idActe INT(11) AUTO_INCREMENT,
    idmanuscrit INT(11),
    nom VARCHAR(11) NULL,
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_idacte_acte PRIMARY KEY (idActe),
    CONSTRAINT fk_idmanuscrit_acte FOREIGN KEY (idmanuscrit) REFERENCES manuscrit (idmanuscrit)
);

CREATE TABLE chapitre (
    idchapitre INT(11) AUTO_INCREMENT,
    idActe INT(11),
    nom VARCHAR(11) NULL,
    introduction TEXT NULL,
    publie BOOL DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_idchapitre_chapitre PRIMARY KEY (idChapitre),
    CONSTRAINT fk_idacte_chapitre FOREIGN KEY (idActe) REFERENCES acte (idActe),
    CONSTRAINT value_publie_chapitre CHECK (publie = 0 OR publie = 1)
);

CREATE TABLE scene (
    idScene INT(11) AUTO_INCREMENT,
    idChapitre INT(11),
    nom VARCHAR(30) NULL,
    publie BOOL DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_idscene_scene PRIMARY KEY (idScene),
    CONSTRAINT fk_idchapitre_scene FOREIGN KEY (idchapitre) REFERENCES chapitre (idchapitre),
    CONSTRAINT value_publie_scene CHECK (publie = 0 OR publie = 1)
);

CREATE TABLE cellule (
    idCellule INT(11) AUTO_INCREMENT,
    idScene INT(11),
    contenu_texte TEXT NULL,
    contenu_audio BLOB NULL,
    type VARCHAR(30) NULL,
    publie BOOL DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_idcellule_cellule PRIMARY KEY (idCellule),
    CONSTRAINT fk_idscene_cellule FOREIGN KEY (idScene) REFERENCES scene (idscene),
    CONSTRAINT value_type_cellule CHECK (type = 'action' OR type = 'description' OR type = 'explication' OR type = NULL),
    CONSTRAINT value_publie_cellule CHECK (publie = 0 OR publie = 1)
);
