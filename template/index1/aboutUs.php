<?php
if(!defined('IN_CRONLITE'))exit();
require INDEX_ROOT.'head.php';
?>
<div class="about_banner">
	<div class="about_img">
		<img src="<?php echo STATIC_ROOT?>picture/about_us.jpg" />
	</div>
</div>
<div class="block_text history">
	<div class="about_info">
		<p>
			<?php echo $conf['orgname']?><br /> 成立于2016年10月，公司业务面向企业SAAS服务， <br /> 主要核心产品是支付清结算云服务：云支付、云结算、云钱包、云电商、大数据； <br /> 在此核心产品基础上为企业提供全面整套的互联网+解决方案，与企业开放、合作、共赢！ <br /> 我们为企业提供网上支付SAAS系统方案，企业只需要在平台注册商务服务账号， <br /> 通过SAAS前台服务填写对应的参数，签订好相关的法律协议即可使用， <br /> 无需企业再次开发相应支付系统，根据使用接口的情况收取服务费用， <br /> <?php echo $conf['sitename']?>仅收取相应套餐费用和套餐内增值业务费用。
		</p>
	</div>
</div>
<div class="block_text history">
	<h1 class="history_title">
		发展历程
	</h1>
	<div class="history_main">
		<div class="year_div">
			<h2>
				<a href="javascript:;">2016年<i></i></a> 
			</h2>
			<div class="list">
				<ul class="clearfix">
					<li class="cls highlight">
						<div class="circle">
						</div>
						<p class="date">
							10月
						</p>
						<div class="round_div">
							<p class="intro">
								我们的公司成立了！
							</p>
							<div class="company_info">
								<p>
									2016年10月，<?php echo $conf['orgname']?>在中国注册成立。
								</p>
							</div>
						</div>
					</li>
					<li class="cls">
						<div class="circle">
						</div>
						<p class="date">
							11月15日
						</p>
						<div class="round_div">
							<p class="intro">
								开始制作我们的产品——<?php echo $conf['sitename']?>！
							</p>
							<div class="company_info">
								<p>
									2016年11月15日，团队组建完毕，一切准备就绪，终于要开始制作我们的产品了。
								</p>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<h2>
				<a href="javascript:;">2017年<i></i></a> 
			</h2>
			<div class="list">
				<ul class="clearfix">
					<li class="cls">
						<div class="circle">
						</div>
						<p class="date">
							2月15日
						</p>
						<div class="round_div">
							<p class="intro">
								<?php echo $conf['sitename']?> 上线了！
							</p>
							<div class="company_info">
								<p>
									2017年2月15日，经过三个月多月的努力和磨合，我们的产品要上线了!
								</p>
							</div>
						</div>
					</li>
					<li class="cls">
						<div class="circle">
						</div>
						<p class="date">
							6月8日
						</p>
						<div class="round_div">
							<p class="intro">
								<?php echo $conf['sitename']?> 进行系统升级！
							</p>
							<div class="company_info">
								<p>
									2017年6月8日，经过三个多月的运营，从中汲取经验后再由策划专业分析，我们的产品要升级了!
								</p>
							</div>
						</div>
					</li>
					<li class="cls">
						<div class="circle">
						</div>
						<p class="date">
							12月7日
						</p>
						<div class="round_div">
							<p class="intro">
								<?php echo $conf['sitename']?> V2.0上线了！
							</p>
							<div class="company_info">
								<p>
									2017年12月15日，经过两个月的努力技术开发和业务整改，我们的系统终于完成升级了!
								</p>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!--div class="block_text history">
	<h1 class="history_title">
		合作伙伴
	</h1>
</div-->
<div class="block_text history">
	<h1 class="history_title">
		联系我们
	</h1>
	<div class="row">
		<div class="4u 12u(mobile)">
			<div class="contact_block">
				<img src="<?php echo STATIC_ROOT?>picture/icon_adress.png" />‍
				<div class="contact_text">
					<h3>
						公司地址
					</h3>
					<div>
						深圳市龙岗区布吉街道三联社区景芬路9号
					</div>
					<p>
						邮编：230011
					</p>
					<p class="button_box">
					</p>
				</div>
			</div>
		</div>
		<div class="4u 12u(mobile)">
			<div class="contact_block">
				<img src="<?php echo STATIC_ROOT?>picture/icon_qq.png" />‍
				<div class="contact_text">
					<h3>
						联系方式
					</h3>
					<p>
						QQ：<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&Site=pay&Menu=yes" target="_blank"><?php echo $conf['kfqq']?></a>
					</p>
					<p>
						邮箱：<a href="mailto:<?php echo $conf['email']?>"><?php echo $conf['email']?></a>
					</p>
					<p class="button_box">
					</p>
				</div>
			</div>
		</div>
		<div class="4u 12u(mobile)">
			<div class="contact_block">
				<img src="<?php echo STATIC_ROOT?>picture/icon_weixin.png" />‍
				<div class="contact_text">
					<h3>
						关注我们
					</h3>
					<div class="weixin_box">
						<img src="assets/img/weixin.jpg" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="block_text history">
	<h1 class="history_title">
		加入我们
	</h1>
	<div class="about_info">
		<p>
			如果你有兴趣成为我们的团队的一部分,请把你的简历和求职信至
			<a href="mailto:<?php echo $conf['email']?>"><?php echo $conf['email']?></a>,<br /> 我们将很快与您联系。
		</p>
	</div>
</div>
<?php require INDEX_ROOT.'foot.php';?>