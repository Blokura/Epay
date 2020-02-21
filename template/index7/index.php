<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<html class="no-js" lang="zh" data-attr-t lang-t="lang">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<title><?php echo $conf['title'];?></title>
<meta name="keywords" content="<?php echo $conf['keywords']?>">
<meta name="description" content="<?php echo $conf['description']?>">
<link rel="stylesheet" href="https://lib.haidism.cn/assets/index/css/ff1.css">
<link rel="stylesheet" href="https://lib.haidism.cn/assets/index/css/public.css">
<link rel="stylesheet" href="https://lib.haidism.cn/assets/index/css/jquery.zySlide.css" />
<link rel="stylesheet" href="https://lib.haidism.cn/assets/index/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="https://lib.haidism.cn/assets/index/css/index.css" />
<style type="text/css">
    @media screen and (-ms-high-contrast: active),
    (-ms-high-contrast: none) {
      .countdown-bg,
      .hero-bg {
        width: 100%;
        height: 100%;
        position: absolute;
        -webkit-left: 0;
        -o-left: 0;
        top: 0px;
        left: 0px;
        -moz-overflow: hidden;
        -webkit-overflow: hidden;
        -o-overflow: hidden;

      }
      /* for IE10+ 此写法可以适配到高对比度和默认模式，故可覆盖所有ie10的模式 */
      .hero-scene-intro {
        top: -50px;
        /*top: 180px\9\0;*/
        left: 10%;
      }
    }

    .txt {
      font-size: 20px;
    }

    #iphone {
      height: 327px;
    }

    .address img{width: 17px;float: left;display: inline-block !important;position: relative;top: 4px;margin-right: 10px;}
    .address a img{width: 320px;height: 225px;margin: 30px 0 40px 0;}
    /*.align-center{border-bottom: solid 1px #eee;}*/
    .top-bar ul li a{color: #434343;}
    </style>
</head>
<body class="" style="min-width: 360px;">
<div class="top-bar-wrapper">
<div class="row align-center">
<div class="title-bar show-for-small-only">
<div class="title-bar-title">
<a href="#" data-attr-t href-t="route.root" title="">
<div class="top-bar__logo"></div>
</a>
</div>
<a id="hamburger" class="title-bar__toggle" target="_blank" data-toggle>
<span></span>
<span></span>
<span></span>
<span></span>
</a>
</div>
<div class="small-11 medium-10 large-10 hide-for-small-only">
<div class="top-bar" style="margin:10px 0 0 10%\0;">
<div class="top-bar-title">
<a href="/" data-attr-t href-t="route.root">
<div class="top-bar__logo" style="background: url(assets/img/logo.png) 0 no-repeat;"></div>
</a>
</div>
<div class="top-bar-right">
<ul class="dropdown menu" data-dropdown-menu>
<div class="top-bar-left">
<ul class="dropdown menu" data-dropdown-menu>
<li class="is-dropdown-submenu-parent">
<a href="#" data-t="top-nav.more" style="padding-right: 10px;">产品</a>
<ul class="menu vertical">
<li>
<a href="#" data-t="top-nav.account">
<img src="https://lib.haidism.cn/assets/index/img/account-system.svg" alt="">聚合服务
</a>
</li>
<li>
<a href="#" data-t="top-nav.platform">
<img src="https://lib.haidism.cn/assets/index/img/aggregate-pay.svg" alt="">公司产品
</a>
</li>
</ul>
</li>
<li>
</li>
<li>
</li>
</ul>
</div>
<li>
<a href="doc.html" data-t="top-nav.devcenter">开发文档</a>
</li>
<li>
</li>
<li id="in">
<a href="/user/" data-t="top-nav.login">登录</a>
</li>
<li style="">
<a href="/user/reg.php" class="button cta hollow small" id="button_top" style="">注册</a>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
<div class="mobile-nav show-for-small-only" id="sidebar-menu">
<ul>
<li>
<dl>
<dt data-t="top-nav.features">
<a>产品</a>
</dt>
<dd>
<a href="#">-聚合服务</a>
</dd>
<dd>
<a href="#">-公司产品</a>
</dd>
</dl>
</li>
<li>
<a href="#">解决方案</a>
</li>
<li class="divider">
<a href="#">Apple Pay</a>
</li>
<li>
<a href="#" target="_blank" data-t="top-nav.help">帮助中心</a>
</li>
<li class="divider">
<a href="#" data-t="top-nav.documentation">开发者中心</a>
</li>
<li>
<a href="/user/" data-t="top-nav.login">登入</a>
</li>
<li class="divider">
<a href="/user/reg.php" data-t="top-nav.signup">注册</a>
</li>
</ul>
</div>
<div class="ui-mask"></div>
<section class="hero fullheight" style="background-color: rgba(255, 255, 255,1);">
<div class="row align-center">
<div class="small-12 medium-9 large-9 columns fullheight-column-align">
<div class="row">
<div class="small-12 medium-5 columns align-self-middle">
<div class="hero-scene-intro">
<h1 class="intro" data-t="index.hero.subheading"><?php echo $conf['sitename'];?></h1>
<div class="viewport hide-for-small-only">
<ul class="hero-scene-text">
<li>
<h4 class="title" data-t="index.hero.scene.app">
在任何场景，
<br>向任何人收款。
</h4>
</li>
<li>
<h4 class="title" data-t="index.hero.scene.transfer">
向个人或企业
<br>付款
<span class="punctuation">、</span>发红包。
</h4>
</li>
<li>
<h4 class="title" data-t="index.hero.scene.offline">
实现余额
<span class="punctuation">、</span>优惠券
<br>等服务功能。
</h4>
</li>
<li>
<h4 class="title" data-t="index.hero.scene.web">
管理全平台
<br>的交易和账务。
</h4>
</li>
<li>
<h4 class="title" data-t="index.hero.scene.app">
在任何场景，
<br>向任何人收款。
</h4>
</li>
</ul>
</div>
<h1 class="title show-for-small-only" style="font-size: 20px;">
是您体验这个世界的仪轨
<br>让您感悟生活的轮廓和价值传递的方式
</h1>
</div>
</div>
</div>
</div>
</div>
<div class="hero-bg home">
<div class="row align-right">
<div class="small-12 medium-7 columns align-self-middle">
<div class="line-box-wrap">
<div class="line-box-viewport">
<div class="line-boxes">
<div class="box web"></div>
<div class="box apple-pay"></div>
<div class="box hongbao"></div>
<div class="box web"></div>
<div class="box apple-pay"></div>
<div class="box hongbao"></div>
<div class="box qr"></div>
</div>
<div class="scene-slider-wrap">
<div class="iphone-hand-bg"></div>
<div class="device-iphone6" id="iphone6">
<div class="topbar">
<span class="camera"></span>
<span class="speaker-before"></span>
<span class="speaker"></span>
</div>
<span class="home"></span>
<div class="screen">
<div class="scene-viewport">
<div class="scene-viewes">
<div class="scene apple-pay"></div>
<div class="scene hongbao"></div>
<div class="scene qr"></div>
<div class="scene web"></div>
<div class="scene apple-pay"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<div class="home-content">
<section class="home-main-con">
<div class="row align-center product-module">
<div class="small-12 medium-10 large-10" style="margin-bottom: 0;border-top:solid 1px #eee ;">
<div class="row align-center">
<div class="small-12 medium-6 large-6 outer" id="product-c" style=" width: 100% !important; -ms-width: 100% !important;">
<div class="product-module-item" style="margin-top: 88px;border-bottom: solid 1px #eee ;">
<p class="txt">服务不止是一次简单的交易，服务不再是冰冷的数据和枯燥的报表</p>
<div class="jiaoY">
<div class="jiaoCl">
<img src="https://lib.haidism.cn/assets/index/img/c-13.png" style="width: 65px;" />
</div>
<div class="jiaoCr">
<h6>不介入资金流</h6>
<p>龙宝只负责交易处理</p>
<p>不参与资金清算</p>
</div>
</div>
<div class="jiaoY">
<div class="jiaoCl">
<img src="https://lib.haidism.cn/assets/index/img/c-11.png" style="width: 65px;" />
</div>
<div class="jiaoCr">
<h6>接入便利</h6>
<p>全平台SKD让你最小化</p>
<p>介入服务的时间与人力</p>
</div>
</div>
<div class="jiaoY">
<div class="jiaoCl">
<img src="https://lib.haidism.cn/assets/index/img/c-15.png" style="width: 65px;" />
</div>
<div class="jiaoCr">
<h6>安全保证</h6>
<p>全地三中心容灾系统</p>
<p>确保服务稳定</p>
<p>最快完成交易</p>
</div>
</div>
<div class="jiaoY">
<div class="jiaoCl">
<img src="https://lib.haidism.cn/assets/index/img/c-12.png" style="width: 65px;" />
</div>
<div class="jiaoCr">
<h6>稳定可靠</h6>
<p>所有数据的传输和存储</p>
<p>符合金融级别的安全标准</p>
</div>
</div>
</div>
</div>
</div>
<div class="row align-center" id="foorm_a">
<div class="small-12 medium-6 large-6 outer" style="margin-bottom: 0; width: 100% !important;">
<div class="product-module-item" style="border-radius:10px ; margin: 120px 0 100px 0;">
<p class="txt" style="margin-bottom: 80px;">多级商户场景的服务解决方案，灵活实现多级商户的分润管理</p>
<div class="jiaoYr">
<div id="Slide1" class="zy-Slide" style="margin: 0; padding: 0 ">
<ul style="margin: 0;height: 100%; margin: 0 auto;">
<li>
<img src="https://lib.haidism.cn/assets/index/img/2w_11.png" />
</li>
<li>
<img src="https://lib.haidism.cn/assets/index/img/a_96.png" />
</li>
<img id="iphone6_img" src="https://lib.haidism.cn/assets/index/img/iphong8-4.png" />
<li>
<img src="https://lib.haidism.cn/assets/index/img/tou.png" />
</li>
<li>
<img src="https://lib.haidism.cn/assets/index/img/km-2.png" />
</li>
</ul>
</div>
</div>
<div class="jiaoYl">
<h4>聚合平台</h4>
<p>
聚合多种主流服务方式，为商户提供完美解决方案， 一次对接，
</p>
<p>一个接单，一个平台解决所有服务问题</p>
<p>
<button class="button-c hollow button_f">解决办法</button>
</p>
</div>
<div class="jiaoYl">
<h4>管理平台</h4>
<p>简单易用的管理平台，快速概览当日的交易状况</p>
<p>财务负责人可以集中进行跨渠道的交易管理，查账对账，数据分析，输出报表</p>
<p>开放多角色的职能权限设置，方便开发，运营和财务高效协作</p>
<p>
<button class="button-c hollow button_f">解决办法</button>
</p>
</div>
<div class="jiaoYr" id="Yr">
<img src="https://lib.haidism.cn/assets/index/img/kc4-13.png" id="kc_img" />
<div id="Yr_box">
<div id="Yr_"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<div id="trigger3" class="spacer s0"></div>
</div>
<footer style="background-color: rgb(246,248,248);padding-bottom: 0;">
<ul class="row" id="roo" style="background-color: rgb(38,163,241);">
<li class="large-2 medium-2 small-6 columns" style="width: 100% !important; display: inline-block;">
<dl>
<dt style="text-align: center;width: 100%; color: #FFFFFF;margin-top: 33px;">企业信赖的商业合作伙伴</dt>
<dd href="#" style="text-align: center; font-weight: 400;color: #FFFFFF;">行业明星团队，顶级风险投资机构支持，历经 3 年积累打造专业的支付系统解决方案和基于交易数据的商业智能平台，历经 273 个版本。</dd>
<dd href="#" style="text-align: center; font-weight: 400;color: #FFFFFF;">迭代升级，服务 70 多个行业近 2 万家企业客户，处理超过 5 亿笔订单。</dd>
<dd href="#" style="text-align: center; font-weight: 400;color: #FFFFFF;"><?php echo $conf['sitename'];?> 累计为超过 25000 家商户提供服务</dd>
</dl>
</li>
<div style="text-align: center; font-weight: 200; width: 100%;">
<a href="/user/reg.php">
<button id="buttonS" class="button_f">立即注册</button>
</a>
</div>
</ul>
<div class="beian row " style="background-color: rgb(255,255,255); margin: 0;padding-bottom: 30px;">
<p class="large-6 medium-6 small-12 columns" style="text-align: center;margin: 0;font-weight: 200;letter-spacing: -1px;padding-top: 7px;width: 100%;">
<?php echo $conf['footer']?>
</p>
<p class="large-6 medium-6 small-12 columns" style="text-align: center; margin: 0; font-weight: 200;letter-spacing: -1px; width: 100%;">
<?php echo $conf['sitename']?>&nbsp;&nbsp;&copy;&nbsp;2020&nbsp;All Rights Reserved. &nbsp;
</p>
</div>
</footer>
<div class="pro-consult">
<a id="consult" href="javascript:void(0);" class="button cta">
<img src="https://lib.haidism.cn/assets/index/img/Long4_33_03.png" />
</a>
</div>
<div id="consultSlide" class="pro-slide">
<div id="proCon" class="pro-con">
<h3><?php echo $conf['sitename'];?></h3>
<h4>掌握最新的行业解决方案</h4>
<hr />
<h3>联系我们</h3>
<form data-abide novalidate id="contact" class="pro-form">
<input type="hidden" id="source" name="source" value="widget">
<div class="address">
<p><img src="https://lib.haidism.cn/assets/index/img/qq.svg" alt="QQ" /> <a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&Site=pay&Menu=yes" target="_blank"><?php echo $conf['kfqq']?></a></p>
<p><img src="https://lib.haidism.cn/assets/index/img/iphone.svg" alt="电话" /> 123456789</p>
</div>
<hr />
<div class="">
<p>邮箱: <a href="mailto:<?php echo $conf['email']?>"><?php echo $conf['email']?></a></p>
</div>
</form>
</div>
<div id="proSuccess" class="pro-con text-center" style="display: none;">
<div class="pos-middle">
<div class="pro-ico">
<span class="pro-icon-success pro-draw"></span>
</div>
</div>
</div>
<div class="pro-close-outer">
<p class="pro-tip">
关注
<strong>微信公众号</strong>
<img src="https://lib.haidism/assets/index/img/qr-ping.png" alt=""> 获取即时资讯
</p>
<a class="pro-close">
<i class="fa fa-arrow-right" aria-hidden="true" style="margin: 11px auto ;font-size: 25px;color: #909090;"></i>
</a>
</div>
</div>
<script src="https://lib.haidism.cn/assets/index/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://lib.haidism.cn/assets/index/js/jquery.zySlide.js" type="text/javascript" charset="utf-8"></script>
<script src="https://lib.haidism.cn/assets/index/js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="https://lib.haidism.cn/assets/index/js/animation.js"></script>
</body>
</html>