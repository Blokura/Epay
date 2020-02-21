<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<title><?php echo $conf['title']?></title>
<meta name="keywords" content="<?php echo $conf['keywords']?>">
<meta name="description" content="<?php echo $conf['description']?>">
<link href="<?php echo STATIC_ROOT?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo STATIC_ROOT?>css/index1200.css" rel="stylesheet" type="text/css" />
<link href="<?php echo STATIC_ROOT?>css/index960.css" rel="stylesheet" type="text/css" />
<link href="<?php echo STATIC_ROOT?>css/index720.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo STATIC_ROOT?>css/aos.css">
<script src="//cdn.staticfile.org/jquery/3.4.1/jquery.min.js"></script>
<script src="<?php echo STATIC_ROOT?>js/aos.js"></script>
<script src="<?php echo STATIC_ROOT?>js/main.js"></script>
<!--[if lt IE 9]>
  <script src="//cdn.staticfile.org/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="//cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<!--头-开始-->
    <div class="head backFFF">
    	<div class="headK">
        	<div class="Logo fl"><img src="assets/img/logo.png"  /></div>
            <div class="MenuPC fr">
      			                <a href="/user/reg.php" class="hdReg fr" style="float: right">注册</a>
                <a href="/user/" class="hdLog fr" style="float: right">登录</a>
                
                <a href="/doc.html" class="MenuA fl" style="float: right">开发文档</a>
				<?php if($conf['test_open']){?><a href="/user/test.php" class="helpc MenuA fl" style="float: right">支付测试</a><?php }?>
                <a href="javascript:;" class="helpc MenuA fl" style="float: right">帮助中心</a>
				
            	<a href="/" class="MenuA backB1 MenuAo fl" style="float: right">首页</a>

            </div>
            <div class="hd_nav fr"><i></i></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="wap_nav">
        <div class="wap_navK">        	
            <a href="/" class="">首页</a>
            <a href="javascript:;" class="helpc ">帮助中心</a>
            <a href="/doc.html" class="">开发文档</a>
			<?php if($conf['test_open']){?><a href="/user/test.php" class="">支付测试</a><?php }?>
            <a href="/user/reg.php" class="">注册</a>
            <a href="/user/" class="">登录</a>
                    </div>
    </div>
    <div id="faq" style="display: none"><!--帮助中心-开始-->
    <div class="Help">
        <div class="HelpT">常见问题</div>
        <div class="HelpD">
            <div class="HelpN">
                <div class="HelpNs">
                    <div class="HelpQ"><i class="backB1">Q</i>怎么入驻淘<?php echo $conf['sitename']?>,成为商户?</div>
                    <div class="HelpA"><i>A</i>通过平台的账户注册功能，即可免费入驻<?php echo $conf['sitename']?>，快速实现支付接入<a href="/user/">点此进入 </a></div>
                </div>
            </div>
            <div class="HelpN">
                <div class="HelpNs">
                    <div class="HelpQ"><i class="backB1">Q</i>怎么快速接入？</div>
                    <div class="HelpA"><i>A</i>点击开发文档有详细的接入手册，还有sdk一键接入</div>
                </div>
            </div>
            <div class="HelpN">
                <div class="HelpNs">
                    <div class="HelpQ"><i class="backB1">Q</i>平台可以卖些什么？</div>
                    <div class="HelpA"><i>A</i>虚拟商品(例如软件注册码，论坛帐号等等，CDK,优惠卷)，不可以卖虚假物品 涉嫌黄赌毒等商品。。</div>
                </div>
            </div>
            <div class="HelpN">
                <div class="HelpNs">
                    <div class="HelpQ"><i class="backB1">Q</i>商户结算方式有哪些？</div>
                    <div class="HelpA"><i>A</i>支持支付宝、银行卡，后期我们还会增加微信结算。</div>
                </div>
            </div>
            <div class="HelpN">
                <div class="HelpNs">
                    <div class="HelpQ"><i class="backB1">Q</i><?php echo $conf['sitename']?>安全吗？</div>
                    <div class="HelpA"><i>A</i>非常安全，<?php echo $conf['sitename']?>运用先进的安全技术保护用户在平台账户中存储的个人信息、账户信息以及交易记录的安全。<?php echo $conf['sitename']?>拥有完善的全监测系统，可以及时发现网站的非正常访问并做相应的安全响应。</div>
                </div>
            </div>
            <div class="HelpN">
                <div class="HelpNs">
                    <div class="HelpQ"><i class="backB1">Q</i>每日结算时间？</div>
                    <div class="HelpA"><i>A</i>商户账户金额满10.00元，当天晚上12点后，系统自动帮您提现，财务将于第二天12点前结算到您预留的账户。</div>
                </div>
            </div>
            <div class="HelpN">
                <div class="HelpNs">
                    <div class="HelpQ"><i class="backB1">Q</i>如何查询订单？</div>
                    <div class="HelpA"><i>A</i>打开平台的订单查询页面,输入订单号即可查询，<a href="/user/order.php">点此进入 </a></div>
                </div>
            </div>
            <div class="HelpN">
                <div class="HelpNs">
                    <div class="HelpQ"><i class="backB1">Q</i>不会接入？商业合作？</div>
                    <div class="HelpA"><i>A</i>请联系平台客服,<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&Site=pay&Menu=yes" target="_blank">点击查看联系方式 </a></div>
                </div>
            </div>
            <div class="HelpN">
                <div class="HelpNs">
                    <div class="HelpQ"><i class="backB1">Q</i>我的账户资金安全吗？</div>
                    <div class="HelpA"><i>A</i><?php echo $conf['sitename']?>严格遵守国家相关的法律法规，对用户的隐私信息进行保护。未经您的同意，<?php echo $conf['sitename']?>不会向任何第三方公司、组织和个人披露您的个人信息、账户信息以及交易信息（法律法规另有规定的除外）</div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="index" style="display: block">
