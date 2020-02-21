<?php
if(!defined('IN_REFUND'))exit();

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
$reqHandler->setKey($cfg->C('key'));
$reqHandler->setParameter('service','unified.trade.refund');//接口类型
$reqHandler->setParameter('version',$cfg->C('version'));
$reqHandler->setParameter('sign_type',$cfg->C('sign_type'));
$reqHandler->setParameter('mch_id',$cfg->C('mchId'));//必填项，商户号，由平台分配
$reqHandler->setParameter('transaction_id',$order['api_trade_no']);
$reqHandler->setParameter('out_refund_no',$order['trade_no']);
$reqHandler->setParameter('total_fee',strval($order['realmoney']*100));
$reqHandler->setParameter('refund_fee',strval($order['realmoney']*100));
$reqHandler->setParameter('nonce_str',mt_rand(time(),time()+rand()));//随机字符串，必填项，不长于 32 位
$reqHandler->createSign();//创建签名

$data = Utils::toXml($reqHandler->getAllParameters());
//var_dump($data);

$pay->setReqContent($reqHandler->getGateURL(),$data);
if($pay->call()){
	$resHandler->setContent($pay->getResContent());
	$resHandler->setKey($cfg->C('key'));
	if($resHandler->isTenpaySign()){
		//当返回状态与业务结果都为0时才返回支付二维码，其它结果请查看接口文档
		if($resHandler->getParameter('status') == 0 && $resHandler->getParameter('result_code') == 0){
			$result = ['code'=>0, 'trade_no'=>$resHandler->getParameter('refund_id'), 'refund_fee'=>$resHandler->getParameter('refund_fee')];
		}else{
			$result = ['code'=>-1, 'msg'=>'['.$resHandler->getParameter('err_code').']'.$resHandler->getParameter('err_msg')];
		}
	}else{
		$result = ['code'=>-1, 'msg'=>'['.$resHandler->getParameter('status').']'.$resHandler->getParameter('message')];
	}
}else{
	$result = ['code'=>-1, 'msg'=>'退款接口调用失败 ['.$pay->getResponseCode().']'.$pay->getErrInfo()];
}
return $result;