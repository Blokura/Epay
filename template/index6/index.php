<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="zh" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zh">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<title><?php echo $conf['title']?></title>
  	<meta name="keywords" content="<?php echo $conf['keywords']?>">
	<meta name="description" content="<?php echo $conf['description']?>">	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="//cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" />
	<link href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
	<link href="//cdn.staticfile.org/animate.css/3.7.2/animate.min.css" rel="stylesheet" />
	<link href="<?php echo STATIC_ROOT?>css/style.min.css" rel="stylesheet" />
	<link href="<?php echo STATIC_ROOT?>css/style-responsive.min.css" rel="stylesheet" />
	<link href="<?php echo STATIC_ROOT?>css/theme/blue.css" id="theme" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="//cdn.staticfile.org/pace/1.0.2/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body data-spy="scroll" data-target="#header-navbar" data-offset="51">
    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin #header -->
        <div id="header" class="header navbar navbar-transparent navbar-fixed-top">
            <!-- begin container -->
            <div class="container">
                <!-- begin navbar-header -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="index.html" class="navbar-brand">
                        <span class="brand-logo"></span>
                        <span class="brand-text">
                            <span class="text-theme"><?php echo $conf['sitename']?></span>
                        </span>
                    </a>
                </div>
                <!-- end navbar-header -->
                <!-- begin navbar-collapse -->
                <div class="collapse navbar-collapse" id="header-navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="#home" data-click="scroll-to-target">首页</a> </li>
                      	<li><a href="#service" data-click="scroll-to-target">优势</a></li>
                        <li><a href="#team" data-click="scroll-to-target">团队</a></li>
                        <?php if($conf['test_open']){?><li><a href="/user/test.php">在线测试</a></li><?php }?>
                        <li><a href="/doc.html">开发文档</a></li>
                      	<li><a href="/user/reg.php">接入申请</a></li>
                        <li><a href="/user/">商户登录</a></li>
                    </ul>
                </div>
                <!-- end navbar-collapse -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #header -->
        
        <!-- begin #home -->
        <div id="home" class="content has-bg home">
            <!-- begin content-bg -->
            <div class="content-bg">
                <img src="<?php echo STATIC_ROOT?>img/home-bg.jpg" alt="Home" />
            </div>
            <!-- end content-bg -->
            <!-- begin container -->
            <div class="container home-content">
                <h1>欢迎来到 <a href="JavaScript:;"><?php echo $conf['sitename']?></a></h1>
                <h3>免签约支付平台 结算费率低至<?php echo $conf['settle_rate']*100; ?>%！</h3>
                <h4>
                    支持多种支付方式：支付宝、QQ钱包、微信、财付通支付，可根据开发文档快速接入自己网站！<br />
                    <a href="JavaScript:;">稳定、安全、值得信赖</a>
                </h4>
                <a href="../../user/reg.php" class="btn btn-theme">申请接入</a> <a href="../../user" class="btn btn-outline">商户登录</a><br />
            </div>
            <!-- end container -->
        </div>
        <!-- end #home -->
    	
      	<!-- beign #service -->
        <div id="service" class="content" data-scrollview="true">
            <!-- begin container -->
            <div class="container">
                <h2 class="content-title">为什么选择我们？</h2>
                <p class="content-desc">
                    <?php echo $conf['sitename']?>免去个人站长无法签约支付接口以及企业申请签约支付接口麻烦的问题，免签约也能享受及时到账的乐趣，系统优势如下：
                </p>
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-3 -->
                    <div class="col-md-4 col-sm-4">
                        <div class="service">
                            <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-cog"></i></div>
                            <div class="info">
                                <h4 class="title">方便接入</h4>
                                <p class="desc">根据我们提供的开发文档，可快速接入你的网站，让你的网站支持在线支付功能，享受免签约支付的乐趣。</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-4 col-sm-4">
                        <div class="service">
                            <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-paint-brush"></i></div>
                            <div class="info">
                                <h4 class="title">低手续费</h4>
                                <p class="desc">结算费率低至<?php echo $conf['settle_rate']*100; ?>%，每日满<?php echo $conf['settle_money']; ?>元自动结算，上不封顶，提现手续费最低<?php echo $conf['settle_fee_min']; ?>元，最高<?php echo $conf['settle_fee_max']; ?>元。</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-4 col-sm-4">
                        <div class="service">
                            <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-file"></i></div>
                            <div class="info">
                                <h4 class="title">智能提醒</h4>
                                <p class="desc"><?php echo $conf['sitename']?>提供商户APP、QQ机器人、邮箱等多种提醒方式可选，让您随时获知自己的收入动态。</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                </div>
                <!-- end row -->
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-3 -->
                    <div class="col-md-4 col-sm-4">
                        <div class="service">
                            <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-code"></i></div>
                            <div class="info">
                                <h4 class="title">安全放心</h4>
                                <p class="desc">我们用的支付接口全为自己申请，不存在二次对接的情况，彻底避免对接方跑路导致无法结算的情况！</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-4 col-sm-4">
                        <div class="service">
                            <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-shopping-cart"></i></div>
                            <div class="info">
                                <h4 class="title">自动结算</h4>
                                <p class="desc">采取T+1结算方式，交易金额满<?php echo $conf['settle_money']; ?>元，系统会于次日零点开始自动结算，不满10元亦可申请手动结算。</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-4 col-sm-4">
                        <div class="service">
                            <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i class="fa fa-heart"></i></div>
                            <div class="info">
                                <h4 class="title">插件拓展</h4>
                                <p class="desc">提供SDK测试包，方便快速开发和接入，后续会逐渐提供discuz、WordPress等平台的支付相关插件。</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #service -->
      
        <!-- begin #milestone -->
        <div id="milestone" class="content bg-black-darker has-bg" data-scrollview="true">
            <!-- begin content-bg -->
            <div class="content-bg">
                <img src="<?php echo STATIC_ROOT?>img/milestone-bg.jpg" alt="Milestone" />
            </div>
            <!-- end content-bg -->
            <!-- begin container -->
            <div class="container">
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-3 -->
                    <div class="col-md-4 col-sm-4 milestone-col">
                        <div class="milestone">
                            <div class="number" data-animation="true" data-animation-type="number" data-final-number="1292">1,292</div>
                            <div class="title">接入商户</div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-4 col-sm-4 milestone-col">
                        <div class="milestone">
                            <div class="number" data-animation="true" data-animation-type="number" data-final-number="9039">9,039</div>
                            <div class="title">接入网站</div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-4 col-sm-4 milestone-col">
                        <div class="milestone">
                            <div class="number" data-animation="true" data-animation-type="number" data-final-number="129">129</div>
                            <div class="title">合作伙伴</div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #milestone -->
        
        <!-- begin #team -->
        <div id="team" class="content" data-scrollview="true">
            <!-- begin container -->
            <div class="container">
                <h2 class="content-title">我们的团队</h2>
                <p class="content-desc">
                    
                </p>
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-3 -->
                    <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
                        <!-- begin team -->
                        <div class="team">             
                            <div class="image" data-animation="true" data-animation-type="flipInX">
                                <img src="//q1.qlogo.cn/g?b=qq&nk=<?php echo $conf['kfqq']?>&s=640" alt="Mia Donovan" />
                            </div>
                            <div class="info">
                                <h3 class="name">客服</h3>
                                <div class="title text-theme">客服</div>
                                <p>业务售后综合客服 </p>
                                <div class="social">
                                    <a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=pay&menu=yes" title="点击联系客服QQ"><i class="fa fa-qq fa-lg fa-fw"></i></a>
                                    <a href="JavaScript:;"><i class="fa fa-weibo fa-lg fa-fw"></i></a>
                                    <a href="JavaScript:;"><i class="fa fa-home fa-lg fa-fw"></i></a>
                                </div>
                            </div>                     
                        </div>
                        <!-- end team -->
                    </div>
                    <!-- end col-3 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #team -->
      
        <!-- begin #footer -->
        <div id="footer" class="footer">
            <div class="container">
                <div class="footer-brand">
                    <div class="footer-brand-logo"></div>
                    <?php echo $conf['sitename']?>
                </div>
                <p>
                    Copyright&nbsp;&nbsp;&copy;&nbsp;2020&nbsp;All Rights Reserved.<br/><?php echo $conf['footer']?>
                </p>
            </div>
        </div>
        <!-- end #footer -->
        
        <!-- begin theme-panel -->
        <div class="theme-panel">
            <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
            <div class="theme-panel-content">
                <ul class="theme-list clearfix">
                    <li><a href="javascript:;" class="bg-purple" data-theme="purple" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Purple">&nbsp;</a></li>
                    <li class="active"><a href="javascript:;" class="bg-blue" data-theme="blue" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Blue">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-green" data-theme="default" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Default">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-orange" data-theme="orange" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Orange">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-red" data-theme="red" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Red">&nbsp;</a></li>
                </ul>
            </div>
        </div>
        <!-- end theme-panel -->
    </div>
    <!-- end #page-container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>
	<script src="//cdn.staticfile.org/jquery-migrate/1.4.1/jquery-migrate.min.js"></script>
	<script src="//cdn.staticfile.org/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="//cdn.staticfile.org/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="//cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="//cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="//cdn.staticfile.org/scrollmonitor/1.2.0/scrollMonitor.js"></script>
	<script src="<?php echo STATIC_ROOT?>js/apps.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<script>
	var staticroot = '<?php echo STATIC_ROOT?>';
	    $(document).ready(function() {
	        App.init();
	    });
	</script>

</body>
</html>
