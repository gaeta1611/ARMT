-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 25 mars 2018 à 14:50
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `adva`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidat`
--

DROP TABLE IF EXISTS `candidat`;
CREATE TABLE IF NOT EXISTS `candidat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) NOT NULL,
  `prenom` varchar(60) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `sexe` varchar(1) NOT NULL,
  `localite_id` int(11) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `remarques` text,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `localite` (`localite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `candidat`
--

INSERT INTO `candidat` (`id`, `nom`, `prenom`, `date_naissance`, `sexe`, `localite_id`, `telephone`, `email`, `linkedin`, `site`, `remarques`, `created_at`, `updated_at`) VALUES
(2, 'Maud', 'Jean', '1982-12-12', 'm', 1, NULL, 'jeanmaud@hotmail.com', NULL, NULL, NULL, NULL, NULL),
(3, 'Rion', 'Marc', '1920-12-13', 'm', 2, NULL, 'marcrion@hotmail.com', NULL, NULL, NULL, NULL, NULL),
(4, 'giordano', 'gaetano', '1992-11-16', 'm', 1, '0494235382', 'titeuf271@hotmail.com', NULL, NULL, NULL, NULL, '2018-01-17'),
(8, 'Giordano mcho', 'Gaetano', NULL, 'm', 2, '0445454587', 'titeuf27111@hotmail.com', 'http://www.linkedin.com', NULL, 'allez on prie', '2018-01-16', '2018-01-16'),
(10, 'Croisy', 'Eric', '1998-08-08', 'm', 2, '0494 87 7 4', 'eric@hotmail.com', NULL, NULL, NULL, '2018-01-16', '2018-02-08'),
(11, 'Pitt', 'Brad', '1975-07-08', 'm', 2, '0498 78 74 87', 'bradpitt@hotmail.com', 'http://www.linkedinbrad.com', NULL, 'lui trouver une bonne place', '2018-01-17', '2018-01-17'),
(12, 'Alonso', 'Sylvain', '1993-05-12', 'm', 1, '04978745745', 'alonso@hotmail.com', 'http://www.linkedinalonso.com', NULL, 'il est tres maniaque', '2018-01-22', '2018-03-15'),
(13, 'Alonso', 'patrick', '1985-12-20', 'm', 1, NULL, 'patrick@gmail.com', NULL, NULL, NULL, '2018-01-23', '2018-01-23'),
(14, 'Zigomar', 'Bertrand', '1980-02-15', 'm', 2, '0494235382', 'fefer@hotmail.com', NULL, NULL, NULL, '2018-02-01', '2018-02-01'),
(16, 'Dupond', 'Georges', '2018-02-09', 'm', 2, NULL, 'ttt@hotmail.com', NULL, NULL, NULL, '2018-02-08', '2018-02-08'),
(17, 'Durand', 'Bob', '2018-02-03', 'm', 2, NULL, 'bob@hotmail.com', NULL, NULL, NULL, '2018-02-14', '2018-02-14'),
(18, 'Van aken', 'Patricia', '2017-12-09', 'f', 2, '0498485221', 'paty@hotmail.com', 'http://www.linkedinrrrrr.com', 'http://www.googlepaty.com', 'cool', '2018-02-14', '2018-02-14'),
(19, 'Cabrino', 'John', '2018-02-09', 'm', 2, NULL, 'cabrino@hotmail.com', NULL, NULL, NULL, '2018-02-14', '2018-02-14'),
(20, 'Cotillard', 'Marion', '2018-02-08', 'f', 2, NULL, 'marioncot@hotmail.com', NULL, NULL, NULL, '2018-02-17', '2018-02-17'),
(21, 'Vandevoorde', 'Charles', '2018-02-08', 'm', 2, NULL, 'charles@hotmail.com', NULL, NULL, NULL, '2018-02-17', '2018-02-17'),
(22, 'Vandermeiren', 'antoine', '2018-02-08', 'm', 2, NULL, 'charleddds@hotmail.com', NULL, NULL, NULL, '2018-02-17', '2018-02-17'),
(23, 'Cools', 'Hadrien', '2018-02-15', 'm', 2, NULL, 'cools@hotmail.com', NULL, NULL, NULL, '2018-02-17', '2018-02-17'),
(24, 'djoubi', 'Otman', '2018-02-15', 'm', 2, NULL, 'othman@hotmail.com', NULL, NULL, NULL, '2018-02-17', '2018-02-17'),
(25, 'macron', 'Emmaanuel', '2018-02-09', 'm', 2, NULL, 'macron@hotmail.com', NULL, NULL, NULL, '2018-02-17', '2018-02-17'),
(26, 'bryan', 'gad', '2018-02-09', 'm', 2, NULL, 'gadon@hotmail.com', NULL, NULL, NULL, '2018-02-17', '2018-02-17'),
(27, 'bryan', 'gad', '2018-02-09', 'm', 2, NULL, 'gadeeeon@hotmail.com', NULL, NULL, NULL, '2018-02-17', '2018-02-17'),
(28, 'Delvaux', 'michael', '1980-10-15', 'm', 2, '0494235874', 'michael@hotmail.com', 'http://www.linkedinMichael.com', NULL, NULL, '2018-02-21', '2018-02-21'),
(29, 'Rubens', 'Thibault', '2018-02-16', 'm', 2, NULL, 'rubens@hotmail.com', NULL, NULL, NULL, '2018-02-21', '2018-02-22'),
(30, 'El Jebari', 'Yassine', '2018-02-03', 'm', 2, NULL, 'yassine@hotmail.com', NULL, NULL, NULL, '2018-02-21', '2018-02-21'),
(31, 'Drijpont', 'Francois', '2018-02-10', 'm', 2, NULL, 'francois@hotmail.com', NULL, NULL, NULL, '2018-02-21', '2018-02-21'),
(32, 'lorente', 'Victor', '2018-02-09', 'm', 2, NULL, 'victor@hotmail.com', NULL, NULL, NULL, '2018-02-21', '2018-02-21'),
(33, 'Bondy', 'Jameson', '2018-02-03', 'f', 2, NULL, 'bondjamess@hotmail.com', NULL, NULL, NULL, '2018-02-22', '2018-02-22'),
(34, 'Sinatra', 'Franck', '2018-02-08', 'm', 2, NULL, 'franck@hotmail.com', NULL, NULL, NULL, '2018-02-22', '2018-02-22'),
(35, 'west', 'Kenny', '2018-02-08', 'm', 2, NULL, 'kenny@hotmail.com', NULL, NULL, NULL, '2018-02-22', '2018-02-22'),
(36, 'Patrick', 'Sébastien', '1958-10-12', 'm', 2, '0494125878', 'patricksebastien@hotmail.com', 'http://www.dffrezzzz.com', 'http://www.fffffrr.com', 'il est humoriste', '2018-02-24', '2018-02-24'),
(37, 'jean', 'benoit', '2018-02-03', 'm', 2, NULL, 'jean@hotmail.com', NULL, NULL, NULL, '2018-02-24', '2018-02-24'),
(38, 'Stephane', 'Rousseaux', '1971-03-18', 'm', 2, '0494238547', 'stephanrousseaux@hotmail.com', 'http://www.linkedin/stephane.com', 'http://www.google.com', 'Il est méchant', '2018-02-26', '2018-02-26'),
(39, 'Faucoult', 'Jean-Pierre', '2018-02-17', 'm', 2, NULL, 'jean-pierre@hotmail.com', NULL, NULL, NULL, '2018-02-26', '2018-02-26'),
(40, 'Armani', 'Pierre', '1982-12-15', 'm', 2, NULL, 'pierre@hotmail.com', NULL, NULL, NULL, '2018-02-27', '2018-02-27'),
(41, 'Mahoux', 'Martin', '1992-11-16', 'm', 2, NULL, 'mahoux@hotmail.com', NULL, NULL, NULL, '2018-03-06', '2018-03-06'),
(42, 'Bernard', 'Mccartney', '2018-03-17', 'm', 2, '0494458545', 'mccartney@gmail.com', NULL, NULL, NULL, '2018-03-08', '2018-03-08'),
(43, 'De wageneer', 'Jean-Francois', '1992-05-10', 'm', 10, NULL, 'jean-francois@hotmail.com', NULL, NULL, NULL, '2018-03-25', '2018-03-25'),
(44, 'hhy', 'hyhy', NULL, 'm', 11, NULL, 'hyhehrs@hotmail.com', NULL, NULL, NULL, '2018-03-25', '2018-03-25');

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

DROP TABLE IF EXISTS `candidature`;
CREATE TABLE IF NOT EXISTS `candidature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mission_id` int(11) DEFAULT NULL,
  `candidat_id` int(11) NOT NULL,
  `postule_mission_id` int(11) DEFAULT NULL,
  `mode_candidature_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `information_candidature_id` int(11) NOT NULL DEFAULT '1',
  `mode_reponse_id` int(11) DEFAULT NULL,
  `date_reponse` date DEFAULT NULL,
  `rapport_interview_id` int(11) DEFAULT NULL,
  `remarques` text,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `candidate_already_applied_to_mission` (`candidat_id`,`postule_mission_id`) USING BTREE,
  UNIQUE KEY `candidat_already_assigned_to_mission` (`mission_id`,`candidat_id`) USING BTREE,
  KEY `mission_id` (`mission_id`),
  KEY `candidat_id` (`candidat_id`),
  KEY `status` (`status_id`),
  KEY `information_candidat` (`information_candidature_id`),
  KEY `mode_reponse` (`mode_reponse_id`),
  KEY `mode_candidature` (`mode_candidature_id`),
  KEY `postule_mission_id` (`postule_mission_id`),
  KEY `rapport_interview` (`rapport_interview_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `candidature`
--

INSERT INTO `candidature` (`id`, `mission_id`, `candidat_id`, `postule_mission_id`, `mode_candidature_id`, `status_id`, `information_candidature_id`, `mode_reponse_id`, `date_reponse`, `rapport_interview_id`, `remarques`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 1, 1, 1, 2, '2018-01-01', NULL, 'test', '2017-12-07', '2018-03-08'),
(2, 1, 3, 1, 2, 4, 3, 4, NULL, NULL, NULL, '2017-12-05', '2018-01-30'),
(3, NULL, 10, 25, 3, 1, 1, 3, NULL, NULL, NULL, '2018-01-18', '2018-01-18'),
(4, 22, 10, 55, 10, 1, 2, NULL, NULL, NULL, NULL, '2018-01-18', '2018-01-18'),
(5, 9, 8, NULL, 3, 1, 4, NULL, NULL, NULL, NULL, '2018-01-18', '2018-01-18'),
(6, 1, 10, NULL, 11, 1, 3, NULL, NULL, 96, NULL, '2018-01-20', '2018-01-20'),
(7, 1, 11, NULL, 10, 2, 1, NULL, NULL, NULL, NULL, '2018-01-20', '2018-02-12'),
(8, 57, 2, NULL, 3, 1, 1, NULL, NULL, NULL, NULL, '2018-01-21', '2018-01-21'),
(9, 11, 10, NULL, 10, 1, 1, NULL, NULL, NULL, NULL, '2018-01-22', '2018-01-22'),
(10, 81, 12, NULL, 3, 2, 1, NULL, NULL, NULL, NULL, '2018-01-03', '2018-03-10'),
(17, NULL, 12, NULL, 11, 1, 1, NULL, NULL, 170, NULL, '2018-01-23', '2018-03-10'),
(18, NULL, 12, 2, 11, 1, 1, NULL, NULL, NULL, NULL, '2018-01-23', '2018-03-10'),
(19, 6, 12, 3, 9, 1, 1, NULL, NULL, NULL, 'cool', '2018-01-23', '2018-03-08'),
(20, NULL, 11, 9, 8, 1, 1, NULL, NULL, NULL, NULL, '2018-01-23', '2018-01-23'),
(21, 57, 4, NULL, 11, 1, 1, NULL, NULL, NULL, NULL, '2018-01-23', '2018-01-23'),
(22, 57, 3, NULL, 11, 6, 1, 6, '2018-01-19', NULL, 'Il peut etre tres intéressant', '2018-01-23', '2018-02-22'),
(23, 17, 3, 6, 6, 1, 1, NULL, NULL, NULL, NULL, '2018-01-23', '2018-01-23'),
(24, 17, 12, NULL, 11, 1, 1, NULL, NULL, NULL, NULL, '2018-01-23', '2018-01-23'),
(25, 57, 11, NULL, 10, 4, 1, NULL, NULL, NULL, NULL, '2018-01-23', '2018-01-30'),
(26, NULL, 13, 3, 5, 1, 1, NULL, NULL, NULL, NULL, '2018-01-23', '2018-01-23'),
(27, 59, 3, NULL, 11, 13, 1, NULL, NULL, NULL, NULL, '2018-01-25', '2018-01-30'),
(28, 57, 10, NULL, 5, 1, 1, NULL, NULL, NULL, NULL, '2018-01-28', '2018-01-28'),
(29, 57, 13, NULL, 11, 2, 3, 2, '2018-01-31', NULL, NULL, '2018-01-31', '2018-01-31'),
(31, 27, 3, 17, 3, 1, 1, NULL, NULL, NULL, NULL, '2018-01-31', '2018-01-31'),
(32, 7, 8, NULL, 4, 1, 1, NULL, NULL, NULL, NULL, '2018-02-01', '2018-02-01'),
(33, 10, 12, NULL, 11, 1, 1, NULL, NULL, NULL, NULL, '2018-02-01', '2018-02-01'),
(34, 71, 14, 71, 3, 1, 1, NULL, NULL, NULL, NULL, '2018-02-01', '2018-02-01'),
(39, 71, 13, 71, 13, 1, 1, NULL, NULL, NULL, NULL, '2018-02-01', '2018-02-01'),
(41, 1, 14, NULL, 11, 10, 3, 3, '2018-02-01', NULL, NULL, '2018-02-01', '2018-03-25'),
(42, 71, 3, NULL, 9, 2, 1, NULL, NULL, NULL, 'il est beau', '2018-02-01', '2018-02-01'),
(43, 71, 12, NULL, 5, 1, 1, NULL, NULL, NULL, NULL, '2018-02-01', '2018-02-01'),
(44, NULL, 14, NULL, 11, 1, 1, NULL, NULL, NULL, NULL, '2018-02-01', '2018-02-01'),
(46, 26, 12, 6, 12, 1, 1, NULL, NULL, NULL, NULL, '2018-02-01', '2018-02-01'),
(47, 11, 11, 11, 8, 13, 1, NULL, NULL, NULL, NULL, '2018-02-01', '2018-02-01'),
(48, 75, 12, 75, 6, 13, 5, NULL, NULL, NULL, NULL, '2018-02-02', '2018-03-08'),
(49, 76, 12, 1, 3, 2, 2, 3, '2018-02-07', NULL, NULL, '2018-02-08', '2018-02-08'),
(50, 78, 2, 78, 3, 2, 3, 5, '2018-02-07', NULL, 'il est grand', '2018-02-08', '2018-02-08'),
(51, 1, 2, NULL, 11, 13, 6, NULL, NULL, NULL, NULL, '2018-02-08', '2018-02-12'),
(52, NULL, 12, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, '2018-02-08', '2018-02-08'),
(53, NULL, 16, NULL, 11, 1, 1, NULL, NULL, NULL, NULL, '2018-02-08', '2018-02-08'),
(58, 7, 16, 1, 13, 1, 1, NULL, NULL, NULL, NULL, '2018-02-12', '2018-02-12'),
(62, 11, 16, NULL, 8, 1, 1, NULL, NULL, NULL, NULL, '2018-02-12', '2018-02-12'),
(68, 6, 16, 2, 3, 1, 1, NULL, NULL, NULL, NULL, '2018-02-12', '2018-02-12'),
(69, 17, 29, 1, 3, 2, 1, NULL, NULL, NULL, NULL, '2018-02-28', '2018-02-28'),
(70, 82, 41, NULL, 11, 10, 3, 5, NULL, NULL, NULL, '2017-02-09', '2018-03-10'),
(71, 74, 41, NULL, 4, 1, 1, NULL, NULL, NULL, NULL, '2018-03-08', '2018-03-08'),
(72, 67, 31, NULL, 11, 2, 1, NULL, NULL, NULL, NULL, '2018-03-08', '2018-03-08'),
(73, 82, 42, 3, 3, 3, 1, NULL, NULL, NULL, NULL, '2018-03-08', '2018-03-08'),
(74, NULL, 43, NULL, 4, 1, 1, NULL, NULL, NULL, NULL, '2018-03-25', '2018-03-25');

-- --------------------------------------------------------

--
-- Structure de la table `candidat_diplome_ecole`
--

DROP TABLE IF EXISTS `candidat_diplome_ecole`;
CREATE TABLE IF NOT EXISTS `candidat_diplome_ecole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidat_id` int(11) NOT NULL,
  `diplome_ecole_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `candidat_id_2` (`candidat_id`,`diplome_ecole_id`),
  KEY `candidat_id` (`candidat_id`),
  KEY `diplome_ecole_id` (`diplome_ecole_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `candidat_diplome_ecole`
--

INSERT INTO `candidat_diplome_ecole` (`id`, `candidat_id`, `diplome_ecole_id`) VALUES
(2, 2, 3),
(3, 3, 1),
(4, 3, 2),
(1, 4, 2),
(19, 13, 1),
(20, 13, 2),
(5, 24, 1),
(6, 24, 3),
(8, 29, 1),
(7, 29, 2),
(9, 29, 3),
(10, 36, 1),
(11, 36, 2),
(15, 37, 1),
(16, 37, 3),
(21, 40, 1),
(23, 40, 2),
(25, 41, 2),
(24, 41, 4),
(26, 42, 1);

-- --------------------------------------------------------

--
-- Structure de la table `candidat_langues`
--

DROP TABLE IF EXISTS `candidat_langues`;
CREATE TABLE IF NOT EXISTS `candidat_langues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidat_id` int(11) NOT NULL,
  `langue_id` int(11) NOT NULL,
  `niveau` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `candidat_id_2` (`candidat_id`,`langue_id`),
  UNIQUE KEY `candidat_id_3` (`candidat_id`,`langue_id`),
  KEY `candidat_id` (`candidat_id`),
  KEY `langues_id` (`langue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `candidat_langues`
--

INSERT INTO `candidat_langues` (`id`, `candidat_id`, `langue_id`, `niveau`) VALUES
(1, 4, 2, 4),
(2, 4, 3, 2),
(3, 2, 4, 3),
(4, 3, 1, 5),
(5, 22, 1, 3),
(6, 22, 2, 4),
(7, 22, 5, 5),
(8, 22, 3, 2),
(9, 34, 1, 5),
(10, 34, 2, 4),
(11, 34, 3, 2),
(12, 34, 4, 1),
(13, 35, 1, 5),
(14, 35, 2, 3),
(15, 35, 3, 2),
(16, 35, 5, 4),
(17, 36, 1, 5),
(18, 36, 2, 0),
(19, 36, 3, 2),
(20, 36, 4, 4),
(21, 36, 5, 1),
(22, 37, 1, 5),
(23, 37, 2, 3),
(24, 37, 3, 1),
(25, 38, 1, 5),
(26, 38, 2, 1),
(27, 38, 3, 2),
(28, 38, 4, 4),
(29, 38, 7, 3),
(30, 39, 1, 0),
(31, 39, 2, 1),
(32, 39, 3, 2),
(33, 39, 4, 3),
(34, 39, 5, 5),
(35, 13, 1, 5),
(36, 13, 2, 4),
(37, 13, 3, 3),
(38, 40, 1, 5),
(39, 40, 2, 5),
(40, 40, 3, 5),
(41, 40, 5, 5),
(42, 41, 1, 5),
(43, 41, 2, 3),
(44, 41, 3, 4),
(45, 41, 4, 2),
(46, 42, 1, 2),
(47, 42, 2, 4),
(48, 42, 4, 3);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_entreprise` varchar(60) NOT NULL,
  `personne_contact` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `adresse` varchar(255) NOT NULL,
  `localite_id` int(10) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `tva` varchar(15) NOT NULL,
  `prospect` tinyint(1) NOT NULL COMMENT 'un prospect peut devenir client',
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `localite` (`localite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom_entreprise`, `personne_contact`, `telephone`, `email`, `adresse`, `localite_id`, `site`, `linkedin`, `tva`, `prospect`, `created_at`, `updated_at`) VALUES
(1, 'Sibelga', NULL, NULL, 'sibelga@hotmail.com', 'rue du tir, 75', 4, NULL, NULL, 'BE 458 458 548', 0, '2017-12-27', '2018-01-04'),
(2, 'Belgacom_missions', 'Gaetano Giordano', '0497878545', 'gggjjgg@hotmail.com', 'rue du marchand, 787', 9, 'http://www.google.com', 'https://www.linkedin.com', 'BE 5 525 778 7', 0, '2017-12-26', '2018-03-21'),
(3, 'flowell sprll', 'benoit jacques', NULL, 'jacques22@hotmail.com', 'rue du chateau d\'eau,69', 1, NULL, NULL, '966877758', 0, '2017-12-25', '2018-03-10'),
(4, 'Luminus_missions', 'Stephane Gerard', '0497875848', 'stephane@hotmail.com', 'Rue du belliard 78', 3, 'http://www.luminus.com', 'http://www.linkedin.com', 'BE5 455 787 987', 0, '2017-12-30', '2018-01-04'),
(5, 'Colruyt sprl', 'Marion jacques', '04985455498', 'titeuf28198@hotmail.com', 'rue du four 4598', 2, 'http://www.goyyyyyo8.com', 'http://www.df98f.com', 'Be45555777', 0, '2017-12-30', '2018-01-04'),
(20, 'Ecam', 'Jean marie', '044545', 'titeuf27888888@hotmail.com', 'place de l\'alma 45', 1, NULL, NULL, 'be55555', 0, '2018-01-04', '2018-01-05'),
(21, 'Boris', NULL, NULL, 'mail@hotmail.com', 'fgerg', 2, NULL, NULL, 'ffgf', 0, '2018-01-06', '2018-01-25'),
(25, 'gaetano giordano', 'Louis dubail', '0494235382', 'titeuf271@hotmail.com', 'rue du chateau d\'eau 69', 3, NULL, NULL, 'BE 0 45587745f', 0, '2018-01-10', '2018-03-21'),
(26, 'Sabca', 'jacques delens', '0498787485', 'sabca@gmail.com', 'rue du feu vert 58', 2, 'http://www.sabca.be', 'http://www.linkedinsabca.com', 'BE 0 45587745', 0, '2018-01-18', '2018-01-18'),
(27, 'Ryanair', 'marc betouf', '0494235382', 'marco@hotmail.com', 'rue du macoco 87', 1, 'http://www.immoweb.com', NULL, 'BE 0 45587745', 0, '2018-01-18', '2018-01-18'),
(31, 'Baseseaa', 'directeur riternoee', '049448854', 'base@hotmail.com', 'rue du marrrroz', 1, NULL, NULL, 'BE 0 45587745', 0, '2018-01-18', '2018-03-10'),
(32, 'Proximus', 'Marion jacques', '0494235382', 'proximus@hotmail.com', 'rue du franc', 1, 'http://www.belgacom.be', 'http://www.linkedinproximus.com', 'BE1545565', 0, '2018-01-25', '2018-01-25'),
(33, 'Techno Metal', 'Jea quet', '0494235382', 'tktkt@hotmail.com', 'rue du chateau d\'eau 69', 2, NULL, NULL, 'BE1222455', 0, '2018-02-01', '2018-02-01'),
(34, 'Lunch Garden', 'Marco john', '049748741', 'marcoeee@hotmail.com', 'rue du balier 45', 2, 'https://www.google.com', 'http://www.linkedineee.com', 'BE88745794', 0, '2018-02-01', '2018-02-01'),
(35, 'Nokia', 'Marie jeanne', '0494124585', 'nokia@hotmail.com', 'rue du pipantou, 45', 2, NULL, NULL, 'BE 458 458 548', 0, '2018-03-08', '2018-03-08'),
(38, 'Sezek', NULL, NULL, 'sezek@hotmail.com', 'rue du chateau d\'eau 69', 2, NULL, NULL, 'BE 0 45587745', 1, '2018-03-14', '2018-03-14'),
(39, 'Brantano', 'franck jacques', '0494125485', 'brantano@hotmail.com', 'rue du chateau d\'eau 69', 1, NULL, NULL, 'BE66655663', 0, '2018-03-21', '2018-03-21');

-- --------------------------------------------------------

--
-- Structure de la table `diplomes`
--

DROP TABLE IF EXISTS `diplomes`;
CREATE TABLE IF NOT EXISTS `diplomes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code_diplome` varchar(30) NOT NULL,
  `designation` varchar(120) NOT NULL,
  `finalite` varchar(60) NOT NULL,
  `niveau` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_diplome` (`code_diplome`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `diplomes`
--

INSERT INTO `diplomes` (`id`, `code_diplome`, `designation`, `finalite`, `niveau`) VALUES
(1, 'Ing Ind Inf', 'Ingénieur Industriel', 'Informatique', 'Master'),
(2, 'Ing Civ Em', 'Ingénieur Civil', 'Electromécanique', 'Master'),
(3, 'Ing Ind Co', 'Ingénieur Industriel', 'Construction', 'Master'),
(4, 'Ing Ind Geo', 'Ingénieur Industriel', 'Géomètre', 'master'),
(5, 'ing ind aero', 'Ingénieur Industriel', 'Aerospatial', 'stratosphere'),
(6, 'ing gest comp', 'Ingénieur de Gestion', 'comptabilité', 'stratosphere');

-- --------------------------------------------------------

--
-- Structure de la table `diplomes_ecoles`
--

DROP TABLE IF EXISTS `diplomes_ecoles`;
CREATE TABLE IF NOT EXISTS `diplomes_ecoles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `diplome_id` int(11) NOT NULL,
  `ecole_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `diplome_id` (`diplome_id`,`ecole_id`),
  UNIQUE KEY `diplome_id_2` (`diplome_id`,`ecole_id`),
  KEY `diplomes_id` (`diplome_id`),
  KEY `ecole_id` (`ecole_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `diplomes_ecoles`
--

INSERT INTO `diplomes_ecoles` (`id`, `diplome_id`, `ecole_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 5, 3),
(7, 6, 4);

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('CV','Lettre de motivation','Lettre de recommandation','Réalisation','Autre','Contrat','Job description','Rapport d''interview','Offre') NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `url_document` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `candidat_id` int(11) DEFAULT NULL,
  `mission_id` int(11) DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidat_id` (`candidat_id`),
  KEY `mission_id` (`mission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `documents`
--

INSERT INTO `documents` (`id`, `type`, `description`, `url_document`, `filename`, `candidat_id`, `mission_id`, `created_at`, `updated_at`) VALUES
(1, 'CV', NULL, 'uploads/cv/Rionafdx9.pdf', '', 3, NULL, '2018-01-08', NULL),
(2, 'Lettre de motivation', NULL, 'uploads/LM/frfrg9.pdf', '', 2, NULL, '2018-01-02', NULL),
(3, 'Contrat', NULL, 'uploads/contrats/frfr.pdf', '', NULL, NULL, '2018-01-04', NULL),
(4, 'Job description', 'francais', 'uploads/jobs/bTLWyzCXFcATxv7xjaGpkKx9Z1JmVNcoxYHL3Bwy.png', '', NULL, 22, '2018-01-11', NULL),
(5, 'Contrat', NULL, 'storage/uploads/5y0lnq408LHDlGluEmWXQQPMvFg0VYwFfoxDZ5Rp.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-06', '2018-01-06'),
(6, 'Contrat', NULL, 'public/uploads/WIX4RlgIgUfFeh8JWg8l3AXiDdGJ4srndtuDTfIq.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-06', '2018-01-06'),
(7, 'Contrat', NULL, 'public/uploads/3dtZKJbMSazpN4p0XcRmusOBwAwBUQVkEKDYEK8T.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-07', '2018-01-07'),
(8, 'Contrat', NULL, 'public/uploads/y8dNBye2sitC6Hd0VDyOGvCkaFJpAYOQh2IXU2z5.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-07', '2018-01-07'),
(9, 'Contrat', NULL, 'public/uploads/l9vXlJDdjx8RgaiiuUry7sUwzle4PRcZz5O7QjKk.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(10, 'Contrat', NULL, 'uploads/0RNTW2BGVeQEg8AD91VoXv7oJaZk2eqP5byu1LUC.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(11, 'Contrat', NULL, 'uploads/6CandlX9VXVG0jtWHYEY5XwM9sUKBBbbg6tWnmJJ.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(12, 'Contrat', NULL, 'uploads/contrats/bKhiWwA66zi6b6jF7jNhzRrbiq9fNH0CHedYu21N.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(13, 'Contrat', NULL, 'uploads/contrats/bTLWyzCXFcATxv7xjaGpkKx9Z1JmVNcoxYHL3Bwy.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(14, 'Job description', 'neerlendais', 'uploads/jobs/bTLWyzCXFcATxv7xjaGpkKx9Z1JmVNcoxYHL3Bwy.png', '', NULL, 22, '2018-01-12', NULL),
(15, 'Contrat', NULL, 'http://localhost/laravel5/public/storage/uploads/contrats/LumTkSVzJBFW66qLFWY6RsTpxcADtdvoAr3FQoVK.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(16, 'Contrat', NULL, 'http://localhost/laravel5/public/storage/uploads/contrats/KEHpVLQJZTh6kSczKDCh54poJJwjE7jyCVHzetZj.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(17, 'Contrat', NULL, 'http://localhost/laravel5/public/storage/uploads/contrats/APuzdugZqaLHmjYsfgMRhM5kUSqAI2pULpfESLXh.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(18, 'Contrat', NULL, 'http://localhost/laravel5/public/storage/uploads/contrats/JosfGd6T28bjDXSF7PSGHbWAswRm79rycJPBKFQ8.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(19, 'Job description', NULL, 'http://localhost/laravel5/public/storage/uploads/jobs/Oia7wIm1cO7c9xIiP7ZSf0yYO7i97LfgfUyTk3N6.png', 'base_de_donnee(1).PNG', NULL, 28, '2018-01-09', '2018-01-09'),
(20, 'Job description', NULL, 'http://localhost/laravel5/public/storage/uploads/jobs/sdvoIR46mF0g8o9us9atPgUEB4LDoIy72qVdxTUL.png', 'base_de_donnee(1).PNG', NULL, 28, '2018-01-09', '2018-01-09'),
(21, 'Contrat', NULL, 'http://localhost/laravel5/public/storage/uploads/contrats/jDF1vMP0xkZu7rrLcoGeZmmiRSr09BFr7btF3HWB.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(22, 'Job description', 'francais', 'http://localhost/laravel5/public/storage/uploads/jobs/CXCjYqd6AEfBWelQDW9XZHQA4jZPE0McyKQwzsMA.png', 'base_de_donnee(1).PNG', NULL, 29, '2018-01-09', '2018-01-09'),
(23, 'Job description', 'japonais', 'http://localhost/laravel5/public/storage/uploads/jobs/5ZvPBNJXLBBKtKTyBIJPv0rWMI7OApZdfbwEcs3L.png', 'base_de_donnee(1).PNG', NULL, 29, '2018-01-09', '2018-01-09'),
(24, 'Contrat', NULL, '/uploads/contrats/mbJCuQdWphkUONJZNG4N9kVBg4mrXrsLLmtqHejt.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(25, 'Job description', 'allemand', '/uploads/jobs/ceyKvK5byanrMIotRyy1jlMtQjoPUqYb5r7lv3dP.png', 'base_de_donnee(1).PNG', NULL, 30, '2018-01-09', '2018-01-09'),
(26, 'Job description', 'coreen', '/uploads/jobs/RSSLaKF7DZFlr2h9c0SX1MPbJEUW8u29VFUTe4o1.png', 'base_de_donnee(1).PNG', NULL, 30, '2018-01-09', '2018-01-09'),
(27, 'Contrat', NULL, '/uploads/contrats/hmYa5TDGWWkooIP6JT9CdkvHL7z61PaEt4GZ3Aaf.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(28, 'Job description', 'Anonyme', '/uploads/jobs/L43DHe2yczkXUwHwrlltfPNWDbZhRbYogQMlL0gO.pdf', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(29, 'Job description', 'Francais', '/uploads/jobs/pth7IHXpKav1vSkUvI8aj0sJMxFVGsUqIDX9HJx8.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(30, 'Job description', 'Neerlendais', '/uploads/jobs/7gx9JYftlGlEBJokqVYrwfgOWZK93AjCqgCzjaOr.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(31, 'Contrat', NULL, '/uploads/contrats/niJ9lXhcM85FnHsvhZtZ0cJcWfI1wEdAXyccPf1n.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(32, 'Contrat', NULL, '/uploads/contrats/OFUhGxwQeaHrGwoWdrF7AR29FaToFQDhgVBr3GDr.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(33, 'Contrat', NULL, '/uploads/contrats/TRlMWhMlndeXubOG8S0L061Wb5ctN2vPpDLgpnL0.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-09', '2018-01-09'),
(34, 'Job description', 'gg', '/uploads/jobs/yrOuIkGWfBc5NW9SHTKQwkday12UXXr2ANdc0qVm.png', 'base_de_donnee(1).PNG', NULL, 36, '2018-01-09', '2018-01-09'),
(35, 'Job description', 'rr', '/uploads/jobs/7Qru5M1RuFnHi4iSuhAv3khCr16VR4k4SvKwW7ke.png', 'base_de_donnee(1).PNG', NULL, 36, '2018-01-09', '2018-01-09'),
(36, 'Contrat', NULL, '/uploads/contrats/WASGgpmAYWtmKo5ptzAoBcFnHjXoYRfHHVzF7k2a.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(37, 'Job description', 'Arabe', '/uploads/jobs/2PexbVRKUhzjYKyLccl1b6ZlGdlRWciTuAm0smVk.png', 'base_de_donnee(1).PNG', NULL, 37, '2018-01-10', '2018-01-10'),
(38, 'Contrat', NULL, '/uploads/contrats/pTP4gmAcDouwnfGhA1pj8ViabVBJHFEzbly056K3.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(39, 'Job description', 'Irlandais', '/uploads/jobs/3QMJWQO52N4NRGCLS8ehAh72yhfQiDrM3O2KCryZ.png', 'base_de_donnee(1).PNG', NULL, 38, '2018-01-10', '2018-01-10'),
(40, 'Contrat', NULL, '/uploads/contrats/M1XOcFyyWvnOzwWbnJk5nt8vCr4Fh6JXqyhHIu1k.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(41, 'Job description', 'Irlandais', '/uploads/jobs/I8CpXydQZaWRcrw5y04IYesOhcS1wD0FEJjlR3MJ.png', 'base_de_donnee(1).PNG', NULL, 39, '2018-01-10', '2018-01-10'),
(42, 'Contrat', NULL, '/uploads/contrats/jQxMXcTumsXj4tUAAsmdvpQ0O1ohJugrmw6SrwOd.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(43, 'Job description', 'Irlandais', '/uploads/jobs/LtPVZq2EtLai6ZD1DTENQpXiNnyUupqus7ase7Iy.png', 'base_de_donnee(1).PNG', NULL, 40, '2018-01-10', '2018-01-10'),
(44, 'Contrat', NULL, '/uploads/contrats/MkD8KcsyarcXniICa7d5UmigsitZQJ7X8VYpUZwp.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(45, 'Job description', 'Irlandais', '/uploads/jobs/9SmaPntCnEyY96Ao3GlDleafYGh2aKFzZ9ZYsHEm.png', 'base_de_donnee(1).PNG', NULL, 41, '2018-01-10', '2018-01-10'),
(46, 'Contrat', NULL, '/uploads/contrats/TqH6kaq1dlwkcgAuczy0hKsohBsEgE500RGYEw8h.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(47, 'Contrat', NULL, '/uploads/contrats/oOEaTUhI5D6T6jVFctg9dtknt2dkXTMNwIb6LpjC.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(48, 'Contrat', NULL, '/uploads/contrats/Fmy8mDuOASYRarikvs7hel2772gJwuvS4gXXUdIY.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(49, 'Job description', 'Irlandais', '/uploads/jobs/AA5Xc1rQAJI2XjpxYjWkauFu86q0MXce3VJEqgIf.png', 'base_de_donnee(1).PNG', NULL, 43, '2018-01-10', '2018-01-10'),
(50, 'Contrat', NULL, '/uploads/contrats/YmYSTdKkfHwZ5PdhyVVOxXwzwGOdB5tdIhdwDKmF.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(51, 'Job description', 'Irlandais', '/uploads/jobs/VBCURxyPeCXGIhA1WMMTRtkwD4MvkOocPoykd4AF.png', 'base_de_donnee(1).PNG', NULL, 44, '2018-01-10', '2018-01-10'),
(52, 'Contrat', NULL, '/uploads/contrats/sdgjCT9NJ07y3sR4vol6WgKdvvI9pl7Z8Npns9Ls.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(53, 'Job description', 'Irlandais', '/uploads/jobs/M2V5wzjazKzuTNLPntp1Vc4fcDloNxCzuuLpv7CE.png', 'base_de_donnee(1).PNG', NULL, 45, '2018-01-10', '2018-01-10'),
(54, 'Contrat', NULL, '/uploads/contrats/fJacK1Wt8fqhIp5GaoSNqpcGKT2Crv8Dngw8OyPi.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(55, 'Job description', 'anglais', '/uploads/jobs/uBtoCwvqIxpP55Hg69h7w5xTrxW1UA7gEHkAwcMb.png', 'base_de_donnee(1).PNG', NULL, 46, '2018-01-10', '2018-01-10'),
(56, 'Job description', 'australien', '/uploads/jobs/qvp8ja1nN3X7M384dItqe6eJlPB8XX581JIgwYVL.png', 'base_de_donnee(1).PNG', NULL, 46, '2018-01-10', '2018-01-10'),
(57, 'Contrat', NULL, '/uploads/contrats/gTdrrIQHVRZvJaXT3nCsXx8zsn0YQoLmcu3TGEAh.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(58, 'Contrat', NULL, '/uploads/contrats/PuPtzxQpodQzYvLeWaGhqgm4HZiORINuW3nVt3OY.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(59, 'Job description', 'italien', '/uploads/jobs/dT313oXx4dsp0KsNhuKQgXQAo0HkkUZ1WY0jTGuv.png', 'base_de_donnee(1).PNG', NULL, 46, '2018-01-10', '2018-01-10'),
(60, 'Contrat', NULL, '/uploads/contrats/TzXq3uMsLh9FRzh6IgDswKKDAhnUmGI90JBA4NfI.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(61, 'Contrat', NULL, '/uploads/contrats/bi2xyZ1cVhy2SEVAnGM1R4Sibmxoc7kBaFx9eLp2.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(62, 'Job description', 'Ameradien', '/uploads/jobs/pTHSmIUmrKFwAJKmFhquLo0H7jeZBlpEVg9SzivE.png', 'base_de_donnee(1).PNG', NULL, 47, '2018-01-10', '2018-01-10'),
(63, 'Job description', 'irlandais', '/uploads/jobs/lquCT0iZPRLTkJ2eud5nQiFPsgCciBvuCHPBmXeV.png', 'base_de_donnee(2).PNG', NULL, 47, '2018-01-10', '2018-01-10'),
(64, 'Job description', 'francais', '/uploads/jobs/0ljke8H8ckBZxE4N4E3CgZ6ZoVpYacOhBuTNLtk0.png', 'base_de_donnee(1).PNG', NULL, 47, '2018-01-10', '2018-01-10'),
(65, 'Job description', 'allemand', '/uploads/jobs/MwoIAKWTS51nejqlnTZhIz7TTHtKtbvpCrwvwcKu.png', 'base_de_donnee(2).PNG', NULL, 47, '2018-01-10', '2018-01-10'),
(66, 'Contrat', NULL, '/uploads/contrats/LPn0vPPR8LxC8oUpS2gxojWJBioQFmkJJtAL4Nvy.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(67, 'Job description', 'anglais', '/uploads/jobs/ZSnx9YCWwldcsB9aTt3L1bm7cJY5jwhJbUQSVTl3.png', 'base_de_donnee(2).PNG', NULL, 47, '2018-01-10', '2018-01-10'),
(68, 'Contrat', NULL, '/uploads/contrats/d00K3OVwEYo601CgqAUcz8dosYG3ujOoH29F2IFj.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-10', '2018-01-10'),
(70, 'Contrat', NULL, '/uploads/contrats/VRDZxtLi58vqcpebdMoBphM1k88jPnrt3WDOvQbq.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(71, 'Contrat', NULL, '/uploads/contrats/6IQrmIOuB2ewKsax8jINSoUgTBam5xleMti8TYtU.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(72, 'Contrat', NULL, '/uploads/contrats/NORHgQyA9crND6ekXNqEE6mdkNyDQp14qOtj5RnF.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(73, 'Contrat', NULL, '/uploads/contrats/2uqLUp11oXkrvSjYdrGSgsSFfxDOuvfeUQLDw8ER.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(74, 'Contrat', NULL, '/uploads/contrats/j96Gpaj5voVn8UWd1OWtmfJLk4ZcIKdcEgSCaSaK.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(75, 'Contrat', NULL, '/uploads/contrats/MXyBKb4RABxLfZZj7q6DMfiXvuQ8hvevGcdCIuA4.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(76, 'Contrat', NULL, '/uploads/contrats/QlVikePw8xa4lCeFiwhjTlaiEjUOUw70cEL1j1wV.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(77, 'Contrat', NULL, '/uploads/contrats/XDd87mCF1wA7OuWVVTp1gcHPwpdlQQUFHnYWmYEe.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(78, 'Contrat', NULL, '/uploads/contrats/FoRqMldL5HnP2OEI6phYSNg6IAy7sXkrYvW09KyE.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(79, 'Contrat', NULL, '/uploads/contrats/9syGpaqHRTMm8ggTpedc8Au3Hq7SLGMDYPblOS3A.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(80, 'Job description', NULL, '/uploads/jobs/LWRGs0YaGbV52SuY6rheuYCUFthmYiQzU5GZHFDO.png', 'base_de_donnee(2).PNG', NULL, 53, '2018-01-15', '2018-01-15'),
(81, 'Contrat', NULL, '/uploads/contrats/e0zKcedfeOqqwF2D9luT4xKJ0uywEaCLdoNYFE0q.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(82, 'Contrat', NULL, '/uploads/contrats/tHo8WlFig1MuxlJ62AAAxrNBOqS0HtQmsKwfykNr.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(83, 'Job description', NULL, '/uploads/jobs/oCucc6KG4ViHqyTVFFR0nRB404xZLrLU4FMiECHv.png', 'base_de_donnee(2).PNG', NULL, 55, '2018-01-15', '2018-01-15'),
(84, 'Job description', 'ricoii', '/uploads/jobs/MgWMb0IcxEoBJ1fNXHyZNm3PCQGCqe3mee53fiXv.png', 'base_de_donnee(2).PNG', NULL, 55, '2018-01-15', '2018-01-15'),
(85, 'Job description', 'rrr', '/uploads/jobs/epnrMg3h4FSuq8vU0MsLZOIqvt17fbjeImr9DFvC.png', 'base_de_donnee(2).PNG', NULL, 56, '2018-01-15', '2018-01-15'),
(86, 'Job description', 'lll', '/uploads/jobs/AGIOv1XtuCbBH0hvMqQ1fZYrFugqslIVZqseb4WA.png', 'base_de_donnee(1).PNG', NULL, 56, '2018-01-15', '2018-01-15'),
(87, 'Contrat', NULL, '/uploads/contrats/85FCEZcqoVymmcI9mJFem40aPBbQfJN8bPIdEBmV.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-15', '2018-01-15'),
(94, 'Job description', 'ioi', '/uploads/jobs/96PPWvWSdWb0LfshgvdZmRuU6eP2C1tXe8HJ16GM.png', 'base_de_donnee(2).PNG', NULL, 57, '2018-01-15', '2018-01-15'),
(95, 'Contrat', NULL, '/uploads/contrats/qooXAD2a6RVKeteI8zleKIFNNrmDomzjiHde7eqW.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-19', '2018-01-19'),
(96, 'Rapport d\'interview', NULL, 'uploads/rapports/2PexbVRKUhzjYKyLccl1b6ZlGdlRWciTuAm0smVk.png', '', 10, NULL, '2018-01-03', NULL),
(97, 'Contrat', NULL, '/uploads/contrats/Q62bGAIHA6sdKGYu6jr67DVaSoYiAeINtBvBr0Ew.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-01-22', '2018-01-22'),
(99, 'Job description', 'anonyme', '/uploads/jobs/EZNu4pkxh7tbG0NbK6DtdJwmWUZxbUlEm7wD3L2n.png', 'base_de_donnee(1).PNG', NULL, 59, '2018-01-25', '2018-01-25'),
(100, 'Job description', 'anglais', '/uploads/jobs/86AfC2VEwe3SbRQzgeSjY9Cy7VmNJb0O2BDHm2t8.pdf', 'creer-pdf.pdf', NULL, 59, '2018-01-25', '2018-01-25'),
(101, 'Contrat', NULL, '/uploads/contrats/3iBJYlRjlbIf5lhwd3t2IBX38Dth8YH1gVfGFT7R.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-25', '2018-01-25'),
(102, 'Job description', 'anonyme', '/uploads/jobs/58QZKkvjLKyeE82iYJAk9eR1KJThlZ9cFewp8Nm3.png', 'base_de_donnee(1).PNG', NULL, 60, '2018-01-25', '2018-01-25'),
(104, 'Job description', 'anglais', '/uploads/jobs/02fkzmQs3e6HiQnm6ERtl6JnGMYLgFemuW5VaNVg.png', 'base_de_donnee(1).PNG', NULL, 61, '2018-01-25', '2018-01-25'),
(105, 'Job description', 'jaonais', '/uploads/jobs/uLznAkGNlnSW4r5HFn1s7Fo29WI8WF4Ye5xK5Lqa.pdf', 'creer-pdf.pdf', NULL, 61, '2018-01-25', '2018-01-25'),
(106, 'Job description', 'francais', '/uploads/jobs/RpS3DzDDkM4HMq9bAyD8lYgyA2lVDurAa3RBf1xG.pdf', 'creer-pdf.pdf', NULL, 61, '2018-01-25', '2018-01-25'),
(107, 'Offre', 'offre refusée', '/uploads/offres/3dtZKJbMSazpN4p0XcRmusOBwAwBUQVkEKDYEK8T.png', 'filename.pdf', NULL, 1, '2018-01-27', NULL),
(111, 'Job description', 'orlandais', '/uploads/jobs/6itDzO3pJuvVTSdsBJqSRCd7myTm7xV2G4SwK2wH.png', 'base_de_donnee(2).PNG', NULL, 66, '2018-01-27', '2018-01-27'),
(112, 'Contrat', NULL, '/uploads/contrats/l2zUF4M04exrsEW5RTShP9am3GAqRmb7F7yo1Sil.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-01-27', '2018-01-27'),
(114, 'Job description', 'javanais', '/uploads/jobs/G5PrDM43lNiAyOlkv67wZnDTAH2tEcJ1rQqFG3y0.pdf', 'creer-pdf.pdf', NULL, 67, '2018-01-27', '2018-01-27'),
(120, 'Job description', 'irlandais', '/uploads/jobs/RG3EosC0bhJeqtTRgZgcSqqhkaM7s5W5juj4MRDK.png', 'base_de_donnee(2).PNG', NULL, 67, '2018-01-27', '2018-01-27'),
(121, 'Offre', 'offre presque accepté', '/uploads/offres/0dT9ZxZgpOWbIkOsc1we4Y6LHSFqFmbkAD0e6Rjy.pdf', 'creer-pdf.pdf', NULL, 67, '2018-01-27', '2018-01-27'),
(123, 'Job description', NULL, '/uploads/jobs/ThRcYDQmF44BfnVqOxUYjKNoZYHVJjhfjhBYjGha.png', 'base_de_donnee(1).PNG', NULL, 68, '2018-01-27', '2018-01-27'),
(124, 'Job description', NULL, '/uploads/jobs/mH4YljikhKtV3jcrN9qxklWz4BhaBMY1C9dbLrOd.pdf', 'creer-pdf.pdf', NULL, 68, '2018-01-27', '2018-01-27'),
(127, 'Job description', 'suedois', '/uploads/jobs/FDsURyntHbBo09YHrLewdJS4L86W6W7fjpLN1q7i.png', 'base_de_donnee(2).PNG', NULL, 69, '2018-01-27', '2018-01-27'),
(128, 'Job description', 'seudois', '/uploads/jobs/7brrqGB9O2gJFxAretws2HKqGRgkm4VHKMkBHUad.png', 'base_de_donnee(2).PNG', NULL, 70, '2018-01-27', '2018-01-27'),
(131, 'Offre', 'ok', '/uploads/offres/ROaCtCC0i31xc0K3mtULSE4w6dkhbW1zA5M3RN0H.png', 'base_de_donnee(2).PNG', NULL, 70, '2018-01-27', '2018-01-27'),
(132, 'Offre', 'lol', '/uploads/offres/NiGfQ8FmV1ax6ewX4d21umQNsq0CA09IM8ZFnrl3.pdf', 'creer-pdf.pdf', NULL, 70, '2018-01-27', '2018-01-27'),
(135, 'Job description', 'kiki', '/uploads/jobs/tju5pxIpo7ZDMfxK8VsXtt2x7IA91SeEzMH4buke.pdf', 'creer-pdf.pdf', NULL, 57, '2018-01-28', '2018-01-28'),
(136, 'Job description', 'iloi', '/uploads/jobs/8M7viPf0xU98mbBrheKQkn2vBBWDw1e5xkmnMS1v.pdf', 'creer-pdf.pdf', NULL, 57, '2018-01-28', '2018-01-28'),
(137, 'Job description', 'aza', '/uploads/jobs/Dr7VLnDksKNp0uXrSPt15JWHzlFnTZN4OgiOjAwh.png', 'base_de_donnee(1).PNG', NULL, 57, '2018-01-28', '2018-01-28'),
(139, 'Offre', '12/12/2017', '/uploads/offres/s6eKYeXkcUx3JoHcGJUcNNi8YCDx4lbHtvioa2wn.pdf', 'creer-pdf.pdf', NULL, 57, '2018-01-28', '2018-01-28'),
(140, 'Offre', 'presque', '/uploads/offres/pIUMN9QEOBuH1JNwKWkkxDo1WtzBEWSlsS26QKzD.png', 'base_de_donnee(2).PNG', NULL, 57, '2018-01-28', '2018-01-28'),
(141, 'Job description', 'choco', '/uploads/jobs/UY8ALln7pQklR8cjyMeUp6EadI8rBZUuwIxKZ4os.png', 'base_de_donnee(2).PNG', NULL, 1, '2018-01-30', '2018-01-30'),
(142, 'Contrat', NULL, '/uploads/contrats/eETPBlOm9VpZz6P0aizSzanzjuKxlPyfWa2Iopoj.pdf', 'creer-pdf.pdf', NULL, NULL, '2018-02-01', '2018-02-01'),
(143, 'Job description', 'anonyme', '/uploads/jobs/Ur3MNKLmPeshwMYK5nKaRSD507cYLPjjuMdmsjCD.png', 'base_de_donnee(2).PNG', NULL, 71, '2018-02-01', '2018-02-01'),
(144, 'Job description', 'francais', '/uploads/jobs/AJOTA8wQRTbZyNdBE7BKh4Fxqgii41YZu5OssxLo.pdf', 'creer-pdf.pdf', NULL, 71, '2018-02-01', '2018-02-01'),
(145, 'Offre', '12/02/15', '/uploads/offres/jjQ604zddhKpQHMMuSoKgLDTntL8wPXt3yqtatY3.png', 'base_de_donnee(1).PNG', NULL, 71, '2018-02-01', '2018-02-01'),
(146, 'Contrat', NULL, '/uploads/contrats/tKYszz2cB98tLmj8cC5JrmchMSAqRwrHgUEh2xMw.png', 'base_de_donnee(1).PNG', NULL, NULL, '2018-02-01', '2018-02-01'),
(147, 'Job description', 'japonais', '/uploads/jobs/UIVuSkcMb2MJYnaSPT8YrpTHavWwgNb7pyCLMqwU.pdf', 'creer-pdf.pdf', NULL, 72, '2018-02-01', '2018-02-01'),
(148, 'Offre', 'a voir', '/uploads/offres/oEQA2gftTt4Hsabz5KkR2GEziWbKhbrtQbtr8SRA.pdf', 'creer-pdf.pdf', NULL, 72, '2018-02-01', '2018-02-01'),
(150, 'Job description', NULL, '/uploads/jobs/NrMyDkpdOABa0DsYGgbtI1rvh1JAfM3qh4lTs8B7.pdf', 'creer-pdf.pdf', NULL, 72, '2018-02-01', '2018-02-01'),
(152, 'Offre', 'fichier word', '/uploads/offres/ufEgRit2Kp2GLAKP3P1ihu35vuYfUzHGpEGyk1Tt.docx', 'test.docx', NULL, 68, '2018-02-01', '2018-02-01'),
(153, 'Contrat', NULL, '/uploads/contrats/uChCpStmv1zd1FhihE1faMc5xUW3PmJsWp5wnaGL.pdf', 'creer-pdf.pdf', NULL, NULL, '2018-02-01', '2018-02-01'),
(154, 'Contrat', NULL, '/uploads/contrats/yad3iwORMRTRHbXRFAftAzQIToGFQ7L9bSVDpNE0.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-02-08', '2018-02-08'),
(155, 'Job description', 'francais', '/uploads/jobs/zhgRpkJaXb3v01e0miFdRryvxyBfkkDMoNszeXOE.pdf', 'creer-pdf.pdf', NULL, 76, '2018-02-08', '2018-02-08'),
(157, 'Offre', 'a retravailer', '/uploads/offres/N2jz075Palq0LKRhjatr0dUQgyJw8MhBUqjFEIMA.pdf', 'creer-pdf.pdf', NULL, 76, '2018-02-08', '2018-02-08'),
(158, 'Contrat', NULL, '/uploads/contrats/7IlSbRxExAo8CIpxp4KEXxdnBZful1j1fGbUr0QZ.png', 'base_de_donnee(2).PNG', NULL, NULL, '2018-02-08', '2018-02-08'),
(160, 'Job description', 'neerlandais', '/uploads/jobs/Fge8IYJvIzCZP2OAqTacToU9ty25J4iPxdESsuk6.pdf', 'creer-pdf.pdf', NULL, 78, '2018-02-08', '2018-02-08'),
(161, 'Offre', 'a retravailer', '/uploads/offres/M2yv9N1zBJVFrRi71LkqPPGt4b9YE2nP40Iwbq7w.pdf', 'creer-pdf.pdf', NULL, 78, '2018-02-08', '2018-02-08'),
(164, 'Job description', 'francais', '/uploads/jobs/jocbxCUGu8uThkJ4SJiXqDt7fj8Rnr1ub8QWSoT9.png', 'diplomes_2.PNG', NULL, 82, '2018-03-08', '2018-03-08'),
(165, 'Offre', 'presque terminé', '/uploads/offres/lVGeempWLUPGRRr8dK8kOYrDaGTorZGBuQi3W5a7.png', 'diplomes_ajout_nouveau.PNG', NULL, 82, '2018-03-08', '2018-03-08'),
(166, 'Offre', 'nickel', '/uploads/offres/JAiED5EyI3QYF0ZInaeayXb3kSiHhMH6ymTzdKu1.png', 'societe_ajout.PNG', NULL, 82, '2018-03-08', '2018-03-08'),
(167, 'Job description', 'Allemand', '/uploads/jobs/e6IMrn5KEdgpaf3iEnvBt1RBhvwJ7Fh4rVwZiiUq.png', 'langues.PNG', NULL, 82, '2018-03-08', '2018-03-08'),
(168, 'Contrat', NULL, '/uploads/contrats/Uambyir9GLVZD3grhhSUFzP1JfvDhTq0dajanV81.png', 'ajouter_Candidat.PNG', NULL, NULL, '2018-03-10', '2018-03-10'),
(170, 'Rapport d\'interview', NULL, '/uploads/rapports/UPcpC3ykJwnLEITEKl8nSsYLqp3OdcgBFGbPjrXm.png', 'langues.PNG', NULL, NULL, '2018-03-10', '2018-03-10'),
(171, 'Rapport d\'interview', NULL, '/uploads/rapports/6LZTKGWXk14KKCqYPo0JmqCtqFG3jIE7zkD8WNXD.png', 'langues.PNG', NULL, NULL, '2018-03-10', '2018-03-10'),
(172, 'Rapport d\'interview', NULL, '/uploads/rapports/EFPse0Uh4r7CiGwdyxDjDmkJzdoJon5De4iJPFKh.png', 'diplomes_ajout_nouveau.PNG', NULL, NULL, '2018-03-10', '2018-03-10'),
(173, 'Rapport d\'interview', NULL, '/uploads/rapports/rvokVizYP6k1XzphOYt7pUxX1XHc557V1eb7yhbi.png', 'ajouter_Candidat.PNG', NULL, NULL, '2018-03-10', '2018-03-10'),
(174, 'Rapport d\'interview', NULL, '/uploads/rapports/JgGwysUFD23MRx5tv0Z72M5rpMQcud5vEhxUtjzc.png', 'societe_ajout.PNG', NULL, NULL, '2018-03-10', '2018-03-10'),
(175, 'Rapport d\'interview', NULL, '/uploads/rapports/YqAORmy5XRnWYY2ZgOoMtRw4IIluAM3lLCj3MQxW.png', 'diplomes_ajout_nouveau.PNG', NULL, NULL, '2018-03-10', '2018-03-10'),
(178, 'Contrat', NULL, '/uploads/contrats/NSlXHEGIl9bPNnnDVdLN4Eqa0BK8qHwKivz7G9XM.png', 'societe_ajout.PNG', NULL, NULL, '2018-03-11', '2018-03-11');

-- --------------------------------------------------------

--
-- Structure de la table `ecoles`
--

DROP TABLE IF EXISTS `ecoles`;
CREATE TABLE IF NOT EXISTS `ecoles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code_ecole` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`code_ecole`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ecoles`
--

INSERT INTO `ecoles` (`id`, `code_ecole`) VALUES
(1, 'ECAM'),
(3, 'EFPC'),
(4, 'IPF'),
(2, 'ULB');

-- --------------------------------------------------------

--
-- Structure de la table `fonctions`
--

DROP TABLE IF EXISTS `fonctions`;
CREATE TABLE IF NOT EXISTS `fonctions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fonction` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fonctions`
--

INSERT INTO `fonctions` (`id`, `fonction`) VALUES
(1, 'Ingenieur de construction'),
(2, 'Bussinnes Analyst'),
(3, 'Commercial'),
(4, 'Chef de projets'),
(7, 'Gestionnaire'),
(8, 'Fauconnier'),
(9, 'Ramonneur'),
(10, 'Cuisinier'),
(11, 'developpeur'),
(12, 'infirmiere'),
(13, 'Babysitteur'),
(14, 'carinier'),
(15, 'babiloe'),
(16, 'tratieur'),
(17, 'bussinness metier'),
(18, 'Magasinier'),
(19, 'Palefronier'),
(20, 'cedric'),
(21, 'Ingenieur agronome'),
(22, 'cocotier'),
(23, 'droguer'),
(24, 'drogueeeeer'),
(25, 'carolo'),
(26, 'mmosa'),
(27, 'rocco sifredi'),
(28, 'Chef cuisto'),
(29, 'Technicien de surface'),
(30, 'Project manager'),
(31, 'ingenieur'),
(32, 'cocotier youala'),
(33, 'carrosier'),
(34, 'nettoyeur'),
(35, 'macronier'),
(36, 'corrro'),
(37, 'fleuriste'),
(38, 'dealer'),
(39, 'snackeyr'),
(40, 'Responsable du Bureau de Dessin'),
(41, 'Serveur en salle'),
(42, 'babouin'),
(43, 'babouinn'),
(44, 'Merovingien'),
(45, 'clariste'),
(46, 'clariste entrepreneur'),
(47, 'chocolatier'),
(48, 'Gynecologue'),
(49, 'epiculteur'),
(50, 'charpentier'),
(51, 'Ingénieur de métro'),
(52, 'stage en développement web'),
(53, 'Ingenieur de construction en chantier naval'),
(54, 'Coursier');

-- --------------------------------------------------------

--
-- Structure de la table `historique_candidat`
--

DROP TABLE IF EXISTS `historique_candidat`;
CREATE TABLE IF NOT EXISTS `historique_candidat` (
  `id` int(11) DEFAULT NULL,
  `nom` varchar(60) DEFAULT NULL,
  `date_candidature` date DEFAULT NULL,
  `fonction` varchar(120) DEFAULT NULL,
  `designation` varchar(120) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `information_candidature`
--

DROP TABLE IF EXISTS `information_candidature`;
CREATE TABLE IF NOT EXISTS `information_candidature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `information_candidature`
--

INSERT INTO `information_candidature` (`id`, `information`) VALUES
(1, 'On going'),
(2, 'Info'),
(3, 'Info+JD'),
(4, 'Info+JDC'),
(5, 'Stop'),
(6, 'Merci'),
(7, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `interviews`
--

DROP TABLE IF EXISTS `interviews`;
CREATE TABLE IF NOT EXISTS `interviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidature_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `date_interview` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidature_id` (`candidature_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `interviews`
--

INSERT INTO `interviews` (`id`, `candidature_id`, `type`, `date_interview`) VALUES
(1, 1, 'F2F', '2017-11-14'),
(2, 1, 'rencontre client', '2018-01-17'),
(3, 1, '3e rencontre', '2018-01-18'),
(4, 2, 'F2F', '2018-01-27'),
(5, 22, 'F2F', '2018-01-04'),
(6, 22, '3e rencontre', '2018-01-03'),
(7, 22, 'rencontre client', '2018-01-28'),
(8, 29, 'F2F', '2018-01-18'),
(9, 29, 'rencontre client', '2018-01-11'),
(10, 69, 'rencontre client', '0002-11-12'),
(11, 69, 'rencontre client', '0022-11-12'),
(12, 69, 'rencontre client', '0002-11-01'),
(13, 69, 'rencontre client', NULL),
(14, 69, 'rencontre client', '0001-11-12'),
(15, 69, 'F2F', '0002-11-12'),
(16, 69, 'F2F', '0001-09-06'),
(17, 69, 'rencontre client', '0001-11-08');

-- --------------------------------------------------------

--
-- Structure de la table `langues`
--

DROP TABLE IF EXISTS `langues`;
CREATE TABLE IF NOT EXISTS `langues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(30) NOT NULL,
  `code_langue` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `langues`
--

INSERT INTO `langues` (`id`, `designation`, `code_langue`) VALUES
(1, 'français', 'fr'),
(2, 'néerlendais', 'nl'),
(3, 'anglais', 'en'),
(4, 'espagnol', 'es'),
(5, 'allemand', 'de'),
(6, 'russe', 'ru'),
(7, 'italien', 'it');

-- --------------------------------------------------------

--
-- Structure de la table `localites`
--

DROP TABLE IF EXISTS `localites`;
CREATE TABLE IF NOT EXISTS `localites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code_postal` varchar(10) NOT NULL,
  `localite` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `localites`
--

INSERT INTO `localites` (`id`, `code_postal`, `localite`) VALUES
(1, '1000', 'Bruxelles'),
(2, '1050', 'Ixelles'),
(3, '1180', 'Uccle'),
(4, '1190', 'Forest'),
(5, '1400', 'Nivelles'),
(6, '1348', 'Louvain-La-Neuve'),
(7, '1090', 'Jette'),
(8, '1070', 'Anderlecht'),
(9, '1200', 'Woluwe Saint Lambert'),
(10, '8400', 'Ostende'),
(11, '6400', 'Arlon');

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

DROP TABLE IF EXISTS `mission`;
CREATE TABLE IF NOT EXISTS `mission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `fonction_id` int(11) NOT NULL,
  `type_contrat_id` int(11) NOT NULL,
  `status` enum('En cours','Effectuée','Abandon','En pause','Négociation','Autre') NOT NULL DEFAULT 'En cours',
  `contrat_id` int(11) DEFAULT NULL,
  `remarques` text,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `type_contrat_id` (`type_contrat_id`),
  KEY `contrat` (`contrat_id`),
  KEY `fonction_id` (`fonction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`id`, `client_id`, `fonction_id`, `type_contrat_id`, `status`, `contrat_id`, `remarques`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 2, 'En cours', 1, NULL, '2017-12-20', NULL),
(2, 4, 4, 2, 'En cours', 1, NULL, '2018-01-04', NULL),
(3, 4, 1, 1, 'En cours', 1, NULL, '2018-01-03', NULL),
(5, 2, 1, 2, 'En cours', 5, 'La personne doit parler anglais', '2018-01-01', '2018-01-26'),
(6, 1, 1, 1, 'En cours', NULL, NULL, '2018-01-05', '2018-01-05'),
(7, 1, 30, 1, 'En cours', NULL, NULL, '2018-01-05', '2018-01-05'),
(8, 1, 1, 1, 'En cours', NULL, NULL, '2018-01-05', '2018-01-05'),
(9, 1, 9, 1, 'En cours', NULL, NULL, '2018-01-05', '2018-01-05'),
(10, 1, 1, 1, 'En cours', NULL, 'coucou', '2018-01-05', '2018-01-05'),
(11, 2, 1, 1, 'En cours', NULL, NULL, '2018-01-05', '2018-01-05'),
(17, 20, 13, 3, 'En cours', 8, NULL, '2018-01-07', '2018-02-28'),
(19, 2, 1, 1, 'En cours', 10, NULL, '2018-01-09', '2018-01-09'),
(21, 2, 35, 1, 'En cours', 12, NULL, '2018-01-09', '2018-01-09'),
(22, 2, 1, 1, 'En cours', 13, NULL, '2018-01-09', '2018-01-09'),
(24, 2, 1, 1, 'En cours', NULL, NULL, '2018-01-09', '2018-01-09'),
(25, 2, 1, 1, 'En cours', 15, 'hy', '2018-01-09', '2018-01-09'),
(26, 2, 1, 1, 'En cours', 16, 'hy', '2018-01-09', '2018-01-09'),
(27, 2, 1, 1, 'En cours', 17, 'hy', '2018-01-09', '2018-01-09'),
(28, 2, 1, 1, 'En cours', 18, 'ho', '2018-01-09', '2018-01-09'),
(29, 2, 1, 1, 'En cours', 21, 'hiii', '2018-01-09', '2018-01-09'),
(30, 2, 1, 1, 'En cours', 24, 'bonjour', '2018-01-09', '2018-01-09'),
(36, 2, 20, 1, 'Effectuée', 74, NULL, '2018-01-09', '2018-01-15'),
(37, 5, 1, 1, 'En cours', 36, NULL, '2018-01-10', '2018-01-10'),
(38, 21, 1, 2, 'En cours', 38, 'A terminer avant 2019', '2018-01-10', '2018-01-10'),
(39, 21, 1, 2, 'En cours', 40, 'A terminer avant 2019', '2018-01-10', '2018-01-10'),
(40, 21, 18, 2, 'En cours', 42, 'A terminer avant 2019', '2018-01-10', '2018-01-10'),
(41, 21, 1, 2, 'En cours', 44, 'A terminer avant 2019', '2018-01-10', '2018-01-10'),
(42, 21, 1, 2, 'En cours', 47, 'A terminer avant 2019', '2018-01-10', '2018-01-10'),
(43, 21, 1, 2, 'En cours', 48, 'A terminer avant 2019', '2018-01-10', '2018-01-10'),
(44, 21, 1, 2, 'En cours', 50, 'A terminer avant 2019', '2018-01-10', '2018-01-10'),
(45, 21, 7, 2, 'En cours', NULL, 'A terminer avant 2019', '2018-01-10', '2018-01-10'),
(46, 21, 1, 1, 'En cours', NULL, 'hoo', '2018-01-10', '2018-01-10'),
(47, 25, 1, 1, 'En cours', 95, 'petite remarquesssd', '2018-01-10', '2018-01-19'),
(48, 2, 1, 1, 'En cours', 50, 'mmm', '2018-01-15', '2018-01-15'),
(49, 2, 1, 1, 'En cours', 75, NULL, '2018-01-15', '2018-01-15'),
(50, 2, 1, 1, 'En cours', 76, NULL, '2018-01-15', '2018-01-15'),
(51, 2, 1, 1, 'En cours', 77, NULL, '2018-01-15', '2018-01-15'),
(52, 2, 32, 1, 'En cours', 78, NULL, '2018-01-15', '2018-01-15'),
(53, 2, 1, 1, 'Effectuée', 79, NULL, '2018-01-15', '2018-01-23'),
(54, 2, 1, 1, 'En cours', 81, 'remarques', '2018-01-15', '2018-01-15'),
(55, 2, 1, 1, 'En cours', 82, 'remarques', '2018-01-15', '2018-01-15'),
(56, 2, 36, 1, 'En cours', NULL, NULL, '2018-01-15', '2018-01-15'),
(57, 2, 1, 1, 'En cours', 97, 'youpiyoupiyoupiyoupiyoupiyoupiyoupivyoup', '2018-01-15', '2018-01-28'),
(58, 21, 1, 1, 'En cours', NULL, NULL, '2018-01-17', '2018-01-17'),
(59, 21, 32, 2, 'En cours', NULL, 'le client ne veut pas de gens feneant', '2018-01-25', '2018-01-25'),
(60, 32, 1, 2, 'En cours', 101, 'le client ne veut pas de personne', '2018-01-25', '2018-01-25'),
(61, 32, 1, 1, 'Effectuée', NULL, NULL, '2018-01-25', '2018-01-25'),
(63, 32, 1, 1, 'Effectuée', NULL, NULL, '2018-01-25', '2018-01-25'),
(64, 32, 24, 1, 'En cours', NULL, NULL, '2018-01-25', '2018-01-25'),
(65, 2, 1, 1, 'Abandon', NULL, NULL, '2018-01-26', '2018-01-26'),
(66, 2, 1, 1, 'En cours', NULL, NULL, '2018-01-27', '2018-01-27'),
(67, 2, 1, 1, 'En cours', 112, NULL, '2018-01-27', '2018-01-27'),
(68, 2, 43, 1, 'En cours', NULL, NULL, '2018-01-27', '2018-02-02'),
(69, 25, 1, 1, 'En cours', NULL, NULL, '2018-01-27', '2018-01-27'),
(70, 5, 1, 1, 'En cours', NULL, NULL, '2018-01-27', '2018-01-27'),
(71, 33, 1, 1, 'Effectuée', 153, 'a finir avant noel', '2018-02-01', '2018-02-01'),
(72, 34, 1, 1, 'En cours', 146, NULL, '2018-02-01', '2018-02-01'),
(73, 33, 1, 3, 'En cours', NULL, NULL, '2018-02-01', '2018-02-01'),
(74, 2, 4, 1, 'En cours', NULL, 'test fonction', '2018-02-02', '2018-02-02'),
(75, 2, 48, 1, 'En cours', NULL, 'et fonction mero', '2018-02-02', '2018-02-02'),
(76, 27, 1, 1, 'En cours', 154, NULL, '2018-02-08', '2018-02-08'),
(78, 27, 50, 2, 'En cours', 158, 'coucou fgf', '2018-02-08', '2018-02-08'),
(79, 2, 51, 1, 'En cours', NULL, NULL, '2018-02-12', '2018-02-12'),
(80, 2, 1, 2, 'En cours', NULL, NULL, '2018-02-12', '2018-02-12'),
(81, 2, 53, 1, 'En cours', 178, NULL, '2018-02-27', '2018-03-11'),
(82, 35, 54, 2, 'En cours', 168, 'attention il est sévère', '2018-03-08', '2018-03-10');

-- --------------------------------------------------------

--
-- Structure de la table `mode_candidature`
--

DROP TABLE IF EXISTS `mode_candidature`;
CREATE TABLE IF NOT EXISTS `mode_candidature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mode_candidature`
--

INSERT INTO `mode_candidature` (`id`, `media`) VALUES
(1, '{\"type\":\"Email\",\"mode\":\"Sponta\"}'),
(2, '{\"type\":\"Email\",\"mode\":\"Lié à une mission\"}'),
(3, '{\"type\":\"Push\",\"mode\":\"Stepstone\"}'),
(4, '{\"type\":\"Email\",\"mode\":\"Stepstone\"}'),
(5, '{\"type\":\"CV manager\",\"mode\":\"Stepstone\"}'),
(6, '{\"type\":\"Email\",\"mode\":\"Site adva\"}'),
(7, '{\"type\":\"Email\",\"mode\":\"Site adva/mission\"}'),
(8, '{\"type\":\"Email\",\"mode\":\"Recommandation\"}'),
(9, '{\"type\":\"DB\",\"mode\":\"Linkedin\"}'),
(10, '{\"type\":\"DB\",\"mode\":\"Stepstone\"}'),
(11, '{\"type\":\"DB\",\"mode\":\"adva\"}'),
(12, '{\"type\":\"Autres\",\"mode\":\"\"}'),
(13, '{\"type\":\"Email\",\"mode\":\"Indeed\"}');

-- --------------------------------------------------------

--
-- Structure de la table `mode_reponse`
--

DROP TABLE IF EXISTS `mode_reponse`;
CREATE TABLE IF NOT EXISTS `mode_reponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media` varchar(120) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mode_reponse`
--

INSERT INTO `mode_reponse` (`id`, `media`, `description`) VALUES
(1, 'F2F', 'Face à Face'),
(2, 'Tel EC', 'adva téléphone au candidat'),
(3, 'Tel CDT', 'candidat téléphone à adva'),
(4, 'VM EC', 'adva laisse un message vocal au candidat'),
(5, 'Mail EC', 'adva répond par mail'),
(6, 'Mail CDT', 'candidat à envoyé un mail'),
(7, 'Autre', 'autre forme de mode de réponse');

-- --------------------------------------------------------

--
-- Structure de la table `societes`
--

DROP TABLE IF EXISTS `societes`;
CREATE TABLE IF NOT EXISTS `societes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_entreprise` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `societes`
--

INSERT INTO `societes` (`id`, `nom_entreprise`) VALUES
(1, 'google'),
(2, 'facebook'),
(3, 'étudiant'),
(4, 'recherche d\'emploi'),
(5, 'Colruyt'),
(6, 'Lunch Garden');

-- --------------------------------------------------------

--
-- Structure de la table `societe_candidat`
--

DROP TABLE IF EXISTS `societe_candidat`;
CREATE TABLE IF NOT EXISTS `societe_candidat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `societe_id` int(11) NOT NULL,
  `candidat_id` int(11) NOT NULL,
  `fonction_id` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `societe_actuelle` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `societe_id` (`societe_id`),
  KEY `candidat_id` (`candidat_id`),
  KEY `fonction_id` (`fonction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `societe_candidat`
--

INSERT INTO `societe_candidat` (`id`, `societe_id`, `candidat_id`, `fonction_id`, `date_debut`, `date_fin`, `societe_actuelle`) VALUES
(1, 2, 4, 1, '2018-02-07', '2018-02-24', 1),
(2, 1, 2, 2, NULL, NULL, 1),
(3, 4, 27, NULL, NULL, NULL, 1),
(6, 4, 37, NULL, NULL, NULL, 1),
(7, 1, 37, 7, NULL, NULL, 0),
(8, 2, 37, 12, NULL, NULL, 0),
(9, 4, 39, NULL, NULL, NULL, 1),
(10, 2, 39, 50, NULL, NULL, 0),
(17, 2, 29, 51, NULL, NULL, 0),
(18, 1, 29, 48, NULL, NULL, 0),
(19, 2, 29, 43, NULL, NULL, 0),
(20, 3, 29, 50, NULL, NULL, 1),
(24, 3, 40, 52, NULL, NULL, 0),
(25, 2, 40, 48, '2018-02-01', '2018-02-24', 1),
(26, 3, 41, 52, NULL, NULL, 1),
(27, 2, 41, 8, '2018-03-16', '2018-03-25', 0),
(28, 2, 42, 54, '2018-03-11', '2018-03-29', 1);

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avancement` varchar(120) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `status`
--

INSERT INTO `status` (`id`, `avancement`, `status`) VALUES
(1, 'à traiter', 'ouvert'),
(2, 'à contacter', 'ouvert'),
(3, 'à valider', 'ouvert'),
(4, 'vu par adva', 'ouvert'),
(5, 'vu par le client', 'ouvert'),
(6, 'short listé', 'fermé'),
(7, 'candidat non intéréssé', 'fermé'),
(8, 'candidat non prévalidé', 'fermé'),
(9, 'candidat non validé par adva', 'fermé'),
(10, 'candidat non validé par client', 'fermé'),
(11, 'candidat non retenu', 'fermé'),
(12, 'candidat engagé', 'fermé'),
(13, 'Pas le bon profil', 'fermé');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `test_view`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `test_view`;
CREATE TABLE IF NOT EXISTS `test_view` (
`id` int(11)
,`type` varchar(30)
);

-- --------------------------------------------------------

--
-- Structure de la table `type_contrat`
--

DROP TABLE IF EXISTS `type_contrat`;
CREATE TABLE IF NOT EXISTS `type_contrat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `type_contrat`
--

INSERT INTO `type_contrat` (`id`, `type`) VALUES
(1, 'Retain'),
(2, 'Contingency'),
(3, 'Cadre'),
(4, 'Replace'),
(5, 'Autres');

-- --------------------------------------------------------

--
-- Structure de la vue `test_view`
--
DROP TABLE IF EXISTS `test_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `test_view`  AS  select `type_contrat`.`id` AS `id`,`type_contrat`.`type` AS `type` from `type_contrat` where (`type_contrat`.`type` = 'retain') ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `candidat`
--
ALTER TABLE `candidat`
  ADD CONSTRAINT `candidat_ibfk_1` FOREIGN KEY (`localite_id`) REFERENCES `localites` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `candidature`
--
ALTER TABLE `candidature`
  ADD CONSTRAINT `candidature_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidature_ibfk_2` FOREIGN KEY (`mode_candidature_id`) REFERENCES `mode_candidature` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidature_ibfk_3` FOREIGN KEY (`information_candidature_id`) REFERENCES `information_candidature` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidature_ibfk_4` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidature_ibfk_5` FOREIGN KEY (`candidat_id`) REFERENCES `candidat` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidature_ibfk_6` FOREIGN KEY (`mode_reponse_id`) REFERENCES `mode_reponse` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidature_ibfk_7` FOREIGN KEY (`postule_mission_id`) REFERENCES `mission` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidature_ibfk_8` FOREIGN KEY (`rapport_interview_id`) REFERENCES `documents` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `candidat_diplome_ecole`
--
ALTER TABLE `candidat_diplome_ecole`
  ADD CONSTRAINT `candidat_diplome_ecole_ibfk_1` FOREIGN KEY (`candidat_id`) REFERENCES `candidat` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidat_diplome_ecole_ibfk_2` FOREIGN KEY (`diplome_ecole_id`) REFERENCES `diplomes_ecoles` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `candidat_langues`
--
ALTER TABLE `candidat_langues`
  ADD CONSTRAINT `candidat_langues_ibfk_1` FOREIGN KEY (`langue_id`) REFERENCES `langues` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidat_langues_ibfk_2` FOREIGN KEY (`candidat_id`) REFERENCES `candidat` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`localite_id`) REFERENCES `localites` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `diplomes_ecoles`
--
ALTER TABLE `diplomes_ecoles`
  ADD CONSTRAINT `diplomes_ecoles_ibfk_1` FOREIGN KEY (`diplome_id`) REFERENCES `diplomes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `diplomes_ecoles_ibfk_2` FOREIGN KEY (`ecole_id`) REFERENCES `ecoles` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`candidat_id`) REFERENCES `candidat` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `interviews`
--
ALTER TABLE `interviews`
  ADD CONSTRAINT `interviews_ibfk_1` FOREIGN KEY (`candidature_id`) REFERENCES `candidature` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `mission`
--
ALTER TABLE `mission`
  ADD CONSTRAINT `mission_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mission_ibfk_2` FOREIGN KEY (`type_contrat_id`) REFERENCES `type_contrat` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mission_ibfk_3` FOREIGN KEY (`contrat_id`) REFERENCES `documents` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mission_ibfk_4` FOREIGN KEY (`fonction_id`) REFERENCES `fonctions` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `societe_candidat`
--
ALTER TABLE `societe_candidat`
  ADD CONSTRAINT `societe_candidat_ibfk_1` FOREIGN KEY (`candidat_id`) REFERENCES `candidat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `societe_candidat_ibfk_2` FOREIGN KEY (`societe_id`) REFERENCES `societes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `societe_candidat_ibfk_3` FOREIGN KEY (`fonction_id`) REFERENCES `fonctions` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
