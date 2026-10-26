<?php
require_once('../includes/auth.php');
include_once('../includes/db.php');

// 1. Alle Variablen EINMALIG am Anfang definieren
$email = $vorname = $nachname = $adresse = $plz = $ort = '';
$nachnameErr = $vornameErr = $emailErr = $adresseErr = $ortErr = $plzErr = $formErr = '';

$kundenId = $_SESSION['kunden_id'];

//------------- FALL A: Formular wurde abgeschickt (SPEICHERN) -------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $vorname = putzen($_POST['vorname'] ?? '');
    $nachname = putzen($_POST['nachname'] ?? '');
    $email = putzen($_POST['email'] ?? '');
    $adresse = putzen($_POST['adresse'] ?? '');
    $plz = putzen($_POST['plz'] ?? '');
    $ort = putzen($_POST['ort'] ?? '');

    // 0. CSRF-Token prüfen
    if (!csrf_pruefen()) {
        $formErr = "Das Formular ist abgelaufen. Bitte lade die Seite neu und versuche es noch einmal.";
    }

    // 1. Vorname prüfen
    if(!empty($vorname)){
        if (!ist_gueltiger_name($vorname)) {
            $vornameErr = "Gib einen gültigen Namen ein.";
        }
    }else{
        $vornameErr = "Dieses Feld darf nicht leer sein.";
    }

    // 2. Nachname prüfen
    if(!empty($nachname)){
         if (!ist_gueltiger_name($nachname)) {
            $nachnameErr = "Gib einen gültigen Namen ein.";
        }
    }else{
        $nachnameErr = "Dieses Feld darf nicht leer sein.";
    }

    // 3. Ort prüfen (erlaubt Umlaute, Leerzeichen und Bindestriche)
    if(!empty($ort)){
        if (!ist_gueltiger_name($ort)) {
            $ortErr = "Gib einen gültigen Ort ein.";
        }
    }else{
        $ortErr = "Dieses Feld darf nicht leer sein.";
    }

    // 4. E-Mail prüfen
    if(!empty($email)){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Bitte gib eine gültige E-Mail-Adresse ein.";
        } else {
            //Die E-mail darf nur einmal vorhanden sein und deshalb überprüfen wir alle anderen Profile, ob sie ja nicht die gleiche Mail haben
            $sqlCheck = "SELECT id FROM kunden_profile WHERE email = ? AND id != ?";
            $stmtCheck = mysqli_prepare($conn, $sqlCheck);
            mysqli_stmt_bind_param($stmtCheck, "si", $email, $kundenId);
            mysqli_stmt_execute($stmtCheck);
            $resultCheck = mysqli_stmt_get_result($stmtCheck);
            //Es gab ein Resultat mit derselben Mail --> Fehler anzeigen
            if (mysqli_num_rows($resultCheck) > 0) {
                $emailErr = "Diese E-Mail-Adresse wird bereits verwendet.";
            }
            mysqli_stmt_close($stmtCheck);
        }
    } else {
        $emailErr = "Dieses Feld darf nicht leer sein.";
    }

    // 5. Adresse prüfen
    if (!empty($adresse)) {
        if (!preg_match('/^.+\s+\d+[a-zA-Z]?$/u', $adresse)) {
            $adresseErr = "Bitte gib Strasse und Hausnummer ein.";
        }
    } else {
        $adresseErr = "Dieses Feld darf nicht leer sein.";
    }

    // 6. PLZ prüfen
    if (!empty($plz)) {
        if (!preg_match('/^[1-9][0-9]{3}$/', $plz)) {
            $plzErr = "Bitte gib eine gültige Postleitzahl ein.";
        }
    } else {
        $plzErr = "Dieses Feld darf nicht leer sein.";
    }

    // 7. Wenn gar keine Fehler vorliegen -> In die Datenbank schreiben/updaten
    if(empty($formErr) && empty($ortErr) && empty($plzErr) && empty($adresseErr) && empty($emailErr) && empty($nachnameErr) && empty($vornameErr)){

        $sql = "UPDATE kunden_profile
                SET email = ?,
                    vorname = ?,
                    nachname = ?,
                    strasse = ?,
                    plz = ?,
                    ort = ?
                WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssi", $email, $vorname, $nachname, $adresse, $plz, $ort, $kundenId);
        $successProfil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if($successProfil){
            header("Location: willkommen.php?succeed");
            exit;
        } else {
            header("Location: logindaten-bearbeiten.php?f1");
            exit;
        }
    }

