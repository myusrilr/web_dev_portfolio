-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Okt 2024 pada 16.31
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
-- Database: `digital_file_manager`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` bigint(20) NOT NULL,
  `document_id` varchar(10) NOT NULL,
  `uploaded_by` varchar(255) NOT NULL,
  `account_type` enum('public','private','protected') NOT NULL,
  `document_status` enum('viewed','archived','deleted') DEFAULT 'viewed',
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `files`
--

INSERT INTO `files` (`id`, `file_name`, `file_type`, `file_size`, `document_id`, `uploaded_by`, `account_type`, `document_status`, `upload_time`, `file_path`) VALUES
(1, 'sampleGambar.jpg', 'image/jpeg', 1324580, 'D-001', '1', 'public', 'viewed', '2024-10-01 09:10:44', 'Assets/Uploads/sampleGambar.jpg'),
(2, 'samplePdf.pdf', 'application/pdf', 6105294, 'D-002', '1', 'private', 'viewed', '2024-10-01 09:11:00', 'Assets/Uploads/samplePdf.pdf'),
(3, 'sampletxt.txt', 'text/plain', 1137241, 'D-003', '1', 'protected', 'viewed', '2024-10-01 12:11:42', 'Assets/Uploads/sampleTxt.txt');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_id` (`document_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
