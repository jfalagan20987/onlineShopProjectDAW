<?php 
  $developers_key = " ";
  $location_key = "305482";

  $apikey="12345josep";
  //Testing cURL (currently: no idea)

  //Initialize a curl session
  $curl = curl_init();
  $data = array(
    'Authorization' => $developers_key
  );

  $payload = json_encode($data);
  //curl_setopt($curl, CURLOPT_URL, "https://dataservice.accuweather.com/currentconditions/v1/$location_key?apikey=$developers_key");
  curl_setopt($curl, CURLOPT_URL, "https://remotehost.es/student014/shop/backend/endpoints/product_seller.php?apikey=$apikey");
  //curl_setopt($curl, CURLOPT_POST, true);
  //curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
  //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

  $response = curl_exec($curl);
  curl_close($curl);
  echo $response;

  //print_r(curl_version());
?>