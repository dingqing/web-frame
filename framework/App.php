<?php

namespace Framework;

class App
{
    public static $rootPath;
    public static $configs;
    public static $container;

    public static $module;
    public static $controller;
    public static $action;
    public static $params;

    public function __construct()
    {
        self::$rootPath = dirname(__DIR__) . DIRECTORY_SEPARATOR;

        spl_autoload_register(['Framework\App', 'autoload']);

        // register services
        self::$container = new Container();
        self::$container->register();
    }

    public function run()
    {
        $configs = self::$configs;
        list(self::$module, self::$controller, self::$action, self::$params) = Router::parseUrl($configs['defaultModule'], $configs['defaultController'], $configs['defaultAction']);

        //check params
        self::$params = Request::check(self::$params);

        //register exception and error handle
        $errorHandle = new ErrorHandle();
        $errorHandle->register();

        /* dispatch */
        self::$controller = ucfirst(self::$controller);

        $c = 'App\\' . self::$module . '\\Controller\\' . self::$controller;
        $c = new $c();
        call_user_func_array([$c, self::$action], self::$params);
    }

    public function autoload($class)
    {
        $classArr = explode('\\', $class);
        $className = array_pop($classArr);
        $space = implode('/', $classArr);
        // namespace to lower case
        $space = strtolower($space);

        include self::$rootPath . $space . '/' . $className . '.php';
    }
}
