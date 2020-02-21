<?php
if(!defined('IN_PLUGIN'))exit();

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false && !$submit2){
	echo "<script>window.location.href='/submit2.php?typeid={$order['type']}&trade_no={$trade_no}';</script>";exit;
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
	include(SYSTEM_ROOT.'pages/wxopen.php');
	exit;
}
if(!empty($conf['localurl_alipay']) && !strpos($conf['localurl_alipay'],$_SERVER['HTTP_HOST'])){
	echo "<script>window.location.href='{$conf['localurl_alipay']}submit2.php?typeid={$order['type']}&trade_no={$trade_no}';</script>";exit;
}

require_once(PAY_ROOT."inc/alipay.config.php");
require_once(PAY_ROOT."inc/alipay_submit.class.php");

if(checkmobile()==true && in_array('2',$channel['apptype'])){
	$alipay_service = "alipay.wap.create.direct.pay.by.user";
}else{
	$alipay_service = "create_direct_pay_by_user";
}
$parameter = array(
	"service" => $alipay_service,
	"partner" => trim($alipay_config['partner']), //合作身份者id
	"seller_id" => trim($alipay_config['partner']), //收款支付宝用户号
	"payment_type"	=> "1", //支付方式
	"notify_url"	=> $conf['localurl'].'pay/aliold/notify/'.TRADE_NO.'/', //服务器异步通知页面路径
	"return_url"	=> $siteurl.'pay/aliold/return/'.TRADE_NO.'/', //页面跳转同步通知页面路径
	"out_trade_no"	=> $trade_no, //商户订单号
	"subject"	=> $ordername, //订单名称
	"total_fee"	=> $order['money'], //付款金额
	"_input_charset"	=> strtolower('utf-8')
);
if($alipay_service=="alipay.wap.create.direct.pay.by.user"){
	$parameter['app_pay'] = "Y";
}

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "正在跳转");
echo $html_text;