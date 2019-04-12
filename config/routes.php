<?php

$router = \Core\Router::getInstance();

$router->route('/', 'WelcomeController@index');
