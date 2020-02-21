<?php
/*
 * 支付宝退款接口
*/
if(!defined('IN_REFUND'))exit();

require_once(PAY_ROOT."inc/model/builder/AlipayTradeRefundContentBuilder.php");
require_once(PAY_ROOT."inc/AlipayTradeService.php");

// 创建请求builder，设置请求参数
$requestBuilder = new AlipayTradeRefundContentBuilder();
$requestBuilder->setTradeNo($order['api_trade_no']);
$requestBuilder->setRefundAmount($order['realmoney']);

// 调用退款接口
$trade = new AlipayTradeService($config);
$refundResult = $trade->refund($requestBuilder);

//	根据状态值进行业务处理
$status = $refundResult->getTradeStatus();
$response = $refundResult->getResponse();
if($status == 'SUCCESS'){
	$result = ['code'=>0, 'trade_no'=>$response->trade_no, 'refund_fee'=>$response->refund_fee, 'refund_time'=>$response->gmt_refund_pay, 'buyer'=>$response->buyer_user_id];
}elseif($status == 'FAILED'){
	$result = ['code'=>-1, 'msg'=>'['.$response->sub_code.']'.$response->sub_msg];
}else{
	$result = ['code'=>-1, 'msg'=>'未知错误'];
}
return $result;
