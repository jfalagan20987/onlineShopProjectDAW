<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>

<main>
    <form action="/student012/shop/backend/forms/form_customer_delete.php" method="POST">
        <p>
            Customer ID:
            <input type="number" name="customer_id" id="customer_id">
        </p>
        <input type="submit" value="Search">
    </form>
</main>
<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>