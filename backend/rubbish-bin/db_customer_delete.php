<?php
  //Get data
  $customer_id = $_POST['customer_id'];

  //Delete the data in the database
  $sql = "DELETE FROM `012_customers`
          WHERE customer_id = $customer_id;";

  // Connect and send confirmation
  include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  mysqli_query($conn, $sql);
?>