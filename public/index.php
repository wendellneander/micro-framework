<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try{
    \Dotenv\Dotenv::create(__DIR__ . '/..')->load();
}catch (Exception $e){}

require_once __DIR__ . '/../config/routes.php';

require_once __DIR__ . '/../config/database.php';

\Core\Bootstrap::start();
