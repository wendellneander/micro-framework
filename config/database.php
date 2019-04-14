<?php

$database = \Core\DataBase::getInstance();

$database->addConfig('db', [
    'driver' => getenv('DB_DRIVER'),
    'host' => getenv('DB_HOST'),
    'database' => getenv('DB_DATABASE'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => getenv('DB_CHARSET'),
    'collation' => getenv('DB_COLLATION')
]);

$database->setCurrentConfig('db');
