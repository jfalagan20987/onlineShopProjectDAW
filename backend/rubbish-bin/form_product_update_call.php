<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>
<main>
    <form action="/student012/shop/backend/forms/form_product_update.php" method="POST">
        <p>
            <label for="product_id">
                Product ID:
                <input type="number" name="product_id" id="product_id">
            </label>
        </p>

        <input type="submit" value="Search">
    </form>
</main>
<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>