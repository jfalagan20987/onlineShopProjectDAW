<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); 
      require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/functions/checkout_functions.php');

  //Get the subtotal
  $sql = "SELECT SUM(s.quantity * p.unit_price) AS subtotal
    FROM 012_shopping_cart AS s
    INNER JOIN 012_products AS p ON s.product_id = p.product_id
    WHERE customer_id = $customer_id;";
  include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  $result = mysqli_query($conn, $sql);
  $subtotal = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $my_subtotal = $subtotal[0]['subtotal'];
  $total = $my_subtotal + 10;

  // Get data
  $sql = "SELECT p.*, s.customer_id, s.quantity, s.selected_color, s.size FROM `012_shopping_cart` AS s
          INNER JOIN `012_products` AS p ON s.product_id = p.product_id
          WHERE customer_id = $customer_id;";
  include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  $result = mysqli_query($conn, $sql);
  $my_shopping_cart = mysqli_fetch_all($result, MYSQLI_ASSOC);


  // Go back to shopping cart
  if(isset($_POST['go-back'])){
    ?>
      <script>
        window.location.href="/student012/shop/backend/db/my_shopping_cart.php";
      </script>
    <?php
  }

  // Insert into orders table
  if(isset($_POST['submit'])){

    //random order number and address_id
    $order_number = rand(1000, 999999);
    $address_id = getAddressId($customer_id);

    $sql= "INSERT INTO `012_orders` (order_number, customer_id, product_id, quantity, unit_price, address_id)
            SELECT $order_number, $customer_id, product_id, quantity, unit_price, $address_id
            FROM `012_shopping_cart_view`
            WHERE customer_id = $customer_id;";

    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $result = mysqli_query($conn, $sql);

    $order_number_to_send = $order_number;
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/endpoints/insert_supplier_orders.php');
    
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/mail/send_order_email.php');
    $customer_email = "jfalagan20987@iesjoanramis.org";
    sendOrderEmail($order_number, $customer_email);

    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $sql = "DELETE FROM `012_shopping_cart` WHERE customer_id = $customer_id;";
    $result = mysqli_query($conn, $sql);

    ?>
      <script>
        window.location.href="/student012/shop/backend/views/my_orders.php";
      </script>
    <?php
  }

?>

<main class="flex flex-col items-center justify-center mt-0 bg-anti-flash-white">
  <h2 class="text-center text-2xl font-bold mt-4">ORDER DETAILS</h2>
  <form class="border border-solid border-poppy rounded-xl m-4 p-4" method="POST">
    <?php foreach($my_shopping_cart as $product):?>
      <input type="number" name="product_id" hidden value="<?php echo $product['product_id'];?>">
      <div class="flex gap-2 justify-around border-b border-solid border-onyx mb-4 w-80">
        <img src="<?php echo $product['image_path'];?>" alt="product" class="mb-4 w-40 rounded-xl">
        <div class="flex flex-col gap-2 items-start h-full mb-4">
          <h3 class="text-2xl font-bold"><?php echo $product['product_name'];?></h3>
          <div class="flex gap-1 items-center justify-between w-full">
            <p>x<span><?php echo $product['quantity'];?></span></p>
            <p><span><?php echo $product['selected_color'];?></span></p>
            <p>s<span><?php echo $product['size']?></span></p>
          </div>
          <?php $product['unit_price'] = $product['unit_price'] * $product['quantity']?>
          <h4 class="text-xl font-bold self-end mt-14"><?php echo number_format($product['unit_price'], 2)?> €</h4>
        </div>
      </div>
    <?php endforeach;?>

    <div class="w-full flex flex-col gap-1 items-center border-b border-solid border-onyx">
      <div class="flex items-center justify-between w-full">
        <p>Subtotal:</p>
        <p><?php echo $my_subtotal;?> €</p>
      </div>
      <div class="flex items-center justify-between w-full">
        <p>Shipping costs:</p>
        <p>10.00 €</p>
      </div>
      <div class="mb-2 flex items-center justify-between w-full font-bold text-2xl">
        <h4>TOTAL:</h4>
        <h4><?php echo number_format($total, 2);?> €</h4>
      </div>
    </div>

    <div class="flex flex-col gap-2 mt-2">
      <input type="submit" name="submit" value="CONFIRM" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-105 self-center">
      <input type="submit" name="go-back" value="Go back" class="rounded bg-anti-flash-white border-2 border-solid border-poppy p-1.5 w-full text-poppy font-bold cursor-pointer hover:scale-105 self-center">
    </div>
  </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>