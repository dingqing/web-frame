<?php
/**
 * User: dingqing
 * Time: 2019-1-8 下午3:07
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
        // 注册自定义自加载方法
        spl_autoload_register(['Framework\Load', 'autoload']);
        // composer自加载文件
        // require(App::$rootPath . 'vendor/autoload.php');
    }

    /**
     * 输入示例：Framework\Handles\RouterHandle
     * 输出：framework/handles/routerhandle.php
     */
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