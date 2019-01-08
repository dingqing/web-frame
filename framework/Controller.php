<?php

namespace Framework;

class Controller
{
    function __construct()
    {
        $router = App::$container->getSingle('router');
        $configs = App::$container->getSingle('config')->config;

        $model = 'App\\' . $router->module . '\\Model\\' . $router->controller;
        $this->model = new $model($configs['db']);
    }

    public function __call($method, $b)
    {
        View::load('common/error', ['msg' => 'function : ' . $method . ' not found.']);
    }
}