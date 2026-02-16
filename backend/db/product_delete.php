<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>
<?php 
    //Get data
    $product_id = $_POST['product_id'];

    //Search by ID
    $sql = "SELECT product_id, product_name
            FROM `012_products`
            WHERE product_id = $product_id;";

    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $product_id = $product[0]['product_id'];
    $product_name = $product[0]['product_name'];

?>
<?php
    if(isset($_POST['submit'])){
        //Get data
        $product_id = $_POST['product_id'];
      
        //Delete the data in the database
        $sql = "DELETE FROM `012_products`
                WHERE product_id = $product_id;";
      
        // Connect and send confirmation
        include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
        mysqli_query($conn, $sql);
        
        // Redirect to products.php
        ?>
        <script>
          window.location.href="/student012/shop/backend/views/products.php";
        </script>
   <?php };?>

<main class="flex items-center justify-center mt-0 bg-anti-flash-white">
    <form class="flex flex-col items-center justify-center m-48 gap-10 border-2 border-solid border-poppy rounded-2xl p-10" method="POST">
        <p class="font-bold">Are you sure you want to delete this product?</p>
        <p class="font-bold">Product ID:</p>
        <input class="bg-white border border-solid border-onyx rounded pl-1" type="number" name="product_id" id="product_id" value=<?php echo($product_id)?> readonly>
        <p class="font-bold">Product name:</p>
        <input class="bg-white border border-solid border-onyx rounded pl-1" type="text" name="product_name" id="product_name" disabled value="<?php echo($product_name)?>" readonly>
        <input class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110 self-center" type="submit" name="submit" value="Delete">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>