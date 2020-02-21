<?php
if(!defined('IN_PLUGIN'))exit();

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false && !$submit2){
	echo "<script>window.location.href='/submit2.php?typeid={$order['type']}&trade_no={$trade_no}';</script>";exit;
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
	include(SYSTEM_ROOT.'pages/wxopen.php');
	exit;
}

require_once(PAY_ROOT."inc/common/SignUtil.php");
require_once(PAY_ROOT."inc/common/TDESUtil.php");

if(checkmobile()==true){
	$oriUrl = 'https://h5pay.jd.com/jdpay/saveOrder';
}else{
	$oriUrl = 'https://wepay.jd.com/jdpay/saveOrder';
}

$param=array();
$param["version"]='V2.0';
$param["merchant"]=$channel['appid'];
$param["tradeNum"]=$trade_no;
$param["tradeName"]=$ordername;
$param["tradeTime"]= date('YmdHis');
$param["amount"]= strval($order['money']*100);
$param["currency"]= 'CNY';
$param["callbackUrl"]= $siteurl.'pay/jdpay/return/'.TRADE_NO.'/';
$param["notifyUrl"]= $conf['localurl'].'pay/jdpay/notify/'.TRADE_NO.'/';
$param["ip"]= $clientip;
$param["userId"]= '';
$param["orderType"]= '1';
$unSignKeyList = array("sign");
$desKey = $channel['appkey'];
$sign = SignUtil::signWithoutToHex($param, $unSignKeyList);
//echo $sign."<br/>";
$param["sign"] = $sign;
$keys = base64_decode($desKey);

$param["tradeNum"]=TDESUtil::encrypt2HexStr($keys, $param["tradeNum"]);
if($param["tradeName"] != null && $param["tradeName"]!=""){
	$param["tradeName"]=TDESUtil::encrypt2HexStr($keys, $param["tradeName"]);
}
$param["tradeTime"]=TDESUtil::encrypt2HexStr($keys, $param["tradeTime"]);
$param["amount"]=TDESUtil::encrypt2HexStr($keys, $param["amount"]);
$param["currency"]=TDESUtil::encrypt2HexStr($keys, $param["currency"]);
$param["callbackUrl"]=TDESUtil::encrypt2HexStr($keys, $param["callbackUrl"]);
$param["notifyUrl"]=TDESUtil::encrypt2HexStr($keys, $param["notifyUrl"]);
$param["ip"]=TDESUtil::encrypt2HexStr($keys, $param["ip"]);

if($param["userId"] != null && $param["userId"]!=""){
	$param["userId"]=TDESUtil::encrypt2HexStr($keys, $param["userId"]);
}
if($param["orderType"] != null && $param["orderType"]!=""){
	$param["orderType"]=TDESUtil::encrypt2HexStr($keys, $param["orderType"]);
}
//print_R($param);exit;

echo '<form action="'.$oriUrl.'" method="post" id="dopay">';
foreach($param as $k => $v) {
	echo "<input type=\"hidden\" name=\"{$k}\" value=\"{$v}\" />\n";
}
echo '<input type="submit" value="正在跳转"></form><script>document.getElementById("dopay").submit();</script>';
?>