-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 28. Mrz 2022 um 08:56
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
  `date` datetime NOT NULL
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
(1, 'American Shorthair', 'Schnurrli', 'Bredlway 11', 'Schnurrli was a really kind cat who likes to sleep the whole day long', 'small', 7, 'be petted, playing with budgies', '624155ddc273a.jpg'),
(2, 'Lion', 'Puschl', 'sherwood forrest', 'for everyone who is looking for a really big challenge', 'xx-large', 11, 'eating kids', '6241558c26322.jpg'),
(11, 'American Bobtail[', 'Bagir', 'Homeway 23', 'a little shy but very sweet', 'small', 9, 'play with other cats, like sleeping', '623f6d9ab2805.jpg'),
(12, 'Australian Mist', 'Lilly', 'under the table 1', 'little cat who like kids', 'x-small', 1, 'purr and enjoy', '62415791a0622.jpg'),
(13, 'Cyprus', 'Felix', 'in the garden', 'chef of the house', 'small', 3, 'fight with others', '624158c904b98.jpg'),
(14, 'Gscheckert', 'Svinka Pepper', 'im Dreck 33', 'sweet and kind playing partner', 'medium', 0, 'grunt and play', '62415967b6437.jpg'),
(15, 'who knows', 'Rosalinde', 'Behind the house', 'some more infos', 'medium', 1, 'play with sticks and go for a walk', '62415a04e932f.jpg'),
(16, 'Amirican sheleter', 'Gaff Gaff', 'Rosegarden 17', 'always alert and very child friendly', 'small', 8, 'play with the tail', '62415a7d8b9d9.jpg'),
(17, 'Irish Long-eared', 'Charlie', 'between the house and the door', 'allways waiting for playing something', 'big', 13, 'playing frisby and swimming', '62415b6bc25af.jpg'),
(18, 'Hastered', 'Ready', 'Underfield 3', 'always alert and prepared for anything', 'x-small', 2, 'sit and wait', '62415bcf44f74.jpg');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
