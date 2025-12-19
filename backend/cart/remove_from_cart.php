<?php
header("Content-Type: application/json");

require($_SERVER['DOCUMENT_ROOT']."/student012/shop/backend/config/db_connect.php");
require($_SERVER['DOCUMENT_ROOT']."/student012/shop/backend/functions/get_customer_id.php");

$data = json_decode(file_get_contents("php://input"), true);

$product_id     = intval($data['product_id'] ?? 0);
$selected_color = $data['selected_color'] ?? '';
$size           = intval($data['size'] ?? 0);

$customer_id = getCustomerId($conn);

$stmt = $conn->prepare("
  DELETE FROM 012_shopping_cart
  WHERE customer_id = ?
    AND product_id = ?
    AND selected_color = ?
    AND size = ?
");

$stmt->bind_param(
  "iisi",
  $customer_id,
  $product_id,
  $selected_color,
  $size
);

$stmt->execute();

echo json_encode([
  "success" => true,
  "affected_rows" => $stmt->affected_rows
]);
?>
