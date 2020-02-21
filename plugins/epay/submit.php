<?php
if(!defined('IN_PLUGIN'))exit();

require_once(PAY_ROOT."inc/epay.config.php");
require_once(PAY_ROOT."inc/epay_submit.class.php");
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $order['typename'],
	"notify_url"	=> $conf['localurl'].'pay/epay/notify/'.TRADE_NO.'/',
	"return_url"	=> $siteurl.'pay/epay/return/'.TRADE_NO.'/',
	"out_trade_no"	=> $trade_no,
	"name"	=> $order['name'],
	"money"	=> $order['money']
);
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
