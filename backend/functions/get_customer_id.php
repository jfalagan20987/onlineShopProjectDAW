<?php
    function getCustomerId($conn) {
        if (isset($_COOKIE['customer_id'])) {
            return intval($_COOKIE['customer_id']);
        }

        //Insertar cliente temporal con valores por defecto
        $stmt = $conn->prepare("
            INSERT INTO `012_customers` 
            (forename, surname, nif, email, phone, birthdate, username, password, customer_type)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $forename = '';
        $surname = '';
        $nif = '';
        $email = '';
        $phone = '';
        $birthdate = '1900-01-01'; //dummy date
        $username = 'guest_' . uniqid();
        $password = '';
        $customer_type = 'customer';

        $stmt->bind_param(
            "sssssssss",
            $forename, $surname, $nif, $email, $phone, $birthdate, $username, $password, $customer_type
        );

        $stmt->execute();

        $customer_id = $conn->insert_id;

        $secure = isset($_SERVER['HTTPS']);

        setcookie(
            "customer_id",
            $customer_id,
            time() + (60 * 60 * 24 * 30), //30 días
            "/",
            "",
            $secure,
            true
        );

        return $customer_id;
    }
?>

