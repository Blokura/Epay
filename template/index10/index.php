<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $conf['title']?></title>
	<meta name="keywords" content="<?php echo $conf['keywords']?>">
	<meta name="description" content="<?php echo $conf['description']?>">
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/default.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/animate.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/aos.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/header_common.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/index_main.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/common_contact.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT?>css/media.css" />
		<script src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>
		<script src="<?php echo STATIC_ROOT?>js/aos.js"></script>
		<script src="<?php echo STATIC_ROOT?>js/xs.js"></script>
		<script src="<?php echo STATIC_ROOT?>js/common_js.js"></script>
		<script src="<?php echo STATIC_ROOT?>js/index_main.js"></script>
	</head>
	<body aos-easing="ease-out-back" aos-duration="1000" aos-delay="0">
		<!--头-->
     <header class="index_header">
			<!--顶部-->
			<div class="navBox">
				<div class="logo left">
					<img src="assets/img/logo.png" alt="<?php echo $conf['sitename']?>" draggable="false">
				</div>
				<div class="navBox_right right">
					<ul class="nav left">
						
												<li class="left"><a href="/" >网站首页</a></li>
												<?php if($conf['test_open']){?><li class="left"><a href="/user/test.php" rel="nofollow">DEMO体验</a></li><?php }?>
												<li class="left"><a href="doc.html" rel="nofollow">API开发文档</a></li>
												<li class="left"><a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=pay&menu=yes" rel="nofollow">联系我们</a></li>
 
											</ul>
					<a class="btn_common login left active" href="/user/" rel="nofollow">登录</a>
					<a class="btn_common login left active" href="/user/reg.php" rel="nofollow">注册</a>
					
 
				</div>
			</div>
			<div class="center">
				<div class="banner">
					<div class="banner_left left">
						<div class="text1 animated bounceInLeft">全新支付体验</div>
						<div class="text1_line animated bounceInLeft"></div>
						<p aos="fade-right" class="banner_p animated bounceInRight aos-init aos-animate">资金记录、订单记录、收益统计、渠道分析...</p>
						<p aos="fade-right" class="banner_p animated bounceInRight aos-init aos-animate">全响应式界面，简易操作，安全便利快捷，为您稳定服务。</p>
