<?php

  function showCustomer($customer){ ?>
    <div class="border border-solid border-poppy rounded-xl p-4 min-w-80 flex flex-col items-center justify-center gap-2 hover:bg-red-200">
        <div class="flex gap-1 items-center">
          <p class="font-bold">Username:</p>
          <p><?php echo $customer['username']?></p>
        </div>
        <div class="flex gap-1 items-center">
          <p class="font-bold">Email:</p>
          <p><?php echo $customer['email']?></p>
        </div>
        <div class="flex gap-1 items-center">
          <p class="font-bold">Customer Type:</p>
          <p><?php echo $customer['customer_type']?></p>
        </div>
        <div class="flex gap-1 items-center">
          <p class="font-bold">Full name:</p>
          <p><?php echo $customer['forename']?> <?php echo $customer['surname']?></p>
        </div>
        <div class="flex gap-1 items-center">
          <p class="font-bold">NIF:</p>
          <p><?php echo $customer['nif']?></p>
        </div>
        <div class="flex gap-1 items-center">
          <p class="font-bold">Phone:</p>
          <p><?php echo $customer['phone']?></p>
        </div>
        <div class="flex gap-1 items-center">
          <p class="font-bold">Birthdate:</p>
          <p><?php echo $customer['birthdate']?></p>
        </div>

        <form class="w-full" action="/student012/shop/backend/db/customer_update.php" method="POST">
            <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']?>">
            <input type="submit" value="UPDATE" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
        </form>

        <form class="w-full" action="/student012/shop/backend/db/customer_delete.php" method="POST">
            <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']?>">
            <input type="submit" value="DELETE" class="rounded bg-anti-flash-white border-2 border-solid border-poppy p-1.5 w-full text-poppy font-bold cursor-pointer hover:scale-110">
        </form>
    </div>
  <?php }; ?>