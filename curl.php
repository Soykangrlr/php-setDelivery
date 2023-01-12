<?php
$data = array(
  "deliveryType" => 3,
    "description"=> "string",
      "sender"=> "string",
      "senderBranchCode"=> 123,
      "senderAuthority"=> "string",
      "senderAddress"=> "string",
      "senderCityId"=> 34,
      "senderDistrictId"=> 34139,
      "senderPhone"=> "1234567891",
      "senderEmail"=> "test2@testmail.com",
      "receiver"=> "string",
      "receiverBranchCode"=> 123,
      "receiverAuthority"=> "string",
      "receiverAddress"=> "string",
      "receiverCityId"=> 26,
      "receiverDistrictId"=> 174228,
      "receiverPhone"=> "12345678912",
      "receiverEmail"=> "test@testmail.com",
      "paymentType"=> 1,
      "collectionType"=> 0,
      "collectionPrice"=> 0,
      "dispatchNoteNumber"=> "1a2b3-SendeO",
      "additionalValue"=> "string",
      "serviceType"=> 1,
      "barcodeLabelType"=> 3,
      "payType"=> 1,
      "customerReferenceType"=>"dsa",
      "isReturn"=>true,
      "product"=>[  
         [
          "count"=>877,
      "productCode"=> "string",
      "description"=> "string",
      "deci"=> 0,
      "weigth"=> 0,
      "deciWeight"=> 0]
      ,
      [  
         "count"=>977,
      "productCode"=> "string",
      "description"=> "string",
      "deci"=> 0,
      "weigth"=> 0,
      "deciWeight"=> 0]
      ]
       
 
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
    "deliveryType"=> @$data->deliveryType,
    "referenceNo"=> $referenceNo,
    "description"=> @$data->description,
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
    "collectionType"=>  @$data->paymentType,
    "collectionPrice"=> @$data->collectionPrice,
    "dispatchNoteNumber"=>  @$data->dispatchNoteNumber,
    "additionalValue"=> @$data->additionalValue,
    "serviceType"=> @$data->serviceType,
    "barcodeLabelType"=>  @$data->barcodeLabelType,
    "product"=>[],
    "payType"=> @$data->payType,
    "customerReferenceType"=> @$data->customerReferenceType,
    "isReturn"=> true,

    );
   foreach ($data->product as  $value) {
     $prmProduct=new stdClass();
      $prmProduct->count=$value->count;
      $prmProduct->productCode=$value->productCode?$value->productCode:"";
      $prmProduct->description=$value->description?$value->description:"";
      $prmProduct->deci=$value->deci?$value->productCode:0;
      $prmProduct->weigth=$value->weigth?$value->weigth:0;
      $prmProduct->deciWeight=$value->deciWeight?$value->deciWeight:0;
      array_push($sendData['product'],$prmProduct);
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
