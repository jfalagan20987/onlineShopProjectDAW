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
<main>
    <form action="/student012/shop/backend/db/db_product_delete.php" method="POST">
        <p>Are you sure you want to delete this product?</p>
        <p>Product ID:</p>
        <input type="number" name="product_id" id="product_id" value=<?php echo($product_id)?> readonly>
        <p>Product name:</p>
        <input type="text" name="product_name" id="product_name" disabled value="<?php echo($product_name)?>" readonly>
        <input type="submit" value="Delete">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>