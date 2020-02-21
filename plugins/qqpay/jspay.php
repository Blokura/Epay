<?php
/*
 * QQ钱包公众号支付
*/
if(!defined('IN_PLUGIN'))exit();

@header('Content-Type: text/html; charset=UTF-8');

require_once (PAY_ROOT.'inc/qpayMchAPI.class.php');

//入参
$params = array();
$params["out_trade_no"] = TRADE_NO;
$params["body"] = $ordername;
$params["fee_type"] = "CNY";
$params["notify_url"] = $conf['localurl'].'pay/qqpay/notify/'.TRADE_NO.'/';
$params["spbill_create_ip"] = $clientip;
$params["total_fee"] = strval($order['money']*100);
$params["trade_type"] = "JSAPI";

//api调用
$qpayApi = new QpayMchAPI('https://qpay.qq.com/cgi-bin/pay/qpay_unified_order.cgi', null, 10);
$ret = $qpayApi->reqQpay($params);
$result = QpayMchUtil::xmlToArray($ret);
//print_r($result);

if($result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS'){
	$prepay_id = $result['prepay_id'];
}elseif(isset($result["err_code"])){
	sysmsg('QQ钱包支付下单失败！['.$result["err_code"].'] '.$result["err_code_des"]);
}else{
	sysmsg('QQ钱包支付下单失败！['.$result["return_code"].'] '.$result["return_msg"]);
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
	<h1 class="title">QQ钱包安全支付</h1>
</div>
<div class="has-header" style="padding: 5px;position: absolute;width: 100%;">
<div class="text-center" style="color: #a09ee5;">
<i class="icon ion-information-circled" style="font-size: 80px;"></i><br>
<span>正在跳转...</span>
<script src="//cdn.staticfile.org/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script src="//open.mobile.qq.com/sdk/qqapi.js?_bid=152"></script>
<script>
	$(document).on('touchmove',function(e){
		e.preventDefault();
	});

	function callpay()
	{
		mqq.tenpay.pay({
			tokenId: '<?php echo $prepay_id; ?>',
			appInfo: "appid#<?php echo QpayMchConf::MCH_APPID;?>|bargainor_id#<?php echo QpayMchConf::MCH_ID;?>|channel#wallet"
		}, function(result, resultCode){
			if(result.resultCode == 0){ //支付成功
				loadmsg();
			}
		});
	}
    // 检查是否支付完成
    function loadmsg() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/getshop.php",
            timeout: 10000, //ajax请求超时时间10s
            data: {type: "qqpay", trade_no: "<?php echo $order['trade_no']?>"}, //post数据
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.code == 1) {
					layer.msg('支付成功，正在跳转中...', {icon: 16,shade: 0.01,time: 15000});
                    window.location.href=data.backurl;
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