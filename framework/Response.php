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

    public static function responseErr($msg)
    {
        View::load('common/error', ['msg' => $msg]);
    }
}
