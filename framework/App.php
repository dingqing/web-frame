<?php

namespace Framework;

use Closure;

class App
{
    public static $rootPath;

    private $notOutput = false;
    public static $container;

    public $runningMode = 'fpm';
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

    /**
     * inner call get
     */
    public function get($uri = '', $argus = array())
    {
        return $this->callSelf('get', $uri, $argus);
    }

    public function post($uri = '', $argus = array())
    {
        return $this->callSelf('post', $uri, $argus);
    }

    public function put($uri = '', $argus = array())
    {
        return $this->callSelf('put', $uri, $argus);
    }

    public function delete($uri = '', $argus = array())
    {
        return $this->callSelf('delete', $uri, $argus);
    }

    public function callSelf($method = '', $uri = '', $argus = array())
    {
        $requestUri = explode('/', $uri);
        if (count($requestUri) !== 3) {
            throw new CoreHttpException(400);
        }

        $router = self::$container->get('router');
        $router->module = $requestUri[0];
        $router->controller = $requestUri[1];
        $router->action = $requestUri[2];
        $router->register($this, 'microService');
        return $this->responseData;
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
