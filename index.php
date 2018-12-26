<?php 
xhprof_enable();

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


$xhprof_data = xhprof_disable();

// display raw xhprof data for the profiler run
print_r($xhprof_data);


include_once  "xhprof_lib.php";
include_once  "xhprof_runs.php";

// save raw data for this profiler run using default
// implementation of iXHProfRuns.
$xhprof_runs = new XHProfRuns_Default();

// save the run under a namespace "xhprof_foo"
$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");

echo "---------------\n".
     "Assuming you have set up the http based UI for \n".
     "XHProf at some address, you can view run at \n".
     "http://<xhprof-ui-address>/index.php?run=$run_id&source=xhprof_foo\n".
     "---------------\n";