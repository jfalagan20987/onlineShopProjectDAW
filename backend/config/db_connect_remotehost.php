<?php
    $servername = "remotehost.es";
    $username = "dwess1234";
    $password = "test1234.";
    $database = "dwesdatabase";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    //Check connection
    if (!$conn){
        echo "Connection failed";
    }
?>