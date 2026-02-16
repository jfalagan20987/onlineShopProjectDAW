<?php

  header('Content-Type: application/json');

  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

  $apikey = $_GET['apikey'] ?? null;

  if (!$apikey) {
      http_response_code(401);
      echo json_encode(["error" => "API key missing"]);
      exit;
  }

  $stmt = $conn->prepare("SELECT seller_id FROM 012_sellers WHERE seller_api_key = ?");
  $stmt->bind_param("s", $apikey);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
      http_response_code(403);
      echo json_encode(["error" => "Invalid API key"]);
      exit;
  }

  $seller = $result->fetch_assoc();
  $seller_id = $seller['seller_id'];

  $sql = "SELECT p.product_id, p.product_name, p.image_path AS product_image, p.unit_price AS product_price, p.description AS product_desc, p.color AS product_color, p.size AS product_size, p.stock AS product_stock
          FROM `012_products` AS p
          JOIN `012_seller_products` AS sp ON p.product_id = sp.product_id
          WHERE sp.seller_id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $seller_id);
  $stmt->execute();

  $result = $stmt->get_result();
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

  echo json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>