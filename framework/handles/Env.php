<?php
/**
 * User: dingqing
 * Time: 2019-1-8 下午3:40
 */

namespace Framework\Handles;

use Framework\App;

Class Env implements Handle
{
    public function register(App $app)
    {
        $env = parse_ini_file(App::$rootPath . '.env', true);
        if ($env === false) {
            throw CoreHttpException('load env fail', 500);
        }
        $this->envParams = array_merge($_ENV, $env);

        App::$container->setSingle('env', $this);
    }
}