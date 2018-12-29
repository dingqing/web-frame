<?php

namespace Framework;

class ApiController
{
    function __construct()
    {
        $model = 'App\\' . App::$module . '\\Model\\' . App::$controller;
        $configs = App::$configs;
        $this->model = new $model($configs['db']);
    }

    public function __call($method, $b)
    {
        Log::write();
        Response::response('function : ' . $method . ' not found.');
    }
}