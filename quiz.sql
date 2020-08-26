-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Sty 2019, 22:03
-- Wersja serwera: 10.1.34-MariaDB
-- Wersja PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `quiz`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `nazwa` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`id`, `nazwa`) VALUES
(1, 'Filmy'),
(2, 'Człowiek'),
(3, 'Zwierzęta'),
(4, 'Gry'),
(6, 'Jedzenie'),
(7, 'Historia'),
(8, 'Komputery'),
(9, 'Programowanie'),
(10, 'Nowa kategoria testowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `Login` text COLLATE utf8_polish_ci NOT NULL,
  `Haslo` text COLLATE utf8_polish_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `login`
--

INSERT INTO `login` (`id`, `Login`, `Haslo`, `Email`) VALUES
(1, 'Gosia', '$2y$10$qT47waIjNYqhgiiWNUKmxebmSB6KIRaMG3VcWrlMESUgtKPLxS9Gi', 'gosia@gmail.com'),
(5, 'Weronika', '$2y$10$7Wkj9EHlWu9ytSXg76Q49.Zvf43xmw1/nEDpoI33KjojDgGMGo/b2', 'werka@gmail.com'),
(6, 'Szymon', '$2y$10$o1VxPpAY0fMjuNkDXnVAHu6d7L353NB4WwXYYcwwKlbltds/sTGAy', 'szymon@gmail.com'),
(7, 'Adam', '$2y$10$1HwckYAnhKYg8I59AAQmueLdTUy5O5Xbifm.Qkslhd9Yc0CZNHPPK', 'adam@gmail.com'),
(8, 'Test', '$2y$10$vPp0qppIdUEo.VCkB9ARZOsykyPNvRidlDU39QVoTsniT6FNFn9xO', 'test@test.com'),
(9, 'Basia', '$2y$10$xrBc/VqE4A/XJ5D2zjCM6.Fvs/yhuxw76X5aVClaekYHquMMFPKFy', 'basia@gmail.com'),
(10, 'qwerty', '$2y$10$CST0ZZC8vmaMniQbALHSFuzz2MGCk5Pc7O936eMFnednOWvyauil6', 'qwerty@qw.pl'),
(11, 'user25', '$2y$10$tboeMHF1.7iPCuG2fvm1QOOEO2v4UB6c6I.K4QTbpBf1yZOw1nInS', 'user25@gmail.com'),
(25, 'TestAplikacji', '$2y$10$tQpZ2zUJMovk4b7aJKkKUejS/ZrEkWBDDE5Fkbq5rZ1HBhg2Izy5K', 'example@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `odpowiedzi`
--

CREATE TABLE `odpowiedzi` (
  `id` int(11) NOT NULL,
  `pytanieID` int(11) NOT NULL,
  `tresc` text COLLATE utf8_polish_ci NOT NULL,
  `czyprawidlowa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `odpowiedzi`
--

INSERT INTO `odpowiedzi` (`id`, `pytanieID`, `tresc`, `czyprawidlowa`) VALUES
(1, 1, 'Harry Potter i kamień filozoficzny', 1),
(2, 2, 'syjamski', 0),
(3, 3, 'Gothic', 1),
(4, 1, 'Harry Potter i komnata tajemnic', 0),
(5, 2, 'sfinks', 1),
(6, 3, 'Diablo', 0),
(115, 38, ' 5', 0),
(116, 38, ' 10', 1),
(117, 38, ' 15', 0),
(118, 39, '3', 0),
(119, 39, '2', 0),
(120, 39, '1', 1),
(240, 1, 'Harry Potter i Czara ognia', 0),
(246, 67, ' Kotek', 1),
(247, 67, ' Piesek', 0),
(250, 69, 'Hermiona', 0),
(251, 69, 'Ron', 0),
(252, 69, 'Dumbledore', 0),
(253, 69, 'Harry Potter', 1),
(254, 69, 'Pomyluna', 0),
(285, 81, 'fsdfsdfds', 0),
(286, 81, 'fsdfsd', 1),
(287, 82, 'lama', 0),
(288, 82, 'żyrafa', 1),
(289, 82, 'koń', 0),
(292, 84, 'Pizza', 0),
(293, 84, 'Chili con carne', 0),
(294, 84, 'Bigos', 1),
(295, 85, 'panasonic', 0),
(296, 85, 'hp', 1),
(297, 85, 'inna firma', 0),
(298, 86, 'pierwsza odp', 0),
(299, 86, 'druga odp', 0),
(300, 86, 'prawidlowa odp', 1),
(301, 87, '3', 0),
(302, 87, '4', 0),
(303, 87, '5', 1),
(304, 88, 'tak', 1),
(305, 88, 'nie', 0),
(361, 88, 'nie wiem', 0),
(362, 96, 'nie', 0),
(363, 96, 'nie wiem', 0),
(364, 96, 'tak', 0),
(365, 96, 'na pewno tak', 1),
(366, 97, 'Ta odpowiedź', 0),
(367, 97, 'Ta odpowiedź', 0),
(368, 97, 'Ta odpowiedź', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pytania`
--

CREATE TABLE `pytania` (
  `id` int(11) NOT NULL,
  `tresc` text COLLATE utf8_polish_ci NOT NULL,
  `quizID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pytania`
--

INSERT INTO `pytania` (`id`, `tresc`, `quizID`) VALUES
(1, 'Jak nazywa się pierwsza część sagi?', 1),
(2, 'Jak nazywa się kot bez sierści?', 2),
(3, 'Jak nazywa się trylogia, w której głównym bohaterem jest Bezimienny?', 3),
(38, 'Ile masz palców u rąk?', 30),
(39, 'Ile masz par nóg?', 30),
(67, 'Jaki zwierzak miauczy?', 31),
(69, 'Jak nazywa się główny bohater?', 1),
(81, 'dfsdfsdfsfsd', 31),
(82, 'Jakie zwierzę ma najdłuższą szyję?', 31),
(84, 'Które danie należy do polskiej kuchni?', 36),
(85, 'Wybierz firmę komputera', 37),
(86, 'Pytanie o komputer', 37),
(87, 'Na ile poziomów dzieli się testy oprogramowania?', 38),
(88, 'Czy to pytanie było edytowane?', 38),
(96, 'Czy to pytanie było dodawane?', 38),
(97, 'Która odpowiedź jest trzecia?', 39);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `nazwa` text COLLATE utf8_polish_ci NOT NULL,
  `autorID` int(11) NOT NULL,
  `kategoriaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `quiz`
--

INSERT INTO `quiz` (`id`, `nazwa`, `autorID`, `kategoriaID`) VALUES
(1, 'Sprawdź swoją wiedzę o HP', 1, 1),
(2, 'quiz wiedzy o kotach', 1, 3),
(3, 'Wiedza o grach', 5, 4),
(30, 'Czy znasz swoje ciało?', 1, 2),
(31, 'Zwierzaki', 1, 3),
(36, 'Sprawdź swoją wiedzę o jedzeniu', 1, 6),
(37, 'Jaki masz komputer?', 1, 8),
(38, 'Quiz wiedzy o testach oprogramowania', 25, 8),
(39, 'Quiz wiedzy', 25, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ranking`
--

CREATE TABLE `ranking` (
  `id` int(11) NOT NULL,
  `loginID` int(11) NOT NULL,
  `quizID` int(11) NOT NULL,
  `wynik` int(11) NOT NULL,
  `czas` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `ranking`
--

INSERT INTO `ranking` (`id`, `loginID`, `quizID`, `wynik`, `czas`) VALUES
(1, 1, 1, 100, '00:00:05'),
(2, 1, 1, 0, '00:00:03'),
(3, 1, 30, 50, '00:00:06'),
(4, 1, 2, 100, '00:00:01'),
(5, 1, 31, 100, '00:00:08'),
(6, 5, 2, 100, '00:00:07'),
(7, 5, 1, 100, '00:00:02'),
(8, 1, 3, 100, '00:00:03'),
(11, 1, 31, 100, '00:00:10'),
(12, 1, 2, 100, '00:00:03'),
(13, 1, 30, 0, '00:00:02'),
(14, 1, 3, 100, '00:00:02'),
(15, 1, 1, 50, '00:00:06'),
(16, 1, 36, 100, '00:00:06'),
(17, 1, 30, 50, '00:00:04'),
(18, 1, 30, 50, '00:00:01'),
(19, 1, 2, 0, '00:00:03'),
(22, 1, 31, 33, '00:00:02'),
(39, 1, 36, 100, '00:00:02'),
(42, 1, 36, 0, '00:00:08'),
(43, 1, 36, 0, '00:00:17'),
(44, 1, 2, 100, '00:00:02'),
(45, 1, 2, 0, '00:00:02'),
(46, 1, 2, 100, '00:00:02'),
(47, 1, 36, 0, '00:00:02'),
(48, 1, 2, 100, '00:00:07'),
(49, 1, 2, 100, '00:00:02'),
(50, 1, 36, 100, '00:00:01'),
(53, 1, 2, 0, '00:01:15'),
(54, 1, 2, 100, '00:00:01'),
(55, 1, 36, 0, '00:00:02'),
(56, 1, 2, 100, '00:00:02'),
(57, 1, 1, 0, '00:00:04'),
(58, 25, 38, 100, '00:00:10'),
(59, 1, 38, 100, '00:00:04');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `odpowiedzi`
--
ALTER TABLE `odpowiedzi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pytanieID` (`pytanieID`);

--
-- Indeksy dla tabeli `pytania`
--
ALTER TABLE `pytania`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quizID` (`quizID`);

--
-- Indeksy dla tabeli `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autorID` (`autorID`),
  ADD KEY `kategoriaID` (`kategoriaID`);

--
-- Indeksy dla tabeli `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loginID` (`loginID`),
  ADD KEY `quizID` (`quizID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT dla tabeli `odpowiedzi`
--
ALTER TABLE `odpowiedzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=369;

--
-- AUTO_INCREMENT dla tabeli `pytania`
--
ALTER TABLE `pytania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT dla tabeli `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT dla tabeli `ranking`
--
ALTER TABLE `ranking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
