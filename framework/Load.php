<?php
/**
 * User: dingqing
 * Time: 19-1-8 下午3:07
 */

namespace Framework;


class Load
{
    public static $namespaceMap = [];

    public static function register(App $app)
    {
        self::$namespaceMap = [
            'Framework' => App::$rootPath
        ];

        spl_autoload_register(['Framework\Load', 'autoload']);

        require(App::$rootPath . 'vendor/autoload.php');
    }

    public static function autoload($class)
    {
        $classArr = explode('\\', $class);
        $className = array_pop($classArr);
        $space = implode('/', $classArr);
        // namespace to lower case
        $space = strtolower($space);

        $path = self::$namespaceMap['Framework'];
        include $path . $space . '/' . $className . '.php';
    }
}