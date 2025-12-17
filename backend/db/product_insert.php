<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');
    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

    if(isset($_POST['submit'])){
        //Get data
        $product_name = $_POST['product_name'];
        $category_id = $_POST['category_id'];
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $unit_price = $_POST['unit_price'];
    
        //Treat colors array
        $colors = implode(',',$_POST['colors']);

        //File upload
        $image_path = "";
        if(isset($_FILES['image_path']) && $_FILES['image_path']['error'] === 0){
            $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/uploads/';

            if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $image_name = basename($_FILES['image_path']['name']);
            $target_file = $upload_dir.$image_name;

            move_uploaded_file($_FILES['image_path']['tmp_name'], $target_file);

            $image_path = '/student012/shop/backend/uploads/'.$image_name;
        }
    
        //Put data in the database
        $sql = "INSERT INTO `012_products`(category_id, image_path, product_name, `description`, color, unit_price)
                VALUES ($category_id, '$image_path', '$product_name', '$description', '$colors', $unit_price);";
    
        // Connect and send confirmation
        mysqli_query($conn, $sql);
    ?>
        <script>
            window.location.href="/student012/shop/backend/views/products.php";
        </script>
   <?php };?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('image_path');
    const fileLabel = fileInput.nextElementSibling; // El <span> que está justo después

    fileInput.addEventListener('change', () => {
        if(fileInput.files.length > 0){
            fileLabel.textContent = fileInput.files[0].name;
        } else {
            fileLabel.textContent = "Upload image";
        }
    });
});
</script>

<main class="flex items-center justify-center mt-0 bg-anti-flash-white">
    <!--Insert product form-->
    <form class="flex flex-col items-start justify-center m-10 gap-2 border-2 border-solid border-poppy rounded-2xl p-10 max-w-96" method="POST" enctype="multipart/form-data">
        <p>
            <label for="product_name">
                <p class="font-bold">Product Name:</p>
                <input class="bg-white border border-solid border-onyx rounded pl-1" type="text" name="product_name" id="product_name">
            </label>
        </p>

        <div class="custom-file relative inline-block w-60">
            <input type="file" name="image_path" id="image_path" accept="image/*"
                class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer z-10">
            <span class="font-bold custom-file-label block px-3 py-2 border border-onyx rounded bg-white text-center z-0">Upload image</span>
        </div>

        <p>
            <label for="category_id">
                <p class="font-bold">Brand:</p>
                <select class="bg-white border border-solid border-onyx rounded pl-1" name="category_id" id="category_id">
                    <option value="1">Adidas</option>
                    <option value="2">Converse</option>
                    <option value="3">Jordan</option>
                    <option value="4">New Balance</option>
                    <option value="5">Nike</option>
                    <option value="6">Puma</option>
                    <option value="7">Reebok</option>
                    <option value="8">Under Armour</option>
                </select>
            </label>
        </p>

        <p>
            <label for="description">
                <p class="font-bold">Description:</p>
                <textarea class="bg-white border border-solid border-onyx rounded pl-1" name="description" id="description" rows=4 cols=35 placeholder="Describe the product..."></textarea>
            </label>
        </p>


        <p class="font-bold">Colors:
            <p class="flex flex-row flex-wrap gap-2 justify-center w-70">
                <input type="checkbox" name="colors[]" value="black">Black
                <input type="checkbox" name="colors[]" value="white">White
                <input type="checkbox" name="colors[]" value="gold">Gold
                <input type="checkbox" name="colors[]" value="silver">Silver
                <input type="checkbox" name="colors[]" value="red">Red
                <input type="checkbox" name="colors[]" value="blue">Blue
                <input type="checkbox" name="colors[]" value="yellow">Yellow
                <input type="checkbox" name="colors[]" value="orange">Orange
                <input type="checkbox" name="colors[]" value="green">Green
                <input type="checkbox" name="colors[]" value="pink">Pink
                <input type="checkbox" name="colors[]" value="purple">Purple
            </p>
        </p>

        <p>
            <label for="unit_price">
                <p class="font-bold">Unit price:
                    <input class="bg-white border border-solid border-onyx rounded pl-1" type="decimal" name="unit_price" id="unit_price">
                </p>
            </label>
        </p>

        <input class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110 self-center" type="submit" name="submit" value="Insert product">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>