<?php
  header("Content-Type: application/json");

  require($_SERVER['DOCUMENT_ROOT']."/student012/shop/backend/config/db_connect.php");
  require($_SERVER['DOCUMENT_ROOT']."/student012/shop/backend/functions/get_customer_id.php");

  $customer_id = getCustomerId($conn);

  $stmt = $conn->prepare("
  SELECT
    c.product_id,
    c.quantity,
    c.selected_color,
    c.size,
    p.product_name,
    p.unit_price,
    p.image_path,
    p.color
  FROM `012_shopping_cart` AS c
  JOIN `012_products` AS p ON p.product_id = c.product_id
  WHERE c.customer_id = ?
  ");
  
  $stmt->bind_param("i", $customer_id);
  $stmt->execute();

  $res = $stmt->get_result();
  $items = [];

  while ($row = $res->fetch_assoc()) {
    $items[] = $row;
  }

  echo json_encode($items);

?>