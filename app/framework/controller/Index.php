<?php

namespace App\Framework\Controller;
use Framework\App;

class Index extends App
{
	function __construct($model) {
	    parent::__construct();
		$this->model = $model;
	}

    function index() {
        $this->view('framework/index');
    }

    function doc() {
        $tickets = $this->model->select("tickets", 'ticket', [
            "status" => 2,
        ]);
        $this->view('framework/doc', ['tickets'=>$tickets]);
    }
}