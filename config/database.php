<?php

return [

    'driver' => getenv('DB_DRIVER'),

    'sqlite' => [
        'host' => getenv('DB_HOST'),
    ],

    'mysql' => [
        'host' => getenv('DB_HOST'),
        'database' => getenv('DB_DATABASE'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'charset' => getenv('DB_CHARSET'),
        'collation' => getenv('DB_COLLATION')
    ]
];
