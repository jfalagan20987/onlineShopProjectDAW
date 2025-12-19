<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/functions/get_customer_id.php');

    //Read POST JSON
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || !isset($input['product_id'], $input['quantity'])) {
        http_response_code(400);
        echo json_encode(['success'=>false, 'error'=>'Datos incompletos']);
        exit;
    }

    $product_id = intval($input['product_id']);
    $quantity = intval($input['quantity']);
    $selected_color = isset($input['selected_color']) ? $conn->real_escape_string($input['selected_color']) : '';
    $size = isset($input['size']) ? $conn->real_escape_string($input['size']) : '';

    //Get or create customer_id
    $customer_id = getCustomerId($conn);
    if (!$customer_id) {
        http_response_code(500);
        echo json_encode(['success'=>false, 'error'=>'No se pudo obtener customer_id']);
        exit;
    }

    //Verify if there's a coincidence in the DB
    $stmt = $conn->prepare("
        SELECT quantity 
        FROM `012_shopping_cart`
        WHERE customer_id = ? AND product_id = ? AND selected_color = ? AND size = ?
    ");

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['success'=>false, 'error'=>'Error en SQL: '.$conn->error]);
        exit;
    }

    $stmt->bind_param("iiss", $customer_id, $product_id, $selected_color, $size);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newQuantity = $row['quantity'] + $quantity;

        $update = $conn->prepare("
            UPDATE `012_shopping_cart` 
            SET quantity = ? 
            WHERE customer_id = ? AND product_id = ? AND selected_color = ? AND size = ?
        ");
        if (!$update) {
            http_response_code(500);
            echo json_encode(['success'=>false, 'error'=>'Error en SQL: '.$conn->error]);
            exit;
        }
        $update->bind_param("iisss", $newQuantity, $customer_id, $product_id, $selected_color, $size);
        $update->execute();
    } else {
        $insert = $conn->prepare("
            INSERT INTO `012_shopping_cart`
            (customer_id, product_id, quantity, selected_color, size, inserted_on)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        if (!$insert) {
            http_response_code(500);
            echo json_encode(['success'=>false, 'error'=>'Error en SQL: '.$conn->error]);
            exit;
        }
        $insert->bind_param("iiiss", $customer_id, $product_id, $quantity, $selected_color, $size);
        $insert->execute();
    }

    echo json_encode(['success'=>true]);
    exit;
?>
