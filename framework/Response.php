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
}
