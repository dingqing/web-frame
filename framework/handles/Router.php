<?php

namespace Framework\Handles;

use Framework\App;
use Framework\Router\RouterStart;
Class Router implements Handle
{
    public function register(App $app)
    {
        (new RouterStart())->init($app);
    }
}