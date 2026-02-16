<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');?>
<?php
    //Get data
    $customer_id = $_POST['customer_id'];

    //Search by ID
    $sql = "SELECT *
            FROM `012_customers`
            WHERE customer_id = $customer_id;";

    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $result = mysqli_query($conn, $sql);
    $customer = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if(isset($_POST['submit'])){

      // Get data
      $forename = $_POST['forename'];
      $surname = $_POST['surname'];
      $nif = $_POST['nif'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $birthdate = $_POST['birthdate'];
      $type = $_POST['customer_type'];
      $user = $_POST['user'];
      $password = $_POST['password'];

      // Update data in the database
      $sql = "UPDATE `012_customers` SET
            forename = '$forename', surname = '$surname', nif = '$nif', email = '$email', phone = '$phone', birthdate = '$birthdate', customer_type = '$type', username = '$username', `password` = '$password'
            WHERE customer_id = $customer_id;";

      // Connect and send confirmation
        include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
        mysqli_query($conn, $sql);
    ?>
        <script>
            window.location.href="/student012/shop/backend/views/customers.php";
        </script>
<?php };?>
<main class="flex items-center justify-center mt-0 bg-anti-flash-white">
    <form class="flex flex-col items-start justify-center m-10 gap-2 border-2 border-solid border-poppy rounded-2xl p-10 max-w-96" method="POST">
        <p>
            <label for="customer_id">
                <p class="font-bold">Customer ID:</p>
                <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="number" name="customer_id" id="customer_id" value=<?php echo($customer[0]['customer_id'])?> readonly>
            </label>
        </p>
        <p>
            <label for="forename">
                <p class="font-bold">Forename:</p>
                <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="forename" id="forename" value="<?php echo($customer[0]['forename'])?>">
            </label>
        </p>
        <p>
            <label for="surname">
                <p class="font-bold">Surname:</p>
                <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="surname" id="surname" value="<?php echo($customer[0]['surname'])?>">
            </label>
        </p>
        <p>
            <label for="nif">
                <p class="font-bold">NIF:</p>
                <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="nif" id="nif" value="<?php echo($customer[0]['nif'])?>">
            </label>
        </p>
        <p>
            <label for="email">
                <p class="font-bold">Email:</p>
                <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="email" name="email" id="email" value=<?php echo($customer[0]['email'])?>>
            </label>
        </p>
        <p>
            <label for="phone">
                <p class="font-bold">Phone:</p>
                <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="phone" id="phone" value="<?php echo($customer[0]['phone'])?>">
            </label>
        </p>
        <p>
            <label for="birthdate">
                <p class="font-bold">Birthdate:</p>
                <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="date" name="birthdate" id="birthdate" value="<?php echo($customer[0]['birthdate'])?>">
            </label>
        </p>
        <p>
            <label for="customer_type">
                <p class="font-bold">Customer Type:</p>
                <select class="bg-white border border-solid border-onyx rounded pl-1" name="customer_type" id="customer_type">
                    <option value="customer" <?php echo $selected = ($customer[0]['customer_type'] == 'customer')? 'selected' : ''; ?>>Customer</option>
                    <option value="admin" <?php echo $selected = ($customer[0]['customer_type'] == 'admin')? 'selected' : ''; ?>>Administrator</option>
                </select>
            </label>
        </p>
        <p>
            <label for="user">
                <p class="font-bold">Username:</p>
                <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="text" name="user" id="user" value="<?php echo($customer[0]['username'])?>">
            </label>
        </p>
        <p>
            <label for="password">
                <p class="font-bold">Password:</p>
                <input class="font-normal bg-white border border-solid border-onyx rounded pl-1" type="password" name="password" id="password" value="<?php echo($customer[0]['password'])?>" readonly>
            </label>
        </p>

        <input class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110 self-center" type="submit" name="submit" value="Update customer">
    </form>
</main>
<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>