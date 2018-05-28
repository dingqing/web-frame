<?php 
namespace core;

if (!defined('ACCESS')) exit('bad request!');

class Init extends \Base{
	private $configs;
	private $configsDb;

	function __construct(Array $configs=[], Array $configsDb) {
		$this->configs = $configs;
		$this->configsDb = $configsDb;
	}

	public function run() {
		// set_error_handler('myErrorHandler');
		// $f=4/0;
		// trigger_error("Incorrect input vector, array of values expected", E_USER_WARNING);
		// set_exception_handler('_exception_handler');
		// register_shutdown_function('_shutdown_handler');

		$this->dispatch();
	}

	public function dispatch() {
		list($c, $a) = $this->parseUrl();
		$c = ucfirst($c);
		
		// 执行方法
		$contro = 'controller\\'.$c;
		$m = 'model\\'.$c;
		$model = new $m($this->configsDb);
		$contro = new $contro($model);
		/*if (!method_exists($contro, $a)) {
			$this->notExist($a, 'controller\\'.$c.' function');
		}*/
		$contro->$a();
	}
}