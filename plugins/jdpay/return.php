<?php
/* *
 * 京东支付同步通知页面
 */

require_once('./includes/common.php');
require_once(PAY_ROOT."inc/common/SignUtil.php");
require_once(PAY_ROOT."inc/common/TDESUtil.php");

$desKey = $channel['appkey'];
$keys = base64_decode($desKey);
$param = array();
if(!empty($_POST["tradeNum"])){
	$param["tradeNum"]=TDESUtil::decrypt4HexStr($keys, $_POST["tradeNum"]);
}
if(!empty($_POST["amount"])){
	$param["amount"]=TDESUtil::decrypt4HexStr($keys, $_POST["amount"]);
}
if(!empty($_POST["currency"])){
	$param["currency"]=TDESUtil::decrypt4HexStr($keys, $_POST["currency"]);
}
if(!empty($_POST["tradeTime"])){
	$param["tradeTime"]=TDESUtil::decrypt4HexStr($keys, $_POST["tradeTime"]);
}
if(!empty($_POST["status"])){
	$param["status"]=TDESUtil::decrypt4HexStr($keys, $_POST["status"]);
}

$sign = $_POST["sign"];
$strSourceData = SignUtil::signString($param, array());
//echo "strSourceData=".htmlspecialchars($strSourceData)."<br/>";
//$decryptBASE64Arr = base64_decode($sign);
$decryptStr = RSAUtils::decryptByPublicKey($sign);
//echo "decryptStr=".htmlspecialchars($decryptStr)."<br/>";
$sha256SourceSignString = hash ( "sha256", $strSourceData);
//echo "sha256SourceSignString=".htmlspecialchars($sha256SourceSignString)."<br/>";
if($decryptStr == $sha256SourceSignString){
	$trade_no = daddslashes($param["tradeNum"]);
	$out_trade_no = daddslashes($param["tradeNum"]);
	if($out_trade_no == TRADE_NO && $param["amount"]==$order['money']*100 && $order['status']==0){
		$url=creat_callback($order);

		if($order['status']==0){
			if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='".TRADE_NO."'")){
				$DB->exec("update `pre_order` set `api_trade_no` ='$trade_no',`endtime` ='$date',`date` =NOW() where `trade_no`='".TRADE_NO."'");
				processOrder($order,false);
			}
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		}else{
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		}
	}else{
		sysmsg('订单信息校验失败');
	}
}else{
	sysmsg("验证签名失败！strSourceData=".htmlspecialchars($strSourceData));
}
