<?php
/**
 * 微信登录
**/
$is_defend=true;
$nosession=true;
include("../includes/common.php");
if(!$conf['login_wx'])sysmsg("未开启微信快捷登录");

if(isset($_GET['sid'])){
	$sid = trim(daddslashes($_GET['sid']));
	if(!preg_match('/^(.[a-zA-Z0-9]+)$/',$sid))exit("Access Denied");
	session_id($sid);
}
session_start();

if(isset($_GET['act']) && $_GET['act']=='login'){
	if(isset($_SESSION['openid']) && !empty($_SESSION['openid'])){
		$openId = daddslashes($_SESSION['openid']);
		$userrow=$DB->getRow("SELECT * FROM pre_user WHERE wxid='{$openId}' LIMIT 1");
		if($userrow){
			$uid=$userrow['uid'];
			$key=$userrow['key'];
			if($islogin2==1){
				exit('{"code":-1,"msg":"当前微信已绑定商户ID:'.$uid.'，请勿重复绑定！"}');
			}
			$session=md5($uid.$key.$password_hash);
			$expiretime=time()+604800;
			$token=authcode("{$uid}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
			setcookie("user_token", $token, time() + 604800);
			$DB->exec("update `pre_user` set `lasttime` ='$date' where `uid`='$uid'");
			$result=array("code"=>0,"msg"=>"登录成功！正在跳转到用户中心","url"=>"./");
		}elseif($islogin2==1){
			$sds=$DB->exec("update `pre_user` set `wxid` ='$openId' where `uid`='$uid'");
			$result=array("code"=>0,"msg"=>"已成功绑定微信账号！","url"=>"./editinfo.php");
		}else{
			$_SESSION['Oauth_wx_uid']=$openId;
			$result=array("code"=>0,"msg"=>"请输入商户ID和密钥完成绑定和登录","url"=>"./login.php?connect=true");
		}
	}else{
		$result=array("code"=>1);
	}
	exit(json_encode($result));
}

if(!empty($conf['localurl_wxpay']) && !strpos($conf['localurl_wxpay'],$_SERVER['HTTP_HOST'])){
	$code_url = $conf['localurl_wxpay'].'user/wxlogin.php?sid='.session_id();
}else{
	$code_url = $siteurl.'user/wxlogin.php?sid='.session_id();
}
if(isset($_GET['bind'])){
	$code_url .= '&bind=1';
}

if($islogin2==1 && isset($_GET['unbind'])){
	$DB->exec("update `pre_user` set `wxid` =NULL where `uid`='$uid'");
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功解绑微信账号！');window.location.href='./editinfo.php';</script>");
}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){

$redirect_url = isset($_GET['url'])?$_GET['url']:null;
if($islogin2==1 && !isset($_GET['bind']) && !isset($_GET['code'])){
	exit("<script language='javascript'>window.location.href='./{$redirect_url}';</script>");
}

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

	$userrow=$DB->getRow("SELECT * FROM pre_user WHERE wxid='{$openId}' limit 1");
	if($userrow){
		$uid=$userrow['uid'];
		$key=$userrow['key'];
		$DB->exec("insert into `pre_log` (`uid`,`type`,`date`,`ip`,`city`) values ('".$uid."','微信快捷登录','".$date."','".$clientip."','".$city."')");
		$session=md5($uid.$key.$password_hash);
		$expiretime=time()+604800;
		$token=authcode("{$uid}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
		setcookie("user_token", $token, time() + 604800);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>window.location.href='./{$redirect_url}';</script>");
	}elseif($islogin2==1){
		$sds=$DB->exec("update `pre_user` set `wxid` ='$openId' where `uid`='$uid'");
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('已成功绑定微信账号！');window.location.href='./editinfo.php';</script>");
	}else{
		$_SESSION['Oauth_wx_uid']=$openId;
		exit("<script language='javascript'>alert('请输入商户ID和密钥完成绑定和登录');window.location.href='./login.php?connect=true';</script>");
	}
}elseif($islogin2==1 && !isset($_GET['bind'])){
	exit("<script language='javascript'>window.location.href='./';</script>");
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>微信登录 | <?php echo $conf['sitename']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="//cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="//cdn.staticfile.org/animate.css/3.5.2/animate.min.css" type="text/css" />
<link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="//cdn.staticfile.org/simple-line-icons/2.4.1/css/simple-line-icons.min.css" type="text/css" />
<link rel="stylesheet" href="./assets/css/font.css" type="text/css" />
<link rel="stylesheet" href="./assets/css/app.css" type="text/css" />
<style>input:-webkit-autofill{-webkit-box-shadow:0 0 0px 1000px white inset;-webkit-text-fill-color:#333;}img.logo{width:14px;height:14px;margin:0 5px 0 3px;}</style>
</head>
<body>
<div class="app app-header-fixed  ">
<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;">
<span class="navbar-brand block m-t" id="sitename"><?php echo $conf['sitename']?></span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>微信扫码登录</strong>
</div>
<form name="form" class="form-validation">
<div class="text-danger wrapper text-center" ng-show="authError">
</div>
	<div class="form-group" style="text-align: center;">
		<div class="list-group-item list-group-item-success" style="font-weight: bold;" id="login">
			<span id="loginmsg">请使用微信扫描二维码登录</span>
		</div>
		<div id="qrcode" class="qr-image list-group-item">
		</div>
		<div class="list-group-item" id="mobile" style="display:none;"><button type="button" id="mlogin" onclick="mloginurl()" class="btn btn-warning btn-block">跳转QQ快捷登录</button><br/><button type="button" onclick="loadScript()" class="btn btn-success btn-block">我已完成登录</button></div>
		<div class="list-group-item">
		<div class="btn-group">
		<a href="login.php" class="btn btn-primary btn-rounded"><i class="fa fa-user"></i>&nbsp;返回登录</a>
		<a href="reg.php" class="btn btn-info btn-rounded"><i class="fa fa-user-plus"></i>&nbsp;注册账号</a>
		</div>
		</div>
		</div>
	</div>
</form>
</div>
<div class="text-center">
<p>
<small class="text-muted"><a href="/"><?php echo $conf['sitename']?></a><br>&copy; 2016~2020</small>
</p>
</div>
</div>
</div>
<script src="//cdn.staticfile.org/jquery/3.3.1/jquery.min.js"></script>
<script src="//cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../assets/layer/layer.js"></script>
<script src="../assets/js/jquery-qrcode.min.js"></script>
<script>
$(document).ready(function(){
	$('#qrcode').qrcode({
        text: "<?php echo $code_url?>",
        width: 230,
        height: 230,
        foreground: "#000000",
        background: "#ffffff",
        typeNumber: -1
    });
	setTimeout('checkopenid()', 2000);
});
function checkopenid(){
	$.ajax({
		type: "GET",
		dataType: "json",
		url: "wxlogin.php?act=login",
		success: function (data, textStatus) {
			if (data.code == 0) {
				layer.msg(data.msg, {icon: 16,time: 10000,shade:[0.3, "#000"]});
				setTimeout(function(){ window.location.href=data.url }, 1000);
			}else if (data.code == 1) {
				setTimeout('checkopenid()', 2000);
			}else{
				layer.alert(data.msg);
			}
		},
		error: function (data) {
			layer.msg('服务器错误', {icon: 2});
			return false;
		}
	});
}
</script>
</body>
</html>