<?php 

  function showOrder($order_number){ ?>
    <div class="flex flex-col gap-2 border border-solid border-poppy rounded-xl p-4 w-[400px] justify-center self-center">
      <h3 class="font-bold text-2xl">ORDER NUMBER: <?php echo $order_number[0]['order_number'];?></h3>
      <div>
        <p><?php echo $order_number[0]['forename']?> <?php echo $order_number[0]['surname']?></p>
        <p><?php echo $order_number[0]['nif']?></p>
        <p><?php echo $order_number[0]['phone']?></p>
        <p><?php echo $order_number[0]['direction']?>, <?php echo $order_number[0]['zip_code']?></p>
        <p>(<?php echo $order_number[0]['location']?>, <?php echo $order_number[0]['country']?>)</p>
      </div>
      <!-- <form class="w-full" action="/student012/shop/backend/db/modify_order.php" method="POST">
        <input type="hidden" name="order_number" value="<?php echo $order_number[0]['order_number'];?>">
        <input type="submit" value="MODIFY" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-105">
      </form> -->
    </div>
 <?php } 

?>