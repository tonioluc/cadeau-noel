-- ============================================
-- SCRIPT DE CRÉATION DE LA BASE DE DONNÉES
-- Site de cadeaux de Noël
-- ============================================

-- Création de la base de données (si nécessaire)
-- CREATE DATABASE IF NOT EXISTS noel_cadeaux;
-- USE noel_cadeaux;
-- Table utilisateur
CREATE TABLE utilisateur (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    solde DECIMAL(10,2) DEFAULT 0.00,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table statut_depot
CREATE TABLE statut_depot (
    id_statut_depot INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);

-- Table depot
CREATE TABLE depot (
    id_depot INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    montant_demande DECIMAL(10,2) NOT NULL,
    montant_credit DECIMAL(10,2) NOT NULL,
    commission_applique DECIMAL(5,2) NOT NULL,
    id_statut_depot INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (id_statut_depot) REFERENCES statut_depot(id_statut_depot)
);

-- Table historique_statut_depot
CREATE TABLE historique_statut_depot (
    id_historique INT AUTO_INCREMENT PRIMARY KEY,
    id_depot INT NOT NULL,
    id_statut_depot INT NOT NULL,
    date_changement DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_depot) REFERENCES depot(id_depot),
    FOREIGN KEY (id_statut_depot) REFERENCES statut_depot(id_statut_depot)
);

-- Table commission_site
CREATE TABLE commission_site (
    id_commission INT AUTO_INCREMENT PRIMARY KEY,
    id_depot INT NOT NULL,
    montant_commission DECIMAL(10,2) NOT NULL,
    date_commission DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_depot) REFERENCES depot(id_depot),
    UNIQUE(id_depot) -- Un dépôt ne génère qu'une commission
);

-- Table parametres
CREATE TABLE parametres (
    id_parametre INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL,
    description TEXT,
    valeur VARCHAR(255) NOT NULL
);

-- table historique_parametres
CREATE TABLE historique_parametres (
    id_historique_parametre INT AUTO_INCREMENT PRIMARY KEY,
    id_parametre INT NOT NULL,
    ancienne_valeur VARCHAR(255) NOT NULL,
    nouvelle_valeur VARCHAR(255) NOT NULL,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_parametre) REFERENCES parametres(id_parametre)
);

-- Table categorie_cadeau
CREATE TABLE categorie_cadeau (
    id_categorie_cadeau INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100)
);

-- Table cadeau
CREATE TABLE cadeau (
    id_cadeau INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    id_categorie_cadeau INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    chemin_image VARCHAR(255),
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categorie_cadeau) REFERENCES categorie_cadeau(id_categorie_cadeau)
);

-- Table choix_valide
CREATE TABLE choix_valide (
    id_choix INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL,
    nbr_fille INT NOT NULL,
    nbr_garcon INT NOT NULL,
    date_choix DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

-- Table detail_choix_valide
CREATE TABLE detail_choix_valide (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_choix INT NOT NULL,
    id_cadeau INT NOT NULL,
    type_enfant ENUM('FILLE', 'GARÇON') NOT NULL,
    numero_enfant INT NOT NULL,
    FOREIGN KEY (id_choix) REFERENCES choix_valide(id_choix),
    FOREIGN KEY (id_cadeau) REFERENCES cadeau(id_cadeau),
    UNIQUE(id_choix, type_enfant, numero_enfant), -- Un seul cadeau par enfant
    UNIQUE(id_choix, id_cadeau) -- Un cadeau ne peut pas être en double dans un choix
);