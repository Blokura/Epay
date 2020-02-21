<?php
/*
 * 京东支付退款接口
*/
if(!defined('IN_REFUND'))exit();

require_once(PAY_ROOT."inc/common/XMLUtil.php");
require_once(PAY_ROOT."inc/common/HttpUtils.php");

define("Confid_desKey",$channel['appkey']);

$param["version"]="V2.0";
$param["merchant"]=$channel['appid'];
$param["tradeNum"]=$order['trade_no'].rand(000,999);
$param["oTradeNum"]=$order['api_trade_no'];
$param["amount"]=$order['realmoney']*100;
$param["currency"]="CNY";

$reqXmlStr = XMLUtil::encryptReqXml($param);
$url = 'https://paygate.jd.com/service/refund';

$httputil = new HttpUtils();
list ( $return_code, $return_content )  = $httputil->http_post_data($url, $reqXmlStr);
//echo $return_content."\n";

$flag=XMLUtil::decryptResXml($return_content,$resData);
//echo var_dump($resData);

if($flag){
	if($resData['status'] == "1"){
		$result = ['code'=>0, 'trade_no'=>$resData['oTradeNum'], 'refund_fee'=>$resData['amount']];
	}else{
		$result = ['code'=>-1, 'msg'=>'['.$resData['result']['code'].']'.$resData['result']['desc']];
	}
}else{
	$result = ['code'=>-1, 'msg'=>'验签失败'];
}

return $result;