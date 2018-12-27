<?php

namespace Framework;

class App
{
    public $rootPath;
    public $viewPath;
    public $configs;

    public $module;
    public $controller;
    public $action;
    public $params;

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

        list($this->module, $this->controller, $this->action, $this->params) = Router::parseUrl();

        //exception and error handle
        ErrorHandle::call();

        $this->dispatch();
    }

    public function dispatch() {
        $c = ucfirst($this->controller);

        $m = 'App\\'.$this->module.'\\Model\\'.$c;
        $configs = $this->configs;
        $model = new $m($configs['db']);

        // 执行方法
        $contro = 'App\\'.$this->module.'\\Controller\\'.$c;
        $contro = new $contro($model);

        call_user_func_array([$contro, $this->action], $this->params);
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

        include ($this->rootPath . $class . '.php');
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
        $module = $this->module;
        $controller = $this->controller;
        $action = $this->action;

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

    function getConfig(){
        return $configs = include $this->rootPath . 'config/common.php';

    }
    function response($data){
        echo json_encode($data);
    }
}