-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 16 sep. 2021 à 00:08
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crud`
--

-- --------------------------------------------------------

--
-- Structure de la table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `activity`
--

INSERT INTO `activity` (`id`, `project_id`, `name`) VALUES
(1, 1, 'activity1');

-- --------------------------------------------------------

--
-- Structure de la table `budget_line`
--

CREATE TABLE `budget_line` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `budget_line`
--

INSERT INTO `budget_line` (`id`, `project_id`, `name`, `percentage`) VALUES
(1, 1, 'Transport', 20);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `name`, `email`, `address`, `phone`) VALUES
(1, 'salem', 'salem@gmail.com', NULL, 94787515);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210902163033', '2021-09-11 21:04:18', 909),
('DoctrineMigrations\\Version20210903161720', '2021-09-11 21:04:19', 68),
('DoctrineMigrations\\Version20210904161446', '2021-09-11 21:04:19', 95),
('DoctrineMigrations\\Version20210905130247', '2021-09-11 21:04:19', 108),
('DoctrineMigrations\\Version20210908004543', '2021-09-11 21:04:19', 9166),
('DoctrineMigrations\\Version20210911112809', '2021-09-11 21:04:28', 69),
('DoctrineMigrations\\Version20210911135441', '2021-09-11 21:04:28', 1305),
('DoctrineMigrations\\Version20210911154223', '2021-09-11 21:04:30', 1357),
('DoctrineMigrations\\Version20210911190803', '2021-09-11 21:08:35', 1142);

-- --------------------------------------------------------

--
-- Structure de la table `operation`
--

CREATE TABLE `operation` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `budget_line_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `operation`
--

INSERT INTO `operation` (`id`, `activity_id`, `budget_line_id`, `name`, `date`, `price`, `description`) VALUES
(1, 1, 1, 'Promoting oneself', '2022/09/11', 1500, 'we are gonna make flyers'),
(2, 1, 1, 'op2', '12/26/2021', 9620.11, 'op2');

-- --------------------------------------------------------

--
-- Structure de la table `payment_trace`
--

CREATE TABLE `payment_trace` (
  `id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `trace_type_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `payment_trace`
--

INSERT INTO `payment_trace` (`id`, `operation_id`, `trace_type_id`, `name`, `file`) VALUES
(1, 1, 1, 'bill', 'inscri_insat-613d3262b87b1.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `payment_tranche`
--

CREATE TABLE `payment_tranche` (
  `id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payment_type`
--

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limitation` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` double NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `budget`, `client_id`) VALUES
(1, 'velo', 'test', 1500.6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `trace_type`
--

CREATE TABLE `trace_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trace_type`
--

INSERT INTO `trace_type` (`id`, `name`) VALUES
(1, 'pdf'),
(2, 'image');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `client_id`, `name`, `email`, `password`, `address`, `roles`, `role`) VALUES
(1, 1, 'mohamed', 'm@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$cDNjWFhGeGdPTXVkS3VDTg$wwcftCHlx72JWrBl5zvSdt0MpZDkABIztXr2sBXDx0I', '676 INSAT Centre Urbain Nord BP Tunis Cedex 1080', '\"[\\\"ROLE_ADMIN\\\"]\"', 'ADMIN');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AC74095A166D1F9C` (`project_id`);

--
-- Index pour la table `budget_line`
--
ALTER TABLE `budget_line`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_ABD0B6A6166D1F9C` (`project_id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1981A66D81C06096` (`activity_id`),
  ADD KEY `IDX_1981A66D8FF83FA3` (`budget_line_id`);

--
-- Index pour la table `payment_trace`
--
ALTER TABLE `payment_trace`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6612E31344AC3583` (`operation_id`),
  ADD KEY `IDX_6612E313D410CF1C` (`trace_type_id`);

--
-- Index pour la table `payment_tranche`
--
ALTER TABLE `payment_tranche`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7F2E56AA44AC3583` (`operation_id`),
  ADD KEY `IDX_7F2E56AADC058279` (`payment_type_id`);

--
-- Index pour la table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2FB3D0EE19EB6921` (`client_id`);

--
-- Index pour la table `trace_type`
--
ALTER TABLE `trace_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8D93D64919EB6921` (`client_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `budget_line`
--
ALTER TABLE `budget_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `operation`
--
ALTER TABLE `operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `payment_trace`
--
ALTER TABLE `payment_trace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `payment_tranche`
--
ALTER TABLE `payment_tranche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `trace_type`
--
ALTER TABLE `trace_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `FK_AC74095A166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);

--
-- Contraintes pour la table `budget_line`
--
ALTER TABLE `budget_line`
  ADD CONSTRAINT `FK_ABD0B6A6166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);

--
-- Contraintes pour la table `operation`
--
ALTER TABLE `operation`
  ADD CONSTRAINT `FK_1981A66D81C06096` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`),
  ADD CONSTRAINT `FK_1981A66D8FF83FA3` FOREIGN KEY (`budget_line_id`) REFERENCES `budget_line` (`id`);

--
-- Contraintes pour la table `payment_trace`
--
ALTER TABLE `payment_trace`
  ADD CONSTRAINT `FK_6612E31344AC3583` FOREIGN KEY (`operation_id`) REFERENCES `operation` (`id`),
  ADD CONSTRAINT `FK_6612E313D410CF1C` FOREIGN KEY (`trace_type_id`) REFERENCES `trace_type` (`id`);

--
-- Contraintes pour la table `payment_tranche`
--
ALTER TABLE `payment_tranche`
  ADD CONSTRAINT `FK_7F2E56AA44AC3583` FOREIGN KEY (`operation_id`) REFERENCES `operation` (`id`),
  ADD CONSTRAINT `FK_7F2E56AADC058279` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_type` (`id`);

--
-- Contraintes pour la table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `FK_2FB3D0EE19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D64919EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
