<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../core/bootstrap.php';

require_once __DIR__ . '/../config/routes.php';

require_once __DIR__ . '/../config/database.php';

$bootstrap = \Core\Bootstrap::getInstance();

$bootstrap->start();

