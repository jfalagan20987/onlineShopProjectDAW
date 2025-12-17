<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "online_shop";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    mysqli_set_charset($conn, "utf8");
    /* if($conn) {
        echo 'Bien';
    }else {
        echo "mal";
    } */
?>