<?php
require_once('session.php');

//ist der Benutzer eingeloggt?

if (($_SESSION['login'] ?? '') !== 'ok' || !isset($_SESSION['kunden_id'])) {
    header("Location: login.php");
    exit;
}

?>