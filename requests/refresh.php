<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        /*la fonction session_start donne la possiblité d'appeler la variable PHP $_SESSION*/
    }
    $_SESSION['refresh'] = true;
?>