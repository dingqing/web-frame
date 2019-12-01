<?php

return [
    /* 主库配置 */
    'db' => [
        'database_type'   => env('db')['database_type'],
        'dbprefix' => env('db')['dbprefix'],
        'database_name'   => env('db')['database_name'],
        'server'   => env('db')['server'],
        'username' => env('db')['username'],
        'password' => env('db')['password'],
        'slave'    => explode(',', env('db')['slave'])
    ],
    /* 从库0配置 */
    'db-slave-0' => [
        'dbname'   => env('db-slave-0')['dbname'],
        'dbhost'   => env('db-slave-0')['dbhost'],
        'username' => env('db-slave-0')['username'],
        'password' => env('db-slave-0')['password'],
    ],
    /* 从库1配置 */
    'db-slave-1' => [
        'dbname'   => env('db-slave-1')['dbname'],
        'dbhost'   => env('db-slave-1')['dbhost'],
        'username' => env('db-slave-1')['username'],
        'password' => env('db-slave-1')['password'],
    ]
];
