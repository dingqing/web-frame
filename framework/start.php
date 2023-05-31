<?php
use Framework\Exceptions\CoreHttpException;
use Framework\Request;
use Framework\Response;

include __DIR__ . '/App.php';
try {
    $app = new Framework\App(dirname(__DIR__) . DIRECTORY_SEPARATOR, function () {
        return require(__DIR__ . '/Load.php');
    });
    $app->run(function () use ($app) {
        return new Request($app);
    });
    $app->response(function ($app) {
        return new Response($app);
    });
} catch (CoreHttpException $e) {
    $e->reponse();
}
