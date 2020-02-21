<?php
if(isset($_GET['pid'])){
	$queryArr=$_GET;
	$is_defend=true;
}elseif(isset($_POST['pid'])){
	$queryArr=$_POST;
}else{
	@header('Content-Type: text/html; charset=UTF-8');
	exit('你还未配置支付接口商户！');
}
$nosession = true;
require './includes/common.php';

@header('Content-Type: text/html; charset=UTF-8');
?>
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

use \lib\PayUtils;
$prestr=PayUtils::createLinkstring(PayUtils::argSort(PayUtils::paraFilter($queryArr)));
$pid=intval($queryArr['pid']);
if(empty($pid))sysmsg('PID不存在');
$userrow=$DB->query("SELECT `uid`,`gid`,`key`,`mode`,`pay`,`cert`,`status` FROM `pre_user` WHERE `uid`='{$pid}' LIMIT 1")->fetch();
if(!$userrow)sysmsg('商户不存在！');
if(!PayUtils::md5Verify($prestr, $queryArr['sign'], $userrow['key']))sysmsg('签名校验失败，请返回重试！');

if($userrow['status']==0 || $userrow['pay']==0)sysmsg('商户已封禁，无法支付！');

$type=daddslashes($queryArr['type']);
$out_trade_no=daddslashes($queryArr['out_trade_no']);
$notify_url=htmlspecialchars(daddslashes($queryArr['notify_url']));
$return_url=htmlspecialchars(daddslashes($queryArr['return_url']));
$name=htmlspecialchars(daddslashes($queryArr['name']));
$money=daddslashes($queryArr['money']);
$sitename=urlencode(base64_encode($queryArr['sitename']));


if(empty($out_trade_no))sysmsg('订单号(out_trade_no)不能为空');
if(empty($notify_url))sysmsg('通知地址(notify_url)不能为空');
if(empty($return_url))sysmsg('回调地址(return_url)不能为空');
if(empty($name))sysmsg('商品名称(name)不能为空');
if(empty($money))sysmsg('金额(money)不能为空');
if($money<=0 || !is_numeric($money) || !preg_match('/^[0-9.]+$/', $money))sysmsg('金额不合法');
if($conf['pay_maxmoney']>0 && $money>$conf['pay_maxmoney'])sysmsg('最大支付金额是'.$conf['pay_maxmoney'].'元');
if($conf['pay_minmoney']>0 && $money<$conf['pay_minmoney'])sysmsg('最小支付金额是'.$conf['pay_minmoney'].'元');
if(!preg_match('/^[a-zA-Z0-9.\_\-|]+$/',$out_trade_no))sysmsg('订单号(out_trade_no)格式不正确');

$domain=getdomain($notify_url);

if(!empty($conf['blockname'])){
	$block_name = explode('|',$conf['blockname']);
	foreach($block_name as $rows){
		if(strpos($name,$rows)!==false){
			$DB->exec("INSERT INTO `pre_risk` (`uid`, `url`, `content`, `date`) VALUES (:uid, :domain, :rows, NOW())", [':uid'=>$pid,':domain'=>$domain,':rows'=>$rows]);
			sysmsg($conf['blockalert']?$conf['blockalert']:'该商品禁止出售');
		}
	}
}
if($conf['cert_force']==1 && $userrow['cert']==0){
	sysmsg('当前商户未完成实名认证，无法收款');
}

$trade_no=date("YmdHis").rand(11111,99999);
if(!$DB->exec("INSERT INTO `pre_order` (`trade_no`,`out_trade_no`,`uid`,`addtime`,`name`,`money`,`notify_url`,`return_url`,`domain`,`ip`,`status`) VALUES (:trade_no, :out_trade_no, :uid, NOW(), :name, :money, :notify_url, :return_url, :domain, :clientip, 0)", [':trade_no'=>$trade_no, ':out_trade_no'=>$out_trade_no, ':uid'=>$pid, ':name'=>$name, ':money'=>$money, ':notify_url'=>$notify_url, ':return_url'=>$return_url, ':domain'=>$domain, ':clientip'=>$clientip]))sysmsg('创建订单失败，请返回重试！');

if(empty($type)){
	echo "<script>window.location.href='./cashier.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
	exit;
}

// 获取订单支付方式ID、支付插件、支付通道、支付费率
$submitData = \lib\Channel::submit($type, $userrow['gid']);

if($submitData){
	if($userrow['mode']==1){
		$realmoney = round($money*(100+100-$submitData['rate'])/100,2);
		$getmoney = $money;
	}else{
		$realmoney = $money;
		$getmoney = round($money*$submitData['rate']/100,2);
	}
	$DB->exec("UPDATE pre_order SET type='{$submitData['typeid']}',channel='{$submitData['channel']}',realmoney='$realmoney',getmoney='$getmoney' WHERE trade_no='$trade_no'");
}else{ //选择其他支付方式
	echo "<script>window.location.href='./cashier.php?trade_no={$trade_no}&sitename={$sitename}&other=1';</script>";
	exit;
}

$order['trade_no'] = $trade_no;
$order['out_trade_no'] = $out_trade_no;
$order['uid'] = $pid;
$order['addtime'] = $date;
$order['name'] = $name;
$order['money'] = $realmoney;
$order['type'] = $submitData['typeid'];
$order['channel'] = $submitData['channel'];
$order['typename'] = $submitData['typename'];
$order['apptype'] = explode(',',$submitData['apptype']);

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