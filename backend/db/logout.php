<?php
    session_start();

    if(isset($_SESSION['customer_id'])) {
        $logDir  = $_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/logs';
        $logFile = $logDir . '/log.txt';

        // Crear directorio si no existe
        if (!is_dir($logDir)) mkdir($logDir, 0777, true);

        // Abrir archivo para agregar al final
        $handle = fopen($logFile, 'a+');
        if ($handle) {
            $customer_id = $_SESSION['customer_id'];
            $username = $_SESSION['username'] ?? 'unknown';
            date_default_timezone_set('Europe/Madrid');
            $date = date('Y-m-d H:i:s');

            // Escribir línea de logout
            fwrite($handle, "Customer $customer_id ($username) has logged out -- $date\n");

            fclose($handle);
        }
    }
    session_destroy();

    setcookie('lang', '', time() - 3600, "/");

    header("Location: /student012/shop/backend/index.php");
    exit;
?>