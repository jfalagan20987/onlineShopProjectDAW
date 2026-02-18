<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');?>

<?php
  //Get data
  $customer_id = $_SESSION['customer_id'];

  //Search results by ID
  $sql = "SELECT * FROM `012_customers`
          WHERE customer_id = $customer_id;";

  include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  $result = mysqli_query($conn, $sql);
  $customer = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<main class="flex items-center justify-center p-20 bg-anti-flash-white">
  <div class="border border-solid border-poppy rounded-xl p-8 min-w-80 flex flex-col items-start justify-center gap-8">
      <div class="flex gap-1 items-center">
        <p class="font-bold">Username:</p>
        <p><?php echo $customer[0]['username']?></p>
      </div>
      <div class="flex gap-1 items-center">
        <p class="font-bold">Email:</p>
        <p><?php echo $customer[0]['email']?></p>
      </div>
      <div class="flex gap-1 items-center">
        <p class="font-bold">Full name:</p>
        <p><?php echo $customer[0]['forename']?> <?php echo $customer[0]['surname']?></p>
      </div>
      <div class="flex gap-1 items-center">
        <p class="font-bold">NIF:</p>
        <p><?php echo $customer[0]['nif']?></p>
      </div>
      <div class="flex gap-1 items-center">
        <p class="font-bold">Phone:</p>
        <p><?php echo $customer[0]['phone']?></p>
      </div>
      <div class="flex gap-1 items-center">
        <p class="font-bold">Birthdate:</p>
        <p><?php echo $customer[0]['birthdate']?></p>
      </div>

      <form class="w-full" action="/student012/shop/backend/db/update_my_profile.php" method="POST"> <!--Change redirection || Implement another form-->
          <input type="hidden" name="customer_id" value="<?php echo $customer[0]['customer_id']?>">
          <input type="submit" value="Modify Profile" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
      </form>
      
      <form class="w-full" action="/student012/shop/backend/db/update_password.php" method="POST"> <!--Change redirection || Implement another form-->
          <input type="hidden" name="customer_id" value="<?php echo $customer[0]['customer_id']?>">
          <input type="submit" value="Change Password" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
      </form>

      <form class="w-full" action="/student012/shop/backend/db/delete_account.php" method="POST"> <!--Change redirection || Implement another form-->
          <input type="hidden" name="customer_id" value="<?php echo $customer[0]['customer_id']?>">
          <input type="submit" value="Delete Account" class="rounded border-4 border-poppy bg-anti-flash-white p-1 w-full text-poppy font-bold cursor-pointer hover:scale-110">
      </form>
  </div>    
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>