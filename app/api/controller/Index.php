<?php

namespace App\Api\Controller;

use App\Controller;
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