<?php
if(!defined('IN_PLUGIN'))exit();

require_once(PAY_ROOT."inc/AlipayTradeService.php");


//计算得出通知验证结果
$alipaySevice = new AlipayTradeService($config); 
//$alipaySevice->writeLog(var_export($_POST,true));
$verify_result = $alipaySevice->check($_POST);

if($verify_result) {//验证成功
	//商户订单号
	$out_trade_no = daddslashes($_POST['out_trade_no']);

	//支付宝交易号
	$trade_no = daddslashes($_POST['trade_no']);

	//交易状态
	$trade_status = $_POST['trade_status'];

	//买家支付宝
	$buyer_id = daddslashes($_POST['buyer_id']);

	//交易金额
	$total_amount = $_POST['total_amount'];

    if($_POST['trade_status'] == 'TRADE_FINISHED') {
		//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
    }
    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		if($out_trade_no == TRADE_NO && round($total_amount,2)==round($order['money'],2) && $order['status']==0){
			if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='".TRADE_NO."'")){
				$DB->exec("update `pre_order` set `api_trade_no` ='$trade_no',`endtime` ='$date',`buyer` ='$buyer_id',`date` =NOW() where `trade_no`='".TRADE_NO."'");
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