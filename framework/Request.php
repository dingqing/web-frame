<?php

namespace Framework;

class Request
{
    static public function check($params)
    {
        foreach ($params as &$v) {
            $v = htmlspecialchars($v);
        }
        return $params;
    }
}
