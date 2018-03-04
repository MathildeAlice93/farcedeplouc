-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Dim 04 Mars 2018 à 11:32
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
CREATE TABLE `conversation` (
  `id` int(11) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `public` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `joint_conversation_personne`
--

DROP TABLE IF EXISTS `joint_conversation_personne`;
CREATE TABLE `joint_conversation_personne` (
  `id_conversation` int(11) NOT NULL,
  `id_personne` int(11) NOT NULL,
  `date_lecture` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `joint_personne`
--

DROP TABLE IF EXISTS `joint_personne`;
CREATE TABLE `joint_personne` (
  `id_demandeur` int(11) NOT NULL,
  `id_receveur` int(11) NOT NULL,
  `statut` enum('confirme','en_attente','refuse') NOT NULL,
  `date_demande` timestamp NOT NULL,
  `date_traitement` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `joint_personne`
--

INSERT INTO `joint_personne` (`id_demandeur`, `id_receveur`, `statut`, `date_demande`, `date_traitement`) VALUES
(5, 6, 'confirme', '2017-12-23 17:57:13', '2017-12-23 17:57:13'),
(5, 12, 'en_attente', '2018-02-18 12:42:39', NULL),
(5, 17, 'en_attente', '2018-02-18 12:46:35', NULL),
(5, 18, 'confirme', '2018-02-18 12:47:56', NULL),
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
CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `id_conversation` int(11) NOT NULL,
  `expediteur` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

DROP TABLE IF EXISTS `personne`;
CREATE TABLE `personne` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `date_anniversaire` date DEFAULT NULL,
  `date_inscription` timestamp NOT NULL,
  `courriel` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `personne`
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
-- Index pour les tables exportées
--

--
-- Index pour la table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `joint_conversation_personne`
--
ALTER TABLE `joint_conversation_personne`
  ADD PRIMARY KEY (`id_conversation`,`id_personne`),
  ADD KEY `id_conversation` (`id_conversation`),
  ADD KEY `id_personne` (`id_personne`);

--
-- Index pour la table `joint_personne`
--
ALTER TABLE `joint_personne`
  ADD PRIMARY KEY (`id_demandeur`,`id_receveur`),
  ADD KEY `FK_id_receveur` (`id_receveur`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_conversation` (`id_conversation`),
  ADD KEY `FK_id_personne` (`expediteur`) USING BTREE;

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courriel` (`courriel`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- Contraintes pour les tables exportées
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
