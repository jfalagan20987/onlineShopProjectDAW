<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>

<main>
    <form action="/student012/shop/backend/db/db_register.php" method="POST">
        <p>
            Username:
            <input type="text" name="username" id="username">
        </p>

        <p>
            Password:
            <input type="password" name="pwd" id="pwd">
        </p>

       <p>
            Select a role:
            <p>
                <input type="radio" name="role" id="customer">Customer
                <input type="radio" name="role" id="admin">Admin
            </p>
        </p>

        <input type="submit" value="Register">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>