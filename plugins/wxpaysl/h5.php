<?php
/*
 * 微信H5支付
*/
if(!defined('IN_PLUGIN'))exit();

@header('Content-Type: text/html; charset=UTF-8');

require_once PAY_ROOT."inc/WxPay.Api.php";
require_once PAY_ROOT."inc/WxPay.NativePay.php";
$notify = new NativePay();
$input = new WxPayUnifiedOrder();
$input->SetBody($ordername);
$input->SetOut_trade_no(TRADE_NO);
$input->SetTotal_fee(strval($order['money']*100));
$input->SetSpbill_create_ip($clientip);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetNotify_url($conf['localurl'].'pay/wxpaysl/notify/'.TRADE_NO.'/');
$input->SetTrade_type("MWEB");
$result = $notify->GetPayUrl($input);
if($result["result_code"]=='SUCCESS'){
	$redirect_url=$siteurl.'pay/wxpay/return/'.TRADE_NO.'/';
	$url=$result['mweb_url'].'&redirect_url='.urlencode($redirect_url);
	exit("<script>window.location.replace('{$url}');</script>");
}elseif(isset($result["err_code"])){
	sysmsg('微信支付下单失败！['.$result["err_code"].'] '.$result["err_code_des"]);
}else{
	sysmsg('微信支付下单失败！['.$result["return_code"].'] '.$result["return_msg"]);
}

?>