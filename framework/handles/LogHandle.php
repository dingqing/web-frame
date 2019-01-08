<?php
/**
 * User: dingqing
 * Time: 19-1-8 下午4:47
 */

namespace Framework\Handles;

use Framework\App;
use SeasLog;

Class LogHandle implements Handle
{
    public function register(App $app)
    {
        // $env = App::$container->getSingle('env')->envParams;

        // SeasLog::setBasePath(App::$rootPath .$env['log']['path']);
    }
}