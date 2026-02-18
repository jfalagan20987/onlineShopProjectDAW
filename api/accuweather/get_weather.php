<?php
  $developers_key = "zpka_0fb27bf1a70441198a73024c762021e7_9b957bb0";
  $location_key = "305482";

  $url = "https://dataservice.accuweather.com/currentconditions/v1/$location_key?apikey=$developers_key&details=true";
  $json = file_get_contents($url);

  if ($json === false) {
      http_response_code(500);
      echo "Error calling AccuWeather";
      exit;
  }

  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

  $json_escaped = mysqli_real_escape_string($conn, $json);

  $sql = "INSERT INTO `012_accuweather` (accuweather_json) VALUES ('$json_escaped')";
  mysqli_query($conn, $sql);

  header("Content-Type: application/json");
  echo $json;
?>