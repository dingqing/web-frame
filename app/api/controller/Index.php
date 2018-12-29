<?php

namespace App\Api\Controller;

use Framework\ApiController;
use Framework\Response;

class Index extends ApiController
{
    function index()
    {
        Response::response('success.');
    }
}