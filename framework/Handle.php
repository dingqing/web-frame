<?php

namespace Framework;

class Handle
{
    static function _error_handler($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            $errorType = 'My ERROR';
        }else{
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

        echo "<b>$errorType</b> [$errno] $errstr<br />\n";
        echo " on line $errline in file $errfile<br />\n";
        echo "PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...";
        exit(1);

        /* Don't execute PHP internal error handler */
        return true;
    }
    static function _exception_handler($exception) {
        echo json_encode([
            'code'       => $exception->getCode(),
            'message'    => $exception->getMessage(),
            'file'       => $exception->getFile(),
            'line'       => $exception->getLine(),
            'trace'      => $exception->getTrace(),
            'previous'   => $exception->getPrevious()
        ]);
    }
    static function _shutdown(){
        //echo 'shutdown';
    }

    static function call(){
        set_error_handler('self::_error_handler');
        set_exception_handler('self::_exception_handler');
        //register_shutdown_function('self::_shutdown');
    }
}