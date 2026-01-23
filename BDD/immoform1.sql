-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 22 jan. 2026 à 22:27
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `immoform1`
--

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

CREATE TABLE `agence` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Adresse` varchar(100) NOT NULL,
  `Telephone` varchar(20) NOT NULL,
  `ContactPrincipal_Id` int(11) NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `ContactFacturation_Id` int(11) DEFAULT NULL,
  `Adhérent` tinyint(1) NOT NULL COMMENT 'oui/non',
  `DebutContrat` date DEFAULT NULL,
  `finContrat` date DEFAULT NULL,
  `Statut` tinyint(1) NOT NULL COMMENT 'actif/inactif',
  `Region` varchar(100) NOT NULL,
  `Type` varchar(50) NOT NULL COMMENT 'indépendante, franchise, réseau',
  `NomReseau` varchar(50) DEFAULT NULL,
  `SecteurActivite` text NOT NULL COMMENT 'résidentiel, commercial, mixte, luxe, atypique, agricole, investissement, autre...',
  `NbAgents` int(11) NOT NULL,
  `NbTransactionsAn` int(11) NOT NULL,
  `Commentaire` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`Id`, `Nom`, `Adresse`, `Telephone`, `ContactPrincipal_Id`, `Mail`, `ContactFacturation_Id`, `Adhérent`, `DebutContrat`, `finContrat`, `Statut`, `Region`, `Type`, `NomReseau`, `SecteurActivite`, `NbAgents`, `NbTransactionsAn`, `Commentaire`) VALUES
(1, 'La tête dans la toile', 'Epsi', '06 00 00 00 00', 1, 'alice@epsi.com', NULL, 1, NULL, NULL, 1, 'Pays de la loire', 'Freelance', NULL, 'Informatique', 100, 100, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `conseil`
--

CREATE TABLE `conseil` (
  `Id` int(11) NOT NULL,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Demande_id` int(11) NOT NULL,
  `Duree` int(11) NOT NULL COMMENT 'en heures',
  `Date` datetime NOT NULL,
  `Cout` float NOT NULL,
  `Commentaire` text DEFAULT NULL,
  `Support` varchar(150) DEFAULT NULL COMMENT 'liens',
  `Lieu` varchar(200) NOT NULL COMMENT 'adresse, ville, code postal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `conseil`
--

INSERT INTO `conseil` (`Id`, `Titre`, `Description`, `Demande_id`, `Duree`, `Date`, `Cout`, `Commentaire`, `Support`, `Lieu`) VALUES
(1, 'Aide à la formation', 'Ceci est un conseil test', 1, 40, '2026-01-01 00:00:00', 600, NULL, NULL, 'EPSI');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Numero` char(15) DEFAULT NULL,
  `Email` varchar(50) NOT NULL,
  `Fonction` varchar(100) DEFAULT NULL,
  `PreferenceContact` varchar(50) DEFAULT NULL COMMENT 'téléphone, e-mail, autre',
  `Commentaire` text DEFAULT NULL,
  `mdp_hash` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`Id`, `Nom`, `Prenom`, `Numero`, `Email`, `Fonction`, `PreferenceContact`, `Commentaire`, `mdp_hash`) VALUES
(1, 'Bob', 'Alice', NULL, 'alice@epsi.fr', NULL, 'Email', NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `contact_agence`
--

CREATE TABLE `contact_agence` (
  `Contact_id` int(11) NOT NULL,
  `Agence_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact_agence`
--

INSERT INTO `contact_agence` (`Contact_id`, `Agence_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

