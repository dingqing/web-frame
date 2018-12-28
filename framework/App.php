<?php

namespace Framework;

class App
{
    public static $rootPath;
    public static $configs;

    public static $module;
    public static $controller;
    public static $action;
    public static $params;

    public function __construct()
    {
        self::$rootPath = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        self::$configs = $this->getConfig();
    }

    public function run()
    {
        spl_autoload_register(['Framework\App', 'autoload']);

        $configs = self::$configs;
        list(self::$module, self::$controller, self::$action, self::$params) = Router::parseUrl($configs['defaultModule'], $configs['defaultController'], $configs['defaultAction']);

        //check params
        self::$params = Request::check(self::$params);

        //exception and error handle
        $errorHandle = new ErrorHandle();
        $errorHandle->register();

        $this->dispatch();
    }

    public function dispatch()
    {
        $c = ucfirst(self::$controller);

        $model = 'App\\' . self::$module . '\\Model\\' . $c;
        $configs = self::$configs;
        $model = new $model($configs['db']);

        // 执行方法
        $c = 'App\\' . self::$module . '\\Controller\\' . $c;
        $c = new $c($model);

        call_user_func_array([$c, self::$action], self::$params);
    }

    // 规则：命名空间和目录名保持同名
    public function autoload($class)
    {
        $classArr = explode('\\', $class);
        $className = array_pop($classArr);
        //命名空间转小写目录名
        foreach ($classArr as &$v) {
            $v = strtolower($v);
        }
        unset($v);

        array_push($classArr, $className);
        $class = implode('\\', $classArr);
        $class = str_replace('\\', '/', $class);

        include self::$rootPath . $class . '.php';
    }

    public function getConfig()
    {
        return $configs = include self::$rootPath . 'config/common.php';
    }
}
