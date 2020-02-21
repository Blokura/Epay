<?php
if(!defined('IN_CRONLITE'))exit();
require INDEX_ROOT.'head.php';
?>
<div class="cd-fixed-bg cd-bg-1 banner" id="banner">
	<div class="container clearfix">
		<div class="banner_img">
			<img class="ie_img" src="<?php echo STATIC_ROOT?>picture/phone.png" />
			<div class="image phone">
				<div class="inner">
					<div class="slide_box">
						<ul class="slider_pic">
							<li class="beijia_img">
								<img src="<?php echo STATIC_ROOT?>picture/ispay_1.png" />
							</li>
							<li class="weixin_img">
								<img src="assets/img/weixin.jpg" />
								<p>
									扫一扫关注<?php echo $conf['sitename']?>
								</p>
							</li>
						</ul>
						<ul class="slider_btn">
							<li>
							</li>
							<li>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="banner_text">
			<h2>
				<span>专业的收银系统</span> 
			</h2>
			<p>全面集成主流支付渠道，为企业提供解决<span>收款</span><span>付款</span><span>结算</span><span>营销</span>等问题的技术方案</p>
			<p>提供企业统一管理电子钱包的技术方案</p>

			<br />
			<a href="/user/reg.php" class="button alt" target="_blank">注册使用</a>
		</div>
	</div>
</div>
<div class="cd-scrolling-bg bg_white">
	<div class="container">
		<h2>
			云支付（全支付场景及渠道覆盖）
		</h2>
		<p>
			支持支付宝、微信、银联、QQ钱包、快钱等主流支付渠道，让您拥有PC网页支付、扫码支付、手机APP支付、移动HTML5支付、微信公众号支付。
		</p>
		<div class="image align-center">
			<img src="<?php echo STATIC_ROOT?>picture/use01.png" alt="" />
		</div>
	</div>
</div>
<div class="cd-scrolling-bg bg_gary">
	<div class="container">
		<h2>
			云钱包
		</h2>
		<p>
			企业通过<?php echo $conf['sitename']?>为用户提供统一虚拟账户，提升用户支付体验，为拓展增值服务提供基础
		</p>
		<div class="image align-center">
			<img src="<?php echo STATIC_ROOT?>picture/use02.png" alt="" />
		</div>
	</div>
</div>
<div class="cd-scrolling-bg bg_white">
	<div class="container">
		<h2>
			云结算
		</h2>
		<p>
			通过简单的页面配置，可以替代复杂繁琐的人工资金结算业务，提高业务实时性，降低错误
		</p>
		<div class="image align-center">
			<img src="<?php echo STATIC_ROOT?>picture/use03.png" alt="" />
		</div>
	</div>
</div>
<div class="cd-scrolling-bg bg_gary">
	<div class="container">
		<h2>
			我们的优势
		</h2>
		<div class="row">
			<div class="6u 12u(mobile)">
				<div class="advantage_img align-center">
					<img src="<?php echo STATIC_ROOT?>picture/adv01.png" />
				</div>
				<div class="box_item">
					<h4>
						降低研发成本
					</h4>
					<div class="content">
						<p>
							简单快速的接入方式，缩短开发周期，实现快速上线。
						</p>
					</div>
				</div>
			</div>
			<div class="6u 12u(mobile)">
				<div class="advantage_img align-center">
					<img src="<?php echo STATIC_ROOT?>picture/adv02.png" />
				</div>
				<div class="box_item">
					<h4>
						轻松结算对账
					</h4>
					<div class="content">
						<p>
							降低财务人员在结算方面投入的时间和精力，客服人员也可以轻松查看账户明细
						</p>
					</div>
				</div>
			</div>
			<div class="6u 12u(mobile)">
				<div class="advantage_img align-center">
					<img src="<?php echo STATIC_ROOT?>picture/adv03.png" />
				</div>
				<div class="box_item">
					<h4>
						全面开放API
					</h4>
					<div class="content">
						<p>
							让企业更加自主的使用<?php echo $conf['sitename']?>相关服务
						</p>
					</div>
				</div>
			</div>
			<div class="6u 12u(mobile)">
				<div class="advantage_img align-center">
					<img src="<?php echo STATIC_ROOT?>picture/adv04.png" />
				</div>
				<div class="box_item">
					<h4>
						安全稳定高效
					</h4>
					<div class="content">
						<p>
							HTTPS传输加密，REST API调用数字签名验证，ACL权限控制，严格保护客户数据的安全和隐私
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="cd-scrolling-bg bottom_bg">
	<div class="konw_morebox">
		<div class="container">
			<h2 style="color: #FFFFFF;">
				想要了解更多
			</h2>
			<div class="row">
				<div class="4u 12u(mobile)">
					<a href="produceIntroduce.html" class="know_more icon fa-chain">
						<h4>
						了解更多
					</h4>
						<p>
							你也许还有更多疑问，我们的帮助中心会为您提供答案
						</p>
					</a>
				</div>
				<div class="4u 12u(mobile)">
					<a href="doc.html" class="know_more icon fa-credit-card">
						<h4>
						开发文档
					</h4>
						<p>
							获取对接我们的API接口以及SDK
						</p>
					</a>
				</div>
				<div class="4u 12u(mobile)">
					<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&Site=pay&Menu=yes" target="_blank" class="know_more icon fa-users">
						<h4>
						商务合作
					</h4>
						<p>
							如果有什么需求或者意见，我们期待您的联系。
						</p>
					</a>
				</div>
			</div>
			<p class="align-center">
				<br />
				<br />
				<a href="/user/reg.php" class="button big alt" target="_blank">注册成为会员</a>
			</p>
		</div>
	</div>
</div>
<!-- Scripts -->
<script>
	(function($) {
		$('body').addClass('landing');
		$('#header').addClass('alt');
	})(jQuery);
</script>
<?php require INDEX_ROOT.'foot.php';?>