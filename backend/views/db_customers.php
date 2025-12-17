<?php
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $str = $_GET['param'];

    // See if the input is empty or not
    if($str === ""){
        $sql = "SELECT * FROM `012_customers`"; // If it's empty, show all products
    }else{
        $sql = "SELECT * FROM `012_customers` WHERE username LIKE '%$str%' OR forename LIKE '%$str%' OR surname LIKE '%$str%' OR email LIKE '%$str%'";
    }

    $result = mysqli_query($conn, $sql);
    $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $customersJson = json_encode($customers);
    echo $customersJson;
?>