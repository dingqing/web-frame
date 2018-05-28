<?php 
if (!defined('ACCESS')) exit('bad request!');

class Base
{
    function __call($method, $b) {
        $this->notExist($method, 'function');
    }
    // 规则：命名空间和目录名保持同名
    static function autoload($class) {
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

        // 公共变量
        list($nowC, $nowA) = $this->parseUrl();
        $baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" .$_SERVER['HTTP_HOST'].DS;
        $viewUrl = $baseUrl.'static'.DS;

        ob_start();
        ob_implicit_flush(0);

        // 加载模板
        if ($header) {
            $this->requireFile(VIEW_DIR . 'header.php', 'header file', 0);
            include VIEW_DIR . 'header.php';
        }
        $this->requireFile(VIEW_DIR . $file . '.php', 'template file', 0);
        include VIEW_DIR . $file . '.php';
        if ($footer) {
            $this->requireFile(VIEW_DIR . 'footer.php', 'footer file', 0);
            include VIEW_DIR . 'footer.php';
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
        exit('Not exsit '.$type.' : ' . $name);
    }

    function parseUrl() {
        $c = $a = 'index';

        $_SERVER['REQUEST_URI'] = str_replace('/index.php', '', $_SERVER['REQUEST_URI']);
        
        $parsed = pathinfo($_SERVER['REQUEST_URI']);
        // var_dump($parsed);die;
        if (isset($parsed['dirname']) && $parsed['dirname'] != '/' && $parsed['dirname'] != '.') {
            $c = trim($parsed['dirname'], '/');
            $a = $parsed['basename'];
        }

        // 解析url：$_GET
        if (isset($_REQUEST['r'])) {
            $action = $_REQUEST['r'];
            $actions = explode('/', $action);
            if (isset($actions[0])&&$actions[0]) {
                $c = $actions[0];
            }
            if (isset($actions[1])&&$actions[1]) {
                $a = $actions[1];
            }
        }

        return [$c, $a];
    }
}