<?php 
    //Get data
    $forename = $_POST['forename'];
    $surname = $_POST['surname'];
    $nif = $_POST['nif'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];

    //Insert new customer in the database
    $sql = "INSERT INTO `012_customers`(forename, surname, nif, email, phone, birthdate)
            VALUES('$forename', '$surname', '$nif', '$email', '$phone', '$birthdate');";
    
    //Connect and do the insert
    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    mysqli_query($conn, $sql);
?>