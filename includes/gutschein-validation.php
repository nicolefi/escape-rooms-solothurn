<?php
require_once __DIR__ . '/session.php';

$vorname = '';
$nachname = '';
$email = '';
$ort = '';
$adresse = '';
$plz = '';
$betrag = '';

$nachnameErr = '';
$vornameErr = '';
$emailErr = '';
$adresseErr = '';
$ortErr = '';
$plzErr = '';
$betragErr = '';
$formErr = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $vorname = putzen($_POST['vorname'] ?? '');
    $nachname = putzen($_POST['nachname'] ?? '');
    $ort = putzen($_POST['ort'] ?? '');
    $email = putzen($_POST['email'] ?? '');
    $adresse = putzen($_POST['adr'] ?? '');
    $plz = putzen($_POST['plz'] ?? '');
    $betrag = putzen($_POST['betrag'] ?? '');

    // CSRF-Token prüfen
    if(!csrf_pruefen()){
        $formErr = "Das Formular ist abgelaufen. Bitte lade die Seite neu und versuche es noch einmal.";
    }

    // Vorname
    if(!empty($vorname)){
        if (!ist_gueltiger_name($vorname)) {
            $vornameErr = "Gib einen gültigen Namen ein.";
        }
    }else{
        $vornameErr = "Dieses Feld darf nicht leer sein.";
    }

    // Nachname
    if(!empty($nachname)){
         if (!ist_gueltiger_name($nachname)) {
            $nachnameErr = "Gib einen gültigen Namen ein.";
        }
    }else{
        $nachnameErr = "Dieses Feld darf nicht leer sein.";
    }

    // Email
    if(!empty($email)){
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Bitte gib eine gültige E-Mail-Adresse ein.";
         }
    }else{
        $emailErr = "Dieses Feld darf nicht leer sein.";
    }

    // Adresse
    if (!empty($adresse)) {
        if (!preg_match('/^.+\s+\d+[a-zA-Z]?$/u', $adresse)) {
            $adresseErr = "Bitte gib Strasse und Hausnummer ein.";
        }
    } else {
        $adresseErr = "Dieses Feld darf nicht leer sein.";
    }

    // PLZ
    if (!empty($plz)) {
        if (!preg_match('/^[1-9][0-9]{3}$/', $plz)) {
            $plzErr = "Bitte gib eine gültige Postleitzahl ein.";
        }
    } else {
        $plzErr = "Dieses Feld darf nicht leer sein.";
    }

    // Ort
    if(!empty($ort)){
         if (!ist_gueltiger_name($ort)) {
            $ortErr = "Gib einen gültigen Ort ein.";
        }
    }else{
        $ortErr = "Dieses Feld darf nicht leer sein.";
    }

    // Betrag
    if (!empty($betrag)) {
        if(!is_numeric($betrag) || $betrag <= 0 || $betrag > 1000){
            $betragErr = "Gib einen gültigen Betrag zwischen 1 und 1000 CHF ein.";
        }
    } else {
        $betragErr = "Dieses Feld darf nicht leer sein.";
    }

    // Falls keine Fehler entstanden
    if(empty($formErr) && empty($betragErr) && empty($plzErr) && empty($ortErr) && empty($adresseErr) && empty($emailErr) && empty($nachnameErr) && empty($vornameErr)){

        require_once __DIR__ . '/db.php';

        try {
            mysqli_begin_transaction($conn);

            // Fall 1: User hat schon ein Login (Eingeloggt)
            if(($_SESSION['login'] ?? '') === 'ok' && isset($_SESSION['kunden_id'])){
                $kundenId = $_SESSION['kunden_id'];

            // Fall 2: User hat noch kein Login (Gastbestellung)
            }else{
                // 1. Neues Profil in kunden_profile anlegen
                $sql_profil = "INSERT INTO kunden_profile (email, vorname, nachname, strasse, plz, ort) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_profil = mysqli_prepare($conn, $sql_profil);
                mysqli_stmt_bind_param($stmt_profil, "ssssss", $email, $vorname, $nachname, $adresse, $plz, $ort);
                mysqli_stmt_execute($stmt_profil);

                // 2. Erzeugte ID des Gast-Profils holen
                $kundenId = mysqli_insert_id($conn);
                mysqli_stmt_close($stmt_profil);
            }

            // Gutschein-Bestellung mit der kunden_id anlegen
            $sql = "INSERT INTO gutschein_bestellungen (kunden_id, betrag) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "id", $kundenId, $betrag);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            mysqli_commit($conn);
            $erfolgreich = true;
        } catch (mysqli_sql_exception $fehler) {
            mysqli_rollback($conn); // Rückgängigmachen der Schritte
            error_log("Gutschein-Bestellung fehlgeschlagen: " . $fehler->getMessage());
            $erfolgreich = false;
        }

        // Weiterleiten
        if($erfolgreich){
            header("Location: gutschein.php?succeed");
        } else {
            header("Location: gutschein.php?f1bestellung");
        }
        exit;
    }
}
?>