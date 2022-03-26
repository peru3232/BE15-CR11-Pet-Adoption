-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Mrz 2022 um 17:59
-- Server-Version: 10.4.22-MariaDB
-- PHP-Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `be15_cr11_petadoption_peter`
--
CREATE DATABASE IF NOT EXISTS `be15_cr11_petadoption_peter` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be15_cr11_petadoption_peter`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adoption`
--

CREATE TABLE `adoption` (
  `fk_userName` varchar(16) NOT NULL,
  `fk_pet_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `breed` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `location` varchar(64) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `size` varchar(16) NOT NULL,
  `age` smallint(6) NOT NULL,
  `hobbies` varchar(128) DEFAULT NULL,
  `photo` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `animals`
--

INSERT INTO `animals` (`id`, `breed`, `name`, `location`, `description`, `size`, `age`, `hobbies`, `photo`) VALUES
(1, 'American Shorthair', 'Schnurrli', 'Bredlway 11', 'Schnurrli was a really kind cat who likes to sleep the whole day long', 'small', 7, 'be petted, playing with budgies', 'Mietzi.jpg'),
(2, 'Lion', 'Puschl', 'sherwood forrest', '', 'xx-large', 11, 'eating kids', 'Puschl.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `userName` varchar(16) NOT NULL,
  `firstName` varchar(32) NOT NULL,
  `lastName` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phoneNumber` varchar(16) NOT NULL,
  `address` varchar(64) NOT NULL,
  `picture` varchar(32) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`userName`, `firstName`, `lastName`, `email`, `phoneNumber`, `address`, `picture`, `password`, `status`) VALUES
('peru3232', 'Peter', 'Wochinger', 'prw@qmail.com.de', '0123 456789', 'Phantasie 14', 'admavatar.png', '42176187c7e539a97af72e2183cb152fc98fc91d0b56434f83c7bbda7d54d1cf', 'adm'),
('tester12', 'Testa', 'Testinger', 'r@e.a', '012 3456 78901', 'Nirgendwo 34', '623f44433b639.png', '42176187c7e539a97af72e2183cb152fc98fc91d0b56434f83c7bbda7d54d1cf', 'user');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `adoption`
--
ALTER TABLE `adoption`
  ADD KEY `adoption_ibfk_1` (`fk_userName`),
  ADD KEY `adoption_ibfk_2` (`fk_pet_id`);

--
-- Indizes für die Tabelle `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userName`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `adoption`
--
ALTER TABLE `adoption`
  ADD CONSTRAINT `adoption_ibfk_1` FOREIGN KEY (`fk_userName`) REFERENCES `users` (`userName`),
  ADD CONSTRAINT `adoption_ibfk_2` FOREIGN KEY (`fk_pet_id`) REFERENCES `animals` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
