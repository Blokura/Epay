<?php 
if(!defined('IN_PLUGIN'))exit();

require_once(PAY_ROOT."inc/epay.config.php");
require_once(PAY_ROOT."inc/epay_notify.class.php");

@header('Content-Type: text/html; charset=UTF-8');

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {
	//商户订单号
	$out_trade_no = daddslashes($_GET['out_trade_no']);

	//支付宝交易号
	$trade_no = daddslashes($_GET['trade_no']);

	//交易状态
	$trade_status = $_GET['trade_status'];

	//交易金额
	$money = $_GET['money'];

    if($_GET['trade_status'] == 'TRADE_SUCCESS') {
		if($out_trade_no == TRADE_NO && round($money,2)==round($order['money'],2)){
			$url=creat_callback($order);
			if($order['status']==0){
				if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='$out_trade_no'")){
					$DB->exec("update `pre_order` set `api_trade_no` ='$trade_no',`endtime` ='$date',`date` =NOW() where `trade_no`='$out_trade_no'");
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
      echo "trade_status=".$_GET['trade_status'];
    }
}
else {
    //验证失败
	echo('验证失败！');
}

?>