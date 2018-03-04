-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 04 mars 2018 à 14:22
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `farce_de_plouc`
--
CREATE DATABASE IF NOT EXISTS `farce_de_plouc` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `farce_de_plouc`;

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `afficher_infos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `afficher_infos` (IN `id_in` INT)  BEGIN
    SELECT nom, prenom, pseudo, date_anniversaire, courriel
    FROM Personne
    WHERE id_in = personne.id;  END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

DROP TABLE IF EXISTS `conversation`;
CREATE TABLE IF NOT EXISTS `conversation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nom` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `conversation`
--

INSERT INTO `conversation` (`id`, `date_creation`, `nom`, `public`) VALUES
(1, '2018-03-04 13:28:01', NULL, 1),
(2, '2018-03-04 13:28:24', NULL, 1),
(3, '2018-03-04 13:30:24', '', 1),
(4, '2018-03-04 13:30:35', '', 1),
(5, '2018-03-04 13:31:15', NULL, 1),
(6, '2018-03-04 13:37:10', NULL, 1),
(7, '2018-03-04 13:47:53', NULL, 1),
(8, '2018-03-04 14:11:06', NULL, 0),
(9, '2018-03-04 14:11:36', NULL, 0),
(10, '2018-03-04 14:15:02', NULL, 0),
(11, '2018-03-04 14:18:02', NULL, 0),
(12, '2018-03-04 14:18:23', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `joint_conversation_personne`
--

DROP TABLE IF EXISTS `joint_conversation_personne`;
CREATE TABLE IF NOT EXISTS `joint_conversation_personne` (
  `id_conversation` int(11) NOT NULL,
  `id_personne` int(11) NOT NULL,
  `date_lecture` timestamp NULL DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_conversation`,`id_personne`),
  KEY `id_conversation` (`id_conversation`),
  KEY `id_personne` (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `joint_conversation_personne`
--

INSERT INTO `joint_conversation_personne` (`id_conversation`, `id_personne`, `date_lecture`, `date_creation`) VALUES
(8, 12, NULL, '2018-03-04 14:16:59'),
(8, 24, NULL, '2018-03-04 14:16:59'),
(9, 12, NULL, '2018-03-04 14:16:59'),
(9, 25, NULL, '2018-03-04 14:16:59'),
(10, 5, NULL, '2018-03-04 14:16:59'),
(10, 25, NULL, '2018-03-04 14:16:59'),
(12, 5, NULL, '2018-03-04 14:18:23'),
(12, 24, NULL, '2018-03-04 14:18:23');

-- --------------------------------------------------------

--
-- Structure de la table `joint_personne`
--

DROP TABLE IF EXISTS `joint_personne`;
CREATE TABLE IF NOT EXISTS `joint_personne` (
  `id_demandeur` int(11) NOT NULL,
  `id_receveur` int(11) NOT NULL,
  `statut` enum('confirme','en_attente','refuse') NOT NULL,
  `date_demande` timestamp NOT NULL,
  `date_traitement` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_demandeur`,`id_receveur`),
  KEY `FK_id_receveur` (`id_receveur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `joint_personne`
--

INSERT INTO `joint_personne` (`id_demandeur`, `id_receveur`, `statut`, `date_demande`, `date_traitement`) VALUES
(5, 6, 'confirme', '2017-12-23 17:57:13', '2017-12-23 17:57:13'),
(5, 12, 'en_attente', '2018-02-18 12:42:39', NULL),
(5, 17, 'en_attente', '2018-02-18 12:46:35', NULL),
(5, 18, 'confirme', '2018-02-18 12:47:56', NULL),
(5, 24, 'confirme', '2018-03-04 14:14:51', NULL),
(5, 25, 'confirme', '2018-03-04 14:14:02', NULL),
(6, 12, 'confirme', '2017-12-23 17:57:13', '2017-12-23 17:57:13'),
(12, 14, 'confirme', '2018-02-25 20:58:10', NULL),
(12, 15, 'confirme', '2018-02-25 21:06:27', NULL),
(12, 16, 'confirme', '2018-02-25 21:19:04', NULL),
(12, 18, 'confirme', '2018-02-25 21:47:53', NULL),
(12, 24, 'confirme', '2018-02-25 21:42:49', NULL),
(12, 25, 'confirme', '2018-02-25 21:41:55', NULL),
(12, 26, 'confirme', '2018-02-25 21:50:34', NULL),
(12, 27, 'confirme', '2018-02-25 21:51:59', NULL),
(12, 28, 'confirme', '2018-02-25 21:52:27', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conversation` int(11) NOT NULL,
  `expediteur` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_id_conversation` (`id_conversation`),
  KEY `FK_id_personne` (`expediteur`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

DROP TABLE IF EXISTS `personne`;
CREATE TABLE IF NOT EXISTS `personne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `date_anniversaire` date DEFAULT NULL,
  `date_inscription` timestamp NOT NULL,
  `courriel` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courriel` (`courriel`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`id`, `nom`, `prenom`, `pseudo`, `date_anniversaire`, `date_inscription`, `courriel`, `mot_de_passe`) VALUES
(5, 'g', 'g', 'g', '2017-07-09', '2017-12-10 17:37:34', 'g', 'g'),
(6, 'i', 'i', 'i', '2017-07-09', '2017-12-10 17:38:56', 'i', 'i'),
(12, 'k', 'k', 'k', '2017-07-09', '2017-12-23 16:52:12', 'k', 'k'),
(14, 'a', 'a', 'a', '2017-09-01', '2018-01-21 21:22:23', 'a', 'a'),
(15, 'b', 'b', 'b', '2017-09-01', '2018-01-21 21:23:33', 'b', 'b'),
(16, 'c', 'c', 'c', '2017-09-01', '2018-01-21 21:23:50', 'c', 'c'),
(17, 'd', 'd', 'd', '2017-09-01', '2018-01-21 21:23:59', 'd', 'd'),
(18, 'e', 'e', 'e', '2017-09-01', '2018-01-21 21:24:16', 'e', 'e'),
(19, 'f', 'f', 'f', '2017-09-01', '2018-01-21 21:24:25', 'f', 'f'),
(22, '', '', '', NULL, '2018-01-21 22:28:47', '', ''),
(23, 'z', 'z', 'z', '2018-01-01', '2018-02-25 21:23:56', 'z', 'z'),
(24, 'test', 'test', 'j', '2018-01-01', '2018-02-25 21:39:42', 'test', 'test'),
(25, 'j', 'j', 'j', '2018-01-01', '2018-02-25 21:41:30', 'j', 'j'),
(26, 'test2', 'test2', 'e', '2018-01-01', '2018-02-25 21:44:52', 'test2', 'test2'),
(27, 'y', 'y', 'y', '2018-01-01', '2018-02-25 21:51:23', 'y', 'y'),
(28, 'test', 'test', 'y', '2018-01-01', '2018-02-25 21:51:39', 'test3', 'test3');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `joint_conversation_personne`
--
ALTER TABLE `joint_conversation_personne`
  ADD CONSTRAINT `FK_id_conversation_2` FOREIGN KEY (`id_conversation`) REFERENCES `conversation` (`id`),
  ADD CONSTRAINT `FK_id_personne` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `joint_personne`
--
ALTER TABLE `joint_personne`
  ADD CONSTRAINT `FK_id_demandeur` FOREIGN KEY (`id_demandeur`) REFERENCES `personne` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_id_receveur` FOREIGN KEY (`id_receveur`) REFERENCES `personne` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_id_conversation` FOREIGN KEY (`id_conversation`) REFERENCES `conversation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_id_expediteur` FOREIGN KEY (`expediteur`) REFERENCES `personne` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
