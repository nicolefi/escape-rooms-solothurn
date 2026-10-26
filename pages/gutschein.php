<?php
require_once '../includes/session.php';
require_once __DIR__ . '/../includes/gutschein-validation.php';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" type="text/css" href="../css/style.css?v=<?= filemtime(__DIR__ . '/../css/style.css') ?>" >
    <link rel="stylesheet" type="text/css" href="../css/gutschein.css?v=<?= filemtime(__DIR__ . '/../css/gutschein.css') ?>" >
    <link rel="icon" href="../img/logo.png" type="image/png">
    <script src="../js/nav.js" defer></script>
    <title>Gutschein bestellen</title>
</head>
<body>
    <?php include("../components/nav.php");?>
    <main>
        <div class="wrapper-seitenbild">
            <img id="gutscheinbild" src="../img/gutschein.webp" alt="Bild von einem Gutschein">
        </div>
         <a href="javascript:history.back()" class="zurueck btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Zurück
        </a>
        <h1>Gutschein</h1>

        <!-- Fall 1: Bestellung war erfolgreich -> Formular verbergen -->
        <?php if (isset($_GET['succeed'])): ?>

            <div class="alert alert-success">
                <h2>Vielen Dank für deine Bestellung!</h2>
                <p>Dein Gutschein wurde erfolgreich bestellt und wird dir innerhalb von 2-3 Werktagen per Post zugestellt.</p>
            </div>

        <!-- Fall 2: Keine erfolgreiche Bestellung -> Formular normal anzeigen -->
        <?php else: ?>

            <?php if (isset($_GET['f1bestellung'])): ?>
                <div class="alert alert-danger">
                    Hoppla! Da ist ein Fehler in der Datenbank aufgetreten. Bitte versuche es noch einmal.
                </div>
            <?php endif; ?>

            <?php if (!empty($formErr)): ?>
                <div class="alert alert-danger"><?= e($formErr) ?></div>
            <?php endif; ?>

            <p>Möchtest du gerne einen Geschenkgutschein bestellen? Fülle das Formular unten aus und du erhältst den Gutschein innerhalb von 2-3 Werktagen per Post.</p>

            <form class="formularGutschein" id="formularGutschein" method="post" action="<?= e($_SERVER['PHP_SELF']) ?>">
                <?= csrf_feld() ?>
                <div class="formularGutschein2">
                    <div>
                        <label for="vorname">Vorname</label>
                        <input class="formularGutschein3" name="vorname" type="text" id="vorname" placeholder="Vorname" value="<?= e($vorname) ?>" required>
                        <span class="error" id="vornameError"><?= e($vornameErr) ?></span>

                        <label for="nachname">Nachname</label>
                        <input class="formularGutschein3" name="nachname" type="text" id="nachname" placeholder="Nachname" value="<?= e($nachname) ?>" required>
                        <span class="error" id="nachnameError"><?= e($nachnameErr) ?></span>

                        <label for="plz">Postleitzahl</label>
                        <input class="formularGutschein3" type="text" inputmode="numeric" name="plz" id="plz" placeholder="Postleitzahl" value="<?= e($plz) ?>" required>
                        <span class="error" id="plzError"><?= e($plzErr) ?></span>

                        <label for="adr">Adresse</label>
                        <input class="formularGutschein3" type="text" name="adr" id="adr" placeholder="Strasse und Nr." value="<?= e($adresse) ?>" required>
                        <span class="error" id="adresseError"><?= e($adresseErr) ?></span>

                        <label for="ort">Ort</label>
                        <input class="formularGutschein3" name="ort" type="text" id="ort" placeholder="Ort" value="<?= e($ort) ?>" required>
                        <span class="error" id="ortError"><?= e($ortErr) ?></span>

                    </div>
                    <div>

                        <label for="email">E-mail</label>
                        <input class="formularGutschein3" name="email" type="email" id="email" placeholder="E-mail" value="<?= e($email) ?>" required>
                        <span class="error" id="emailError"><?= e($emailErr) ?></span>

                        <label for="betrag">Betrag (CHF)</label>
                        <input class="formularGutschein3" type="number" min="1" max="1000" step="0.05" name="betrag" id="betrag" value="<?= e($betrag) ?>" required>
                        <span class="error" id="betragError"><?= e($betragErr) ?></span>
                    </div>
                </div>
                <button id="submit">Bestellen</button>
            </form>

        <?php endif; ?>

    </main>
    <?php include("../components/footer.php");?>
</body>
</html>
