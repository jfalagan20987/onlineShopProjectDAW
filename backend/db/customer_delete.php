<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>
<?php
    //Get data
    $customer_id = $_POST['customer_id'];

    //Search by ID
    $sql = "SELECT customer_id, forename, surname
            FROM `012_customers`
            WHERE customer_id = $customer_id;";
    
    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $result = mysqli_query($conn, $sql);
    $customer = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if(isset($_POST['submit'])){
        //Get data
        $customer_id = $_POST['customer_id'];
      
        //Delete the data in the database
        $sql = "DELETE FROM `012_customers`
                WHERE customer_id = $customer_id;";
      
        // Connect and send confirmation
        include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
        mysqli_query($conn, $sql);
        
        // Redirect to products.php
        ?>
        <script>
          window.location.href="/student012/shop/backend/views/customers.php";
        </script>
<?php };?>

<main class="flex items-center justify-center mt-0 bg-anti-flash-white">
    <form class="flex flex-col items-start justify-center m-10 gap-2 border-2 border-solid border-poppy rounded-2xl p-10 max-w-96" method="POST">
        <p class="font-bold text-2xl">Are you sure you want to delete this customer?</p>
        <p class="font-bold">
            Customer ID:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="number" name="customer_id" id="customer_id" value=<?php echo($customer[0]['customer_id'])?> readonly>
        </p>
        <p class="font-bold">
            Forename:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="forename" id="forename" value="<?php echo($customer[0]['forename'])?>" readonly>
        </p>
        <p class="font-bold">
            Surname:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="surname" id="surname" value="<?php echo($customer[0]['surname'])?>" readonly>
        </p>

        <input class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110 self-center" type="submit" name="submit" value="Delete customer">
    </form>
</main>
<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>