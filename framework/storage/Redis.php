<?php

namespace Framework\Storage;

use Framework\App;
use Redis as rootRedis;

class Redis
{
    public static function init()
    {
        $configs = App::$container->getSingle('config')->config;
        $config = $configs['redis'];
        $redis = new rootRedis();
        $redis->connect($config['host'], $config['port']);
        return $redis;
    }
}
