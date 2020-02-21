<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='完善账户资料';
include './head.php';
?>
<?php
?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">
<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">完善账户资料</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			<h3 class="panel-title">完善账户资料</h3>
		</div>
		<div class="panel-body">
		<div class="alert alert-success">
			你已经注册成功了，请先填写你的收款账号与联系方式信息！
		</div>
			<form class="form-horizontal devform">
				<div class="form-group">
					<label class="col-sm-2 control-label">结算方式</label>
					<div class="col-sm-9">
						<select class="form-control" name="stype" default="<?php echo $userrow['settle_id']?>">
						<?php if($conf['settle_alipay']){?><option value="1" input="支付宝账号">支付宝结算</option>
						<?php }if($conf['settle_wxpay']){?><option value="2" input="<?php echo $conf['transfer_wxpay']?'微信OpenId':'微信号';?>">微信结算</option>
						<?php }if($conf['settle_qqpay']){?><option value="3" input="ＱＱ号码">QQ钱包结算</option>
						<?php }if($conf['settle_bank']){?><option value="4" input="银行卡号">银行卡结算</option>
						<?php }?></select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" id="typename">收款账号</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="account" value="<?php echo $userrow['account']?>">
					</div>
				</div>
				<?php if($conf['transfer_wxpay']){?>
				<div class="form-group" style="display:none;" id="getopenid_form">
					<div class="col-sm-offset-2 col-sm-4">
						<a class="btn btn-sm btn-default" id="getopenid">点此获取微信OpenId</a>
					</div>
				</div>
				<?php }?>
				<div class="form-group">
					<label class="col-sm-2 control-label">真实姓名</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="username" value="<?php echo $userrow['username']?>">
					</div>
				</div>
				<?php if($conf['verifytype']==1){?>
				<div class="form-group">
					<label class="col-sm-2 control-label">邮箱</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="email" value="<?php echo $userrow['email']?>">
					</div>
				</div>
				<?php }?>
				<div class="form-group">
					<label class="col-sm-2 control-label">ＱＱ</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="qq" value="<?php echo $userrow['qq']?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">网站域名</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="url" value="<?php echo $userrow['url']?>">
					</div>
				</div>
				
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><input type="button" id="save" value="保存" class="btn btn-primary form-control"/><br/>
				 </div>
				</div>
			</form>
		</div>
		</div>
	</div>
  </div>
<?php include 'foot.php';?>
<script src="../assets/layer/layer.js"></script>
<script src="../assets/js/jquery-qrcode.min.js"></script>
<script>
$(document).ready(function(){
	$("select[name='stype']").change(function(){
		var input = $("select[name='stype'] option:selected").attr("input");
		$("#typename").html(input);
		if($(this).val() == 2){
			$("#getopenid_form").show();
		}else{
			$("#getopenid_form").hide();
		}
	});
	$("select[name='stype']").change();
	$("#save").click(function(){
		var stype=$("select[name='stype']").val();
		var account=$("input[name='account']").val();
		var username=$("input[name='username']").val();
		var email=$("input[name='email']").val();
		var qq=$("input[name='qq']").val();
		var url=$("input[name='url']").val();
		if(account=='' || username=='' || email=='' || qq=='' || url==''){layer.alert('请确保各项不能为空！');return false;}
		if(email.length>0){
			var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
			if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
		}
		if (url.indexOf(" ")>=0){
			url = url.replace(/ /g,"");
		}
		if (url.toLowerCase().indexOf("http://")==0){
			url = url.slice(7);
		}
		if (url.toLowerCase().indexOf("https://")==0){
			url = url.slice(8);
		}
		if (url.slice(url.length-1)=="/"){
			url = url.slice(0,url.length-1);
		}
		$("input[name='url']").val(url);
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax2.php?act=completeinfo",
			data : {stype:stype,account:account,username:username,email:email,qq:qq,url:url},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 1){
					layer.alert('保存成功！', {icon:1}, function(){ window.location.href="./" });
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	$('#getopenid').click(function () {
		if ($(this).attr("data-lock") === "true") return;
		$(this).attr("data-lock", "true");
		$.ajax({
			type : "GET",
			url : "ajax.php?act=qrcode",
			dataType : 'json',
			success : function(data) {
				$('#getopenid').attr("data-lock", "false");
				if(data.code == 0){
					$.openidform = layer.open({
					  type: 1,
					  title: '请使用微信扫描以下二维码',
					  skin: 'layui-layer-demo',
					  anim: 2,
					  shadeClose: true,
					  content: '<div id="qrcode" class="list-group-item text-center"></div>',
					  success: function(){
						$('#qrcode').qrcode({
							text: data.url,
							width: 230,
							height: 230,
							foreground: "#000000",
							background: "#ffffff",
							typeNumber: -1
						});
						$.ostart = true;
						setTimeout('checkopenid()', 2000);
					  },
					  end: function(){
						$.ostart = false;
					  }
					});
				}else{
					layer.alert(data.msg, {icon: 0});
				}
			},
			error:function(data){
				layer.msg('服务器错误', {icon: 2});
				return false;
			}
		});
	});
});
function checkopenid(){
	$.ajax({
		type: "GET",
		dataType: "json",
		url: "ajax.php?act=getopenid",
		success: function (data, textStatus) {
			if (data.code == 0) {
				layer.msg('Openid获取成功');
				layer.close($.openidform);
				$("input[name='account']").val(data.openid);
			}else if($.ostart==true){
				setTimeout('checkopenid()', 2000);
			}else{
				return false;
			}
		},
		error: function (data) {
			layer.msg('服务器错误', {icon: 2});
			return false;
		}
	});
}
</script>