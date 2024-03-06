-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 mrt 2024 om 22:00
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
-- Tabelstructuur voor tabel `fellows`
--

CREATE TABLE `fellows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `fellows`
--

INSERT INTO `fellows` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Fiffi', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(2, 'Maxim', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(3, 'Reir', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(4, 'Pump', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(5, 'Knivi', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(6, 'Arake', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(7, 'Mirac', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(8, 'Boater', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(9, 'Geast', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(10, 'Björnson', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(11, 'Guarg', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(12, 'Woolf', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(13, 'Hawker', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(14, 'Rogile', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(15, 'Belle', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(16, 'Dr.Doctor', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(17, 'Kaity', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(18, 'Meaden', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(19, 'Lincale', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(20, 'Spipi', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(21, 'Witty', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(22, 'Rani', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(23, 'Angie', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(24, 'Denisa', '2024-02-20 12:13:02', '2024-02-20 12:13:02'),
(25, 'Brotein', '2024-02-20 12:13:02', '2024-02-20 12:13:02');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `fellows`
--
ALTER TABLE `fellows`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `fellows`
--
ALTER TABLE `fellows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
