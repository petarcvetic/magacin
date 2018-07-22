-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2018 at 11:42 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magacin`
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
  `cena` int(7) NOT NULL,
  `stanje` int(11) NOT NULL,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikli`
--

INSERT INTO `artikli` (`id_artikla`, `id_korisnika`, `artikal`, `jedinica_mere`, `cena`, `stanje`, `status`) VALUES
(1, 1, 'Asov', 'kom', 0, 3, '1'),
(2, 1, 'Lopata', 'kom', 0, 13, '1'),
(3, 1, 'Cekic', 'kom', 0, 58, '1'),
(4, 1, 'Brusna ploca 115x6', 'kom', 0, -1, '1'),
(5, 1, 'Rezna ploca 115x1', 'kom', 0, 28, '1'),
(6, 1, 'Metla', 'kom', 0, -11, '1'),
(7, 1, 'Osnovna farba siva', 'kom', 0, 0, '1'),
(8, 1, 'Cetka', 'kom', 0, 5, '1'),
(18, 1, 'stit mali (silt za bravu)', 'kom', 0, 1, '1'),
(17, 1, 'skalper', 'kom', 0, 12, '1'),
(16, 1, 'kalijev sapun', 'kom', 0, 4, '1'),
(15, 1, 'Cetka', 'm', 0, 0, '1'),
(19, 1, 'Diaflex 450', 'kom', 0, 3, '1'),
(20, 1, 'ELGEF spojka d90 (el. fuz. spojka)', 'kom', 0, 9, '1'),
(21, 1, 'PVC jahac fi250/160', 'kom', 0, 8, '1'),
(22, 1, 'Saht poklopac D400 (40T)', 'kom', 0, 149, '1'),
(23, 1, '', '', 0, 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `dobavljaci`
--

CREATE TABLE `dobavljaci` (
  `id_dobavljaca` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `naziv_dobavljaca` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dobavljaci`
--

INSERT INTO `dobavljaci` (`id_dobavljaca`, `id_korisnika`, `naziv_dobavljaca`, `status`) VALUES
(1, 1, 'SIM DOO', '1'),
(2, 1, 'WURTH', '1'),
(3, 1, 'Polietilenski Sistemi (PES)', '1'),
(4, 1, 'Uniprogres DOO', '1');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id_driver` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `driver_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `date_of_birth` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `driver_id_number` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `start_to_work` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id_driver`, `id_korisnika`, `driver_name`, `date_of_birth`, `driver_id_number`, `start_to_work`, `status`) VALUES
(1, 1, 'Vlaisavljevic Davor', '29.03.1977.', 'l.k. 006322941', '*', '1'),
(2, 1, 'Alagic Djordje', '06.04.1971.', 'v.d. 66755', '09.10.2007.', '1'),
(3, 1, 'Drca Zeljko', '15.03.1961.', '9291', '15.10.2013.', '1'),
(4, 1, 'Milic Goran', '06.02.1965.', 'l.k. 003546747', '12.07.2012.', '1'),
(5, 1, 'Starijas Branimir', '06.08.1978.', '3626712', '01.12.2008.', '1'),
(6, 1, 'Grba Bogdan', '29.06.1966.', '6273184', '*', '1'),
(7, 1, 'Uzelac Milan', '25.07.1963.', 'l.k. 1891290', '20.05.2012.', '1'),
(8, 1, 'Savatic Zoran', '25.09.1996.', '004260871', '01.03.2016.', '1'),
(9, 1, 'Cvjeticanin Milan', '10.02.1969.', '008072218', '01.10.2011.', '1'),
(10, 1, 'Smiljanic Radovan', '24.01.1965.', 'l.k. 6383829', '26.06.2017', '1');

-- --------------------------------------------------------

--
-- Table structure for table `gradiliste`
--

CREATE TABLE `gradiliste` (
  `id_gradilista` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `naziv_gradiliste` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gradiliste`
--

INSERT INTO `gradiliste` (`id_gradilista`, `id_korisnika`, `naziv_gradiliste`, `status`) VALUES
(1, 1, 'Veternik', '1'),
(2, 1, 'Budisava', '1'),
(3, 1, 'Kac', '1'),
(4, 1, 'Sajlovo', '1'),
(5, 1, 'Sremski Karlovci', '1');

-- --------------------------------------------------------

--
-- Table structure for table `izlaz`
--

CREATE TABLE `izlaz` (
  `id_izlaza` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `datum` varchar(18) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `br_fakture` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_gradilista` int(11) NOT NULL,
  `id_radnika` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `artikli_kolicina_cena` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_member` int(11) NOT NULL,
  `datum_unosa` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `izlaz`
--

INSERT INTO `izlaz` (`id_izlaza`, `id_korisnika`, `datum`, `br_fakture`, `id_gradilista`, `id_radnika`, `artikli_kolicina_cena`, `id_member`, `datum_unosa`, `status`) VALUES
(48, 1, '2018-04-18', '', 2, '2', ',2/1/0 ', 2, '2018-04-18 16:54:55', '1'),
(47, 1, '2018-04-18', '', 2, '2', ',2/1/0 ', 2, '2018-04-18 16:50:18', '1'),
(46, 1, '2018-04-18', '', 2, '2', ',3/1/0 ', 2, '2018-04-18 16:48:33', '1'),
(45, 1, '2018-04-18', '', 2, '2', ',3/1/0 ', 2, '2018-04-18 16:45:31', '1'),
(39, 1, '2018-04-18', '1', 2, '1', ',1/1/0 ,3/1/0 ,2/1/0 ', 2, '2018-04-18 13:09:27', '1'),
(40, 1, '2018-04-18', '', 2, '1', ',2/1/0 ,1/1/0 ', 2, '2018-04-18 13:10:08', '1'),
(41, 1, '2018-04-18', '1', 2, '1', ',2/1/0 ', 2, '2018-04-18 13:10:56', '1'),
(42, 1, '2018-04-18', '1', 2, '1', ',2/1/0 ', 2, '2018-04-18 13:38:36', '1'),
(43, 1, '180418', '', 2, '1', ',1/1/0 ,8/1/0 ,4/1/0 ', 2, '2018-04-18 13:52:28', '1'),
(44, 1, '2018-04-18', '', 2, '1', ',1/1/0 ', 2, '2018-04-18 13:58:35', '1');

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
(1, 'Bulevar Company', 'Bulevar oslobodjenja 46a', 'Novi Sad', '?20204095', '101627445 ', '?15930', '021/531996', '021/531996', '?160-265673-09', 'Banca Intesa', 'img/logo_bulevar.png', '/2017', '1'),
(2, 'Kolezeee', 'Radojke Lakic', 'Beograd', '12121212', '32323232', '121342', '0600226979', '23412341234', '21341234234', 'Intesa', 'images/default.png', '2017', '0');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `memberID` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resetToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resetComplete` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT 'No',
  `status` enum('0','1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`memberID`, `id_korisnika`, `username`, `password`, `email`, `active`, `resetToken`, `resetComplete`, `status`) VALUES
(1, 1, 'pepa', '$2y$10$8wGrGcCd3T3o3/xL1dfB7uGG09bcX7IVrM.IGa3tibyhVSjc988xe', 'petar.cvetic@gmail.com', 'Yes', NULL, 'Yes', '1'),
(2, 1, 'petar', '$2y$10$QMyx.bM1KSBaEAI1CGtEH.JE6PW6toB2u7pJNk8Mgs.2638eqTIYK', 'petar.cvetic@yahoo.com', 'Yes', NULL, 'Yes', '3'),
(3, 1, 'pera', '$2y$10$MKFgSHv1o2yaFqSfPyjOQu4Y7P0OV2e3xN3rNPVyXaJ48/7n7J06i', 'sdkfj@kjss.com', 'Yes', NULL, 'Yes', '4'),
(4, 1, 'djura', '$2y$10$K1Yjkp.OeYsqyHxJVpkpVOeSBniS.w4vNj7KfQZJNS3SkfuHBXmju', 'djura@gmail.com', '85bcc73faa51720db417e243a5125449', NULL, 'No', '1');

-- --------------------------------------------------------

--
-- Table structure for table `radnici`
--

CREATE TABLE `radnici` (
  `id_radnika` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `ime` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `telefon` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `radno_mesto` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `zaduzenje` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `radnici`
--

INSERT INTO `radnici` (`id_radnika`, `id_korisnika`, `ime`, `telefon`, `radno_mesto`, `zaduzenje`, `status`) VALUES
(1, 1, 'Petar Cvetic', '0648950039', 'Magacioner', ',1/1/180418,2/1/180418', '1'),
(2, 1, 'Dragan Sabic', '0648952005', 'Bravar', '//,Array', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ulaz`
--

CREATE TABLE `ulaz` (
  `id_ulaza` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `datum` varchar(18) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `br_fakture` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_dobavljaca` int(11) NOT NULL,
  `artikli_kolicina_cena` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_member` int(11) NOT NULL,
  `datum_unosa` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ulaz`
--

INSERT INTO `ulaz` (`id_ulaza`, `id_korisnika`, `datum`, `br_fakture`, `id_dobavljaca`, `artikli_kolicina_cena`, `id_member`, `datum_unosa`, `status`) VALUES
(62, 1, '2018-04-18', '1', 1, ',1/10/0 ,2/11/0 ,3/1/0 ', 2, '2018-04-18 09:06:43', '1'),
(63, 1, '2018-04-18', '2', 1, ',2/1/0 ,1/1/0 ,8/11/0 ', 2, '2018-04-18 09:07:27', '1'),
(64, 1, '2018-04-18', '1', 1, ',8/2/0 ,2/2/0 ,1/1/0 ', 2, '2018-04-18 09:08:06', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikli`
--
ALTER TABLE `artikli`
  ADD PRIMARY KEY (`id_artikla`);

--
-- Indexes for table `dobavljaci`
--
ALTER TABLE `dobavljaci`
  ADD PRIMARY KEY (`id_dobavljaca`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id_driver`);

--
-- Indexes for table `gradiliste`
--
ALTER TABLE `gradiliste`
  ADD PRIMARY KEY (`id_gradilista`);

--
-- Indexes for table `izlaz`
--
ALTER TABLE `izlaz`
  ADD PRIMARY KEY (`id_izlaza`);

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
-- Indexes for table `radnici`
--
ALTER TABLE `radnici`
  ADD PRIMARY KEY (`id_radnika`);

--
-- Indexes for table `ulaz`
--
ALTER TABLE `ulaz`
  ADD PRIMARY KEY (`id_ulaza`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikli`
--
ALTER TABLE `artikli`
  MODIFY `id_artikla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `dobavljaci`
--
ALTER TABLE `dobavljaci`
  MODIFY `id_dobavljaca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id_driver` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `gradiliste`
--
ALTER TABLE `gradiliste`
  MODIFY `id_gradilista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `izlaz`
--
ALTER TABLE `izlaz`
  MODIFY `id_izlaza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
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
--
-- AUTO_INCREMENT for table `radnici`
--
ALTER TABLE `radnici`
  MODIFY `id_radnika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ulaz`
--
ALTER TABLE `ulaz`
  MODIFY `id_ulaza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
