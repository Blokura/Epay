<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<title><?php echo $conf['title']?></title>
<meta name="keywords" content="<?php echo $conf['keywords']?>">
<meta name="description" content="<?php echo $conf['description']?>" />
<meta name="viewport"content="user-scalable=no, width=device-width">
<meta name="viewport"content="width=device-width, initial-scale=1"/>
<meta name="renderer"content="webkit">
<link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="//cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet"href="<?php echo STATIC_ROOT?>css/common.css">
<link rel="stylesheet"href="<?php echo STATIC_ROOT?>css/index-top.css">
<!--[if IE 9 ]><style type="text/css">#ie9{ display:block; }</style><![endif]-->
<script src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.staticfile.org/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="//cdn.staticfile.org/jquery-ujs/1.2.2/rails.min.js"async="true"></script>
<link rel="stylesheet"type="text/css"href="<?php echo STATIC_ROOT?>css/index.css"/>
</head>
<body>
<!--[if (gt IE 6)&amp;(lt IE 9)]>
<h1 style='color:red;text-align:center;'>
      你好，浏览器版本过低，升级可正常访问,点击<a style="color:blue"href="http://browsehappy.com/">升级您的浏览器</a>
</h1>
<style type="text/css">#ielt9{ display: none; }h1{ height:300px;line-height: 300px;display:block; }header{ display: none; }#ie9{ display: block; }.tenxcloud-logo{ margin:50px auto 0;display:block}</style>
<![endif]-->

<div id="ielt9"style="height:100%">
<header>
<nav id="main-nav"class="navbar navbar-default"role="navigation">
<div class="container">
<div class="row">
<div class="navbar-header">
<button type="button"class="toggle navbar-toggle collapsed"data-toggle="collapse"data-target=".navbar-top-collapse">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a href="/"><span class="logo" style="background:url(assets/img/logo.png) no-repeat;height: 45px"></span></a>
</div>
<div class="navbar-collapse navbar-top-collapse collapse"style="height: 1px;">
<ul class="nav navbar-nav navbar-right c_navbar">

</ul>
<ul class="nav navbar-nav navbar-right z_navbar">
<li><a href="/">首页</a></li>
<li><a href="doc.html">开发文档</a></li>
<?php if($conf['test_open']){?>
<li><a href="/user/test.php">支付测试</a></li>
<?php }?>
<li><a href="/user/">用户中心</a></li>
                    
                </ul>
</div>
</div>
</div>
</nav>
</header>
<div id="ie9">你当前的浏览器版本过低，请您升级至IE9以上版本，以达到最佳效果，谢谢！<span class="closeIE">X</span></div>
<div id="scroll_Top">
<i class="fa fa-arrow-up"></i>
<a href="javascript:;"title="去顶部"class="TopTop">TOP</a></div>
<script>

  $('.closeIE').click(function(event) {
    $('#ie9').fadeOut();
  });
</script>