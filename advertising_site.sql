-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2023 at 08:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `advertising_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `archiwalne_ogloszenia`
--

CREATE TABLE `archiwalne_ogloszenia` (
  `id_arch_ogloszenia` int(11) NOT NULL,
  `nazwa` varchar(130) NOT NULL,
  `cena` int(11) NOT NULL,
  `ilosc` smallint(6) NOT NULL,
  `kategoria` tinyint(4) NOT NULL,
  `opis` text NOT NULL,
  `przypisane_konto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dostep`
--

CREATE TABLE `dostep` (
  `id_dostep` tinyint(11) NOT NULL,
  `rodzaj_dostepu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dostep`
--

INSERT INTO `dostep` (`id_dostep`, `rodzaj_dostepu`) VALUES
(1, 'uzytkownik'),
(2, 'ogloszeniodawca'),
(3, 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `kategoria_ogloszenia`
--

CREATE TABLE `kategoria_ogloszenia` (
  `id_kategorii` tinyint(4) NOT NULL,
  `kategoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategoria_ogloszenia`
--

INSERT INTO `kategoria_ogloszenia` (`id_kategorii`, `kategoria`) VALUES
(1, 'sprzedam'),
(2, 'kupie'),
(3, 'oddam'),
(4, 'zamienie');

-- --------------------------------------------------------

--
-- Table structure for table `konta`
--

CREATE TABLE `konta` (
  `id_konta` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(100) NOT NULL,
  `dostep` tinyint(4) NOT NULL,
  `token` varchar(60) DEFAULT NULL,
  `data_rejestracji` datetime NOT NULL,
  `ostatnie_logowanie` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konta`
--

INSERT INTO `konta` (`id_konta`, `email`, `haslo`, `dostep`, `token`, `data_rejestracji`, `ostatnie_logowanie`) VALUES
(2, 'admin1@g.pl', '$argon2i$v=19$m=65536,t=4,p=1$TkRYWXBFWnMxT2ZSOTc5Rw$DG8p5Vqmv4eIPpLEoTi7Fyw6+R8RnL1GUCE9EGlCaIU', 3, NULL, '2023-09-22 14:26:58', '2023-09-24 19:56:22'),
(3, 'user1@g.pl', '$argon2i$v=19$m=65536,t=4,p=1$d1dGR244YmZiQ0FaZENuOQ$Fy/14Bi1XUpAqWJG6SL3FYf3Z+qt907XKTgqOUsOCyc', 1, NULL, '2023-09-22 14:29:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ogloszenia`
--

CREATE TABLE `ogloszenia` (
  `id_ogloszenia` int(11) NOT NULL,
  `nazwa` varchar(130) NOT NULL,
  `cena` int(11) NOT NULL,
  `ilosc` smallint(6) NOT NULL,
  `kategoria` tinyint(4) NOT NULL,
  `nr_telefonu` char(9) NOT NULL,
  `opis` text NOT NULL,
  `przypisane_konto` int(11) NOT NULL,
  `zdjecia` text DEFAULT NULL,
  `link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ogloszenia`
--

INSERT INTO `ogloszenia` (`id_ogloszenia`, `nazwa`, `cena`, `ilosc`, `kategoria`, `nr_telefonu`, `opis`, `przypisane_konto`, `zdjecia`, `link`) VALUES
(9, 'zegarek', 232, 1, 1, '123456789', 'music mix featuring house music from subgenres like deep house, Chicago house and lofi house. This house mix focuses on melodic, smooth, calm house track', 2, ',th-3921888408.jpg,th-2071760274.jpg,th-2580835048.jpg', 'http://localhost/projekt ogloszeniowy/ogloszenia/z');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archiwalne_ogloszenia`
--
ALTER TABLE `archiwalne_ogloszenia`
  ADD PRIMARY KEY (`id_arch_ogloszenia`);

--
-- Indexes for table `dostep`
--
ALTER TABLE `dostep`
  ADD PRIMARY KEY (`id_dostep`);

--
-- Indexes for table `kategoria_ogloszenia`
--
ALTER TABLE `kategoria_ogloszenia`
  ADD PRIMARY KEY (`id_kategorii`);

--
-- Indexes for table `konta`
--
ALTER TABLE `konta`
  ADD PRIMARY KEY (`id_konta`),
  ADD KEY `dostep` (`dostep`);

--
-- Indexes for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD PRIMARY KEY (`id_ogloszenia`),
  ADD KEY `kategoria` (`kategoria`),
  ADD KEY `ogloszenia_ibfk_1` (`przypisane_konto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archiwalne_ogloszenia`
--
ALTER TABLE `archiwalne_ogloszenia`
  MODIFY `id_arch_ogloszenia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konta`
--
ALTER TABLE `konta`
  MODIFY `id_konta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  MODIFY `id_ogloszenia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `konta`
--
ALTER TABLE `konta`
  ADD CONSTRAINT `konta_ibfk_1` FOREIGN KEY (`dostep`) REFERENCES `dostep` (`id_dostep`);

--
-- Constraints for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD CONSTRAINT `ogloszenia_ibfk_1` FOREIGN KEY (`przypisane_konto`) REFERENCES `konta` (`id_konta`),
  ADD CONSTRAINT `ogloszenia_ibfk_2` FOREIGN KEY (`kategoria`) REFERENCES `kategoria_ogloszenia` (`id_kategorii`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
