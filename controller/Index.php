<?php

namespace Controller;
use Framework\Base;

class Index extends Base
{
	function __construct($model) {
		$this->model = $model;
	}

    function index() {
        $this->view('welcome');
    }

    function doc() {
    	$this->view('doc');
    }

    function hello() {
    	$tickets = $this->model->select("tickets", 'ticket', [
            "status" => 2,
        ]);
        $this->view('hello', ['tickets'=>$tickets]);
    }
}