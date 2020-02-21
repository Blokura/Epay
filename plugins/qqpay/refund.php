<?php
/*
 * QQ钱包退款接口
*/
if(!defined('IN_REFUND'))exit();

require_once (PAY_ROOT.'inc/qpayMchAPI.class.php');

//入参
$params = array();
$params["transaction_id"] = $order['api_trade_no'];
$params["out_refund_no"] = $order['trade_no'];
$params["refund_fee"] = strval($order['realmoney']*100);
$params["op_user_id"] = QpayMchConf::OP_USERID;
$params["op_user_passwd"] = md5(QpayMchConf::OP_USERPWD);

//api调用
$qpayApi = new QpayMchAPI('https://api.qpay.qq.com/cgi-bin/pay/qpay_refund.cgi', null, 10);
$ret = $qpayApi->reqQpay($params);
$result = QpayMchUtil::xmlToArray($ret);
//print_r($result);

if($result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS'){
	$result = ['code'=>0, 'trade_no'=>$result['transaction_id'], 'refund_fee'=>$result['total_fee']];
}elseif(isset($result["err_code"])){
	$result = ['code'=>-1, 'msg'=>'['.$result["err_code"].']'.$result["err_code_des"]];
}else{
	$result = ['code'=>-1, 'msg'=>'['.$result["return_code"].']'.$result["return_msg"]];
}
return $result;