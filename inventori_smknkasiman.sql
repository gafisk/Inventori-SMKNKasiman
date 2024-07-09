-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2024 at 06:57 AM
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

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username_admin`, `password_admin`) VALUES
(1, 'admin 1', 'admin', 'admin123');

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

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `id_ruangbarang`, `nama_barang`, `stok_barang`, `status_barang`) VALUES
(4, 1, 'Keyboard', 5, 'Tetap'),
(6, 1, 'Bom', 10, 'Pakai'),
(7, 6, 'Kabel', 3, 'Tetap'),
(8, 4, 'Komputer', 5, 'Pakai');

-- --------------------------------------------------------

--
-- Table structure for table `keadaan_barang`
--

CREATE TABLE `keadaan_barang` (
  `id_keadaanbarang` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_baik` int(11) NOT NULL,
  `jumlah_rusak` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keadaan_barang`
--

INSERT INTO `keadaan_barang` (`id_keadaanbarang`, `id_barang`, `jumlah_baik`, `jumlah_rusak`) VALUES
(1, 4, 4, 1),
(3, 6, 3, 7),
(4, 7, 2, 1),
(5, 8, 4, 1);

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

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `id_admin`, `id_pj`, `waktu`, `keterangan`) VALUES
(1, 1, NULL, '2024-07-05 21:33:44', 'ADMIN Login'),
(3, 1, NULL, '2024-07-05 21:36:18', 'ADMIN Login'),
(4, 1, NULL, '2024-07-07 21:57:14', 'ADMIN Login'),
(5, 1, NULL, '2024-07-07 21:58:37', 'ADMIN Logout'),
(6, 1, NULL, '2024-07-07 21:58:50', 'ADMIN Login');

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

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_pj`, `id_user`, `id_barang`, `tanggal_pinjam`, `tanggal_kembali`, `status_peminjaman`) VALUES
(4, 8, 1, 6, '2024-07-01', '2024-09-01', 'Kembali'),
(5, 8, 2, 6, '2024-07-03', '2024-09-03', 'Kembali'),
(6, 8, 1, 6, '2024-07-05', '2024-09-05', 'Pinjam'),
(7, 11, 7, 8, '2024-07-05', '2024-09-05', 'Kembali');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `id_pj` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `id_pj`, `id_peminjaman`, `tanggal_pinjam`, `tanggal_kembali`) VALUES
(3, 8, 5, '2024-07-03', '2024-07-03'),
(4, 8, 4, '2024-07-01', '2024-07-05'),
(5, 11, 7, '2024-07-05', '2024-07-05');

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
(8, 'Ketua 1', 'Laki-laki', '123123', 'asdhasdah', 'PJ2', 'PJ2', 1),
(10, 'Ketua 2', 'Laki-laki', '113331', 'Jalan mana', 'ketua2', 'ketua2', 6),
(11, 'Pj Baru', 'Perempuan', '1312313123', 'Mana Saja', 'PJ3', 'PJ3', 4);

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
(1, 'User', '111111', 'Perempuan', '0819393017', 'Jalan Bandeng NO 5 RT/RW 006/001 Kolor Kec. Kota Sumenep, Sumenep', '111111', '111111', 'Siswa'),
(2, 'Guru', '112233', 'Laki - laki', '081939301923', 'Jalan Mana Saja Yang Penting OKE', '112233', '112233', 'Guru'),
(3, 'Kepsek', '123', 'Laki - laki', '123123123', 'Jalan Yogyakarta Sumenep OKE', '123', '123', 'Kepsek'),
(7, 'Alfi', '123321', 'Perempuan', '000000000', 'UTM', '123321', '123321', 'Siswa');

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
-- Indexes for table `keadaan_barang`
--
ALTER TABLE `keadaan_barang`
  ADD PRIMARY KEY (`id_keadaanbarang`);

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
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `keadaan_barang`
--
ALTER TABLE `keadaan_barang`
  MODIFY `id_keadaanbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pj_ruang`
--
ALTER TABLE `pj_ruang`
  MODIFY `id_pj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ruang_barang`
--
ALTER TABLE `ruang_barang`
  MODIFY `id_ruangbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
