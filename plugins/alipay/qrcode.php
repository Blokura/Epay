<?php
/*
 * 支付宝当面付扫码支付
*/
if(!defined('IN_PLUGIN'))exit();

@header('Content-Type: text/html; charset=UTF-8');

$sitename=htmlspecialchars(base64_decode($_GET['sitename']));

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
	include(SYSTEM_ROOT.'pages/wxopen.php');
	exit;
}

require_once(PAY_ROOT."inc/model/builder/AlipayTradePrecreateContentBuilder.php");
require_once(PAY_ROOT."inc/AlipayTradeService.php");

// 创建请求builder，设置请求参数
$qrPayRequestBuilder = new AlipayTradePrecreateContentBuilder();
$qrPayRequestBuilder->setOutTradeNo(TRADE_NO);
$qrPayRequestBuilder->setTotalAmount($order['money']);
$qrPayRequestBuilder->setSubject($ordername);

// 调用qrPay方法获取当面付应答
$qrPay = new AlipayTradeService($config);
$qrPayResult = $qrPay->qrPay($qrPayRequestBuilder);

//	根据状态值进行业务处理
$status = $qrPayResult->getTradeStatus();
$response = $qrPayResult->getResponse();
if($status == 'SUCCESS'){
	$code_url = $response->qr_code;
}elseif($status == 'FAILED'){
	sysmsg('支付宝创建订单二维码失败！['.$response->sub_code.']'.$response->sub_msg);
}else{
	print_r($response);
	sysmsg('系统异常，状态未知！');
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-cn">
<meta name="renderer" content="webkit">
<title>支付宝扫码支付 - <?php echo $sitename?></title>
<link href="/assets/css/alipay_pay.css" rel="stylesheet" media="screen">
</head>
<body>
<div class="body">
<h1 class="mod-title">
<span class="ico-wechat"></span><span class="text">支付宝扫码支付</span>
</h1>
<div class="mod-ct">
<div class="order">
</div>
<div class="amount">￥<?php echo $order['money']?></div>
<div class="qr-image" id="qrcode">
</div>
 
<div class="detail" id="orderDetail">
<dl class="detail-ct" style="display: none;">
<dt>购买物品</dt>
<dd id="productName"><?php echo $order['name']?></dd>
<dt>商户订单号</dt>
<dd id="billId"><?php echo $order['trade_no']?></dd>
<dt>创建时间</dt>
<dd id="createTime"><?php echo $order['addtime']?></dd>
</dl>
<a href="javascript:void(0)" class="arrow"><i class="ico-arrow"></i></a>
</div>
<div class="tip">
<span class="dec dec-left"></span>
<span class="dec dec-right"></span>
<div class="ico-scan"></div>
<div class="tip-text">
<p>请使用支付宝扫一扫</p>
<p>扫描二维码完成支付</p>
</div>
</div>
<div class="tip-text">
</div>
</div>
<?php if(checkmobile()==true){?>
<div class="foot">
<div class="inner">
<div id="J_downloadInteraction" class="download-interaction download-interaction-opening">
	<div class="inner-interaction">
		<p class="download-opening">正在打开支付宝<span class="download-opening-1">.</span><span class="download-opening-2">.</span><span class="download-opening-3">.</span></p>
		<p class="download-asking">如果没有打开支付宝，<a id="J_downloadBtn" href="javascript:;" onclick="openAli();">请点此重新唤起</a></p>
</div>
</div>
</div>
</div>
<?php }?>
<script src="/assets/js/qcloud_util.js"></script>
<script src="/assets/js/jquery-qrcode.min.js"></script>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
	var code_url = '<?php echo $code_url?>';
    $('#qrcode').qrcode({
        text: code_url,
        width: 230,
        height: 230,
        foreground: "#000000",
        background: "#ffffff",
        typeNumber: -1
    });
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
            data: {type: "alipay", trade_no: "<?php echo $order['trade_no']?>"}, //post数据
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
	function openAli(){
		var scheme = 'alipays://platformapi/startapp?saId=10000007&qrcode=';
		scheme += encodeURIComponent(code_url);

		if(navigator.userAgent.indexOf("Safari") > -1){
			window.location.href = scheme;
		}
		else{
			var iframe = document.createElement("iframe");
			iframe.style.display = "none";
			iframe.src = scheme;
			document.body.appendChild(iframe);
		}
	}
	window.onload = function(){
		openAli();
		setTimeout("loadmsg()", 2000);
	}
</script>
</body>
</html>