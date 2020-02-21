<?php
if(!defined('IN_PLUGIN'))exit();

require_once(PAY_ROOT."inc/micro.config.php");
require_once(PAY_ROOT."inc/micro_submit.class.php");
$parameter = array(
	"appid" => trim($alipay_config['appid']),
	"type" => $order['typename']=='alipay'?'alipay':'cashier',
	"notify_url"	=> $conf['localurl'].'pay/micro/notify/'.TRADE_NO.'/',
	"return_url"	=> $siteurl.'pay/micro/return/'.TRADE_NO.'/',
	"out_trade_no"	=> $trade_no,
	"name"	=> $order['name'],
	"money"	=> $order['money'],
	"mchid"	=> trim($alipay_config['mchid'])
);
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
