<?php 

  function showOrder($order_number){ ?>
    <div class="flex flex-col gap-2 border border-solid border-poppy rounded-xl p-4 w-[400px] justify-center self-center">
      <h3 class="font-bold text-2xl">ORDER NUMBER: <?php echo $order_number[0]['order_number'];?></h3>
    </div>
 <?php } 

?>