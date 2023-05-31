<?php
namespace Framework\Router;

use Framework\App;
use Framework\Router\Router;
use Framework\Exceptions\CoreHttpException;
// use ReflectionClass;
use Closure;

class RouterStart implements Router
{
    private $app;
    private $config;
    private $req;
    private $module = '';
    private $controller = '';
    private $actionName = '';
    private $classPath = '';
    private $executeType = 'controller';
    private $reqUri = '';
    private $routeStrategy = '';
    private $routeStrategyMap = [
        'general'      => 'Framework\Router\General',
        'pathinfo'     => 'Framework\Router\Pathinfo',
        'user-defined' => 'Framework\Router\Userdefined',
        'micromonomer' => 'Framework\Router\Micromonomer',
        'job'          => 'Framework\Router\Job'
    ];

    public function __get($name = '')
    {
        return $this->$name;
    }
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    public function init(App $app)
    {
        $app::$container->set('router', $this);
        $this->req        = $app::$container->get('req');
        $this->reqUri     = $this->req->server('REQUEST_URI');
        $this->app            = $app;
        $this->config         = $app::$container->getSingle('config');

        list($this->module,$this->controller,$this->actionName) = $this->config->config['route']
        $this->strategyJudge();
        (new $this->routeStrategyMap[$this->routeStrategy])->route($this);
        $this->makeClassPath($this);
        if ((new $this->routeStrategyMap['user-defined'])->route($this)) {
            return;
        }
        $this->start();
    }

    public function strategyJudge()
    {
        // 路由策略
        if (! empty($this->routeStrategy)) {
            return;
        }

        // 任务路由
        if ($this->app->runningMode === 'cli' && $this->req->get('router_mode') === 'job') {
            $this->routeStrategy = 'job';
            return;
        }

        // 普通路由
        if (strpos($this->reqUri, 'index.php') || $this->app->runningMode === 'cli') {
            $this->routeStrategy = 'general';
            return;
        }
        $this->routeStrategy = 'pathinfo';
    }

    public function makeClassPath()
    {
        // 任务类
        if ($this->routeStrategy === 'job') {
            return;
        }

        // 获取控制器类
        $controller    = ucfirst($this->controller);
        $folderName        = ucfirst($this->config->config['application_folder']);
        echo "classPath: {$folderName}\\{$this->module}\\Controllers\\{$controller}";
        $this->classPath   = "{$folderName}\\{$this->module}\\Controllers\\{$controller}";
    }

    public function start()
    {
        // 判断模块存不存在
        if (! in_array(strtolower($this->module), $this->config->config['module'])) {
            throw new CoreHttpException(404, 'Module:'.$this->module);
        }

        // 判断控制器存不存在
        if (! class_exists($this->classPath)) {
            throw new CoreHttpException(404, "{$this->executeType}:{$this->classPath}");
        }

        // 反射解析当前控制器类　
        // 判断是否有当前操作方法
        // 不使用反射
        // $reflaction     = new ReflectionClass($controllerPath);
        // if (!$reflaction->hasMethod($this->actionName)) {
        //     throw new CoreHttpException(404, 'Action:'.$this->actionName);
        // }

        // 实例化当前控制器
        $controller = new $this->classPath();
        if (! is_callable([$controller, $this->actionName])) {
            throw new CoreHttpException(404, 'Action:'.$this->actionName);
        }

        // 调用操作
        $actionName = $this->actionName;
echo '$controller->$actionName: '.$controller.$actionName;
        // 获取返回值
        $this->app->responseData = $controller->$actionName();
    }
}
