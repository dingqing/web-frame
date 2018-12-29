<?php

namespace App\Framework\Controller;

use Framework\App;
use Framework\Controller;
use Framework\View;

class Index extends Controller
{
    function index()
    {
        View::load('framework/index');
    }

    function doc($params = '')
    {
        $redis = App::$container->getSingle('redis');
        $redis->set("redisK", "E-PHP redis example");

        $tickets = $this->model->select("tickets", 'ticket', [
            "status" => 2,
        ]);

        View::load('framework/doc', [
            'redisK' => $redis->get("redisK"),
            'tickets' => $tickets,
        ]);
    }

    public function about()
    {
        View::load('framework/about');
    }
}