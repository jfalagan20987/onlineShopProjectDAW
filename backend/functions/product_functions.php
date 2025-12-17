<?php
function showProduct($product, $customer_type) {
    ?>
    <div class="border border-solid border-poppy rounded-xl p-4 w-2xs flex flex-col items-center justify-center gap-2 hover:bg-red-200">
        <img src="<?php echo $product['image_path'] ?>" class="rounded-xl w-full">
        <h3 class="font-bold text-2xl self-start"><?php echo $product['product_name']?></h3>
        <p class="self-end font-bold text-lg"><?php echo $product['unit_price']?>€</p>

        <?php if ($customer_type === 'admin'): ?>
            <form class="w-full" action="/student012/shop/backend/db/product_update.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']?>">
                <input type="submit" value="UPDATE" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
            </form>

            <form class="w-full" action="/student012/shop/backend/db/product_delete.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']?>">
                <input type="submit" value="DELETE" class="rounded bg-anti-flash-white border-2 border-solid border-poppy p-1.5 w-full text-poppy font-bold cursor-pointer hover:scale-110">
            </form>

            <form class="w-full" action="/student012/shop/backend/db/db_add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']?>">

                <div class="flex items-center justify-between mb-2 w-full">
                  <label class="font-bold">Color:
                      <select name="color" class="font-normal bg-white border border-solid border-onyx rounded">
                          <?php foreach (explode(',', $product['color']) as $color): ?>
                              <option value="<?php echo $color; ?>"><?php echo strtoupper($color); ?></option>
                          <?php endforeach; ?>
                      </select>
                  </label>
  
                  <label class="font-bold">Quantity:
                      <input type="number" name="quantity" min="1" value="1" class="font-normal bg-white border border-solid border-onyx rounded pl-1 w-10">
                  </label>
  
                  <label class="font-bold">Size:
                      <select name="size" class="font-normal bg-white border border-solid border-onyx rounded h-7 w-12">
                          <option value="40">40</option>
                          <option value="41">41</option>
                          <option value="42">42</option>
                          <option value="43">43</option>
                          <option value="44">44</option>
                          <option value="45">45</option>
                          <option value="46">46</option>
                          <option value="47">47</option>
                      </select>
                  </label>
                </div>

                <input type="submit" value="ADD TO CART" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
            </form>
        <?php else: // customer ?>
            <form class="w-full" action="/student012/shop/backend/db/db_add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']?>">

                <div class="flex items-center justify-between mb-2 w-full">
                  <label class="font-bold">Color:
                      <select name="color" class="font-normal bg-white border border-solid border-onyx rounded">
                          <?php foreach (explode(',', $product['color']) as $color): ?>
                              <option value="<?php echo $color; ?>"><?php echo strtoupper($color); ?></option>
                          <?php endforeach; ?>
                      </select>
                  </label>
  
                  <label class="font-bold">Quantity:
                      <input type="number" name="quantity" min="1" value="1" class="font-normal bg-white border border-solid border-onyx rounded pl-1 w-10">
                  </label>
  
                  <label class="font-bold">Size:
                      <select name="size" class="font-normal bg-white border border-solid border-onyx rounded h-7 w-12">
                          <option value="40">40</option>
                          <option value="41">41</option>
                          <option value="42">42</option>
                          <option value="43">43</option>
                          <option value="44">44</option>
                          <option value="45">45</option>
                          <option value="46">46</option>
                          <option value="47">47</option>
                      </select>
                  </label>
                </div>

                <input type="submit" value="ADD TO CART" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
            </form>
        <?php endif; ?>
    </div>
<?php
}
?>