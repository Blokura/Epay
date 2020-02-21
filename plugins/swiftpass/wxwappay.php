<?php
if(!defined('IN_PLUGIN'))exit();

@header('Content-Type: text/html; charset=UTF-8');

$target_url = $siteurl.'pay/swiftpass/wxjspay/'.TRADE_NO.'/';
?>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>微信支付</title>
  <link href="//cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>

<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
<div class="panel panel-primary">
	<div class="panel-heading" style="text-align: center;"><h3 class="panel-title">
		<img src="/assets/icon/wechat.ico">微信支付手机版
	</div>
		<div class="list-group" style="text-align: center;">
			<div class="list-group-item list-group-item-info">长按保存到相册使用扫码扫码完成支付</div>
			<div class="list-group-item">
			<div class="qr-image" id="qrcode"></div>
			</div>
			<div class="list-group-item list-group-item-info">或复制以下链接到微信打开：</div>
			<div class="list-group-item">
			<a href="<?php echo $target_url?>"><?php echo $target_url?></a><br/><button id="copy-btn" data-clipboard-text="<?php echo $target_url?>" class="btn btn-info btn-sm">一键复制</button>
			</div>
			<div class="list-group-item"><small>提示：你可以将以上链接发到自己微信的聊天框（在微信顶部搜索框可以搜到自己的微信），即可点击进入支付</small></div>
			<div class="list-group-item"><a href="weixin://" class="btn btn-primary">打开微信</a>&nbsp;<a href="#" onclick="checkresult()" class="btn btn-success">检测支付状态</a></div>
		</div>
</div>
</div>
<script src="/assets/js/qcloud_util.js"></script>
<script src="/assets/js/jquery-qrcode.min.js"></script>
<script src="/assets/layer/layer.js"></script>
<script src="//cdn.staticfile.org/clipboard.js/1.7.1/clipboard.min.js"></script>
<script>
	var clipboard = new Clipboard('#copy-btn');
	clipboard.on('success', function(e) {
		layer.msg('复制成功，请到微信里面粘贴');
	});
	clipboard.on('error', function(e) {
		layer.msg('复制失败，请长按链接后手动复制');
	});
	$('#qrcode').qrcode({
        text: "<?php echo $target_url?>",
        width: 230,
        height: 230,
        foreground: "#000000",
        background: "#ffffff",
        typeNumber: -1
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
            data: {type: "wxpay", trade_no: "<?php echo $order['trade_no']?>"}, //post数据
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