<?php
  session_start();
  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

  header('Content-Type: application/json');

  // Check session
  if (!isset($_SESSION['customer_id'])) {
      echo json_encode(["success" => false, "error" => "Not logged in"]);
      exit;
  }

  $customer_id = $_SESSION['customer_id'];

  // Validate POST data
  if (!isset($_POST['product_id'], $_POST['quantity'], $_POST['color'], $_POST['size'])) {
      echo json_encode(["success" => false, "error" => "Missing parameters"]);
      exit;
  }

  $product_id = intval($_POST['product_id']);
  $quantity = max(1, intval($_POST['quantity']));
  $color = trim($_POST['color']);
  $size = trim($_POST['size']);

  $sql = "UPDATE 012_shopping_cart 
          SET quantity = ?, selected_color = ?, size = ?
          WHERE product_id = ? AND customer_id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("issii", $quantity, $color, $size, $product_id, $customer_id);
  $stmt->execute();

  $sql = "SELECT SUM(s.quantity * p.unit_price) AS subtotal
          FROM 012_shopping_cart AS s
          INNER JOIN 012_products AS p ON s.product_id = p.product_id
          WHERE s.customer_id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $customer_id);
  $stmt->execute();
  $result = $stmt->get_result();

  $data = $result->fetch_assoc();
  $subtotal = $data["subtotal"] ?? 0;

  echo json_encode([
      "success"  => true,
      "subtotal" => number_format($subtotal, 2, '.', '')
  ]);

?>