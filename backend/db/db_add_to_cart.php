<?php
    session_start();

    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

    $sql = "SELECT * FROM `012_shopping_cart` WHERE customer_id = $customer_id AND product_id = $product_id;";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0):
        $sql = "INSERT INTO `012_shopping_cart`(customer_id, product_id, quantity)
            VALUES ($customer_id, $product_id, $quantity);";
        
        $result = mysqli_query($conn, $sql);
    else:
        $sql = "UPDATE `012_shopping_cart`
                SET quantity = quantity + $quantity
                WHERE customer_id = $customer_id AND product_id = $product_id;";

        $result = mysqli_query($conn, $sql);
    endif;
?>