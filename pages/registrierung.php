<?php
require_once '../includes/session.php';
require_once __DIR__ . '/../includes/registrierung_validation.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/registrierung.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="icon" href="../img/logo.png" type="image/png">

    <script src="../js/nav.js" defer></script>
</head>
<body>
    <?php include('../components/nav.php'); ?>
    <main>
        <form action="<?= e($_SERVER['PHP_SELF']) ?>" method="post">
            <?= csrf_feld() ?>
            <h1>Registrierung</h1>
            <?php if($success):?>
                <div class="alert alert-success">
                <h2>Vielen Dank für deine Registrierung!</h2>
                <p>Du kannst dich jetzt <a href="login.php">anmelden</a>.</p>
            </div>
             <?php else: ?>
            <?php if(!empty($formErr)): ?>
                <div class="alert alert-danger"><?= e($formErr) ?></div>
            <?php endif; ?>
            <div>
                <label for="name">Name</label>
                <input id="name" type="text" name="name" autocomplete="username" placeholder="Benutzername" value="<?= e($name) ?>">
                <span class="error" id="nameErr"><?= e($nameErr) ?></span>

            </div>

              <div>
                <label for="email">E-Mail</label>
                <input id="email" type="email" name="email" autocomplete="email" placeholder="E-mail" value="<?= e($email) ?>">
                <span class="error" id="emailError"><?= e($emailErr) ?></span>
            </div>

            <div>
                <label for="password">Passwort</label>
                <p>Mindestens 6 Zeichen, davon 1 Grossbuchstabe und 1 Sonderzeichen.</p>
                <input type="password" name="password" id="password" autocomplete="new-password" placeholder="Passwort" >
                <span class="error" id="passwortError"><?= e($passwortErr) ?></span>
            </div>
            <button id="submit">Registrieren</button>
            <?php endif; ?>
        </form>

    </main>


    <?php include('../components/footer.php'); ?>

</body>
</html>
