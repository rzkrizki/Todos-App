<?php

return [

   'default' => 'mysql',

   'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST'),
            'port'      => env('DB_PORT'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
    ],

    'redis' => [
        'client' => env('REDIS_CLIENT'),
        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT'),
            'database' => env('REDIS_CACHE_DB'),
        ],
    ],
];