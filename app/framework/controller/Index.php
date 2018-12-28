<?php

namespace App\Framework\Controller;

use Framework\Controller;
use Framework\View;

class Index extends Controller
{
    function __construct($model)
    {
        $this->model = $model;
    }

    function index()
    {
        View::load('framework/index');
    }

    function doc($params = '')
    {
        $tickets = $this->model->select("tickets", 'ticket', [
            "status" => 2,
        ]);
        View::load('framework/doc', ['tickets' => $tickets]);
    }

    public function about()
    {
        View::load('framework/about');
    }
}