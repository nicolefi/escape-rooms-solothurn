<?php
require_once '../includes/session.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">

    <link rel="icon" href="../img/logo.png" type="image/png">
    <script src="../js/nav.js" defer></script>
</head>
<body>
    <?php include('../components/nav.php'); ?>
    <main>
        <form action="../includes/login-validierung.php" method="post">
            <?= csrf_feld() ?>
            <h1>Login Benutzerbereich</h1>
            <h4>Gib deine Daten ein. Du hast noch kein Profil? <br><br>Hier geht's zur <a href="registrierung.php">Registrierung</a>.</h4>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" autocomplete="username" placeholder="Benutzername">

            <label for="password">Passwort:</label>
            <input type="password" name="password" id="password" autocomplete="current-password" placeholder="Passwort">
            <?php if(isset($_GET['f'])): ?>
                <p class='fehler'>
                    <?= $_GET['f'] === '4' ? 'Das Formular ist abgelaufen. Bitte versuche es noch einmal.' : 'Login-Daten nicht korrekt' ?>
                </p>
            <?php endif; ?>
            <button id="submit">Anmelden</button>
        </form>

    </main>


    <?php include('../components/footer.php'); ?>
</body>
</html>
