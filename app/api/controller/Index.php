<?php

namespace App\Api\Controller;
use Framework\App;

class Index extends App
{
	function __construct($model) {
	    parent::__construct();
		$this->model = $model;
	}

    function index() {
        $this->response(['success.']);
    }
}