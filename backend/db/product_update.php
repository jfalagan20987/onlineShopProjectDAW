<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>
<?php 
    //Get data
    $product_id = $_POST['product_id'];

    //Search by ID
    $sql = "SELECT product_name, category_id, `description`, unit_price, color, `size`
            FROM `012_products`
            WHERE product_id = $product_id;";

    
    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $product_name = $product[0]['product_name'];
    $category_id = $product[0]['category_id'];
    $description = $product[0]['description'];
    $unit_price = $product[0]['unit_price'];

    // Get selected colors and sizes
    $selectedColors = explode(',', $product[0]['color']);
    $selectedSizes = explode(',', $product[0]['size']);
   
?>
<?php
    if(isset($_POST['submit'])){
    //Get data
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $unit_price = $_POST['unit_price'];

    $colors = isset($_POST['colors']) ? implode(',', $_POST['colors']) : '';
    $sizes = isset($_POST['sizes']) ? implode(',', $_POST['sizes']) : '';

    //Update data in the database
    $sql = "UPDATE `012_products` SET
            product_name = '$product_name', category_id = $category_id, `description` = '$description', unit_price = $unit_price, color = '$colors', `size` = '$sizes'
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
    <form class="flex flex-col items-start justify-center m-10 gap-2 border-2 border-solid border-poppy rounded-2xl p-10" method="POST">
        <p>
            <label for="product_name">
                <p class="font-bold">Product ID:</p>
                <input class="bg-white border border-solid border-onyx rounded pl-1" type="number" name="product_id" id="product_id" value=<?php echo($product_id)?> readonly>
            </label>
        </p>
    
        <p>
            <label for="product_name">
                <p class="font-bold">Product Name:</p>
                <input class="bg-white border border-solid border-onyx rounded pl-1" type="text" name="product_name" id="product_name" value="<?php echo($product_name)?>">
            </label>
        </p>

        <p>
            <label for="category_id">
                <p class="font-bold">Brand:</p>
                <select class="bg-white border border-solid border-onyx rounded pl-1" name="category_id" id="category_id">
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
                <p class="font-bold">Description:</p>
                <textarea class="bg-white border border-solid border-onyx rounded pl-1" name="description" id="description" rows=4 cols=30><?php echo($description)?></textarea>
            </label>
        </p>

        <p class="font-bold">Size:</p>
        <p class="grid grid-cols-4 gap-4 place-items-center">
        <?php
        $sizes = ['40','41','42','43','44','45','46','47'];

        foreach($sizes as $size):
        ?>

            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox"
                    name="sizes[]"
                    value="<?= $size ?>"
                    <?= in_array($size, $selectedSizes) ? 'checked' : '' ?>>
                <span><?= $size ?></span>
            </label>

        <?php endforeach; ?>

        </p>

        <p class="font-bold">Colors:</p>
        <?php
            //COLORS
            $colors = [
                'black','white','gold','silver','red','blue',
                'yellow','orange','green','pink','purple'
            ];
        ?>

        <p class="grid grid-cols-2 md:grid-cols-3 gap-4">

        <?php foreach($colors as $color): ?>

            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="colors[]" value="<?= $color ?>"
                    class="color-radio <?= $color ?>"
                    <?= in_array($color, $selectedColors) ? 'checked' : '' ?>>
                <span><?= ucfirst($color) ?></span>
            </label>

        <?php endforeach; ?>

        </p>
        
        

        <p>
            <label for="unit_price">
                <p class="font-bold">Unit price:</p>
                <input class="bg-white border border-solid border-onyx rounded pl-1" type="decimal" name="unit_price" id="unit_price" value=<?php echo($unit_price)?>>
            </label>
        </p>

        <input class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110 self-center" type="submit" name="submit" value="Update product">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>