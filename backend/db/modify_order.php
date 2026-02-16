<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');

  $order_number = $_POST['order_number'];

  $sql = "SELECT o.*, p.image_path, p.product_name, c.forename, c.surname, c.nif, c.phone, a.direction, a.location, a.country, a.zip_code
        FROM `012_orders` AS o
        INNER JOIN `012_products` AS p ON o.product_id = p.product_id
        INNER JOIN `012_customers` AS c ON o.customer_id = c.customer_id
        INNER JOIN `012_addresses` AS a ON o.address_id = a.address_id;
        WHERE order_number = $order_number;";

  include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  $result = mysqli_query($conn, $sql);
  $order = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<main class="flex items-center justify-center mt-0 bg-anti-flash-white">
  <form class="flex flex-col items-start justify-center m-10 gap-2 border-2 border-solid border-poppy rounded-2xl p-10 max-w-96" method="POST">
  </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>