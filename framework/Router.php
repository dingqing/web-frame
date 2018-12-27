<?php

namespace Framework;

class Router
{
    static function parseUrl() {
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
            //if (!isset($uri[1][0]) || empty($uri[1][0])) {
            // CLI 模式不输出
            /*if ($entrance->app->runningMode === 'cli') {
                $entrance->app->notOutput = true;
            }*/
            //return;
            //}
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
}