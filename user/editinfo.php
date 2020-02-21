<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='个人资料';
include './head.php';
?>
<?php
$mod=isset($_GET['mod'])?$_GET['mod']:'api';

if(strlen($userrow['phone'])==11){
	$userrow['phone']=substr($userrow['phone'],0,3).'****'.substr($userrow['phone'],7,10);
}

?>
<input type="hidden" id="situation" value="">
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">
		<div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
						</button>
						<h4 class="modal-title">验证密保信息</h4>
					</div>
					<div class="modal-body">
<?php if($conf['verifytype']==1){?>
<div class="list-group-item">密保手机：<?php echo $userrow['phone']?></div>
<div class="list-group-item">
<div class="input-group">
<input type="text" name="code" placeholder="输入短信验证码" class="form-control" required>
<a class="input-group-addon" id="sendcode">获取验证码</a>
</div>
</div>
<?php }else{?>
<div class="list-group-item">密保邮箱：<?php echo $userrow['email']?></div>
<div class="list-group-item">
<div class="input-group">
<input type="text" name="code" placeholder="输入验证码" class="form-control" required>
<a class="input-group-addon" id="sendcode">获取验证码</a>
</div>
</div>
<?php }?>
<button type="button" id="verifycode" class="btn btn-primary btn-block">确定</button>
<div id="embed-captcha"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal inmodal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
						</button>
						<h4 class="modal-title">修改密保信息</h4>
					</div>
					<div class="modal-body">
<?php if($conf['verifytype']==1){?>
<div class="list-group-item">
<input type="text" name="phone_n" placeholder="输入新的手机号码" class="form-control" required>
</div>
<div class="list-group-item">
<div class="input-group">
<input type="text" name="code_n" placeholder="输入短信验证码" class="form-control" required>
<a class="input-group-addon" id="sendcode2">获取验证码</a>
</div>
</div>
<?php }else{?>
<div class="list-group-item">
<input type="email" name="email_n" placeholder="输入新的邮箱" class="form-control" required>
</div>
<div class="list-group-item">
<div class="input-group">
<input type="text" name="code_n" placeholder="输入验证码" class="form-control" required>
<a class="input-group-addon" id="sendcode2">获取验证码</a>
</div>
</div>
<?php }?>
<button type="button" id="editBind" class="btn btn-primary btn-block">确定</button>
<div id="embed-captcha"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
					</div>
				</div>
			</div>
		</div>
<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">个人资料</h1>
</div>
<div class="wrapper-md control">
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
	<li style="width: 25%;" align="center" class="active">
		<a href="editinfo.php">修改资料</a>
	</li>
	<li style="width: 25%;" align="center">
		<a href="userinfo.php?mod=account">修改密码</a>
	</li>
	<?php if($conf['cert_channel']){?>
	<li style="width: 25%;" align="center">
		<a href="certificate.php">实名认证</a>
	</li>
	<?php }?>
