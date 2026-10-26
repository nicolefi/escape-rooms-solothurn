<?php
require_once __DIR__ . '/session.php';

$vorname = $nachname = $email = $nachricht = '';
$vornameErr = $nachnameErr = $emailErr = $nachrichtErr = $formErr = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $vorname = putzen($_POST['vorname'] ?? '');
    $nachname = putzen($_POST['nachname'] ?? '');
    $email = putzen($_POST['email'] ?? '');
    $nachricht = putzen($_POST['nachricht'] ?? '');

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

    // Nachricht
    if(empty($nachricht)){
        $nachrichtErr = "Dieses Feld darf nicht leer sein.";
    }elseif(mb_strlen($nachricht) > 5000){
        $nachrichtErr = "Die Nachricht darf höchstens 5000 Zeichen lang sein.";
    }

    // Falls keine Fehler entstanden -> Nachricht speichern
    if(empty($formErr) && empty($vornameErr) && empty($nachnameErr) && empty($emailErr) && empty($nachrichtErr)){
        require_once __DIR__ . '/db.php';

        $sql = "INSERT INTO kontakt_nachrichten (vorname, nachname, email, nachricht) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $vorname, $nachname, $email, $nachricht);

        try {
            mysqli_stmt_execute($stmt);
            header("Location: kontakt.php?succeed");
        } catch (mysqli_sql_exception $fehler) {
            error_log("Kontaktnachricht fehlgeschlagen: " . $fehler->getMessage());
            header("Location: kontakt.php?f1");
        }
        exit;
    }
}
?>