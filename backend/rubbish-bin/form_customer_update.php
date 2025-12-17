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

?>
<main>
    <form action="/student012/shop/backend/db/db_customer_update.php" method="POST">
        <p>
            <label for="customer_id">
                <p>Customer ID:</p>
                <input type="number" name="customer_id" id="customer_id" value=<?php echo($customer[0]['customer_id'])?> readonly>
            </label>
        </p>
        <p>
            <label for="forename">
                <p>Forename:</p>
                <input type="text" name="forename" id="forename" value="<?php echo($customer[0]['forename'])?>">
            </label>
        </p>
        <p>
            <label for="surname">
                <p>Surname:</p>
                <input type="text" name="surname" id="surname" value="<?php echo($customer[0]['surname'])?>">
            </label>
        </p>
        <p>
            <label for="nif">
                <p>NIF:</p>
                <input type="text" name="nif" id="nif" value="<?php echo($customer[0]['nif'])?>">
            </label>
        </p>
        <p>
            <label for="email">
                <p>Email:</p>
                <input type="email" name="email" id="email" value=<?php echo($customer[0]['email'])?>>
            </label>
        </p>
        <p>
            <label for="phone">
                <p>Phone:</p>
                <input type="text" name="phone" id="phone" value="<?php echo($customer[0]['phone'])?>">
            </label>
        </p>
        <p>
            <label for="birthdate">
                <p>Birthdate:</p>
                <input type="date" name="birthdate" id="birthdate" value="<?php echo($customer[0]['birthdate'])?>">
            </label>
        </p>

        <input type="submit" value="Update customer">
    </form>
</main>
<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>