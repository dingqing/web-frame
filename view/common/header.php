<!doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>E-PHP</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>css/bootstrap.css" />
	<!--[if IE]>
		<script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
	<![endif]-->
	<script src='<?php echo $baseUrl;?>js/jquery-2.1.1.min.js'></script>
</head>
<body>
<div class="container">
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <!-- <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="<?php echo $baseUrl;?>">首页</a>
	    </div> -->

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    	<ul class="nav navbar-nav">
		        <li class="<?php if ($nowA=='index' || $nowC==''): ?>active<?php endif ?>"><a href="<?php echo $baseUrl;?>">首页</a></li>
		        <li class="<?php if ($nowA=='doc'): ?>active<?php endif ?>"><a href="<?php echo $baseUrl;?>index/doc">文档</a></li>
		        <li class="<?php if ($nowA=='about'): ?>active<?php endif ?>"><a href="<?php echo $baseUrl;?>index/about">关于</a></li>
		        <li class="<?php if ($nowA=='contact'): ?>active<?php endif ?>"><a href="<?php echo $baseUrl;?>index/contact">联系我</a></li>
		    </ul>

	    	<ul class="nav navbar-nav navbar-right">
		        <!-- <li><a href="javascript:void(0)">欢迎！<?php if (isset($_SESSION['uname'])) {echo $_SESSION['uname']; }?></a></li>
		        <li><a href="#" id="logoutBtn">退出</a></li> -->
		        <li><a href="#">English</a></li>
		    </ul>
		    <!-- <form class="navbar-form navbar-right">
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Search">
		        </div>
		        <button type="submit" class="btn btn-default">搜索</button>
		    </form> -->
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	<script>
		/*$(function(){
			$("#logoutBtn").click(function(e){
		        e.preventDefault();
		        if (confirm('确定退出系统吗？')) {
		        	location.href = '<?php echo $baseUrl ; ?>index.php/system/logout';
		        }
		    });
	    });*/
	</script>