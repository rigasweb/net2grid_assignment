<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    $paths= array('C:\Users\User\Documents\net2grid\src\Entity'),
    $isDevMode= true,);

// configuring the database connection
$connection = DriverManager::getConnection([
    'dbname' => 'cand_t4a4',
    'user' => 'cand_t4a4',
    'password' => 'fGOuTMHTHlINkAg5',
    'host' => 'candidaterds.n2g-dev.net',
    'driver' => 'pdo_sqlite',
    //'path' => __DIR__ . '/db.sqlite',
], $config);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);

?>
