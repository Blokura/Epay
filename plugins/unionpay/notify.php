<?php 
require_once('./includes/common.php');
require(PAY_ROOT.'inc/class/Utils.class.php');
require(PAY_ROOT.'inc/config.php');
require(PAY_ROOT.'inc/class/ClientResponseHandler.class.php');

$resHandler = new ClientResponseHandler();
$cfg = new Config();

$xml = file_get_contents('php://input');

$resHandler->setContent($xml);

$resHandler->setKey($cfg->C('key'));
if($resHandler->isTenpaySign()){
	
	if($resHandler->getParameter('status') == 0 && $resHandler->getParameter('result_code') == 0){
		$transaction_id = $resHandler->getParameter('transaction_id');
		$out_trade_no = $resHandler->getParameter('out_trade_no');
		$total_fee = $resHandler->getParameter('total_fee');
		$fee_type = $resHandler->getParameter('fee_type');
		$openid = $resHandler->getParameter('openid');
		if($out_trade_no == TRADE_NO && $total_fee==strval($order['money']*100) && $order['status']==0){
			if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='".TRADE_NO."'")){
				$DB->exec("update `pre_order` set `api_trade_no` ='$transaction_id',`endtime` ='$date',`buyer` ='$openid',`date`=NOW() where `trade_no`='".TRADE_NO."'");
				processOrder($order);
			}
		}
		//Utils::dataRecodes('接口回调收到通知参数',$resHandler->getAllParameters());
		echo 'success';
		exit();
	}else{
		echo 'failure1';
		exit();
	}
}else{
	echo 'failure2';
}
?>