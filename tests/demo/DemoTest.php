<?php

namespace Tests\Demo;

use Tests\TestCase;
use Framework\App;

class DemoTest extends TestCase
{
    public function testDemo()
    {
        $this->assertEquals(
            'Hello E-PHP',
            App::$app->get('api/index/hello')
        );
    }
}