//------------- FALL B: Seite wurde normal geladen (ANZEIGEN) -------------
} else {
    $sqlLoad = "SELECT email, vorname, nachname, strasse, plz, ort
                FROM kunden_profile
                WHERE id = ?";

    $stmtLoad = mysqli_prepare($conn, $sqlLoad);
    mysqli_stmt_bind_param($stmtLoad, "i", $kundenId);
    mysqli_stmt_execute($stmtLoad);
    $resultLoad = mysqli_stmt_get_result($stmtLoad);

    if ($row = mysqli_fetch_assoc($resultLoad)) {
        $email = $row['email'] ?? '';
        $vorname = $row['vorname'] ?? '';
        $nachname = $row['nachname'] ?? '';
        $adresse = $row['strasse'] ?? '';
        $plz = $row['plz'] ?? '';
        $ort = $row['ort'] ?? '';
    }
    mysqli_stmt_close($stmtLoad);
}
?>



<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerbereich</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/willkommen.css">
    <link rel="icon" href="../img/logo.png" type="image/png">
    <script src="../js/nav.js" defer></script>
</head>
<body>
    <?php include('../components/nav.php'); ?>
    <main>
          <a href="javascript:history.back()" class="zurueck btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Zurück
           </a>
        <div>
            <section id="bearbeiten-main">
                <h3>Persönliche Daten bearbeiten</h3>

                <?php if (isset($_GET['f1'])): ?>
                    <div class="alert alert-danger">Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es noch einmal.</div>
                <?php endif; ?>
                <?php if (!empty($formErr)): ?>
                    <div class="alert alert-danger"><?= e($formErr) ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <?= csrf_feld() ?>

                    <div>
                        <label for="vorname">Vorname:</label>
                        <input type="text" id="vorname" name="vorname" value="<?= e($vorname) ?>" required>
                        <?php if(!empty($vornameErr)) echo '<span class="error">' . e($vornameErr) . '</span>'; ?>
                    </div>

                    <div>
                        <label for="nachname">Nachname:</label>
                        <input type="text" id="nachname" name="nachname" value="<?= e($nachname) ?>" required>
                        <?php if(!empty($nachnameErr)) echo '<span class="error">' . e($nachnameErr) . '</span>'; ?>
                    </div>

                    <div>
                        <label for="email">E-Mail:</label>
                        <input type="email" id="email" name="email" value="<?= e($email) ?>" required>
                        <?php if(!empty($emailErr)) echo '<span class="error">' . e($emailErr) . '</span>'; ?>
                    </div>

                    <div>
                        <label for="adresse">Strasse und Nummer:</label>
                        <input type="text" id="adresse" name="adresse" value="<?= e($adresse) ?>" required>
                        <?php if(!empty($adresseErr)) echo '<span class="error">' . e($adresseErr) . '</span>'; ?>
                    </div>

                    <div>
                        <label for="plz">PLZ:</label>
                        <input type="text" inputmode="numeric" id="plz" name="plz" value="<?= e($plz) ?>" required>
                        <?php if(!empty($plzErr)) echo '<span class="error">' . e($plzErr) . '</span>'; ?>
                    </div>

                    <div>
                        <label for="ort">Ort:</label>
                        <input type="text" id="ort" name="ort" value="<?= e($ort) ?>" required>
                        <?php if(!empty($ortErr)) echo '<span class="error">' . e($ortErr) . '</span>'; ?>
                    </div>

                    <button type="submit">Daten speichern</button>
                    <button type="reset">Zurücksetzen</button>

                </form>
            </section>
        </div>
    </main>

    <?php include('../components/footer.php'); ?>
</body>
</html>
