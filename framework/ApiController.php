<?php

namespace Framework;

class ApiController
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
        Log::write();
        Response::response('function : ' . $method . ' not found.');
    }
}