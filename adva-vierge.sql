-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 31 Mars 2018 à 17:50
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE `candidat` (
  `id` int(11) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `prenom` varchar(60) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `sexe` varchar(1) NOT NULL,
  `localite_id` int(11) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `remarques` text,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

CREATE TABLE `candidature` (
  `id` int(11) NOT NULL,
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
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `candidat_diplome_ecole`
--

CREATE TABLE `candidat_diplome_ecole` (
  `id` int(11) NOT NULL,
  `candidat_id` int(11) NOT NULL,
  `diplome_ecole_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `candidat_langues`
--

CREATE TABLE `candidat_langues` (
  `id` int(11) NOT NULL,
  `candidat_id` int(11) NOT NULL,
  `langue_id` int(11) NOT NULL,
  `niveau` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
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
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `diplomes`
--

CREATE TABLE `diplomes` (
  `id` int(11) NOT NULL,
  `code_diplome` varchar(30) NOT NULL,
  `designation` varchar(120) NOT NULL,
  `finalite` varchar(60) DEFAULT NULL,
  `niveau` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `diplomes_ecoles`
--

CREATE TABLE `diplomes_ecoles` (
  `id` int(11) NOT NULL,
  `diplome_id` int(11) NOT NULL,
  `ecole_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `type` enum('CV','Lettre de motivation','Lettre de recommandation','Réalisation','Autre','Contrat','Job description','Rapport d''interview','Offre') NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `url_document` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `candidat_id` int(11) DEFAULT NULL,
  `mission_id` int(11) DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `ecoles`
--

CREATE TABLE `ecoles` (
  `id` int(11) NOT NULL,
  `code_ecole` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `fonctions`
--

CREATE TABLE `fonctions` (
  `id` int(11) NOT NULL,
  `fonction` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `information_candidature`
--

CREATE TABLE `information_candidature` (
  `id` int(11) NOT NULL,
  `information` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `information_candidature`
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

CREATE TABLE `interviews` (
  `id` int(11) NOT NULL,
  `candidature_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `date_interview` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `langues`
--

CREATE TABLE `langues` (
  `id` int(11) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `code_langue` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `langues`
--

INSERT INTO `langues` (`id`, `designation`, `code_langue`) VALUES
(1, 'français', 'fr'),
(2, 'néerlandais', 'nl'),
(3, 'anglais', 'en'),
(4, 'allemand', 'de'),
(5, 'espagnol', 'es');

-- --------------------------------------------------------

--
-- Structure de la table `localites`
--

CREATE TABLE `localites` (
  `id` int(11) NOT NULL,
  `code_postal` varchar(10) NOT NULL,
  `localite` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `localites`
--

INSERT INTO `localites` (`id`, `code_postal`, `localite`) VALUES
(1, '1000', 'Bruxelles'),
(13, '1040', 'Etterbeek'),
(2, '1050', 'Ixelles'),
(3, '1180', 'Uccle'),
(4, '1190', 'Forest'),
(10, '4000', 'Namur'),
(9, '4500', 'Huy'),
(12, '6000', 'Charleroi');

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

CREATE TABLE `mission` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `fonction_id` int(11) NOT NULL,
  `type_contrat_id` int(11) NOT NULL,
  `status` enum('En cours','Effectuée','Abandon','En pause','Négociation','Autre') NOT NULL DEFAULT 'En cours',
  `contrat_id` int(11) DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `remarques` text,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mode_candidature`
--

CREATE TABLE `mode_candidature` (
  `id` int(11) NOT NULL,
  `media` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `mode_candidature`
--

INSERT INTO `mode_candidature` (`id`, `media`) VALUES
(1, '{"type":"email","mode":"spontanné"}'),
(2, '{"type":"email","mode":"lié à une mission"}'),
(3, '{"type":"push","mode":"Stepstone"}'),
(4, '{"type":"email","mode":"Stepstone"}'),
(5, '{"type":"CV Manager","mode":"Stepstone"}'),
(6, '{"type":"email","mode":"site adva"}'),
(7, '{"type":"email","mode":"site adva /mission"}'),
(8, '{"type":"email","mode":"recommandation"}'),
(9, '{"type":"DB","mode":"LinkedIn"}'),
(10, '{"type":"DB","mode":"Stepstone"}'),
(11, '{"type":"DB","mode":"adva"}'),
(12, '{"type":"autre","mode":""}'),
(13, '{"type":"email","mode":"Indeed"}');

-- --------------------------------------------------------

--
-- Structure de la table `mode_reponse`
--

CREATE TABLE `mode_reponse` (
  `id` int(11) NOT NULL,
  `media` varchar(120) NOT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `mode_reponse`
--

INSERT INTO `mode_reponse` (`id`, `media`, `description`) VALUES
(1, 'F2F', 'Face à face'),
(2, 'Tel EC', 'adva téléphone au candidat'),
(3, 'Tel CDT', 'candidat téléphone à adva'),
(4, 'VM EC', 'adva laisse un message vocal au candidat'),
(5, 'Mail EC', 'adva répond par mail'),
(6, 'Mail Cdt', 'candidat a envoyé un mail'),
(7, 'Autre', 'autre forme de mode de réponse');

-- --------------------------------------------------------

--
-- Structure de la table `societes`
--

CREATE TABLE `societes` (
  `id` int(11) NOT NULL,
  `nom_entreprise` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Contenu de la table `societes`
--

INSERT INTO `societes` (`id`, `nom_entreprise`) VALUES
(1, 'recherche d\'emploi');

--
-- Structure de la table `societe_candidat`
--

CREATE TABLE `societe_candidat` (
  `id` int(11) NOT NULL,
  `societe_id` int(11) NOT NULL,
  `candidat_id` int(11) NOT NULL,
  `fonction_id` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `societe_actuelle` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `avancement` varchar(120) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `status`
--

INSERT INTO `status` (`id`, `avancement`, `status`) VALUES
(1, 'à traiter', 'ouvert'),
(2, 'à contacter', 'ouvert'),
(3, 'à valider', 'ouvert'),
(4, 'vu par adva', 'ouvert'),
(5, 'vu par le client', 'ouvert'),
(6, 'short listé', 'ouvert'),
(7, 'candidat non intéréssé', 'fermé'),
(8, 'candidat non prévalidé', 'fermé'),
(9, 'candidat non validé par adva', 'fermé'),
(10, 'candidat non validé par client', 'fermé'),
(11, 'candidat non retenu', 'fermé'),
(12, 'candidat engagé', 'fermé'),
(13, 'pas le bon profil', 'fermé');

-- --------------------------------------------------------

--
-- Structure de la table `type_contrat`
--

CREATE TABLE `type_contrat` (
  `id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `type_contrat`
--

INSERT INTO `type_contrat` (`id`, `type`) VALUES
(1, 'Retain'),
(2, 'Contingency'),
(3, 'Cadre'),
(4, 'Autres');

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `candidat`
--
ALTER TABLE `candidat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `localite` (`localite_id`);

--
-- Index pour la table `candidature`
--
ALTER TABLE `candidature`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidate_already_applied_to_mission` (`candidat_id`,`postule_mission_id`) USING BTREE,
  ADD UNIQUE KEY `candidate_already_assigned_to_mission` (`mission_id`,`candidat_id`) USING BTREE,
  ADD KEY `mission_id` (`mission_id`),
  ADD KEY `candidat_id` (`candidat_id`),
  ADD KEY `status` (`status_id`),
  ADD KEY `information_candidat` (`information_candidature_id`),
  ADD KEY `mode_reponse` (`mode_reponse_id`),
  ADD KEY `mode_candidature` (`mode_candidature_id`),
  ADD KEY `postule_mission_id` (`postule_mission_id`),
  ADD KEY `rapport_interview` (`rapport_interview_id`);

--
-- Index pour la table `candidat_diplome_ecole`
--
ALTER TABLE `candidat_diplome_ecole`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidat_id_2` (`candidat_id`,`diplome_ecole_id`),
  ADD KEY `candidat_id` (`candidat_id`),
  ADD KEY `diplome_ecole_id` (`diplome_ecole_id`);

--
-- Index pour la table `candidat_langues`
--
ALTER TABLE `candidat_langues`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidat_id_2` (`candidat_id`,`langue_id`),
  ADD UNIQUE KEY `candidat_id_3` (`candidat_id`,`langue_id`),
  ADD KEY `candidat_id` (`candidat_id`),
  ADD KEY `langues_id` (`langue_id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `localite` (`localite_id`);

--
-- Index pour la table `diplomes`
--
ALTER TABLE `diplomes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_diplome` (`code_diplome`);

--
-- Index pour la table `diplomes_ecoles`
--
ALTER TABLE `diplomes_ecoles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `diplome_id_2` (`diplome_id`,`ecole_id`),
  ADD UNIQUE KEY `diplome_id_3` (`diplome_id`,`ecole_id`),
  ADD KEY `diplome_id` (`diplome_id`),
  ADD KEY `ecole_id` (`ecole_id`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidat_id` (`candidat_id`),
  ADD KEY `mission_id` (`mission_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `ecoles`
--
ALTER TABLE `ecoles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`code_ecole`);

--
-- Index pour la table `fonctions`
--
ALTER TABLE `fonctions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `information_candidature`
--
ALTER TABLE `information_candidature`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `interviews`
--
ALTER TABLE `interviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidature_id` (`candidature_id`);

--
-- Index pour la table `langues`
--
ALTER TABLE `langues`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_langue` (`code_langue`);

--
-- Index pour la table `localites`
--
ALTER TABLE `localites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_postal` (`code_postal`,`localite`);

--
-- Index pour la table `mission`
--
ALTER TABLE `mission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `type_contrat_id` (`type_contrat_id`),
  ADD KEY `contrat` (`contrat_id`),
  ADD KEY `fonction_id` (`fonction_id`);

--
-- Index pour la table `mode_candidature`
--
ALTER TABLE `mode_candidature`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mode_reponse`
--
ALTER TABLE `mode_reponse`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `societes`
--
ALTER TABLE `societes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `societe_candidat`
--
ALTER TABLE `societe_candidat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `societe_id` (`societe_id`),
  ADD KEY `candidat_id` (`candidat_id`),
  ADD KEY `fonction_id` (`fonction_id`);

--
-- Index pour la table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_contrat`
--
ALTER TABLE `type_contrat`
  ADD PRIMARY KEY (`id`);

  --
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_initials_unique` (`initials`),
  ADD UNIQUE KEY `users_login_unique` (`login`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `candidat`
--
ALTER TABLE `candidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `candidature`
--
ALTER TABLE `candidature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `candidat_diplome_ecole`
--
ALTER TABLE `candidat_diplome_ecole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `candidat_langues`
--
ALTER TABLE `candidat_langues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `diplomes`
--
ALTER TABLE `diplomes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `diplomes_ecoles`
--
ALTER TABLE `diplomes_ecoles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `ecoles`
--
ALTER TABLE `ecoles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `fonctions`
--
ALTER TABLE `fonctions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `information_candidature`
--
ALTER TABLE `information_candidature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `interviews`
--
ALTER TABLE `interviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `langues`
--
ALTER TABLE `langues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `localites`
--
ALTER TABLE `localites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `mission`
--
ALTER TABLE `mission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `mode_candidature`
--
ALTER TABLE `mode_candidature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `mode_reponse`
--
ALTER TABLE `mode_reponse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `societes`
--
ALTER TABLE `societes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `societe_candidat`
--
ALTER TABLE `societe_candidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `type_contrat`
--
ALTER TABLE `type_contrat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
  
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
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
  ADD CONSTRAINT `candidat_diplome_ecole_ibfk_2` FOREIGN KEY (`candidat_id`) REFERENCES `candidat` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidat_diplome_ecole_ibfk_3` FOREIGN KEY (`diplome_ecole_id`) REFERENCES `diplomes_ecoles` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `candidat_langues`
--
ALTER TABLE `candidat_langues`
  ADD CONSTRAINT `candidat_langues_ibfk_1` FOREIGN KEY (`candidat_id`) REFERENCES `candidat` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `candidat_langues_ibfk_2` FOREIGN KEY (`langue_id`) REFERENCES `langues` (`id`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documents_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `mission_ibfk_4` FOREIGN KEY (`fonction_id`) REFERENCES `fonctions` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mission_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `societe_candidat`
--
ALTER TABLE `societe_candidat`
  ADD CONSTRAINT `societe_candidat_ibfk_1` FOREIGN KEY (`candidat_id`) REFERENCES `candidat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `societe_candidat_ibfk_2` FOREIGN KEY (`societe_id`) REFERENCES `societes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `societe_candidat_ibfk_3` FOREIGN KEY (`fonction_id`) REFERENCES `fonctions` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
