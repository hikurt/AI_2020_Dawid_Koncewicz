-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Cze 2020, 22:44
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `soki`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opakowanie`
--

CREATE TABLE `opakowanie` (
  `idOpakowanie` int(11) NOT NULL,
  `Typ` varchar(50) NOT NULL,
  `PojemnoscMl` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `opakowanie`
--

INSERT INTO `opakowanie` (`idOpakowanie`, `Typ`, `PojemnoscMl`) VALUES
(2, 'Szklane', 500),
(3, 'Karton', 50);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `skladniki`
--

CREATE TABLE `skladniki` (
  `idSkladniki` int(11) NOT NULL,
  `idSmak` int(11) NOT NULL,
  `Organiczny` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `skladniki`
--

INSERT INTO `skladniki` (`idSkladniki`, `idSmak`, `Organiczny`) VALUES
(22, 11, 'Tak'),
(24, 12, 'Nie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `smak`
--

CREATE TABLE `smak` (
  `idSmak` int(11) NOT NULL,
  `Smak` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `smak`
--

INSERT INTO `smak` (`idSmak`, `Smak`) VALUES
(11, 'Pomidorowy'),
(12, 'Truskawkowy'),
(14, 'Malinowy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sok`
--

CREATE TABLE `sok` (
  `idSok` int(11) NOT NULL,
  `Nazwa` varchar(50) NOT NULL,
  `ZawartoscOwocow` float NOT NULL,
  `ZawartoscWarzyw` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `sok`
--

INSERT INTO `sok` (`idSok`, `Nazwa`, `ZawartoscOwocow`, `ZawartoscWarzyw`) VALUES
(5, 'Fnatic', 30, 10),
(6, 'Caprio', 24, 0),
(9, 'Virtus', 33, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `idUzytkownicy` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `haslo` varchar(50) NOT NULL,
  `permisja` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`idUzytkownicy`, `login`, `email`, `haslo`, `permisja`) VALUES
(1, 'admin', 'admin@admin.com', 'admin', 'admin'),
(2, 'klient', 'klient@klient.com', 'klient', 'klient'),
(18, 'dawid', 'dawid@gmail.com', 'dawid', 'klient');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `idZamowienie` int(11) NOT NULL,
  `idKlient` int(20) NOT NULL,
  `idOpakowanie` int(20) NOT NULL,
  `idSkladniki` int(20) NOT NULL,
  `idSok` int(20) NOT NULL,
  `cena` float NOT NULL,
  `dataDostarczenia` date NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamowienia`
--

INSERT INTO `zamowienia` (`idZamowienie`, `idKlient`, `idOpakowanie`, `idSkladniki`, `idSok`, `cena`, `dataDostarczenia`, `ilosc`) VALUES
(22, 18, 2, 24, 9, 20, '2020-06-22', 10),
(23, 2, 2, 22, 5, 62, '2020-06-22', 30);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `opakowanie`
--
ALTER TABLE `opakowanie`
  ADD PRIMARY KEY (`idOpakowanie`);

--
-- Indeksy dla tabeli `skladniki`
--
ALTER TABLE `skladniki`
  ADD PRIMARY KEY (`idSkladniki`),
  ADD KEY `idSmak` (`idSmak`);

--
-- Indeksy dla tabeli `smak`
--
ALTER TABLE `smak`
  ADD PRIMARY KEY (`idSmak`);

--
-- Indeksy dla tabeli `sok`
--
ALTER TABLE `sok`
  ADD PRIMARY KEY (`idSok`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`idUzytkownicy`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`idZamowienie`),
  ADD KEY `idOpakowanie` (`idOpakowanie`),
  ADD KEY `idSok` (`idSok`),
  ADD KEY `idSkladniki` (`idSkladniki`),
  ADD KEY `idKlient` (`idKlient`,`idOpakowanie`,`idSok`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `opakowanie`
--
ALTER TABLE `opakowanie`
  MODIFY `idOpakowanie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `skladniki`
--
ALTER TABLE `skladniki`
  MODIFY `idSkladniki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT dla tabeli `smak`
--
ALTER TABLE `smak`
  MODIFY `idSmak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `sok`
--
ALTER TABLE `sok`
  MODIFY `idSok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `idUzytkownicy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `idZamowienie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `skladniki`
--
ALTER TABLE `skladniki`
  ADD CONSTRAINT `skladniki_ibfk_1` FOREIGN KEY (`idSmak`) REFERENCES `smak` (`idSmak`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`idKlient`) REFERENCES `uzytkownicy` (`idUzytkownicy`),
  ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`idOpakowanie`) REFERENCES `opakowanie` (`idOpakowanie`),
  ADD CONSTRAINT `zamowienia_ibfk_3` FOREIGN KEY (`idSok`) REFERENCES `sok` (`idSok`),
  ADD CONSTRAINT `zamowienia_ibfk_4` FOREIGN KEY (`idSkladniki`) REFERENCES `skladniki` (`idSkladniki`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
