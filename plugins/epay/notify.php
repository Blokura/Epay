<?php 
if(!defined('IN_PLUGIN'))exit();

require_once(PAY_ROOT."inc/epay.config.php");
require_once(PAY_ROOT."inc/epay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功
	//商户订单号
	$out_trade_no = daddslashes($_GET['out_trade_no']);

	//支付宝交易号
	$trade_no = daddslashes($_GET['trade_no']);

	//交易状态
	$trade_status = $_GET['trade_status'];

	//交易金额
	$money = $_GET['money'];

    if ($_GET['trade_status'] == 'TRADE_SUCCESS') {
		//付款完成后，支付宝系统发送该交易状态通知
		if($out_trade_no == TRADE_NO && round($money,2)==round($order['money'],2) && $order['status']==0){
			if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='$out_trade_no'")){
				$DB->exec("update `pre_order` set `api_trade_no` ='$trade_no',`endtime` ='$date',`date` =NOW() where `trade_no`='$out_trade_no'");
				processOrder($order);
			}
		}
    }

	echo "success";
}
else {
    //验证失败
    echo "fail";
}

?>