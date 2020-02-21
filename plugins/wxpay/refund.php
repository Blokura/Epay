<?php
/*
 * 微信退款接口
*/
if(!defined('IN_REFUND'))exit();

require_once PAY_ROOT."inc/WxPay.Api.php";

try{
	$input = new WxPayRefund();
	$input->SetTransaction_id($order['api_trade_no']);
	$input->SetTotal_fee(strval($order['realmoney']*100));
	$input->SetRefund_fee(strval($order['realmoney']*100));
	$input->SetOut_refund_no($order['trade_no']);
	$input->SetOp_user_id(WxPayConfig::MCHID);
	$result = WxPayApi::refund($input);
	if($result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS'){
		$result = ['code'=>0, 'trade_no'=>$result['transaction_id'], 'refund_fee'=>$result['refund_fee']];
	}elseif(isset($result["err_code"])){
		$result = ['code'=>-1, 'msg'=>'['.$result["err_code"].']'.$result["err_code_des"]];
	}else{
		$result = ['code'=>-1, 'msg'=>'['.$result["return_code"].']'.$result["return_msg"]];
	}
} catch(Exception $e) {
	$result = ['code'=>-1, 'msg'=>$e->getMessage()];
}

return $result;