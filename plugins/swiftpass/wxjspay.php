<?php
if(!defined('IN_PLUGIN'))exit();

@header('Content-Type: text/html; charset=UTF-8');

require_once PAY_ROOT."inc/WxPay.JsApiPay.php";
//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
//②、统一下单
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
$reqHandler->setParameter('service','pay.weixin.jspay');//接口类型
$reqHandler->setParameter('mch_id',$cfg->C('mchId'));//必填项，商户号，由平台分配
$reqHandler->setParameter('version',$cfg->C('version'));
$reqHandler->setParameter('sign_type',$cfg->C('sign_type'));
$reqHandler->setParameter('is_raw','1');
$reqHandler->setParameter('body',$order['name']);
$reqHandler->setParameter('sub_appid',WxPayConfig::APPID);
$reqHandler->setParameter('sub_openid',$openId);
$reqHandler->setParameter('total_fee',strval($order['money']*100));
$reqHandler->setParameter('mch_create_ip',$clientip);
$reqHandler->setParameter('out_trade_no',TRADE_NO);
$reqHandler->setParameter('device_info', 'AND_WAP');//应用类型
$reqHandler->setParameter('notify_url',$conf['localurl'].'pay/swiftpass/notify/'.TRADE_NO.'/');
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
		}else{
			sysmsg('微信支付下单失败 ['.$resHandler->getParameter('err_code').']'.$resHandler->getParameter('err_msg'));
		}
	}else{
		sysmsg('微信支付下单失败 ['.$resHandler->getParameter('status').']'.$resHandler->getParameter('message'));
	}
}else{
	sysmsg('支付接口调用失败 ['.$pay->getResponseCode().']'.$pay->getErrInfo());
}
if($_GET['d']==1){
	$redirect_url='window.location.href=data.backurl';
}else{
	$redirect_url='WeixinJSBridge.invoke("closeWindow", {}, function(e) {});';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <link href="//cdn.staticfile.org/ionic/1.3.2/css/ionic.min.css" rel="stylesheet" />
</head>
<body>
<div class="bar bar-header bar-light" align-title="center">
	<h1 class="title">微信安全支付</h1>
</div>
<div class="has-header" style="padding: 5px;position: absolute;width: 100%;">
<div class="text-center" style="color: #a09ee5;">
<i class="icon ion-information-circled" style="font-size: 80px;"></i><br>
<span>正在跳转...</span>
<script src="/assets/js/qcloud_util.js"></script>
<script>
	$(document).on('touchmove',function(e){
		e.preventDefault();
	});
    //调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $pay_info; ?>,
			function(res){
				if(res.err_msg == "get_brand_wcpay_request:ok" ) {
					loadmsg();
				}
				//WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
    // 订单详情
    $('#orderDetail .arrow').click(function (event) {
        if ($('#orderDetail').hasClass('detail-open')) {
            $('#orderDetail .detail-ct').slideUp(500, function () {
                $('#orderDetail').removeClass('detail-open');
            });
        } else {
            $('#orderDetail .detail-ct').slideDown(500, function () {
                $('#orderDetail').addClass('detail-open');
            });
        }
    });
    // 检查是否支付完成
    function loadmsg() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/getshop.php",
            timeout: 10000, //ajax请求超时时间10s
            data: {type: "wxpay", trade_no: "<?php echo $order['trade_no']?>"}, //post数据
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.code == 1) {
                    <?php echo $redirect_url?>
                }else{
                    setTimeout("loadmsg()", 4000);
                }
            },
            //Ajax请求超时，继续查询
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (textStatus == "timeout") {
                    setTimeout("loadmsg()", 1000);
                } else { //异常
                    setTimeout("loadmsg()", 4000);
                }
            }
        });
    }
    window.onload = callpay();
</script>
</div>
</div>
</body>
</html>