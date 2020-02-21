<?php
$is_defend=true;
include("../includes/common.php");
if(isset($_GET['regok'])){
	exit("<script language='javascript'>alert('恭喜你，商户注册成功！');window.location.href='./login.php';</script>");
}
if($islogin2==1){
	exit("<script language='javascript'>alert('您已登录！');window.location.href='./';</script>");
}

if($conf['reg_open']==0)sysmsg('未开放商户申请');

$csrf_token = md5(mt_rand(0,999).time());
$_SESSION['csrf_token'] = $csrf_token;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>申请商户 | <?php echo $conf['sitename']?></title>
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

		<div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
						</button>
						<h4 class="modal-title">注册须知</h4>
					</div>
					<div class="modal-body">
<?php echo $conf['zhuce']?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
					</div>
				</div>
			</div>
		</div>

<div class="app app-header-fixed  ">
<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;">
<span class="navbar-brand block m-t" id="sitename"><?php echo $conf['sitename']?></span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>自助申请商户</strong>
</div>
<form name="form" class="form-validation"><input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>"><input type="hidden" name="verifytype" value="<?php echo $conf['verifytype']?>">
<?php if($conf['reg_pay']){?><div class="wrapper">商户申请价格为：<b><?php echo $conf['reg_pay_price']?></b>元</div><?php }?>
<div class="list-group list-group-sm swaplogin">
<?php if($conf['verifytype']==1){?>
<div class="list-group-item">
<input type="text" name="phone" placeholder="手机号码（同时作为登录账号）" class="form-control no-border" required>
</div>
<div class="list-group-item">
<div class="input-group">
<input type="text" name="code" placeholder="短信验证码" class="form-control no-border" required>
<a class="input-group-addon" id="sendcode">获取验证码</a>
</div>
</div>
<?php }else{?>
<div class="list-group-item">
<input type="email" name="email" placeholder="邮箱（同时作为登录账号）" class="form-control no-border" required>
</div>
<div class="list-group-item">
<div class="input-group">
<input type="text" name="code" placeholder="邮箱验证码" class="form-control no-border" required>
<a class="input-group-addon" id="sendcode">获取验证码</a>
</div>
</div>
<?php }?>
<div class="list-group-item">
<input type="password" name="pwd" placeholder="请输入你的密码" class="form-control no-border" required>
</div>
<div class="list-group-item">
<input type="password" name="pwd2" placeholder="请再次输入密码" class="form-control no-border" required>
</div>
<div class="checkbox m-b-md m-t-none">
<label class="i-checks">
  <input type="checkbox" ng-model="agree" checked required><i></i> 同意<a href="../agreement.html" target="_blank">我们的条款</a>
</label>
</div>
</div>
<button type="button" id="submit" class="btn btn-lg btn-primary btn-block" ng-click="login()" ng-disabled='form.$invalid'>立即注册</button>
<a href="login.php" ui-sref="access.signup" class="btn btn-lg btn-default btn-block">返回登录</a>
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
<script src="//lib.baomitu.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="../assets/layer/layer.js"></script>
<script src="//static.geetest.com/static/tools/gt.js"></script>
<script>
function invokeSettime(obj){
    var countdown=60;
    settime(obj);
    function settime(obj) {
        if (countdown == 0) {
            $(obj).attr("data-lock", "false");
            $(obj).text("获取验证码");
            countdown = 60;
            return;
        } else {
			$(obj).attr("data-lock", "true");
            $(obj).attr("disabled",true);
            $(obj).text("(" + countdown + ") s 重新发送");
            countdown--;
        }
        setTimeout(function() {
                    settime(obj) }
                ,1000)
    }
}
var handlerEmbed = function (captchaObj) {
	var sendto;
	captchaObj.onReady(function () {
		$("#wait").hide();
	}).onSuccess(function () {
		var result = captchaObj.getValidate();
		if (!result) {
			return alert('请完成验证');
		}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax.php?act=sendcode",
			data : {sendto:sendto,geetest_challenge:result.geetest_challenge,geetest_validate:result.geetest_validate,geetest_seccode:result.geetest_seccode},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					new invokeSettime("#sendsms");
					layer.msg('发送成功，请注意查收！');
				}else{
					layer.alert(data.msg);
					captchaObj.reset();
				}
			} 
		});
	});
	$('#sendcode').click(function () {
		if ($(this).attr("data-lock") === "true") return;
		if($("input[name='verifytype']").val()=='1'){
			sendto=$("input[name='phone']").val();
			if(sendto==''){layer.alert('手机号码不能为空！');return false;}
			if(sendto.length!=11){layer.alert('手机号码不正确！');return false;}
		}else{
			sendto=$("input[name='email']").val();
			if(sendto==''){layer.alert('邮箱不能为空！');return false;}
			var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
			if(!reg.test(sendto)){layer.alert('邮箱格式不正确！');return false;}
		}
		captchaObj.verify();
	});
};
$(document).ready(function(){
	$("#submit").click(function(){
		if ($(this).attr("data-lock") === "true") return;
		var email=$("input[name='email']").val();
		var phone=$("input[name='phone']").val();
		var code=$("input[name='code']").val();
		var pwd=$("input[name='pwd']").val();
		var pwd2=$("input[name='pwd2']").val();
		if(email=='' || phone=='' || code=='' || pwd=='' || pwd2==''){layer.alert('请确保各项不能为空！');return false;}
		if(pwd!=pwd2){layer.alert('两次输入密码不一致！');return false;}
		if($("input[name='verifytype']").val()=='1'){
			if(phone.length!=11){layer.alert('手机号码不正确！');return false;}
		}else{
			var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
			if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
		}
		var ii = layer.load();
		$(this).attr("data-lock", "true");
		var csrf_token=$("input[name='csrf_token']").val();
		$.ajax({
			type : "POST",
			url : "ajax.php?act=reg",
			data : {email:email,phone:phone,code:code,pwd:pwd,csrf_token:csrf_token},
			dataType : 'json',
			success : function(data) {
				$("#submit").attr("data-lock", "false");
				layer.close(ii);
				if(data.code == 1){
					layer.alert('恭喜你，商户申请成功！', {icon: 1}, function(){
						window.location.href="./login.php";
					});
				}else if(data.code == 2){
					var paymsg = '';
					$.each(data.paytype, function(key, value) {
						paymsg+='<button class="btn btn-default btn-block" onclick="window.location.href=\'../submit2.php?typeid='+key+'&trade_no='+data.trade_no+'\'" style="margin-top:10px;"><img width="20" src="../assets/icon/'+value.name+'.ico" class="logo">'+value.showname+'</button>';
					});
					layer.alert('<center><h2>￥ '+data.need+'</h2><hr>'+paymsg+'<hr>提示：支付完成后即可直接登录</center>',{
						btn:[],
						title:'支付确认页面',
						closeBtn: false
					});
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	$.ajax({
		// 获取id，challenge，success（是否启用failback）
		url: "ajax.php?act=captcha&t=" + (new Date()).getTime(), // 加随机数防止缓存
		type: "get",
		dataType: "json",
		success: function (data) {
			console.log(data);
			// 使用initGeetest接口
			// 参数1：配置参数
			// 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
			initGeetest({
				width: '100%',
				gt: data.gt,
				challenge: data.challenge,
				new_captcha: data.new_captcha,
				product: "bind", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
				offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
				// 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
			}, handlerEmbed);
		}
	});
	<?php if(!empty($conf['zhuce'])){?>
	$('#myModal').modal('show');
	<?php }?>
});
</script>
</body>
</html>