-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : dim. 04 juin 2023 à 20:36
-- Version du serveur : 10.10.2-MariaDB
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET GLOBAL event_scheduler = ON;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `esirempire_db`
--

-- --------------------------------------------------------

-- Add API Accounts
-- # Privilèges pour `api_admin`@`%`

GRANT ALL PRIVILEGES ON *.* TO `api_admin`@`%` IDENTIFIED BY PASSWORD '*DBB69FFFDC221D3F4C82E43F253E6E11C332D741' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `esirempire\_db`.* TO `api_admin`@`%`;


-- # Privilèges pour `api_attaque`@`%`

GRANT ALL PRIVILEGES ON *.* TO `api_attaque`@`%` IDENTIFIED BY PASSWORD '*0F4F0530856CFD1FCEA313FCD1CF807011A4F23F' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `esirempire\_db`.* TO `api_attaque`@`%`;


-- # Privilèges pour `api_galaxy`@`%`

GRANT ALL PRIVILEGES ON *.* TO `api_galaxy`@`%` IDENTIFIED BY PASSWORD '*18187E82D977346C950B5A3CAEA0E9E5A838B36B' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `esirempire\_db`.* TO `api_galaxy`@`%`;


-- # Privilèges pour `api_infrastructures`@`%`

GRANT ALL PRIVILEGES ON *.* TO `api_infrastructures`@`%` IDENTIFIED BY PASSWORD '*0FAB964C9DD901D25576944E365AF0100E37B7DB' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `esirempire\_db`.* TO `api_infrastructures`@`%`;


-- # Privilèges pour `api_login`@`%`

GRANT ALL PRIVILEGES ON *.* TO `api_login`@`%` IDENTIFIED BY PASSWORD '*F054EA97B13C76D25E9756BEA75A97ADAB8AEF86' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `esirempire\_db`.* TO `api_login`@`%`;


-- # Privilèges pour `api_register`@`%`

GRANT ALL PRIVILEGES ON *.* TO `api_register`@`%` IDENTIFIED BY PASSWORD '*0F3E19CC18BD23F23B50A1A11B906346CFDE4407' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `esirempire\_db`.* TO `api_register`@`%`;


-- # Privilèges pour `api_search`@`%`

GRANT ALL PRIVILEGES ON *.* TO `api_search`@`%` IDENTIFIED BY PASSWORD '*A9726AB38CA0134CAC77E4878807AED1B213E74E' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `esirempire\_db`.* TO `api_search`@`%`;


-- # Privilèges pour `api_spacework`@`%`

GRANT ALL PRIVILEGES ON *.* TO `api_spacework`@`%` IDENTIFIED BY PASSWORD '*4E378D67613E5B1D277A5494BFF76EB889707258' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `esirempire\_db`.* TO `api_spacework`@`%`;


-- # Privilèges pour `api_vaisseau`@`%`

GRANT ALL PRIVILEGES ON *.* TO `api_vaisseau`@`%` IDENTIFIED BY PASSWORD '*1DC2E0B15435B69817BA3EA925907711AB123110' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `esirempire\_db`.* TO `api_vaisseau`@`%`;

--
-- Structure de la table `bonusressources`
--

