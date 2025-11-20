<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>

<main>
    <form action="/student012/shop/backend/forms/form_customer_update.php" method="POST">
        <p>
            <label for="product_id">
                Customer ID:
                <input type="number" name="customer_id" id="customer_id">
            </label>
        </p>

        <input type="submit" value="Search">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>