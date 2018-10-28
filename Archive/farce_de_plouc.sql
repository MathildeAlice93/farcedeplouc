-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 26 avr. 2018 à 20:58
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
  `titre` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `conversation`
--

INSERT INTO `conversation` (`id`, `date_creation`, `titre`, `public`) VALUES
(20, '2018-03-18 13:18:55', NULL, 0),
(21, '2018-03-18 13:23:26', NULL, 0),
(23, '2018-03-18 15:35:53', NULL, 0),
(24, '2018-03-22 20:41:21', NULL, 0),
(25, '2018-03-25 13:11:54', NULL, 0),
(26, '2018-03-25 13:18:38', NULL, 0),
(27, '2018-03-25 23:07:18', NULL, 0),
(28, '2018-04-02 07:58:15', NULL, 0),
(29, '2018-04-26 20:18:18', NULL, 0),
(30, '2018-04-26 20:22:31', NULL, 0),
(31, '2018-04-26 20:25:32', NULL, 0),
(32, '2018-04-26 20:51:30', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `joint_conversation_personne`
--

DROP TABLE IF EXISTS `joint_conversation_personne`;
CREATE TABLE IF NOT EXISTS `joint_conversation_personne` (
  `id_conversation` int(11) NOT NULL,
  `id_personne` int(11) NOT NULL,
  `date_lecture` timestamp NULL DEFAULT NULL,
  `date_invitation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_conversation`,`id_personne`),
  KEY `id_conversation` (`id_conversation`),
  KEY `id_personne` (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `joint_conversation_personne`
--

INSERT INTO `joint_conversation_personne` (`id_conversation`, `id_personne`, `date_lecture`, `date_invitation`) VALUES
(20, 30, NULL, '2018-03-18 13:18:55'),
(20, 32, NULL, '2018-03-18 13:18:55'),
(20, 33, NULL, '2018-03-25 12:56:05'),
(20, 34, NULL, '2018-03-22 20:41:34'),
(21, 30, NULL, '2018-03-18 13:23:26'),
(21, 33, NULL, '2018-03-18 13:23:26'),
(23, 32, NULL, '2018-03-18 15:35:53'),
(23, 34, NULL, '2018-03-18 15:35:53'),
(24, 30, NULL, '2018-03-22 20:41:21'),
(24, 34, NULL, '2018-03-22 20:41:21'),
(25, 36, NULL, '2018-03-25 13:15:32'),
(26, 30, NULL, '2018-03-25 13:18:38'),
(26, 37, NULL, '2018-03-25 13:18:38'),
(27, 30, NULL, '2018-03-25 23:07:18'),
(27, 38, NULL, '2018-03-25 23:07:18'),
(28, 34, NULL, '2018-04-02 07:58:15'),
(28, 39, NULL, '2018-04-02 07:58:15'),
(29, 30, NULL, '2018-04-26 20:18:18'),
(29, 32, NULL, '2018-04-26 20:18:18'),
(30, 33, NULL, '2018-04-26 20:22:31'),
(30, 38, NULL, '2018-04-26 20:22:31'),
(31, 32, NULL, '2018-04-26 20:25:32'),
(31, 38, NULL, '2018-04-26 20:25:32'),
(32, 30, NULL, '2018-04-26 20:51:47'),
(32, 32, NULL, '2018-04-26 20:51:30'),
(32, 33, NULL, '2018-04-26 20:51:30'),
(32, 34, NULL, '2018-04-26 20:52:04');

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
(30, 32, 'confirme', '2018-03-18 13:18:48', NULL),
(30, 36, 'confirme', '2018-03-25 13:11:48', NULL),
(30, 37, 'confirme', '2018-03-25 13:18:33', NULL),
(32, 33, 'confirme', '2018-04-26 20:51:25', NULL),
(32, 38, 'confirme', '2018-04-26 20:25:25', NULL),
(33, 30, 'confirme', '2018-03-18 13:23:19', NULL),
(33, 38, 'confirme', '2018-04-26 20:21:08', NULL),
(34, 30, 'confirme', '2018-03-18 15:35:36', NULL),
(34, 32, 'confirme', '2018-03-18 15:35:45', NULL),
(34, 39, 'confirme', '2018-04-02 07:58:03', NULL),
(38, 30, 'confirme', '2018-03-25 23:07:05', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conversation` int(11) NOT NULL,
  `id_expediteur` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date_envoi` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_id_conversation` (`id_conversation`),
  KEY `FK_id_personne` (`id_expediteur`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `id_conversation`, `id_expediteur`, `contenu`, `date_envoi`) VALUES
(20, 20, 30, 'bonjour', '2018-03-18 13:18:59'),
(21, 20, 30, 'bonjour', '2018-03-18 13:22:32'),
(22, 21, 33, 'salut je suis i', '2018-03-18 13:23:42'),
(23, 21, 33, 'yolo', '2018-03-18 13:23:53'),
(24, 21, 30, 'k', '2018-03-18 13:43:41'),
(25, 21, 30, 's', '2018-03-18 13:43:52'),
(26, 21, 30, 's', '2018-03-18 13:47:42'),
(27, 21, 30, 's', '2018-03-18 13:48:32'),
(28, 21, 30, 'fdqfd\r\n', '2018-03-18 15:12:30'),
(29, 20, 30, 'j\'ai quelque chose Ã  te dire', '2018-03-18 15:34:15'),
(30, 21, 30, 'ceci est ma conversation avec i ', '2018-03-18 15:34:32'),
(31, 23, 34, 'Bonjour j!\r\n', '2018-03-18 15:35:59'),
(32, 23, 32, 'Bonjour a!', '2018-03-18 15:36:28'),
(33, 20, 30, 'tagada', '2018-03-22 20:41:41'),
(34, 20, 34, 'bonjour ', '2018-03-22 20:42:01'),
(35, 25, 30, 'yolo', '2018-03-25 13:15:14'),
(36, 26, 30, 'bonjour d', '2018-03-25 13:18:43'),
(37, 21, 30, 'je suis triste aujd\r\n', '2018-03-25 22:59:04'),
(38, 24, 30, 'La conversation entre a et k ', '2018-03-25 22:59:20'),
(39, 27, 38, 'bonjour k, c\'est manon ! ', '2018-03-25 23:07:25'),
(40, 27, 30, 'salut manouchka ', '2018-03-25 23:07:57'),
(41, 28, 34, 'Salut!\r\n', '2018-04-02 07:58:22'),
(42, 28, 34, 'est-ce que Ã§a va ? ', '2018-04-02 07:58:33'),
(43, 20, 30, 'tralala', '2018-04-26 20:24:25'),
(44, 24, 30, 'salagadou', '2018-04-26 20:24:51'),
(45, 32, 32, 'qsmdl\'fkj', '2018-04-26 20:51:33');

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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`id`, `nom`, `prenom`, `pseudo`, `date_anniversaire`, `date_inscription`, `courriel`, `mot_de_passe`) VALUES
(30, 'k', 'k', 'k', '2018-01-01', '2018-03-18 13:17:43', 'k', 'k'),
(32, 'j', 'j', 'j', '2018-01-01', '2018-03-18 13:18:04', 'j', 'j'),
(33, 'i', 'i', 'i', '2018-01-01', '2018-03-18 13:23:10', 'i', 'i'),
(34, 'a', 'a', 'a', '2017-07-09', '2018-03-18 15:35:16', 'a', 'a'),
(35, 'b', 'b', 'b', '2018-01-01', '2018-03-22 21:12:05', 'b', 'b'),
(36, 'c', 'c', 'c', '2018-01-01', '2018-03-25 13:11:40', 'c', 'c'),
(37, 'd', 'd', 'd', '2018-01-01', '2018-03-25 13:18:25', 'd', 'd'),
(38, 'manon', 'de clercq ', 'Manouchka', '2017-07-09', '2018-03-25 23:06:22', 'cocottemanette@hotmail.fr', 'bambou'),
(39, 'Michnowska', 'Aneta', 'Anemich', '2017-07-09', '2018-04-02 07:57:27', 'aneta@michnowka.com', 'chouchou');

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
  ADD CONSTRAINT `FK_id_expediteur` FOREIGN KEY (`id_expediteur`) REFERENCES `personne` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