DROP TABLE IF EXISTS `bonusressources`;
CREATE TABLE IF NOT EXISTS `bonusressources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `energie` float NOT NULL,
  `deuterium` float NOT NULL,
  `metal` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `bonusressources`
--

INSERT INTO `bonusressources` (`id`, `energie`, `deuterium`, `metal`) VALUES
(1, 0.3, -0.15, 0),
(2, 0.2, -0.1, 0.05),
(3, 0.1, -0.05, 0.1),
(4, 0.05, 0, 0.15),
(5, 0, 0, 0.2),
(6, 0, 0.1, 0.15),
(7, -0.1, 0.15, 0.1),
(8, -0.2, 0.2, 0.05),
(9, -0.3, 0.25, 0),
(10, -0.4, 0.3, -0.05);

-- --------------------------------------------------------

--
-- Structure de la table `defense`
--

DROP TABLE IF EXISTS `defense`;
CREATE TABLE IF NOT EXISTS `defense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Type_Defense` int(11) NOT NULL,
  `id_Infrastructure` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Infrastructure` (`id_Infrastructure`),
  KEY `id_Type_Defense` (`id_Type_Defense`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `defensedefaut`
--

DROP TABLE IF EXISTS `defensedefaut`;
CREATE TABLE IF NOT EXISTS `defensedefaut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cout_metal` int(11) NOT NULL,
  `cout_deuterium` int(11) NOT NULL,
  `cout_energie` int(11) DEFAULT NULL,
  `temps_construction` int(11) NOT NULL,
  `point_attaque` int(11) NOT NULL,
  `point_defense` int(11) NOT NULL,
  `id_Type_Defense` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Type_Defense` (`id_Type_Defense`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `defensedefaut`
--

INSERT INTO `defensedefaut` (`id`, `cout_metal`, `cout_deuterium`, `cout_energie`, `temps_construction`, `point_attaque`, `point_defense`, `id_Type_Defense`) VALUES
(1, 1500, 300, NULL, 10, 100, 25, 1),
(2, 5000, 1000, NULL, 40, 250, 200, 2),
(3, 10000, 5000, 1000, 60, 0, 2000, 3);

-- --------------------------------------------------------

--
-- Structure de la table `flotteattaque`
--

DROP TABLE IF EXISTS `flotteattaque`;
CREATE TABLE IF NOT EXISTS `flotteattaque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Joueur` int(11) NOT NULL,
  `id_Rapport_Combat` int(11) NOT NULL,
  `id_Vaisseaux_Combattants` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Rapport_Combat` (`id_Rapport_Combat`),
  KEY `id_Vaisseaux_Combattants` (`id_Vaisseaux_Combattants`),
  KEY `id_Joueur` (`id_Joueur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `flottedefense`
--

DROP TABLE IF EXISTS `flottedefense`;
CREATE TABLE IF NOT EXISTS `flottedefense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Joueur` int(11) NOT NULL,
  `id_Rapport_Combat` int(11) NOT NULL,
  `id_Vaisseaux_Combattants` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Rapport_Combat` (`id_Rapport_Combat`),
  KEY `id_Vaisseaux_Combattants` (`id_Vaisseaux_Combattants`),
  KEY `id_Joueur` (`id_Joueur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `galaxie`
--

DROP TABLE IF EXISTS `galaxie`;
CREATE TABLE IF NOT EXISTS `galaxie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `id_Univers` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Id_Univers` (`id_Univers`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historiqueattaque`
--

DROP TABLE IF EXISTS `historiqueattaque`;
CREATE TABLE IF NOT EXISTS `historiqueattaque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Rapport_Combat` int(11) NOT NULL,
  `id_Historique_Rapport_Combat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Rapport_Combat` (`id_Rapport_Combat`),
  KEY `id_Historique_Rapport_Combat` (`id_Historique_Rapport_Combat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historiquedefense`
--

DROP TABLE IF EXISTS `historiquedefense`;
CREATE TABLE IF NOT EXISTS `historiquedefense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Rapport_Combat` int(11) NOT NULL,
  `id_Historique_Rapport_Combat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Rapport_Combat` (`id_Rapport_Combat`),
  KEY `id_Historique_Rapport_Combat` (`id_Historique_Rapport_Combat`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historiquerapportcombat`
--

DROP TABLE IF EXISTS `historiquerapportcombat`;
CREATE TABLE IF NOT EXISTS `historiquerapportcombat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Planete` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Planete` (`id_Planete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `infraressource`
--

DROP TABLE IF EXISTS `infraressource`;
CREATE TABLE IF NOT EXISTS `infraressource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Type_Ressource` int(11) NOT NULL,
  `id_Infrastructure` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Infrastructure` (`id_Infrastructure`),
  KEY `id_Type_Ressource` (`id_Type_Ressource`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `infrastructure`
--

DROP TABLE IF EXISTS `infrastructure`;
CREATE TABLE IF NOT EXISTS `infrastructure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `niveau` int(11) DEFAULT 0,
  `id_Planete` int(11) DEFAULT NULL,
  `id_Type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `planete_id` (`id_Planete`),
  KEY `id_Type` (`id_Type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `infratechnologienecessaire`
--

DROP TABLE IF EXISTS `infratechnologienecessaire`;
CREATE TABLE IF NOT EXISTS `infratechnologienecessaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `niveau` int(11) NOT NULL DEFAULT 0,
  `id_Technologie` int(11) NOT NULL,
  `id_Type_Installation` int(11) DEFAULT NULL,
  `id_Type_Ressource` int(11) DEFAULT NULL,
  `id_Type_Defense` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Technologie` (`id_Technologie`),
  KEY `id_Type_Installation` (`id_Type_Installation`),
  KEY `id_Type_Ressource` (`id_Type_Ressource`),
  KEY `id_Type_Defense` (`id_Type_Defense`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `infratechnologienecessaire`
--

INSERT INTO `infratechnologienecessaire` (`id`, `niveau`, `id_Technologie`, `id_Type_Installation`, `id_Type_Ressource`, `id_Type_Defense`) VALUES
(1, 5, 4, 3, NULL, NULL),
(2, 10, 1, NULL, 4, NULL),
(3, 1, 2, NULL, NULL, 1),
(4, 1, 3, NULL, NULL, 2),
(5, 1, 6, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `installation`
--

DROP TABLE IF EXISTS `installation`;
CREATE TABLE IF NOT EXISTS `installation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Type_Installation` int(11) NOT NULL,
  `id_Infrastructure` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Infrastructure` (`id_Infrastructure`),
  KEY `id_Type_Installation` (`id_Type_Installation`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `installationdefaut`
--

DROP TABLE IF EXISTS `installationdefaut`;
CREATE TABLE IF NOT EXISTS `installationdefaut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cout_metal` int(11) NOT NULL,
  `cout_energie` int(11) NOT NULL,
  `temps_construction` int(11) NOT NULL,
  `id_Type_Installation` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Type_Installation` (`id_Type_Installation`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `installationdefaut`
--

INSERT INTO `installationdefaut` (`id`, `cout_metal`, `cout_energie`, `temps_construction`, `id_Type_Installation`) VALUES
(1, 1000, 500, 50, 1),
(2, 500, 500, 50, 2),
(3, 10000, 5000, 600, 3);

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE IF NOT EXISTS `joueur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `joueurunivers`
--

DROP TABLE IF EXISTS `joueurunivers`;
CREATE TABLE IF NOT EXISTS `joueurunivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Univers` int(11) DEFAULT NULL,
  `id_Joueur` int(11) DEFAULT NULL,
  `id_Ressource` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Joueur` (`id_Joueur`),
  KEY `id_Univers` (`id_Univers`) USING BTREE,
  KEY `id_Ressource` (`id_Ressource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `planete`
--

DROP TABLE IF EXISTS `planete`;
CREATE TABLE IF NOT EXISTS `planete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taille` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `id_Systeme_Solaire` int(11) DEFAULT NULL,
  `id_Bonus_Ressources` int(11) DEFAULT NULL,
  `id_Joueur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Systeme_Solaire` (`id_Systeme_Solaire`),
  KEY `id_Bonus_Ressources` (`id_Bonus_Ressources`) USING BTREE,
  KEY `id_Joueur` (`id_Joueur`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rapportcombat`
--

DROP TABLE IF EXISTS `rapportcombat`;
CREATE TABLE IF NOT EXISTS `rapportcombat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_heure` datetime DEFAULT NULL,
  `butin` varchar(255) DEFAULT NULL,
  `id_Resultat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Resultat` (`id_Resultat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ressource`
--

DROP TABLE IF EXISTS `ressource`;
CREATE TABLE IF NOT EXISTS `ressource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` float DEFAULT 1000,
  `id_Type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Ressources` (`id_Type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ressourcedefaut`
--

DROP TABLE IF EXISTS `ressourcedefaut`;
CREATE TABLE IF NOT EXISTS `ressourcedefaut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cout_metal` int(11) NOT NULL,
  `cout_energie` int(11) DEFAULT NULL,
  `cout_deuterium` int(11) DEFAULT NULL,
  `temps_construction` int(11) NOT NULL,
  `production_metal` float DEFAULT NULL,
  `production_energie` float DEFAULT NULL,
  `production_deuterium` float DEFAULT NULL,
  `id_Type_Ressource` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Type_Ressource` (`id_Type_Ressource`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `ressourcedefaut`
--

INSERT INTO `ressourcedefaut` (`id`, `cout_metal`, `cout_energie`, `cout_deuterium`, `temps_construction`, `production_metal`, `production_energie`, `production_deuterium`, `id_Type_Ressource`) VALUES
(1, 100, 10, NULL, 10, 0.05, NULL, NULL, 1),
(2, 200, 50, NULL, 25, NULL, NULL, 0.016, 2),
(3, 150, NULL, 20, 10, NULL, 0.33, NULL, 3),
(4, 5000, NULL, 2000, 120, NULL, 0.83, NULL, 4);

-- --------------------------------------------------------

--
-- Structure de la table `systemesolaire`
--

DROP TABLE IF EXISTS `systemesolaire`;
CREATE TABLE IF NOT EXISTS `systemesolaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `id_Galaxie` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Galaxie` (`id_Galaxie`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `technologie`
--

DROP TABLE IF EXISTS `technologie`;
CREATE TABLE IF NOT EXISTS `technologie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `niveau` int(11) NOT NULL DEFAULT 0,
  `id_Type` int(11) NOT NULL,
  `id_Laboratoire` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Infrastructure` (`id_Laboratoire`),
  KEY `id_Type` (`id_Type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `technologiedefaut`
--

DROP TABLE IF EXISTS `technologiedefaut`;
CREATE TABLE IF NOT EXISTS `technologiedefaut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cout_metal` int(11) DEFAULT NULL,
  `cout_deuterium` int(11) NOT NULL,
  `temps_recherche` int(11) NOT NULL,
  `id_Type_Technologie` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Type_Technologie` (`id_Type_Technologie`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `technologiedefaut`
--

INSERT INTO `technologiedefaut` (`id`, `cout_metal`, `cout_deuterium`, `temps_recherche`, `id_Type_Technologie`) VALUES
(1, NULL, 100, 4, 1),
(2, NULL, 300, 2, 2),
(3, NULL, 500, 8, 3),
(4, NULL, 1200, 1, 4),
(6, NULL, 1000, 5, 6),
(7, 500, 200, 6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `technotechnologienecessaire`
--

DROP TABLE IF EXISTS `technotechnologienecessaire`;
CREATE TABLE IF NOT EXISTS `technotechnologienecessaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `niveau` int(11) NOT NULL,
  `id_Technologie` int(11) NOT NULL,
  `id_Technologie_Necessaire` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Technologie` (`id_Technologie`),
  KEY `id_Technologie_Necessaire` (`id_Technologie_Necessaire`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `technotechnologienecessaire`
--

INSERT INTO `technotechnologienecessaire` (`id`, `niveau`, `id_Technologie`, `id_Technologie_Necessaire`) VALUES
(1, 5, 2, 1),
(2, 5, 3, 2),
(3, 8, 6, 1),
(4, 2, 6, 3);

-- --------------------------------------------------------

--
-- Structure de la table `typedefense`
--

DROP TABLE IF EXISTS `typedefense`;
CREATE TABLE IF NOT EXISTS `typedefense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('Artillerie laser','Canon a ions','Bouclier') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `typedefense`
--

INSERT INTO `typedefense` (`id`, `type`) VALUES
(1, 'Artillerie laser'),
(2, 'Canon a ions'),
(3, 'Bouclier');

-- --------------------------------------------------------

--
-- Structure de la table `typeinfraressource`
--

DROP TABLE IF EXISTS `typeinfraressource`;
CREATE TABLE IF NOT EXISTS `typeinfraressource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('Mine de metal','Synthetiseur de deuterium','Centrale solaire','Centrale a fusion') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `typeinfraressource`
--

INSERT INTO `typeinfraressource` (`id`, `type`) VALUES
(1, 'Mine de metal'),
(2, 'Synthetiseur de deuterium'),
(3, 'Centrale solaire'),
(4, 'Centrale a fusion');

-- --------------------------------------------------------

--
-- Structure de la table `typeinfrastructure`
--

DROP TABLE IF EXISTS `typeinfrastructure`;
CREATE TABLE IF NOT EXISTS `typeinfrastructure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('INSTALLATION','DEFENSE','RESSOURCE','') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `typeinfrastructure`
--

INSERT INTO `typeinfrastructure` (`id`, `type`) VALUES
(1, 'INSTALLATION'),
(2, 'DEFENSE'),
(3, 'RESSOURCE');

-- --------------------------------------------------------

--
-- Structure de la table `typeinstallation`
--

DROP TABLE IF EXISTS `typeinstallation`;
CREATE TABLE IF NOT EXISTS `typeinstallation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('Laboratoire','Chantier spatial','Usine de nanites') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `typeinstallation`
--

INSERT INTO `typeinstallation` (`id`, `type`) VALUES
(1, 'Laboratoire'),
(2, 'Chantier spatial'),
(3, 'Usine de nanites');

-- --------------------------------------------------------

--
-- Structure de la table `typeressource`
--

DROP TABLE IF EXISTS `typeressource`;
CREATE TABLE IF NOT EXISTS `typeressource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('METAL','DEUTERIUM','ENERGIE') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `typeressource`
--

INSERT INTO `typeressource` (`id`, `type`) VALUES
(1, 'METAL'),
(2, 'DEUTERIUM'),
(3, 'ENERGIE');

-- --------------------------------------------------------

--
-- Structure de la table `typeresultat`
--

DROP TABLE IF EXISTS `typeresultat`;
CREATE TABLE IF NOT EXISTS `typeresultat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resultat` enum('ATTAQUANT','DEFENSEUR','EGALITE','') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `typeresultat`
--

INSERT INTO `typeresultat` (`id`, `resultat`) VALUES
(4, 'ATTAQUANT'),
(5, 'DEFENSEUR'),
(6, 'EGALITE');

-- --------------------------------------------------------

--
-- Structure de la table `typetechnologie`
--

DROP TABLE IF EXISTS `typetechnologie`;
CREATE TABLE IF NOT EXISTS `typetechnologie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('ENERGIE','LASER','IONS','IA','ARMEMENT','BOUCLIER') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `typetechnologie`
--

INSERT INTO `typetechnologie` (`id`, `type`) VALUES
(1, 'ENERGIE'),
(2, 'LASER'),
(3, 'IONS'),
(4, 'IA'),
(5, 'ARMEMENT'),
(6, 'BOUCLIER');

-- --------------------------------------------------------

--
-- Structure de la table `typevaisseaux`
--

DROP TABLE IF EXISTS `typevaisseaux`;
CREATE TABLE IF NOT EXISTS `typevaisseaux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('CHASSEUR','CROISEUR','TRANSPORTEUR','COLONISATEUR') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `typevaisseaux`
--

INSERT INTO `typevaisseaux` (`id`, `type`) VALUES
(1, 'CHASSEUR'),
(2, 'CROISEUR'),
(3, 'TRANSPORTEUR'),
(4, 'COLONISATEUR');

-- --------------------------------------------------------

--
-- Structure de la table `univers`
--

DROP TABLE IF EXISTS `univers`;
CREATE TABLE IF NOT EXISTS `univers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vaisseau`
--

DROP TABLE IF EXISTS `vaisseau`;
CREATE TABLE IF NOT EXISTS `vaisseau` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Type` int(11) DEFAULT NULL,
  `id_Chantier_Spatial` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `id_Type` (`id_Type`),
  KEY `id_Chantier_Spatial` (`id_Chantier_Spatial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vaisseaudefaut`
--

DROP TABLE IF EXISTS `vaisseaudefaut`;
CREATE TABLE IF NOT EXISTS `vaisseaudefaut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cout_metal` int(11) NOT NULL,
  `cout_deuterium` int(11) NOT NULL,
  `temps_construction` int(11) NOT NULL,
  `point_attaque` int(11) NOT NULL,
  `point_defense` int(11) NOT NULL,
  `capacite_fret` int(11) DEFAULT NULL,
  `id_Type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Type` (`id_Type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Déchargement des données de la table `vaisseaudefaut`
--

INSERT INTO `vaisseaudefaut` (`id`, `cout_metal`, `cout_deuterium`, `temps_construction`, `point_attaque`, `point_defense`, `capacite_fret`, `id_Type`) VALUES
(1, 3000, 500, 20, 75, 50, NULL, 1),
(2, 20000, 5000, 120, 400, 150, NULL, 2),
(3, 6000, 1500, 55, 0, 50, 100000, 3),
(4, 10000, 10000, 50, 0, 50, NULL, 4);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `defense`
--
ALTER TABLE `defense`
  ADD CONSTRAINT `defense_ibfk_1` FOREIGN KEY (`id_Infrastructure`) REFERENCES `infrastructure` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `defense_ibfk_2` FOREIGN KEY (`id_Type_Defense`) REFERENCES `typedefense` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `defensedefaut`
--
ALTER TABLE `defensedefaut`
  ADD CONSTRAINT `defensedefaut_ibfk_1` FOREIGN KEY (`id_Type_Defense`) REFERENCES `typedefense` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `flotteattaque`
--
ALTER TABLE `flotteattaque`
  ADD CONSTRAINT `flotteattaque_ibfk_3` FOREIGN KEY (`id_Joueur`) REFERENCES `joueur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flotteattaque_ibfk_4` FOREIGN KEY (`id_Vaisseaux_Combattants`) REFERENCES `vaisseau` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flotteattaque_ibfk_5` FOREIGN KEY (`id_Rapport_Combat`) REFERENCES `rapportcombat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `flottedefense`
--
ALTER TABLE `flottedefense`
  ADD CONSTRAINT `flottedefense_ibfk_3` FOREIGN KEY (`id_Joueur`) REFERENCES `joueur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flottedefense_ibfk_4` FOREIGN KEY (`id_Vaisseaux_Combattants`) REFERENCES `vaisseau` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flottedefense_ibfk_5` FOREIGN KEY (`id_Rapport_Combat`) REFERENCES `rapportcombat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `galaxie`
--
ALTER TABLE `galaxie`
  ADD CONSTRAINT `galaxie_ibfk_1` FOREIGN KEY (`id_Univers`) REFERENCES `univers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `historiqueattaque`
--
ALTER TABLE `historiqueattaque`
  ADD CONSTRAINT `historiqueattaque_ibfk_2` FOREIGN KEY (`id_Rapport_Combat`) REFERENCES `rapportcombat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historiqueattaque_ibfk_3` FOREIGN KEY (`id_Historique_Rapport_Combat`) REFERENCES `historiquerapportcombat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `historiquedefense`
--
ALTER TABLE `historiquedefense`
  ADD CONSTRAINT `historiquedefense_ibfk_2` FOREIGN KEY (`id_Rapport_Combat`) REFERENCES `rapportcombat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historiquedefense_ibfk_3` FOREIGN KEY (`id_Historique_Rapport_Combat`) REFERENCES `historiquerapportcombat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `historiquerapportcombat`
--
ALTER TABLE `historiquerapportcombat`
  ADD CONSTRAINT `historiquerapportcombat_ibfk_1` FOREIGN KEY (`id_Planete`) REFERENCES `planete` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `infraressource`
--
ALTER TABLE `infraressource`
  ADD CONSTRAINT `infraressource_ibfk_1` FOREIGN KEY (`id_Infrastructure`) REFERENCES `infrastructure` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `infraressource_ibfk_2` FOREIGN KEY (`id_Type_Ressource`) REFERENCES `typeinfraressource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `infrastructure`
--
ALTER TABLE `infrastructure`
  ADD CONSTRAINT `infrastructure_ibfk_1` FOREIGN KEY (`id_Planete`) REFERENCES `planete` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `infrastructure_ibfk_2` FOREIGN KEY (`id_Type`) REFERENCES `typeinfrastructure` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `infratechnologienecessaire`
--
ALTER TABLE `infratechnologienecessaire`
  ADD CONSTRAINT `infratechnologienecessaire_ibfk_1` FOREIGN KEY (`id_Type_Defense`) REFERENCES `typedefense` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `infratechnologienecessaire_ibfk_2` FOREIGN KEY (`id_Type_Ressource`) REFERENCES `typeinfraressource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `infratechnologienecessaire_ibfk_3` FOREIGN KEY (`id_Type_Installation`) REFERENCES `typeinstallation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `infratechnologienecessaire_ibfk_4` FOREIGN KEY (`id_Technologie`) REFERENCES `typetechnologie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `installation`
--
ALTER TABLE `installation`
  ADD CONSTRAINT `installation_ibfk_1` FOREIGN KEY (`id_Infrastructure`) REFERENCES `infrastructure` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `installation_ibfk_2` FOREIGN KEY (`id_Type_Installation`) REFERENCES `typeinstallation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `installationdefaut`
--
ALTER TABLE `installationdefaut`
  ADD CONSTRAINT `installationdefaut_ibfk_1` FOREIGN KEY (`id_Type_Installation`) REFERENCES `typeinstallation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `joueurunivers`
--
ALTER TABLE `joueurunivers`
  ADD CONSTRAINT `joueurunivers_ibfk_1` FOREIGN KEY (`id_Univers`) REFERENCES `univers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joueurunivers_ibfk_2` FOREIGN KEY (`id_Joueur`) REFERENCES `joueur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joueurunivers_ibfk_3` FOREIGN KEY (`id_Ressource`) REFERENCES `ressource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `planete`
--
ALTER TABLE `planete`
  ADD CONSTRAINT `planete_ibfk_2` FOREIGN KEY (`id_Systeme_Solaire`) REFERENCES `systemesolaire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planete_ibfk_3` FOREIGN KEY (`id_Bonus_Ressources`) REFERENCES `bonusressources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planete_ibfk_4` FOREIGN KEY (`id_Joueur`) REFERENCES `joueur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rapportcombat`
--
ALTER TABLE `rapportcombat`
  ADD CONSTRAINT `rapportcombat_ibfk_1` FOREIGN KEY (`id_Resultat`) REFERENCES `typeresultat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ressource`
--
ALTER TABLE `ressource`
  ADD CONSTRAINT `ressource_ibfk_3` FOREIGN KEY (`id_Type`) REFERENCES `typeressource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ressourcedefaut`
--
ALTER TABLE `ressourcedefaut`
  ADD CONSTRAINT `ressourcedefaut_ibfk_1` FOREIGN KEY (`id_Type_Ressource`) REFERENCES `typeinfraressource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `systemesolaire`
--
ALTER TABLE `systemesolaire`
  ADD CONSTRAINT `systemesolaire_ibfk_1` FOREIGN KEY (`id_Galaxie`) REFERENCES `galaxie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `technologie`
--
ALTER TABLE `technologie`
  ADD CONSTRAINT `technologie_ibfk_3` FOREIGN KEY (`id_Type`) REFERENCES `typetechnologie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `technologie_ibfk_4` FOREIGN KEY (`id_Laboratoire`) REFERENCES `installation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `technologiedefaut`
--
ALTER TABLE `technologiedefaut`
  ADD CONSTRAINT `technologiedefaut_ibfk_1` FOREIGN KEY (`id_Type_Technologie`) REFERENCES `typetechnologie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `technotechnologienecessaire`
--
ALTER TABLE `technotechnologienecessaire`
  ADD CONSTRAINT `technotechnologienecessaire_ibfk_1` FOREIGN KEY (`id_Technologie_Necessaire`) REFERENCES `typetechnologie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `technotechnologienecessaire_ibfk_2` FOREIGN KEY (`id_Technologie`) REFERENCES `typetechnologie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vaisseau`
--
ALTER TABLE `vaisseau`
  ADD CONSTRAINT `vaisseau_ibfk_4` FOREIGN KEY (`id_Type`) REFERENCES `typevaisseaux` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vaisseau_ibfk_5` FOREIGN KEY (`id_Chantier_Spatial`) REFERENCES `installation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vaisseaudefaut`
--
ALTER TABLE `vaisseaudefaut`
  ADD CONSTRAINT `vaisseaudefaut_ibfk_1` FOREIGN KEY (`id_Type`) REFERENCES `typevaisseaux` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
