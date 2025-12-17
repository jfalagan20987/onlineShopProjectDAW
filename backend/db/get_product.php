<?php
  ini_set('display_errors', 0);
  ini_set('display_startup_errors', 0);
  error_reporting(0);
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");

  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

  if (!isset($_GET["id"])) {
      echo json_encode(["error" => "Missing ID"]);
      exit;
  }

  $id = intval($_GET["id"]);

  $stmt = $conn->prepare("
      SELECT product_id, product_name, `description`, unit_price, color, image_path 
      FROM `012_products` 
      WHERE product_id = ?
  ");
  if (!$stmt) {
      echo json_encode(["error" => "Database error: prepare failed"]);
      exit;
  }

  $stmt->bind_param("i", $id);

  if (!$stmt->execute()) {
      echo json_encode(["error" => "Database error: execute failed"]);
      exit;
  }

  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
      echo json_encode(["error" => "Product not found"]);
      exit;
  }

  $product = $result->fetch_assoc();

  echo json_encode($product);
  exit;
?>