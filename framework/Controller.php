<?php

namespace Framework;

class Controller
{
    public function __call($method, $b)
    {
        Log::write();
        View::load('common/error', ['msg' => 'function : ' . $method . ' not found.']);
    }
}