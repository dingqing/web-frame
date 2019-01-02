<?php

namespace App\Demo\Controller;

use Framework\App;
use Framework\Controller;
use Framework\View;

class Index extends Controller
{
    function index()
    {
        View::load('demo/index');
    }

    function doc($params = '')
    {
        $redis = App::$container->getSingle('redis');
        $redis->set("redisK", "E-PHP redis example");

        $tickets = $this->model->select("tickets", 'ticket', [
            "status" => 2,
        ]);

        View::load('demo/doc', [
            'redisK' => $redis->get("redisK"),
            'tickets' => $tickets,
        ]);
    }

    public function about()
    {
        View::load('demo/about');
    }
}