<?php
$data = array(
  "deliverytype"=> 3,
  "sender"=> "METRO ECZANESİ",

  "SenderTaxpayerId"=> "",
  "description"=> "ÖZAY ÖZGÜDEN KEFKEN ECZANESİ",
  "senderAuthority"=> "METRO ECZANESİ",
  "senderAddress"=> "Osmangazi mah Ortapazarcad bedizci sok no:1/a osmangazi Bursa",
  "senderCityId"=> "16",
  "senderDistrictId"=> "177614",
  "senderPhone"=> "05323362313",
  "senderGSM"=> "05323362313",
  "senderEmail"=> "erpamukcu1@hotmail.com",
  "receiver"=> "KEFKEN ECZANESİ",
  "receiverAuthority"=> "KEFKEN ECZANESİ",
  "receiverAddress"=> "Kefken mh. Şehit Oguz Kır  cad.  no:205/A  KANDIRA / KOCAELİ",
  "receiverCityId"=> "41",
  "receiverDistrictId"=> "38140",
  "receiverPhone"=> "05383290563",
  "receiverGSM"=> "05383290563",
  "receiverEmail"=> "ozgudeneczanesi@hotmail.com",
  "paymentType"=> 1,
  "collectionType"=> 0,
  "collectionPrice"=> 0,
  "dispatchNoteNumber"=> "TELC2BJRIYHQ",
  "serviceType"=> 1,
  "barcodeLabelType"=> 1,
  "product"=> [
   [ 
    "Count"=> 1,
   "Deci"=> null
   ],
   
  ],
  "payType"=> 1,
  "isReturn"=> true
       
 
);


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
function sendeo($data)
{
  $user=json_decode(login()) ;
  $token=$user->result->Token;
  $referenceNo=$user->result->CustomerId;
  
  $data = json_decode(json_encode($data));

  $curl = curl_init();
  $sendData=array(
    "deliveryType"=> @$data->deliverytype,
    "referenceNo"=> $referenceNo,
    "description"=> @$data->description,
    "sender"=>@$data->sender,
    "SenderTaxpayerId"=>@$data->SenderTaxpayerId,
    "senderAuthority"=> @$data->senderAuthority,
    "senderAddress"=> @$data->senderAddress,
    "senderCityId"=>  @$data->senderCityId,
    "senderDistrictId"=> @$data->senderDistrictId,
    "senderPhone"=>  @$data->senderPhone,
    "senderGSM"=>  @$data->senderGSM,
    "senderEmail"=>  @$data->senderEmail,
    "receiver"=> @$data->receiver,
    "receiverAuthority"=> @$data->receiverAuthority,
    "receiverAddress"=> @$data->receiverAddress,
    "receiverCityId"=>  @$data->receiverCityId,
    "receiverDistrictId"=>  @$data->receiverDistrictId,
    "receiverPhone"=> @$data->receiverPhone,
    "receiverGSM"=> @$data->receiverGSM,
    "receiverEmail"=> @$data->receiverEmail,
    "paymentType"=> @$data->paymentType,
    "collectionType"=>  @$data->collectionType,
    "collectionPrice"=> @$data->collectionPrice,
    "dispatchNoteNumber"=>  @$data->dispatchNoteNumber,
    "serviceType"=> @$data->serviceType,
    "barcodeLabelType"=>  @$data->barcodeLabelType,
    "products"=>[],
    "payType"=> @$data->payType,
    "isReturn"=> true,

    );
   foreach ($data->product as  $value) {
     $prmProduct=new stdClass();
      $prmProduct->count=$value->Count;
      
      $prmProduct->deci=$value->Deci?$value->productCode:0;
    
      array_push($sendData['products'],$prmProduct);
   }

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.sendeo.com.tr/api/Cargo/SETDELIVERY',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_SSL_VERIFYHOST=> false,
    CURLOPT_SSL_VERIFYPEER=> false, 
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($sendData),
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json-patch+json',
      'Accept: application/json',
      'Authorization: Bearer '.$token,
      'Cookie: Enc_Cookie=370086060.47873.0000; TS01af34b2=0157130bb94a0659105b27ddbfe9e6e5577b3a77de36e0b0169306eb918c0869ca47ef4cb0380a23ec7ad03087311b652957a73bf9e368570e8573fc9503d761ea1d4bb69e'
    ),
  ));
  
  $response = curl_exec($curl);

  curl_close($curl);
 
return $response;
}

 echo "<pre>";
    print_r(json_decode( sendeo($data))) ;

?>
ds