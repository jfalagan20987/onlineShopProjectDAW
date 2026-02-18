<?php

  $developers_key = "zpka_0fb27bf1a70441198a73024c762021e7_9b957bb0";
  $location_key = "305482";
  $url = "https://dataservice.accuweather.com/forecasts/v1/daily/5day/$location_key?apikey=$developers_key&details=true&metric=true";

  $json = file_get_contents($url);
  $data = json_decode($json, true);
  $pretty_json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

  file_put_contents('forecast_5days.json', $pretty_json);
?>