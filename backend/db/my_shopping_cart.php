<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');
require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/functions/shopping_cart_functions.php');
?>

<?php
//Get data
$customer_id = $_SESSION['customer_id'];

//Get the subtotal
$sql = "SELECT SUM(s.quantity * p.unit_price) AS subtotal
    FROM 012_shopping_cart AS s
    INNER JOIN 012_products AS p ON s.product_id = p.product_id
    WHERE customer_id = $customer_id;";
include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
$result = mysqli_query($conn, $sql);
$subtotal = mysqli_fetch_all($result, MYSQLI_ASSOC);
$my_subtotal = $subtotal[0]['subtotal'];

//Get all the products in my shopping cart
$sql = "SELECT p.*, s.customer_id, s.quantity, s.selected_color, s.size 
        FROM `012_shopping_cart` AS s
        INNER JOIN `012_products` AS p ON s.product_id = p.product_id
        WHERE customer_id = $customer_id;";
include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
$result = mysqli_query($conn, $sql);
$my_shopping_cart = mysqli_fetch_all($result, MYSQLI_ASSOC);

// SUBMIT
if(isset($_POST['submit'])){
?>
<script>
  window.location.href = "/student012/shop/backend/db/checkout.php";
</script>
<?php };?>

<main class="flex items-center justify-center mt-0 bg-anti-flash-white min-h-3/4">
  <?php if ($my_shopping_cart == null):?>
    <div class="flex flex-col gap-2">
      <p>You shopping cart is empty!</p>
      <p>See our products:</p>
      <form action="/student012/shop/backend/views/products.php">
        <input type="submit" value="PRODUCTS" class="h-10 w-50 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
      </form>
    </div>
  <?php else :?>
  <form class="flex flex-col gap-4 w-96 m-8" method="POST">
    <div class="w-full flex flex-col gap-1 justify-start border-b border-solid border-onyx mb-2">
      <p class="text-xl">Subtotal: 
        <span id="subtotal" class="font-bold"><?php echo $my_subtotal;?> €</span>
      </p>
      <input class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110 self-center mb-2" 
             type="submit" name="submit" value="BUY NOW">
    </div>

    <?php foreach($my_shopping_cart as $product): ?>
      <div class="product-card flex flex-col p-4 border border-solid border-poppy rounded-xl">

        <div class="flex items-center justify-between gap-4 mb-5">
          <img src="<?php echo $product['image_path'];?>" alt="product" class="w-44 rounded-xl">

          <div class="flex flex-col gap-2 min-h-44 items-end justify-between w-full">
            <h3 class="text-2xl font-bold self-start"><?php echo $product['product_name']?></h3>

            <div class="flex items-end self-end justify-between w-full">
              <p class="font-semibold text-2xl"><?php echo $product['unit_price']?> €</p>

              <div class="flex flex-col gap-2 items-center">
                <img class="cursor-pointer hover:scale-110" src="/student012/shop/assets/icons/wishlist.svg" alt="wishlist">
                <img class="cursor-pointer hover:scale-110" src="/student012/shop/assets/icons/bin.svg" alt="bin">
              </div>
            </div>
          </div>
        </div>

        <div class="flex gap-4 justify-between items-end">

          <!-- COLOR -->
          <label class="font-bold">Color:
            <select 
              name="color" 
              data-product="<?php echo $product['product_id'];?>" 
              class="color-select font-normal bg-white border border-solid border-onyx rounded">
              
              <?php foreach(explode(',', $product['color']) as $color):?>
                <option value="<?php echo $color;?>" 
                  <?php if($color==$product['selected_color']) echo 'selected'; ?>>
                  <?php echo strtoupper($color);?>
                </option>
              <?php endforeach;?>
            </select>
          </label>

          <!-- QUANTITY -->
          <label class="font-bold">Quantity:
            <input 
              type="number" 
              name="quantity" 
              data-product="<?php echo $product['product_id'];?>" 
              min="1" 
              value="<?php echo $product['quantity']?>" 
              class="quantity-input font-normal bg-white border border-solid border-onyx rounded pl-1 w-10">
          </label>

          <!-- SIZE -->
          <label class="font-bold">Size:
            <select 
              name="size" 
              data-product="<?php echo $product['product_id'];?>" 
              class="size-select font-normal bg-white border border-solid border-onyx rounded h-7 w-12">

              <?php foreach(range(40,47) as $size): ?>
                <option value="<?php echo $size;?>" 
                  <?php if($product['size'] == "$size") echo "selected"; ?>>
                  <?php echo $size;?>
                </option>
              <?php endforeach;?>

            </select>
          </label>

        </div>
      </div>
    <?php endforeach;?>

  </form>
  <?php endif;?>
</main>

<script>
  function updateCart(product_id, quantity, color, size) {
    fetch('/student012/shop/backend/db/update_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body:
            'product_id=' + product_id +
            '&quantity=' + quantity +
            '&color=' + color +
            '&size=' + size
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector('#subtotal').innerText = data.subtotal + ' €';
        }
    });
  }

  document.querySelectorAll('.quantity-input').forEach(input => {
      input.addEventListener('change', function() {
          const card = this.closest('.product-card');
          updateCart(
            this.dataset.product,
            this.value,
            card.querySelector('.color-select').value,
            card.querySelector('.size-select').value
          );
      });
  });

  document.querySelectorAll('.color-select').forEach(select => {
      select.addEventListener('change', function() {
          const card = this.closest('.product-card');
          updateCart(
            this.dataset.product,
            card.querySelector('.quantity-input').value,
            this.value,
            card.querySelector('.size-select').value
          );
      });
  });

  document.querySelectorAll('.size-select').forEach(select => {
      select.addEventListener('change', function() {
          const card = this.closest('.product-card');
          updateCart(
            this.dataset.product,
            card.querySelector('.quantity-input').value,
            card.querySelector('.color-select').value,
            this.value
          );
      });
  });
</script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>
