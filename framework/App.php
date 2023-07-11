<?php
namespace Framework;

use Framework\Handles\Error;
use Framework\Handles\Env;
use Framework\Handles\Router;
use Framework\Handles\Config;
use Framework\Handles\Log;
use Framework\Handles\Nosql;
use Closure;

class App
{
    public static $rootPath;
    public static $container;

    public $runningMode = 'cli';

    private $notOutput = false;
    private $responseData='hello web-frame';

    public function __construct($rootPath, Closure $loader)
    {
        self::$rootPath = $rootPath;
        
        $loader(); // register aotoLoad functions
        Load::register($this);

        self::$container = new Container();
    }

    public function run(Closure $req)
    {
        self::$container->set('req', $req);
        
        $dh = opendir(self::$rootPath . 'framework/handles/');
        while ($file = readdir($dh) !== false) {
            if ($file == 'Handle') {continue;}
            basename($file)()->register($this);
        }
        closedir($dh);
    }

    public function response(Closure $closure)
    {
        register_shutdown_function([$this, 'responseShutdownFun'], $closure);
    }

    public function responseShutdownFun(Closure $closure)
    {
        if ($this->notOutput === true) {
            return;
        }
        if ($this->runningMode === 'cli') {
            $closure($this)->cliModeSuccess($this->responseData);
            return;
        }

        /*$useRest = self::$container->getSingle('config')
            ->config['rest_response'];

        if ($useRest) {
            $closure($this)->restSuccess($this->responseData);
        }
        $closure($this)->response($this->responseData);*/
    }
    
    public function responseSwoole(Closure $closure)
    {
        $closure()->header('Content-Type', 'Application/json');
        $closure()->header('Charset', 'utf-8');
        $closure()->end(json_encode($this->responseData));
    }
}
