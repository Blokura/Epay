<?php
if(!defined('IN_CRONLITE'))exit();
require INDEX_ROOT.'head.php';
?>
<section class="screen1">
<div id="myCarousel"class="carousel slide">
<div class="carousel-inner">

<div class="item active">
<div class="banner2 banner3">
<div class="container">
<div class="row">

<div class="col-xs-12 col-sm-6 col-md-6">
<div class="ban2_img">
<div class="cloud_db_img"><img src="<?php echo STATIC_ROOT?>images/banner4.png"class="img-responsive"></div>
</div>
</div>
<div class="col-xs-12 col-sm-6 col-md-6">
<div class="ban2_text">
<div class="ban2_status docker">
<div class="ban2_middle">欢迎使用<?php echo $conf['sitename']?></div>
<div class="ban2_content">提供免签约支付宝、QQ钱包、微信支付</div>
                      
                        <div class="ban2_experience">
<a href="/user/"class="btn proceed">登录商户</a>&nbsp;&nbsp;<a href="/user/reg.php"class="btn proceed">注册商户</a><br/>
                      </div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
<!--   <ol class="carousel-indicators">
<li data-target="#myCarousel"data-slide-to="1"class="active"></li>
</ol>
<div id="trun_left"><a href="#myCarousel"data-slide="prev"class="_left">&lsaquo;</a></div>
<div id="trun_right"><a href="#myCarousel"data-slide="next"class="_right">&rsaquo;</a></div>-->
</div>

</section>
   
   <section class="screen3">
<div class="container">
<div class="row">
<div class="col-xs-12 cloud_server">
<div class="h3"><?php echo $conf['sitename']?>®免签约支付产品</div>
</div>
<div class="col-xs-6 col-sm-4 col-md-4">
<div id="container_server">
<div class="server_item container_server"></div>
<div class="server-head h4">多种支付方式
<div class="h5 text-center">支持财付通 支付宝 微信 QQ钱包</div>
</div>
</div>
</div>
<div class="col-xs-6 col-sm-4 col-md-4">
<div id="server-arrange">
<div class="server_item arrange"></div>
<div class="server-head h4">对接费率超低
<div class="h5 text-center">每笔交易手续费低至2%，比其它平台更便宜</div>
</div>
</div>
</div>
<div class="col-xs-6 col-sm-4 col-md-4">
<div id="codebuild">
<div class="server_item codebuild"></div>
<div class="server-head h4">无需自主提现
<div class="h5 text-center">满一定金额即可自动提现到你的支付宝账号</div>
</div>
</div>
</div>


</div>
</div>
</section>

  
    <section class="screen4">
<div class="container">
<div class="row">
<div class="col-xs-12 blog-head">
<div class="h3">平台合作伙伴</div>
<div class="col-xs-3">
<img src="<?php echo STATIC_ROOT?>images/alipay.png" width="150">
</div>
<div class="col-xs-3">
<img src="<?php echo STATIC_ROOT?>images/wxpay.png" width="150">
</div>
<div class="col-xs-3">
<img src="<?php echo STATIC_ROOT?>images/qqpay.png" width="150">
</div>
<div class="col-xs-3">
<img src="<?php echo STATIC_ROOT?>images/tenpay.png" width="150">
</div>
</div>
          
          
        </div>
</div>
</section>

<?php require INDEX_ROOT.'foot.php';?>