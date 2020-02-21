<?php
if(!defined('IN_CRONLITE'))exit();
require INDEX_ROOT.'head.php';
?>
<style type="text/css">
body{color:#000;}header { position: relative; }
.bann{ content:'';background-size:100%;background:#4280cb;background:-webkit-gradient(linear,0 0,0 100%,from(#4585d2),to(#4280cb));background:-moz-linear-gradient(top,#4585d2,#4280cb);background:linear-gradient(to bottom,#4585d2,#4280cb);top:0;left:0;z-index:-1;min-height:50px;width:100%}.fl .active{ color:#3F5061;background:#fff;border-color:#fff}
.api_block{margin-bottom: 4em;}
</style>

<div class="bann">


<div class="col-xs-12"style="text-align:center;">
<div class="h3"style="color:#ffffff;margin-top: 35px;margin-bottom: 30px;">开发文档</div>
                  
<div style="clear:both;"></div>
</div><div style="clear:both;"></div>
</div>


<div class="container">

  <!-- Docs nav
  ================================================== -->
  <div class="row">
    <div class="col-md-3 ">
      <div id="toc" class="bc-sidebar">
		<ul class="nav">
			<hr/>
			<li class="toc-h2"><a href="#api0">[API]创建商户</a></li>
			<li class="toc-h2"><a href="#api1">[API]查询商户信息</a></li>
			<li class="toc-h2"><a href="#api2">[API]修改结算账号</a></li>
			<li class="toc-h2"><a href="#api3">[API]查询结算记录</a></li>
			<li class="toc-h2"><a href="#api4">[API]查询单个订单</a></li>
			<li class="toc-h2"><a href="#api5">[API]批量查询订单</a></li>
			<li class="toc-h2"><a href="#api6">[API]二维码下单接口</a></li>
			<hr/>
			<li class="toc-h2"><a href="#pay0">发起支付请求</a></li>
			<li class="toc-h2"><a href="#pay1">支付结果通知</a></li>
			<hr/>
			<li class="toc-h2"><a href="#sdk0">SDK下载</a></li>
			<hr/>
		</ul>
	</div>
   </div>

    <div class="col-md-9">
      <article class="post page">
      	<section class="post-content">
		<hr/>
<div id="toc2" class="api_block">
			<h3>
				协议规则
			</h3>
			<p>传输方式：HTTP</p>
			<p>数据格式：JSON</p>
			<p>签名算法：MD5</p>
			<p>字符编码：UTF-8</p>
		</div>
		<div id="api0" class="api_block">
			<h3>
				[API]创建商户
			</h3>
<p>API权限：该API只能合作支付商户调用</p>
<p>URL地址：<?php echo $siteurl?>api.php?act=apply&amp;token={合作者身份TOKEN}&amp;url={商户域名}</p>
<p>请求参数说明：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>必填</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>操作类型</td><td>act</td><td>是</td><td>String</td><td>apply</td><td>此API固定值</td></tr>
  <tr><td>合作者TOKEN</td><td>token</td><td>是</td><td>String</td><td>9ddab6c4f2c87ce442de371b04f36d68</td><td>需要事先申请</td></tr>
  <tr><td>商户域名</td><td>url</td><td>是</td><td>String</td><td>pay.v8jisu.cn</td><td></td></tr>
  </tbody>
</table>
<p>返回结果：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>返回状态码</td><td>code</td><td>Int</td><td>1</td><td>1为成功，其它值为失败</td></tr>
  <tr><td>返回信息</td><td>msg</td><td>String</td><td>添加支付商户成功！</td><td></td></tr>
  <tr><td>商户ID</td><td>pid</td><td>Int</td><td>1001</td><td>所创建的商户ID</td></tr>
  <tr><td>商户密钥</td><td>key</td><td>String(32)</td><td>89unJUB8HZ54Hj7x4nUj56HN4nUzUJ8i</td><td>所创建的商户密钥</td></tr>
  <tr><td>商户类型</td><td>type</td><td>Int</td><td>1</td><td>此值暂无用</td></tr>
  </tbody>
</table>
		</div>
		<div id="api1" class="api_block">
			<h3>
				[API]查询商户信息与结算规则
			</h3>
<p>URL地址：<?php echo $siteurl?>api.php?act=query&amp;pid={商户ID}&amp;key={商户密钥}</p>
<p>请求参数说明：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>必填</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>操作类型</td><td>act</td><td>是</td><td>String</td><td>query</td><td>此API固定值</td></tr>
  <tr><td>商户ID</td><td>pid</td><td>是</td><td>Int</td><td>1001</td><td></td></tr>
  <tr><td>商户密钥</td><td>key</td><td>是</td><td>String</td><td>89unJUB8HZ54Hj7x4nUj56HN4nUzUJ8i</td><td></td></tr>
  </tbody>
</table>
<p>返回结果：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>返回状态码</td><td>code</td><td>Int</td><td>1</td><td>1为成功，其它值为失败</td></tr>
  <tr><td>商户ID</td><td>pid</td><td>Int</td><td>1001</td><td>所创建的商户ID</td></tr>
  <tr><td>商户密钥</td><td>key</td><td>String(32)</td><td>89unJUB8HZ54Hj7x4nUj56HN4nUzUJ8i</td><td>所创建的商户密钥</td></tr>
  <tr><td>商户类型</td><td>type</td><td>Int</td><td>1</td><td>此值暂无用</td></tr>
  <tr><td>商户状态</td><td>active</td><td>Int</td><td>1</td><td>1为正常，0为封禁</td></tr>
  <tr><td>商户余额</td><td>money</td><td>String</td><td>0.00</td><td>商户所拥有的余额</td></tr>
  <tr><td>结算账号</td><td>account</td><td>String</td><td>pay@cccyun.cn</td><td>结算的支付宝账号</td></tr>
  <tr><td>结算姓名</td><td>username</td><td>String</td><td>张三</td><td>结算的支付宝姓名</td></tr>
  <tr><td>满多少自动结算</td><td>settle_money</td><td>String</td><td>30</td><td>此值为系统预定义</td></tr>
  <tr><td>手动结算手续费</td><td>settle_fee</td><td>String</td><td>1</td><td>此值为系统预定义</td></tr>
  <tr><td>每笔订单分成比例</td><td>money_rate</td><td>String</td><td>98</td><td>此值为系统预定义</td></tr>
  </tbody>
</table>
		</div>
		<div id="api2" class="api_block">
			<h3>
				[API]修改结算账号
			</h3>
<p>URL地址：<?php echo $siteurl?>api.php?act=change&amp;pid={商户ID}&amp;key={商户密钥}&amp;account={结算账号}&amp;username={结算姓名}</p>
<p>注：为了保障资金安全，已经设置结算账号的无法再进行修改，如需修改请联系客服</p>
<p>请求参数说明：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>必填</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>操作类型</td><td>act</td><td>是</td><td>String</td><td>change</td><td>此API固定值</td></tr>
  <tr><td>商户ID</td><td>pid</td><td>是</td><td>Int</td><td>1001</td><td></td></tr>
  <tr><td>商户密钥</td><td>key</td><td>是</td><td>String</td><td>89unJUB8HZ54Hj7x4nUj56HN4nUzUJ8i</td><td></td></tr>
  <tr><td>结算账号</td><td>account</td><td>是</td><td>String</td><td>pay@cccyun.cn</td><td>结算的支付宝账号</td></tr>
  <tr><td>结算姓名</td><td>username</td><td>是</td><td>String</td><td>张三</td><td>结算的支付宝姓名</td></tr>
  </tbody>
</table>
<p>返回结果：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>返回状态码</td><td>code</td><td>Int</td><td>1</td><td>1为成功，其它值为失败</td></tr>
  <tr><td>返回信息</td><td>msg</td><td>String</td><td>修改收款账号成功！</td><td></td></tr>
  </tbody>
</table>
		</div>
		<div id="api3" class="api_block">
			<h3>
				[API]查询结算记录
			</h3>
<p>URL地址：<?php echo $siteurl?>api.php?act=settle&amp;pid={商户ID}&amp;key={商户密钥}</p>
<p>请求参数说明：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>必填</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>操作类型</td><td>act</td><td>是</td><td>String</td><td>settle</td><td>此API固定值</td></tr>
  <tr><td>商户ID</td><td>pid</td><td>是</td><td>Int</td><td>1001</td><td></td></tr>
  <tr><td>商户密钥</td><td>key</td><td>是</td><td>String</td><td>89unJUB8HZ54Hj7x4nUj56HN4nUzUJ8i</td><td></td></tr>
  </tbody>
</table>
<p>返回结果：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>返回状态码</td><td>code</td><td>Int</td><td>1</td><td>1为成功，其它值为失败</td></tr>
  <tr><td>返回信息</td><td>msg</td><td>String</td><td>查询结算记录成功！</td><td></td></tr>
  <tr><td>结算记录</td><td>data</td><td>Array</td><td>结算记录列表</td><td></td></tr>
  </tbody>
</table>
		</div>
		<div id="api4" class="api_block">
			<h3>
				[API]查询单个订单
			</h3>
<p>URL地址：<?php echo $siteurl?>api.php?act=order&amp;pid={商户ID}&amp;key={商户密钥}&amp;out_trade_no={商户订单号}</p>
<p>请求参数说明：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>必填</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>操作类型</td><td>act</td><td>是</td><td>String</td><td>order</td><td>此API固定值</td></tr>
  <tr><td>商户ID</td><td>pid</td><td>是</td><td>Int</td><td>1001</td><td></td></tr>
  <tr><td>商户密钥</td><td>key</td><td>是</td><td>String</td><td>89unJUB8HZ54Hj7x4nUj56HN4nUzUJ8i</td><td></td></tr>
  <tr><td>商户订单号</td><td>out_trade_no</td><td>是</td><td>String</td><td>20160806151343349</td><td></td></tr>
  </tbody>
</table>
<p>返回结果：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>返回状态码</td><td>code</td><td>Int</td><td>1</td><td>1为成功，其它值为失败</td></tr>
  <tr><td>返回信息</td><td>msg</td><td>String</td><td>查询订单号成功！</td><td></td></tr>
  <tr><td>易支付订单号</td><td>trade_no</td><td>String</td><td>2016080622555342651</td><td><?php echo $conf['sitename']?>订单号</td></tr>
  <tr><td>商户订单号</td><td>out_trade_no</td><td>String</td><td>20160806151343349</td><td>商户系统内部的订单号</td></tr>
  <tr><td>支付方式</td><td>type</td><td>String</td><td>alipay</td><td>alipay:支付宝,tenpay:财付通,<br/>qqpay:QQ钱包,wxpay:微信支付</td></tr>
  <tr><td>商户ID</td><td>pid</td><td>Int</td><td>1001</td><td>发起支付的商户ID</td></tr>
  <tr><td>创建订单时间</td><td>addtime</td><td>String</td><td>2016-08-06 22:55:52</td><td></td></tr>
  <tr><td>完成交易时间</td><td>endtime</td><td>String</td><td>2016-08-06 22:55:52</td><td></td></tr>
  <tr><td>商品名称</td><td>name</td><td>String</td><td>VIP会员</td><td></td></tr>
  <tr><td>商品金额</td><td>money</td><td>String</td><td>1.00</td><td></td></tr>
  <tr><td>支付状态</td><td>status</td><td>Int</td><td>0</td><td>1为支付成功，0为未支付</td></tr>
  </tbody>
</table>
		</div>
		<div id="api5" class="api_block">
			<h3>
				[API]批量查询订单
			</h3>
<p>URL地址：<?php echo $siteurl?>api.php?act=orders&amp;pid={商户ID}&amp;key={商户密钥}</p>
<p>请求参数说明：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>必填</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>操作类型</td><td>act</td><td>是</td><td>String</td><td>orders</td><td>此API固定值</td></tr>
  <tr><td>商户ID</td><td>pid</td><td>是</td><td>Int</td><td>1001</td><td></td></tr>
  <tr><td>商户密钥</td><td>key</td><td>是</td><td>String</td><td>89unJUB8HZ54Hj7x4nUj56HN4nUzUJ8i</td><td></td></tr>
  <tr><td>查询订单数量</td><td>limit</td><td>否</td><td>Int</td><td>20</td><td>返回的订单数量，最大50</td></tr>
  <tr><td>页码</td><td>page</td><td>否</td><td>Int</td><td>1</td><td>当前查询的页码</td></tr>
  </tbody>
</table>
<p>返回结果：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>返回状态码</td><td>code</td><td>Int</td><td>1</td><td>1为成功，其它值为失败</td></tr>
  <tr><td>返回信息</td><td>msg</td><td>String</td><td>查询结算记录成功！</td><td></td></tr>
  <tr><td>订单列表</td><td>data</td><td>Array</td><td></td><td>订单列表</td></tr>
  </tbody>
</table>
		</div>
		<div id="api6" class="api_block">
			<h3>
				[API]二维码下单接口
			</h3>
<p>此接口可用于服务器后端发起支付请求，会返回支付二维码链接</p>
<p>URL地址：<?php echo $siteurl?>qrcode.php?pid={商户ID}&amp;type={支付方式}&amp;out_trade_no={商户订单号}&amp;notify_url={服务器异步通知地址}&amp;name={商品名称}&amp;money={金额}&amp;sign={签名字符串}&amp;sign_type=MD5</p>
<p>请求参数说明：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>必填</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>商户ID</td><td>pid</td><td>是</td><td>Int</td><td>1001</td><td></td></tr>
  <tr><td>支付方式</td><td>type</td><td>是</td><td>String</td><td>alipay</td><td>qqpay:QQ钱包,wxpay:微信支付</td></tr>
  <tr><td>商户订单号</td><td>out_trade_no</td><td>是</td><td>String</td><td>20160806151343349</td><td></td></tr>
  <tr><td>异步通知地址</td><td>notify_url</td><td>是</td><td>String</td><td>http://www.cccyun.cc/notify_url.php</td><td>服务器异步通知地址</td></tr>
  <tr><td>商品名称</td><td>name</td><td>是</td><td>String</td><td>VIP会员</td><td></td></tr>
  <tr><td>商品金额</td><td>money</td><td>是</td><td>String</td><td>1.00</td><td></td></tr>
  <tr><td>签名字符串</td><td>sign</td><td>是</td><td>String</td><td>202cb962ac59075b964b07152d234b70</td><td>签名算法与<a href="https://doc.open.alipay.com/docs/doc.htm?treeId=62&articleId=104741&docType=1" target="_blank">支付宝签名算法</a>相同</td></tr>
  <tr><td>签名类型</td><td>sign_type</td><td>是</td><td>String</td><td>MD5</td><td>默认为MD5</td></tr>
  </tbody>
</table>
<p>返回结果：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>返回状态码</td><td>code</td><td>Int</td><td>1</td><td>1为成功，其它值为失败</td></tr>
  <tr><td>返回信息</td><td>msg</td><td>String</td><td>下单成功！</td><td></td></tr>
  <tr><td>订单号</td><td>trade_no</td><td>String</td><td>20160806151343349</td><td></td></tr>
  <tr><td>商户订单号</td><td>out_trade_no</td><td>String</td><td>20160806151343349</td><td></td></tr>
  <tr><td>二维码链接</td><td>code_url</td><td>String</td><td>weixin://wxpay/bizpayurl?pr=04IPMKM</td><td></td></tr>
  </tbody>
</table>
<hr/>
		</div>
		<div id="pay0" class="api_block">
			<h3>
				发起支付请求
			</h3>
<p>URL地址：<?php echo $siteurl?>submit.php</p>
<p>POST数据：pid={商户ID}&amp;type={支付方式}&amp;out_trade_no={商户订单号}&amp;notify_url={服务器异步通知地址}&amp;return_url={页面跳转通知地址}&amp;name={商品名称}&amp;money={金额}&amp;sitename={网站名称}&amp;sign={签名字符串}&amp;sign_type=MD5</p>
<p>请求参数说明：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>必填</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>商户ID</td><td>pid</td><td>是</td><td>Int</td><td>1001</td><td></td></tr>
  <tr><td>支付方式</td><td>type</td><td>是</td><td>String</td><td>alipay</td><td>alipay:支付宝,tenpay:财付通,<br/>qqpay:QQ钱包,wxpay:微信支付</td></tr>
  <tr><td>商户订单号</td><td>out_trade_no</td><td>是</td><td>String</td><td>20160806151343349</td><td></td></tr>
  <tr><td>异步通知地址</td><td>notify_url</td><td>是</td><td>String</td><td>http://www.cccyun.cc/notify_url.php</td><td>服务器异步通知地址</td></tr>
  <tr><td>跳转通知地址</td><td>return_url</td><td>是</td><td>String</td><td>http://www.cccyun.cc/return_url.php</td><td>页面跳转通知地址</td></tr>
  <tr><td>商品名称</td><td>name</td><td>是</td><td>String</td><td>VIP会员</td><td></td></tr>
  <tr><td>商品金额</td><td>money</td><td>是</td><td>String</td><td>1.00</td><td></td></tr>
  <tr><td>网站名称</td><td>sitename</td><td>否</td><td>String</td><td>彩虹云任务</td><td></td></tr>
  <tr><td>签名字符串</td><td>sign</td><td>是</td><td>String</td><td>202cb962ac59075b964b07152d234b70</td><td>签名算法与<a href="https://doc.open.alipay.com/docs/doc.htm?treeId=62&articleId=104741&docType=1" target="_blank">支付宝签名算法</a>相同</td></tr>
  <tr><td>签名类型</td><td>sign_type</td><td>是</td><td>String</td><td>MD5</td><td>默认为MD5</td></tr>
  </tbody>
</table>
		</div>
		<div id="pay1" class="api_block">
			<h3>
				支付结果通知
			</h3>
<p>通知类型：服务器异步通知（notify_url）、页面跳转通知（return_url）</p>
<p>请求方式：GET</p>
<p>请求参数说明：</p>
<table class="table table-bordered table-hover">
  <thead><tr><th>字段名</th><th>变量名</th><th>必填</th><th>类型</th><th>示例值</th><th>描述</th></tr></thead>
  <tbody>
  <tr><td>商户ID</td><td>pid</td><td>是</td><td>Int</td><td>1001</td><td></td></tr>
  <tr><td>易支付订单号</td><td>trade_no</td><td>是</td><td>String</td><td>20160806151343349021</td><td><?php echo $conf['sitename']?>订单号</td></tr>
  <tr><td>商户订单号</td><td>out_trade_no</td><td>是</td><td>String</td><td>20160806151343349</td><td>商户系统内部的订单号</td></tr>
  <tr><td>支付方式</td><td>type</td><td>是</td><td>String</td><td>alipay</td><td>alipay:支付宝,tenpay:财付通,<br/>qqpay:QQ钱包,wxpay:微信支付,<br/>alipaycode:支付宝扫码,jdpay:京东支付</td></tr>
  <tr><td>商品名称</td><td>name</td><td>是</td><td>String</td><td>VIP会员</td><td></td></tr>
  <tr><td>商品金额</td><td>money</td><td>是</td><td>String</td><td>1.00</td><td></td></tr>
  <tr><td>支付状态</td><td>trade_status</td><td>是</td><td>String</td><td>TRADE_SUCCESS</td><td></td></tr>
  <tr><td>签名字符串</td><td>sign</td><td>是</td><td>String</td><td>202cb962ac59075b964b07152d234b70</td><td>签名算法与<a href="https://doc.open.alipay.com/docs/doc.htm?treeId=62&articleId=104741&docType=1" target="_blank">支付宝签名算法</a>相同</td></tr>
  <tr><td>签名类型</td><td>sign_type</td><td>是</td><td>String</td><td>MD5</td><td>默认为MD5</td></tr>
  </tbody>
</table>
<hr/>
		</div>
		<div id="sdk0" class="api_block">
			<h3>
				SDK下载
			</h3>
<blockquote>
<a href="./SDK.zip" style="color:blue">SDK.zip</a><br/>
SDK版本：V1.1
</blockquote>
		</div>

          </section>
      </article>
    </div>
  </div>

</div>

<?php require INDEX_ROOT.'foot.php';?>