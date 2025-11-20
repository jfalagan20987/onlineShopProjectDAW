<?php

  function showProduct($product){ ?>
    <div class="border border-solid border-poppy rounded-xl p-4 w-3xs flex flex-col items-center justify-center gap-2 hover:bg-red-200">
        <img src="<?php echo $product['image_path'] ?>" class="rounded-xl w-full">
        <h3 class="font-bold text-2xl self-start"><?php echo $product['product_name']?></h3>
        <p class="self-end font-bold text-lg"><?php echo $product['unit_price']?>€</p>
        <form class="w-full" action="/student012/shop/backend/db/product_update.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']?>">
            <input type="submit" value="UPDATE" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
        </form>

        <form class="w-full" action="/student012/shop/backend/db/product_delete.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']?>">
            <input type="submit" value="DELETE" class="rounded bg-anti-flash-white border-2 border-solid border-poppy p-1.5 w-full text-poppy font-bold cursor-pointer hover:scale-110">
        </form>
    </div>
  <?php }; ?>