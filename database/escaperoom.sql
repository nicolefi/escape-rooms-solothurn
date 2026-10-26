-- Datenbankstruktur für das Projekt 'Escape Rooms Solothurn'
-- Import: phpMyAdmin -> Neu -> Datenbank 'escaperoom' anlegen -> Importieren -> diese Datei

CREATE DATABASE IF NOT EXISTS `escaperoom` DEFAULT CHARACTER SET utf8mb4;
USE `escaperoom`;

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `gutschein_bestellungen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kunden_id` int(11) NOT NULL,
  `betrag` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'offen',
  `bestelldatum` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_bestellungen_kunden` (`kunden_id`),
  CONSTRAINT `fk_bestellungen_kunden` FOREIGN KEY (`kunden_id`) REFERENCES `kunden_profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `kontakt_nachrichten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vorname` varchar(255) NOT NULL,
  `nachname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nachricht` text NOT NULL,
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `kunden_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `vorname` varchar(255) NOT NULL,
  `nachname` varchar(255) NOT NULL,
  `strasse` varchar(255) NOT NULL,
  `plz` varchar(10) NOT NULL,
  `ort` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `logindaten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kunden_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_logindaten_kunden` (`kunden_id`),
  CONSTRAINT `fk_logindaten_kunden` FOREIGN KEY (`kunden_id`) REFERENCES `kunden_profile` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
