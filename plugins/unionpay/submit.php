<?php
if(!defined('IN_PLUGIN'))exit();

if($order['typename']=='alipay'){
	echo "<script>window.location.href='/pay/unionpay/alipay/{$trade_no}/';</script>";
}elseif($order['typename']=='wxpay'){
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
		echo "<script>window.location.href='/pay/unionpay/wxjspay/{$trade_no}/?d=1';</script>";
	}elseif(checkmobile()==true){
		echo "<script>window.location.href='/pay/unionpay/wxwappay/{$trade_no}/';</script>";
	}else{
		echo "<script>window.location.href='/pay/unionpay/wxpay/{$trade_no}/';</script>";
	}
}elseif($order['typename']=='bank'){
	echo "<script>window.location.href='/pay/unionpay/bank/{$trade_no}/';</script>";
}
