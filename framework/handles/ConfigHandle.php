<?php
/**
 * User: dingqing
 * Time: 19-1-8 下午3:50
 */

namespace Framework\Handles;

use Framework\App;

Class ConfigHandle implements Handle
{
    public function register(App $app)
    {
    	require(App::$rootPath . '/framework/helper.php');
    	
        $common = include App::$rootPath . 'config/common.php';
        $nosql = include App::$rootPath . 'config/nosql.php';
        $db = include App::$rootPath . 'config/db.php';
        $this->config = array_merge($common, $nosql, $db);

        App::$container->setSingle('config', $this);
    }
}