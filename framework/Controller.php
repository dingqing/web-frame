<?php

namespace Framework;

class Controller
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
        View::load('common/error', ['msg' => 'function : ' . $method . ' not found.']);
    }
}