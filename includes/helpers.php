<?php
// Gemeinsame Hilfsfunktionen für alle Formulare

// Eingaben bereinigen: nur Leerzeichen entfernen.

function putzen($eingabe){
    return trim((string)$eingabe);
}

// Kurzform für sichere HTML-Ausgabe
function e($wert){
    return htmlspecialchars((string)$wert, ENT_QUOTES, 'UTF-8');
}

// CSRF-Schutz: Token pro Session erzeugen
function csrf_token(){
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verstecktes Formularfeld mit dem Token
function csrf_feld(){
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

// Prüft, ob das mitgeschickte Token stimmt
function csrf_pruefen(){
    $token = $_POST['csrf_token'] ?? '';
    return is_string($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Namen/Orte: Buchstaben inkl. Umlaute, Leerzeichen, Bindestrich, Apostroph
function ist_gueltiger_name($wert){
    return (bool)preg_match("/^[\p{L}\p{M}' -]+$/u", $wert);
}
?>