<?php
exit('asd');

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

\Dotenv\Dotenv::create(__DIR__ . '/..')->load();

require_once __DIR__ . '/../config/routes.php';

require_once __DIR__ . '/../config/database.php';

$bootstrap = \Core\Bootstrap::getInstance();

$bootstrap->start();

