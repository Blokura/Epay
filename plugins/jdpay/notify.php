<?php
/* *
 * 京东支付异步通知页面
 */

if(!defined('IN_PLUGIN'))exit();
require_once(PAY_ROOT."inc/common/XMLUtil.php");

define("Confid_desKey",$channel['appkey']);
$xml = file_get_contents("php://input");
$flag = XMLUtil::decryptResXml($xml, $param);
//var_dump($flag);
if($flag){
	echo "success";
	$trade_no = daddslashes($param["tradeNum"]);
	$out_trade_no = daddslashes($param["tradeNum"]);
	if($param["status"]==2) {
		if($out_trade_no == TRADE_NO && $param["amount"]==strval($order['money']*100) && $order['status']==0){
			if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='".TRADE_NO."'")){
				$DB->exec("update `pre_order` set `api_trade_no` ='$trade_no',`endtime` ='$date',`date` =NOW() where `trade_no`='".TRADE_NO."'");
				processOrder($order);
			}
		}
    }
}else{
	echo "error";
}