<?php 

  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

  $str = $_GET['param'] ?? "";

  if ($str === "") {

      $sql = "SELECT o.*, p.image_path, p.product_name, 
          COALESCE(c.forename, o.customer_forename) AS customer_forename,
          COALESCE(c.surname, o.customer_surname) AS customer_surname,
          COALESCE(c.nif, o.nif) AS nif,
          COALESCE(c.email, o.email) AS email,
          COALESCE(c.phone, o.phone) AS phone,
          COALESCE(a.direction, o.direction) AS direction,
          COALESCE(a.location, o.location) AS location,
          COALESCE(a.country, o.country) AS country,
          COALESCE(a.zip_code, o.zip_code) AS zip_code
        
          FROM `012_orders` AS o
          INNER JOIN `012_products` AS p ON o.product_id = p.product_id
          LEFT JOIN `012_customers` AS c ON o.customer_id = c.customer_id
          LEFT JOIN `012_addresses` AS a ON o.address_id = a.address_id
          
          ORDER BY o.placed_on DESC";

  } else {

      $sql = "SELECT o.*, p.image_path, p.product_name, 
          COALESCE(c.forename, o.customer_forename) AS customer_forename,
          COALESCE(c.surname, o.customer_surname) AS customer_surname,
          COALESCE(c.nif, o.nif) AS nif,
          COALESCE(c.email, o.email) AS email,
          COALESCE(c.phone, o.phone) AS phone,
          COALESCE(a.direction, o.direction) AS direction,
          COALESCE(a.location, o.location) AS location,
          COALESCE(a.country, o.country) AS country,
          COALESCE(a.zip_code, o.zip_code) AS zip_code

          FROM `012_orders` AS o
          INNER JOIN `012_products` AS p ON o.product_id = p.product_id
          LEFT JOIN `012_customers` AS c ON o.customer_id = c.customer_id
          LEFT JOIN `012_addresses` AS a ON o.address_id = a.address_id
          
          WHERE o.order_number LIKE '%$str%'
          
          ORDER BY o.placed_on DESC";
  }

  $result = mysqli_query($conn, $sql);

  $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

  echo json_encode($orders);

?>
