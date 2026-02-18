<?php
    session_start();

    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    $sql = "SELECT *
          FROM `012_customers`
          WHERE username = '$user' AND `password` = '$pwd';";

    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $result = mysqli_query($conn, $sql);
    $customer = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $_SESSION['customer_id'] = $customer[0]['customer_id'];
    $_SESSION['user'] = $customer[0]['username'];
    $_SESSION['customer_type'] = $customer[0]['customer_type'];
    /* print_r($_SESSION['user']);
    print_r($customer[0]['customer_type']); */

    if($customer[0]['customer_type'] === 'admin'){
        header("Location: /student012/shop/backend/index.php");
    }elseif($customer[0]['customer_type'] === 'customer'){
        header("Location: /student012/shop/backend/index.php");
    };
?>