<?php
    //Get data
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $unit_price = $_POST['unit_price'];

    //Treat colors array
    $colors = implode(',',$_POST['colors']);

    //Put data in the database
    $sql = "INSERT INTO `012_products`(category_id, product_name, `description`, color, unit_price)
            VALUES ($category_id, '$product_name', '$description', '$colors', $unit_price);";

    // Connect and send confirmation
    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    mysqli_query($conn, $sql);
?>