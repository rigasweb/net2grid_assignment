<?php

namespace App\Controller;

require_once 'C:\Users\User\vendor\autoload.php';

use mysqli;

class Database
{
    /**
     * This connects and stores data to a database
     */

    public function connect($hostname = 'candidaterds.n2g-dev.net',
                            $username = 'cand_t4a4',
                            $password = 'fGOuTMHTHlINkAg5',
                            $database = 'cand_t4a4'): AMQPStreamConnection{
      /**
       * Create a connection with the DataBase
       * :param hostname: the name of the host
       * :param username: the name of the user
       * :param password: the password
       * :return: an AMQPStreamConnection
       */
      
      $databaseConnection = new mysqli($databaseServername, $databaseUsername, $databasePassword, $dbname);

      if ($databaseConnection->connect_error) {
          die("Connection failed: " . $databaseConnection->connect_error);
      }
      return $databaseConnection;
  }

    public function close_connection($connection){
      /**
       * Close reate a RabbitMQ connection
       * :param connection: the RabbitMQ connection
       */
      $connection->close();     
    }
         
    public function publish_data(): Response{
      /**
       * Send data to an exchange on a RabbitMQ instance where they are filtered
       * :param:
       * :return:
       */   

      $connection = $this -> connect();
      $channel = $connection->channel();
      
      $exchange = 'cand_t4a4';
      $queue = 'cand_t4a4_results';
      $routingKey = '9574384526953556788.260.10.1794.1024'; 

      //$channel->queue_declare($queue, false, true, false, false);
      //$channel->exchange_declare($exchange, 'direct', true, true, false);
      $channel->queue_bind($queue, $exchange, $routingKey);

      $messageBody = json_encode([$routingKey]);
      $message = new AMQPMessage($messageBody, array('content_type' => 'text/plain','delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
      echo "Sending message..." . $message->body . "\n";

      $channel->basic_publish($message, $exchange, $routingKey);
      $channel->close();

      $sth = $this -> consume_data($connection);
      $this->close_connection($connection);

      return new Response(
        '<html><body>gatewayEui: </body></html>'
      );
      }
    
    public function consume_data($connection): Response{
      /**
       * Consume data from the RabbitMQ queue
       * :param connection: the RabbitMQ connection
       * :return:
       */  
      
      $channel = $connection->channel();

      $queue = 'cand_t4a4_results';
      $consumerTag = 'my_consumer';

      $channel->basic_qos(null, 1, null);
      $channel->basic_consume($queue, $consumerTag, false, false, false, false, function($message) {
          echo "Received message: " . $message->body. "\n"; 
          $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
          $routingKey = $message->delivery_info['routing_key'];
      });

      echo "Waiting for messages...\n";

      try {
        while (count($channel->callbacks)) {
            $channel->wait(null, true, 3);
        }} 
      catch (Exception $e) {
        echo "End of messages: " . $e->getMessage() . "\n";
      }

      $channel->close();
    }
}

?>