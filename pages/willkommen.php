<?php
require_once('../includes/auth.php');
include_once('../includes/db.php');

// Variablen vorab definieren, falls kein Datensatz gefunden wird
$email = $vorname = $nachname = $adresse = $plz = $ort = '';
$bestellungen = [];

$kundenId = $_SESSION['kunden_id'];

// Persönliche Daten laden
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

// Gutschein-Bestellungen des Kunden laden (neueste zuerst)
$sqlBestellungen = "SELECT id, betrag, status, bestelldatum
                    FROM gutschein_bestellungen
                    WHERE kunden_id = ?
                    ORDER BY bestelldatum DESC";

$stmtBestellungen = mysqli_prepare($conn, $sqlBestellungen);
mysqli_stmt_bind_param($stmtBestellungen, "i", $kundenId);
mysqli_stmt_execute($stmtBestellungen);
$bestellungen = mysqli_fetch_all(mysqli_stmt_get_result($stmtBestellungen), MYSQLI_ASSOC);
mysqli_stmt_close($stmtBestellungen);

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
          <h1>Willkommen <?= e($_SESSION['username'] ?? 'Gast') ?></h1>

          <?php if (isset($_GET['succeed'])): ?>
              <div class="alert alert-success"><p>Deine Daten wurden gespeichert.</p></div>
          <?php endif; ?>

            <p>Hier siehst du deine persönlichen Daten und deine bestellten Gutscheine. Fehlen noch Angaben? Dann ergänze sie unter «Daten bearbeiten», damit wir dir Gutscheine per Post zustellen können.</p>
        <div class="box-sections">
            <section id="section-1">
                <h3>Persönliche Daten</h3>
                <p>Vorname: <?= e($vorname) ?></p>
                <p>Nachname: <?= e($nachname) ?></p>
                <p>E-Mail: <?= e($email) ?></p>
                <p>Adresse: <?= e($adresse) ?></p>
                <p>PLZ: <?= e($plz) ?></p>
                <p>Ort: <?= e($ort) ?></p>

                <a class="btn btn-default" href="logindaten-bearbeiten.php">Daten bearbeiten</a>
            </section>

                <section>
                    <h3>Meine Bestellungen</h3>
                    <?php if (empty($bestellungen)): ?>
                        <p>Du hast noch keine Gutscheine bestellt.</p>
                        <p><a href="gutschein.php">Jetzt Gutschein bestellen</a></p>
                    <?php else: ?>
                        <?php foreach ($bestellungen as $bestellung): ?>
                            <p>
                                Bestellung #<?= e($bestellung['id']) ?> – CHF <?= e(number_format((float)$bestellung['betrag'], 2, '.', "'")) ?><br>
                                <small><?= e(date('d.m.Y', strtotime($bestellung['bestelldatum']))) ?> · Status: <?= e($bestellung['status']) ?></small>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </section>

                <section id="section-3">
                    <h3>Weitere Optionen</h3>
                    <ul>
                        <li><a href="gutschein.php">Gutschein bestellen</a></li>
                        <li><a href="logindaten-bearbeiten.php">Adresse ändern</a></li>
                        <li><a href="logout.php">Abmelden</a></li>
                    </ul>
                </section>
            </div>
        </main>

    <?php include('../components/footer.php'); ?>
</body>
</html>
