<?php 
if(!defined('IN_PLUGIN'))exit();

require_once(PAY_ROOT."inc/micro.config.php");
require_once(PAY_ROOT."inc/micro_notify.class.php");

@header('Content-Type: text/html; charset=UTF-8');

$url=creat_callback($srow);

if ($order['status']==1) {
	echo '<script>window.location.href="'.$url['return'].'";</script>';
	exit;
}else{
	$alipayNotify = new AlipayNotify($alipay_config);
	$verify_result = $alipayNotify->verifyReturn();
	if($verify_result){
		if($order['status']==0){
			if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='$out_trade_no'")){
				$DB->exec("update `pre_order` set `endtime` ='$date',`date` =NOW() where `trade_no`='$out_trade_no'");
				processOrder($order,false);
			}
		}
		echo '<script>window.location.href="'.$url['return'].'";</script>';
		exit;
	}
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
	<h1 class="title">支付结果页面</h1>
</div>
<div class="has-header" style="padding: 5px;position: absolute;width: 100%;">
<div class="text-center" style="color: #a09ee5;">
<i class="icon ion-close-circled" style="font-size: 80px;"></i><br>
<span>支付未完成</span>
</div>
</div>
<script>
document.querySelector('body').addEventListener('touchmove', function (event) {
	event.preventDefault();
});
</script>
</body>
</html>