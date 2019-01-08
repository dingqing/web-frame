<?php

namespace Framework\exceptions;

use Exception;
use SeasLog;

/**
 */
class CoreHttpException extends Exception
{
    /**
     * @var array
     */
    private $httpCode = [
        400 => 'Bad Request',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internet Server Error',
        503 => 'Service Unavailable'
    ];

    /**
     * @param int $code excption code
     */
    public function __construct($code = 200, $extra = '')
    {
        $this->code = $code;
        if (empty($extra)) {
            $this->message = $this->httpCode[$code];
            return;
        }
        $this->message = $extra . ' ' . $this->httpCode[$code];
    }

    /**
     * rest style http response
     *
     * @return json
     */
    public function reponse()
    {
        $data = [
            '__coreError' => [
                'code' => $this->getCode(),
                'message' => $this->getMessage(),
                'infomations' => [
                    'file' => $this->getFile(),
                    'line' => $this->getLine(),
                    'trace' => $this->getTrace(),
                ]
            ]
        ];

        // log
        SeasLog::debug(json_encode($data));

        // response
        header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @return json
     */
    public function reponseSwoole()
    {
        $data = [
            '__coreError' => [
                'code' => $this->getCode(),
                'message' => $this->getMessage(),
                'infomations' => [
                    'file' => $this->getFile(),
                    'line' => $this->getLine(),
                    'trace' => $this->getTrace(),
                ]
            ]
        ];

        // log
        SeasLog::debug(json_encode($data));

        // response
        $reponse = App::$container->get('response-swoole');
        $reponse->header('Content-Type', 'Application/json');
        $reponse->header('Charset', 'utf-8');
        $reponse->end(json_encode($data));
    }

    /**
     * @return json
     */
    public static function reponseErr($e)
    {
        $data = [
            '__coreError' => [
                'code' => 500,
                'message' => $e,
                'infomations' => [
                    'file' => $e['file'],
                    'line' => $e['line'],
                ]
            ]
        ];

        // log
        SeasLog::debug(json_encode($data));

        header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode($data));
    }

    /**
     *
     * @param  array $e
     * @return json
     */
    public static function reponseErrSwoole($e)
    {
        $data = [
            '__coreError' => [
                'code' => 500,
                'message' => $e,
                'infomations' => [
                    'file' => $e['file'],
                    'line' => $e['line'],
                ]
            ]
        ];

        // log
        SeasLog::debug(json_encode($data));

        $reponse = App::$container->get('response-swoole');
        $reponse->header('Content-Type', 'Application/json');
        $reponse->header('Charset', 'utf-8');
        $reponse->end(json_encode($data));
    }
}