<div class="bannerK">
    <div class="banner">
    	<div class="banNr" data-aos="fade-right" aos-delay="50">
        	<div class="banNrT"><?php echo $conf['sitename']?></div>
            <p>致力于帮助企业快速和高质量地建立支付模块，<br />聚合主流通道，为您提供全方位支付体验，告别繁琐的接入流程</p>
            <a href="/user/" class="ButAN backB1">立即体验</a>
        </div>
    </div>
    <div class="Title">
    	<p>寄售服务项目</p>
        <span>CONSIGNMENT SERVICE ITEMS</span>
        <i></i>
    </div>
    <div class="IndIte" data-aos="fade-up" aos-delay="50">
    	<div class="IndIteK fl"><div class="IndIteI"><img src="<?php echo STATIC_ROOT?>picture/indi01.png" /></div><p>电商/优惠卷/折扣卷</p></div>
        <div class="IndIteK fl"><div class="IndIteI"><img src="<?php echo STATIC_ROOT?>picture/indi02.png" /></div><p>论坛/邀请码/注册码/积分充值卡</p></div>
        <div class="IndIteK fl"><div class="IndIteI"><img src="<?php echo STATIC_ROOT?>picture/indi03.png" /></div><p>企业个人软件/充值码/注册码</p></div>
        <div class="IndIteK fl"><div class="IndIteI"><img src="<?php echo STATIC_ROOT?>picture/indi04.png" /></div><p>腾讯/爱奇艺/优酷/视频CDK/游戏CDK</p></div>
        <div class="clear"></div>
    </div>
    <div class="Title">
    	<p>渠道</p>
        <span>CHANNEL OF PAYMENT</span>
        <i></i>
    </div>
    <div class="IndPay" data-aos="fade-up" aos-delay="50">
    	<div class="IndPayK fl"><img src="<?php echo STATIC_ROOT?>picture/indpay1.jpg" /></div>
        <div class="IndPayK fl"><img src="<?php echo STATIC_ROOT?>picture/indpay2.jpg" /></div>
        <div class="IndPayK fl"><img src="<?php echo STATIC_ROOT?>picture/indpay3.jpg" /></div>
        <div class="IndPayK fl"><img src="<?php echo STATIC_ROOT?>picture/indpay4.jpg" /></div>
        <div class="IndPayK fl"><img src="<?php echo STATIC_ROOT?>picture/indpay5.jpg" /></div>
        <div class="IndPayK fl"><img src="<?php echo STATIC_ROOT?>picture/indpay6.jpg" /></div>
        <div class="clear"></div>
    </div>
    <div class="Title">
    	<p>平台功能</p>
        <span>PLATFORM FUNCTION</span>
        <i></i>
    </div>
    <div class="IndPlaK" >
    	<div class="IndPlaL fl" data-aos="fade-right" aos-delay="50">
        	<div class="IndPlaLT">01.手续费扣除模式</div>
            <div class="IndPlaLn">
            	<div class="IndPlaLz backB1 fl">A</div>
                <div class="IndPlaLr fr">
                	<p>模式1.买家承担</p><span>买家付款时会连同手续费一并支付</span>
                </div><div class="clear"></div>
            </div>
            <div class="IndPlaLn">
            	<div class="IndPlaLz backB1 fl">B</div>
                <div class="IndPlaLr fr">
                	<p>模式2.商家承担</p><span>手续费在成功付款的订单内扣除</span>
                </div><div class="clear"></div>
            </div>
        </div>
        <div class="IndPlar fr" data-aos="fade-left" aos-delay="50">
        	<img src="<?php echo STATIC_ROOT?>picture/indpic01.png" />
        </div><div class="clear"></div>
    </div>
    <div class="IndPlaS" data-aos="fade-down" aos-delay="50">
    	<div class="IndPlaC fl">
        	<div class="IndPlaI"><img src="<?php echo STATIC_ROOT?>picture/indpl01.png" height="100%" /></div>
            <div class="IndPlaKt">极简使用</div><p>七行代码，极速完成，支付接入 简洁的操作界面易于使用</p>
        </div>
        <div class="IndPlaC fl">
        	<div class="IndPlaI"><img src="<?php echo STATIC_ROOT?>picture/indpl02.png" height="100%" /></div>
            <div class="IndPlaKt">灵活便利</div><p>产品服务灵活组合 满足企业多元化业务需求</p>
        </div>
        <div class="IndPlaC fl">
        	<div class="IndPlaI"><img src="<?php echo STATIC_ROOT?>picture/indpl03.png" height="100%" /></div>
            <div class="IndPlaKt">大数据</div><p>运用交易数据分析功能 了解公司运营状况</p>
        </div>
        <div class="IndPlaC fl">
        	<div class="IndPlaI"><img src="<?php echo STATIC_ROOT?>picture/indpl04.png" height="100%" /></div>
            <div class="IndPlaKt">安全稳定</div><p>平台运行于阿里云计算中心 多备份容灾保障</p>
        </div>
        <div class="IndPlaC fl">
        	<div class="IndPlaI"><img src="<?php echo STATIC_ROOT?>picture/indpl05.png" height="100%" /></div>
            <div class="IndPlaKt">不介入资金流</div><p>只负责交易处理不参与资金清算 保障您的资金安全</p>
        </div>
        <div class="IndPlaC fl">
        	<div class="IndPlaI"><img src="<?php echo STATIC_ROOT?>picture/indpl06.png" height="100%" /></div>
            <div class="IndPlaKt">安全密码</div><p>可自行开关 为你的账户安全保驾护航</p>
        </div>
        <div class="IndPlaC fl">
        	<div class="IndPlaI"><img src="<?php echo STATIC_ROOT?>picture/indpl07.png" height="100%" /></div>
            <div class="IndPlaKt">增值服务</div><p>提供金融产品及技术服务 帮助企业整合互联网金融</p>
        </div>
        <div class="IndPlaC fl">
        	<div class="IndPlaI"><img src="<?php echo STATIC_ROOT?>picture/indpl08.png" height="100%" /></div>
            <div class="IndPlaKt">自助服务</div><p>同时平台全面提供7*24小时客户服务，保障客户问题随时得到处理解决</p>
        </div>
        <div class="clear"></div>
        <a href="javascript:;" class="ButAN ButPla backB1" data-aos="fade-down" aos-delay="50">更多功能等你来发掘</a>
    </div>
    
    <div class="Title">
    	<p>核心优势</p>
        <span>CHANNEL OF PAYMENT</span>
        <i></i>
    </div>
    <div class="IndCha">
    	<div class="IndChaZ fl" data-aos="fade-right" aos-delay="50">
        	<div class="IndChaZt">服务器安全</div>
            <p>采用群集服务器，防御高，故障率低，无论用户身在何处，均能获得流畅安全可靠的体验</p>
            <a href="javascript:;" class="ButAN backB1">立即体验</a>
        </div>
        <div class="IndChaP fr" data-aos="fade-left" aos-delay="60"><img src="<?php echo STATIC_ROOT?>picture/indpic02.png" width="100%" /></div>
        <div class="clear"></div>
    </div>
    <div class="IndCha">
    	<div class="IndChaP fl" data-aos="fade-right" aos-delay="60"><img src="<?php echo STATIC_ROOT?>picture/indpic03.png" width="100%" /></div>
    	<div class="IndChaZ fr" data-aos="fade-left" aos-delay="50">
        	<div class="IndChaZt">资金保障</div>
            <p>商户的商品，全部加密处理，专业运维24小时处理，您的帐户安全将得到充分的保障。</p>
            <a href="javascript:;" class="ButAN backB1">立即体验</a>
        </div>        
        <div class="clear"></div>
    </div>
    <div class="IndCha">
    	<div class="IndChaZ fl" data-aos="fade-right" aos-delay="50">
        	<div class="IndChaZt">专属客服</div>
            <p>专业客服团队，专属客服一对一贴心服务，7*24小时全天候在线为你解答。</p>
            <a href="javascript:;" class="ButAN backB1">立即体验</a>
        </div>
        <div class="IndChaP fr" data-aos="fade-left" aos-delay="50"><img src="<?php echo STATIC_ROOT?>picture/indpic04.png" width="100%" /></div>
        <div class="clear"></div>
    </div>
    <div class="IndCha">
    	<div class="IndChaP fl" data-aos="fade-right" aos-delay="50"><img src="<?php echo STATIC_ROOT?>picture/indpic05.png" width="100%" /></div>
    	<div class="IndChaZ fr" data-aos="fade-left" aos-delay="50">
        	<div class="IndChaZt">费率超低</div>
            <p>支付渠道直接对接官方，直接去掉中间商的差价，因此我们可以给商户提供更低廉的费率</p>
            <a href="javascript:;" class="ButAN backB1">立即体验</a>
        </div>        
        <div class="clear"></div>
    </div>
