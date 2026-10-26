<?php
require_once 'session.php';

$name = $_POST['name'] ?? "";
$password = $_POST['password'] ?? "";

$extra = 'login.php';

if(!csrf_pruefen()){
    $extra = 'login.php?f=4';

}elseif(!empty($password)){

   require_once 'db.php';

    // kunden_id holen, damit das Profil und die Gutscheine zugeordnet werden können
    $sql = "SELECT passwort, kunden_id FROM logindaten WHERE username = ?";

    //Prepared Statement --> Passwort und kunden_id wird herausgezogen von DB
    $stmt = mysqli_prepare($conn, $sql);

    if($stmt){
        $kunden_id = '';
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hash, $kunden_id); // Werte in Variablen speichern

        if(mysqli_stmt_fetch($stmt)){
            if(password_verify($password, $hash)){
                session_regenerate_id(true);
                $extra = 'willkommen.php';

                $_SESSION['kunden_id'] = $kunden_id;
                $_SESSION['login'] = 'ok';
                $_SESSION['username'] = $name;
            }else{
                $extra = 'login.php?f=1';
            }

       }else{
        $extra = 'login.php?f=2';
       }
           mysqli_stmt_close($stmt);

    }
 mysqli_close($conn);
}else{
    $extra = 'login.php?f=3';
}

header("Location: ../pages/$extra");
exit;

?>