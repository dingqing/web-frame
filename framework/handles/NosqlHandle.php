<?php
/**
 * User: dingqing
 * Time: 19-1-8 下午4:02
 */

namespace Framework\Handles;

use Framework\App;

Class NosqlHandle implements Handle
{
    public function register(App $app)
    {
        $nosqls = ['redis'];
        foreach ($nosqls as $v) {
            $className = 'Framework\Storage\\' . ucfirst($v);
            App::$container->setSingle($v, function () use ($className) {
                // lazy load
                return $className::init();
            });
        }
    }
}