<?php

namespace Framework;

class ApiController
{
    public function __call($method, $b)
    {
        Log::write();
        Response::response('function : ' . $method . ' not found.');
    }
}