<?php
namespace Framework;

use Framework\App;
use Framework\Exceptions\CoreHttpException;

class Request
{
    private $headerParams = [];
    private $serverParams = [];
    private $requestParams = [];
    private $getParams = [];
    private $postParams = [];
    private $cookie = [];
    private $file = [];
    private $method = '';
    private $serverIp = '';
    private $clientIp = '';
    private $beginTime = 0;
    private $endTime = 0;
    private $consumeTime = 0;
    private $requestId = '';

    public function __construct(App $app)
    {
        // swoole mode
        if ($app->runningMode === 'swoole') {
            $swooleRequest = $app::$container->get('request-swoole');
            $this->headerParams  = $swooleRequest->header;
            $this->serverParams  = $swooleRequest->server;
            $this->method        = $this->serverParams['request_method'];
            $this->serverIp      = $this->serverParams['server_addr'];
            $this->clientIp      = $this->serverParams['remote_addr'];
            $this->beginTime     = $this->serverParams['request_time_float'];
            $this->getParams     = isset($swooleRequest->get)? $swooleRequest->get: [];
            $this->postParams    = isset($swooleRequest->post)? $swooleRequest->post: [];
            $this->cookie        = isset($swooleRequest->cookie)? $swooleRequest->cookie: [];
            $this->file          = isset($swooleRequest->files)? $swooleRequest->files: [];
            $this->requestParams = array_merge($this->getParams, $this->postParams);
            return;
        }

        $this->serverParams = $_SERVER;
        $this->method       = isset($_SERVER['REQUEST_METHOD'])? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
        $this->serverIp     = isset($_SERVER['SERVER_ADDR'])? $_SERVER['SERVER_ADDR'] : '';
        $this->clientIp     = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR'] : '';
        $this->beginTime    = isset($_SERVER['REQUEST_TIME_FLOAT'])? $_SERVER['REQUEST_TIME_FLOAT'] : microtime(true);
        if ($app->runningMode === 'cli') {
            // cli 模式
            $this->requestParams = isset($_REQUEST['argv'])? $_REQUEST['argv']: [];
            $this->getParams     = isset($_REQUEST['argv'])? $_REQUEST['argv']: [];
            $this->postParams    = isset($_REQUEST['argv'])? $_REQUEST['argv']: [];
            return;
        }

        $this->requestParams = $_REQUEST;
        $this->getParams     = $_GET;
        $this->postParams    = $_POST;
        
    }

    /**
     * 魔法函数__get.
     *
     * @param string $name 属性名称
     *
     * @return mixed
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set.
     *
     * @param string $name  属性名称
     * @param mixed  $value 属性值
     *
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    /**
     * 获取GET参数
     *
     * @param  string  $value      参数名
     * @param  string  $default    默认值
     * @param  boolean $checkEmpty 值为空时是否返回默认值，默认true
     * @return mixed
     */
    public function get($value = '', $default = '', $checkEmpty = true)
    {
        if (! isset($this->getParams[$value])) {
            return '';
        }
        if (empty($this->getParams[$value]) && $checkEmpty) {
            return $default;
        }
        return htmlspecialchars($this->getParams[$value]);
    }

    /**
     * 获取POST参数
     *
     * @param  string  $value      参数名
     * @param  string  $default    默认值
     * @param  boolean $checkEmpty 值为空时是否返回默认值，默认true
     * @return mixed
     */
    public function post($value = '', $default = '', $checkEmpty = true)
    {
        if (! isset($this->postParams[$value])) {
            return '';
        }
        if (empty($this->getParams[$value]) && $checkEmpty) {
            return $default;
        }
        return htmlspecialchars($this->postParams[$value]);
    }

    /**
     * 获取REQUEST参数
     *
     * @param  string  $value      参数名
     * @param  string  $default    默认值
     * @param  boolean $checkEmpty 值为空时是否返回默认值，默认true
     * @return mixed
     */
    public function request($value = '', $default = '', $checkEmpty = true)
    {
        if (! isset($this->requestParams[$value])) {
            return '';
        }
        if (empty($this->getParams[$value]) && $checkEmpty) {
            return $default;
        }
        return htmlspecialchars($this->requestParams[$value]);
    }

    /**
     * 获取所有参数
     *
     * @return array
     */
    public function all()
    {
        $res = array_merge($this->postParams, $this->getParams);
        foreach ($res as &$v) {
            $v = htmlspecialchars($v);
        }
        return $res;
    }

    /**
     * 获取SERVER参数
     *
     * @param  string $value 参数名
     * @return mixed
     */
    public function server($value = '')
    {
        if (isset($this->serverParams[$value])) {
            return $this->serverParams[$value];
        }
        return '';
    }

    /**
     * 参数验证
     *
     * 支持必传参数验证，参数长度验证，参数类型验证
     *
     * @param  string $paramName 参数名
     * @param  string $rule      规则
     * @return mixed
     */
    public function check($paramName = '', $rule = '', $length = 0)
    {
        if (! is_int($length)) {
            throw new CoreHttpException(
                400,
                'length type is not int'
            );
        }

        if ($rule === 'require') {
            if (! empty($this->request($paramName))) {
                return;
            }
            throw new CoreHttpException(404, "param {$paramName}");
        }

        if ($rule === 'length') {
            if (strlen($this->request($paramName)) === $length) {
                return;
            }
            throw new CoreHttpException(
                400,
                "param {$paramName} length is not {$length}"
            );
        }

        if ($rule === 'number') {
            if (is_numeric($this->request($paramName))) {
                return;
            }
            throw new CoreHttpException(
                400,
                "{$paramName} type is not number"
            );
        }
    }
}
