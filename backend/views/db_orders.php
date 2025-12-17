<?php 
  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  $str = $_GET['param'];

  if ($str === ""){
    $sql = "SELECT o.*, p.image_path, p.product_name, c.forename, c.surname, c.nif, c.phone, a.direction, a.location, a.country, a.zip_code
        FROM `012_orders` AS o
        INNER JOIN `012_products` AS p ON o.product_id = p.product_id
        INNER JOIN `012_customers` AS c ON o.customer_id = c.customer_id
        INNER JOIN `012_addresses` AS a ON o.address_id = a.address_id
        GROUP BY order_number;";
  }else{
    $sql = "SELECT o.*, p.image_path, p.product_name, c.forename, c.surname, c.nif, c.phone, a.direction, a.location, a.country, a.zip_code
        FROM `012_orders` AS o
        INNER JOIN `012_products` AS p ON o.product_id = p.product_id
        INNER JOIN `012_customers` AS c ON o.customer_id = c.customer_id
        INNER JOIN `012_addresses` AS a ON o.address_id = a.address_id
        WHERE order_number LIKE '%$str%'
        GROUP BY order_number;";
  }

  $result = mysqli_query($conn, $sql);
  $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

  $ordersJson = json_encode($orders);
  echo $ordersJson;
?>