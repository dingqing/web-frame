<?php

namespace App\Api\Controller;

use Framework\ApiController;
use Framework\Response;

class Index extends ApiController
{
    function __construct($model)
    {
        $this->model = $model;
    }

    function index()
    {
        Response::response('success.');
    }
}