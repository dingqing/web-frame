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
        $this->config = include App::$rootPath . 'config/common.php';

        App::$container->setSingle('config', $this);
    }
}