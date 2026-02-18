<?php
    header('Content-Type: application/json');

    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

    $developers_key = "zpka_0fb27bf1a70441198a73024c762021e7_9b957bb0";
    $location_key = "305482";

    $url = "https://dataservice.accuweather.com/currentconditions/v1/$location_key?apikey=$developers_key&details=true";
    $json = file_get_contents($url);

    $data = json_decode($json, true);

    if (!$data) {
        echo json_encode([
            "ok" => false,
            "error" => "Error fetching AccuWeather"
        ]);
        exit;
    }

    $pretty_json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $pretty_json_db = mysqli_real_escape_string($conn, $pretty_json);

    $sql = "INSERT INTO `012_accuweather` (accuweather_json) VALUES ('$pretty_json_db')";
    mysqli_query($conn, $sql);

    echo $pretty_json;
?>