<?php

return [

    'driver' => getenv('DB_CHARSET') || 'sqlite',

    'sqlite' => [
        'host' => getenv('DB_HOST') || 'sqlite'
    ],

    'mysql' => [
        'host' => getenv('DB_HOST') || 'sqlite',
        'database' =>  getenv('DB_DATABASE') || 'sqlite',
        'user' =>  getenv('DB_USER') || 'sqlite',
        'password' =>  getenv('DB_PASSWORD') || 'sqlite',
        'charset' =>  getenv('DB_CHARSET') || 'sqlite',
        'collation' =>getenv('DB_CHARSET') || 'utf8_unicode_ci'
    ]

];
