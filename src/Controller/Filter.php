<?php

namespace App\Controller;

require_once 'C:\Users\User\vendor\autoload.php';

use Symfony\Component\HttpFoundation\Response;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Filter
{
    /**
     * This class filters data from a RabbitMQ instance
     */

    public function connect($hostname = 'candidatemq.n2g-dev.net',
                            $username = 'cand_t4a4',
                            $password = 'fGOuTMHTHlINkAg5'): AMQPStreamConnection{
      /**
       * Create a RabbitMQ connection
       * :param hostname: the name of the host
       * :param username: the name of the user
       * :param password: the password
       * :return: an AMQPStreamConnection
       */

      return new AMQPStreamConnection($hostname, 5672, $username, $password);
    }

    public function close_connection($connection){
      /**
       * Close reate a RabbitMQ connection
       * :param connection: the RabbitMQ connection
       */
      $connection->close();     
    }
         
    public function publish_data($connection, 
                                 $routingKey,
                                 $exchange = 'cand_t4a4',
                                 $queue = 'cand_t4a4_results'): Response{
      /**
       * Send data to an exchange on a RabbitMQ instance where they are filtered
       * :param:
       * :return:
       */   
      $channel = $connection->channel();

      //$channel->queue_declare($queue, false, true, false, false);
      //$channel->exchange_declare($exchange, 'direct', true, true, false);
      $channel->queue_bind($queue, $exchange, $routingKey);

      $messageBody = json_encode([$routingKey]);
      $message = new AMQPMessage($messageBody, array('content_type' => 'text/plain','delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
      echo "Sending message..." . $message->body . "\n";

      $channel->basic_publish($message, $exchange, $routingKey);
      $channel->close();

      $message = $this -> consume_data($connection);
      $this->close_connection($connection);

      return $message;
      //return new Response(
      //  '<html><body>gatewayEui:'.$message.' </body></html>'
      //);
      }
    
    public function consume_data($connection) {
      /**
       * Consume data from the RabbitMQ queue
       * :param connection: the RabbitMQ connection
       * :return:
       */  
      $queue = 'cand_t4a4_results';
      $consumerTag = 'my_consumer';
      $exchange = 'cand_t4a4';

      $channel = $connection->channel();
      $channel->queue_bind($queue, $exchange);

      $channel->basic_qos(null, 1, null);
      $channel->basic_consume($queue, $consumerTag, false, false, false, false, function($message) {
          echo "Received message: " . $message->body. "\n"; 
          $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
          $routingKey = $message->delivery_info['routing_key'];
      });

      echo "Waiting for messages...\n";

      try {
        while (count($channel->callbacks)) {
            $channel->wait(null, true, 5);
        }} 
      catch (Exception $e) {
        echo "End of messages: " . $e->getMessage() . "\n";
      }

      $channel->close();
      
      return $message->body;
    }
}

?>