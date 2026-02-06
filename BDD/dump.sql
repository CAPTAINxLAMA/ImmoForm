/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.3-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: immoform
-- ------------------------------------------------------
-- Server version	11.8.3-MariaDB-0+deb13u1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `agence`
--

DROP TABLE IF EXISTS `agence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agence` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
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
  `Commentaire` text DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `agence_contact_Id_fk` (`ContactPrincipal_Id`),
  KEY `agence_contact_Id_fk_2` (`ContactFacturation_Id`),
  CONSTRAINT `agence_ibfk_1` FOREIGN KEY (`ContactPrincipal_Id`) REFERENCES `contact` (`Id`),
  CONSTRAINT `agence_ibfk_2` FOREIGN KEY (`ContactFacturation_Id`) REFERENCES `contact` (`Id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agence`
--

LOCK TABLES `agence` WRITE;
/*!40000 ALTER TABLE `agence` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `agence` VALUES
(1,'La tête dans la toile','Epsi','06 00 00 00 00',1,'alice@epsi.com',NULL,1,NULL,NULL,1,'Pays de la loire','Freelance',NULL,'Informatique',100,100,NULL);
/*!40000 ALTER TABLE `agence` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `conseil`
--

DROP TABLE IF EXISTS `conseil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `conseil` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Demande_id` int(11) NOT NULL,
  `Duree` int(11) NOT NULL COMMENT 'en heures',
  `Date` datetime NOT NULL,
  `Cout` float NOT NULL,
  `Commentaire` text DEFAULT NULL,
  `Support` varchar(150) DEFAULT NULL COMMENT 'liens',
  `Lieu` varchar(200) NOT NULL COMMENT 'adresse, ville, code postal',
  PRIMARY KEY (`Id`),
  KEY `conseil_demandeconseil_id_fk` (`Demande_id`),
  CONSTRAINT `conseil_ibfk_1` FOREIGN KEY (`Demande_id`) REFERENCES `demandes` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conseil`
--

LOCK TABLES `conseil` WRITE;
/*!40000 ALTER TABLE `conseil` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `conseil` VALUES
(1,'Aide à la formation','Ceci est un conseil test',1,400,'2026-01-01 00:00:00',600,'','','EPSI');
/*!40000 ALTER TABLE `conseil` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Numero` char(15) DEFAULT NULL,
  `Email` varchar(50) NOT NULL,
  `Fonction` varchar(100) DEFAULT NULL,
  `PreferenceContact` varchar(50) DEFAULT NULL COMMENT 'téléphone, e-mail, autre',
  `Commentaire` text DEFAULT NULL,
  `mdp_hash` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `contact` VALUES
(1,'Bob','Alice',NULL,'alice@epsi.fr','','Email','','$2y$12$/vzHuDH0cKG8I94LRNC8Qumto.vlxw8U83UMCQVla0PMqMOMnbLQq');
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `contact_agence`
--

DROP TABLE IF EXISTS `contact_agence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_agence` (
  `Contact_id` int(11) NOT NULL,
  `Agence_id` int(11) NOT NULL,
  KEY `Agence_id` (`Agence_id`),
  KEY `Contact_id` (`Contact_id`),
  CONSTRAINT `contact_agence_ibfk_1` FOREIGN KEY (`Agence_id`) REFERENCES `agence` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `contact_agence_ibfk_2` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_agence`
--

LOCK TABLES `contact_agence` WRITE;
/*!40000 ALTER TABLE `contact_agence` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `contact_agence` VALUES
(1,1);
/*!40000 ALTER TABLE `contact_agence` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `demandes`
--

DROP TABLE IF EXISTS `demandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `demandes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Agence_id` int(11) NOT NULL,
  `Contact_id` int(11) NOT NULL,
  `Type` varchar(100) NOT NULL COMMENT 'stratégie commerciale, marketing, gestion d''équipe, autre...',
  `Description` text NOT NULL,
  `Date` date NOT NULL,
  `Statut` varchar(20) NOT NULL COMMENT 'en attente, annulée, terminé',
  `Formateur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `demandeconseil_agence_Id_fk` (`Agence_id`),
  KEY `demandeconseil_contact_Id_fk` (`Contact_id`),
  KEY `demandeconseil_formateur_Id_fk` (`Formateur_id`),
  CONSTRAINT `demandes_ibfk_1` FOREIGN KEY (`Agence_id`) REFERENCES `agence` (`Id`),
  CONSTRAINT `demandes_ibfk_2` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Id`),
  CONSTRAINT `demandes_ibfk_3` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demandes`
--

LOCK TABLES `demandes` WRITE;
/*!40000 ALTER TABLE `demandes` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `demandes` VALUES
(1,1,1,'Formation','Ceci est une demande test','2026-01-01','Accepté',1),
(23,1,1,'Conseil','Ceci est un conseil','2026-01-29','Refusé',1),
(24,1,1,'Formation','aze','2026-01-29','En attente',NULL);
/*!40000 ALTER TABLE `demandes` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `formateur`
--

DROP TABLE IF EXISTS `formateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `formateur` (
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Numero` char(15) DEFAULT NULL,
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(50) NOT NULL,
  `Specialite` varchar(100) DEFAULT NULL,
  `AnneeExeprience` int(11) DEFAULT NULL,
  `Commentaire` text DEFAULT NULL,
  `DebutCollab` date NOT NULL,
  `FinCollab` date DEFAULT NULL,
  `Statut` tinyint(1) NOT NULL COMMENT 'actif/inactif',
  `Certification` varchar(100) DEFAULT NULL,
  `mdp_hash` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formateur`
--

LOCK TABLES `formateur` WRITE;
/*!40000 ALTER TABLE `formateur` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `formateur` VALUES
('Charlie','David',NULL,1,'david@epsi.fr',NULL,NULL,NULL,'2000-01-01',NULL,0,NULL,'$2y$12$1/ohQ9AVgal.48zg4N6Av.LBTvpFASJFhSp1Mj/77SoGxGNrXk8uG'),
('Joe','Bertran',NULL,3,'joe@gmail.fr',NULL,NULL,NULL,'2000-01-01',NULL,0,NULL,NULL);
/*!40000 ALTER TABLE `formateur` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `formateur_conseil`
--

DROP TABLE IF EXISTS `formateur_conseil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `formateur_conseil` (
  `Formateur_id` int(11) NOT NULL,
  `Conseil_id` int(11) NOT NULL,
  UNIQUE KEY `formateur/conseil_Formateur_id__uindex` (`Formateur_id`,`Conseil_id`),
  KEY `association_conseil_conseil_id_fk` (`Conseil_id`),
  KEY `association_conseil_formateur_Id_fk` (`Formateur_id`),
  CONSTRAINT `formateur_conseil_ibfk_1` FOREIGN KEY (`Conseil_id`) REFERENCES `conseil` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `formateur_conseil_ibfk_2` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formateur_conseil`
--

LOCK TABLES `formateur_conseil` WRITE;
/*!40000 ALTER TABLE `formateur_conseil` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `formateur_conseil` VALUES
(1,1);
/*!40000 ALTER TABLE `formateur_conseil` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `formateur_standard`
--

DROP TABLE IF EXISTS `formateur_standard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `formateur_standard` (
  `Formateur_id` int(11) NOT NULL,
  `Standard_id` int(11) NOT NULL,
  UNIQUE KEY `formateur/standard_Formateur_id_Standard_id_uindex` (`Formateur_id`,`Standard_id`),
  KEY `association_standard_formateur_Id_fk` (`Formateur_id`),
  KEY `association_standard_standard_Id_fk` (`Standard_id`),
  CONSTRAINT `formateur_standard_ibfk_1` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `formateur_standard_ibfk_2` FOREIGN KEY (`Standard_id`) REFERENCES `standard` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formateur_standard`
--

LOCK TABLES `formateur_standard` WRITE;
/*!40000 ALTER TABLE `formateur_standard` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `formateur_standard` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscription` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `Statut` varchar(20) NOT NULL COMMENT 'confirmée, annulée, en attente',
  `StatutPaiement` varchar(20) NOT NULL COMMENT 'payé, en attente, annulé',
  `Montant` float NOT NULL,
  `Commentaire` text DEFAULT NULL,
  `ModePaiement` varchar(50) NOT NULL COMMENT 'carte bancaire, virement, chèque, autre...',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscription`
--

LOCK TABLES `inscription` WRITE;
/*!40000 ALTER TABLE `inscription` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `inscription` VALUES
(1,'2026-01-01','En attente','En attente',100,NULL,'CB');
/*!40000 ALTER TABLE `inscription` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `inscription_agence`
--

DROP TABLE IF EXISTS `inscription_agence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscription_agence` (
  `Inscription_id` int(11) NOT NULL,
  `Agence_id` int(11) NOT NULL,
  UNIQUE KEY `inscription/agence_Inscription_id_Agence_id_uindex` (`Inscription_id`,`Agence_id`),
  KEY `Agence_id` (`Agence_id`),
  CONSTRAINT `inscription_agence_ibfk_1` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inscription_agence_ibfk_2` FOREIGN KEY (`Agence_id`) REFERENCES `agence` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscription_agence`
--

LOCK TABLES `inscription_agence` WRITE;
/*!40000 ALTER TABLE `inscription_agence` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `inscription_agence` VALUES
(1,1);
/*!40000 ALTER TABLE `inscription_agence` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `inscription_contact`
--

DROP TABLE IF EXISTS `inscription_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscription_contact` (
  `Inscription_id` int(11) NOT NULL,
  `Contact_id` int(11) NOT NULL,
  UNIQUE KEY `inscription/contact_Inscription_id_Contact_id_uindex` (`Inscription_id`,`Contact_id`),
  KEY `associationInscription1_inscription_id_fk` (`Inscription_id`),
  KEY `Contact_id` (`Contact_id`),
  CONSTRAINT `inscription_contact_ibfk_1` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inscription_contact_ibfk_2` FOREIGN KEY (`Contact_id`) REFERENCES `contact` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscription_contact`
--

LOCK TABLES `inscription_contact` WRITE;
/*!40000 ALTER TABLE `inscription_contact` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `inscription_contact` VALUES
(1,1);
/*!40000 ALTER TABLE `inscription_contact` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `inscription_online`
--

DROP TABLE IF EXISTS `inscription_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscription_online` (
  `Inscription_id` int(11) NOT NULL,
  `Formation_id` int(11) NOT NULL,
  KEY `association_inscription2_inscription_id_fk` (`Inscription_id`),
  KEY `Formation_id` (`Formation_id`),
  KEY `inscription/formation_Inscription_id_Formation_id_index` (`Inscription_id`,`Formation_id`),
  CONSTRAINT `inscription_online_ibfk_1` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inscription_online_ibfk_2` FOREIGN KEY (`Formation_id`) REFERENCES `online` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscription_online`
--

LOCK TABLES `inscription_online` WRITE;
/*!40000 ALTER TABLE `inscription_online` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `inscription_online` VALUES
(1,1);
/*!40000 ALTER TABLE `inscription_online` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `inscription_standard`
--

DROP TABLE IF EXISTS `inscription_standard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscription_standard` (
  `Inscription_id` int(11) NOT NULL,
  `Formation_id` int(11) NOT NULL,
  KEY `association_inscription2_inscription_id_fk` (`Inscription_id`),
  KEY `Formation_id` (`Formation_id`),
  KEY `inscription/formation_Inscription_id_Formation_id_index` (`Inscription_id`,`Formation_id`),
  CONSTRAINT `inscription_standard_ibfk_1` FOREIGN KEY (`Formation_id`) REFERENCES `standard` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inscription_standard_ibfk_2` FOREIGN KEY (`Inscription_id`) REFERENCES `inscription` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscription_standard`
--

LOCK TABLES `inscription_standard` WRITE;
/*!40000 ALTER TABLE `inscription_standard` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `inscription_standard` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `online`
--

DROP TABLE IF EXISTS `online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `online` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Titre` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Duree` int(11) NOT NULL COMMENT 'en heures',
  `Niveau` varchar(50) NOT NULL COMMENT 'débutant, intermédiaire, avancé',
  `DateHeure` datetime NOT NULL,
  `URL` varchar(100) NOT NULL,
  `Formateur_id` int(11) NOT NULL,
  `Secteur` varchar(150) NOT NULL COMMENT 'résidentiel, commercial, mixte, luxe, atypique, agricole, investissement, autre...',
  PRIMARY KEY (`Id`),
  KEY `online_formateur_Id_fk` (`Formateur_id`),
  CONSTRAINT `online_ibfk_1` FOREIGN KEY (`Formateur_id`) REFERENCES `formateur` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online`
--

LOCK TABLES `online` WRITE;
/*!40000 ALTER TABLE `online` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `online` VALUES
(1,'Les bases de données','Ceci est un cours de BDD',50,'debutant','2026-01-01 00:00:00','https://google.com',1,'Informatique');
/*!40000 ALTER TABLE `online` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `standard`
--

DROP TABLE IF EXISTS `standard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `standard` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
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
  `Support` varchar(200) DEFAULT NULL COMMENT 'liens',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `standard`
--

LOCK TABLES `standard` WRITE;
/*!40000 ALTER TABLE `standard` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `standard` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-02-06 15:33:18
