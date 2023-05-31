<?php
/*
 * swoole server file
 */

/**
 * Require framework
 */
$app = require('../framework/swoole.php');
$config = $app::$container->getSingle('config');
$swooleConfig = $config->config['swoole'];
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
