-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Agu 2025 pada 07.50
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stok`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dapur`
--

CREATE TABLE `dapur` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `asal` varchar(50) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `konfirmasi` enum('Belum','Sudah') DEFAULT 'Belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dapur`
--

INSERT INTO `dapur` (`id`, `kode`, `nama`, `asal`, `stok`, `created_at`, `updated_at`, `konfirmasi`) VALUES
(1, 'H', 'Hijau', NULL, 32, '2025-08-05 06:14:45', '2025-08-05 13:50:12', 'Sudah'),
(2, 'D', 'Dara', NULL, 32, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(3, 'BT', 'Batik', NULL, 8, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(4, 'BB', 'Bambu', NULL, 14, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(5, 'S', 'Simping', NULL, 20, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(6, 'T', 'Tahu', NULL, 15, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(7, 'O', 'Octopus', NULL, 18, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(8, 'S', 'Sotong', NULL, 12, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(9, 'C', 'Cumi-cumi', NULL, 4, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(10, 'U', 'Udang', NULL, 30, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(11, 'LK', 'Lobster Kecil', NULL, 30, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(12, 'LB', 'Lobster Besar', NULL, 15, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(13, 'KK', 'Kepiting Kecil', NULL, 21, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(14, 'KB', 'Kepiting Besar', NULL, 16, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(15, 'KTK', 'K Telur Kecil', NULL, 16, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(16, 'KTB', 'K Telur Besar', NULL, 8, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(17, 'J', 'Jagung', NULL, 70, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(18, 'AM', 'Asam Manis', NULL, 5, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(19, 'J', 'Jeletot', NULL, 3, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(20, 'LH', 'Lada Hitam', NULL, 3, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(21, 'CO', 'Chili Oil', NULL, 2, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(22, 'H', 'Hijau', 'Taman', 2, '2025-08-05 08:10:41', '2025-08-05 11:28:55', 'Belum'),
(23, 'D', 'Dara', 'Taman', 5, '2025-08-05 08:55:00', '2025-08-06 05:27:08', 'Belum'),
(24, 'H', 'Hijau', 'Pahlawan', 7, '2025-08-05 09:19:15', '2025-08-05 09:34:04', 'Sudah'),
(25, 'H', 'Hijau', 'Pahlawan', 7, '2025-08-05 09:25:25', '2025-08-05 11:32:42', 'Belum'),
(26, 'H', 'Hijau', 'Pahlawan', 3, '2025-08-05 09:57:08', '2025-08-05 12:23:36', 'Belum'),
(27, 'H', 'Hijau', 'Penjualan', 5, '2025-08-05 13:14:47', '2025-08-05 13:14:47', 'Sudah'),
(28, 'H', 'Hijau', 'Rusak', 1, '2025-08-05 13:50:13', '2025-08-05 13:50:13', 'Sudah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pahlawan`
--

CREATE TABLE `pahlawan` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `asal` varchar(50) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `konfirmasi` enum('Belum','Sudah') DEFAULT 'Belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pahlawan`
--

INSERT INTO `pahlawan` (`id`, `kode`, `nama`, `asal`, `stok`, `created_at`, `updated_at`, `konfirmasi`) VALUES
(1, 'H', 'Hijau', NULL, 52, '2025-08-05 06:14:45', '2025-08-05 13:42:15', 'Sudah'),
(2, 'D', 'Dara', NULL, 32, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(3, 'BT', 'Batik', NULL, 8, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(4, 'BB', 'Bambu', NULL, 14, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(5, 'S', 'Simping', NULL, 20, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(6, 'T', 'Tahu', NULL, 15, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(7, 'O', 'Octopus', NULL, 18, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(8, 'S', 'Sotong', NULL, 12, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(9, 'C', 'Cumi-cumi', NULL, 4, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(10, 'U', 'Udang', NULL, 30, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(11, 'LK', 'Lobster Kecil', NULL, 30, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(12, 'LB', 'Lobster Besar', NULL, 15, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(13, 'KK', 'Kepiting Kecil', NULL, 21, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(14, 'KB', 'Kepiting Besar', NULL, 16, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(15, 'KTK', 'K Telur Kecil', NULL, 16, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(16, 'KTB', 'K Telur Besar', NULL, 8, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(17, 'J', 'Jagung', NULL, 70, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(18, 'AM', 'Asam Manis', NULL, 5, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(19, 'J', 'Jeletot', NULL, 3, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(20, 'LH', 'Lada Hitam', NULL, 3, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(21, 'CO', 'Chili Oil', NULL, 2, '2025-08-05 06:14:45', '2025-08-05 07:46:08', 'Sudah'),
(22, 'H', 'Hijau', 'Taman', 5, '2025-08-05 06:46:46', '2025-08-06 05:46:59', 'Belum'),
(23, 'D', 'Dara', 'Taman', 3, '2025-08-05 06:55:54', '2025-08-06 02:35:10', 'Belum'),
(24, 'H', 'Hijau', 'Dapur', 2, '2025-08-05 07:42:45', '2025-08-05 10:53:02', 'Belum'),
(25, 'H', 'Hijau', 'Dapur', 5, '2025-08-05 10:08:27', '2025-08-05 10:52:43', 'Belum'),
(26, 'H', 'Hijau', 'Penjualan', 1, '2025-08-05 13:21:58', '2025-08-05 13:21:58', 'Sudah'),
(27, 'H', 'Hijau', 'Rusak', 3, '2025-08-05 13:42:15', '2025-08-05 13:42:15', 'Sudah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `taman`
--

CREATE TABLE `taman` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `asal` varchar(50) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `konfirmasi` enum('Belum','Sudah') DEFAULT 'Belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `taman`
--

INSERT INTO `taman` (`id`, `kode`, `nama`, `asal`, `stok`, `created_at`, `updated_at`, `konfirmasi`) VALUES
(1, 'H', 'Hijau', NULL, 26, '2025-08-05 04:22:47', '2025-08-05 13:38:08', 'Sudah'),
(2, 'D', 'Dara', NULL, 25, '2025-08-05 04:22:47', '2025-08-05 08:55:00', 'Sudah'),
(3, 'BT', 'Batik', NULL, 8, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(4, 'BB', 'Bambu', NULL, 14, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(5, 'S', 'Simping', NULL, 20, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(6, 'T', 'Tahu', NULL, 15, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(7, 'O', 'Octopus', NULL, 18, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(8, 'S', 'Sotong', NULL, 12, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(9, 'C', 'Cumi-cumi', NULL, 4, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(10, 'U', 'Udang', NULL, 30, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(11, 'LK', 'Lobster Kecil', NULL, 30, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(12, 'LB', 'Lobster Besar', NULL, 15, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(13, 'KK', 'Kepiting Kecil', NULL, 21, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(14, 'KB', 'Kepiting Besar', NULL, 16, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(15, 'KTK', 'K Telur Kecil', NULL, 16, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(16, 'KTB', 'K Telur Besar', NULL, 8, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(17, 'J', 'Jagung', NULL, 70, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(18, 'AM', 'Asam Manis', NULL, 5, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(19, 'J', 'Jeletot', NULL, 3, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(20, 'LH', 'Lada Hitam', NULL, 3, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(21, 'CO', 'Chili Oil', NULL, 2, '2025-08-05 04:22:47', '2025-08-05 07:46:08', 'Sudah'),
(22, 'H', 'Hijau', 'Pahlawan', 3, '2025-08-05 08:08:08', '2025-08-06 05:45:06', 'Belum'),
(23, 'H', 'Hijau', 'Pahlawan', 1, '2025-08-05 09:30:03', '2025-08-06 05:48:07', 'Belum'),
(24, 'H', 'Hijau', 'Dapur', 4, '2025-08-05 09:52:05', '2025-08-05 12:03:16', 'Sudah'),
(25, 'H', 'Hijau', 'Dapur', 9, '2025-08-05 09:58:51', '2025-08-05 11:48:56', 'Belum'),
(26, 'H', 'Hijau', 'Dapur', 1, '2025-08-05 10:01:42', '2025-08-05 11:49:09', 'Belum'),
(27, 'H', 'Hijau', 'Penjualan', 2, '2025-08-05 13:29:01', '2025-08-05 13:29:01', 'Sudah'),
(28, 'H', 'Hijau', 'Penjualan', 1, '2025-08-05 13:33:44', '2025-08-05 13:34:51', 'Sudah'),
(29, 'H', 'Hijau', 'Rusak', 7, '2025-08-05 13:38:08', '2025-08-05 13:38:08', 'Sudah');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dapur`
--
ALTER TABLE `dapur`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pahlawan`
--
ALTER TABLE `pahlawan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `taman`
--
ALTER TABLE `taman`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dapur`
--
ALTER TABLE `dapur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `pahlawan`
--
ALTER TABLE `pahlawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `taman`
--
ALTER TABLE `taman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
