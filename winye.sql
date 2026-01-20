-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 19 jan. 2026 à 13:28
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `winye`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compte_utilisateurs`
--

DROP TABLE IF EXISTS `compte_utilisateurs`;
CREATE TABLE IF NOT EXISTS `compte_utilisateurs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` enum('actif','inactif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'actif',
  `role_id` bigint UNSIGNED NOT NULL,
  `reset_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token_expire_at` timestamp NULL DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `compte_utilisateurs_email_unique` (`email`),
  KEY `compte_utilisateurs_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `compte_utilisateurs`
--

INSERT INTO `compte_utilisateurs` (`id`, `email`, `password`, `statut`, `role_id`, `reset_token`, `reset_token_expire_at`, `date_creation`, `created_at`, `updated_at`) VALUES
(1, 'fokouatony@gmail.com', '$2y$12$x4n/B0mRE2CAV6/K8Cdi7uwrFESsgN2TVasjsBSH.tW.bA7qLS3Uu', 'actif', 4, NULL, NULL, '2026-01-12 18:59:48', '2026-01-12 18:59:48', '2026-01-12 18:59:48'),
(2, 'queenelvyge@gmail.com', '$2y$12$zjLpwkdIspAnttd1v1qxm.sl1FcpqUQu8rCFsyKbii8vKUGDjZeUC', 'inactif', 1, NULL, NULL, '2026-01-12 20:48:30', '2026-01-12 20:48:30', '2026-01-12 20:48:30');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '0001_01_01_000001_create_cache_table', 1),
(5, '0001_01_01_000002_create_jobs_table', 1),
(6, '2026_01_12_021843_create_roles_table', 1),
(7, '2026_01_12_022534_create_compte_utilisateurs_table', 2),
(8, '2026_01_12_023607_create_utilisateurs_table', 3),
(9, '2026_01_12_184752_add_matricule_to_utilisateurs_table', 4),
(10, '2026_01_18_202745_create_notifications_table', 5);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('info','alerte','system') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `compte_utilisateur_id` bigint UNSIGNED DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `is_lu` tinyint(1) NOT NULL DEFAULT '0',
  `date_lecture` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_compte_utilisateur_id_foreign` (`compte_utilisateur_id`),
  KEY `notifications_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `titre`, `message`, `type`, `compte_utilisateur_id`, `role_id`, `is_lu`, `date_lecture`, `created_at`, `updated_at`) VALUES
(1, 'Test  de notification', 'Bonjour Administrateur Tony', 'info', 1, NULL, 0, NULL, '2026-01-19 08:23:28', '2026-01-19 08:23:28');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_libelle_unique` (`libelle`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `libelle`, `created_at`, `updated_at`) VALUES
(1, 'etudiant', '2026-01-12 02:00:33', '2026-01-12 02:00:33'),
(2, 'enseignant', '2026-01-12 02:00:33', '2026-01-12 02:00:33'),
(3, 'secretaire', '2026-01-12 02:00:33', '2026-01-12 02:00:33'),
(4, 'administrateur', '2026-01-12 02:00:33', '2026-01-12 02:00:33');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `compte_utilisateur_id` bigint UNSIGNED NOT NULL,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` enum('standard','premium') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standard',
  `date_debut_premium` date DEFAULT NULL,
  `date_fin_premium` date DEFAULT NULL,
  `photo_profil` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filiere_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `utilisateurs_matricule_unique` (`matricule`),
  KEY `utilisateurs_compte_utilisateur_id_foreign` (`compte_utilisateur_id`),
  KEY `utilisateurs_filiere_id_foreign` (`filiere_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `compte_utilisateur_id`, `nom`, `prenom`, `matricule`, `date_naissance`, `telephone`, `mode`, `date_debut_premium`, `date_fin_premium`, `photo_profil`, `filiere_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kengne', 'Tony', NULL, '2003-07-23', '672815824', 'standard', NULL, NULL, 'profiles/UGKB47CSQ7ev05r0xeA4SspzhPaYbGJDvXCpwQkD.jpg', NULL, '2026-01-12 18:59:48', '2026-01-19 08:13:14'),
(2, 2, 'Tsakem', 'Florence Evyra', NULL, NULL, NULL, 'standard', NULL, NULL, NULL, NULL, '2026-01-12 20:48:30', '2026-01-12 20:48:30');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
