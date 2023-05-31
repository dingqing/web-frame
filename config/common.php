<?php
return [
    'application_folder' => 'app',
    /* 默认模块 */
    'module' => [
        'demo'
    ],
    'route'  => [
        'defaultModule'     => 'demo',
        'defaultController' => 'index',
        'defaultAction'     => 'hello',
    ],
    /* 响应结果是否使用框架定义的rest风格 */
    'rest_response' => true,
];