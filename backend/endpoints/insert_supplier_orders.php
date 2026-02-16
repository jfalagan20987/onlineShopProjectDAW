<?php

require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

if (!isset($order_number_to_send)) {
    exit;
}


// Get suppliers involved in this order
$sql = "SELECT DISTINCT p.supplier_id, s.supplier_api_key, s.supplier_endpoint_orders

        FROM `012_orders` AS o
        INNER JOIN `012_products` AS p ON o.product_id = p.product_id
        INNER JOIN `012_suppliers` AS s ON p.supplier_id = s.supplier_id
        WHERE o.order_number = $order_number_to_send";

$result = mysqli_query($conn, $sql);

$suppliers = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (empty($suppliers)) {
    exit;
}


// Send order to each supplier
foreach ($suppliers as $supplier) {

    $supplier_id = $supplier['supplier_id'];
    $api_key = $supplier['supplier_api_key'];
    $endpoint = $supplier['supplier_endpoint_orders'];


    // Get products for this supplier
    $sql = "SELECT p.product_code AS product_code, o.quantity AS product_quantity, c.forename AS customer_forename, c.surname AS customer_surname,
            c.nif AS customer_nif, c.email AS customer_email, c.phone AS customer_phone, a.direction AS customer_address, a.location AS customer_location,
            a.country AS customer_country, a.zip_code AS customer_zip

        FROM `012_orders` AS o
        INNER JOIN `012_products` AS p ON o.product_id = p.product_id
        INNER JOIN `012_customers` AS c ON o.customer_id = c.customer_id
        INNER JOIN `012_addresses` AS a ON o.address_id = a.address_id
        WHERE o.order_number = $order_number_to_send AND p.supplier_id = $supplier_id";

    $result = mysqli_query($conn, $sql);

    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (empty($orders)) {
        continue;
    }

    $orders_json = json_encode($orders, JSON_UNESCAPED_UNICODE);

    $orders_encoded = urlencode($orders_json);

    $url = $endpoint
         . "?apikey=$api_key"
         . "&orders_json=$orders_encoded";


    // Send
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    curl_close($ch);

}

?>