<?php 
if(!defined('IN_PLUGIN'))exit();

require_once(PAY_ROOT."inc/micro.config.php");
require_once(PAY_ROOT."inc/micro_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功
	//商户订单号
	$out_trade_no = daddslashes($_POST['out_trade_no']);

	//支付宝交易号
	$trade_no = daddslashes($_POST['trade_no']);

	//金额
	$money = $_POST['money'];

    if ($_POST['status'] == 1) {
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
