<?php
$nosession=true;
include("../includes/common.php");
if(isset($_GET['sid'])){
	$sid = trim(daddslashes($_GET['sid']));
	if(!preg_match('/^(.[a-zA-Z0-9]+)$/',$sid))exit("Access Denied");
	session_id($sid);
}
session_start();

@header('Content-Type: text/html; charset=UTF-8');

if(!$conf['login_wx'])sysmsg("未开启微信快捷登录");
$channel = \lib\Channel::get($conf['login_wx']);
if(!$channel)exit('{"code":-1,"msg":"当前支付通道信息不存在"}');
define("PAY_ROOT", PLUGIN_ROOT.'wxpay/');

require_once PAY_ROOT."inc/WxPay.Api.php";
require_once PAY_ROOT."inc/WxPay.JsApiPay.php";

$tools = new JsApiPay();
$openId = $tools->GetOpenid();

if(!$openId)sysmsg('OpenId获取失败');

$_SESSION['openid'] = $openId;

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
	<title>获取OpenID</title>
    <link href="//cdn.bootcss.com/ionic/1.3.1/css/ionic.min.css" rel="stylesheet" />
<style type="text/css">
.qr-text {padding: 30px;margin: 5px 0;background-color: #FDFDCA;border-radius: 3px;border: 1px solid #EEEEEE;word-wrap: break-word;word-break: break-all;}
</style>
</head>
<body>
<div class="bar bar-header bar-light" align-title="center">
	<h1 class="title">提示信息</h1>
</div>
<div class="has-header" style="padding: 5px;position: absolute;width: 100%;">
<div class="text-center" style="color: #a09ee5;">
<i class="icon ion-checkmark-circled" style="font-size: 80px;"></i><br>
<span>获取OpenId成功</span>
</div>
<div class="text-center" style="padding: 15px;">
<span>如未自动填写，请手动复制下方OpenId：</span>
<p class="qr-text"><strong><?php echo $openId?></strong></p>
</div>
</div>
<script>
document.querySelector('body').addEventListener('touchmove', function (event) {
	event.preventDefault();
});
</script>
</body>
</html>