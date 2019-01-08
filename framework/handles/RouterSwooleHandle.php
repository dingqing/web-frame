<?php

namespace Framework\Handles;

use Framework\App;

class RouterSwooleHandle implements Handle
{
    public function register(App $app)
    {
        App::$container->setSingle('router', $this);
    }
}
