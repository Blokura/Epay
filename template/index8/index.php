<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zh-cn">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title><?php echo $conf['title']?></title>
	<meta name="keywords" content="<?php echo $conf['keywords']?>">
	<meta name="description" content="<?php echo $conf['description']?>">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <link rel="stylesheet" type="text/css" href="//cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/animations.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/responsive.css">
    <!--[if lt IE 9]>
	  <script src="//cdn.staticfile.org/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="//cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>.section {padding: 25px 0;color: #666666;}</style>
</head>
<body>
<div class="wrapper">
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="logo"><a href=""><img src="assets/img/logo.png" alt=""></a></div>
                </div>
                <div class="col-md-7">
                    <ul class="menu">
                        <li><a href="/">网站首页</a></li>
                        <li><a href="/user/test.php" target="_blank">demo测试</a></li>
						<li><a href="/doc.html" target="_blank">开发文档</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <div class="button-header">
                        <a href="/user/" class="custom-btn login">商户登录</a>
                        <a href="/user/reg.php" class="custom-btn">注册商户</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-block">
            <div class="logo-mobile"><a href=""><img src="assets/img/logo.png" alt=""></a></div>
            <a href="#" class="mobile-menu-btn"><span></span></a>
            <div class="mobile-menu">
                <div class="inside">
                    <div class="logo">
                        <a href=""><img src="assets/img/logo.png" alt="""></a>
                    </div>
                    <ul class="menu panel-group" id="accordion" aria-multiselectable="true">
                        <li><a href="/">网站首页</a></li>
                        <li><a href="/user/test.php">demo测试</a></li>
						<li><a href="/doc.html">开发文档</a></li>
                    </ul>
                    <div class="button-header">
                        <a href="/user/" class="custom-btn login">商户登录</a>
                        <a href="/user/reg.php" class="custom-btn">注册商户</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="base-slider owl-carousel owl-theme bg-gray">
        <div class="item">
            <img src="<?php echo STATIC_ROOT?>picture/bg-test.png" alt=""">
            <div class="inside">
                <h2><?php echo $conf['sitename']?> - 为创业者而生</h2>
                <p>专注于提供安全、高效、严谨、便捷的订单数据服务！</p>
                <a href="/user/login.php" class="custom-btn">立即登录</a>
            </div>
        </div>
    </div>
    <section class="bg-gray">
        <div class="container">
            <div class="why-choose animatedParent">
                <h2 class="title-head">全天候无人值守 7X24小时高效运转</h2>
                <div class="row">
                    <div class="col-md-4 col-xs-12 animated bounceInUp delay-250 go">
                        <div class="inside">
                            <img src="<?php echo STATIC_ROOT?>picture/optimised.svg" alt=""">
                            <a href="">极速响应</a>
                            <p>付款后立即回调,无等待,流程超顺畅</p>
                            <a href="/user/reg.php" class="read-more">加入我们<img src="<?php echo STATIC_ROOT?>picture/right.png" alt="""></a>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 animated bounceInUp delay-500 go">
                        <div class="inside">
                            <img src="<?php echo STATIC_ROOT?>picture/powerfull.svg" alt=""">
                            <a href="">资金直达</a>
                            <p>系统收到交易消息后自动将余额提现</p>
                            <a href="/user/reg.php" class="read-more">加入我们<img src="<?php echo STATIC_ROOT?>picture/right.png" alt="""></a>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 animated bounceInUp delay-750 go">
                        <div class="inside">
                            <img src="<?php echo STATIC_ROOT?>picture/website.svg" alt=""">
                            <a href="">账户安全</a>
                            <p>绑定后无法更改,防止他人修改结算账户</p>
                            <a href="/user/reg.php" class="read-more">加入我们<img src="<?php echo STATIC_ROOT?>picture/right.png" alt="""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<div class="section section-pricing">
<div class="title-block">
<div style="text-align:center;">
平台合作伙伴
</div>
<center>
<img style="FILTER: gray()" src="<?php echo STATIC_ROOT?>picture/aliyun.png" width="85">
<img style="FILTER: gray()" src="<?php echo STATIC_ROOT?>picture/qqpay.png" width="85">
<img style="FILTER: gray()" src="<?php echo STATIC_ROOT?>picture/wxpay.png" width="85">
<img style="FILTER: gray()" src="<?php echo STATIC_ROOT?>picture/tenpay.png" width="85">
</center>
</div>
</div>
</div>
</div>
</div>
</div>
    <footer>
        <div class="container">
            <div class="copyright text-center">
			<p style="font-style:oblique;font-size:14px;color:#FFF"><?php echo $conf['sitename']?>&nbsp;&nbsp;&copy;&nbsp;2020&nbsp;All Rights Reserved.<br/><?php echo $conf['footer']?></p>
            </div>
        </div>
    </footer>
</div>
<script type="text/javascript" src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo STATIC_ROOT?>js/owl.carousel.min.js"></script>
<script src="<?php echo STATIC_ROOT?>js/main.js"></script>
<script type="text/javascript">
    $(function () {
        $("header").addClass('transparent');
    });
</script>
</body>
</html>