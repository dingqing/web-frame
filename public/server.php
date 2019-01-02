<?php
/*
 * swoole server file
 */

/**
 * Require framework
 */
include '../framework/App.php';

$app = new \Framework\App(dirname(__DIR__) . DIRECTORY_SEPARATOR);
$config            = \Framework\App::$configs;
$swooleConfig      = $config['swoole'];
$app->runningMode = 'swoole'; // set the app running mode

/**
 * Start the http server
 */
$http = new swoole_http_server('127.0.0.1', 8888);
$http->set($swooleConfig);

/**
 * monitor
 */
$http->on('request', function ($request, $response) use ($app) {
    try {
        // reject context
        $app::$container->set('request-swoole', $request);
        $app::$container->set('response-swoole', $response);
        // init router
        //$app::$container->get('router')->init($app);
        // response
        $app->responseSwoole(function () use ($response) {
            return $response;
        });
    } catch (CoreHttpException $e) {
        // exception
        $e->reponseSwoole();
    }
});

/**
 * start
 */
$http->start();