</ul>
	<div class="tab-content">
		<div class="tab-pane ng-scope active">
			<form class="form-horizontal devform">
				<div class="form-group"><div class="col-sm-offset-2 col-sm-4"><h4>收款账号设置：</h4></div></div>
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
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><input type="button" id="editSettle" value="确定修改" class="btn btn-primary form-control"/><br/>
				 </div>
				</div>

				<div class="line line-dashed b-b line-lg pull-in"></div>
				<div class="form-group"><div class="col-sm-offset-2 col-sm-4"><h4>联系方式设置：</h4></div></div>
				<?php if($conf['verifytype']==1){?>
				<div class="form-group">
					<label class="col-sm-2 control-label">手机号码</label>
					<div class="col-sm-9">
						<div class="input-group">
						<input class="form-control" type="text" name="phone" value="<?php echo $userrow['phone']?>" disabled>
						<a class="input-group-addon" id="checkbind">修改绑定</a>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">邮箱</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="email" value="<?php echo $userrow['email']?>">
					</div>
				</div>
				<?php }else{?>
				<div class="form-group">
					<label class="col-sm-2 control-label">邮箱</label>
					<div class="col-sm-9">
						<div class="input-group">
						<input class="form-control" type="text" name="email" value="<?php echo $userrow['email']?>" disabled>
						<a class="input-group-addon" id="checkbind">修改绑定</a>
						</div>
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
					<label class="col-sm-2 control-label">开启密钥登录</label>
					<div class="col-sm-9">
						<select class="form-control" name="keylogin" default="<?php echo $userrow['keylogin']?>"><option value="0">关闭</option><option value="1">开启</option></select>
					</div>
				</div>
				
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><input type="button" id="editInfo" value="确定修改" class="btn btn-primary form-control"/><br/>
				 </div>
				</div>

				<div class="line line-dashed b-b line-lg pull-in"></div>
				<div class="form-group"><div class="col-sm-offset-2 col-sm-4"><h4>支付手续费扣除模式选择：</h4></div></div>
				<div class="form-group has-success">
					<div class="col-sm-offset-2 col-sm-9">
					<div class="alert alert-success">
					1、余额扣费 (经典模式，默认)：例如费率1%，客户购买100元商品，客户需支付100元，卖家到账99元，手续费1元由卖家支付<br>            2、订单加费 (奸商模式)：例如费率1%，客户购买100元商品，客户需支付101元，卖家到账100元，手续费1元由买家支付
					  </div>
						<select class="form-control" name="mode" default="<?php echo $userrow['mode']?>">
								<option value="0">余额扣费</option>
								<option value="1">订单加费</option>
							  </select>
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><input type="button" id="editMode" value="确定修改" class="btn btn-primary form-control"/><br/>
				 </div>
				</div>

				 <div class="line line-dashed b-b line-lg pull-in"></div>
				<div class="form-group"><div class="col-sm-offset-2 col-sm-4"><h4>第三方账号绑定：</h4></div></div>
				<?php if($conf['login_qq']>0){?>
				<div class="form-group">
					<div class="col-xs-6"><span class="pull-right"><i class="fa fa-qq fa-2x fa-fw" style="color: #0BB2FF"></i>&nbsp;&nbsp;&nbsp;ＱＱ快捷登录&nbsp;&nbsp;&nbsp;</span></div>
					<div class="col-xs-6">
					<?php if($userrow['qq_uid']){?>
						<a class="btn btn-sm btn-success" disabled title="<?php echo $userrow['qq_uid']?>">已绑定</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-danger" href="./connect.php?unbind=1" onclick="return confirm('解绑后将无法通过QQ一键登录，是否确定解绑？');">解绑</a>
					<?php }else{?>
						<a class="btn btn-sm btn-success" href="./connect.php?bind=1">立即绑定</a>
					<?php }?>
					</div>
				</div>
				<?php }?>
				<?php if($conf['login_wx']>0){?>
				<div class="form-group">
					<div class="col-xs-6"><span class="pull-right"><i class="fa fa-wechat fa-2x fa-fw" style="color: green"></i>&nbsp;&nbsp;&nbsp;微信快捷登录&nbsp;&nbsp;&nbsp;</span></div>
					<div class="col-xs-6">
					<?php if($userrow['wxid']){?>
						<a class="btn btn-sm btn-success" disabled title="<?php echo $userrow['wxid']?>">已绑定</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-danger" href="./wxlogin.php?unbind=1" onclick="return confirm('解绑后将无法通过微信一键登录，是否确定解绑？');">解绑</a>
					<?php }else{?>
						<a class="btn btn-sm btn-success" href="./wxlogin.php?bind=1">立即绑定</a>
					<?php }?>
					</div>
				</div>
				<?php }?>
				<?php if($conf['login_alipay']>0){?>
				<div class="form-group">
					<div class="col-xs-6"><span class="pull-right"><i class="fa fa-2x"><img src="/assets/icon/alipay.ico" style="border-radius:50px;"></i>&nbsp;&nbsp;支付宝快捷登录</span></div>
					<div class="col-xs-6">
					<?php if($userrow['alipay_uid']){?>
						<a class="btn btn-sm btn-success" disabled title="<?php echo $userrow['alipay_uid']?>">已绑定</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-danger" href="./oauth.php?unbind=1" onclick="return confirm('解绑后将无法通过支付宝一键登录，是否确定解绑？');">解绑</a>
					<?php }else{?>
						<a class="btn btn-sm btn-success" href="./oauth.php?bind=1">立即绑定</a>
					<?php }?>
					</div>
				</div>
				<?php }?>
			</form>
		</div>
	</div>
</div>
</div>
    </div>
  </div>
<?php include 'foot.php';?>
<script src="../assets/layer/layer.js"></script>
<script src="../assets/js/jquery-qrcode.min.js"></script>
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
	var target;
	captchaObj.onReady(function () {
		$("#wait").hide();
	}).onSuccess(function () {
		var result = captchaObj.getValidate();
		if (!result) {
			return alert('请完成验证');
		}
		var situation=$("#situation").val();
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax2.php?act=sendcode",
			data : {situation:situation,target:target,geetest_challenge:result.geetest_challenge,geetest_validate:result.geetest_validate,geetest_seccode:result.geetest_seccode},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					new invokeSettime("#sendcode");
					new invokeSettime("#sendcode2");
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
		captchaObj.verify();
	});
	$('#sendcode2').click(function () {
		if ($(this).attr("data-lock") === "true") return;
		if($("input[name='phone_n']").length>0){
			target=$("input[name='phone_n']").val();
			if(target==''){layer.alert('手机号码不能为空！');return false;}
			if(target.length!=11){layer.alert('手机号码不正确！');return false;}
		}else{
			target=$("input[name='email_n']").val();
			if(target==''){layer.alert('邮箱不能为空！');return false;}
			var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
			if(!reg.test(target)){layer.alert('邮箱格式不正确！');return false;}
		}
		captchaObj.verify();
	})
	// 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
};
$(document).ready(function(){
	var items = $("select[default]");
	for (i = 0; i < items.length; i++) {
		$(items[i]).val($(items[i]).attr("default")||1);
	}
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
	$("#editSettle").click(function(){
		var stype=$("select[name='stype']").val();
		var account=$("input[name='account']").val();
		var username=$("input[name='username']").val();
		if(account=='' || username==''){layer.alert('请确保各项不能为空！');return false;}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax2.php?act=edit_settle",
			data : {stype:stype,account:account,username:username},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 1){
					layer.alert('修改成功！', {icon:1});
				}else if(data.code == 2){
					$("#situation").val("settle");
					$('#myModal').modal('show');
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	$("#editInfo").click(function(){
		var email=$("input[name='email']").val();
		var qq=$("input[name='qq']").val();
		var url=$("input[name='url']").val();
		var keylogin=$("select[name='keylogin']").val();
		if(email=='' || qq=='' || url==''){layer.alert('请确保各项不能为空！');return false;}
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
			url : "ajax2.php?act=edit_info",
			data : {email:email,qq:qq,url:url,keylogin:keylogin},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 1){
					layer.alert('修改成功！', {icon:1});
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	$("#editMode").click(function(){
		var mode=$("select[name='mode']").val();
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax2.php?act=edit_mode",
			data : {mode:mode},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 1){
					layer.alert('修改成功！', {icon:1});
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	$("#checkbind").click(function(){
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "GET",
			url : "ajax2.php?act=checkbind",
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 1){
					$("#situation").val("bind");
					$('#myModal2').modal('show');
				}else if(data.code == 2){
					$("#situation").val("mibao");
					$('#myModal').modal('show');
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	$("#editBind").click(function(){
		var phone=$("input[name='phone_n']").val();
		var email=$("input[name='email_n']").val();
		var code=$("input[name='code_n']").val();
		if(code==''){layer.alert('请输入验证码！');return false;}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax2.php?act=edit_bind",
			data : {phone:phone,email:email,code:code},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 1){
					layer.alert('修改绑定成功！', {icon:1}, function(){window.location.reload()});
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	$("#verifycode").click(function(){
		var code=$("input[name='code']").val();
		var situation=$("#situation").val();
		if(code==''){layer.alert('请输入验证码！');return false;}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax2.php?act=verifycode",
			data : {code:code},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 1){
					layer.msg('验证成功！', {icon:1});
					$('#myModal').modal('hide');
					if(situation=='settle'){
						$("#editSettle").click();
					}else if(situation=='mibao'){
						$("#situation").val("bind");
						$('#myModal2').modal('show');
					}else if(situation=='bind'){
						$('#myModal2').modal('hide');
						window.location.reload();
					}
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
	$.ajax({
		// 获取id，challenge，success（是否启用failback）
		url: "ajax.php?act=captcha&t=" + (new Date()).getTime(), // 加随机数防止缓存
		type: "get",
		asysn: true,
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