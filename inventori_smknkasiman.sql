-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 03:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventori_smknkasiman`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username_admin` char(50) NOT NULL,
  `password_admin` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `id_ruangbarang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `stok_barang` int(11) DEFAULT NULL,
  `status_barang` enum('Tetap','Pakai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_pj` int(11) DEFAULT NULL,
  `waktu` datetime NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_pj` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `status_peminjaman` enum('Pinjam','Kembali') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `tanggal_serah` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pj_ruang`
--

CREATE TABLE `pj_ruang` (
  `id_pj` int(11) NOT NULL,
  `nama_pj` varchar(100) NOT NULL,
  `jk_pj` enum('Laki-laki','Perempuan') NOT NULL,
  `telp_pj` char(18) NOT NULL,
  `alamat_pj` varchar(255) NOT NULL,
  `username_pj` char(50) NOT NULL,
  `password_pj` char(20) NOT NULL,
  `id_ruangbarang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pj_ruang`
--

INSERT INTO `pj_ruang` (`id_pj`, `nama_pj`, `jk_pj`, `telp_pj`, `alamat_pj`, `username_pj`, `password_pj`, `id_ruangbarang`) VALUES
(1, 'pj 1', 'Laki-laki', '01231', 'Jalan a', 'pj1', 'pj1', 1),
(2, 'pj 2', 'Laki-laki', '3123123', 'Jalan b', 'pj2', 'pj2', 2),
(3, 'pj 3', 'Laki-laki', '123123', 'Jalan c', 'pj3', 'pj3', 3),
(4, 'pj 4', 'Laki-laki', '2222', 'Jalan d', 'pj4', 'pj4', 4),
(5, 'pj 5', 'Laki-laki', '3332', 'Jalan e', 'pj5', 'pj5', 5),
(6, 'pj 6', 'Laki-laki', '4343', 'Jalan f', 'pj6', 'pj6', 6),
(7, 'pj 7', 'Laki-laki', '1231111', 'Jalan g', 'pj7', 'pj7', 7);

-- --------------------------------------------------------

--
-- Table structure for table `ruang_barang`
--

CREATE TABLE `ruang_barang` (
  `id_ruangbarang` int(11) NOT NULL,
  `role_ruang` enum('Lab','Bengkel') NOT NULL,
  `nama_ruangbarang` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruang_barang`
--

INSERT INTO `ruang_barang` (`id_ruangbarang`, `role_ruang`, `nama_ruangbarang`) VALUES
(1, 'Lab', 'Teknik Komputer dan Jaringan'),
(2, 'Lab', 'Desain Komunikasi Visual'),
(3, 'Lab', 'Akuntansi dan Keuangan Lembaga'),
(4, 'Lab', 'CBT'),
(5, 'Bengkel', 'Teknik Kendaraan Ringan'),
(6, 'Bengkel', 'Teknik Ototronik'),
(7, 'Bengkel', 'Teknik Pengelasan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `ni_user` char(20) NOT NULL,
  `jk_user` enum('Laki - laki','Perempuan') NOT NULL,
  `telp_user` char(18) NOT NULL,
  `alamat_user` varchar(255) NOT NULL,
  `username_user` char(50) NOT NULL,
  `password_user` char(20) NOT NULL,
  `role_user` enum('Guru','Siswa','Kepsek') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `ni_user`, `jk_user`, `telp_user`, `alamat_user`, `username_user`, `password_user`, `role_user`) VALUES
(1, 'Galih User', '190411100177', 'Laki - laki', '081939301705', 'Jalan Bandeng NO 5 RT/RW 006/001 Kolor Kec. Kota Sumenep, Sumenep', '190411100177', '190411100177', 'Siswa'),
(2, 'Galih Guru', '112233', 'Laki - laki', '081939301923', 'Jalan Mana Saja Yang Penting OKE', '112233', '112233', 'Guru'),
(3, 'Galih Kepsek', '123', 'Perempuan', '123123123', 'Jalan Yogyakarta Sumenep OKE', '123', '123', 'Kepsek');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`);

--
-- Indexes for table `pj_ruang`
--
ALTER TABLE `pj_ruang`
  ADD PRIMARY KEY (`id_pj`);

--
-- Indexes for table `ruang_barang`
--
ALTER TABLE `ruang_barang`
  ADD PRIMARY KEY (`id_ruangbarang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pj_ruang`
--
ALTER TABLE `pj_ruang`
  MODIFY `id_pj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ruang_barang`
--
ALTER TABLE `ruang_barang`
  MODIFY `id_ruangbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
