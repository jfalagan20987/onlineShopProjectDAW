<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: Content-Type");
  header("Access-Control-Allow-Methods: GET");
  header("Content-Type: application/json");

  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

  $sql = "SELECT image_path FROM `012_products`
          WHERE supplier_id IS NULL; ";

  $result = mysqli_query($conn, $sql);
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

  $productsJson = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

  echo $productsJson;
?>