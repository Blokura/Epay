<?php
if(!defined('IN_PLUGIN'))exit();

@header('Content-Type: text/html; charset=UTF-8');

require_once(PAY_ROOT."inc/AlipayTradeService.php");


//计算得出通知验证结果
$alipaySevice = new AlipayTradeService($config); 
//$alipaySevice->writeLog(var_export($_POST,true));
$verify_result = $alipaySevice->check($_GET);

if($verify_result) {//验证成功
	//商户订单号
	$out_trade_no = daddslashes($_GET['out_trade_no']);

	//支付宝交易号
	$trade_no = daddslashes($_GET['trade_no']);

	//交易金额
	$total_amount = $_GET['total_amount'];

	if($out_trade_no == TRADE_NO && round($total_amount,2)==round($order['money'],2)){
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
}
else {
    //验证失败
    sysmsg('支付宝返回验证失败！');
}
?>