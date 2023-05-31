<?php
namespace Framework\Handles;

use Framework\App;
use Framework\Response;

Class Error implements Handle
{
    function register(App $app)
    {
        set_error_handler([$this, '_error_handler']);
        set_exception_handler([$this, '_exception_handler']);
        register_shutdown_function([$this, '_shutdown']);
    }

    function _error_handler($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            $errorType = 'My ERROR';
        } else {
            switch ($errno) {
                case E_USER_ERROR:
                    $errorType = 'My ERROR';
                    break;
                case E_USER_WARNING:
                    $errorType = 'My WARNING';
                    break;
                case E_USER_NOTICE:
                    $errorType = 'My NOTICE';
                    break;
                default:
                    $errorType = 'Unknown error type';
                    break;
            }
        }

        Response::response(
            "$errorType [$errno]<br/>" .
            "$errstr<br/>" .
            "on line $errline in file $errfile"
        );
        exit(1);

        // don't execute PHP internal error handler 
        return true;
    }

    function _exception_handler($exception)
    {
        Response::response(
            'code: ' . $exception->getCode() . '<br/>' .
            'message: ' . $exception->getMessage() . '<br/>' .
            'file: ' . $exception->getFile() . '<br/>' .
            'line: ' . $exception->getLine() . '<br/>' .
            'trace: ' . json_encode($exception->getTrace()) . '<br/>' .
            'previous: ' . $exception->getPrevious()
        );
    }

    function _shutdown()
    {
        $error = error_get_last();
        if ($error) {
            Response::response(
                'type: ' . $error['type'] . '<br/>' .
                'message: ' . $error['message'] . '<br/>' .
                'file: ' . $error['file'] . '<br/>' .
                'line: ' . $error['line']
            );
        }
    }
}