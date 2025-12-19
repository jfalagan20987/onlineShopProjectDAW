<?php 
  header("Content-Type: application/json");
  require($_SERVER['DOCUMENT_ROOT']."/student012/shop/backend/config/db_connect.php");
  require($_SERVER['DOCUMENT_ROOT']."/student012/shop/backend/functions/get_customer_id.php");

  $product_id = intval($_GET['product_id']);
  $customer_id = getCustomerId($conn);

  $stmt = $conn->prepare("
  DELETE FROM 012_shopping_cart
  WHERE customer_id=? AND product_id=?
  ");
  
  $stmt->bind_param("ii", $customer_id, $product_id);
  $stmt->execute();

  echo json_encode(["success" => true]);
?>