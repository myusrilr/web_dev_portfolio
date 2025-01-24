-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Nov 2024 pada 03.13
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blox_fuit`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `fruit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stock`
--

INSERT INTO `stock` (`id`, `fruit`) VALUES
(1, 'Rocket'),
(2, 'Spin'),
(3, 'Chop'),
(4, 'Spring'),
(5, 'Bomb'),
(6, 'Smoke'),
(7, 'Spike'),
(8, 'Flame'),
(9, 'Falcon'),
(10, 'Ice'),
(11, 'Sand'),
(12, 'Dark'),
(13, 'Diamond'),
(14, 'Light'),
(15, 'Rubber'),
(16, 'Barrier'),
(17, 'Magma'),
(18, 'Quake'),
(19, 'Buddha'),
(20, 'Ghost'),
(21, 'Love'),
(22, 'Spider'),
(23, 'Sound'),
(24, 'Phoenix'),
(25, 'Portal'),
(26, 'Rumble'),
(27, 'Pain'),
(28, 'Blizzard'),
(29, 'Gravity'),
(30, 'Mammoth'),
(31, 'T-Rex'),
(32, 'Dough'),
(33, 'Shadow'),
(34, 'Venom'),
(35, 'Dragon'),
(36, 'Leopard'),
(37, 'Control'),
(38, 'Spirit'),
(39, 'Kitsune');

-- --------------------------------------------------------

--
-- Struktur dari tabel `store_1`
--

CREATE TABLE `store_1` (
  `id` int(11) NOT NULL,
  `fruit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `store_1`
--

INSERT INTO `store_1` (`id`, `fruit`) VALUES
(1, 'Kitsune'),
(2, 'Kitsune'),
(3, 'Leopard'),
(4, 'Magma'),
(5, 'Phoenix'),
(6, 'Kitsune');

-- --------------------------------------------------------

--
-- Struktur dari tabel `store_2`
--

CREATE TABLE `store_2` (
  `id` int(11) NOT NULL,
  `fruit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `store_2`
--

INSERT INTO `store_2` (`id`, `fruit`) VALUES
(1, 'Kitsune'),
(2, 'Dough'),
(3, 'Leopard'),
(4, 'Kitsune');

-- --------------------------------------------------------

--
-- Struktur dari tabel `store_3`
--

CREATE TABLE `store_3` (
  `id` int(11) NOT NULL,
  `fruit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `store_3`
--

INSERT INTO `store_3` (`id`, `fruit`) VALUES
(1, 'Kitsune'),
(2, 'Dough'),
(3, 'Leopard'),
(4, 'Kitsune');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `store_1`
--
ALTER TABLE `store_1`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `store_2`
--
ALTER TABLE `store_2`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `store_3`
--
ALTER TABLE `store_3`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `store_1`
--
ALTER TABLE `store_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `store_2`
--
ALTER TABLE `store_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `store_3`
--
ALTER TABLE `store_3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
