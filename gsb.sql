-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 04 Avril 2018 à 08:25
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gsb`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptables`
--

CREATE TABLE `comptables` (
  `id` int(11) NOT NULL,
  `utilisateur` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `comptables`
--

INSERT INTO `comptables` (`id`, `utilisateur`, `mdp`) VALUES
(1, 'Adel', 'Azerty22'),
(2, 'root', '');

-- --------------------------------------------------------

--
-- Structure de la table `frais_forfait`
--

CREATE TABLE `frais_forfait` (
  `id` int(11) NOT NULL,
  `id_visiteur` int(11) NOT NULL,
  `nuits` int(11) NOT NULL,
  `repas` int(11) NOT NULL,
  `kilometres` int(11) NOT NULL,
  `date` date NOT NULL,
  `statut` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `frais_forfait`
--

INSERT INTO `frais_forfait` (`id`, `id_visiteur`, `nuits`, `repas`, `kilometres`, `date`, `statut`) VALUES
(1, 1, 1, 1, 1, '2017-11-01', 2),
(3, 1, 25, 15, 35, '2017-12-01', 0),
(6, 1, 8, 9, 20, '2018-01-01', 2),
(17, 3, 0, 0, 0, '2018-03-01', 0),
(16, 1, 2, 3, 1, '2018-03-01', 1),
(15, 1, 1, 1, 1, '2018-02-01', 0),
(14, 2, 4, 4, 4, '2018-01-01', 1),
(18, 1, 0, 0, 0, '2018-04-01', 0);

-- --------------------------------------------------------

--
-- Structure de la table `hors_forfait`
--

CREATE TABLE `hors_forfait` (
  `id` int(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `libelle` varchar(2048) NOT NULL,
  `date` date NOT NULL,
  `montant` decimal(65,0) NOT NULL,
  `justificatif` varchar(255) DEFAULT NULL,
  `statut` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hors_forfait`
--

INSERT INTO `hors_forfait` (`id`, `id_user`, `libelle`, `date`, `montant`, `justificatif`, `statut`) VALUES
(86, 1, 'test', '2017-12-12', '2', 'justificatifs/1/1514941496RAM_wallpaper2.png', 0),
(54, 1, 'ps4', '2017-11-22', '300', '', 1),
(106, 2, 'RAM', '2018-01-13', '99999999999', 'justificatifs/2/1514947220RAM_wallpaper2.png', 2),
(107, 1, 'RAM 2', '2018-01-13', '99999999999999', 'justificatifs/1/1514947250RAM_wallpaper.jpg', 2),
(109, 1, 'test 3', '2018-01-18', '2', '', 1),
(113, 1, 'Frais de transport', '2018-03-09', '14', 'justificatifs/1/152145186827591497_10214966817346750_956810747_n.png', 2),
(114, 1, 'Achat tÃ©lÃ©phone', '2018-03-23', '350', '', 2);

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

CREATE TABLE `visiteur` (
  `id` int(11) NOT NULL,
  `utilisateur` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `visiteur`
--

INSERT INTO `visiteur` (`id`, `utilisateur`, `mdp`) VALUES
(1, 'Kevin', 'Azerty22'),
(2, 'thomas', 'password'),
(3, 'btsblanc', '12345');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comptables`
--
ALTER TABLE `comptables`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `frais_forfait`
--
ALTER TABLE `frais_forfait`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `hors_forfait`
--
ALTER TABLE `hors_forfait`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `visiteur`
--
ALTER TABLE `visiteur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comptables`
--
ALTER TABLE `comptables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `frais_forfait`
--
ALTER TABLE `frais_forfait`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `hors_forfait`
--
ALTER TABLE `hors_forfait`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT pour la table `visiteur`
--
ALTER TABLE `visiteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