<!-- 						<a class="banner_btnContact animated wobble xs_li_07" href="javascript:;" style="position: relative;">
							<span style="position: relative; z-index: 2;">大客户请联系我们</span>
						<canvas width="208" height="54" style="position: absolute; top: 0px; left: 0px; z-index: 2;"></canvas>
						<canvas width="208" height="54" style="position:absolute; top:0; left:0; z-index:1;"></canvas></a> -->
					</div>
					<div class="banner_right right animated bounceInRight">
						<img src="<?php echo STATIC_ROOT?>picture/banner_right.png" alt="<?php echo $conf['sitename']?>-一个好用的免签约支付接口" draggable="false">
					</div>
				</div>
			</div>
		</header>
		<!--支付方式-->
		<div class="center">
			<div aos="zoom-in" class="payment_box animated zoomIn">
				<ul class="payment_ul">
					<li class="left payment_item1">
						<a href="javascript:;">
							<img class="img1" src="<?php echo STATIC_ROOT?>picture/payment_1.png" alt="<?php echo $conf['sitename']?>-免签约支付宝扫码H5支付" draggable="false" />
						</a>
					</li>
					<li class="left payment_item2">
						<a href="javascript:;">
							<img class="img1" src="<?php echo STATIC_ROOT?>picture/payment_2.png" alt="<?php echo $conf['sitename']?>-免签约微信扫码公众号H5支付" draggable="false" />
						</a>
					</li>
					<li class="left payment_item3">
						<a href="javascript:;">
							<img class="img1" src="<?php echo STATIC_ROOT?>picture/payment_3.png" alt="<?php echo $conf['sitename']?>-银联在线快捷支付" draggable="false" />
						</a>
					</li>
					<li class="left payment_item4">
						<a href="javascript:;">
							<img class="img3" src="<?php echo STATIC_ROOT?>picture/payment_4.png" alt="<?php echo $conf['sitename']?>-QQ钱包免签约扫码H5支付" draggable="false" />
						</a>
					</li>
					<li class="left payment_item5">
						<a href="javascript:;">
							<img class="img3" src="<?php echo STATIC_ROOT?>picture/payment_5.png" alt="<?php echo $conf['sitename']?>-免签约京东支付" draggable="false" />
						</a>
					</li>
					<li class="left payment_item6">
						<a href="javascript:;">
							<img class="img3" src="<?php echo STATIC_ROOT?>picture/payment_6.png" alt="<?php echo $conf['sitename']?>-免签约百度钱包支付" draggable="false" />
						</a>
					</li>
					<li class="left payment_item7">
						<a href="javascript:;">
							<img class="img2" src="<?php echo STATIC_ROOT?>picture/payment_7.png" alt="<?php echo $conf['sitename']?>-免签约财付通支付" draggable="false" />
						</a>
					</li>
					<li class="left payment_item8">
						<a href="javascript:;">
							正在接入...
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!--HHYPAY简介-->
		<div class="about">
			<div class="center">
				<div aos="zoom-in" class="about_main aos-init aos-animate">
					<span class="title_common about_title pingFang"><?php echo $conf['sitename']?>简介</span>
					<span class="about_line right"></span>
					<div class="about_txt">
						<p class="pingFang"><?php echo $conf['orgname']?>成立于2018年，<?php echo $conf['sitename']?>（<?php echo $_SERVER['HTTP_HOST']?>）。</p>
						<p class="pingFang"><?php echo $conf['sitename']?>平台主要服务于互联网和移动互联网领域，为网页游戏、手机游戏、阅读、音乐、交友、教育等移动应用提供综合计费营销服务，创新、诚信、灵和活多元,创新是企业发展的灵魂。</p>
						<p class="pingFang">我们打破了传统聚合支付网站几年来一成不变的局面，建立了新一代聚合支付的行业方向，我们将引领聚合支付交易过程的个性化、自动化、工具化等。作为业内最善于创新的网站，力争成为行业的佼佼者。</p>
					</div>
					<!--<div class="about_more pingFang">更多</div>-->
					<!--a href="/Home_Index_userLogin.html" target="_blank" class="about_more pingFang">更多</a-->
				</div>
			</div>
			<div class="about_right">
				<div class="about_rightMain">
					<img aos="fade-up-right" class="about_rightImg1 aos-init aos-animate" src="<?php echo STATIC_ROOT?>picture/about_rightimg1.png" alt="" draggable="false" />
					<div class="about_rightCenter">
					</div>
					<img aos="fade-up-left" class="about_rightImg2 aos-init aos-animate" src="<?php echo STATIC_ROOT?>picture/about_rightimg2.png" alt="" draggable="false" />
				</div>
			</div>
		</div>
		<!--商户流程-流程-->
		<div aos="zoom-in" class="process aos-init aos-animate">
			<div class="center">
				<div class="process_main">
					<span class="title_common process_title pingFang animated slideInUp">成为<?php echo $conf['sitename']?>商户仅需六步</span>
					<span class="process_line animated zoomIn"></span>
					<span class="process_h4 pingFang animated slideInDown"><?php echo $conf['sitename']?>让你轻松做生意</span>
					<ul class="process_ul">
						<li class="left animated bounceInLeft">
							<img src="<?php echo STATIC_ROOT?>picture/process_1.png" alt="<?php echo $conf['sitename']?>-注册商户-在线自助注册" draggable="false" />
							<span class="process_txt1 pingFang">注册商户</span>
							<span class="process_txt2 pingFang">在线自助注册</span>
						</li>
						<li class="left animated bounceInLeft">
							<img src="<?php echo STATIC_ROOT?>picture/process_2.png" alt="<?php echo $conf['sitename']?>-绑定银行-轻松设置商户信息" draggable="false" />
							<span class="process_txt1 pingFang">绑定银行</span>
							<span class="process_txt2 pingFang">轻松设置商户信息</span>
						</li>
						<li class="left animated bounceInLeft">
							<img src="<?php echo STATIC_ROOT?>picture/process_3.png" alt="<?php echo $conf['sitename']?>-接口对接-全平台SDK支持" draggable="false" />
							<span class="process_txt1 pingFang">接口对接</span>
							<span class="process_txt2 pingFang">全平台SDK支持</span>
						</li>
						<li class="left animated bounceInRight">
							<img src="<?php echo STATIC_ROOT?>picture/process_4.png" alt="<?php echo $conf['sitename']?>-自助下单-会员支付一键直达" draggable="false" />
							<span class="process_txt1 pingFang">自助下单</span>
							<span class="process_txt2 pingFang">会员支付一键直达</span>
						</li>
						<li class="left animated bounceInRight">
							<img src="<?php echo STATIC_ROOT?>picture/process_5.png" alt="<?php echo $conf['sitename']?>-全天客服-7*24小时专业服务" draggable="false" />
							<span class="process_txt1 pingFang">全天客服</span>
							<span class="process_txt2 pingFang">7*24小时专业服务</span>
						</li>
						<li class="left animated bounceInRight">
							<img src="<?php echo STATIC_ROOT?>picture/process_6.png" alt="<?php echo $conf['sitename']?>-自动结算-信誉无忧充分保障" draggable="false" />
							<span class="process_txt1 pingFang">自动结算</span>
							<span class="process_txt2 pingFang">信誉无忧充分保障</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!--品牌优势-->
		<div class="advantage" id="advantage">
			<div class="advantage_topBox">
				<div aos="fade-up-right" class="leftImg_common1 rightImg_common2 advantage_topL aos-init aos-animate"></div>
				<div class="center centerRe">
					<div aos="flip-left" class="advantage_topMain aos-init aos-animate">
						<span class="advantage_common advantage_title pingFang">品牌优势</span>
						<span class="advantage_line"></span>
						<span class="advantage_common advantage_txt pingFang">全年365天持续运行,每天正常下款<br>根据行业的不同和交易量<br>实行T0/T1,D0/D1结算,请联系客服</span>
					</div>
				</div>
				<div aos="fade-up-left" class="rightImg_common1 leftImg_common2 advantage_topR aos-init aos-animate"></div>
			</div>
			<div class="center">
				<ul class="advantage_botMain">
					<li class="left">
						<img aos="zoom-in-up" class="aos-init aos-animate" src="<?php echo STATIC_ROOT?>picture/advantage_1.png" alt="<?php echo $conf['sitename']?>-服务器安全、速度、稳定" draggable="false" />
						<span aos="flip-up" class="advantage_botTxt pingFang aos-init aos-animate">服务器安全</span>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">采用群集服务器,防御高,</p>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">故障率低,无论用户身在何方,</p>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">均能获得流畅安全可靠的体验</p>
					</li>
					<li class="left li_margin">
						<img aos="zoom-in-up" class="aos-init aos-animate" src="<?php echo STATIC_ROOT?>picture/advantage_2.png" alt="<?php echo $conf['sitename']?>-资金安全有保障" draggable="false" />
						<span aos="flip-up" class="advantage_botTxt pingFang aos-init aos-animate">资金保障</span>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">结算及时，资金秒到</p>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">资金平均停留的时间不超过12小时,</p>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">您的资金安全将得到充分的保障.</p>
					</li>
					<li class="left li_margin">
						<img aos="zoom-in-up" class="aos-init aos-animate" src="<?php echo STATIC_ROOT?>picture/advantage_3.png" alt="<?php echo $conf['sitename']?>-持续更新用的安心" draggable="false" />
						<span aos="flip-up" class="advantage_botTxt pingFang aos-init aos-animate">持续更新</span>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">系统持续更新,功能持续完善,</p>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">让商户以及客户的体验不断接近</p>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">完美是我们一直不变的追求.</p>
					</li>
					<li class="left">
						<img aos="zoom-in-up" class="aos-init aos-animate" src="<?php echo STATIC_ROOT?>picture/advantage_4.png" alt="<?php echo $conf['sitename']?>-界面简约，操作简单" draggable="false" />
						<span aos="flip-up" class="advantage_botTxt pingFang aos-init aos-animate">界面简约</span>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">简约的UI交互体验可以</p>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">给您一个体验度极高的商户后台,</p>
						<p aos="flip-up" class="advantage_botP pingFang aos-init aos-animate">更好的使用体验.</p>
					</li>
				</ul>
			</div>
		</div>
		<!--联系我们-->
		<div class="contact_comBox contact_box" id="contact_box">
			<div class="contactUs_index contactUs">
				<div class="center">
					<p aos="zoom-out-down" class="contactUs_indexTitle contactUs_title pingFang aos-init aos-animate">联系我们</p>
					<p aos="zoom-out-down" class="contactUs_line aos-init aos-animate"></p>
					<ul aos="zoom-in-up" class="contactUs_main aos-init aos-animate">
						<li class="left contactUs_liMargin1">
							<span class="contactUs_icon contactUs_icon1"></span>
							<span class="contactUs_mainTit pingFang_bold">公司地址</span>
							<span class="contactUs_mainLine"></span>
							<span class="contactUs_mainTxt pingFang">xxxxxx</span>
							<span class="contactUs_mainBot"></span>
						</li>
						<li class="left contactUs_liMargin2">
							<span class="contactUs_icon contactUs_icon2"></span>
							<span class="contactUs_mainTit pingFang_bold">联系方式</span>
							<span class="contactUs_mainLine"></span>
							
								<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=pay&menu=yes" rel="nofollow"target="_blank" class="contactUs_mainTxt pingFang">商务QQ：<?php echo $conf['kfqq']?></a>
							<span class="contactUs_mainBot"></span>
						</li>
						<li class="left contactUs_liMargin1">
							<span class="contactUs_icon contactUs_icon3"></span>
							<span class="contactUs_mainTit pingFang_bold">电子邮箱</span>
							<span class="contactUs_mainLine"></span>
							<span class="contactUs_mainTxt pingFang"><?php echo $conf['email']?></span>
							<span class="contactUs_mainBot"></span>
						</li>
					</ul>
				</div>
			</div>
			<div class="contact_bot">
				<div aos="fade-up-right" class="leftImg_common1 leftImg_common2 contact_botL aos-init aos-animate"></div>
				<div class="center centerRe">
					<div aos="fade-left" class="contact_botMain pingFang aos-init aos-animate">
						<div class="contact_botMainTxt">马上开启全新商户体验</div>
						<a href="/user/" rel="nofollow"class="contact_botMainBtn" style="float: left;">商户登录</a>
					</div>
				</div>
				<div aos="fade-up-left" class="rightImg_common1 rightImg_common2 contact_botR aos-init aos-animate"></div>
			</div>
		</div>
		<!--底-->
				<!--底-->
		<footer>
			<div class="footer_top">
				<ul class="footer_topLeft left">
					<li class="left">
						<div class="footer_topLeftTit footer_icon1 pingFang">用户协议</div>
						<div class="footer_topLeftCon pingFang">
							<a href="#">禁售商品</a>
							<a href="#">隐私协议</a>
							<a href="#">注册协议</a>
						</div>
					</li>
					<li class="left">
						<div class="footer_topLeftTit footer_icon2 pingFang">关于我们</div>
						<div class="footer_topLeftCon pingFang">
							<a href="/user/test.php" rel="nofollow">DEMO体验</a>
							<a href="doc.html" rel="nofollow">API开发文档</a>
							<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=pay&menu=yes" rel="nofollow">联系我们</a>
						</div>
					</li>
				</ul>
				<div class="footer_topRight right">

					<div class="footer_detail left pingFang">
					 
						<p class="footer_pCom footer_tellTime">全年无休 7x24小时</p>
						<p class="footer_pCom footer_email"><?php echo $conf['email']?></p>
						<p class="footer_pCom footer_qq"> <a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=pay&menu=yes"rel="nofollow" target="_blank" style="color: #666666;"><?php echo $conf['kfqq']?></a></p>
					</div>
					<div></div>
				</div>
			</div>
			<div class="footer_bottom pingFang"> Copyright © 2016-2020 <?php echo $conf['sitename']?> All rights reserved. 版权所有
<!-- wpa start -->  

</div>
		</footer>
		<!--右侧社交固定-->
		<div class="right_fixed">
		<div class="right_common right_conBox">
				<div class="right_qqShow rightShow_common">
					<div class="rightImg_comm right_qqImg left"></div>
					<div class="rightNum_comm right_tellNum left"><?php echo $conf['kfqq']?></div>-
					<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=pay&menu=yes" rel="nofollow"target="_blank" class="rightNum_comm right_tellNum left"><?php echo $conf['kfqq']?></a>
				</div>
				<div class="right_qqPhoto rightPhoto_common right"></div>
			</div>
			<div class="right_common right_scrollTop">
				<div class="right_scrollTopPhoto right">顶部</div>
			</div>
		</div>
		<script>
			AOS.init({
				easing: 'ease-out-back',
				duration: 1000
			});
//			hljs.initHighlightingOnLoad();
	
			$('.hero__scroll').on('click', function(e) {
				$('html, body').animate({
					scrollTop: $(window).height()
				}, 1200);
			});
		</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".xs_li_07").xs999(7);
			$(".xs_li_11").xs999(11);
        });
	</script>
	</body>
</html>
