<?php 

namespace Framework;

class Init extends Base{
	private $configs;

	function __construct(Array $configs) {
        $this->configs = $configs;
    }

	public function run() {
        set_error_handler([$this,'_error_handler']);
        set_exception_handler([$this,'_exception_handler']);
        register_shutdown_function([$this,'shutdown']);

		$this->dispatch();
	}

    public function dispatch() {
        list($c, $a) = $this->parseUrl();
        $c = ucfirst($c);

        // 执行方法
        $m = 'model\\'.$c;
        $configs = $this->configs;
        $model = new $m($configs['db']);

        $contro = 'controller\\'.$c;
        $contro = new $contro($model);
        $contro->$a();
    }

    function _error_handler($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
            echo "  Fatal error on line $errline in file $errfile";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            echo "Aborting...<br />\n";
            exit(1);
        }

        switch ($errno) {
            case E_USER_ERROR:
                echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
                echo "  Fatal error on line $errline in file $errfile";
                echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                echo "Aborting...<br />\n";
                exit(1);
                break;

            case E_USER_WARNING:
                echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
                break;

            case E_USER_NOTICE:
                echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
                break;

            default:
                echo "Unknown error type: [$errno] $errstr<br />\n";
                break;
        }

        /* Don't execute PHP internal error handler */
        return true;
    }
    function _exception_handler($exception)
    {
        $data = [
            'code'       => $exception->getCode(),
            'message'    => $exception->getMessage(),
            'file'       => $exception->getFile(),
            'line'       => $exception->getLine(),
            'trace'      => $exception->getTrace(),
            'previous'   => $exception->getPrevious()
        ];
        $this->response($data);
    }

    function shutdown($value=''){
        // echo 3;
    }
}