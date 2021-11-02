-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Okt 24. 11:50
-- Kiszolgáló verziója: 10.4.21-MariaDB
-- PHP verzió: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `szinesz`
--
CREATE DATABASE IF NOT EXISTS `szinesz` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci;
USE `szinesz`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szinesz`
--

CREATE TABLE `szinesz` (
  `id` int(11) NOT NULL,
  `nev` varchar(45) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `magassag` int(11) NOT NULL,
  `szul_datum` date NOT NULL,
  `dijak_szama` int(11) NOT NULL,
  `forgatason_van` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `szinesz`
--

INSERT INTO `szinesz` (`id`, `nev`, `magassag`, `szul_datum`, `dijak_szama`, `forgatason_van`) VALUES
(1, 'Zendaya', 178, '1996-09-01', 19, 0),
(2, 'Alec Baldwin', 183, '1958-04-03', 46, 1),
(3, 'Ryan Reynolds', 188, '1976-10-23', 18, 0),
(4, 'Daniel Craig', 178, '1968-03-02', 16, 0),
(5, 'Jodie Comer', 173, '1993-03-11', 8, 0),
(6, 'Timothée Chalamet', 182, '1995-12-27', 40, 1),
(7, 'Florence Pugh', 162, '1996-01-03', 36, 1);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `szinesz`
--
ALTER TABLE `szinesz`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `szinesz`
--
ALTER TABLE `szinesz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
