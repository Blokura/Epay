<?php
if(!defined('IN_PLUGIN'))exit();

require_once(PAY_ROOT.'inc/qpayNotify.class.php');
@header('Content-Type: text/html; charset=UTF-8');

$qpayNotify = new QpayNotify();
$result = $qpayNotify->getParams();
//判断签名
if($qpayNotify->verifySign()) {

//判断签名及结果（即时到帐）
	if($result['trade_state'] == "SUCCESS") {
		//商户订单号
		$out_trade_no = daddslashes($result['out_trade_no']);
		//QQ钱包订单号
		$transaction_id = daddslashes($result['transaction_id']);
		//金额,以分为单位
		$total_fee = $result['total_fee'];
		//币种
		$fee_type = $result['fee_type'];
		//用户表示
		$openid = daddslashes($result['openid']);

		//------------------------------
		//处理业务开始
		//------------------------------
		if($out_trade_no == TRADE_NO && $total_fee==strval($order['money']*100) && $order['status']==0){
			if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='".TRADE_NO."'")){
				$DB->exec("update `pre_order` set `api_trade_no` ='$transaction_id',`endtime` ='$date',`buyer` ='$openid',`date`=NOW() where `trade_no`='".TRADE_NO."'");
				processOrder($order);
			}
		}
		//------------------------------
		//处理业务完毕
		//------------------------------
		echo "<xml>
<return_code>SUCCESS</return_code>
</xml>";
	} else {
		echo "<xml>
<return_code>FAIL</return_code>
</xml>";
	}

} else {
	//回调签名错误
	echo "<xml>
<return_code>FAIL</return_code>
<return_msg>签名失败</return_msg>
</xml>";
} 

?>