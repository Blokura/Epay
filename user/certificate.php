<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='实名认证';
include './head.php';
?>
<?php
function showstar($num){
	$data = '';
	for($i=0;$i<$num;$i++){
		$data .= '*';
	}
	return $data;
}
if(isset($_GET['certify_id'])){
	$certify_id=htmlspecialchars(strip_tags($_GET['certify_id']));
	if(!isset($_SESSION[$uid.'_certify_id']) || $_SESSION[$uid.'_certify_id'] !== $certify_id){
		exit("<script language='javascript'>window.location.href='./certificate.php';</script>");
	}
}

if(strlen($userrow['phone'])==11){
	$userrow['phone']=substr($userrow['phone'],0,3).'****'.substr($userrow['phone'],7,10);
}

$csrf_token = md5(mt_rand(0,999).time());
$_SESSION['csrf_token'] = $csrf_token;
?>
<style>
.verified .row{padding:25px}
.verified .mt-step-col{padding:5px 5px 5px 30px;}
.verified .mt-step-col .mt-step-col-cont{background:#94aac5;color:rgba(255,255,255,.6);width:100%;border-radius:3px}
.verified .font-grey-cascade{padding-top:0;font-size:16px!important}
.verified .complete-active .mt-step-col-cont{background:#635ebe}
.verified .icon{color:#fff;position:absolute;top:10px;-webkit-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%);left:20px;width:40px;height:40px;font-size:24px;line-height:40px;color:#fff;text-align:center;background:rgba(255,255,255,.1);border-radius:50%}
@media screen and (max-width:1200px) {
	.verified .row {
		padding: 15px;
	}
}
</style>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">
<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">个人资料</h1>
</div>
<div class="wrapper-md control">
<?php if(!$conf['cert_channel'])showmsg('未开启实名认证功能');?>
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
<div class="tab-container ng-isolate-scope">
<ul class="nav nav-tabs">
	<li style="width: 25%;" align="center">
		<a href="userinfo.php?mod=api">API信息</a>
	</li>
	<li style="width: 25%;" align="center">
		<a href="editinfo.php">修改资料</a>
	</li>
	<li style="width: 25%;" align="center">
		<a href="userinfo.php?mod=account">修改密码</a>
	</li>
	<?php if($conf['cert_channel']){?>
	<li style="width: 25%;" align="center" class="active">
		<a href="certificate.php">实名认证</a>
	</li>
	<?php }?>
</ul>
	<div class="tab-content">
		<div class="tab-pane ng-scope active">
			<div class="row step-line nav nav-pills nav-justified steps verified">
				<div id="tag1" class="col-sm-12 col-md-4 mt-step-col first fill complete-active">
					<div class="mt-step-col-cont row bg-primary">
						<div class="col-xs-3 bg-primary-l">
							<i class="icon glyphicon glyphicon-edit"></i>
						</div>
						<div class="col-xs-9 bg-primary-r">
							<div class="mt-step-title uppercase font-grey-cascade ">填写认证信息
							</div>
						</div>
					</div>
				</div>
				<div id="tag2" class="col-sm-12 col-md-4 mt-step-col <?php if($userrow['cert']==1||$certify_id)echo 'complete-active';?>">
					<div class="mt-step-col-cont row">
						<div class="col-xs-3 bg-primary-l">
							<i class="icon fa fa-qrcode"></i>
						</div>
						<div class="col-xs-9 bg-primary-r">
							<div class="mt-step-title uppercase font-grey-cascade ">
								支付宝扫码快捷认证</div>
						</div>
					</div>
				</div>
				<div id="tag3" class="col-sm-12 col-md-4 mt-step-col last <?php if($userrow['cert']==1)echo 'complete-active';?>">
					<div class="mt-step-col-cont row ">
						<div class="col-xs-3 bg-primary-l">
							<i class="icon fa fa-check-circle-o"></i>
						</div>
						<div class="col-xs-9 bg-primary-r">
							<div class="mt-step-title uppercase font-grey-cascade ">
								认证完成</div>
						</div>
					</div>
				</div>
			</div>
			<div class="line line-dashed b-b line-lg pull-in"></div>
<?php if($userrow['cert']==1){?>
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<img src="https://imgcache.qq.com/open_proj/proj_qcloud_v2/mc_2014/user/auth/css/mod/img/sfz.jpg" class="pull-right">
				</div>
				<div class="col-xs-12 col-sm-6">
					<h4>恭喜您已通过<?php echo $conf['sitename']?>实名认证！</h4>
					<p>认证途径：支付宝快捷认证</p>
					<p>真实姓名：<?php echo showstar((strlen($userrow['certname'])-3)/3).substr($userrow['certname'],-3)?></p>
					<p>身份证号：<?php echo substr($userrow['certno'],0,3).showstar(11).substr($userrow['certno'],-4)?></p>
					<p>认证时间：<?php echo $userrow['certtime']?></p>
				</div>
			</div>
<?php }else{?>
<?php if($conf['cert_money']>0){?>
			<div class="alert alert-info alert-dismissible" role="alert" style="line-height: 26px;">
<p>认证需要<b><?php echo $conf['cert_money']; ?></b>元，请确保你的账号内有<?php echo $conf['cert_money']; ?>元余额[<a href="recharge.php">点此充值</a>]，认证成功会自动扣除，认证失败不扣费</p>
			</div>
<?php }?>
<?php if($certify_id){?>
			<div id="step2">
			<form class="form-horizontal devform">
				<input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
				<input type="hidden" name="certify_id" value="<?php echo $certify_id?>">
				<input type="hidden" name="qrcode_url" value="<?php echo $siteurl.'user/alipaycert.php?id='.$certify_id?>">
				<center><div id="qrcode"></div>
				<p class="text-muted" style="line-height: 26px;">请使用支付宝APP扫描二维码</p>
				<?php if(checkmobile()){?><p><a href="javascript:openAlipay()" id="jumplink" class="btn btn-success">点此跳转到支付宝</a></p><p class="text-muted">到支付宝确认之后请返回此页面才能认证成功</p><?php }?>
				<p><a href="./certificate.php" class="btn btn-default btn-sm">返回重新填写</a></p>
				</center>
			</form>
			</div>
<?php }else{?>
			<div id="step1">
			<form class="form-horizontal devform">
				<input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
				<div class="form-group">
					<label class="col-sm-2 control-label">认证方式</label>
					<div class="col-sm-9">
					<div class="certification_type">
						<img src="/assets/icon/alipay.ico" width="25">&nbsp;&nbsp;支付宝快捷认证
					</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">真实姓名</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="certname" value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">身份证号</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="certno" value="">
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><div class="text-muted"><small>姓名需与所认证的支付宝账号姓名一致</small></div>
				 </div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><input type="button" id="certSubmit" value="提交认证" class="btn btn-primary form-control"/><br/>
				 </div>
				</div>
			</form>
			<div class="alert alert-warning alert-dismissible" role="alert" style="line-height: 26px;font-size: 13px;margin-top: 50px;">
<p>1、为了更好的享受<?php echo $conf['sitename']?>提供的服务，本人知晓并同意授权支付宝的实人认证方式用于验证本人信息的真实性</p>
<p>2、本站承诺任何在本网站提交的用户信息，仅限用于本站为用户提供服务，本站承诺为用户的隐私及其他个人信息采取严格保密措施，并在必要时销毁数据。</p>
			</div>
			</div>
<?php }?>
<?php }?>
		</div>
	</div>
</div>
</div>
    </div>
  </div>
<?php include 'foot.php';?>
<script src="../assets/layer/layer.js"></script>
<script src="../assets/js/jquery-qrcode.min.js"></script>
<script>
<?php if($certify_id){?>
var alipay_url;
$(document).ready(function(){
	alipay_url = $("input[name='qrcode_url']").val();
	$('#qrcode').qrcode({
		text: alipay_url,
		width: 230,
		height: 230,
		foreground: "#000000",
		background: "#ffffff",
		typeNumber: -1
	});
	openAlipay();
	setTimeout(certQuery, 5000);
});
<?php }else{?>
$(document).ready(function(){
	$("#certSubmit").click(function(){
		var certname=$("input[name='certname']").val();
		var certno=$("input[name='certno']").val();
		var csrf_token=$("input[name='csrf_token']").val();
		if(certname=='' || certno==''){
			layer.alert('请确保各项不能为空');return false;
		}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax2.php?act=certificate",
			data : {certname:certname,certno:certno,csrf_token:csrf_token},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 1){
					window.location.href='./certificate.php?certify_id='+data.certify_id;
				}else if(data.code == -2){
					var confirmobj = layer.confirm(data.msg, {
					  icon: 0, btn: ['关联认证','取消']
					}, function(){
						certBind(data.uid);
					}, function(){
						layer.close(confirmobj);
					});
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
});
<?php }?>
function openAlipay(){
	var scheme = 'alipays://platformapi/startapp?appId=20000067&url=';
	scheme += encodeURIComponent(alipay_url);
	window.location.href = scheme;
}
function certBind(touid){
	var certname=$("input[name='certname']").val();
	var certno=$("input[name='certno']").val();
	var csrf_token=$("input[name='csrf_token']").val();
	layer.prompt({title: '请输入商户ID'+uid+'的商户密钥', value: '', formType: 0}, function(text, index){
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : 'POST',
			url : 'ajax2.php?act=cert_bind',
			data : {touid:touid,certname:certname,certno:certno,csrf_token:csrf_token},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 1){
					layer.alert(data.msg, {icon: 1}, function(){window.location.reload()});
				}else{
					layer.alert(data.msg, {icon: 2});
				}
			},
			error:function(data){
				layer.msg('服务器错误');
				return false;
			}
		});
	});
}
function certQuery(){
	var csrf_token=$("input[name='csrf_token']").val();
	var certify_id=$("input[name='certify_id']").val();
	$.ajax({
		type : 'POST',
		url : 'ajax2.php?act=cert_query',
		data : {certify_id:certify_id, csrf_token:csrf_token},
		dataType : 'json',
		async: true,
		success : function(data) {
			if(data.code == 1){
				if(data.passed == true){
					layer.msg('实名认证成功！', {icon: 1,time: 10000,shade:[0.3, "#000"]});
					setTimeout(function(){ window.location.href='./certificate.php' }, 800);
				}else{
					setTimeout(certQuery, 3000)
				}
			}else{
				layer.alert(data.msg, {icon: 2});
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
</script>