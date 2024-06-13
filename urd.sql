-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 13 juin 2024 à 11:49
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
-- Structure de la table `guesser`
--

DROP TABLE IF EXISTS `guesser`;
CREATE TABLE IF NOT EXISTS `guesser` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `guesser`
--

INSERT INTO `guesser` (`id`, `nom`, `img`) VALUES
(1, 'Cité des rêves', 'Dreaming City.png');

-- --------------------------------------------------------

--
-- Structure de la table `guesser_score`
--

DROP TABLE IF EXISTS `guesser_score`;
CREATE TABLE IF NOT EXISTS `guesser_score` (
  `id` int NOT NULL AUTO_INCREMENT,
  `joueur` varchar(255) NOT NULL,
  `score` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `guesser_score`
--

INSERT INTO `guesser_score` (`id`, `joueur`, `score`) VALUES
(1, 'Oreki', 80),
(6, 'sach', 10),
(7, 'teilo', 10),
(8, 'test', 10);

-- --------------------------------------------------------

--
-- Structure de la table `jeu_paires`
--

DROP TABLE IF EXISTS `jeu_paires`;
CREATE TABLE IF NOT EXISTS `jeu_paires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `score` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `jeu_paires`
--

INSERT INTO `jeu_paires` (`id`, `pseudo`, `score`) VALUES
(1, 'Oreki', 10),
(2, 'sach', 10),
(3, 'teilo', 10),
(4, 'test', 10);

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id`, `pseudo`, `email`, `mdp`) VALUES
(2, 'Oreki', 'gs10arunmoli@gmail.com', 'arun'),
(3, 'Maurice', 'mauricelataupe@gmail.com', 'maurice'),
(4, 'Oreki', 'arunmoli.sathiyaseelan@istlm.org', 'qrun'),
(5, 'sach', 'sach@gmail.com', 'azerty'),
(6, 'teilo', 'teiloira@gmail.com', 'test'),
(7, 'test', 'test@gmail.com', 'test');

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `niveau`
--

INSERT INTO `niveau` (`id`, `id_joueur`, `niveau`, `joueur`) VALUES
(1, 3, 1, 'Maurice'),
(2, 2, 4, 'Oreki'),
(6, 4, 4, 'Oreki'),
(7, 5, 2, 'sach'),
(8, 6, 4, 'teilo'),
(9, 7, 4, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `perso_combat`
--

DROP TABLE IF EXISTS `perso_combat`;
CREATE TABLE IF NOT EXISTS `perso_combat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `force` int NOT NULL,
  `vie` int NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `perso_combat`
--

INSERT INTO `perso_combat` (`id`, `nom`, `force`, `vie`, `img`) VALUES
(1, 'Rebut', 10, 50, 'Rebut.webp'),
(2, 'Cabal', 20, 75, 'Cabal.webp');

-- --------------------------------------------------------

--
-- Structure de la table `perso_joueur`
--

DROP TABLE IF EXISTS `perso_joueur`;
CREATE TABLE IF NOT EXISTS `perso_joueur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `force` int NOT NULL,
  `vie` int NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `perso_joueur`
--

INSERT INTO `perso_joueur` (`id`, `nom`, `force`, `vie`, `img`) VALUES
(1, 'Chasseur', 20, 60, 'chasseur.webp'),
(2, 'Titan', 30, 80, 'titan.png'),
(3, 'Arcaniste', 25, 70, 'arcaniste.png');

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
(20, 4, 'Les Eveillés', 0),
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
-- Structure de la table `score_combat`
--

DROP TABLE IF EXISTS `score_combat`;
CREATE TABLE IF NOT EXISTS `score_combat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `joueur` varchar(255) NOT NULL,
  `score` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `score_combat`
--

INSERT INTO `score_combat` (`id`, `joueur`, `score`) VALUES
(1, 'Oreki', 70),
(2, 'sach', 70),
(3, 'teilo', 60),
(4, 'test', 60);

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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `score_quiz`
--

INSERT INTO `score_quiz` (`id`, `joueur`, `score`) VALUES
(1, 'Oreki', 4),
(2, 'Maurice', 1),
(20, 'sach', 3),
(19, 'teilo', 3),
(21, 'test', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
