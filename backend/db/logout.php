<?php
    session_start();
    session_destroy();

    header("Location: /student012/shop/backend/index.php");
?>