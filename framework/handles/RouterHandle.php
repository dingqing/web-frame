<?php

namespace Framework\Handles;

use Framework\App;
use Framework\Request;

Class RouterHandle implements Handle
{
    public $module = '';
    public $controller = '';
    public $action = '';
    public $params = [];

    public function register(App $app)
    {
        App::$container->setSingle('router', $this);

        $this->parseUrl();

        /* dispatch */
        $c = 'App\\' . $this->module . '\\Controller\\' . $this->controller;
        $c = new $c();
        call_user_func_array([$c, $this->action], $this->params);
    }

    public function parseUrl()
    {
        $params = [];

        $configs = App::$container->getSingle('config')->config;
        list($m, $c, $a) = [$configs['defaultModule'], $configs['defaultController'], $configs['defaultAction']];

        if (php_sapi_name() == 'cli') {
            $m = 'api';
        } else {
            if (strpos($_SERVER['REQUEST_URI'], 'index.php')) {
                if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
                if (isset($_REQUEST['c'])) $c = $_REQUEST['c'];
                if (isset($_REQUEST['a'])) $a = $_REQUEST['a'];
                $params = $_REQUEST;
            } else {//pathinfo
                $questionMark = strpos($_SERVER['REQUEST_URI'], '?') ? '\?' : '';
                preg_match_all('/^\/(.*)' . $questionMark . '/', $_SERVER['REQUEST_URI'], $uri);

                $uri = $uri[1][0];

                if ($uri != '') {
                    $uri = explode('/', $uri);
                    $uriCount = count($uri);
                    if ($uriCount > 2) $m = array_shift($uri);
                    if ($uriCount > 1) $c = array_shift($uri);
                    if ($uriCount > 0) $a = array_shift($uri);
                    if ($uriCount > 3) $params = $uri;
                }
            }

            //check params
            Request::check($params);
        }

        $c = ucfirst($c);
        list($this->module, $this->controller, $this->action, $this->params) = [$m, $c, $a, $params];
    }
}