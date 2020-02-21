<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!-- Footer -->
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="2u 4u(mobile)">
				<div class="footer_link list_p">
					<h5>关于我们</h5>
					<p>
						<a href="aboutUs.html">公司信息</a>
					</p>
					<p>
						<a href="aboutUs.html">联系我们</a>
					</p>
					<p>
						<a href="aboutUs.html">加入我们</a>
					</p>
				</div>
			</div>
			<div class="2u 4u(mobile)">
				<div class="footer_link list_p">
					<h5>产品</h5>
					<p>
						<a target="_blank" href="/doc.html">开发文档</a>
					</p>
					<p>
						<a target="_blank" href="/SDK.zip">SDK下载 </a>
					</p>
				</div>
			</div>
			<div class="2u 4u(mobile)">
				<div class="footer_link list_p">
					<h5>其它</h5>
					<p>
						<a href="aboutUs.html">合作伙伴</a>
					</p>
					<p>
						<a href="agreement.html">用户协议</a>
					</p>
					<p>
						<a href="produceIntroduce.html">功能介绍</a>
					</p>
				</div>
			</div>
			<div class="2u 4u(mobile)">
				<div class="footer_link"> <img src="assets/img/weixin.jpg" />
					<p>关注<?php echo $conf['sitename']?></p>
				</div>
			</div>
			<div class="4u 8u(mobile)">
				<div class="footer_link">
					<h5>联系我们</h5>
					<p><i class="icon fa-qq"></i> QQ：<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&Site=pay&Menu=yes" target="_blank"><?php echo $conf['kfqq']?></a></p>
					<p><i class="icon fa-envelope"></i> 邮箱：<a href="mailto:<?php echo $conf['email']?>"><?php echo $conf['email']?></a></p>
					<p><i class="icon fa-map-marker"></i> 地址：深圳市龙岗区龙岗街道龙岗大道4005号和创大厦306</p>
				</div>
			</div>
		</div> <br />
		<div class="align-center">
			<p><?php echo $conf['sitename']?>&nbsp;&nbsp;&copy;2020&nbsp;All Rights Reserved.&nbsp;&nbsp;<?php echo $conf['footer']?></p>
		</div>
	</div>
</footer>
</div>
</body>
</html>