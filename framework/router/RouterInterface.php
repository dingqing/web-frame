<?php
namespace Framework\Router;

use Framework\Router\Router;

Interface RouterInterface
{
    /**
     * 路由方法
     *
     * @param void
     */
    public function route(Router $entrance);
}
