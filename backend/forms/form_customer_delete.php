<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>
<?php
    //Get data
    $customer_id = $_POST['customer_id'];

    //Search by ID
    $sql = "SELECT customer_id, forename, surname
            FROM `012_customers`
            WHERE customer_id = $customer_id;";
    
    include($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    $result = mysqli_query($conn, $sql);
    $customer = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<main>
    <form action="/student012/shop/backend/db/db_customer_delete.php" method="POST">
        <p>Are you sure you want to delete this customer?</p>
        <p>
            Customer ID:
            <input type="number" name="customer_id" id="customer_id" value=<?php echo($customer[0]['customer_id'])?> readonly>
        </p>
        <p>
            Forename:
            <input type="text" name="forename" id="forename" value="<?php echo($customer[0]['forename'])?>" readonly>
        </p>
        <p>
            Surname:
            <input type="text" name="surname" id="surname" value="<?php echo($customer[0]['surname'])?>" readonly>
        </p>

        <input type="submit" value="Delete customer">
    </form>
</main>
<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>