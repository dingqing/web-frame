<?php

namespace Framework;

use Closure;

class App
{
    public static $rootPath;
    public static $container;

    public $runningMode = 'fpm';

    private $notOutput = false;
    private $responseData='hello e-php';

    public function __construct($rootPath, Closure $loader)
    {
        self::$rootPath = $rootPath;

        $loader(); // require Load file
        Load::register($this);

        // register services
        self::$container = new Container();
    }

    public function load(Closure $handle)
    {
        $this->handlesList[] = $handle;
    }

    public function run(Closure $request)
    {
        self::$container->set('request', $request);

        foreach ($this->handlesList as $handle) {
            $handle()->register($this);
        }
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
