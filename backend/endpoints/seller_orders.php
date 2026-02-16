<?php 

  header('Content-Type: application/json');

  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

  $apikey = $_GET['apikey'] ?? null;
  $ordersJson = $_GET['orders_json'] ?? null;

  if (!$apikey) {
      http_response_code(401);
      echo json_encode(["error" => "API key missing"]);
      exit;
  }

  $stmt = $conn->prepare("SELECT seller_id FROM `012_sellers` WHERE seller_api_key = ?");
  $stmt->bind_param("s", $apikey);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
      http_response_code(403);
      echo json_encode(["error" => "Invalid API key"]);
      exit;
  }

  //$test = urldecode($ordersJson);
  $input = json_decode(urldecode($ordersJson), true);

  if (!is_array($input)) {
      http_response_code(400);
      echo json_encode(["error" => "Invalid JSON"]);
      exit;
  }

  $priceStmt = $conn->prepare("
        SELECT unit_price 
        FROM `012_products` 
        WHERE product_id = ?
  ");

  $stmt = $conn->prepare("
  INSERT INTO `012_orders`
  (order_number, customer_forename, customer_surname, nif, email, phone, product_id, quantity, unit_price, placed_on, direction, location, country, zip_code, status, reviewed)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, 'pending', 0)
  ");

  $inserted = 0;
  $errors = [];

  foreach ($input as $order) {

      $required = [
          "customer_forename", "customer_surname", "customer_nif",
          "customer_email", "customer_phone", "product_code", "product_quantity",
          "customer_address", "customer_location", "customer_country", "customer_zip"
      ];

      foreach ($required as $field) {
          if (empty($order[$field])) {
              $errors[] = "Missing field: $field";
              continue 2;
          }
      }

      $product_id = (int)$order['product_code'];

      $priceStmt->bind_param("i", $product_id);
      $priceStmt->execute();
      $priceResult = $priceStmt->get_result();

      if ($priceResult->num_rows === 0) {
          $errors[] = "Product not found: ".$product_id;
          continue;
      }

      $priceRow = $priceResult->fetch_assoc();
      $unit_price = $priceRow['unit_price'];

      $order_number = str_pad(rand(1000, 999999), 6, '0', STR_PAD_LEFT);

      $stmt->bind_param(
          "isssssiidssss",
          $order_number,
          $order['customer_forename'],
          $order['customer_surname'],
          $order['customer_nif'],
          $order['customer_email'],
          $order['customer_phone'],
          $product_id,
          $order['product_quantity'],
          $unit_price,
          $order['customer_address'],
          $order['customer_location'],
          $order['customer_country'],
          $order['customer_zip']
      );

      if ($stmt->execute()) {
          $inserted++;
      } else {
          $errors[] = $stmt->error;
      }
  }

  $priceStmt->close();
  $stmt->close();

  echo json_encode([
      "success" => $inserted > 0,
      "inserted" => $inserted,
      "errors" => $errors
  ]);

?>
