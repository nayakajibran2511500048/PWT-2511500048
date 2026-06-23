-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2026 at 12:20 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absen`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen_datang`
--

CREATE TABLE `absen_datang` (
  `id_datang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_datang` varchar(25) NOT NULL,
  `status_datang` enum('Ontime','Telat') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absen_datang`
--

INSERT INTO `absen_datang` (`id_datang`, `id_user`, `tanggal`, `jam_datang`, `status_datang`) VALUES
(6, 1, '2026-06-16', '18:04:54', 'Telat'),
(7, 4, '2026-06-16', '18:22:07', 'Telat');

-- --------------------------------------------------------

--
-- Table structure for table `absen_pulang`
--

CREATE TABLE `absen_pulang` (
  `id_pulang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_pulang` varchar(20) NOT NULL,
  `status_pulang` enum('Ontime','Pulang Cepat') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absen_pulang`
--

INSERT INTO `absen_pulang` (`id_pulang`, `id_user`, `tanggal`, `jam_pulang`, `status_pulang`) VALUES
(5, 1, '2026-06-16', '18:04:58', 'Ontime'),
(6, 4, '2026-06-16', '18:22:13', 'Ontime');

-- --------------------------------------------------------

--
-- Table structure for table `jam_kerja`
--

CREATE TABLE `jam_kerja` (
  `id_jam` int(11) NOT NULL,
  `hari` varchar(15) NOT NULL,
  `jam_masuk_mulai` varchar(20) NOT NULL,
  `jam_masuk_batas` varchar(20) NOT NULL,
  `jam_pulang_mulai` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jam_kerja`
--

INSERT INTO `jam_kerja` (`id_jam`, `hari`, `jam_masuk_mulai`, `jam_masuk_batas`, `jam_pulang_mulai`) VALUES
(1, 'Senin', '06:00:00', '08:30:00', '16:00:00'),
(2, 'Selasa', '06:00:00', '08:30:00', '16:00:00'),
(3, 'Rabu', '06:00:00', '08:30:00', '16:00:00'),
(4, 'Kamis', '06:00:00', '08:30:00', '16:00:00'),
(5, 'Jumat', '06:00:00', '08:30:00', '11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pegawai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `username`, `password`, `role`) VALUES
(1, 'Steven Marcelino', 'Marcelino', '1234', 'pegawai'),
(2, 'Nayaka Jibran', 'Nayaka', '1234', 'admin'),
(4, 'Mamat Susanto', 'Mamat', '1234', 'pegawai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen_datang`
--
ALTER TABLE `absen_datang`
  ADD PRIMARY KEY (`id_datang`);

--
-- Indexes for table `absen_pulang`
--
ALTER TABLE `absen_pulang`
  ADD PRIMARY KEY (`id_pulang`);

--
-- Indexes for table `jam_kerja`
--
ALTER TABLE `jam_kerja`
  ADD PRIMARY KEY (`id_jam`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen_datang`
--
ALTER TABLE `absen_datang`
  MODIFY `id_datang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `absen_pulang`
--
ALTER TABLE `absen_pulang`
  MODIFY `id_pulang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jam_kerja`
--
ALTER TABLE `jam_kerja`
  MODIFY `id_jam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
