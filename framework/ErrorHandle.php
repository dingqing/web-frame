<?php

namespace Framework;

class ErrorHandle
{
    function register()
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

        $msg = "<b>$errorType</b> [$errno] $errstr<br />" . PHP_EOL
            . " on line $errline in file $errfile";
        View::load('common/error', ['msg' => $msg]);
        exit(1);

        /* Don't execute PHP internal error handler */
        return true;
    }

    function _exception_handler($exception)
    {
        $msg = json_encode([
            'code'     => $exception->getCode(),
            'message'  => $exception->getMessage(),
            'file'     => $exception->getFile(),
            'line'     => $exception->getLine(),
            'trace'    => $exception->getTrace(),
            'previous' => $exception->getPrevious()
        ]);
        View::load('common/error', ['msg' => $msg]);
    }

    function _shutdown()
    {
        $error = error_get_last();
        if ($error) {
            View::load('common/error', ['msg' => json_encode([
                'type'    => $error['type'],
                'message' => $error['message'],
                'file'    => $error['file'],
                'line'    => $error['line'],
            ])]);
        }
    }
}