<?php

$router = \Core\Router::getInstance();

$router->route('/', 'StoreController@index');
$router->route('/new', 'StoreController@create');
$router->route('/save', 'StoreController@save');
$router->route('/edit/{id}', 'StoreController@edit');
$router->route('/update/{id}', 'StoreController@update');
$router->route('/delete/{id}', 'StoreController@delete');

$router->route('/product', 'ProductController@index');
$router->route('/product/new', 'ProductController@create');
$router->route('/product/save', 'ProductController@save');
$router->route('/product/edit/{id}', 'ProductController@edit');
$router->route('/product/update/{id}', 'ProductController@update');
$router->route('/product/delete/{id}', 'ProductController@delete');
