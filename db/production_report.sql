-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2022 at 06:09 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `production_report`
--

-- --------------------------------------------------------

--
-- Table structure for table `ayaktepung`
--

CREATE TABLE `ayaktepung` (
  `id_ayaktepung` int(11) NOT NULL,
  `jenis_tepung` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ayaktepung`
--

INSERT INTO `ayaktepung` (`id_ayaktepung`, `jenis_tepung`) VALUES
(1, 'Terigu A'),
(2, 'Terigu B'),
(3, 'Terigu C'),
(6, 'Terigu D');

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`) VALUES
(1, 'Manajemen'),
(2, 'Ayak Tepung'),
(3, 'Mixing'),
(4, 'Drying');

-- --------------------------------------------------------

--
-- Table structure for table `drying`
--

CREATE TABLE `drying` (
  `id_drying` int(11) NOT NULL,
  `jenis_label` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drying`
--

INSERT INTO `drying` (`id_drying`, `jenis_label`) VALUES
(1, 'Label A'),
(2, 'Label B'),
(3, 'Label C');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_shift` varchar(25) NOT NULL,
  `no_planprod` varchar(15) DEFAULT NULL,
  `produk` text NOT NULL,
  `qty` text NOT NULL,
  `qty_stok` text NOT NULL,
  `qty_limbah` text NOT NULL,
  `jenis_oven` enum('','Electric Baking','Oven Baking') NOT NULL,
  `no_mesin` enum('','Mesin 1','Mesin 2','Mesin 3') NOT NULL,
  `operator` text NOT NULL,
  `kendala` text NOT NULL,
  `user` varchar(50) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `divisi` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `tanggal`, `nama_shift`, `no_planprod`, `produk`, `qty`, `qty_stok`, `qty_limbah`, `jenis_oven`, `no_mesin`, `operator`, `kendala`, `user`, `id_divisi`, `divisi`) VALUES
(5, '2022-10-21', 'Shift 1 (08:00 - 16:00)', NULL, 'Terigu A', '1 SAK', '2 Box - 10Kg;3 Box - 25Kg', '0.1 Gram', '', '', 'Amir', 'oke', 'User Ayak Tepung', 2, 'Ayak Tepung'),
(9, '2022-09-25', 'Shift 2 (16:00 - 00:00)', '00192', 'Roti A', '12 Batch', '', '', 'Electric Baking', '', 'Suhendar', 'tidak ada', 'User Mixing', 3, 'Mixing'),
(10, '2022-10-16', 'Shift 3 (00:00 - 08:00)', '11290', 'Roti B - Label C', '', '', '', 'Electric Baking', 'Mesin 2', 'Yuna', 'hasil kurang', 'User Drying', 4, 'Drying'),
(11, '2021-10-21', 'Shift 2 (16:00 - 00:00)', NULL, 'Terigu C', '20 SAK', '3 Box - 10Kg;10 Box - 25Kg', '0.1520 Gram', '', '', 'Dudi', 'Tidak ada', 'User Ayak Tepung', 2, 'Ayak Tepung'),
(12, '2022-10-21', 'Shift 3 (00:00 - 08:00)', NULL, 'Terigu B', '26 SAK', '13 Box - 10Kg;5 Box - 25Kg', '0 Gram', '', '', 'Ahyani', 'Aman', 'User Ayak Tepung', 2, 'Ayak Tepung'),
(13, '2022-10-22', 'Shift 1 (08:00 - 16:00)', NULL, 'Terigu A', '36 SAK', '12 Box - 10Kg;10 Box - 25Kg', '0 Gram', '', '', 'Juhem', 'Oke', 'User Ayak Tepung', 2, 'Ayak Tepung'),
(14, '2022-10-15', 'Shift 1 (08:00 - 16:00)', '992GH', 'Roti B', '120 Batch', '', '', 'Oven Baking', '', 'Saman', 'Mesin delay', 'User Mixing', 3, 'Mixing');

-- --------------------------------------------------------

--
-- Table structure for table `mixing`
--

CREATE TABLE `mixing` (
  `id_mixing` int(11) NOT NULL,
  `jenis_roti` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mixing`
--

INSERT INTO `mixing` (`id_mixing`, `jenis_roti`) VALUES
(1, 'Roti A'),
(2, 'Roti B'),
(3, 'Roti C');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id_shift` int(11) NOT NULL,
  `nama_shift` varchar(15) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id_shift`, `nama_shift`, `jam_masuk`, `jam_keluar`) VALUES
(1, 'Shift 1', '08:00:00', '16:00:00'),
(2, 'Shift 2', '16:00:00', '00:00:00'),
(3, 'Shift 3', '00:00:00', '08:00:00'),
(7, 'Shift 4', '00:00:00', '03:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  `divisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `alamat`, `no_hp`, `username`, `password`, `divisi`) VALUES
(1, 'User Manajemen', '', '', 'usermanajemen', '1', 1),
(2, 'User Ayak Tepung', '', '', 'userayaktepung', '1', 2),
(3, 'User Mixing', '', '', 'usermixing', '1', 3),
(4, 'User Drying', '', '', 'userdrying', '1', 4),
(9, 'Ahyani', 'Jl. Raya Solo - Surakarta No 11', '081281216317', 'ahyani', '1', 1),
(11, 'Ayas', 'Jakarta', '021000000', 'ayas', '1', 2),
(12, 'amir', 'VGH', '0899', 'amir', '1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ayaktepung`
--
ALTER TABLE `ayaktepung`
  ADD PRIMARY KEY (`id_ayaktepung`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `drying`
--
ALTER TABLE `drying`
  ADD PRIMARY KEY (`id_drying`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `mixing`
--
ALTER TABLE `mixing`
  ADD PRIMARY KEY (`id_mixing`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id_shift`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ayaktepung`
--
ALTER TABLE `ayaktepung`
  MODIFY `id_ayaktepung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `drying`
--
ALTER TABLE `drying`
  MODIFY `id_drying` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `mixing`
--
ALTER TABLE `mixing`
  MODIFY `id_mixing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id_shift` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
