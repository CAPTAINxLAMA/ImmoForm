-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 11 jan. 2026 à 17:31
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
  `Adhérent` tinyint(1) NOT NULL,
  `DebutContrat` date DEFAULT NULL,
  `finContrat` date DEFAULT NULL,
  `Statut` tinyint(1) NOT NULL,
  `Region` varchar(100) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `NomReseau` varchar(50) DEFAULT NULL,
  `SecteurActivite` text NOT NULL,
  `NbAgents` int(11) NOT NULL,
  `NbTransactionsAn` int(11) NOT NULL,
  `Commentaire` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`Id`, `Nom`, `Adresse`, `Telephone`, `ContactPrincipal_Id`, `Mail`, `ContactFacturation_Id`, `Adhérent`, `DebutContrat`, `finContrat`, `Statut`, `Region`, `Type`, `NomReseau`, `SecteurActivite`, `NbAgents`, `NbTransactionsAn`, `Commentaire`) VALUES
(1, 'Agence', 'AdresseAgence', 'TelephoneAgence', 1, 'agence@mail.com', NULL, 1, NULL, NULL, 1, 'RégionAgence', 'TypeAgence', NULL, 'SecteurActivitéAgence', 100, 100, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `associationinscription`
--

CREATE TABLE `associationinscription` (
  `Agence_id` int(11) NOT NULL,
  `Inscription_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `associationinscription1`
--

CREATE TABLE `associationinscription1` (
  `Contact_id` int(11) DEFAULT NULL,
  `Inscription_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `association_conseil`
--

CREATE TABLE `association_conseil` (
  `Formateur_id` int(11) NOT NULL,
  `Conseil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `association_inscription2`
--

CREATE TABLE `association_inscription2` (
  `Inscription_id` int(11) NOT NULL,
  `Formation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `association_standard`
--

CREATE TABLE `association_standard` (
  `Formateur_id` int(11) DEFAULT NULL,
  `Standard_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `association_standard`
--

INSERT INTO `association_standard` (`Formateur_id`, `Standard_id`) VALUES
(1, 6),
(2, 6);

-- --------------------------------------------------------

--
-- Structure de la table `association_standard1`
--

CREATE TABLE `association_standard1` (
  `Standard_id` int(11) NOT NULL,
  `Inscription_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `conseil`
--

CREATE TABLE `conseil` (
  `Id` int(11) NOT NULL,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Demande_Id` int(11) NOT NULL,
  `Duree` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `Formateur_Id` int(11) NOT NULL,
  `Cout` float NOT NULL,
  `Commentaire` text DEFAULT NULL,
  `Support` varchar(150) DEFAULT NULL,
  `Lieu` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `conseil`
--

INSERT INTO `conseil` (`Id`, `Titre`, `Description`, `Demande_Id`, `Duree`, `Date`, `Formateur_Id`, `Cout`, `Commentaire`, `Support`, `Lieu`) VALUES
(1, 'TitreConseil', 'DescriptionConseil', 1, 1200, '0000-00-00 00:00:00', 1, 50, 'CommentaireConseil', 'SupportConseil', 'LieuConseil');

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
  `PreferenceContact` varchar(50) DEFAULT NULL,
  `Commentaire` text DEFAULT NULL,
  `Agence_Id` int(11) NOT NULL,
  `mdp` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`Id`, `Nom`, `Prenom`, `Numero`, `Email`, `Fonction`, `PreferenceContact`, `Commentaire`, `Agence_Id`, `mdp`) VALUES
(1, 'epsi', 'client', NULL, 'client@io', '', 'Email', '', 0, '$2y$10$dvAS/Zq4w1zoK0Xym1Lsr.Nb65qvUs6xHTxjfGBlVtZFr4wjUxIM2');

-- --------------------------------------------------------

--
-- Structure de la table `demandeconseil`
--

CREATE TABLE `demandeconseil` (
  `Id` int(11) NOT NULL,
  `Agence_Id` int(11) NOT NULL,
  `Contact_Id` int(11) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Date` date NOT NULL,
  `Statut` varchar(20) NOT NULL,
  `Formateur_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demandeconseil`
--

INSERT INTO `demandeconseil` (`Id`, `Agence_Id`, `Contact_Id`, `Type`, `Description`, `Date`, `Statut`, `Formateur_Id`) VALUES
(10, 1, 1, 'Conseil', 'Conseil PLS PLS PLS', '0000-00-00', 'Accepté', 1),
(12, 1, 1, 'Conseil', 'Conseil PLS PLS PLS', '0000-00-00', 'Refusé', 1),
(17, 1, 1, 'Conseil', 'dd', '2026-01-09', 'En attente', NULL),
(18, 1, 1, 'Formation', 'aze', '2026-01-09', 'Accepté', 1),
(19, 1, 1, 'Formation', 'je veux que ça marche', '2026-01-11', 'Accepté', 1),
(20, 1, 1, 'Formation', 'là aussi', '2026-01-11', 'Accepté', 1),
(21, 1, 1, 'Formation', 'encore', '2026-01-11', 'Accepté', 1),
(22, 1, 1, 'Formation', 'et encore', '2026-01-11', 'Accepté', 1);

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
  `Statut` tinyint(1) NOT NULL,
  `Certification` varchar(100) DEFAULT NULL,
  `mdp` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formateur`
--

INSERT INTO `formateur` (`Nom`, `Prenom`, `Numero`, `Id`, `Email`, `Specialite`, `AnneeExeprience`, `Commentaire`, `DebutCollab`, `FinCollab`, `Statut`, `Certification`, `mdp`) VALUES
('epsi', 'admin', NULL, 1, 'admin@io', NULL, NULL, NULL, '0000-00-00', NULL, 0, NULL, '$2y$10$h80k8y02ktJf.PthAlb4cO174RzGPeAgo/L/WTCse0uhn.DlWJZFm'),
('epsi1', 'admin', NULL, 2, 'admin@io', NULL, NULL, NULL, '0000-00-00', NULL, 0, NULL, '$2y$10$h80k8y02ktJf.PthAlb4cO174RzGPeAgo/L/WTCse0uhn.DlWJZFm');

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `Id` int(11) NOT NULL,
  `Agence_Id` int(11) NOT NULL,
  `Contact_Id` int(11) NOT NULL,
  `Formation_Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Statut` varchar(20) NOT NULL,
  `StatutPaiement` varchar(20) NOT NULL,
  `Montant` float NOT NULL,
  `Commentaire` text DEFAULT NULL,
  `ModePaiement` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`Id`, `Agence_Id`, `Contact_Id`, `Formation_Id`, `Date`, `Statut`, `StatutPaiement`, `Montant`, `Commentaire`, `ModePaiement`) VALUES
(1, 1, 1, 1, '0000-00-00', '0', 'test', 100, NULL, 'carte');

-- --------------------------------------------------------

--
-- Structure de la table `online`
--

CREATE TABLE `online` (
  `Id` int(11) NOT NULL,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Duree` int(11) NOT NULL,
  `Niveau` varchar(50) NOT NULL,
  `DateHeure` datetime NOT NULL,
  `URL` varchar(100) NOT NULL,
  `Formateur_Id` int(11) NOT NULL,
  `Secteur` varchar(150) NOT NULL,
  `Inscription_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `online`
--

INSERT INTO `online` (`Id`, `Titre`, `Description`, `Duree`, `Niveau`, `DateHeure`, `URL`, `Formateur_Id`, `Secteur`, `Inscription_Id`) VALUES
(5, 'test', 'test', 5, 'debutant', '0220-02-01 20:02:00', 'https://music.youtube.com', 1, 'test', 0);

-- --------------------------------------------------------

--
-- Structure de la table `standard`
--

CREATE TABLE `standard` (
  `Id` int(11) NOT NULL,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Duree` int(11) NOT NULL,
  `Niveau` varchar(50) NOT NULL,
  `Secteur` varchar(150) NOT NULL,
  `PlanningDebut` datetime NOT NULL,
  `PlanningFin` datetime NOT NULL,
  `Lieu` varchar(100) NOT NULL,
  `Capacite` int(11) NOT NULL,
  `Formateur_Id` int(11) NOT NULL,
  `Materiel` text DEFAULT NULL,
  `Cout` float NOT NULL,
  `Modalite` text DEFAULT NULL,
  `Commentaire` text DEFAULT NULL,
  `Support` varchar(200) DEFAULT NULL,
  `Inscription_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `standard`
--

INSERT INTO `standard` (`Id`, `Titre`, `Description`, `Duree`, `Niveau`, `Secteur`, `PlanningDebut`, `PlanningFin`, `Lieu`, `Capacite`, `Formateur_Id`, `Materiel`, `Cout`, `Modalite`, `Commentaire`, `Support`, `Inscription_Id`) VALUES
(6, 'test', 'test', 4, 'intermediaire', 'test', '0001-01-01 00:00:00', '0999-09-09 09:09:00', 'test', 20, 0, '', 99, '', '', '', 0);

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
-- Index pour la table `associationinscription`
--
ALTER TABLE `associationinscription`
  ADD KEY `associationInscription_agence_Id_fk` (`Agence_id`),
  ADD KEY `associationInscription_inscription_id_fk` (`Inscription_id`);

--
-- Index pour la table `associationinscription1`
--
ALTER TABLE `associationinscription1`
  ADD KEY `associationInscription1_contact_Id_fk` (`Contact_id`),
  ADD KEY `associationInscription1_inscription_id_fk` (`Inscription_id`);

--
-- Index pour la table `association_conseil`
--
ALTER TABLE `association_conseil`
  ADD KEY `association_conseil_conseil_id_fk` (`Conseil_id`),
  ADD KEY `association_conseil_formateur_Id_fk` (`Formateur_id`);

--
-- Index pour la table `association_inscription2`
--
ALTER TABLE `association_inscription2`
  ADD KEY `association_inscription2_inscription_id_fk` (`Inscription_id`),
  ADD KEY `Formation_id` (`Formation_id`);

--
-- Index pour la table `association_standard`
--
ALTER TABLE `association_standard`
  ADD KEY `association_standard_formateur_Id_fk` (`Formateur_id`),
  ADD KEY `association_standard_standard_Id_fk` (`Standard_id`);

--
-- Index pour la table `association_standard1`
--
ALTER TABLE `association_standard1`
  ADD KEY `Inscription_Id` (`Inscription_id`),
  ADD KEY `Standard_Id` (`Standard_id`);

--
-- Index pour la table `conseil`
--
ALTER TABLE `conseil`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `conseil_demandeconseil_id_fk` (`Demande_Id`),
  ADD KEY `conseil_formateur_Id_fk` (`Formateur_Id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `demandeconseil`
--
ALTER TABLE `demandeconseil`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `demandeconseil_agence_Id_fk` (`Agence_Id`),
  ADD KEY `demandeconseil_contact_Id_fk` (`Contact_Id`),
  ADD KEY `demandeconseil_formateur_Id_fk` (`Formateur_Id`);

--
-- Index pour la table `formateur`
--
ALTER TABLE `formateur`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `online_formateur_Id_fk` (`Formateur_Id`),
  ADD KEY `online_association_inscription2_Inscription_id_fk` (`Inscription_Id`);

--
-- Index pour la table `standard`
--
ALTER TABLE `standard`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `standard_association_inscription2_Inscription_id_fk` (`Inscription_Id`),
  ADD KEY `standard_formateur_Id_fk` (`Formateur_Id`);

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
-- AUTO_INCREMENT pour la table `demandeconseil`
--
ALTER TABLE `demandeconseil`
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
  ADD CONSTRAINT `agence_contact_Id_fk` FOREIGN KEY (`ContactPrincipal_Id`) REFERENCES `contact` (`Id`),
  ADD CONSTRAINT `agence_contact_Id_fk_2` FOREIGN KEY (`ContactFacturation_Id`) REFERENCES `contact` (`Id`);

--
-- Contraintes pour la table `associationinscription`
--
ALTER TABLE `associationinscription`
  ADD CONSTRAINT `associationInscription_agence_Id_fk` FOREIGN KEY (`Agence_id`) REFERENCES `agence` (`Id`),
  ADD CONSTRAINT `associationInscription_inscription_id_fk` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`);

--
-- Contraintes pour la table `associationinscription1`
--
ALTER TABLE `associationinscription1`
  ADD CONSTRAINT `associationInscription1_contact_Id_fk` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Id`),
  ADD CONSTRAINT `associationInscription1_inscription_id_fk` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`);

--
-- Contraintes pour la table `association_conseil`
--
ALTER TABLE `association_conseil`
  ADD CONSTRAINT `association_conseil_conseil_id_fk` FOREIGN KEY (`Conseil_id`) REFERENCES `conseil` (`Id`),
  ADD CONSTRAINT `association_conseil_formateur_Id_fk` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`);

--
-- Contraintes pour la table `association_inscription2`
--
ALTER TABLE `association_inscription2`
  ADD CONSTRAINT `association_inscription2_ibfk_1` FOREIGN KEY (`Formation_id`) REFERENCES `online` (`Id`),
  ADD CONSTRAINT `association_inscription2_ibfk_2` FOREIGN KEY (`Formation_id`) REFERENCES `standard` (`Id`),
  ADD CONSTRAINT `association_inscription2_inscription_id_fk` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`);

--
-- Contraintes pour la table `association_standard`
--
ALTER TABLE `association_standard`
  ADD CONSTRAINT `association_standard_formateur_Id_fk` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `association_standard_standard_Id_fk` FOREIGN KEY (`Standard_id`) REFERENCES `standard` (`Id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `association_standard1`
--
ALTER TABLE `association_standard1`
  ADD CONSTRAINT `association_standard1_ibfk_1` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`),
  ADD CONSTRAINT `association_standard1_ibfk_2` FOREIGN KEY (`Standard_id`) REFERENCES `standard` (`Id`);

--
-- Contraintes pour la table `demandeconseil`
--
ALTER TABLE `demandeconseil`
  ADD CONSTRAINT `demandeconseil_agence_Id_fk` FOREIGN KEY (`Agence_Id`) REFERENCES `agence` (`Id`),
  ADD CONSTRAINT `demandeconseil_contact_Id_fk` FOREIGN KEY (`Contact_Id`) REFERENCES `contact` (`Id`),
  ADD CONSTRAINT `demandeconseil_formateur_Id_fk` FOREIGN KEY (`Formateur_Id`) REFERENCES `formateur` (`Id`);

--
-- Contraintes pour la table `online`
--
ALTER TABLE `online`
  ADD CONSTRAINT `online_formateur_Id_fk` FOREIGN KEY (`Formateur_Id`) REFERENCES `formateur` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
