CREATE TABLE `members` (
  `memberID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `resetToken` varchar(255) DEFAULT NULL,
  `resetComplete` varchar(3) DEFAULT 'No',
  `status` enum('0','1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `artikli` (
  `id_artikla` int(11) NOT NULL,
  `id_korisnika` int(11) NOT NULL,
  `artikal` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `jedinica_mere` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cena` decimal(6,2) NOT NULL,
  `pdv` int(2) NOT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `status` enum('0','1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
