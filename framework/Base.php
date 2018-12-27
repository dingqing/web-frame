<?php

namespace Framework;

class Base
{
    function __call($method, $b) {
        $this->notExist($method, 'function');
    }
    // 规则：命名空间和目录名保持同名
    static function autoload($class) {
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

        (new self)->requireFile(ROOT_DIR . $class . '.php');
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
        list($nowC, $nowA) = $this->parseUrl();
        $baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" .$_SERVER['HTTP_HOST'].DS;

        ob_start();
        ob_implicit_flush(0);

        // 加载模板
        if ($header) {
            $this->requireFile(VIEW_DIR . 'common/header.php', 'header file', 0);
            include VIEW_DIR . 'common/header.php';
        }
        $this->requireFile(VIEW_DIR . $file . '.php', 'template file', 0);
        include VIEW_DIR . $file . '.php';
        if ($footer) {
            $this->requireFile(VIEW_DIR . 'common/footer.php', 'footer file', 0);
            include VIEW_DIR . 'common/footer.php';
        }

        echo ob_get_clean();
    }

    function requireFile($fileUrl='', $type='', $include=true) {
        if(!file_exists($fileUrl)) {
            $this->notExist($fileUrl, $type);
        }
        if ($include) {
            include $fileUrl;
        }
    }
    
    function notExist($name='', $type='') {
        $this->view('common/error', ['msg'=> $type.' : ' . $name. ' not found.']);
    }

    function parseUrl() {
        $c = $a = 'index';

        if (strpos($_SERVER['REQUEST_URI'], 'index.php')) {
            if (isset($_REQUEST['controller'])) $c=$_REQUEST['controller'];
            if (isset($_REQUEST['action'])) $a=$_REQUEST['action'];
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
                }
                return;*/
            }
            $uri = $uri[1][0];

            /* 自定义路由判断 */
            if ($uri != ''){
                $uri = explode('/', $uri);
                switch (count($uri)) {
                    case 3:
                        //$entrance->moduleName     = $uri['0'];
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
            }
        }

        return [$c, $a];
    }

    function response($data){
        echo json_encode($data);
    }
}