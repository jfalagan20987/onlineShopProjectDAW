<?php

// Get random address_id from a specific customer
function getAddressId($customer_id){
  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

  $sql = "SELECT address_id
          FROM `012_customer_addresses`
          WHERE customer_id = $customer_id
          ORDER BY RAND()
          LIMIT 1;";

  $result = mysqli_query($conn, $sql);
  $address = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $address_id = $address[0]['address_id'];

  return ($address_id);
}

?>