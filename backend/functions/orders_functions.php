<?php 

function showOrder($order_number){

  $order = $order_number[0];
  ?>

  <div class="flex flex-col gap-2 border border-solid border-poppy rounded-xl p-4 w-[400px] justify-center self-center">

    <h3 class="font-bold text-2xl">ORDER NUMBER: <?php echo $order['order_number']; ?></h3>

    <div>
      <p><?php echo $order['customer_forename']; ?> <?php echo $order['customer_surname']; ?>
      </p>

      <p><?php echo $order['nif']; ?></p>
      <p><?php echo $order['phone']; ?></p>

      <p><?php echo $order['direction']; ?>, <?php echo $order['zip_code']; ?></p>

      <p>(<?php echo $order['location']; ?>, <?php echo $order['country']; ?>)</p>
    </div>

     <div class="border-t border-solid border-onyx pt-2">

      <p class="font-bold mb-1">Products:</p>

      <ul class="flex flex-col gap-1 text-sm">

        <?php foreach($order_number as $product): ?>

          <li class="flex justify-between">
            <span><?php echo $product['product_name']; ?> (x<?php echo $product['quantity']; ?>)</span>

            <span><?php $price = $product['unit_price'] * $product['quantity']; echo number_format($price, 2); ?> € </span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- <form class="w-full" action="/student012/shop/backend/db/modify_order.php" method="POST">
      <input type="hidden" name="order_number" value="<?php echo $order['order_number']; ?>">
      <input type="submit" value="MODIFY" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-105">
    </form> -->
  </div>

<?php 
}
?>