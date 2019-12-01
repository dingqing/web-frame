<?php

namespace App;

use Framework\App;

class Controller
{
    function __construct()
    {
        $router = App::$container->getSingle('router');
        $env = App::$container->getSingle('env')->envParams;

        $model = 'App\\' . $router->module . '\\Model\\' . $router->controller;
        $this->model = new $model($env['db']);
    }

    public function __call($method, $b)
    {
        View::load('common/error', ['msg' => 'function : ' . $method . ' not found.']);
    }
}