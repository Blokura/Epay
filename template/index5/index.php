<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=yes">
		<title><?php echo $conf['title']?></title>
		<meta name="keywords" content="<?php echo $conf['keywords']?>">
		<meta name="description" content="<?php echo $conf['description']?>">
		<link rel="stylesheet" href="<?php echo STATIC_ROOT?>css/qietu.css">
		<link rel="stylesheet" href="<?php echo STATIC_ROOT?>css/iconfont.css">
		<link rel="stylesheet" href="<?php echo STATIC_ROOT?>css/animate.min.css">
		<link rel="stylesheet" href="<?php echo STATIC_ROOT?>css/style.css">
		<link rel="stylesheet" href="<?php echo STATIC_ROOT?>css/responsive.css">
	</head>
	<body>
		<div class="header bj-3d7bf8">
			<div class="wrapper">
				<div class="logo">
					<a href="./">
						<?php echo $conf['sitename']?>
					</a>
				</div>
				<div class="nav-wrap">
					<div class="nav">
						<ul>
							<a href="/">
								<li class="home_index">
									<strong>
										首页
									</strong>
								</li>
							</a>
							<?php if($conf['test_open']){?><a href="/user/test.php">
								<li class="home_index">
									<strong>
										DEMO体验
									</strong>
								</li>
							</a><?php }?>
							<a href="/doc.html">
								<li class="home_index">
									<strong>
										开发文档
									</strong>
								</li>
							</a>
						</ul>
					</div>
					<div class="btns">
						<ul>
							<li class="">
								<a href="/user/">
									登录
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="gh">
					<a href="#">
					</a>
				</div>
			</div>
		</div>
		<div class="hbanner">
			<div class="wrapper">
				<div class="wow fadeInLeft hbanner-txt g-txt">
					<h2>
						<?php echo $conf['sitename']?>/Payment
						<br>
						<font>
							让支付接入前所未有的简单
						</font>
					</h2>
					<p>
						无需后端开发，一个SDK即可接入一套完整的支付系统，高速集成主流支付接口，以更稳定的接口、更快的速度直达支付。<br />
						结算费率低至0.05%，单笔交易费率低至3%。
					</p>
				</div>
				<div class="wow fadeInRight hbanner-img g-img">
					<img src="<?php echo STATIC_ROOT?>images/banner-1.png">
				</div>
			</div>
		</div>
		<div class="hnav">
			<div class="wrapper">
				<ul>
					<li>
						<div class="img">
							<img src="<?php echo STATIC_ROOT?>images/img_01.png" alt="">
						</div>
						<div class="txt">
							<h2>
								快速高效
							</h2>
							<p>
								10分钟超快速响应，1V1专业客
								<br>
								服服务，7*24小时技术支持。
							</p>
						</div>
					</li>
					<li>
						<div class="img">
							<img src="<?php echo STATIC_ROOT?>images/img_02.png" alt="">
						</div>
						<div class="txt">
							<h2>
								稳定持久
							</h2>
							<p>
								多机房异地容灾系统，服务器可用
								<br>
								性99.9%，专业运维团队值守。
							</p>
						</div>
					</li>
					<li>
						<div class="img">
							<img src="<?php echo STATIC_ROOT?>images/img_03.png" alt="">
						</div>
						<div class="txt">
							<h2>
								快速高效
							</h2>
							<p>
								金融级安全防护标准，强有力抵
								<br>
								御外部入侵，支持高并发交易。
							</p>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="hhelp">
			<div class="wrapper">
				<div class="hhelp-hd g-hd">
					<h2 class="wow fadeInUp">
						最专业的支付帮手
					</h2>
					<p class="wow fadeInUp" data-wow-delay=".5s">
						-Payment Assistant-
					</p>
				</div>
				<div class="wow fadeInUp hhelp-bd" data-wow-delay=".5s">
					<ul class="clear">
						<li class="s">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_04.png">
							</div>
							<div class="txt">
								<h2>
									手机APP支付
								</h2>
								<h4>
									APP内实现收款
								</h4>
							</div>
						</li>
						<li>
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_05.png">
							</div>
							<div class="txt">
								<h2>
									手机网页支付
								</h2>
								<h4>
									手机浏览器内实现收款
								</h4>
							</div>
						</li>
						<li>
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_06.png">
							</div>
							<div class="txt">
								<h2>
									公众号支付
								</h2>
								<h4>
									微信浏览器内实现收款
								</h4>
							</div>
						</li>
						<li class="s">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_07.png">
							</div>
							<div class="txt">
								<h2>
									PC网页支付
								</h2>
								<h4>
									PC浏览器内实现收款
								</h4>
							</div>
						</li>
						<li class="s">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_08.png">
							</div>
							<div class="txt">
								<h2>
									线下扫码支付
								</h2>
								<h4>
									扫描二维码实现收款
								</h4>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="hpro">
			<div class="wrapper">
				<div class="hpro-hd g-hd">
					<h2 class="wow fadeInUp">
						产品与服务
					</h2>
					<p class="wow fadeInUp" data-wow-delay=".5s">
						-PRODUCT SERVICE-
					</p>
				</div>
				<div class="hpro-bd">
					<ul>
						<li>
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_09.png">
							</div>
							<div class="txt">
								<h2>
									财务对账
								</h2>
								<h4>
									相近的订单统计
									<br>
									企业收支一目了然
								</h4>
							</div>
						</li>
						<li class="line-ffb573">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_10.png">
							</div>
							<div class="txt">
								<h2>
									商户系统
								</h2>
								<h4>
									添加商户账号
									<br>
									为交易实现分账功能
								</h4>
							</div>
						</li>
						<li class="line-47e7c4">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_11.png">
							</div>
							<div class="txt">
								<h2>
									接口申请
								</h2>
								<h4>
									全支付场景覆盖
									<br>
									主流支付接口支持
								</h4>
							</div>
						</li>
						<li class="line-6e94ff">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_12.png">
							</div>
							<div class="txt">
								<h2>
									二维码支付
								</h2>
								<h4>
									专业收款工具
									<br>
									线下商户经营必备
								</h4>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="pay">
			<div class="wrapper">
				<div class="pay-hd g-hd">
					<h2 class="wow fadeInUp">
						对接多家支付接口
					</h2>
					<p class="wow fadeInUp" data-wow-delay=".25s">
						-Multiple payments-
					</p>
					<p class="wow fadeInUp pay-txt" data-wow-delay=".5s">
						对接行业内最优质的多家支付接口。全力保障业务流畅。
						<br>
						让支付接口开发更加简单方便。
					</p>
				</div>
				<div class="pay-bd">
					<ul>
						<li class="wow fadeInLeft">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_13.png">
							</div>
							<div class="txt">
								<p>
									支付宝支付
								</p>
							</div>
						</li>
						<li class="wow fadeInLeft">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_14.png">
							</div>
							<div class="txt">
								<p>
									微信支付
								</p>
							</div>
						</li>
						<li class="wow fadeInRight">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_15.png">
							</div>
							<div class="txt">
								<p>
									QQ钱包
								</p>
							</div>
						</li>
						<li class="wow fadeInRight">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_16.png">
							</div>
							<div class="txt">
								<p>
									银联支付
								</p>
							</div>
						</li>
						<li class="wow fadeInLeft">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_17.png">
							</div>
							<div class="txt">
								<p>
									京东支付
								</p>
							</div>
						</li>
						<li class="wow fadeInLeft">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_18.png">
							</div>
							<div class="txt">
								<p>
									百度钱包
								</p>
							</div>
						</li>
						<li class="wow fadeInRight">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_19.png">
							</div>
							<div class="txt">
								<p>
									Apple Pay
								</p>
							</div>
						</li>
						<li class="wow fadeInRight">
							<div class="img">
								<img src="<?php echo STATIC_ROOT?>images/img_20.png">
							</div>
							<div class="txt">
								<p>
									蚂蚁花呗
								</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="hview even">
			<div class="wrapper">
				<div class="wow fadeInRight hview-img img">
					<img src="<?php echo STATIC_ROOT?>images/img_21.png">
				</div>
				<div class="wow fadeInLeft hview-txt txt">
					<h2 class=" line-27">
						定制化支付解决方案
					</h2>
					<ul>
						<li>
							<i class="iconfont icon-xuanzhongzhuangtai">
							</i>
							支持不同业务场景的交易方式。
						</li>
						<li>
							<i class="iconfont icon-xuanzhongzhuangtai">
							</i>
							免费在线一对一分析支付场景、梳理企业收款需
							<br>
							求，提出接入建议、定制支付解决方案。
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="hview odd">
			<div class="wrapper">
				<div class="wow fadeInLeft hview-img img">
					<img src="<?php echo STATIC_ROOT?>images/img_22.png">
				</div>
				<div class="wow fadeInRight hview-txt txt">
					<h2 class="line-27 line-a996fa">
						专业的全流程服务
					</h2>
					<ul>
						<li>
							<i class="iconfont icon-xuanzhongzhuangtai">
							</i>
							支持个性化定制和私有化部署。
						</li>
						<li>
							<i class="iconfont icon-xuanzhongzhuangtai">
							</i>
							全程跟进定制化业务需求，可部署企业本地服务器，数据安全可控。
						</li>
						<li>
							<i class="iconfont icon-xuanzhongzhuangtai">
							</i>
							客户成功团队从接口联调、测试上线到后期系统运维、管理平台
							<br>
							使用等各方向全面提供7*10小时服务。
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="hpartner">
			<div class="wrapper">
				<div class="hpart-hd g-hd">
					<h2 class="wow fadeInUp">
						我们的伙伴
					</h2>
					<p class="wow fadeInUp" data-wow-delay=".4s">
						-Our partners-
					</p>
				</div>
				<div class="hpart-bd">
					<div class="hpart-prev">
						<i class="iconfont icon-zuo">
						</i>
					</div>
					<div class="hpart-list">
						<div class="list-wrper">
							<ul class="hpart-list-wrapper">
								<li class="hpart-list-item">
									<dl>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_1.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_2.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_3.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_4.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_5.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_6.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_7.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_8.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_9.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_10.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_11.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_12.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_13.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_14.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_15.png">
											</a>
										</dd>
									</dl>
								</li>
								<li class="hpart-list-item">
									<dl>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_1.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_2.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_3.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_4.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_5.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_6.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_7.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_8.png">
											</a>
										</dd>
										<dd>
											<a href="javascript:;">
												<img src="<?php echo STATIC_ROOT?>images/slider_9.png">
											</a>
										</dd>
									</dl>
								</li>
							</ul>
						</div>
					</div>
					<div class="hpart-next">
						<i class="iconfont icon-you">
						</i>
					</div>
				</div>
			</div>
		</div>
		<div class="hstart">
			<div class="wrapper">
				<div class="wow fadeInLeft hstart-txt">
					<h2>
						立即开启支付新时代！
					</h2>
					<p>
						<?php echo $conf['sitename']?>，支付技术服务商，让支付简单、专业、快捷！
					</p>
				</div>
				<div class="wow fadeInRight hstart-btn ">
					<a class="g-btn" href="/user/">立即开启</a>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="wrapper">
				<dl class="s">
					<dt>
						联系我们
					</dt>
					<dd>
						联系方式
						<p> 商务合作QQ:
							<?php echo $conf['kfqq']?>
						</p>
						<p> Email:<a href="mailto:<?php echo $conf['email']?>">
								<?php echo $conf['email']?></a></p>
					</dd>
					<dd>

					</dd>
				</dl>
				<dl>
					<dt>
						产品项目
					</dt>
					<dd>
						商户系统
					</dd>
					<dd>
						二维码支付
					</dd>
					<dd>
						H5支付
					</dd>
				</dl>
				<dl>
					<dt>
						关于我们
					</dt>
					<dd>
						<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=pay&menu=yes">
							接口合作
						</a>
					</dd>
					<dd>
						<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=pay&menu=yes">
							流量合作
						</a>
					</dd>
				</dl>
				<dl>
					<dt>
						开发者
					</dt>
					<dd>
						<a href="/user/test.php">
							DEMO体验
						</a>
					</dd>
					<dd>
						<a href="doc.html">
							API开发文档
						</a>
					</dd>
					<dd>

					</dd>
				</dl>
				<dl class="s">
					<dt>
						友情链接
					</dt>
					<dd>
						<a href="http://blog.cccyun.cn" target="_blank">
							缤纷彩虹天地
						</a>
					</dd>
					<dd>
						<a href="./" target="_blank">
							待添加
						</a>
					</dd>
				</dl>
			</div>
		</div>
		<div class="copyright">
			<div class="wrapper">
				<?php echo $conf['sitename']?>&nbsp;&nbsp;&copy;&nbsp;2020&nbsp;All Rights Reserved.&nbsp;<?php echo $conf['footer']?>
			</div>
		</div>
		<div class="sidebar">
			<ul>
				<li class="sidebar-scroll">
					<a href="#">
						<i class="iconfont icon-shang">
						</i>
					</a>
				</li>
			</ul>
		</div>
		<script type="text/javascript" src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js">
		</script>
		<script type="text/javascript" src="<?php echo STATIC_ROOT?>js/jquery.glide.js">
		</script>
		<script type="text/javascript" src="<?php echo STATIC_ROOT?>js/wow.min.js">
		</script>
		<script type="text/javascript" src="<?php echo STATIC_ROOT?>js/script.js">
		</script>
		<script type="text/javascript">
			$(function() {
				//$(".home_index").addClass("on");
				$('.sidebar-scroll').click(function() {
					$('html ,body').animate({
						scrollTop: 0
					}, 1000);
					return false
				});
				var glide = $('.list-wrper').glide({
					arrows: false
				}).data('api_glide');
				$(".hpart-prev").click(function() {
					glide.prev()
				});
				$(".hpart-next").click(function() {
					glide.next()
				})
			})
		</script>
	</body>
</html>
