<?php

use Core\Router;

Router::route('/', 'StoreController@index');
Router::route('/new', 'StoreController@create');
Router::route('/save', 'StoreController@save');
Router::route('/edit/{id}', 'StoreController@edit');
Router::route('/update/{id}', 'StoreController@update');
Router::route('/delete/{id}', 'StoreController@delete');

Router::route('/products', 'ProductController@index');
Router::route('/product/new', 'ProductController@create');
Router::route('/product/save', 'ProductController@save');
Router::route('/product/edit/{id}', 'ProductController@edit');
Router::route('/product/update/{id}', 'ProductController@update');
Router::route('/product/delete/{id}', 'ProductController@delete');
Router::route('/product/import', 'ProductController@import');
Router::route('/products/{store}/{category}', 'ProductController@productsByStoreAndCategory');

Router::route('/categories', 'CategoryController@index');
Router::route('/category/new', 'CategoryController@create');
Router::route('/category/save', 'CategoryController@save');
Router::route('/category/edit/{id}', 'CategoryController@edit');
Router::route('/category/update/{id}', 'CategoryController@update');
Router::route('/category/delete/{id}', 'CategoryController@delete');
Router::route('/category/delete/{id}', 'CategoryController@delete');
Router::route('/calcula-notas/{nota1}/{nota2}/{nota3}/{nota4}', 'MathController@calculateScore');
Router::route('/calcula-temperatura/{celsius}', 'MathController@calculateTemperature');
Router::route('/calcula-idade/{years}/{months}/{days}', 'MathController@calculateAge');
