<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>正在为您跳转到支付页面，请稍候...</title>
	<style type="text/css">
        body {margin:0;padding:0;}
        p {position:absolute;
            left:50%;top:50%;
            width:330px;height:30px;
            margin:-35px 0 0 -160px;
            padding:20px;font:bold 14px/30px "宋体", Arial;
            background:#f9fafc url(../assets/img/loading.gif) no-repeat 20px 20px;
            text-indent:40px;border:1px solid #c5d0dc;}
        #waiting {font-family:Arial;}
    </style>
</head>
<body>
<?php
$is_defend=true;
$nosession = true;
require './includes/common.php';
$submit2=true;

@header('Content-Type: text/html; charset=UTF-8');

$typeid=intval($_GET['typeid']);
$trade_no=daddslashes($_GET['trade_no']);
$order=$DB->getRow("SELECT * FROM pre_order WHERE trade_no='{$trade_no}' LIMIT 1");
if(!$order)sysmsg('该订单号不存在，请返回来源地重新发起请求！');

$userrow = $DB->getRow("SELECT gid,mode FROM pre_user WHERE uid='{$order['uid']}' LIMIT 1");

// 获取订单支付方式ID、支付插件、支付通道、支付费率
$submitData = \lib\Channel::submit2($typeid, $userrow['gid']);

if($submitData){
	if($userrow['mode']==1 && $order['tid']!=4 || $order['tid']==2){
		$realmoney = round($order['money']*(100+100-$submitData['rate'])/100,2);
		$getmoney = $order['money'];
	}else{
		$realmoney = $order['money'];
		$getmoney = round($order['money']*$submitData['rate']/100,2);
	}
	$DB->exec("UPDATE pre_order SET type='{$submitData['typeid']}',channel='{$submitData['channel']}',realmoney='$realmoney',getmoney='$getmoney' WHERE trade_no='$trade_no'");
}else{
	sysmsg('<center>当前支付方式无法使用</center>', '跳转提示');
}

$order['type'] = $submitData['typeid'];
$order['channel'] = $submitData['channel'];
$order['typename'] = $submitData['typename'];
$order['apptype'] = explode(',',$submitData['apptype']);
$order['money'] = $realmoney;

$loadfile = \lib\Plugin::load2($submitData['plugin'], 'submit', $trade_no);
$channel = \lib\Channel::get($order['channel']);
if(!$channel || $channel['plugin']!=PAY_PLUGIN)sysmsg('当前支付通道信息不存在');
$channel['apptype'] = explode(',',$channel['apptype']);
$ordername = !empty($conf['ordername'])?ordername_replace($conf['ordername'],$order['name'],$order['uid']):$order['name'];
include $loadfile;
?>
<p>正在为您跳转到支付页面，请稍候...</p>
</body>
</html>