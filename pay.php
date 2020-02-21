<?php
$nosession = true;
include("./includes/common.php");

$s = isset($_GET['s'])?$_GET['s']:exit('404 Not Found');
unset($_GET['s']);

$loadfile = \lib\Plugin::load($s);

$order = $DB->getRow("SELECT * FROM pre_order WHERE trade_no='".TRADE_NO."' limit 1");
if(!$order)sysmsg('该订单号不存在，请返回来源地重新发起请求！');

$channel = \lib\Channel::get($order['channel']);
if(!$channel || $channel['plugin']!=PAY_PLUGIN)sysmsg('当前支付通道信息不存在');

$ordername = !empty($conf['ordername'])?ordername_replace($conf['ordername'],$order['name'],$order['uid']):$order['name'];
$order['money'] = $order['realmoney'];

include $loadfile;