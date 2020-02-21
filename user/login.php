<?php
/**
 * 登录
**/
$is_defend=true;
include("../includes/common.php");

if(isset($_GET['logout'])){
	setcookie("user_token", "", time() - 604800);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登录！');window.location.href='./login.php';</script>");
}elseif($islogin2==1){
	exit("<script language='javascript'>alert('您已登录！');window.location.href='./';</script>");
}
$csrf_token = md5(mt_rand(0,999).time());
$_SESSION['csrf_token'] = $csrf_token;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>登录 | <?php echo $conf['sitename']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="//cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="//cdn.staticfile.org/animate.css/3.5.2/animate.min.css" type="text/css" />
<link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="//cdn.staticfile.org/simple-line-icons/2.4.1/css/simple-line-icons.min.css" type="text/css" />
<link rel="stylesheet" href="./assets/css/font.css" type="text/css" />
<link rel="stylesheet" href="./assets/css/app.css" type="text/css" />
<link rel="stylesheet" href="./assets/css/captcha.css" type="text/css" />
<style>input:-webkit-autofill{-webkit-box-shadow:0 0 0px 1000px white inset;-webkit-text-fill-color:#333;}</style>
</head>
<body>
<div class="app app-header-fixed  ">
<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;">
<span class="navbar-brand block m-t"><?php echo $conf['sitename']?></span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>请输入您的商户信息</strong>
</div>
<form name="form" class="form-validation" method="post" action="login.php">
<input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
<div class="text-danger wrapper text-center" ng-show="authError">
</div>
<ul class="nav nav-tabs">
    <li style="width: 50%;" align="center" class="<?php echo $_GET['m']!='key'?'active':null;?>">
  <a href="./login.php">密码登录(New)</a>
</li>
    <li style="width: 50%;" align="center" class="<?php echo $_GET['m']=='key'?'active':null;?>">
  <a href="./login.php?m=key">密钥登录</a>
</li>
</ul>
<div class="tab-content">
<div class="tab-pane active">
<div class="list-group list-group-sm swaplogin">
<?php if($_GET['m']=='key'){?>
<input type="hidden" name="type" value="0"/>
<div class="list-group-item">
<input type="text" name="user" placeholder="商户ID" value="" class="form-control no-border" onkeydown="if(event.keyCode==13){$('#submit').click()}">
</div>
<div class="list-group-item">
<input type="password" name="pass" placeholder="商户密钥" value="" class="form-control no-border" onkeydown="if(event.keyCode==13){$('#submit').click()}">
</div>
<?php }else{?>
<input type="hidden" name="type" value="1"/>
<div class="list-group-item">
<input type="text" name="user" placeholder="邮箱/手机号" value="" class="form-control no-border" onkeydown="if(event.keyCode==13){$('#submit').click()}">
</div>
<div class="list-group-item">
<input type="password" name="pass" placeholder="密码" value="" class="form-control no-border" onkeydown="if(event.keyCode==13){$('#submit').click()}">
</div>
<?php }?>
	<?php if($conf['captcha_open_login']==1){?>
	<div class="list-group-item" id="captcha" style="margin: auto;"><div id="captcha_text">
		正在加载验证码
	</div>
	<div id="captcha_wait">
		<div class="loading">
			<div class="loading-dot"></div>
			<div class="loading-dot"></div>
			<div class="loading-dot"></div>
			<div class="loading-dot"></div>
		</div>
	</div></div>
	<div id="captchaform"></div>
	<?php }?>
</div>
<button type="button" class="btn btn-lg btn-primary btn-block" id="submit">立即登录</button>
</div>
</div>
<a href="reg.php" ui-sref="access.signup" class="btn btn-lg btn-default btn-block <?php echo $conf['reg_open']==0?'hide':null;?>">自助申请商户</a>
<div class="line line-dashed"></div>
<?php if(!isset($_GET['connect'])){?>
<div class="wrapper text-center">
<?php if($conf['login_alipay']>0){?>
<button type="button" class="btn btn-rounded btn-lg btn-icon btn-default" title="支付宝快捷登录" onclick="window.location.href='oauth.php'"><img src="../assets/icon/alipay.ico" style="border-radius:50px;"></button>
<?php }?>
<?php if($conf['login_qq']>0){?>
<button type="button" class="btn btn-rounded btn-lg btn-icon btn-default" title="QQ快捷登录" onclick="window.location.href='connect.php'"><i class="fa fa-qq fa-lg" style="color: #0BB2FF"></i></button>
<?php }?>
<?php if($conf['login_wx']>0){?>
<button type="button" class="btn btn-rounded btn-lg btn-icon btn-default" title="微信快捷登录" onclick="window.location.href='wxlogin.php'"><i class="fa fa-wechat fa-lg" style="color: green"></i></button>
</div>
<?php }?>
<?php }?>
<div class="text-center m-t m-b"><a ui-sref="access.forgotpwd" href="findpwd.php">找回密码</a></div>
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
<script src="//static.geetest.com/static/tools/gt.js"></script>
<script>
var captcha_open = 0;
var handlerEmbed = function (captchaObj) {
	captchaObj.appendTo('#captcha');
	captchaObj.onReady(function () {
		$("#captcha_wait").hide();
	}).onSuccess(function () {
		var result = captchaObj.getValidate();
		if (!result) {
			return alert('请完成验证');
		}
		$("#captchaform").html('<input type="hidden" name="geetest_challenge" value="'+result.geetest_challenge+'" /><input type="hidden" name="geetest_validate" value="'+result.geetest_validate+'" /><input type="hidden" name="geetest_seccode" value="'+result.geetest_seccode+'" />');
	});
};
$(document).ready(function(){
	if($("#captcha").length>0) captcha_open=1;
	$("#submit").click(function(){
		var type=$("input[name='type']").val();
		var user=$("input[name='user']").val();
		var pass=$("input[name='pass']").val();
		if(user=='' || pass==''){layer.alert(type==1?'账号和密码不能为空！':'ID和密钥不能为空！');return false;}
		submitLogin(type,user,pass);
	});
	if(captcha_open==1){
	$.ajax({
		url: "./ajax.php?act=captcha&t=" + (new Date()).getTime(),
		type: "get",
		dataType: "json",
		success: function (data) {
			$('#captcha_text').hide();
			$('#captcha_wait').show();
			initGeetest({
				gt: data.gt,
				challenge: data.challenge,
				new_captcha: data.new_captcha,
				product: "popup",
				width: "100%",
				offline: !data.success
			}, handlerEmbed);
		}
	});
	}
});
function submitLogin(type,user,pass){
	var csrf_token=$("input[name='csrf_token']").val();
	var data = {type:type, user:user, pass:pass, csrf_token:csrf_token};
	if(captcha_open == 1){
		var geetest_challenge = $("input[name='geetest_challenge']").val();
		var geetest_validate = $("input[name='geetest_validate']").val();
		var geetest_seccode = $("input[name='geetest_seccode']").val();
		if(geetest_challenge == ""){
			layer.alert('请先完成滑动验证！'); return false;
		}
		var adddata = {geetest_challenge:geetest_challenge, geetest_validate:geetest_validate, geetest_seccode:geetest_seccode};
	}
	var ii = layer.load();
	$.ajax({
		type: "POST",
		dataType: "json",
		data: Object.assign(data, adddata),
		url: "ajax.php?act=login",
		success: function (data, textStatus) {
			layer.close(ii);
			if (data.code == 0) {
				layer.msg(data.msg, {icon: 16,time: 10000,shade:[0.3, "#000"]});
				setTimeout(function(){ window.location.href=data.url }, 1000);
			}else{
				layer.alert(data.msg, {icon: 2});
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