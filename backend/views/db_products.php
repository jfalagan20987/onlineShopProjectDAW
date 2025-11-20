<?php
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $str = $_GET['param'];

    // See if the input is empty or not
    if($str === ""){
        $sql = "SELECT * FROM `012_products`"; // If it's empty, show all products
    }else{
        $sql = "SELECT * FROM `012_products` WHERE product_name LIKE '%$str%'";
    }

    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $productsJson = json_encode($products);
    echo $productsJson;
?>