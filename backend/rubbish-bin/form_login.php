<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>

<main>
    <form action="/student012/shop/backend/db/db_login.php" method="POST">
        <p>
            Username:
            <input type="text" name="user" id="user">
        </p>

        <p>
            Password:
            <input type="password" name="pwd" id="pwd">
        </p>

        <input type="submit" value="Login">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>