<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>
<main>
    <form action="/student012/shop/backend/db/db_customer_insert.php" method="POST">
        <h2>Add customer</h2>
        <p>
            Forename:
            <input type="text" name="forename" id="forename">
        </p>
        <p>
            Surname:
            <input type="text" name="surname" id="surname">
        </p>
        <p>
            NIF:
            <input type="text" name="nif" id="nif">
        </p>
        <p>
            Email:
            <input type="email" name="email" id="email">
        </p>
        <p>
            Phone:
            <input type="text" name="phone" id="phone">
        </p>
        <p>
            Birthdate:
            <input type="date" name="birthdate" id="birthdate">
        </p>

        <input type="submit" value="Add customer">
    </form>
</main>
<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>