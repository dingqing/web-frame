<?php
/**
 * User: dingqing
 * Time: 2019-1-8 下午3:39
 */

namespace Framework\Handles;

use Framework\App;

interface Handle
{
    public function register(App $app);
}