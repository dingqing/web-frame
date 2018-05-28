<?php 
namespace controller;

if (!defined('ACCESS')) exit('bad request!');

class Index extends \Base
{
	function __construct($model) {
		$this->model = $model;
	}

    function index($value='') {
        $this->view('core/welcome');
    }

    function doc($value='') {
    	$this->view('core/doc');
    }

    function hello() {
    	$tickets = $this->model->select("tickets", 'ticket', [
            "status" => 2,
        ]);
        $this->view('core/hello', ['tickets'=>$tickets]);
    }
}