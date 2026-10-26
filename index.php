<?php
require_once 'includes/session.php';

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escape Rooms</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?= filemtime('css/style.css') ?>" >
    <link rel="stylesheet" type="text/css" href="css/main.css?v=<?= filemtime('css/main.css') ?>" >
    <link rel="icon" href="img/logo.png" type="image/png">
    <script src="js/nav.js" defer></script>
    
</head>
<body>

<!--Header mit Navigation-->
    
    <?php include('components/nav.php');?>

    <!--Main--->
<main>
    <div class="bildContainer"><a href="#next" class="scroll-down"><i class="bi bi-chevron-down aufmacher-arrow"></i></a></div>
    <section id="next">
                <!-- Über uns -->
        <section class="about">
            <h1>Über uns</h1>
            <p>
                ESCAPE ROOMS SOLOTHURN steht für Spannung, Teamwork und unvergessliche Erlebnisse. Gemeinsam mit Freunden, Familie oder Arbeitskollegen tauchst du in eine andere Welt ein, löst knifflige Rätsel und stellst dich aufregenden Herausforderungen.

                Seid ihr bereit für die nächste Mission?
            </p>
            <a href="#" class="red-button">Mehr erfahren</a>
        </section>


        <!-- Escape Rooms -->
        <section class="escape-rooms">
                <h1>Unsere Escape Rooms</h1>
                <div class="room-container">
                    <div class="room">
                        <img class="room-image room1" src="img/buero_escape.webp" alt="Bild des Escape Rooms: Büro des Zauberers">
                        <h3>Büro des Zauberers</h3>
                        <a href="#" class="red-button">Mehr Infos</a>
                    </div>
                    <div class="room">
               
                         <img class="room-image room2" src="img/indianajones_escape.webp" alt="Bild des Escape Rooms: Indiana">
                        <h3>Indiana lässt grüssen</h3>
                    <a href="#" class="red-button">Mehr Infos</a>
                </div>
                <div class="room">
                  
                     <img class="room-image room3" src="img/unterwasser_escape.webp" alt="Bild des Escape Rooms: Poseidon">
                    <h3>Poseidon</h3>
                    <a href="#" class="red-button">Mehr Infos</a>
                </div>
            </div>
        </section>


            <!-- Abschluss -->
            <section class="cta">
            <h1>Bereit für Escape Rooms Solothurn?</h1>
            <a href="#" class="red-button">Jetzt buchen</a>
        </section>

    </section>
        
</main>

<?php
include('components/footer.php');
?>

</body>
</html>
