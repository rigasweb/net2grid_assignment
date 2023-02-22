<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class Receiver
{
  /**
   * This class retrieves data from the API endpoint
   */
  
  public function get_data(): Response{
    /**
    * Get the data from the API url
    *
    * :param url: the url string
    * :return: the response data
    */
    $api_url = 'https://xqy1konaa2.execute-api.eu-west-1.amazonaws.com/prod/results';
    
    // Read JSON file
    $json_data = file_get_contents($api_url);

    // Decode JSON data into PHP array
    $response_data = json_decode($json_data, true);

    // Transform values to decimal
    foreach ($response_data as $key => &$value) {
      if ($key === "gatewayEui" || substr($value, 0, 2) === "0x") {
        $value = hexdec(substr($value, 2));
      }
    }

    $rooting_key = $this -> transformArray($response_data);

    return $rooting_key;
  }

  public function transformArray($array) {
    /**
    * Transform the array the a valid rooting key
    * e.g. 9574384526953556788.260.10.1794.1024
    *
    * :param url: the php array 
    * :return: the valid rooting key
    */
    $gatewayEui = $array["gatewayEui"];
    $profileId = $array["profileId"];
    $endpointId = $array["endpointId"];
    $clusterId = $array["clusterId"];
    $attributeId = $array["attributeId"];
  
    $transformed = "{$gatewayEui}.{$profileId}.{$endpointId}.{$clusterId}.{$attributeId}";
    return $transformed;
  }
}

?>
