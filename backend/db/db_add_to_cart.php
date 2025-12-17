<?php
    session_start();

    $customer_id = $_SESSION['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $selected_color = $_POST['color'];
    $size = $_POST['size'];

    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

    $sql = "SELECT * FROM `012_shopping_cart` WHERE customer_id = $customer_id AND product_id = $product_id;";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0):
        $sql = "INSERT INTO `012_shopping_cart`(customer_id, product_id, quantity, selected_color, size)
            VALUES ($customer_id, $product_id, $quantity, '$selected_color', $size);";
        
        $result = mysqli_query($conn, $sql);

        ?><script>
            window.location.href="/student012/shop/backend/views/products.php";
        </script><?php
    else:
        $sql = "UPDATE `012_shopping_cart`
                SET quantity = quantity + $quantity
                WHERE customer_id = $customer_id AND product_id = $product_id;";

        $result = mysqli_query($conn, $sql);

        ?><script>
            window.location.href="/student012/shop/backend/views/products.php";
        </script><?php
    endif;
?>