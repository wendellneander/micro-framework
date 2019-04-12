<?php

$router = \Core\Router::getInstance();

$router->route('/', 'StoreController@index');
$router->route('/new', 'StoreController@create');
$router->route('/save', 'StoreController@save');
$router->route('/edit/{id}', 'StoreController@edit');
$router->route('/update/{id}', 'StoreController@update');
$router->route('/delete/{id}', 'StoreController@delete');
