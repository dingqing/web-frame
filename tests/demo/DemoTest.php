<?php

namespace Tests\Demo;

use Tests\TestCase;
use Framework\App;

class DemoTest extends TestCase
{
    public function testDemo()
    {
        $this->assertEquals(
            'Hello php-frame',
            App::$app->get('api/index/index')
        );
    }
}
