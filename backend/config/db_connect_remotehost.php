<?php
    $servername = "remotehost.es";
    $username = "dwess1234";
    $password = "Usertest1234.";
    $database = "dwesdatabase";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    mysqli_set_charset($conn, "utf8");
    
    //Check connection
    if (!$conn){
        echo "Connection failed";
    }
?>