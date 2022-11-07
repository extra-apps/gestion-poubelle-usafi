-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 05 nov. 2022 à 16:06
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `amada_db`
--
CREATE DATABASE IF NOT EXISTS `amada_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `amada_db`;

-- --------------------------------------------------------

--
-- Structure de la table `chef_projet`
--

CREATE TABLE `chef_projet` (
  `id` int(11) NOT NULL,
  `nomchefprojet` varchar(128) DEFAULT NULL,
  `fonction` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `equipe_projet`
--

CREATE TABLE `equipe_projet` (
  `id` int(11) NOT NULL,
  `nom` varchar(128) DEFAULT NULL,
  `role` varchar(128) DEFAULT NULL,
  `service` varchar(128) DEFAULT NULL,
  `observation` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plan_action`
--

CREATE TABLE `plan_action` (
  `id` int(11) NOT NULL,
  `codeplan` varchar(128) DEFAULT NULL,
  `priorite` varchar(128) DEFAULT NULL,
  `sujetaction` varchar(128) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `dateaction` date DEFAULT NULL,
  `statusaction` varchar(128) DEFAULT NULL,
  `dateplanfin` date DEFAULT NULL,
  `actionsuivant` varchar(128) DEFAULT NULL,
  `typeaction` varchar(128) DEFAULT NULL,
  `datereelfin` date DEFAULT NULL,
  `risque_id` int(11) NOT NULL,
  `dateajout` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `nomprojet` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `caracteristique` text DEFAULT NULL,
  `competences` text DEFAULT NULL,
  `datedebut` datetime DEFAULT NULL,
  `datefin` datetime DEFAULT NULL,
  `cout` varchar(128) DEFAULT NULL,
  `delaiclient` varchar(128) DEFAULT NULL,
  `elementcontrat` text DEFAULT NULL,
  `coordonateurqualite` text DEFAULT NULL,
  `expertdesigner` varchar(128) DEFAULT NULL,
  `periodicitereunion` varchar(128) DEFAULT NULL,
  `devis` varchar(128) DEFAULT NULL,
  `cahierdecharge` text DEFAULT NULL,
  `planning` text DEFAULT NULL,
  `specificationsystem` varchar(128) DEFAULT NULL,
  `plandevelopement` varchar(128) DEFAULT NULL,
  `observationcp` varchar(128) DEFAULT NULL,
  `planqualite` varchar(128) DEFAULT NULL,
  `planvalidation` text DEFAULT NULL,
  `nomequipe` varchar(128) DEFAULT NULL,
  `dateajout` datetime DEFAULT current_timestamp(),
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `risque`
--

CREATE TABLE `risque` (
  `id` int(11) NOT NULL,
  `nomclient` varchar(128) DEFAULT NULL,
  `categorierisque` varchar(128) DEFAULT NULL,
  `probabilitedoccurence` int(11) DEFAULT NULL,
  `impact` varchar(128) DEFAULT NULL,
  `gravite` varchar(128) DEFAULT NULL,
  `source` varchar(128) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `daterisque` date DEFAULT NULL,
  `actionmitigation` varchar(128) DEFAULT NULL,
  `coefficientexposition` varchar(128) DEFAULT NULL,
  `etatrisque` varchar(128) DEFAULT NULL,
  `datelimite` date DEFAULT NULL,
  `projet_id` int(11) NOT NULL,
  `dateajout` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `telephone` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_role` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fonction` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role1` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observation` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users_has_risque`
--

CREATE TABLE `users_has_risque` (
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `risque_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chef_projet`
--
ALTER TABLE `chef_projet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `equipe_projet`
--
ALTER TABLE `equipe_projet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `plan_action`
--
ALTER TABLE `plan_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_plan_action_risque1_idx` (`risque_id`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_projet_users1_idx` (`users_id`);

--
-- Index pour la table `risque`
--
ALTER TABLE `risque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_risque_projet_idx` (`projet_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `users_has_risque`
--
ALTER TABLE `users_has_risque`
  ADD PRIMARY KEY (`users_id`,`risque_id`),
  ADD KEY `fk_users_has_risque_risque1_idx` (`risque_id`),
  ADD KEY `fk_users_has_risque_users1_idx` (`users_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chef_projet`
--
ALTER TABLE `chef_projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `equipe_projet`
--
ALTER TABLE `equipe_projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `plan_action`
--
ALTER TABLE `plan_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `risque`
--
ALTER TABLE `risque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `plan_action`
--
ALTER TABLE `plan_action`
  ADD CONSTRAINT `fk_plan_action_risque1` FOREIGN KEY (`risque_id`) REFERENCES `risque` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `fk_projet_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `risque`
--
ALTER TABLE `risque`
  ADD CONSTRAINT `fk_risque_projet` FOREIGN KEY (`projet_id`) REFERENCES `projet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users_has_risque`
--
ALTER TABLE `users_has_risque`
  ADD CONSTRAINT `fk_users_has_risque_risque1` FOREIGN KEY (`risque_id`) REFERENCES `risque` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_has_risque_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
