<?php
//load base file
include 'App.php';

//deal with request
$app = new \Framework\App(dirname(__DIR__) . DIRECTORY_SEPARATOR);
$app->run();