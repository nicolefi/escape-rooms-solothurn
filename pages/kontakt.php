<?php
require_once '../includes/session.php';
require_once __DIR__ . '/../includes/kontakt-validierung.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/kontakt.css">
    <link rel="icon" href="../img/logo.png" type="image/png">
    <script src="../js/nav.js" defer></script>
    <title>Kontakt</title>
</head>
<body>
    <?php include('../components/nav.php'); ?>

    <!--Kontaktformular-->
    <main>
        <h1>Kontakt</h1>

        <?php if (isset($_GET['succeed'])): ?>
            <div class="alert alert-success">
                <h2>Vielen Dank für deine Nachricht!</h2>
                <p>Wir melden uns so schnell wie möglich bei dir.</p>
            </div>
        <?php else: ?>

            <h3>Hast du eine Frage oder ein anderes Anliegen? Schreibe uns eine Nachricht.</h3>

            <?php if (isset($_GET['f1'])): ?>
                <div class="alert alert-danger">Deine Nachricht konnte nicht gesendet werden. Bitte versuche es noch einmal.</div>
            <?php endif; ?>
            <?php if (!empty($formErr)): ?>
                <div class="alert alert-danger"><?= e($formErr) ?></div>
            <?php endif; ?>

            <form action="<?= e($_SERVER['PHP_SELF']) ?>" method="post">
                <?= csrf_feld() ?>

                <label for="vorname">Vorname</label>
                <input type="text" name="vorname" id="vorname" value="<?= e($vorname) ?>" required>
                <span class="error"><?= e($vornameErr) ?></span>

                <label for="nachname">Nachname</label>
                <input type="text" name="nachname" id="nachname" value="<?= e($nachname) ?>" required>
                <span class="error"><?= e($nachnameErr) ?></span>

                <label for="email">E-Mail</label>
                <input type="email" name="email" id="email" value="<?= e($email) ?>" required>
                <span class="error"><?= e($emailErr) ?></span>

                <label for="nachricht">Nachricht</label>
                <textarea name="nachricht" id="nachricht" cols="200" rows="10" maxlength="5000" required><?= e($nachricht) ?></textarea>
                <span class="error"><?= e($nachrichtErr) ?></span>

                <button id="submit">Senden</button>
            </form>
        <?php endif; ?>
    </main>

    <?php include('../components/footer.php'); ?>
</body>
</html>
