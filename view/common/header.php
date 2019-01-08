<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PHP</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>css/bootstrap.min.css"/>
    <script src='<?php echo $baseUrl; ?>js/jquery-3.2.1.min.js'></script>
</head>
<body>

<div class="container">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand/logo -->
        <a class="navbar-brand" href="<?php echo $baseUrl; ?>">首页</a>

        <ul class="navbar-nav">
            <li class="nav-item <?php if ($action == 'doc'): ?>active<?php endif ?>">
                <a class="nav-link" href="<?php echo $baseUrl; ?>index/doc">文档</a>
            </li>
        </ul>
    </nav>
    <p></p>