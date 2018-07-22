-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2018 at 08:56 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `centra_house_ml`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikli`
--

CREATE TABLE `artikli` (
  `id_artikla` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `artikal` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `jedinica_mere` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cena` decimal(6,2) NOT NULL,
  `pdv` int(2) NOT NULL,
  `stanje` int(11) NOT NULL,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikli`
--

INSERT INTO `artikli` (`id_artikla`, `id_korisnika`, `artikal`, `jedinica_mere`, `cena`, `pdv`, `stanje`, `status`) VALUES
(1, 1, 'Asov', 'kom', '60.00', 20, 60, '1'),
(2, 1, 'Lopata', 'kom', '100.00', 20, 0, '1'),
(3, 1, 'Cekic', 'kom', '120.00', 20, 100, '1'),
(4, 1, 'Brusna ploca 115x6', 'kom', '100.00', 20, 0, '1'),
(5, 1, 'Rezna ploca 115x1', 'kom', '100.00', 20, 28, '1'),
(6, 1, 'Metla', 'kom', '100.00', 20, 12, '1'),
(7, 1, 'Osnovna farba siva', 'kom', '100.00', 20, 0, '1'),
(8, 1, 'Cetka', 'kom', '130.00', 20, 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id_korisnika` int(11) NOT NULL,
  `korisnik` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `adresa` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mesto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `maticni_broj` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pib` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sifra_delatnosti` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telefon` varchar(26) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(26) COLLATE utf8_unicode_ci NOT NULL,
  `tekuci_racun` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `banka` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dodatak_broju` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id_korisnika`, `korisnik`, `adresa`, `mesto`, `maticni_broj`, `pib`, `sifra_delatnosti`, `telefon`, `fax`, `tekuci_racun`, `banka`, `logo`, `dodatak_broju`, `status`) VALUES
(1, 'Bulevar Company', 'Bulevar oslobodjenja 46a', 'Novi Sad', '?20204095', '101627445 ', '?15930', '021/531996', '021/531996', '?160-265673-09', 'Banca Intesa', 'img/centralhouse-logo.png', '/2017', '1'),
(2, 'Kolezeee', 'Radojke Lakic', 'Beograd', '12121212', '32323232', '121342', '0600226979', '23412341234', '21341234234', 'Intesa', 'images/default.png', '2017', '0');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `memberID` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `resetToken` varchar(255) DEFAULT NULL,
  `resetComplete` varchar(3) DEFAULT 'No',
  `status` enum('0','1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`memberID`, `id_korisnika`, `username`, `password`, `email`, `active`, `resetToken`, `resetComplete`, `status`) VALUES
(1, 1, 'pepa', '$2y$10$8wGrGcCd3T3o3/xL1dfB7uGG09bcX7IVrM.IGa3tibyhVSjc988xe', 'petar.cvetic@gmail.com', 'Yes', NULL, 'Yes', '1'),
(2, 1, 'petar', '$2y$10$QMyx.bM1KSBaEAI1CGtEH.JE6PW6toB2u7pJNk8Mgs.2638eqTIYK', 'petar.cvetic@yahoo.com', 'Yes', NULL, 'Yes', '3'),
(3, 1, 'pera', '$2y$10$MKFgSHv1o2yaFqSfPyjOQu4Y7P0OV2e3xN3rNPVyXaJ48/7n7J06i', 'sdkfj@kjss.com', 'Yes', NULL, 'Yes', '4'),
(4, 1, 'djura', '$2y$10$K1Yjkp.OeYsqyHxJVpkpVOeSBniS.w4vNj7KfQZJNS3SkfuHBXmju', 'djura@gmail.com', '85bcc73faa51720db417e243a5125449', NULL, 'No', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikli`
--
ALTER TABLE `artikli`
  ADD PRIMARY KEY (`id_artikla`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id_korisnika`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`memberID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikli`
--
ALTER TABLE `artikli`
  MODIFY `id_artikla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id_korisnika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