CREATE TABLE `demandes` (
  `Id` int(11) NOT NULL,
  `Agence_id` int(11) NOT NULL,
  `Contact_id` int(11) NOT NULL,
  `Type` varchar(100) NOT NULL COMMENT 'stratégie commerciale, marketing, gestion d''équipe, autre...',
  `Description` text NOT NULL,
  `Date` date NOT NULL,
  `Statut` varchar(20) NOT NULL COMMENT 'en attente, annulée, terminé',
  `Formateur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demandes`
--

INSERT INTO `demandes` (`Id`, `Agence_id`, `Contact_id`, `Type`, `Description`, `Date`, `Statut`, `Formateur_id`) VALUES
(1, 1, 1, 'Demande', 'Ceci est une demande test', '2026-01-01', 'En attente', 1);

-- --------------------------------------------------------

--
-- Structure de la table `formateur`
--

CREATE TABLE `formateur` (
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Numero` char(15) DEFAULT NULL,
  `Id` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Specialite` varchar(100) DEFAULT NULL,
  `AnneeExeprience` int(11) DEFAULT NULL,
  `Commentaire` text DEFAULT NULL,
  `DebutCollab` date NOT NULL,
  `FinCollab` date DEFAULT NULL,
  `Statut` tinyint(1) NOT NULL COMMENT 'actif/inactif',
  `Certification` varchar(100) DEFAULT NULL,
  `mdp_hash` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formateur`
--

INSERT INTO `formateur` (`Nom`, `Prenom`, `Numero`, `Id`, `Email`, `Specialite`, `AnneeExeprience`, `Commentaire`, `DebutCollab`, `FinCollab`, `Statut`, `Certification`, `mdp_hash`) VALUES
('Charlie', 'David', NULL, 1, 'david@epsi.fr', NULL, NULL, NULL, '2000-01-01', NULL, 0, NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `formateur_conseil`
--

CREATE TABLE `formateur_conseil` (
  `Formateur_id` int(11) NOT NULL,
  `Conseil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formateur_conseil`
--

INSERT INTO `formateur_conseil` (`Formateur_id`, `Conseil_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `formateur_standard`
--

CREATE TABLE `formateur_standard` (
  `Formateur_id` int(11) NOT NULL,
  `Standard_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formateur_standard`
--

INSERT INTO `formateur_standard` (`Formateur_id`, `Standard_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Statut` varchar(20) NOT NULL COMMENT 'confirmée, annulée, en attente',
  `StatutPaiement` varchar(20) NOT NULL COMMENT 'payé, en attente, annulé',
  `Montant` float NOT NULL,
  `Commentaire` text DEFAULT NULL,
  `ModePaiement` varchar(50) NOT NULL COMMENT 'carte bancaire, virement, chèque, autre...'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`Id`, `Date`, `Statut`, `StatutPaiement`, `Montant`, `Commentaire`, `ModePaiement`) VALUES
(1, '2026-01-01', 'En attente', 'En attente', 100, NULL, 'CB');

-- --------------------------------------------------------

--
-- Structure de la table `inscription_agence`
--

CREATE TABLE `inscription_agence` (
  `Inscription_id` int(11) NOT NULL,
  `Agence_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription_agence`
--

INSERT INTO `inscription_agence` (`Inscription_id`, `Agence_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription_contact`
--

CREATE TABLE `inscription_contact` (
  `Inscription_id` int(11) NOT NULL,
  `Contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription_contact`
--

INSERT INTO `inscription_contact` (`Inscription_id`, `Contact_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription_online`
--

CREATE TABLE `inscription_online` (
  `Inscription_id` int(11) NOT NULL,
  `Formation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription_online`
--

INSERT INTO `inscription_online` (`Inscription_id`, `Formation_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription_standard`
--

CREATE TABLE `inscription_standard` (
  `Inscription_id` int(11) NOT NULL,
  `Formation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription_standard`
--

INSERT INTO `inscription_standard` (`Inscription_id`, `Formation_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `online`
--

CREATE TABLE `online` (
  `Id` int(11) NOT NULL,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Duree` int(11) NOT NULL COMMENT 'en heures',
  `Niveau` varchar(50) NOT NULL COMMENT 'débutant, intermédiaire, avancé',
  `DateHeure` datetime NOT NULL,
  `URL` varchar(100) NOT NULL,
  `Formateur_id` int(11) NOT NULL,
  `Secteur` varchar(150) NOT NULL COMMENT 'résidentiel, commercial, mixte, luxe, atypique, agricole, investissement, autre...'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `online`
--

INSERT INTO `online` (`Id`, `Titre`, `Description`, `Duree`, `Niveau`, `DateHeure`, `URL`, `Formateur_id`, `Secteur`) VALUES
(1, 'Les bases de données', 'Ceci est un cours de BDD', 50, 'debutant', '2026-01-01 00:00:00', 'https://google.com', 1, 'Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `standard`
--

CREATE TABLE `standard` (
  `Id` int(11) NOT NULL,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Duree` int(11) NOT NULL COMMENT 'en heures',
  `Niveau` varchar(50) NOT NULL COMMENT 'débutant, intermédiaire, avancé',
  `Secteur` varchar(150) NOT NULL COMMENT 'résidentiel, commercial, mixte, luxe, atypique, agricole, investissement, autre...',
  `PlanningDebut` datetime NOT NULL,
  `PlanningFin` datetime NOT NULL,
  `Lieu` varchar(100) NOT NULL COMMENT 'adresse, ville, code postal',
  `Capacite` int(11) NOT NULL,
  `Materiel` text DEFAULT NULL,
  `Cout` float NOT NULL,
  `Modalite` text DEFAULT NULL,
  `Commentaire` text DEFAULT NULL,
  `Support` varchar(200) DEFAULT NULL COMMENT 'liens'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `standard`
--

INSERT INTO `standard` (`Id`, `Titre`, `Description`, `Duree`, `Niveau`, `Secteur`, `PlanningDebut`, `PlanningFin`, `Lieu`, `Capacite`, `Materiel`, `Cout`, `Modalite`, `Commentaire`, `Support`) VALUES
(1, 'Cybersécurité', 'Ceci est une formation de sensibilisation à la sécurité', 40, 'intermediaire', 'Informatique', '2026-01-01 00:00:00', '2026-06-30 00:00:00', 'EPSI', 20, NULL, 250, NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agence`
--
ALTER TABLE `agence`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `agence_contact_Id_fk` (`ContactPrincipal_Id`),
  ADD KEY `agence_contact_Id_fk_2` (`ContactFacturation_Id`);

--
-- Index pour la table `conseil`
--
ALTER TABLE `conseil`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `conseil_demandeconseil_id_fk` (`Demande_id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `contact_agence`
--
ALTER TABLE `contact_agence`
  ADD KEY `Agence_id` (`Agence_id`),
  ADD KEY `Contact_id` (`Contact_id`);

--
-- Index pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `demandeconseil_agence_Id_fk` (`Agence_id`),
  ADD KEY `demandeconseil_contact_Id_fk` (`Contact_id`),
  ADD KEY `demandeconseil_formateur_Id_fk` (`Formateur_id`);

--
-- Index pour la table `formateur`
--
ALTER TABLE `formateur`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `formateur_conseil`
--
ALTER TABLE `formateur_conseil`
  ADD UNIQUE KEY `formateur/conseil_Formateur_id__uindex` (`Formateur_id`,`Conseil_id`),
  ADD KEY `association_conseil_conseil_id_fk` (`Conseil_id`),
  ADD KEY `association_conseil_formateur_Id_fk` (`Formateur_id`);

--
-- Index pour la table `formateur_standard`
--
ALTER TABLE `formateur_standard`
  ADD UNIQUE KEY `formateur/standard_Formateur_id_Standard_id_uindex` (`Formateur_id`,`Standard_id`),
  ADD KEY `association_standard_formateur_Id_fk` (`Formateur_id`),
  ADD KEY `association_standard_standard_Id_fk` (`Standard_id`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `inscription_agence`
--
ALTER TABLE `inscription_agence`
  ADD UNIQUE KEY `inscription/agence_Inscription_id_Agence_id_uindex` (`Inscription_id`,`Agence_id`),
  ADD KEY `Agence_id` (`Agence_id`);

--
-- Index pour la table `inscription_contact`
--
ALTER TABLE `inscription_contact`
  ADD UNIQUE KEY `inscription/contact_Inscription_id_Contact_id_uindex` (`Inscription_id`,`Contact_id`),
  ADD KEY `associationInscription1_inscription_id_fk` (`Inscription_id`),
  ADD KEY `Contact_id` (`Contact_id`);

--
-- Index pour la table `inscription_online`
--
ALTER TABLE `inscription_online`
  ADD KEY `association_inscription2_inscription_id_fk` (`Inscription_id`),
  ADD KEY `Formation_id` (`Formation_id`),
  ADD KEY `inscription/formation_Inscription_id_Formation_id_index` (`Inscription_id`,`Formation_id`);

--
-- Index pour la table `inscription_standard`
--
ALTER TABLE `inscription_standard`
  ADD KEY `association_inscription2_inscription_id_fk` (`Inscription_id`),
  ADD KEY `Formation_id` (`Formation_id`),
  ADD KEY `inscription/formation_Inscription_id_Formation_id_index` (`Inscription_id`,`Formation_id`);

--
-- Index pour la table `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `online_formateur_Id_fk` (`Formateur_id`);

--
-- Index pour la table `standard`
--
ALTER TABLE `standard`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agence`
--
ALTER TABLE `agence`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `conseil`
--
ALTER TABLE `conseil`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `demandes`
--
ALTER TABLE `demandes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `formateur`
--
ALTER TABLE `formateur`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `online`
--
ALTER TABLE `online`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `standard`
--
ALTER TABLE `standard`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `agence`
--
ALTER TABLE `agence`
  ADD CONSTRAINT `agence_ibfk_1` FOREIGN KEY (`ContactPrincipal_Id`) REFERENCES `contact` (`Id`),
  ADD CONSTRAINT `agence_ibfk_2` FOREIGN KEY (`ContactFacturation_Id`) REFERENCES `contact` (`Id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `conseil`
--
ALTER TABLE `conseil`
  ADD CONSTRAINT `conseil_ibfk_1` FOREIGN KEY (`Demande_id`) REFERENCES `demandes` (`Id`);

--
-- Contraintes pour la table `contact_agence`
--
ALTER TABLE `contact_agence`
  ADD CONSTRAINT `contact_agence_ibfk_1` FOREIGN KEY (`Agence_id`) REFERENCES `agence` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contact_agence_ibfk_2` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD CONSTRAINT `demandes_ibfk_1` FOREIGN KEY (`Agence_id`) REFERENCES `agence` (`Id`),
  ADD CONSTRAINT `demandes_ibfk_2` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Id`),
  ADD CONSTRAINT `demandes_ibfk_3` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`);

--
-- Contraintes pour la table `formateur_conseil`
--
ALTER TABLE `formateur_conseil`
  ADD CONSTRAINT `formateur_conseil_ibfk_1` FOREIGN KEY (`Conseil_id`) REFERENCES `conseil` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `formateur_conseil_ibfk_2` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formateur_standard`
--
ALTER TABLE `formateur_standard`
  ADD CONSTRAINT `formateur_standard_ibfk_1` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `formateur_standard_ibfk_2` FOREIGN KEY (`Standard_id`) REFERENCES `standard` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inscription_agence`
--
ALTER TABLE `inscription_agence`
  ADD CONSTRAINT `inscription_agence_ibfk_1` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscription_agence_ibfk_2` FOREIGN KEY (`Agence_id`) REFERENCES `agence` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inscription_contact`
--
ALTER TABLE `inscription_contact`
  ADD CONSTRAINT `inscription_contact_ibfk_1` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscription_contact_ibfk_2` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inscription_online`
--
ALTER TABLE `inscription_online`
  ADD CONSTRAINT `inscription_online_ibfk_1` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscription_online_ibfk_2` FOREIGN KEY (`Formation_id`) REFERENCES `online` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inscription_standard`
--
ALTER TABLE `inscription_standard`
  ADD CONSTRAINT `inscription_standard_ibfk_1` FOREIGN KEY (`Formation_id`) REFERENCES `standard` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscription_standard_ibfk_2` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `online`
--
ALTER TABLE `online`
  ADD CONSTRAINT `online_ibfk_1` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
