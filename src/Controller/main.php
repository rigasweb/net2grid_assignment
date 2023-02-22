<?php

require_once 'C:\Users\User\vendor\autoload.php';

use App\Controller\Receiver;
use App\Controller\Filter;
use App\Controller\Database;

$rabbitMQQueue = 'cand_x07w_results';
$rabbitMQExchange = 'cand_x07w';

$receiver = new Receiver();
$filter = new Filter();

for ($i = 0 ; $i <= 10 ; $i++) {
    $receiver->get_data($rabbitMQConnection, $rabbitMQQueue, $rabbitMQExchange);
}
$consumer->consumingData($rabbitMQConnection, $rabbitMQQueue, $rabbitMQExchange, $databaseConnection);

$connectors->closeConnections($rabbitMQConnection, $databaseConnection);