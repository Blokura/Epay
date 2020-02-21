<?php
$config = array (
	//签名方式,默认为RSA2(RSA2048)
	'sign_type' => "RSA2",

	//支付宝公钥
	'alipay_public_key' => $channel['appkey'],

	//商户私钥
	'merchant_private_key' => $channel['appsecret'],

	//编码格式
	'charset' => "UTF-8",

	//支付宝网关
	'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

	//应用ID
	'app_id' => $channel['appid'],

	//异步通知地址
	'notify_url' => $conf['localurl'].'pay/alipay/notify/'.(defined("TRADE_NO")?TRADE_NO:$order['trade_no']).'/',

	//同步通知地址
	'return_url' => $conf['localurl'].'pay/alipay/return/'.(defined("TRADE_NO")?TRADE_NO:$order['trade_no']).'/',

	//登录返回页面
	'redirect_uri' => $siteurl.'user/oauth.php',

	//实名认证返回页面
	'cert_return_url' => 'alipays://platformapi/startapp?appId=20000067&url='.urlencode($siteurl.'user/alipaycertok.php'),
);