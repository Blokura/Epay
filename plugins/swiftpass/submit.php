<?php
if(!defined('IN_PLUGIN'))exit();

if($order['typename']=='alipay'){
	echo "<script>window.location.href='/pay/swiftpass/alipay/{$trade_no}/';</script>";
}elseif($order['typename']=='wxpay'){
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
		echo "<script>window.location.href='/pay/swiftpass/wxjspay/{$trade_no}/?d=1';</script>";
	}elseif(checkmobile()==true){
		if(in_array('2',$channel['apptype'])){
			echo "<script>window.location.href='/pay/swiftpass/wxh5pay/{$trade_no}/';</script>";
		}else{
			echo "<script>window.location.href='/pay/swiftpass/wxwappay/{$trade_no}/';</script>";
		}
	}else{
		echo "<script>window.location.href='/pay/swiftpass/wxpay/{$trade_no}/';</script>";
	}
}elseif($order['typename']=='qqpay'){
	if(checkmobile()==true){
		echo "<script>window.location.href='/pay/swiftpass/qqwappay/{$trade_no}/';</script>";
	}else{
		echo "<script>window.location.href='/pay/swiftpass/qqpay/{$trade_no}/';</script>";
	}
}elseif($order['typename']=='jdpay'){
	echo "<script>window.location.href='/pay/swiftpass/jdpay/{$trade_no}/';</script>";
}elseif($order['typename']=='bank'){
	echo "<script>window.location.href='/pay/swiftpass/bank/{$trade_no}/';</script>";
}
