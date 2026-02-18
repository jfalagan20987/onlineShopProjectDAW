<?php
    //Get data
    $customer_id = $_POST['customer_id'];
    $forename = $_POST['forename'];
    $surname = $_POST['surname'];
    $nif = $_POST['nif'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];

    //Update data in the database
    $sql = "UPDATE `012_customers` SET
            forename = '$forename', surname = '$surname', nif = '$nif', email = '$email', phone = '$phone', birthdate = '$birthdate'
            WHERE customer_id = $customer_id;";

    //Connect and send the data
    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    mysqli_query($conn, $sql);
?>