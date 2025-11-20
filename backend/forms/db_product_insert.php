<?php
    //Get data
    print_r($_GET);

    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $unit_price = $_POST['unit_price'];

    //Put data in the database
    $sql = "INSERT INTO `012_products`(category_id, product_name, `description`, unit_price)
            VALUES ($category_id, '$product_name', '$description', $unit_price);";

    // Connect and send confirmation
    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    mysqli_query($conn, $sql);
?>