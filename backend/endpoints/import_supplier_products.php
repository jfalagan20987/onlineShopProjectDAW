<?php

require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

$apikey = "85c712e7-6a84-4a5a-87a3-47b25df6771b";
$url = "https://remotehost.es/student024/Shop/backend/endpoints/sellers/sellers_products.php?apikey=$apikey";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl);
curl_close($curl);

$products = json_decode($response, true);
print_r($products);

// Identify the supplier
$getSupplierId = "SELECT supplier_id FROM `012_suppliers` WHERE supplier_api_key = '$apikey';";
$result = mysqli_query($conn, $getSupplierId);
$supplier = mysqli_fetch_all($result, MYSQLI_ASSOC);
$supplier_id = $supplier[0]['supplier_id'];

// Delete supplier products
$delete = "DELETE FROM `012_products` WHERE supplier_id = $supplier_id;";
mysqli_query($conn, $delete);

// Allowed sizes
$allowed_sizes = ['40','41','42','43','44','45','46','47','XS','S','M','L','XL','2XL'];

foreach ($products as $product) {

    $product_code = mysqli_real_escape_string($conn, $product['product_id']);
    $product_name = mysqli_real_escape_string($conn, $product['product_name']);
    $image_path = mysqli_real_escape_string($conn, $product['product_image']);
    $unit_price = $product['product_price'];
    $description = mysqli_real_escape_string($conn, $product['product_desc']);
    $color = mysqli_real_escape_string($conn, $product['product_color'] ?? '');
    $stock = $product['product_stock'];

    $colors = is_array($color) ? implode(',', $color) : $color;

    $rawSize = $product['product_size'] ?? null;

    /* if (is_array($rawSize)) {
        $rawSize = $rawSize[0] ?? null
    } */

    $size = strtoupper(trim((string)$rawSize));

    if (!in_array($size, $allowed_sizes)) {
        $insert = "INSERT INTO `012_products`
            (image_path, product_name, `description`, color, unit_price, product_code, supplier_id, stock)
            VALUES
            ('$image_path', '$product_name', '$description', '$colors', $unit_price, '$product_code', $supplier_id, $stock)";
    } else {
        $insert = "INSERT INTO `012_products`
            (image_path, product_name, `description`, color, `size`, unit_price, product_code, supplier_id, stock)
            VALUES
            ('$image_path', '$product_name', '$description', '$colors', '$size', $unit_price, '$product_code', $supplier_id, $stock)";
    }

    mysqli_query($conn, $insert);
}
?>