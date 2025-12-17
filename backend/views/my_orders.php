<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');

  // Get ID
  $customer_id = $_SESSION['customer_id'];

  // Get data
  $sql = "SELECT o.*, p.image_path, p.product_name, c.forename, c.surname, c.nif, c.phone, a.direction, a.location, a.country, a.zip_code
          FROM `012_orders` AS o
          INNER JOIN `012_products` AS p ON o.product_id = p.product_id
          INNER JOIN `012_customers` AS c ON o.customer_id = c.customer_id
          INNER JOIN `012_addresses` AS a ON o.address_id = a.address_id
          WHERE o.customer_id = $customer_id;";

  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  $result = mysqli_query($conn, $sql);
  $my_orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // Group the products by order_number to retrieve all their details
  $orders_numbers = [];
  foreach($my_orders as $order):
    $orders_numbers[$order['order_number']][] = $order;
  endforeach;

  // Click on REVIEW
  /* if(isset($_POST['submit'])):?>
    <script>
      window.location.href="/student012/shop/backend/db/review_product.php";
    </script>
  <?php endif; */
?>

<main class="mt-0 bg-anti-flash-white min-h-3/4 p-5">
  <h2 class="font-bold text-center text-3xl mb-4">MY ORDERS</h2>
  <section class="flex gap-4 w-full m-2 flex-wrap justify-center">
    <?php foreach($orders_numbers as $order_number => $products):?>
      <div class="flex flex-col gap-2 border border-solid border-poppy rounded-xl p-6 max-h-[600px] w-[420px] overflow-y-auto">
        <div>
          <h3 class="font-bold text-2xl">ORDER NUMBER: <?php echo $order_number;?></h3>
          <div>
            <p><?php echo $my_orders[0]['forename']?> <?php echo $my_orders[0]['surname']?></p>
            <p><?php echo $my_orders[0]['nif']?></p>
            <p><?php echo $my_orders[0]['phone']?></p>
            <p><?php echo $my_orders[0]['direction']?>, <?php echo $my_orders[0]['zip_code']?> (<?php echo $my_orders[0]['location']?>, <?php echo $my_orders[0]['country']?>)</p>
          </div>
        </div>
        <?php foreach($products as $product):

          // Define text color for status
          $statusClass = "";
          if ($product['status'] === "pending") {
              $statusClass = "text-poppy";
          } elseif ($product['status'] === "delivered") {
              $statusClass = "text-green-500";
          }  
        ?>
          <div class="flex gap-4 w-full items-center justify-between border-t border-solid border-onyx">
            <img class="h-28 rounded-xl mt-3" src="<?php echo $product['image_path'];?>" alt="product">
            <div>
              <h4 class="font-bold text-xl"><?php echo $product['product_name'];?></h4>
              <p>Quantity: <?php echo $product['quantity'];?></p>
              <p>Status: <span class="<?php echo $statusClass;?>"><?php echo $product['status'];?></span></p>
            </div>
            <form method="POST" action="/student012/shop/backend/db/review_product.php">
              <?php if ($product['status'] === "pending"){?>
                <input type="submit" value="REVIEW" name="submit" class="rounded bg-french-gray border-0 p-1.5 w-full text-onyx font-bold cursor-not-allowed self-center mb-2" disabled>
              <?php } elseif($product['status'] === "delivered" & $product['reviewed'] == 0){?>
                <input type="number" name="order_number" id="order_number" hidden value="<?php echo $order_number;?>">
                <input type="number" name="product_id" id="product_id" hidden value="<?php echo $product['product_id'];?>">
                <input type="submit" value="REVIEW" name="submit" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110 self-center mb-2">
              <?php } elseif($product['status'] === "delivered" & $product['reviewed'] == 1){?>
                <input type="submit" value="REVIEWED" name="submit" class="rounded bg-salmon-pink border-0 p-1.5 w-full text-onyx font-bold self-center mb-2" disabled>
              <?php } ?>
              </form>
          </div>
        <?php endforeach;?>
      </div>
    <?php endforeach;?>
  </section>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>