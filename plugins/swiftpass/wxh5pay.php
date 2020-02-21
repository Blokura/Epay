<?php
if(!defined('IN_PLUGIN'))exit();

@header('Content-Type: text/html; charset=UTF-8');

require(PAY_ROOT.'inc/class/Utils.class.php');
require(PAY_ROOT.'inc/config.php');
require(PAY_ROOT.'inc/class/RequestHandler.class.php');
require(PAY_ROOT.'inc/class/ClientResponseHandler.class.php');
require(PAY_ROOT.'inc/class/PayHttpClient.class.php');

$resHandler = new ClientResponseHandler();
$reqHandler = new RequestHandler();
$pay = new PayHttpClient();
$cfg = new Config();

$reqHandler->setGateUrl($cfg->C('url'));
$reqHandler->setSignType($cfg->C('sign_type'));
$reqHandler->setRSAKey($cfg->C('private_rsa_key'));
$reqHandler->setParameter('service','pay.weixin.wappay');//接口类型
$reqHandler->setParameter('mch_id',$cfg->C('mchId'));//必填项，商户号，由平台分配
$reqHandler->setParameter('version',$cfg->C('version'));
$reqHandler->setParameter('sign_type',$cfg->C('sign_type'));
$reqHandler->setParameter('body',$order['name']);
$reqHandler->setParameter('total_fee',strval($order['money']*100));
$reqHandler->setParameter('mch_create_ip',$clientip);
$reqHandler->setParameter('out_trade_no',TRADE_NO);
$reqHandler->setParameter('device_info', 'AND_WAP');//应用类型
$reqHandler->setParameter('mch_app_name',$sitename);//应用名 
$reqHandler->setParameter('mch_app_id',$siteurl);//应用标识
$reqHandler->setParameter('notify_url',$conf['localurl'].'pay/swiftpass/notify/'.TRADE_NO.'/');
$reqHandler->setParameter('callback_url',$siteurl.'pay/swiftpass/return/'.TRADE_NO.'/');
$reqHandler->setParameter('nonce_str',mt_rand(time(),time()+rand()));//随机字符串，必填项，不长于 32 位
$reqHandler->createSign();//创建签名

$data = Utils::toXml($reqHandler->getAllParameters());
//var_dump($data);

$pay->setReqContent($reqHandler->getGateURL(),$data);
if($pay->call()){
	$resHandler->setContent($pay->getResContent());
	$resHandler->setRSAKey($cfg->C('public_rsa_key'));
	if($resHandler->isTenpaySign()){
		//当返回状态与业务结果都为0时才返回支付二维码，其它结果请查看接口文档
		if($resHandler->getParameter('status') == 0 && $resHandler->getParameter('result_code') == 0){
			$pay_info = $resHandler->getParameter('pay_info');
			exit("<script>window.location.replace('{$pay_info}');</script>");
		}else{
			sysmsg('微信支付下单失败 ['.$resHandler->getParameter('err_code').']'.$resHandler->getParameter('err_msg'));
		}
	}else{
		sysmsg('微信支付下单失败 ['.$resHandler->getParameter('status').']'.$resHandler->getParameter('message'));
	}
}else{
	sysmsg('支付接口调用失败 ['.$pay->getResponseCode().']'.$pay->getErrInfo());
}
?>