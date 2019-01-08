<?php

namespace App\Api\Controller;

use Framework\Controller;
use Framework\Response;

class Index extends Controller
{
    function hello()
    {
        return 'Hello E-PHP';
    }

    function index()
    {
        Response::response('success.');
    }
}