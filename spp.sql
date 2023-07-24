-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2023 at 10:35 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spp`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`) VALUES
(1, 'Melmel'),
(3, 'Meel');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` varchar(20) NOT NULL,
  `nis` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `tahun_ajaran` varchar(50) NOT NULL,
  `biaya` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nama`, `kelas`, `alamat`, `telp`, `tahun_ajaran`, `biaya`) VALUES
('S-000001', '7612641', 'Dr Melati', 'PAKET B KELAS 11', 'Jl Raya ...', '082181618129', '2023/2024', 200000);

-- --------------------------------------------------------

--
-- Table structure for table `spp`
--

CREATE TABLE `spp` (
  `id_spp` int(11) NOT NULL,
  `id_siswa` varchar(20) NOT NULL,
  `jatuh_tempo` varchar(50) NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `no_bayar` varchar(20) NOT NULL,
  `tgl_bayar` varchar(20) NOT NULL,
  `nominal` int(11) NOT NULL,
  `ket` varchar(20) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spp`
--

INSERT INTO `spp` (`id_spp`, `id_siswa`, `jatuh_tempo`, `bulan`, `no_bayar`, `tgl_bayar`, `nominal`, `ket`, `id`) VALUES
(70, 'S-000001', '2023-07-10', 'Juli 2023', '23062900001', '2023-06-29', 200000, 'lunas', 8),
(71, 'S-000001', '2023-08-10', 'Agustus 2023', '23062900002', '2023-06-29', 200000, 'cicilan', 8),
(72, 'S-000001', '2023-09-10', 'September 2023', '', '', 200000, 'belum_bayar', 8),
(73, 'S-000001', '2023-10-10', 'Oktober 2023', '', '', 200000, 'belum_bayar', 8),
(74, 'S-000001', '2023-11-10', 'November 2023', '', '', 200000, 'belum_bayar', 8),
(75, 'S-000001', '2023-12-10', 'Desember 2023', '', '', 200000, 'belum_bayar', 8),
(76, 'S-000001', '2024-01-10', 'Januari 2024', '', '', 200000, 'belum_bayar', 8),
(77, 'S-000001', '2024-02-10', 'Februari 2024', '', '', 200000, 'belum_bayar', 8),
(78, 'S-000001', '2024-03-10', 'Maret 2024', '', '', 200000, 'belum_bayar', 8),
(79, 'S-000001', '2024-04-10', 'April 2024', '', '', 200000, 'belum_bayar', 8),
(80, 'S-000001', '2024-05-10', 'Mei 2024', '', '', 200000, 'belum_bayar', 8),
(81, 'S-000001', '2024-06-10', 'Juni 2024', '', '', 200000, 'belum_bayar', 8);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `user_akses` int(11) NOT NULL,
  `user_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama_user`, `username`, `email`, `password`, `foto`, `user_akses`, `user_status`) VALUES
(8, 'Melati Sanjayaa', 'melati', 'melati@gmail.com', '200ceb26807d6bf99fd6f4f0d1ca54d4', 'default.jpg', 1, 1),
(9, 'melatitanoe', 'melatitanoe', 'melatitanoe@gmail.com', '010d7ec7af6e3287b7a5adea4504cfe5', 'default.jpg', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wali_kelas`
--

CREATE TABLE `wali_kelas` (
  `id_kelas` int(11) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `id_guru` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wali_kelas`
--

INSERT INTO `wali_kelas` (`id_kelas`, `kelas`, `id_guru`) VALUES
(1, 'PAKET B KELAS 11', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `kelas` (`kelas`);

--
-- Indexes for table `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`id_spp`),
  ADD KEY `spp_ibfk_2` (`id_siswa`) USING BTREE,
  ADD KEY `spp_ibfk_1` (`id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wali_kelas`
--
ALTER TABLE `wali_kelas`
  ADD PRIMARY KEY (`kelas`),
  ADD UNIQUE KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_guru` (`id_guru`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `spp`
--
ALTER TABLE `spp`
  MODIFY `id_spp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wali_kelas`
--
ALTER TABLE `wali_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `kelas` FOREIGN KEY (`kelas`) REFERENCES `wali_kelas` (`kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `spp`
--
ALTER TABLE `spp`
  ADD CONSTRAINT `spp_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spp_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
