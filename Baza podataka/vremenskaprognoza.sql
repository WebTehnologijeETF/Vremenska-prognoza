-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2015 at 11:09 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vremenskaprognoza`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE IF NOT EXISTS `administrator` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`Id`, `username`, `password`, `mail`) VALUES
(1, 'admin', 'tajna', 'custovicharis@gmail.com'),
(4, 'noviAdmin23', 'sarma', 'sADSSDAS');

-- --------------------------------------------------------

--
-- Table structure for table `autor`
--

CREATE TABLE IF NOT EXISTS `autor` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Ime` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `Prezime` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `Username` varchar(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Password` varchar(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `autor`
--

INSERT INTO `autor` (`Id`, `Ime`, `Prezime`, `Username`, `Password`) VALUES
(2, 'Ime', 'Prezime', 'iprezime1', 'lozinka'),
(3, 'Haris', 'Čustović', 'hcustovic1', 'tajna'),
(4, 'Novi', 'Autor', NULL, NULL),
(5, 'Samo', 'Polako', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE IF NOT EXISTS `komentar` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `NovostID` int(11) NOT NULL,
  `Komentator` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Poruka` text COLLATE utf8_slovenian_ci NOT NULL,
  `DatumObjave` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `NovostKomentar_FK` (`NovostID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`Id`, `NovostID`, `Komentator`, `Email`, `Poruka`, `DatumObjave`) VALUES
(1, 1, 'Ime', 'dasdas@dsds.com', 'Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!!', '2015-05-27 10:45:48'),
(2, 1, NULL, NULL, 'Ovo je anonimno super!', '2015-05-27 10:45:48'),
(3, 1, 'AutorBezMaila', NULL, 'Ovo je bez maila opet super!', '2015-05-27 10:46:11'),
(5, 1, '', '', 'dasdasda', '2015-05-27 21:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `novost`
--

CREATE TABLE IF NOT EXISTS `novost` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AutorID` int(11) NOT NULL,
  `Naslov` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `Slika` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `Opis` varchar(500) COLLATE utf8_slovenian_ci NOT NULL,
  `Detaljno` text COLLATE utf8_slovenian_ci NOT NULL,
  `DatumObjave` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `AutorNovost_FK` (`AutorID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `novost`
--

INSERT INTO `novost` (`Id`, `AutorID`, `Naslov`, `Slika`, `Opis`, `Detaljno`, `DatumObjave`) VALUES
(1, 2, 'LIJEP SARAJEVSKI DAN', 'Images/Sunny-Sarajevo.jpg', 'U Sarajevu se očekuje lijepo vrijeme danas. Na sjeveru zemlje su moguće padavine.', 'U Sarajevu se očekuje pretežno sunčano i veoma toplo vrijeme. Uvečer postoji mala mogućnost za kratkotrajnom pojavom lokalnih pljuskova sa grmljavinom. Puhat će umjeren zapadni i jugozapadni vetar. Minimalna temperatura 12°C, maksimalna dnevna 28°C.\r\nSjever zemlje s druge strane će pogoditi intenzivne padavine, čije se smirenje očekuje tek predveče.', '2015-05-27 09:21:31'),
(3, 3, 'MOGUĆNOST POPLAVA', 'Images/poplave.jpg', 'Nakon prošlogodišnih nesretnih okolnosti vezanih za poplave, građani cijele BiH opet ne mogu odahnuti...', 'U većem dijelu Bosni i Hercegovini sutra se očekuje opasno vrijeme, piše novinska agencija Patria. Kako je najavljeno u Federalnom hidrometeorološkog zavodu očekuju se obilnije padavine i to čak 20 do 50, a negdje i više od 50 mm kiše. Crveni meteoalarm upaljen je na području Višegrada, što znači da je vrijeme izuzetno opasno te da se prognozira iznimno intenzivan meteorološki događaj.\r\nObilnije padavine najviše se očekuju u centralnim i sjeveroistočnim dijelovima BiH. Većina rijeka, izuzev Bosne imala je trend opadanja vodostaja, ali će tokom noći usljed padavina doći do porasta te nisu isključene poplave.', '2015-05-27 09:22:53'),
(4, 2, 'MOGUĆNOST POPLAVA', 'Images/poplave.jpg', 'Nakon prošlogodišnih nesretnih okolnosti vezanih za poplave, građani cijele BiH opet ne mogu odahnuti...', '', '2015-05-27 09:22:53'),
(5, 2, 'Neka Nova vijest', 'http://metro-portal.hr/img/repository/2010/06/medium/shutterstock_vrijeme_prognoza.jpg', 'Probni tekst! Probni tekst! Probni tekst! Probni tekst!', '', '2015-05-28 19:00:27');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`NovostID`) REFERENCES `novost` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `novost`
--
ALTER TABLE `novost`
  ADD CONSTRAINT `novost_ibfk_1` FOREIGN KEY (`AutorID`) REFERENCES `autor` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
