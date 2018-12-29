<?php
//load base file
include 'App.php';
require '../vendor/autoload.php';

//deal with request
$app = new \Framework\App();
$app->run();