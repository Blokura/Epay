<?php
include("../includes/common.php");
if($islogin2==1 && isset($_SESSION[$uid.'_certify_id'])){
	exit("<script language='javascript'>window.location.href='./certificate.php?certify_id={$_SESSION[$uid.'_certify_id']}';</script>");
}
@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <link href="//cdn.bootcss.com/ionic/1.3.1/css/ionic.min.css" rel="stylesheet" />
</head>
<body>
<div class="bar bar-header bar-light" align-title="center">
	<h1 class="title">实名认证结果页面</h1>
</div>
<div class="has-header" style="padding: 5px;position: absolute;width: 100%;">
<div class="text-center" style="color: #a09ee5;">
<i class="icon ion-checkmark-circled" style="font-size: 80px;"></i><br>
<span>实名认证成功，请关闭此页面</span>
</div>
</div>
<script>
document.querySelector('body').addEventListener('touchmove', function (event) {
	event.preventDefault();
});
</script>
</body>
</html>