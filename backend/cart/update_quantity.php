<?php
  header("Content-Type: application/json; charset=UTF-8");
  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/functions/get_customer_id.php');

  $input = json_decode(file_get_contents('php://input'), true);

  if (!isset($input['product_id'], $input['selected_color'], $input['size'], $input['quantity'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos']);
    exit;
  }

  $customer_id = getCustomerId($conn);

  $stmt = $conn->prepare("
    UPDATE `012_shopping_cart`
    SET quantity = ?
    WHERE customer_id = ?
      AND product_id = ?
      AND selected_color = ?
      AND size = ?
  ");

  $stmt->bind_param(
    "iiiss",
    $input['quantity'],
    $customer_id,
    $input['product_id'],
    $input['selected_color'],
    $input['size']
  );

  $stmt->execute();

  echo json_encode(['success' => true]);
?>