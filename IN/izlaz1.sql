-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2018 at 12:26 PM
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
-- Table structure for table `ulaz`
--

CREATE TABLE `izlaz` (
  `id_izlaza` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `datum` varchar(18) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `br_fakture` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_gradilista` int(11) NOT NULL,
  `artikli_kolicina` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_member` int(11) NOT NULL,
  `datum_unosa` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Indexes for table `ulaz`
--
ALTER TABLE `izlaz`
  ADD PRIMARY KEY (`id_izlaza`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ulaz`
--
ALTER TABLE `izlaz`
  MODIFY `id_izlaza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
