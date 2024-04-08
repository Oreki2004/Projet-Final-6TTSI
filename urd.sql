-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 08 avr. 2024 à 12:13
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `urd`
--

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE IF NOT EXISTS `joueur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `genre` binary(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id`, `pseudo`, `email`, `mdp`, `genre`) VALUES
(2, 'Oreki', 'gs10arunmoli@gmail.com', 'arun', 0x0000),
(3, 'Maurice', 'mauricelataupe@gmail.com', 'maurice', 0x0000);

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

DROP TABLE IF EXISTS `niveau`;
CREATE TABLE IF NOT EXISTS `niveau` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_joueur` int NOT NULL,
  `niveau` int NOT NULL,
  `joueur` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `niveau`
--

INSERT INTO `niveau` (`id`, `id_joueur`, `niveau`, `joueur`) VALUES
(1, 3, 1, 'Maurice');

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`id`, `question`) VALUES
(1, 'D\'où viens le pouvoir des Gardiens?'),
(2, 'Qui a commencé la Guerre Rouge?'),
(3, 'Qui a crée les Exos?'),
(4, 'Ghaul est le chef que quelle race?'),
(5, 'Qui a crée les spectres?'),
(6, 'Qui sont les principaux ennemis sur Mars?'),
(7, 'Qui sont les principaux ennemis sur Terre (Ancienne Russie) ?'),
(8, 'Quelle race \"habite\" dans \"Le Récif\" ?');

-- --------------------------------------------------------

--
-- Structure de la table `quiz_reponse`
--

DROP TABLE IF EXISTS `quiz_reponse`;
CREATE TABLE IF NOT EXISTS `quiz_reponse` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_question` int DEFAULT NULL,
  `reponse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `est_correcte` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_question` (`id_question`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `quiz_reponse`
--

INSERT INTO `quiz_reponse` (`id`, `id_question`, `reponse`, `est_correcte`) VALUES
(1, 1, 'Le Voyageur', 1),
(2, 2, 'Ghaul', 1),
(3, 3, 'Les Humains', 1),
(4, 4, 'Les Cabals', 1),
(5, 5, 'Le Voyageur', 1),
(6, 6, 'Les Cabals', 1),
(7, 7, 'Les Déchus', 1),
(8, 8, 'Les Eveillés', 1),
(9, 1, 'Des Vex', 0),
(10, 1, 'Des Cabals', 0),
(14, 2, 'Les Gardiens', 0),
(13, 1, 'De la Ruche', 0),
(15, 2, 'Les Vex', 0),
(16, 2, 'Les Déchus', 0),
(17, 3, 'Les Vex', 0),
(18, 3, 'Le Voyageur', 0),
(19, 3, 'Les Eveillés', 0),
(20, 4, 'Les Cabals', 0),
(21, 4, 'La Ruche', 0),
(22, 4, 'Infâmes', 0),
(23, 5, 'Les Humains', 0),
(24, 5, 'Les Vex', 0),
(25, 5, 'Les Eveillés', 0),
(26, 6, 'Les Infâmes', 0),
(27, 6, 'Les Déchus', 0),
(28, 6, 'La Ruche', 0),
(29, 7, 'La Ruche', 0),
(30, 7, 'Les Corrompus', 0),
(31, 7, 'Les Infâmes', 0),
(33, 8, 'Les Corrompus', 0),
(34, 8, 'Les Humains', 0),
(35, 8, 'Les Infâmes', 0);

-- --------------------------------------------------------

--
-- Structure de la table `score_quiz`
--

DROP TABLE IF EXISTS `score_quiz`;
CREATE TABLE IF NOT EXISTS `score_quiz` (
  `id` int NOT NULL AUTO_INCREMENT,
  `joueur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `score` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `score_quiz`
--

INSERT INTO `score_quiz` (`id`, `joueur`, `score`) VALUES
(1, 'Oreki', 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
