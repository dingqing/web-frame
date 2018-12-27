<?php 
return [
	'controllerDir' => 'controller',
	'modelDir'      => 'model',
	'viewDir'       => 'view',
	'db'       => [
        'database_type' => 'mysql',
        'database_name' => 'test',
        'server'        => 'localhost',
        'username'      => 'root',
        'password'      => '',
        'charset'       => 'utf8',
    ],
    'redis'=> [
        'host'  => 'localhost',
        'port' => 6379,
        'password'    => '',
    ],
    'swoole'=> [
        'worker_num'  => 5,
        'max_request' => 10000,
        'log_file'    => '/runtime/logs/easy_swoole.log',
    ],
];