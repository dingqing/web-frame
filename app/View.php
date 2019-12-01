<?php

namespace App;

use Framework\App;

class View
{
    static function loadRaw($file = '', $data = [])
    {
        self::load($file, $data, 0, 0);
    }

    static function load($file = '', $data = [], $header = true, $footer = true)
    {
        extract($data);
        // varibles passed to template
        $router = App::$container->getSingle('router');
        $module = $router->module;
        $controller = $router->controller;
        $action = $router->action;
        $baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR;

        ob_start();
        ob_implicit_flush(0);

        // load templates
        if ($header) {
            include (App::$rootPath) . 'view/common/header.php';
        }
        include (App::$rootPath) . 'view/' . $file . '.php';
        if ($footer) {
            include App::$rootPath . 'view/common/footer.php';
        }

        echo ob_get_clean();
    }
}