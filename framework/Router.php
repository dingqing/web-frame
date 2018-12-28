<?php

namespace Framework;

class Router
{
    static function parseUrl($m, $c, $a)
    {
        $params = [];

        if (strpos($_SERVER['REQUEST_URI'], 'index.php')) {
            if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
            if (isset($_REQUEST['c'])) $c = $_REQUEST['c'];
            if (isset($_REQUEST['a'])) $a = $_REQUEST['a'];
            $params = $_REQUEST;
        } else {//pathinfo
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
            if ($uri != '') {
                $uri = explode('/', $uri);
                $uriCount = count($uri);
                if ($uriCount > 2) $m = array_shift($uri);
                if ($uriCount > 1) $c = array_shift($uri);
                if ($uriCount > 0) $a = array_shift($uri);
                if ($uriCount > 3) $params = $uri;
            }
        }

        return [$m, $c, $a, $params];
    }
}