-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Paź 2023, 15:51
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `advertising_site`
--

DELIMITER $$
--
-- Procedury
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `WyswietlOgloszeniaUzytkownika` (IN `konto` INT)  BEGIN
SELECT id_ogloszenia, nazwa, cena, ilosc, kategoria_ogloszenia.kategoria, nr_telefonu, przypisane_konto, link 
    FROM ogloszenia
    INNER JOIN konta on konta.id_konta = ogloszenia.przypisane_konto
    INNER JOIN kategoria_ogloszenia on kategoria_ogloszenia.id_kategorii = ogloszenia.kategoria
    WHERE przypisane_konto = konto 
    ORDER BY id_ogloszenia;
END$$

--
-- Funkcje
--
CREATE DEFINER=`root`@`localhost` FUNCTION `LiczbaOgloszen` (`kontoprzypisane` INT) RETURNS INT(11) BEGIN 
      DECLARE liczba INT; 
		SELECT COUNT(id_ogloszenia) INTO liczba FROM ogloszenia WHERE przypisane_konto = kontoprzypisane; 
  
    RETURN liczba; 
  END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `archiwalne_ogloszenia`
--

CREATE TABLE `archiwalne_ogloszenia` (
  `id_arch_ogloszenia` int(11) NOT NULL,
  `nazwa` varchar(130) NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `ilosc` smallint(6) NOT NULL,
  `kategoria` tinyint(4) NOT NULL,
  `przypisane_konto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `archiwalne_ogloszenia`
--

INSERT INTO `archiwalne_ogloszenia` (`id_arch_ogloszenia`, `nazwa`, `cena`, `ilosc`, `kategoria`, `przypisane_konto`) VALUES
(2, 'Samsung s20', '1222.00', 1, 1, 2),
(4, 'Okulary damskie', '100.00', 1, 1, 4),
(5, 'samsung s23', '2000.50', 12, 2, 2),
(6, 'komputer', '1000.00', 1, 2, 2),
(7, 'czapka', '0.00', 1, 4, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dostep`
--

CREATE TABLE `dostep` (
  `id_dostep` tinyint(11) NOT NULL,
  `rodzaj_dostepu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `dostep`
--

INSERT INTO `dostep` (`id_dostep`, `rodzaj_dostepu`) VALUES
(1, 'uzytkownik'),
(2, 'ogloszeniodawca'),
(3, 'administrator');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria_ogloszenia`
--

CREATE TABLE `kategoria_ogloszenia` (
  `id_kategorii` tinyint(4) NOT NULL,
  `kategoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kategoria_ogloszenia`
--

INSERT INTO `kategoria_ogloszenia` (`id_kategorii`, `kategoria`) VALUES
(1, 'sprzedam'),
(2, 'kupie'),
(3, 'oddam'),
(4, 'zamienie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konta`
--

CREATE TABLE `konta` (
  `id_konta` int(11) NOT NULL,
  `imie` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(100) NOT NULL,
  `dostep` tinyint(4) NOT NULL,
  `token` varchar(60) DEFAULT NULL,
  `data_rejestracji` datetime NOT NULL,
  `ostatnie_logowanie` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `konta`
--

INSERT INTO `konta` (`id_konta`, `imie`, `email`, `haslo`, `dostep`, `token`, `data_rejestracji`, `ostatnie_logowanie`) VALUES
(2, 'krzychu', 'admin1@g.pl', '$argon2i$v=19$m=65536,t=4,p=1$TkRYWXBFWnMxT2ZSOTc5Rw$DG8p5Vqmv4eIPpLEoTi7Fyw6+R8RnL1GUCE9EGlCaIU', 3, NULL, '2023-09-22 14:26:58', '2023-10-09 15:30:21'),
(3, 'Paweł', 'user1@g.pl', '$argon2i$v=19$m=65536,t=4,p=1$d1dGR244YmZiQ0FaZENuOQ$Fy/14Bi1XUpAqWJG6SL3FYf3Z+qt907XKTgqOUsOCyc', 2, NULL, '2023-09-22 14:29:29', '2023-10-09 12:06:30'),
(4, 'mateusz', 'mati12@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$TGR6clNUSWpyUHdqMHlvYQ$azeFsgS9sq98ZW6XekFPLECzKImDEH37N5M2uBuZIDk', 2, NULL, '2023-10-04 12:39:58', '2023-10-09 15:26:04');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenia`
--

CREATE TABLE `ogloszenia` (
  `id_ogloszenia` int(11) NOT NULL,
  `nazwa` varchar(130) NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `ilosc` smallint(6) NOT NULL,
  `kategoria` tinyint(4) NOT NULL,
  `nr_telefonu` char(9) NOT NULL,
  `opis` text NOT NULL,
  `przypisane_konto` int(11) NOT NULL,
  `zdjecia` text DEFAULT NULL,
  `link` varchar(50) NOT NULL,
  `czas_dodania` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `ogloszenia`
--

INSERT INTO `ogloszenia` (`id_ogloszenia`, `nazwa`, `cena`, `ilosc`, `kategoria`, `nr_telefonu`, `opis`, `przypisane_konto`, `zdjecia`, `link`, `czas_dodania`) VALUES
(14, 'Koszula meska', '120.00', 3, 1, '902422312', 'Linia Premium to odpowiedź na potrzeby nowoczesnego mężczyzny. Pozwala na dotrzymanie kroku współczesnemu światu i podkreślenie w nim swojej indywidualności. To kolekcja, która zapewni Ci stylowy wygląd przez cały dzień. Wystarczy tylko, że zmienisz dodatki, a z biurowej stylizacji stworzysz outfit na wyjście ze znajomymi. Jedno ubranie możesz łączyć z wieloma innymi, w różnych stylach, dzięki czemu nadasz całości zupełnie innego charakteru. To niebywały komfort, kiedy możesz w jednym miejscu skompletować swoją całą garderobę.', 2, '2023-10-03-23-33-04-0.jpg', 'koszula-meska-453242u.php', '2023-10-03 23:30:00'),
(15, 'Hulajnoga elektryczna LAMBORGHINI', '5800.00', 4, 1, '123942321', 'Hulajnoga elektryczna AL-EXT V2 marki LAMBORGHINI to połączenie doskonałego designu, wydajności i funkcjonalności. Zapewnia bezpieczną i płynną jazdę, a przy tym oferuje wiele zaawansowanych funkcji. Zasilana dużą baterią o pojemności 12.5 Ah, ta hulajnoga jest idealnym wyborem dla osób, które chcą cieszyć się szybkim i ekscytującym środkiem transportu w mieście.', 2, '2023-10-04-14-13-37-0.jpg,2023-10-04-14-13-37-1.jpg,2023-10-04-14-13-37-2.jpg,2023-10-04-14-13-37-3.jpg,2023-10-04-14-13-37-4.jpg,2023-10-04-14-13-37-5.jpg', 'hulajnoga-elektryczna-lamborghini-722415f.php', '2023-10-04 14:08:00'),
(16, 'Zegarek CASIO', '0.00', 2, 4, '983242123', 'Witam. Zamienie na srebrny', 4, '2023-10-06-00-48-27-0.jpg,2023-10-06-00-48-27-1.jpg', 'zegarek-casio-467856g.php', '2023-10-09 15:24:00'),
(18, 'Czapka KFC', '130.00', 1, 1, '847238212', 'Sprzedam rzadką czapke KFC', 2, '2023-10-06-12-49-56-0.webp', 'czapka-kfc-486d.php', '2023-10-06 12:49:00'),
(19, 'Plantronics Backbeat Pro 5100', '299.99', 8, 1, '832739421', 'Uwolnij swoją muzykę i rozmowy dzięki prawdziwie bezprzewodowym słuchawkom Poly Backbeat Pro 5100 w czarnym kolorze. Wysoką jakość dźwięku i głębokie basy zapewnią Ci między innymi wydajne przetworniki o średnicy 5,8 mm.\r\n\r\nWbudowane mikrofony z funkcją redukcji szumów i technologią WindSmart pozwolą Ci prowadzić rozmowy bez zakłóceń. Twój rozmówca usłyszy tylko Twój głos, a hałas z otoczenia zostanie wyeliminowany. W pełni naładowane słuchawki wraz z etui ładującym zapewnią Ci nawet 19 i pół godziny słuchania muzyki.', 3, '2023-10-09-12-13-09-0.webp,2023-10-09-12-13-09-1.jpg,2023-10-09-12-13-09-2.jpg', 'plantronics-backbeat-pro-5100-239853h.php', '2023-10-09 12:17:00');

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `popularne`
-- (Zobacz poniżej rzeczywisty widok)
--
CREATE TABLE `popularne` (
`nazwa` varchar(130)
,`cena` decimal(10,2)
,`zdjecia` text
,`link` varchar(50)
,`kategoria` varchar(50)
,`czas_dodania` datetime
);

-- --------------------------------------------------------

--
-- Struktura widoku `popularne`
--
DROP TABLE IF EXISTS `popularne`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `popularne`  AS SELECT `ogloszenia`.`nazwa` AS `nazwa`, `ogloszenia`.`cena` AS `cena`, `ogloszenia`.`zdjecia` AS `zdjecia`, `ogloszenia`.`link` AS `link`, `kategoria_ogloszenia`.`kategoria` AS `kategoria`, `ogloszenia`.`czas_dodania` AS `czas_dodania` FROM (`ogloszenia` join `kategoria_ogloszenia` on(`kategoria_ogloszenia`.`id_kategorii` = `ogloszenia`.`kategoria`)) ORDER BY `ogloszenia`.`czas_dodania` DESC LIMIT 0, 3 ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `archiwalne_ogloszenia`
--
ALTER TABLE `archiwalne_ogloszenia`
  ADD PRIMARY KEY (`id_arch_ogloszenia`);

--
-- Indeksy dla tabeli `dostep`
--
ALTER TABLE `dostep`
  ADD PRIMARY KEY (`id_dostep`);

--
-- Indeksy dla tabeli `kategoria_ogloszenia`
--
ALTER TABLE `kategoria_ogloszenia`
  ADD PRIMARY KEY (`id_kategorii`);

--
-- Indeksy dla tabeli `konta`
--
ALTER TABLE `konta`
  ADD PRIMARY KEY (`id_konta`),
  ADD KEY `dostep` (`dostep`);

--
-- Indeksy dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD PRIMARY KEY (`id_ogloszenia`),
  ADD KEY `kategoria` (`kategoria`),
  ADD KEY `ogloszenia_ibfk_1` (`przypisane_konto`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `archiwalne_ogloszenia`
--
ALTER TABLE `archiwalne_ogloszenia`
  MODIFY `id_arch_ogloszenia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `konta`
--
ALTER TABLE `konta`
  MODIFY `id_konta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  MODIFY `id_ogloszenia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `konta`
--
ALTER TABLE `konta`
  ADD CONSTRAINT `konta_ibfk_1` FOREIGN KEY (`dostep`) REFERENCES `dostep` (`id_dostep`);

--
-- Ograniczenia dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD CONSTRAINT `ogloszenia_ibfk_1` FOREIGN KEY (`przypisane_konto`) REFERENCES `konta` (`id_konta`),
  ADD CONSTRAINT `ogloszenia_ibfk_2` FOREIGN KEY (`kategoria`) REFERENCES `kategoria_ogloszenia` (`id_kategorii`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
