<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>

<?php
    if(isset($_POST['submit'])){

        //Get data
        $forename = $_POST['forename'];
        $surname = $_POST['surname'];
        $nif = $_POST['nif'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $birthdate = $_POST['birthdate'];
        $type = $_POST['customer_type'];
        $user = $_POST['user'];
        $password = $_POST['password'];

        //Insert new customer in the database
        $sql = "INSERT INTO `012_customers`(forename, surname, nif, email, phone, birthdate, customer_type, username, `password`)
                VALUES('$forename', '$surname', '$nif', '$email', '$phone', '$birthdate', '$type' '$user', '$password');";
    
        // Connect and send confirmation
        include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
        mysqli_query($conn, $sql);
    ?>
        <script>
            window.location.href="/student012/shop/backend/index.php";
        </script>
<?php };?>

<main class="flex items-center justify-center mt-0 bg-anti-flash-white">
    <form class="flex flex-col items-start justify-center m-10 gap-8 border-2 border-solid border-poppy rounded-2xl p-10 max-w-96" method="POST">
        <p class="font-bold">
            Forename:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="forename" id="forename">
        </p>
        <p class="font-bold">
            Surname:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="surname" id="surname">
        </p>
        <p class="font-bold">
            NIF:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="nif" id="nif">
        </p>
        <p class="font-bold">
            Email:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="email" name="email" id="email">
        </p>
        <p class="font-bold">
            Phone:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="phone" id="phone">
        </p>
        <p class="font-bold">
            Birthdate:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="date" name="birthdate" id="birthdate">
        </p>
        <p class="font-bold">
            Customer Type:
            <select class="bg-white border border-solid border-onyx rounded pl-1" name="customer_type" id="customer_type">
                    <option value="customer">Customer</option>
                    <option value="admin">Administrator</option>
            </select>
        </p>
        <p class="font-bold">
            Username:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="user" id="user">
        </p>
        <p class="font-bold">
            Password:
            <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="password" name="password" id="password">
        </p>

        <input class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110 self-center" type="submit" name="submit" value="Register">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>