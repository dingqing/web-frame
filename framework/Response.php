<?php

namespace Framework;

class Response
{
    public static function response($msg = '', $data = [], $code = 200)
    {
        echo json_encode([
            'msg' => $msg,
            'data' => $data,
            'code' => $code,
        ]);
    }

    public function restSuccess($response)
    {
        header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode([
            'code' => 200,
            'message' => 'OK',
            'result' => $response
        ], JSON_UNESCAPED_UNICODE)
        );
    }

    public static function responseErr($msg)
    {
        View::load('common/error', ['msg' => $msg]);
    }
}
