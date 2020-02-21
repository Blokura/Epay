<?php
include("../includes/common.php");

function showerror($msg){
	include ROOT.'paypage/error.php';
	exit;
}

function showerrorjson($msg){
	$result = ['code'=>-1, 'msg'=>$msg];
	exit(json_encode($result));
}

function check_paytype(){
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger/')!==false){
		$type='wxpay';
	}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient/')!==false){
		$type='alipay';
	}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/')!==false){
		$type='qqpay';
	}
	return $type;
}

function alipayOpenId($channel){
	global $DB,$siteurl;
	$channel = \lib\Channel::get($channel);
	if(!$channel)showerror('支付通道不存在');
	define("PAY_ROOT", PLUGIN_ROOT.$channel['plugin'].'/');
	require_once(PAY_ROOT."inc/AlipayOauthService.php");
	$config['redirect_uri'] = $siteurl.'paypage/';
	$oauth = new AlipayOauthService($config);
	if(isset($_GET['auth_code'])){
		$result = $oauth->getToken($_GET['auth_code']);
		if($result['user_id']){
			return $result['user_id'];
		}else{
			showerror('支付宝快捷登录失败！['.$result['sub_code'].']'.$result['sub_msg']);
		}
	}else{
		$oauth->oauth();
	}
}

function weixinOpenId($channel){
	global $DB;
	$channel = \lib\Channel::get($channel);
	if(!$channel)showerror('支付通道不存在');
	define("PAY_ROOT", PLUGIN_ROOT.$channel['plugin'].'/');
	require_once PAY_ROOT."inc/WxPay.Api.php";
	require_once PAY_ROOT."inc/WxPay.JsApiPay.php";
	$tools = new JsApiPay();
	$openId = $tools->GetOpenid();
	if(!$openId)showerror('OpenId获取失败');
	return $openId;
}

function alipay_jspay($channel,$trade_no,$money,$name,$openid){
	global $DB,$conf;
	$channel = \lib\Channel::get($channel);
	if(!$channel)showerrorjson('支付通道不存在');
	define("PAY_ROOT", PLUGIN_ROOT.$channel['plugin'].'/');
	define("TRADE_NO", $trade_no);

	require_once(PAY_ROOT."inc/model/builder/AlipayTradeCreateContentBuilder.php");
	require_once(PAY_ROOT."inc/AlipayTradeService.php");

	// 创建请求builder，设置请求参数
	$qrPayRequestBuilder = new AlipayTradeCreateContentBuilder();
	$qrPayRequestBuilder->setOutTradeNo(TRADE_NO);
	$qrPayRequestBuilder->setTotalAmount($money);
	$qrPayRequestBuilder->setSubject($name);
	$qrPayRequestBuilder->setBuyerId($openid);

	// 调用qrPay方法获取当面付应答
	$qrPay = new AlipayTradeService($config);
	$qrPayResult = $qrPay->create($qrPayRequestBuilder);

	//	根据状态值进行业务处理
	$status = $qrPayResult->getTradeStatus();
	$response = $qrPayResult->getResponse();
	if($status == 'SUCCESS'){
		$trade_no = $response->trade_no;
		return $trade_no;
	}elseif($status == 'FAILED'){
		showerrorjson('支付宝创建订单失败！['.$response->sub_code.']'.$response->sub_msg);
	}else{
		showerrorjson('系统异常，状态未知！');
	}
}

function wxpay_jspay($channel,$trade_no,$money,$name,$openid){
	global $DB,$conf;
	$channel = \lib\Channel::get($channel);
	if(!$channel)showerrorjson('支付通道不存在');
	define("PAY_ROOT", PLUGIN_ROOT.$channel['plugin'].'/');
	define("TRADE_NO", $trade_no);

	require_once PAY_ROOT."inc/WxPay.Api.php";
	require_once PAY_ROOT."inc/WxPay.JsApiPay.php";

	$input = new WxPayUnifiedOrder();
	$input->SetBody($name);
	$input->SetOut_trade_no(TRADE_NO);
	$input->SetTotal_fee($money*100);
	$input->SetTime_start(date("YmdHis"));
	$input->SetTime_expire(date("YmdHis", time() + 600));
	$input->SetNotify_url($conf['localurl'].'pay/wxpay/notify/'.TRADE_NO.'/');
	$input->SetTrade_type("JSAPI");
	$input->SetProduct_id("01001");
	$input->SetOpenid($openid);
	$order = WxPayApi::unifiedOrder($input);

	if($order["result_code"]=='SUCCESS'){
		$tools = new JsApiPay();
		$jsApiParameters = $tools->GetJsApiParameters($order);
		return $jsApiParameters;
	}else{
		showerrorjson('微信支付下单失败！['.$order["return_code"].'] '.$order["return_msg"].'['.$order["err_code"].'] '.$order["err_code_des"]);
	}
}

function qqpay_jspay($channel,$trade_no,$money,$name){
	global $DB,$conf;
	$channel = \lib\Channel::get($channel);
	if(!$channel)showerrorjson('支付通道不存在');
	define("PAY_ROOT", PLUGIN_ROOT.$channel['plugin'].'/');
	define("TRADE_NO", $trade_no);

	require_once (PAY_ROOT.'inc/qpayMchAPI.class.php');

	//入参
	$params = array();
	$params["out_trade_no"] = TRADE_NO;
	$params["body"] = $name;
	$params["fee_type"] = "CNY";
	$params["notify_url"] = $conf['localurl'].'pay/qqpay/notify/'.TRADE_NO.'/';
	$params["spbill_create_ip"] = real_ip();
	$params["total_fee"] = $money*100;
	$params["trade_type"] = "JSAPI";

	//api调用
	$qpayApi = new QpayMchAPI('https://qpay.qq.com/cgi-bin/pay/qpay_unified_order.cgi', null, 10);
	$ret = $qpayApi->reqQpay($params);
	$result = QpayMchUtil::xmlToArray($ret);
	//print_r($result);

	if($result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS'){
		$prepay_id = $result['prepay_id'];
		return $prepay_id;
	}elseif(isset($result["err_code"])){
		showerrorjson('QQ钱包支付下单失败！['.$result["err_code"].'] '.$result["err_code_des"]);
	}else{
		showerrorjson('QQ钱包支付下单失败！['.$result["return_code"].'] '.$result["return_msg"]);
	}
}