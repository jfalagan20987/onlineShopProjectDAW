<?php

    $sql = "SELECT *
          FROM `012_products`;";

    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach($products as $product){
        echo "<div>"."<p>".$product['product_name']."</p>"."<p>".$product['unit_price']."€"."</p>"."</div>";
    }
?>