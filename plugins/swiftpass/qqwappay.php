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
$reqHandler->setParameter('service','pay.tenpay.native');//接口类型
$reqHandler->setParameter('mch_id',$cfg->C('mchId'));//必填项，商户号，由平台分配
$reqHandler->setParameter('version',$cfg->C('version'));
$reqHandler->setParameter('sign_type',$cfg->C('sign_type'));
$reqHandler->setParameter('body',$order['name']);
$reqHandler->setParameter('total_fee',strval($order['money']*100));
$reqHandler->setParameter('mch_create_ip',$clientip);
$reqHandler->setParameter('out_trade_no',TRADE_NO);
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
			$code_url = $resHandler->getParameter('code_url');
		}else{
			sysmsg('QQ钱包支付下单失败 ['.$resHandler->getParameter('err_code').']'.$resHandler->getParameter('err_msg'));
		}
	}else{
		sysmsg('QQ钱包支付下单失败 ['.$resHandler->getParameter('status').']'.$resHandler->getParameter('message'));
	}
}else{
	sysmsg('支付接口调用失败 ['.$pay->getResponseCode().']'.$pay->getErrInfo());
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/')!==false){
	exit("<script>window.location.href='{$code_url}';</script>");
}

?>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>QQ钱包支付</title>
  <link href="//cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>

<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
<div class="panel panel-default">
	<div class="panel-heading" style="text-align: center;"><h3 class="panel-title">
		<img src="assets/icon/qqpay.ico">QQ钱包支付手机版
	</div>
		<div class="list-group" style="text-align: center;">
			<div class="list-group-item"><h1>￥<?php echo $order['money']?><h1></div>
			<div class="list-group-item">商品名称：<?php echo $order['name']?><br/>商户订单号：<?php echo $order['trade_no']?><br/>创建时间：<?php echo $order['addtime']?></div>
			<div class="list-group-item"><a href="" id="openUrl" class="btn btn-primary btn-block">跳转到QQ支付</a></div>
			<div class="list-group-item"><a href="#" onclick="checkresult()" class="btn btn-success btn-block">检测支付状态</a></div>
			<div class="list-group-item"><a href="/pay/swiftpass/qqpay/<?php echo TRADE_NO?>/" class="btn btn-default btn-sm btn-block">使用扫码支付</a></div>
		</div>
</div>
</div>
<script src="/assets/js/qcloud_util.js"></script>
<script src="/assets/layer/layer.js"></script>
<script>
	var isSafari = navigator.userAgent.indexOf("Safari") > -1;
	var code_url = '<?php echo $code_url?>';
	var	tencentSeries = 'mqqapi://forward/url?src_type=web&style=default&=1&version=1&url_prefix='+window.btoa(code_url);
	if(isSafari){
		location.href = tencentSeries;
	}
	else{
		var iframe = document.createElement("iframe");
        iframe.style.display = "none";
        iframe.src = tencentSeries;
        document.body.appendChild(iframe);
	}
	document.getElementById("openUrl").href = tencentSeries; 
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
					setTimeout(window.location.href=data.backurl, 1000);
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
	function checkresult() {
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
					setTimeout(window.location.href=data.backurl, 1000);
                }
            },
            //Ajax请求超时，继续查询
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('服务器错误');
            }
        });
    }
    window.onload = loadmsg();
</script>
</body>
</html>