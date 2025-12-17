<?php

  // JUST TESTING - NOT IMPLEMENTED
  function updateQuantity(){
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

    $sql = "UPDATE `012_shopping_cart`
                SET quantity = $quantity
                WHERE customer_id = $customer_id AND product_id = $product_id;";

    $result = mysqli_query($conn, $sql);
  }

?>