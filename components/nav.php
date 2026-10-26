<?php

$skript = $_SERVER['SCRIPT_NAME'];
$projekt = dirname($skript);

$base = rtrim($projekt, '/') . '/';
$aktuelleSeite = basename($_SERVER['SCRIPT_NAME']);

?>
    <header>
        <img class="logo logo-nav" src="<?php if (strpos($base, 'pages') !== false){echo '../';}?>img/logo.png" alt="Logo Schlüssel von Escape Room Solothurn">
        <i class="bi bi-list burgerbar" id="burgerbar"></i>
        <nav id="oben">
            <ul id="navUl">
                <i id="kreuz" class="bi bi-x hide"></i>
                <li id="Home" class="<?= $aktuelleSeite === 'index.php' ? 'active' : ''?>"><a href="<?php if (strpos($base, 'pages') !== false) {$base = str_replace('pages/', '', $base);echo $base;} //bei index.php wird pages weggenommen ?>index.php">Home</a></li>
                <li class="dropdown-klick" id="EscapeRooms" ><a href="#">Escape Rooms <i class="bi bi-chevron-down"></i></a>
                        <ul id="dropdown-rooms" class="dropdown">
                            <li class="<?= $aktuelleSeite === 'escape-rooms.php' ? 'active' : ''?>"><a href="#">Übersicht</a></li>
                            <li class="<?= $aktuelleSeite === 'buero-des-zauberers.php' ? 'active' : ''?>"><a href="#">Büro des Zauberers</a></li>
                            <li class="<?= $aktuelleSeite === 'indiana.php' ? 'active' : ''?>"><a href="#">Indiana</a></li>
                            <li class="<?= $aktuelleSeite === 'poseidon.php' ? 'active' : ''?>"><a href="#">Poseidon</a></li>
                        </ul>
                 </li>

                <li class="dropdown-klick" id="ueber"><a href="#">Über <i class="bi bi-chevron-down"></i></a>
                    
                        <ul id="dropdown-ueber" class="dropdown">
                            <li class="<?= $aktuelleSeite === 'team.php' ? 'active' : ''?>"><a href="#">Team</a></li>
                            <li class="<?= $aktuelleSeite === 'solothurnescape.php' ? 'active' : ''?>"><a href="#">Ueber Solothurn Escape Rooms</a></li>
                          
                        </ul>
                </li>
                    
    
                <li id="Events" class="<?= $aktuelleSeite === 'events.php' ? 'active' : ''?>"><a id="events" href="#">Events</a></li>
                <li class="<?= $aktuelleSeite === 'gutschein.php' ? 'active' : ''?>"><a href="<?= $base ?>pages/gutschein.php">Gutschein</a></li>
                <li class="<?= $aktuelleSeite === 'kontakt.php' ? 'active' : ''?>"><a href="<?= $base ?>pages/kontakt.php">Kontakt</a></li>
             
            </ul>
        </nav>
            <div class="nav-rechts">
                <button class="sprache navbutton">DE <i class="bi bi-chevron-down"></i></button>
                <button class="buchen navbutton">Buchen</button>
                <?php 
                if (isset($_SESSION['login']) && $_SESSION['login'] === 'ok') {

    if (strpos($base, 'pages') !== false) {
        echo '<a href="' . $base . 'willkommen.php" class="profil-icon">
                <i class="bi bi-person-circle"></i>
              </a>';

        echo '<a href="' . $base . 'logout.php" class="profil-icon">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
              </a>';

    } else {
        echo '<a href="' . $base . 'pages/willkommen.php" class="profil-icon">
                <i class="bi bi-person-circle"></i>
              </a>';

        echo '<a href="' . $base . 'pages/logout.php" class="profil-icon">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
              </a>';
    }

} else {

    if (strpos($base, 'pages') !== false) {
        $loginLink = $base . 'login.php';
    } else {
        $loginLink = $base . 'pages/login.php';
    }

    echo '<a href="' . $loginLink . '" class="profil-icon" aria-label="Login">
            <i class="bi bi-person-circle"></i>
            <span>Login</span>
          </a>';
}
                ?>
              
            </div>
           
    </header>