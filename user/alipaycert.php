<?php
include("../includes/common.php");
$certify_id = isset($_GET['id'])?$_GET['id']:exit('param is error');
$channel = \lib\Channel::get($conf['cert_channel']);
if(!$channel)sysmsg('当前实名认证通道信息不存在');
define("IN_PLUGIN", true);
define("PAY_ROOT", PLUGIN_ROOT.'alipay/');
require_once PAY_ROOT."inc/AlipayCertifyService.php";
$certify = new AlipayCertifyService($config);
$html = $certify->certify($certify_id);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
	<title>正在跳转</title>
	<style type="text/css">
        body {margin:0;padding:0;}
        p {position:absolute;
            left:50%;top:50%;
            width:330px;height:30px;
            margin:-35px 0 0 -160px;
            padding:20px;font:bold 14px/30px "宋体", Arial;
            background:#f9fafc url(../assets/img/loading.gif) no-repeat 20px 20px;
            text-indent:40px;border:1px solid #c5d0dc;}
        #waiting {font-family:Arial;}
    </style>
</head>
<body>
<p>正在跳转，请稍候...</p>
<?php echo $html?>
</body>
</html>