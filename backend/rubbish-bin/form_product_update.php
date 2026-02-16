<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>
<?php 
    
    //Get data
    $product_id = $_POST['product_id'];

    //Search by ID
    $sql = "SELECT product_name, category_id, `description`, unit_price
            FROM `012_products`
            WHERE product_id = $product_id;";

    
    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $product_name = $product[0]['product_name'];
    $category_id = $product[0]['category_id'];
    $description = $product[0]['description'];
    $unit_price = $product[0]['unit_price'];

?>

<main>
    <form action="/student012/shop/backend/db/db_product_update.php" method="POST">
        <p>
            <label for="product_name">
                <p>Product ID:</p>
                <input type="number" name="product_id" id="product_id" value=<?php echo($product_id)?> readonly>
            </label>
        </p>
    
        <p>
            <label for="product_name">
                <p>Product Name:</p>
                <input type="text" name="product_name" id="product_name" value="<?php echo($product_name)?>">
            </label>
        </p>

        <p>
            <label for="category_id">
                <p>Brand:</p>
                <select name="category_id" id="category_id">
                    <option value="1" <?php echo $selected = ($category_id == '1')? 'selected' : ''; ?>>Adidas</option>
                    <option value="2" <?php echo $selected = ($category_id == '2')? 'selected' : ''; ?>>Converse</option>
                    <option value="3" <?php echo $selected = ($category_id == '3')? 'selected' : ''; ?>>Jordan</option>
                    <option value="4" <?php echo $selected = ($category_id == '4')? 'selected' : ''; ?>>New Balance</option>
                    <option value="5" <?php echo $selected = ($category_id == '5')? 'selected' : ''; ?>>Nike</option>
                    <option value="6" <?php echo $selected = ($category_id == '6')? 'selected' : ''; ?>>Puma</option>
                    <option value="7" <?php echo $selected = ($category_id == '7')? 'selected' : ''; ?>>Reebok</option>
                    <option value="8" <?php echo $selected = ($category_id == '8')? 'selected' : ''; ?>>Under Armour</option>
                </select>
            </label>
        </p>

        <p>
            <label for="description">
                <p>Description:</p>
                <textarea name="description" id="description" rows=2 cols=30><?php echo($description)?></textarea>
            </label>
        </p>

        <!-- <p>
            <label for="colors">
                <p>Colors:</p>
                <input type="checkbox" name="colors[]" value="black">Black
                <input type="checkbox" name="colors[]" value="white">White
                <input type="checkbox" name="colors[]" value="red">Red
                <input type="checkbox" name="colors[]" value="blue">Blue
            </label>
        </p> -->

        <p>
            <label for="unit_price">
                <p>Unit price:
                    <input type="decimal" name="unit_price" id="unit_price" value=<?php echo($unit_price)?>>
                </p>
            </label>
        </p>

        <input type="submit" value="Update product">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>