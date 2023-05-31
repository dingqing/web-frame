<?php

namespace Framework\Handles;

use Framework\App;

class RouterSwoole implements Handle
{
    public function register(App $app)
    {
        App::$container->setSingle('router', $this);
    }
}
