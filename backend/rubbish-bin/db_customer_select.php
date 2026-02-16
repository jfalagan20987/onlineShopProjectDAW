<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>
<?php
  //Get data
  $customer_id = $_POST['customer_id'];

  //Search by ID
  $sql = "SELECT *
          FROM `012_customers`
          WHERE customer_id = $customer_id;";

  include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  $result = mysqli_query($conn, $sql);
  $customer = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $forename = $customer[0]['forename'];
  $surname = $customer[0]['surname'];
  $nif = $customer[0]['nif'];
  $email = $customer[0]['email'];
  $phone = $customer[0]['phone'];
  $birthdate = $customer[0]['birthdate'];
?>
<main>
  <h3>Customer info</h3>
  <p>Forename: <?php echo($forename)?></p>
  <p>Surname: <?php echo($surname)?></p>
  <p>NIF: <?php echo($nif)?></p>
  <p>Email: <?php echo($email)?></p>
  <p>Phone: <?php echo($phone)?></p>
  <p>Birthdate: <?php echo($birthdate)?></p>
</main>
<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>