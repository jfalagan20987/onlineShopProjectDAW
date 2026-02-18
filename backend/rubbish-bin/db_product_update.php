<?php
    //Get data
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $unit_price = $_POST['unit_price'];

    //Update data in the database
    $sql = "UPDATE `012_products` SET
            product_name = '$product_name', category_id = $category_id, `description` = '$description', unit_price = $unit_price
            WHERE product_id = $product_id;";

    // Connect and send confirmation
    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    mysqli_query($conn, $sql);
?>