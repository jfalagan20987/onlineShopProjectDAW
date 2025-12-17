<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');

  // Get customer, product and order_number (PRIMARY KEY)
  $customer_id = $_SESSION['customer_id'];
  $product_id = $_POST['product_id'];
  $order_number = $_POST['order_number'];

  // Get product details
  $sql = "SELECT * FROM `012_products`
          WHERE product_id = $product_id;";

  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  $result = mysqli_query($conn, $sql);
  $product = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // Submit the review
  if(isset($_POST['submit_review'])):

    $review_content = mysqli_real_escape_string($conn, $_POST['review_content']);
    $score = $_POST['score'];

    $sql = "INSERT INTO `012_reviews` (order_number, customer_id, product_id, review_content, score)
            VALUES ($order_number, $customer_id, $product_id, '$review_content', $score)";
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    mysqli_query($conn, $sql);

    // Change the boolean column 'reviewed' in orders table
    $sql = "UPDATE `012_orders` SET reviewed = 1
            WHERE order_number = $order_number AND customer_id = $customer_id AND product_id = $product_id;";
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    mysqli_query($conn, $sql);

    // Redirect to My Orders
    ?>
    <script>
      window.location.href = "/student012/shop/backend/views/my_orders.php";
    </script>

  <?php endif;
?>

<main class="mt-0 bg-anti-flash-white min-h-3/4 p-5 flex flex-col items-center justify-center">
  <section class="flex flex-col items-center gap-4 max-w-2xl justify-center">
    <div class="flex items-center justify-between gap-8 border-b border-solid border-onyx w-full">
      <img class="h-56 rounded-xl mb-4" src="<?php echo $product[0]['image_path'];?>" alt="product">
      <div class="flex flex-col items-start h-56 justify-between mb-4">
        <div>
          <h3 class="text-2xl font-bold"><?php echo $product[0]['product_name'];?></h3>
          <p><?php echo $product[0]['description'];?></p>
        </div>
        <h3 class="self-end text-2xl font-bold"><?php echo $product[0]['unit_price'];?>€</h3>
      </div>
    </div>

    <form method="POST" class="w-full flex flex-col gap-4">
      <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
      <input type="hidden" name="order_number" value="<?php echo $order_number; ?>">
      <div class="flex items-center justify-between w-full">
        <h3 class="font-bold text-2xl">Review the product</h3>
        <select name="score" id="score" class="border-2 border-solid border-poppy rounded-xl font-bold bg-white cursor-pointer p-2 focus:border-salmon-pink outline-0">
          <option value="1">1 - VERY BAD</option>
          <option value="2">2 - BAD</option>
          <option value="3">3 - OK</option>
          <option value="4">4 - GOOD</option>
          <option value="5">5 - VERY GOOD</option>
        </select>
      </div>
      <textarea name="review_content" id="review_content" placeholder="Leave a comment..." class="w-full h-44 bg-white border border-solid border-poppy rounded p-2 outline-0 focus:border-salmon-pink"></textarea>
      <input type="submit" name="submit_review" value="SEND REVIEW" class="bg-poppy p-1.5 text-anti-flash-white font-bold w-full rounded cursor-pointer hover:scale-105">
    </form>
  </section>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>