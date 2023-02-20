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
    $response_data = json_decode($json_data);

    // Transform eui to decimal
    $response_data->gatewayEui = hexdec($response_data->gatewayEui);

    return new Response(
      '<html><body>gatewayEui: '.$response_data->gatewayEui.'</body></html>'
    );
  }
}
?>
