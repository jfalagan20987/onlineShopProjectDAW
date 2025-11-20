<?php include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>
<?php
  //Get data
  $product_id = $_POST['product_id'];

  //Search by ID
  $sql = "SELECT *
          FROM `012_products`
          WHERE product_id = $product_id;";

  include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  $result = mysqli_query($conn, $sql);
  $product = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $product_name = $product[0]['product_name'];
  $description = $product[0]['description'];
  $unit_price = $product[0]['unit_price'];
?>
<main>
  <h3>Product info:</h3>
  <p>Product name: <?php echo($product_name)?></p>
  <p>Description: <?php echo($description)?></p>
  <p>Unit price: <?php echo($unit_price)?>€</p>
</main>
<?php include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>