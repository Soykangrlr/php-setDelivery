<?php

// Bizden yine Token istiyor bundan dolayı tekrar giriş methodunu ekledim.
function login(){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.sendeo.com.tr/api/Token/LoginAES',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYHOST=> false,
      CURLOPT_SSL_VERIFYPEER=> false, 
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>"{
        'musteri': 'TEST',
    'sifre': 'TesT.43e54',
    
    }",
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Cookie: Enc_Cookie=370086060.47873.0000; TS01af34b2=0157130bb90d114c5a742184871ce345c7152e22f50aa33b1edfb40a47cceb7719a853ec85da348e0de640196530c367e33f789409979b638956dfcd25207bad88eed69f2e'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
  return $response;
  }
 
function track($trackingNo){
    $user=json_decode(login()) ;
    $token=$user->result->Token;
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.sendeo.com.tr/api/Cargo/TRACKDELIVERY?trackingNo='.$trackingNo,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_SSL_VERIFYHOST=> false,
  CURLOPT_SSL_VERIFYPEER=> false,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$token,
    'Cookie: Enc_Cookie=353308844.47873.0000; TS01af34b2=0157130bb998b7463efe2a59f38e4cb1e4f28c3725f970ad03bcfa7837ef4ebdb30f89f8a47b4ed5890493bc411b4d440d604c316f'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;
}

// Referans Numarası ile kargo takibi yapılıyor ama 2 adet kargo olduüunda ne dönecek deneyemedim
function trackRef(){
    $user=json_decode(login()) ;
    $token=$user->result->Token;
    $referenceNo=$user->result->CustomerId;
    $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.sendeo.com.tr/api/Cargo/TRACKDELIVERY?referenceNo='.$referenceNo,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYHOST=> false,
        CURLOPT_SSL_VERIFYPEER=> false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
            'Cookie: Enc_Cookie=353308844.47873.0000; TS01af34b2=0157130bb998b7463efe2a59f38e4cb1e4f28c3725f970ad03bcfa7837ef4ebdb30f89f8a47b4ed5890493bc411b4d440d604c316f'
        ),
        ));

    $response = curl_exec($curl);

        curl_close($curl);
        return $response;
}
$trackingNo="231064940537"; //TrackingNo SetDelivery dönen TrackingNumber 
echo "<pre>";
    print_r(json_decode( track($trackingNo))) ;
    print_r(json_decode( trackRef()));
