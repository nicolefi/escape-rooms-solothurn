<?php
require_once __DIR__ . '/session.php';

$name = '';
$email = '';
$passwort = '';

$passwortErr = $emailErr = $nameErr = $formErr = '';

$success = false;

//Abgeschickt?
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = putzen($_POST['name'] ?? '');
    $email = putzen($_POST['email'] ?? '');
    $passwort = $_POST['password'] ?? '';

    // CSRF-Token prüfen
    if(!csrf_pruefen()){
        $formErr = "Das Formular ist abgelaufen. Bitte lade die Seite neu und versuche es noch einmal.";
    }

//Name (Benutzername: Buchstaben, Zahlen, Punkt, Bindestrich, Unterstrich)
    if(empty($name)){
        $nameErr = 'Dieses Feld darf nicht leer sein.';
    }else{
         if(!preg_match("/^[\p{L}\p{N}._-]{3,30}$/u", $name)){
            $nameErr = "Der Benutzername muss 3–30 Zeichen lang sein (Buchstaben, Zahlen, . _ -).";
        }
    }

 //E-Mail
   if(!empty($email)){
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Bitte gib eine gültige E-Mail-Adresse ein.";
            }
    }else{
        $emailErr = "Dieses Feld darf nicht leer sein.";
    }

//Passwort
    if(!empty($passwort)){
        if(!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{6,}$/', $passwort)){
            $passwortErr = "Bitte gib ein gültiges Passwort ein.";
        }
    }else{
        $passwortErr = "Dieses Feld darf nicht leer sein.";
    }

    require_once __DIR__ . '/db.php';

    //Ist der Benutzername schon vergeben?
    if(empty($nameErr)){
        $stmt_check = mysqli_prepare($conn, "SELECT id FROM logindaten WHERE username = ?");
        mysqli_stmt_bind_param($stmt_check, 's', $name);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        if(mysqli_stmt_num_rows($stmt_check) > 0){
            $nameErr = "Dieser Benutzername ist bereits vergeben.";
        }
        mysqli_stmt_close($stmt_check);
    }

//Wenn alles okay
     if(empty($formErr) && empty($emailErr) && empty($nameErr) && empty($passwortErr)){

        $passwortHash = password_hash($passwort, PASSWORD_DEFAULT);

        // Profil und Login gemeinsam speichern: entweder beides oder nichts
        try {
            mysqli_begin_transaction($conn);

            // Profil in kunden_profile anlegen
            $sql_profil = "INSERT INTO kunden_profile (email, vorname, nachname, strasse, plz, ort) VALUES (?, '', '', '', '', '')";
            $stmt_profil = mysqli_prepare($conn, $sql_profil);
            mysqli_stmt_bind_param($stmt_profil, 's', $email);
            mysqli_stmt_execute($stmt_profil);

            // kunden_id auslesen
            $neue_kunden_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt_profil);

            // Die Logindaten mit der kunden_id anlegen
            $sql_login = "INSERT INTO logindaten (kunden_id, username, passwort) VALUES (?, ?, ?)";
            $stmt_login = mysqli_prepare($conn, $sql_login);
            mysqli_stmt_bind_param($stmt_login, 'iss', $neue_kunden_id, $name, $passwortHash);
            mysqli_stmt_execute($stmt_login);
            mysqli_stmt_close($stmt_login);

            mysqli_commit($conn);
            $success = true;
        } catch (mysqli_sql_exception $fehler) {
            mysqli_rollback($conn);
            error_log("Registrierung fehlgeschlagen: " . $fehler->getMessage());
            $formErr = "Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es noch einmal.";
        }
    }
}

?>