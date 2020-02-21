<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="blank" />
		<meta name="format-detection" content="telephone=no" />
		<meta name="keywords" content="<?php echo $conf['keywords']?>" />
		<meta name="description" content="<?php echo $conf['description']?>" />
		<link rel="stylesheet" href="<?php echo STATIC_ROOT?>css/main.css" />
		<link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>
		<script src="//cdn.staticfile.org/jquery.dropotron/1.4.3/jquery.dropotron.min.js"></script>
		<!--[if lte IE 8]><script src="//cdn.staticfile.org/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
		<!--[if lte IE 8]><script src="//cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script><![endif]-->
		<title><?php echo $conf['title']?></title>
	</head>

	<body>
		<section id="page-wrapper">
			<!-- Header -->
			<header id="header">
				<h1><a href="#"><img src="assets/img/logo.png"></a></h1>
				<nav id="nav">
					<ul>
						<li>
							<a href="/">首页</a>
						</li>
						<li>
							<a href="produceIntroduce.html">功能介绍</a>
						</li>
						<li>
							<a href="doc.html">开发文档</a>
                        </li>
						<?php if($conf['test_open']==1){?>
						<li>
							<a target="_blank" href="/user/test.php">在线测试</a>
                        </li><?php }?>
						<?php if(!empty($conf['appurl'])){?>
						<li>
							<a href="<?php echo $conf['appurl']?>">APP下载</a>
						</li><?php }?>
					</ul>
				</nav> 				<nav id="navRight">
					<ul>
						<li>
							<a href="/user/" class="button login_btn">商户登录</a>

						</li>
						<li>
							<a href="/user/reg.php" class="button register_btn">商户注册</a>
						</li>
					</ul>
				</nav>			</header>