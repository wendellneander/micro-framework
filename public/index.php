<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try{
    \Dotenv\Dotenv::create(__DIR__ . '/..')->load();
}catch (Exception $e){}


try{
    require_once __DIR__ . '/../config/routes.php';

    require_once __DIR__ . '/../config/database.php';

    $bootstrap = \Core\Bootstrap::getInstance();

    $bootstrap->start();
}catch (Exception $e){
    var_dump($e);
    exit;
}
