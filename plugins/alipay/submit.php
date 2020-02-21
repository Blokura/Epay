<?php
if(!defined('IN_PLUGIN'))exit();

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false && !$submit2){
	echo "<script>window.location.href='/submit2.php?typeid={$order['type']}&trade_no={$trade_no}';</script>";exit;
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
	include(SYSTEM_ROOT.'pages/wxopen.php');
	exit;
}

if(in_array('3',$channel['apptype']) && !in_array('1',$channel['apptype']) && !in_array('2',$channel['apptype'])){
	echo "<script>window.location.href='/pay/alipay/qrcode/{$trade_no}/?sitename={$sitename}';</script>";
}else{

if(!empty($conf['localurl_alipay']) && !strpos($conf['localurl_alipay'],$_SERVER['HTTP_HOST'])){
	echo "<script>window.location.href='{$conf['localurl_alipay']}submit2.php?typeid={$order['type']}&trade_no={$trade_no}';</script>";exit;
}

if(checkmobile()==true && in_array('2',$channel['apptype'])){
	require_once(PAY_ROOT."inc/model/builder/AlipayTradeWapPayContentBuilder.php");
	require_once(PAY_ROOT."inc/AlipayTradeService.php");

	//构造参数
	$payRequestBuilder = new AlipayTradeWapPayContentBuilder();
	$payRequestBuilder->setSubject($ordername);
	$payRequestBuilder->setTotalAmount($order['money']);
	$payRequestBuilder->setOutTradeNo($trade_no);

	$aop = new AlipayTradeService($config);
	echo $aop->wapPay($payRequestBuilder);
}else{
	require_once(PAY_ROOT."inc/model/builder/AlipayTradePagePayContentBuilder.php");
	require_once(PAY_ROOT."inc/AlipayTradeService.php");

	//构造参数
	$payRequestBuilder = new AlipayTradePagePayContentBuilder();
	$payRequestBuilder->setSubject($ordername);
	$payRequestBuilder->setTotalAmount($order['money']);
	$payRequestBuilder->setOutTradeNo($trade_no);

	$aop = new AlipayTradeService($config);
	echo $aop->pagePay($payRequestBuilder);
}
}