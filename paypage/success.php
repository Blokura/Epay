<?php
include("./inc.php");
@header('Content-Type: text/html; charset=UTF-8');
$trade_no=daddslashes($_GET['trade_no']);
$row=$DB->getRow("SELECT * FROM pre_order WHERE trade_no='{$trade_no}' limit 1");
if(!$row)showerror('订单号不存在');
if($row['status']!=1)showerror('订单未完成支付');
if(!isset($_SESSION['paypage_trade_no']) || $_SESSION['paypage_trade_no']!=$trade_no)showerror('订单校验失败');
$userrow=$DB->getRow("select codename,username from pre_user where uid='{$row['uid']}' limit 1");
$codename = !empty($userrow['codename'])?$userrow['codename']:$userrow['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>支付成功页面</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <link href="//cdn.staticfile.org/ionic/1.3.2/css/ionic.min.css" rel="stylesheet" />
	<style>
	body,input,button,h1{font-size:16px;font-family: 'PingFang SC', 'Helvetica Neue', Helvetica, Arial, 'Hiragino Sans GB', 'Microsoft Yahei', 微软雅黑, STHeiti, 华文细黑, sans-serif; padding:0;margin:0}
	</style>
</head>
<body>
<div class="bar bar-header bar-light" align-title="center">
	<h1 class="title">支付成功页面</h1>
</div>
<div class="has-header" style="padding: 5px;position: absolute;width: 100%;">
<div class="text-center" style="color: #22ac38;">
<i class="icon ion-checkmark-circled" style="font-size: 80px;"></i><br>
</div>
<div class="text-center" style="margin-top: 30px;">
<p><span style="font-size: 18px;color: #666;"><?php echo $codename?></span></p>
<p><span style="font-size: 18px;color: #666;">支付金额：<span style="font-size:24px;font-weight:700;color:#f40;">￥<?php echo $row['money']?></span></span></p>
<p><span style="font-size: 14px;color: #666;">支付时间：<?php echo $row['endtime']?></span></p>
<p><span style="font-size: 14px;color: #666;">订单号：<?php echo $trade_no?></span></p>
</div>
</div>
<script>
document.querySelector('body').addEventListener('touchmove', function (event) {
	event.preventDefault();
});
</script>
</body>
</html>