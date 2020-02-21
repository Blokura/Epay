<?php
/*
 * 微信公众号支付
 * https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=7_3
*/
if(!defined('IN_PLUGIN'))exit();

@header('Content-Type: text/html; charset=UTF-8');

if($_SESSION[$trade_no.'_wxpay']){
	$jsApiParameters=$_SESSION[$trade_no.'_wxpay'];
}else{
require_once PAY_ROOT."inc/WxPay.Api.php";
require_once PAY_ROOT."inc/WxPay.JsApiPay.php";
//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
if(!$openId)sysmsg('OpenId获取失败');
$DB->query("update `pre_order` set `buyer` ='$openId' where `trade_no`='".TRADE_NO."'");

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody($ordername);
$input->SetOut_trade_no(TRADE_NO);
$input->SetTotal_fee(strval($order['money']*100));
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetNotify_url($conf['localurl'].'pay/wxpay/notify/'.TRADE_NO.'/');
$input->SetTrade_type("JSAPI");
$input->SetProduct_id("01001");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);

if($order["result_code"]=='SUCCESS'){
	$jsApiParameters = $tools->GetJsApiParameters($order);
}else{
	sysmsg('微信支付下单失败！['.$order["return_code"].'] '.$order["return_msg"].'['.$order["err_code"].'] '.$order["err_code_des"]);
}
$_SESSION[$trade_no.'_wxpay'] = $jsApiParameters;
}

if($_GET['d']==1){
	$redirect_url='data.backurl';
}else{
	$redirect_url='\'/pay/wxpay/ok/'.TRADE_NO.'/\'';
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
<script src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
	$(document).on('touchmove',function(e){
		e.preventDefault();
	});
    //调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
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
    // 检查是否支付完成
    function loadmsg() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/getshop.php",
            timeout: 10000, //ajax请求超时时间10s
            data: {type: "wxpay", trade_no: "<?php echo TRADE_NO?>"}, //post数据
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.code == 1) {
					layer.msg('支付成功，正在跳转中...', {icon: 16,shade: 0.01,time: 15000});
                    window.location.href=<?php echo $redirect_url?>;
                }else{
                    setTimeout("loadmsg()", 2000);
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