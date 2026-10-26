<?php
// Zugangsdaten aus config.php laden (Vorlage: config.example.php)
$config = require __DIR__ . '/config.php';

// Datenbankfehler als Exception melden (Standard ab PHP 8.1, hier auch für ältere Versionen)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// 1. Verbindung zur Datenbank aufbauen (MySQLi)
try {
  $conn = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);
  mysqli_set_charset($conn, 'utf8mb4'); // Zeichenkodierung soll in utf8mb4 sein
} catch (mysqli_sql_exception $fehler) {
  // Keine technischen Details an den Besucher ausgeben
  error_log("DB-Verbindung fehlgeschlagen: " . $fehler->getMessage());
  die("Die Datenbank ist momentan nicht erreichbar. Bitte versuche es später noch einmal.");
}
?>