<?php 
/*入口常量，用于判断是否可以直接访问其他文件*/
define('ACCESS', TRUE);

/*目录常量*/
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', __DIR__.DS);
define('CORE_DIR', __DIR__.DS.'core'.DS);

/*加载配置*/
$configs = include ROOT_DIR . 'config/app.php';
define('VIEW_DIR', ROOT_DIR . $configs['viewDir'].DS);
$configsDb = include ROOT_DIR . 'config/db.php';

/*加载类文件*/
include CORE_DIR.'Base.php';// （框架和应用共同的）基类
spl_autoload_register('Base::autoload');//通用规则
include CORE_DIR.'Medoo.php';// 模型基类

/*处理请求*/
$init = new \core\Init($configs, $configsDb);
$init->run();
