<?php
  header("Content-Type: application/json; charset=UTF-8");
  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/functions/get_customer_id.php');

  $input = json_decode(file_get_contents('php://input'), true);

  if (!isset(
    $input['product_id'],
    $input['old_color'],
    $input['old_size'],
    $input['new_color'],
    $input['new_size']
  )) {
    http_response_code(400);
    echo json_encode(['error'=>'Datos incompletos']);
    exit;
  }

  $customer_id = getCustomerId($conn);
  $conn->begin_transaction();

  try {
    // ¿Ya existe la nueva combinación?
    $check = $conn->prepare("
      SELECT quantity
      FROM `012_shopping_cart`
      WHERE customer_id = ?
        AND product_id = ?
        AND selected_color = ?
        AND size = ?
    ");
    $check->bind_param(
      "iiss",
      $customer_id,
      $input['product_id'],
      $input['new_color'],
      $input['new_size']
    );
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
      // Sumar cantidades y borrar la antigua
      $row = $res->fetch_assoc();

      $update = $conn->prepare("
        UPDATE `012_shopping_cart`
        SET quantity = quantity + ?
        WHERE customer_id = ?
          AND product_id = ?
          AND selected_color = ?
          AND size = ?
      ");
      $update->bind_param(
        "iiiss",
        $row['quantity'],
        $customer_id,
        $input['product_id'],
        $input['new_color'],
        $input['new_size']
      );
      $update->execute();

      $delete = $conn->prepare("
        DELETE FROM `012_shopping_cart`
        WHERE customer_id = ?
          AND product_id = ?
          AND selected_color = ?
          AND size = ?
      ");
      $delete->bind_param(
        "iiss",
        $customer_id,
        $input['product_id'],
        $input['old_color'],
        $input['old_size']
      );
      $delete->execute();
    } else {
      // Simple update
      $stmt = $conn->prepare("
        UPDATE `012_shopping_cart`
        SET selected_color = ?, size = ?
        WHERE customer_id = ?
          AND product_id = ?
          AND selected_color = ?
          AND size = ?
      ");
      $stmt->bind_param(
        "siisss",
        $input['new_color'],
        $input['new_size'],
        $customer_id,
        $input['product_id'],
        $input['old_color'],
        $input['old_size']
      );
      $stmt->execute();
    }

    $conn->commit();
    echo json_encode(['success'=>true]);

  } catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['error'=>'Error actualizando variante']);
  }
?>