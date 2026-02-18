<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>

<main>
    <!--Insert product form-->
    <form action="/student012/shop/backend/db/db_product_insert.php" method="POST">
        <h2>Add product</h2>
        <p>
            <label for="product_name">
                <p>Product Name:</p>
                <input type="text" name="product_name" id="product_name">
            </label>
        </p>

        <p>
            <label for="category_id">
                <p>Brand:</p>
                <select name="category_id" id="category_id">
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
                <p>Description:</p>
                <textarea name="description" id="description" rows=2 cols=30 placeholder="Describe the product..."></textarea>
            </label>
        </p>

        <p>
            <p>Colors:</p>
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
        </p>

        <p>
            <label for="unit_price">
                <p>Unit price:
                    <input type="decimal" name="unit_price" id="unit_price">
                </p>
            </label>
        </p>

        <input type="submit" value="Insert product">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>