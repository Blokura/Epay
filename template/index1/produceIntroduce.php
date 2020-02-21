<?php
if(!defined('IN_CRONLITE'))exit();
require INDEX_ROOT.'head.php';
?>
<div class="container api_doc">
	<div class="api_doc_bar">
		<dl>
			<dt>
									<a href="#zfqdId">支付渠道</a>
								</dt>
		</dl>
		<dl>
			<dt>
									<a href="#kfzxId">开发中心</a>
								</dt>
		</dl>
		<dl>
			<dt>
									<a href="#glzxId">管理中心</a>
								</dt>
		</dl>
		<dl>
			<dt>
									<a href="#yyzxId">运营中心</a>
								</dt>
		</dl>
		<dl>
			<dt>
									<a href="#cwzxId">财务中心</a>
								</dt>
		</dl>
		<dl>
			<dt>
									<a href="#ktsmId">开通说明</a>
								</dt>
		</dl>

	</div>
	<div class="api_doc_content">
		<div id="zfqdId" class="api_block">
			<h3>
				支付渠道
			</h3>
			<img style="width:430px;height:430px" src="<?php echo STATIC_ROOT?>picture/yuke01.png" />
			<h4>
				PC网页支付
			</h4>
			<p>
				<?php echo $conf['sitename']?>,PC网页支付支持支付宝网页支付、支付宝扫码支付、 微信扫码支付、银联网页支付、百度钱包等。
			</p>
			<img src="<?php echo STATIC_ROOT?>picture/yuke02.png" />
			<h4>
				扫码支付
			</h4>
			<p>
				<?php echo $conf['sitename']?>,支持统一扫码支付,渠道扫码支付,包括支付宝扫码支付、 微信扫码支付等。
			</p>
			<img src="<?php echo STATIC_ROOT?>picture/yuke04.png" />
			<h4>
				微信公众号支付
			</h4>
			<p>
				<?php echo $conf['sitename']?>,为微信公众号提供全套支付解决方案： 用户可在你的微信服务号内进行微信 支付，简单便捷！
			</p>
			<img src="<?php echo STATIC_ROOT?>picture/yuke03.png" />
			<h4>
				手机APP支付
			</h4>
			<p>
				<?php echo $conf['sitename']?>,为iOS/Android原生/H5 App提供支付解决方案:支持微信支付、支付宝支付、银联手机支付、百度钱包等。
			</p>
		</div>
		<div id="kfzxId" class="api_block">
			<h3>
				开发中心
			</h3>
			<div class="row">
				<div class="4u 4u(mobile)">
					<div class="fund_text align-center">
						<i class="icon fa-code round_icon round_border"></i>
						<div class="content">
							<h4>
								集成开发
							</h4>
						</div>
					</div>
				</div>
				<div class="4u 4u(mobile)">
					<div class="fund_text align-center">
						<i class="icon fa-shield round_icon round_border"></i>
						<div class="content">
							<h4>
								安全设置
							</h4>
						</div>
					</div>
				</div>
				<div class="4u 4u(mobile)">
					<div class="fund_text align-center">
						<i class="icon fa-wrench round_icon round_border"></i>
						<div class="content">
							<h4>
								渠道配置
							</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="glzxId" class="api_block">
			<h3>
				管理中心
			</h3>
			<div class="row">
				<div class="4u 4u(mobile)">
					<div class="fund_text align-center">
						<img src="<?php echo STATIC_ROOT?>picture/kf02.png" />
						<div class="content">
							<h4>
								开发人员
							</h4>
						</div>
					</div>
				</div>
				<div class="4u 4u(mobile)">
					<div class="fund_text align-center">
						<img src="<?php echo STATIC_ROOT?>picture/kf01.png" />
						<div class="content">
							<h4>
								运营人员
							</h4>
						</div>
					</div>
				</div>
				<div class="4u 4u(mobile)">
					<div class="fund_text align-center">
						<img src="<?php echo STATIC_ROOT?>picture/kf03.png" />
						<div class="content">
							<h4>
								财务人员
							</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="yyzxId" class="api_block">
			<h3>
				运营中心
			</h3>
			<div class="row">
				<div class="6u 6u(mobile)">
					<div class="fund_text align-center">
						<i class="icon fa-gears round_icon round_border"></i>
						<div class="content">
							<h4>
								配置
							</h4>
							<p>
								风控、分账、费用、营销、结算
							</p>
						</div>
					</div>
				</div>
				<div class="6u 6u(mobile)">
					<div class="fund_text align-center">
						<i class="icon fa-bar-chart round_icon round_border"></i>
						<div class="content">
							<h4>
								报表
							</h4>
							<p>
								资金流水报表、日报表、汇总报表
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="cwzxId" class="api_block">
			<h3>
				财务中心
			</h3>
			<div class="row">
				<div class="6u 6u(mobile)">
					<div class="fund_text align-center">
						<i class="icon fa-list-ol round_icon round_border"></i>
						<div class="content">
							<h4>
								对账
							</h4>
							<p>
								系统自动对账、对账结果查询、对账处理
							</p>
						</div>
					</div>
				</div>
				<div class="6u 6u(mobile)">
					<div class="fund_text align-center">
						<i class="icon fa-database round_icon round_border"></i>
						<div class="content">
							<h4>
								财务
							</h4>
							<p>
								余额调整、相关审核、批量出款、T+n自动结算
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="ktsmId" class="api_block">
			<h3>
				开通说明
			</h3>
			<div class="row">
				<div class="4u 12u(mobile)">
					<div class="fund_text align-center">
						<i class="icon fa-edit featured"></i>
						<div class="content">
							<h4>
								注册
							</h4>
							<p>
								您可以免费申请账号，使用开发的相关功能。
							</p>
							<p>
								<a href="/user/reg.php" target="_blank">去注册</a>
							</p>
						</div>
					</div>
				</div>
				<div class="4u 12u(mobile)">
					<div class="fund_text align-center">
						<i class="icon fa-file-code-o featured alt"></i>
						<div class="content">
							<h4>
								集成
							</h4>
							<p>
								开发人员根据文档说明配置相关的信息.下载SDK与DEMO进行集成.
							</p>
							<p>
								<a href="doc.html" target="_blank">查看文档</a>&nbsp;&nbsp;&nbsp;
								<a href="SDK.zip" target="_blank">下载SDK</a>
							</p>
						</div>
					</div>
				</div>
				<div class="4u 12u(mobile)">
					<div class="fund_text align-center">
						<i class="icon fa-check-square-o featured alt2"></i>
						<div class="content">
							<h4>
								开通
							</h4>
							<p>
								正式开通如果有个性化定制需求，请线下联系我们
							</p>
							<p>
								<a href="aboutUs.html" target="_blank">联系我们</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require INDEX_ROOT.'foot.php';?>