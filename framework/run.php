<?php
/*加载类文件*/
include 'App.php';
require '../vendor/autoload.php';

/*处理请求*/
$app = new \Framework\App();
$app->run();