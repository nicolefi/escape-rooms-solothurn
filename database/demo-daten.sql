-- Demo-Daten für das Projekt 'Escape Rooms Solothurn' (freiwillig)
-- Zuerst escaperoom.sql importieren, danach diese Datei.
-- Alle Personen sind erfunden; example.ch ist eine reservierte Beispiel-Domain.
--
-- Demo-Login:  Benutzername: demo   Passwort: Demo!123

USE `escaperoom`;

INSERT INTO `kunden_profile` (`id`, `email`, `vorname`, `nachname`, `strasse`, `plz`, `ort`) VALUES
(1, 'karin.schenk@example.ch', 'Karin', 'Schenk', 'Schlafstrasse 22', '8001', 'Zürich'),
(2, 'anna.graber@example.ch', 'Anna', 'Graber', 'Hammer 6', '2540', 'Grenchen');

-- Karin ist registriert (Demo-Login), Anna hat als Gast bestellt
INSERT INTO `logindaten` (`id`, `kunden_id`, `username`, `passwort`) VALUES
(1, 1, 'demo', '$2y$10$HMLzh31d51zlb0QKHC0xBOFHu.hDLAFY76XRVCCkhw/VPvldjBOUO');

INSERT INTO `gutschein_bestellungen` (`id`, `kunden_id`, `betrag`, `status`, `bestelldatum`) VALUES
(1, 1, 40.00, 'offen', '2026-10-23 13:35:49'),
(2, 2, 50.00, 'offen', '2026-10-23 13:37:12');
