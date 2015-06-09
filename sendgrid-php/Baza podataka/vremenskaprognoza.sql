-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2015 at 10:48 PM
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
-- Table structure for table `autor`
--

CREATE TABLE IF NOT EXISTS `autor` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Ime` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `Prezime` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `Username` varchar(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Password` varchar(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `autor`
--

INSERT INTO `autor` (`Id`, `Ime`, `Prezime`, `Username`, `Password`) VALUES
(2, 'Ime', 'Prezime', 'iprezime1', 'lozinka'),
(3, 'Haris', 'Čustović', 'hcustovic1', 'tajna'),
(4, 'Novi', 'Autor', NULL, NULL),
(5, 'Samo', 'Polako', NULL, NULL),
(6, 'dsdaskdcas', 'vjslfjdsklfs', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE IF NOT EXISTS `komentar` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `NovostID` int(11) NOT NULL,
  `KorisnikID` int(11) DEFAULT NULL,
  `Komentator` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Poruka` text COLLATE utf8_slovenian_ci NOT NULL,
  `DatumObjave` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `NovostKomentar_FK` (`NovostID`),
  KEY `KomentarKorisnik_FK` (`KorisnikID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`Id`, `NovostID`, `KorisnikID`, `Komentator`, `Email`, `Poruka`, `DatumObjave`) VALUES
(1, 1, NULL, 'Ime', 'dasdas@dsds.com', 'Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!! Ovo je super!!!!!', '2015-05-27 10:45:48'),
(2, 1, NULL, NULL, NULL, 'Ovo je anonimno super!', '2015-05-27 10:45:48'),
(4, 1, NULL, '', '', 'dasdfafadfdasdasdcdads', '2015-06-09 19:56:09'),
(5, 1, NULL, 'dsadsada', '', 'sadasds', '2015-06-09 20:07:31'),
(8, 1, NULL, '', '', 'dasdfasdasd', '2015-06-09 20:16:46'),
(11, 1, NULL, 'Orhan', 'mail@mail.com', 'lsjdasldjasldasd', '2015-06-09 20:19:25'),
(12, 1, NULL, '', '', 'Još adn dasdkasd', '2015-06-09 20:20:01'),
(13, 1, NULL, 'Orhan', 'mail@mail.com', 'dsadasdasd', '2015-06-09 20:39:23'),
(14, 1, NULL, 'Orhan', 'mail@mail.com', 'fdsgrgf', '2015-06-09 20:40:11'),
(15, 3, NULL, '', '', 'djlasdjasld', '2015-06-09 20:46:31'),
(16, 3, 5, 'Orhan', 'mail@mail.com', 'Ovo nije anonimno!', '2015-06-09 20:46:43');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE IF NOT EXISTS `korisnik` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `administrator` tinyint(1) NOT NULL DEFAULT '0',
  `mail` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`Id`, `username`, `password`, `administrator`, `mail`) VALUES
(1, 'admin', 'tajna', 1, 'dsds@asa.com'),
(5, 'Orhan', 'pisarica', 0, 'mail@mail.com'),
(6, 'Gamad', 'gamad', 0, 'gamad@fsdas.com'),
(7, 'fasdas', 'fdfdsfds', 0, '123124@dsas.com');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `novost`
--

INSERT INTO `novost` (`Id`, `AutorID`, `Naslov`, `Slika`, `Opis`, `Detaljno`, `DatumObjave`) VALUES
(1, 2, 'LIJEP SARAJEVSKI DAN', 'Images/Sunny-Sarajevo.jpg', 'U Sarajevu se očekuje lijepo vrijeme danas. Na sjeveru zemlje su moguće padavine.', 'U Sarajevu se očekuje pretežno sunčano i veoma toplo vrijeme. Uvečer postoji mala mogućnost za kratkotrajnom pojavom lokalnih pljuskova sa grmljavinom. Puhat će umjeren zapadni i jugozapadni vetar. Minimalna temperatura 12°C, maksimalna dnevna 28°C.\r\nSjever zemlje s druge strane će pogoditi intenzivne padavine, čije se smirenje očekuje tek predveče.', '2015-05-27 09:21:31'),
(3, 3, 'MOGUĆNOST POPLAVA', 'Images/poplave.jpg', 'Nakon prošlogodišnih nesretnih okolnosti vezanih za poplave, građani cijele BiH opet ne mogu odahnuti...', 'U većem dijelu Bosni i Hercegovini sutra se očekuje opasno vrijeme, piše novinska agencija Patria. Kako je najavljeno u Federalnom hidrometeorološkog zavodu očekuju se obilnije padavine i to čak 20 do 50, a negdje i više od 50 mm kiše. Crveni meteoalarm upaljen je na području Višegrada, što znači da je vrijeme izuzetno opasno te da se prognozira iznimno intenzivan meteorološki događaj.\nObilnije padavine najviše se očekuju u centralnim i sjeveroistočnim dijelovima BiH. Većina rijeka, izuzev Bosne imala je trend opadanja vodostaja, ali će tokom noći usljed padavina doći do porasta te nisu isključene poplave. EDIT!!!!!', '2015-05-27 09:22:53'),
(4, 2, 'MOGUĆNOST POPLAVA', 'Images/poplave.jpg', 'Nakon prošlogodišnih nesretnih okolnosti vezanih za poplave, građani cijele BiH opet ne mogu odahnuti...', '', '2015-05-27 09:22:53'),
(5, 2, 'Neka Nova vijest', 'http://metro-portal.hr/img/repository/2010/06/medium/shutterstock_vrijeme_prognoza.jpg', 'Probni tekst! Probni tekst! Probni tekst! Probni tekst!', '', '2015-05-28 19:00:27');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`KorisnikID`) REFERENCES `korisnik` (`Id`),
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`NovostID`) REFERENCES `novost` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `novost`
--
ALTER TABLE `novost`
  ADD CONSTRAINT `novost_ibfk_1` FOREIGN KEY (`AutorID`) REFERENCES `autor` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