</div>
</div>
<div class="footer">
    <div class="footN">
        <div class="footF fl">
        	<div class="footFk"><i class="footF1 fl"></i>0746-123456789</div>
            <div class="footFk"><i class="footF2 fl"></i><a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&Site=pay&Menu=yes" target="_blank"><?php echo $conf['kfqq']?></a></div>
            <div class="footFm"><i class="footF3 fl"></i><a href="mailto:<?php echo $conf['email']?>"><?php echo $conf['email']?></a></div>
        </div>
        <div class="footR fl">
            <div class="footRT">快速通道</div>
            <a href="/user/" style="display:block; width:70px" target="_blank">商户登录</a>
            <a href="/user/reg.php" style="display:block; width:70px" target="_blank">商户注册</a>
           
        </div>
        <div class="footR fl">
            <div class="footRT">更多内容</div>
              <a href="/doc.html" style="display:block; width:70px" target="_blank">帮助中心</a>
              <a href="/doc.html" style="display:block; width:70px" target="_blank">开发文档</a>
        </div>
        <div class="footR fl">
            <div class="footRT">服务协议</div>
            <a href="/agreement.html" style="display:block; width:70px" target="_blank">服务协议</a>
            <a href="/agreement.html" style="display:block; width:70px" target="_blank">法律声明</a>
        </div>        <div class="clear"></div>
    </div>
    <div class="footC">
    	<p><?php echo $conf['footer']?></p>
        <p><?php echo $conf['sitename']?>&nbsp;&nbsp;&copy;2020&nbsp;All Rights Reserved.</p>
	</div>
</div> 
<!--尾-结束-->
<a href="#0" class="cd-top">Top</a>
<script type="text/javascript">
AOS.init({
	easing: 'ease-in',
	duration: 800,
	disable: 'mobile'
});  
jQuery(document).ready(function($) {
	
})
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
	//下拉
	$('.HelpNs').click(function(){	  
	  if($(this).find('.HelpA').is(':visible')){
		$(this).find('.HelpA').slideUp(100);
	  }else{
		$(this).find('.HelpA').slideDown(200);
	  }
	});

	$('.helpc').click(function(){	  
	  $("#index").hide();
	  $("#faq").show();
	});
})

</script>
</body>
</html>

