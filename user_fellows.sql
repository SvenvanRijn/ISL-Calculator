-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 mrt 2024 om 22:01
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isl_calculator`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_fellows`
--

CREATE TABLE `user_fellows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fellow_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `power` bigint(20) NOT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user_fellows`
--

INSERT INTO `user_fellows` (`id`, `fellow_id`, `user_id`, `power`, `extra`, `created_at`, `updated_at`) VALUES
(6, 6, 1, 2170982, NULL, '2024-02-20 21:34:57', '2024-02-20 21:34:57'),
(7, 7, 1, 2180021, NULL, '2024-02-20 21:35:23', '2024-02-20 21:35:23'),
(1, 1, 1, 2306746, NULL, '2024-02-20 20:43:47', '2024-02-20 20:43:47'),
(2, 2, 1, 2391627, NULL, '2024-02-20 20:51:02', '2024-02-20 20:51:02'),
(3, 5, 1, 2404370, NULL, '2024-02-20 20:53:34', '2024-02-20 20:53:34'),
(8, 8, 1, 2439868, NULL, '2024-02-20 21:35:50', '2024-02-20 21:35:50'),
(53, 9, 1, 2441907, NULL, '2024-02-22 19:48:46', '2024-02-22 19:48:46'),
(52, 10, 1, 2461295, NULL, '2024-02-22 19:48:35', '2024-02-22 19:48:35'),
(4, 4, 1, 2500159, NULL, '2024-02-20 21:00:57', '2024-02-20 21:00:57'),
(51, 11, 1, 2583218, NULL, '2024-02-22 19:48:17', '2024-02-22 19:48:17'),
(50, 13, 1, 2588322, NULL, '2024-02-22 19:47:59', '2024-02-22 19:47:59'),
(49, 12, 1, 2601584, NULL, '2024-02-22 19:47:10', '2024-02-22 19:47:10'),
(48, 14, 1, 2626883, NULL, '2024-02-22 19:46:53', '2024-02-22 19:46:53'),
(47, 15, 1, 2634884, NULL, '2024-02-22 19:46:36', '2024-02-22 19:46:36'),
(46, 16, 1, 2661656, NULL, '2024-02-22 19:46:18', '2024-02-22 19:46:18'),
(45, 64, 1, 2850203, NULL, '2024-02-22 19:46:02', '2024-02-22 19:46:02'),
(44, 18, 1, 3055412, NULL, '2024-02-22 19:43:33', '2024-02-22 19:43:33'),
(41, 20, 1, 3151340, NULL, '2024-02-22 19:42:04', '2024-02-22 19:42:04'),
(40, 21, 1, 3223925, NULL, '2024-02-22 19:41:45', '2024-02-22 19:41:45'),
(39, 22, 1, 3226300, NULL, '2024-02-22 19:41:27', '2024-02-22 19:41:27'),
(38, 23, 1, 3246190, NULL, '2024-02-22 19:41:07', '2024-02-22 19:41:07'),
(37, 24, 1, 3272112, NULL, '2024-02-22 19:40:47', '2024-02-22 19:40:47'),
(5, 3, 1, 3368810, NULL, '2024-02-20 21:01:48', '2024-02-20 21:01:48'),
(43, 17, 1, 3392073, NULL, '2024-02-22 19:43:20', '2024-02-22 19:43:20'),
(36, 25, 1, 3520290, NULL, '2024-02-22 19:40:30', '2024-02-22 19:40:30');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `user_fellows`
--
ALTER TABLE `user_fellows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_fellows_fellow_id_foreign` (`fellow_id`),
  ADD KEY `user_fellows_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `user_fellows`
--
ALTER TABLE `user_fellows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `user_fellows`
--
ALTER TABLE `user_fellows`
  ADD CONSTRAINT `user_fellows_fellow_id_foreign` FOREIGN KEY (`fellow_id`) REFERENCES `fellows` (`id`),
  ADD CONSTRAINT `user_fellows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
