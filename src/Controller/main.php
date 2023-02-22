<?php

require_once 'C:\Users\User\vendor\autoload.php';

use App\Controller\Receiver;
use App\Controller\Filter;
use App\Controller\Database;

$receiver = new Receiver();
$filter = new Filter();

$RabbitMQConnection = $filter -> connect();

for ($i = 0 ; $i <= 10 ; $i++) {
    $rooting_key = $receiver->get_data();
    $filtered_data = $filter->publish_data($RabbitMQConnection,
                                           $rooting_key);
}