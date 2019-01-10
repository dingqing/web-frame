<?php

use Framework\Handles\ErrorHandle;
use Framework\Handles\EnvHandle;
use Framework\Handles\RouterSwooleHandle;
use Framework\Handles\ConfigHandle;
use Framework\Handles\LogHandle;
use Framework\Handles\NosqlHandle;
use Framework\Exceptions\CoreHttpException;
use Framework\Request;

/**
 * Require framework
 */
require(__DIR__ . '/App.php');

try {
    $app = new Framework\App(__DIR__ . '/../', function () {
        return require(__DIR__ . '/Load.php');
    });
    $app->runningMode = 'cli';

    $app->load(function () {
        return new EnvHandle();
    });

    $app->load(function () {
        return new ConfigHandle();
    });

    $app->load(function () {
        return new LogHandle();
    });

    $app->load(function () {
        return new ErrorHandle();
    });

    $app->load(function () {
        return new ErrorHandle();
    });

    $app->load(function () {
        return new NosqlHandle();
    });

    $app->load(function () {
        return new RouterSwooleHandle();
    });

    /**
     * Start framework
     */
    $app->run(function () use ($app) {
        return new Request($app);
    });

    return $app;

} catch (CoreHttpException $e) {
    /**
     * 捕获异常
     *
     * Catch exception
     */
    $e->reponse();
}
