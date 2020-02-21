<!DOCTYPE html>
<html>
<head>
    <title>错误提示</title>
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
	<h1 class="title">错误提示</h1>
</div>
<div class="has-header" style="padding: 5px;position: absolute;width: 100%;">
<div class="text-center" style="color: #ff5757;">
<i class="icon ion-close-circled" style="font-size: 80px;"></i><br>
</div>
<div class="text-center" style="margin-top: 30px;">
<span style="font-size: 18px;color: #666;"><?php echo $msg?></span>
</div>
</div>
<script>
document.querySelector('body').addEventListener('touchmove', function (event) {
	event.preventDefault();
});
</script>
</body>
</html>