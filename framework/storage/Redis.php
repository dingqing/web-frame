<?php

namespace Framework\Storage;

use Framework\App;
use Redis as rootRedis;

class Redis
{
    public static function init()
    {
        $env = App::$container->getSingle('env')->envParams;
        $config = $env['redis'];
        $redis = new rootRedis();
        $redis->connect($config['host'], $config['port']);
        return $redis;
    }
}
