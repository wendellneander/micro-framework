<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../core/bootstrap.php';

$app = new \Core\Application();

$bootstrap = new \Core\Bootstrap();

$bootstrap->start();

