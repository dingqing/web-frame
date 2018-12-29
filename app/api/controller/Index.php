<?php

namespace App\Api\Controller;

use Framework\ApiController;
use Framework\Response;

class Index extends ApiController
{
    function hello(){
        return 'Hello E-PHP';
    }

    function index()
    {
        Response::response('success.');
    }
}