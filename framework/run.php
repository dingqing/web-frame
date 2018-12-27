<?php
/*目录常量*/
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(__DIR__).DS);
define('FRAMEWORK_DIR', __DIR__.DS);

/*加载类文件*/
include FRAMEWORK_DIR.'Base.php';// （框架和应用共同的）基类
spl_autoload_register('Framework\Base::autoload');//通用规则
require ROOT_DIR.'vendor/autoload.php';

/*加载配置*/
$configs = include ROOT_DIR . 'config/common.php';
define('VIEW_DIR', ROOT_DIR .$configs['viewDir'].DS);

/*处理请求*/
$app = new \Framework\Init($configs);
$app->run();