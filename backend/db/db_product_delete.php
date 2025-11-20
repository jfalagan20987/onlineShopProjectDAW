<?php
  //Get data
  $product_id = $_POST['product_id'];

  //Delete the data in the database
  $sql = "DELETE FROM `012_products`
          WHERE product_id = $product_id;";

  // Connect and send confirmation
  include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  mysqli_query($conn, $sql);
?>