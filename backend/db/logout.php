<?php
    session_start();
    session_destroy();

    setcookie('lang', '', time() - 3600, "/");

    header("Location: /student012/shop/backend/index.php");
    exit;
?>