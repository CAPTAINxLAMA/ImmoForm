-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 05 déc. 2025 à 09:19
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
  `Formateur_Id` int(11) DEFAULT NULL,
  `Standard_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `conseil`
--

CREATE TABLE `conseil` (
  `id` int(11) NOT NULL,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Demande_id` int(11) NOT NULL,
  `Duree` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `Formateur_id` int(11) NOT NULL,
  `Cout` float NOT NULL,
  `Commentaire` text DEFAULT NULL,
  `Support` varchar(150) DEFAULT NULL,
  `Lieu` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Numero` char(15) DEFAULT NULL,
  `E-mail` varchar(50) NOT NULL,
  `Fonction` varchar(100) DEFAULT NULL,
  `PreferenceContact` varchar(50) DEFAULT NULL,
  `Commentaire` text DEFAULT NULL,
  `Agence_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `demandeconseil`
--

CREATE TABLE `demandeconseil` (
  `id` int(11) NOT NULL,
  `Agence_id` int(11) NOT NULL,
  `Contact_id` int(11) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Date` date NOT NULL,
  `Statut` varchar(20) NOT NULL,
  `Formateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formateur`
--

CREATE TABLE `formateur` (
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Numero` char(15) DEFAULT NULL,
  `Id` int(11) NOT NULL,
  `E-mail` varchar(50) NOT NULL,
  `Specialite` varchar(100) DEFAULT NULL,
  `AnneeExeprience` int(11) DEFAULT NULL,
  `Commentaire` text DEFAULT NULL,
  `DebutCollab` date NOT NULL,
  `FinCollab` date DEFAULT NULL,
  `Statut` tinyint(1) NOT NULL,
  `Certification` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `Agence_id` int(11) NOT NULL,
  `Contact_id` int(11) NOT NULL,
  `Formation_id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Statut` varchar(20) NOT NULL,
  `StatutPaiement` varchar(20) NOT NULL,
  `Montant` float NOT NULL,
  `Commentaire` text DEFAULT NULL,
  `ModePaiement` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `online`
--

CREATE TABLE `online` (
  `Id` int(11) NOT NULL,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Duree` datetime NOT NULL,
  `Niveau` varchar(50) NOT NULL,
  `DateHeure` datetime NOT NULL,
  `URL` varchar(100) NOT NULL,
  `Formateur_id` int(11) NOT NULL,
  `Secteur` varchar(150) NOT NULL,
  `Inscription_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `standard`
--

CREATE TABLE `standard` (
  `Id` int(11) NOT NULL,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Duree` datetime NOT NULL,
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
  `Inscription_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD KEY `association_inscription2_inscription_id_fk` (`Inscription_id`);

--
-- Index pour la table `association_standard`
--
ALTER TABLE `association_standard`
  ADD KEY `association_standard_formateur_Id_fk` (`Formateur_Id`),
  ADD KEY `association_standard_standard_Id_fk` (`Standard_Id`);

--
-- Index pour la table `conseil`
--
ALTER TABLE `conseil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conseil_demandeconseil_id_fk` (`Demande_id`),
  ADD KEY `conseil_formateur_Id_fk` (`Formateur_id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `contact_agence_id_fk` (`Agence_id`);

--
-- Index pour la table `demandeconseil`
--
ALTER TABLE `demandeconseil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demandeconseil_agence_Id_fk` (`Agence_id`),
  ADD KEY `demandeconseil_contact_Id_fk` (`Contact_id`),
  ADD KEY `demandeconseil_formateur_Id_fk` (`Formateur_id`);

--
-- Index pour la table `formateur`
--
ALTER TABLE `formateur`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `online_formateur_Id_fk` (`Formateur_id`),
  ADD KEY `online_association_inscription2_Inscription_id_fk` (`Inscription_id`);

--
-- Index pour la table `standard`
--
ALTER TABLE `standard`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `standard_association_inscription2_Inscription_id_fk` (`Inscription_id`),
  ADD KEY `standard_formateur_Id_fk` (`Formateur_Id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agence`
--
ALTER TABLE `agence`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `conseil`
--
ALTER TABLE `conseil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `demandeconseil`
--
ALTER TABLE `demandeconseil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formateur`
--
ALTER TABLE `formateur`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `online`
--
ALTER TABLE `online`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `standard`
--
ALTER TABLE `standard`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `associationInscription_inscription_id_fk` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`id`);

--
-- Contraintes pour la table `associationinscription1`
--
ALTER TABLE `associationinscription1`
  ADD CONSTRAINT `associationInscription1_contact_Id_fk` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Id`),
  ADD CONSTRAINT `associationInscription1_inscription_id_fk` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`id`);

--
-- Contraintes pour la table `association_conseil`
--
ALTER TABLE `association_conseil`
  ADD CONSTRAINT `association_conseil_conseil_id_fk` FOREIGN KEY (`Conseil_id`) REFERENCES `conseil` (`id`),
  ADD CONSTRAINT `association_conseil_formateur_Id_fk` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`);

--
-- Contraintes pour la table `association_inscription2`
--
ALTER TABLE `association_inscription2`
  ADD CONSTRAINT `association_inscription2_inscription_id_fk` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`id`);

--
-- Contraintes pour la table `association_standard`
--
ALTER TABLE `association_standard`
  ADD CONSTRAINT `association_standard_formateur_Id_fk` FOREIGN KEY (`Formateur_Id`) REFERENCES `formateur` (`Id`),
  ADD CONSTRAINT `association_standard_standard_Id_fk` FOREIGN KEY (`Standard_Id`) REFERENCES `standard` (`Id`);

--
-- Contraintes pour la table `conseil`
--
ALTER TABLE `conseil`
  ADD CONSTRAINT `conseil_demandeconseil_id_fk` FOREIGN KEY (`Demande_id`) REFERENCES `demandeconseil` (`id`),
  ADD CONSTRAINT `conseil_formateur_Id_fk` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`);

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_agence_id_fk` FOREIGN KEY (`Agence_id`) REFERENCES `agence` (`Id`);

--
-- Contraintes pour la table `demandeconseil`
--
ALTER TABLE `demandeconseil`
  ADD CONSTRAINT `demandeconseil_agence_Id_fk` FOREIGN KEY (`Agence_id`) REFERENCES `agence` (`Id`),
  ADD CONSTRAINT `demandeconseil_contact_Id_fk` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Id`),
  ADD CONSTRAINT `demandeconseil_formateur_Id_fk` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`);

--
-- Contraintes pour la table `online`
--
ALTER TABLE `online`
  ADD CONSTRAINT `online_association_inscription2_Inscription_id_fk` FOREIGN KEY (`Inscription_id`) REFERENCES `association_inscription2` (`Inscription_id`),
  ADD CONSTRAINT `online_formateur_Id_fk` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`);

--
-- Contraintes pour la table `standard`
--
ALTER TABLE `standard`
  ADD CONSTRAINT `standard_association_inscription2_Inscription_id_fk` FOREIGN KEY (`Inscription_id`) REFERENCES `association_inscription2` (`Inscription_id`),
  ADD CONSTRAINT `standard_formateur_Id_fk` FOREIGN KEY (`Formateur_Id`) REFERENCES `formateur` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
