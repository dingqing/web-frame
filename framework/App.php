<?php

namespace Framework;

class App
{
    public $rootPath;
    public $viewPath;
    public $configs;

    function __construct() {
        $this->rootPath = $rootPath = dirname(__DIR__).DIRECTORY_SEPARATOR;
        $this->configs = $this->getConfig();

        $this->viewPath = $rootPath .$this->configs['viewDir'].DIRECTORY_SEPARATOR;
    }

    function __call($method, $b) {
        $this->notExist($method, 'function');
    }

    public function run() {
        spl_autoload_register(['Framework\App', 'autoload']);

        //exception and error handle
        Handle::call();

        $this->dispatch();
    }

    public function dispatch() {
        list($module, $c, $a, $params) = $this->parseUrl();
        $c = ucfirst($c);

        $m = 'App\\'.$module.'\\Model\\'.$c;
        $configs = $this->configs;
        $model = new $m($configs['db']);

        // 执行方法
        $contro = 'App\\'.$module.'\\Controller\\'.$c;
        $contro = new $contro($model);

        call_user_func_array([$contro, $a], $params);
    }

    // 规则：命名空间和目录名保持同名
    function autoload($class) {
        $classArr   = explode('\\', $class);
        $className   = array_pop($classArr);
        //命名空间转小写目录名
        foreach ($classArr as &$v) {
            $v = strtolower($v);
        }
        unset($v);

        array_push($classArr, $className);
        $class  = implode('\\', $classArr);
        $class = str_replace('\\', '/', $class);

        include ($this->rootPath) . $class . '.php';
    }

    function viewRaw($file='', $data=[]) {
        $this->view($file, $data, 0, 0);
    }

    function view($file='', $data=[], $header=true, $footer=true) {
        if (!is_array($data)) {
            exit('$data is not array!');
        }
        extract($data);

        // 模板公共变量
        list($nowM, $nowC, $nowA) = $this->parseUrl();
        $baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" .$_SERVER['HTTP_HOST'].DIRECTORY_SEPARATOR;

        ob_start();
        ob_implicit_flush(0);

        // 加载模板
        if ($header) {
            include ($this->viewPath) . 'common/header.php';
        }
        include ($this->viewPath) . $file . '.php';
        if ($footer) {
            include $this->viewPath . 'common/footer.php';
        }

        echo ob_get_clean();
    }

    function notExist($name='', $type='') {
        $this->view('common/error', ['msg'=> $type.' : ' . $name. ' not found.']);
    }

    function parseUrl() {
        $module = 'framework';
        $c = $a = 'index';
        $params = [];

        if (strpos($_SERVER['REQUEST_URI'], 'index.php')) {
            if (isset($_REQUEST['module'])) $module=$_REQUEST['module'];
            if (isset($_REQUEST['controller'])) $c=$_REQUEST['controller'];
            if (isset($_REQUEST['action'])) $a=$_REQUEST['action'];
            $params = $_REQUEST;
        }else{//pathinfo
            /* 匹配出uri */
            if (strpos($_SERVER['REQUEST_URI'], '?')) {
                preg_match_all('/^\/(.*)\?/', $_SERVER['REQUEST_URI'], $uri);
            } else {
                preg_match_all('/^\/(.*)/', $_SERVER['REQUEST_URI'], $uri);
            }

            // 使用默认模块/控制器/操作逻辑
            if (!isset($uri[1][0]) || empty($uri[1][0])) {
                // CLI 模式不输出
                /*if ($entrance->app->runningMode === 'cli') {
                    $entrance->app->notOutput = true;
                }*/
                return;
            }
            $uri = $uri[1][0];

            /* 自定义路由判断 */
            if ($uri != ''){
                $uri = explode('/', $uri);
                switch (count($uri)) {
                    case 3:
                        $module     = $uri['0'];
                        $c = $uri['1'];
                        $a     = $uri['2'];
                        break;

                    case 2:
                        /*
                        * 使用默认模块
                        */
                        $c = $uri['0'];
                        $a     = $uri['1'];
                        break;
                    case 1:
                        /*
                        * 使用默认模块/控制器
                        */
                        $a = $uri['0'];
                        break;

                    default:
                        /*
                        * 使用默认模块/控制器/操作逻辑
                        */
                        break;
                }

                if (count($uri) > 2){
                    $params = array_slice($uri, 3);
                }
            }
        }

        return [$module, $c, $a, $params];
    }

    function getConfig(){
        return $configs = include $this->rootPath . 'config/common.php';

    }
    function response($data){
        echo json_encode($data);
    }
}