-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 03:05 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spfc`
--

-- --------------------------------------------------------

--
-- Table structure for table `basis_aturan`
--

CREATE TABLE `basis_aturan` (
  `idaturan` int(11) NOT NULL,
  `idpenyakit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `basis_aturan`
--

INSERT INTO `basis_aturan` (`idaturan`, `idpenyakit`) VALUES
(11, 4),
(12, 6),
(13, 3);

-- --------------------------------------------------------

--
-- Table structure for table `detail_basis_aturan`
--

CREATE TABLE `detail_basis_aturan` (
  `idaturan` int(11) NOT NULL,
  `idgejala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_basis_aturan`
--

INSERT INTO `detail_basis_aturan` (`idaturan`, `idgejala`) VALUES
(11, 12),
(11, 13),
(12, 5),
(12, 8),
(13, 4),
(13, 10),
(13, 11);

-- --------------------------------------------------------

--
-- Table structure for table `detail_konsultasi`
--

CREATE TABLE `detail_konsultasi` (
  `idkonsultasi` int(11) NOT NULL,
  `idgejala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_konsultasi`
--

INSERT INTO `detail_konsultasi` (`idkonsultasi`, `idgejala`) VALUES
(1, 4),
(1, 5),
(2, 4),
(2, 5),
(3, 9),
(3, 8),
(4, 6),
(4, 7),
(4, 8),
(4, 12),
(4, 13),
(5, 6),
(5, 7),
(5, 12),
(5, 13),
(5, 14),
(5, 15),
(5, 18);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penyakit`
--

CREATE TABLE `detail_penyakit` (
  `idkonsultasi` int(11) NOT NULL,
  `idpenyakit` int(11) NOT NULL,
  `persentase` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_penyakit`
--

INSERT INTO `detail_penyakit` (`idkonsultasi`, `idpenyakit`, `persentase`) VALUES
(3, 3, 100),
(3, 4, 100),
(3, 6, 100),
(4, 3, 100),
(4, 4, 100),
(4, 6, 100),
(5, 3, 100),
(5, 4, 100),
(5, 6, 100);

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `idgejala` int(11) NOT NULL,
  `nmgejala` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`idgejala`, `nmgejala`) VALUES
(4, 'Keluar cairan bening'),
(5, 'Mata berpasir'),
(6, 'Mata berwarna merah'),
(7, 'Mata terasa gatal'),
(8, 'Mata terasa kering'),
(9, 'Mata iritasi'),
(10, 'Mual'),
(11, 'Muntah'),
(12, 'Pandangan kabur'),
(13, 'Penglihatan berbayang'),
(14, 'Penglihatan hilang'),
(15, 'Penurunan penglihatan warna'),
(16, 'Perasaan terbakar'),
(17, 'Perubahan penglihatan'),
(18, 'Sakit kepala'),
(19, 'Sulit melihat di malam hari'),
(20, 'Terjadi peningkatan tekanan pada mata');

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

CREATE TABLE `konsultasi` (
  `idkonsultasi` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `konsultasi`
--

INSERT INTO `konsultasi` (`idkonsultasi`, `tanggal`, `nama`) VALUES
(3, '2025-01-08', 'Ridho'),
(4, '2025-01-09', 'cindi'),
(5, '2025-01-09', 'Deni');

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE `penyakit` (
  `idpenyakit` int(11) NOT NULL,
  `nmpenyakit` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  `solusi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`idpenyakit`, `nmpenyakit`, `keterangan`, `solusi`) VALUES
(3, 'Glukoma', 'Kelompok penyakit mata yang merusak saraf optik dan dapat menyebabkan kehilangan penglihatan', 'Terapi konservatif melibatkan obat penurun tekanan mata atau prosedur pembedahan, tergantung pada tingkat keparahan'),
(4, 'Katarak', 'Kondisi dimana lensa mata menjadi keruh, menyebabkan penglihatan kabur atau berbayang.', 'Pembedahan katarak adalah opsi perawatan yang umum. Lensa yang kabur diganti dengan lensa buatan'),
(5, 'Konjungtivitas', 'Peradangan pada konjungtivas, lapisan tipis yang melapisi bagian putih mata dan bagian dalam kelopak mata.', 'Terapi dapat melibatkan tetes mata antibiotik atau antihistamin, kompres dingin untuk mengurangi peradangan, dan hindari sentuhan mata yang berlebihan'),
(6, 'Mata kering', 'Terjadi karena mata tidak dapat memproduksi cukup air mata atau produksi air mata tidak seimbang.', 'Menggunakan tetes mata buatan air mata, menjaga kelembaban udara, menghindari paparan angin dan asap.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idusers` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idusers`, `username`, `pass`, `role`) VALUES
(1, 'Agus', 'fdf169558242ee051cca1479770ebac3', 'Dokter'),
(2, 'Ida', '7f78f270e3e1129faf118ed92fdf54db', 'Admin'),
(3, 'Bowo', '9b930621eaa7ca7e9f6f584a1450b8a6', 'Pasien');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basis_aturan`
--
ALTER TABLE `basis_aturan`
  ADD PRIMARY KEY (`idaturan`);

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`idgejala`);

--
-- Indexes for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`idkonsultasi`);

--
-- Indexes for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`idpenyakit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idusers`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basis_aturan`
--
ALTER TABLE `basis_aturan`
  MODIFY `idaturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `gejala`
--
ALTER TABLE `gejala`
  MODIFY `idgejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `idkonsultasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `idpenyakit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idusers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
