<?php
/**
 * 系统设置
**/
include("../includes/common.php");
$title='系统设置';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
$mod=isset($_GET['mod'])?$_GET['mod']:null;
$mods=['site'=>'网站信息','pay'=>'支付与结算','transfer'=>'企业付款','oauth'=>'快捷登录','certificate'=>'实名认证','template'=>'首页模板','gonggao'=>'公告与排版','mail'=>'邮箱与短信','upimg'=>'LOGO设置','iptype'=>'IP地址','cron'=>'计划任务','account'=>'修改密码'];
?>
<ul class="nav nav-pills">
	<?php foreach($mods as $key=>$name){echo '<li class="'.($key==$mod?'active':null).'"><a href="set.php?mod='.$key.'">'.$name.'</a></li>';} ?>
</ul>
<?php
if($mod=='site'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">网站信息配置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-2 control-label">网站名称</label>
	  <div class="col-sm-10"><input type="text" name="sitename" value="<?php echo $conf['sitename']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">首页标题</label>
	  <div class="col-sm-10"><input type="text" name="title" value="<?php echo $conf['title']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">关键字</label>
	  <div class="col-sm-10"><input type="text" name="keywords" value="<?php echo $conf['keywords']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">网站描述</label>
	  <div class="col-sm-10"><input type="text" name="description" value="<?php echo $conf['description']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">公司/组织名称</label>
	  <div class="col-sm-10"><input type="text" name="orgname" value="<?php echo $conf['orgname']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">本站网址</label>
	  <div class="col-sm-10"><input type="text" name="localurl" value="<?php echo $conf['localurl']; ?>" class="form-control"/><font color="green">必须以http://或https://开头，以/结尾，填错会导致订单无法回调</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">联系邮箱</label>
	  <div class="col-sm-10"><input type="text" name="email" value="<?php echo $conf['email']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">客服ＱＱ</label>
	  <div class="col-sm-10"><input type="text" name="kfqq" value="<?php echo $conf['kfqq']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">加群链接</label>
	  <div class="col-sm-10"><input type="text" name="qqqun" value="<?php echo $conf['qqqun']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">APP下载链接</label>
	  <div class="col-sm-10"><input type="text" name="appurl" value="<?php echo $conf['appurl']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">用户验证方式</label>
	  <div class="col-sm-10"><select class="form-control" name="verifytype" default="<?php echo $conf['verifytype']?>"><option value="0">邮箱验证</option><option value="1">手机验证</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">开放注册</label>
	  <div class="col-sm-10"><select class="form-control" name="reg_open" default="<?php echo $conf['reg_open']?>"><option value="1">开启</option><option value="0">关闭</option></select></div>
	</div><br/>
	<div id="setform1" style="<?php echo $conf['reg_open']==0?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-2 control-label">注册付费</label>
	  <div class="col-sm-10"><select class="form-control" name="reg_pay" default="<?php echo $conf['reg_pay']?>"><option value="1">开启</option><option value="0">关闭</option></select></div>
	</div><br/>
	<div id="setform2" style="<?php echo $conf['reg_pay']==0?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-2 control-label">注册付费金额</label>
	  <div class="col-sm-10"><input type="text" name="reg_pay_price" value="<?php echo $conf['reg_pay_price']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">注册付费收款商户ID</label>
	  <div class="col-sm-10"><input type="text" name="reg_pay_uid" value="<?php echo $conf['reg_pay_uid']; ?>" class="form-control" placeholder="填写在本站注册的商户UID"/></div>
	</div><br/>
	</div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">测试支付</label>
	  <div class="col-sm-10"><select class="form-control" name="test_open" default="<?php echo $conf['test_open']?>"><option value="1">开启</option><option value="0">关闭</option></select></div>
	</div><br/>
	<div id="setform3" style="<?php echo $conf['test_open']==0?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-2 control-label">测试支付收款商户ID</label>
	  <div class="col-sm-10"><input type="text" name="test_pay_uid" value="<?php echo $conf['test_pay_uid']; ?>" class="form-control" placeholder="填写在本站注册的商户UID"/></div>
	</div><br/>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">极限验证码ID</label>
	  <div class="col-sm-10"><input type="text" name="captcha_id" value="<?php echo $conf['captcha_id']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">极限验证码密钥</label>
	  <div class="col-sm-10"><input type="text" name="captcha_key" value="<?php echo $conf['captcha_key']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">登录开启验证码</label>
	  <div class="col-sm-10"><select class="form-control" name="captcha_open_login" default="<?php echo $conf['captcha_open_login']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">用户中心风格</label>
	  <div class="col-sm-10"><select class="form-control" name="user_style" default="<?php echo $conf['user_style']?>"><option value="0">黑色（1）</option><option value="1">黑色（2）</option><option value="2">棕色（1）</option><option value="3">棕色（2）</option><option value="4">蓝色（1）</option><option value="5">蓝色（2）</option><option value="6">紫色（1）</option><option value="7">紫色（2）</option></select></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<script>
$("select[name='reg_open']").change(function(){
	if($(this).val() == 1){
		$("#setform1").show();
	}else{
		$("#setform1").hide();
	}
});
$("select[name='reg_pay']").change(function(){
	if($(this).val() == 1){
		$("#setform2").show();
	}else{
		$("#setform2").hide();
	}
});
$("select[name='test_open']").change(function(){
	if($(this).val() == 1){
		$("#setform3").show();
	}else{
		$("#setform3").hide();
	}
});
</script>
<?php
}elseif($mod=='paypwd_n' && $_POST['do']=='submit'){
	$oldpwd=$_POST['oldpwd'];
	$newpwd=$_POST['newpwd'];
	$newpwd2=$_POST['newpwd2'];
	if(!empty($newpwd) && !empty($newpwd2)){
		if($oldpwd!=$conf['admin_paypwd'])showmsg('旧密码不正确！',3);
		if($newpwd!=$newpwd2)showmsg('两次输入的密码不一致！',3);
		saveSetting('admin_paypwd',$newpwd);
	}else{
		showmsg('新密码不能为空',3);
	}
	$ad=$CACHE->clear();
	if($ad)showmsg('修改成功！',1);
	else showmsg('修改失败！<br/>'.$DB->error(),4);
}elseif($mod=='account_n' && $_POST['do']=='submit'){
	$user=$_POST['user'];
	$oldpwd=$_POST['oldpwd'];
	$newpwd=$_POST['newpwd'];
	$newpwd2=$_POST['newpwd2'];
	if($user==null)showmsg('用户名不能为空！',3);
	saveSetting('admin_user',$user);
	if(!empty($newpwd) && !empty($newpwd2)){
		if($oldpwd!=$conf['admin_pwd'])showmsg('旧密码不正确！',3);
		if($newpwd!=$newpwd2)showmsg('两次输入的密码不一致！',3);
		saveSetting('admin_pwd',$newpwd);
	}
	$ad=$CACHE->clear();
	if($ad)showmsg('修改成功！请重新登录',1);
	else showmsg('修改失败！<br/>'.$DB->error(),4);
}elseif($mod=='account'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">管理员账号配置</h3></div>
<div class="panel-body">
  <form action="./set.php?mod=account_n" method="post" class="form-horizontal" role="form"><input type="hidden" name="do" value="submit"/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">用户名</label>
	  <div class="col-sm-10"><input type="text" name="user" value="<?php echo $conf['admin_user']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">旧密码</label>
	  <div class="col-sm-10"><input type="password" name="oldpwd" value="" class="form-control" placeholder="请输入当前的管理员密码"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">新密码</label>
	  <div class="col-sm-10"><input type="password" name="newpwd" value="" class="form-control" placeholder="不修改请留空"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">重输密码</label>
	  <div class="col-sm-10"><input type="password" name="newpwd2" value="" class="form-control" placeholder="不修改请留空"/></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">支付密码修改</h3></div>
<div class="panel-body">
  <form action="./set.php?mod=paypwd_n" method="post" class="form-horizontal" role="form"><input type="hidden" name="do" value="submit"/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">旧密码</label>
	  <div class="col-sm-10"><input type="password" name="oldpwd" value="" class="form-control" placeholder="请输入当前的支付密码"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">新密码</label>
	  <div class="col-sm-10"><input type="password" name="newpwd" value="" class="form-control" placeholder="不修改请留空"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">重输密码</label>
	  <div class="col-sm-10"><input type="password" name="newpwd2" value="" class="form-control" placeholder="不修改请留空"/></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
<div class="panel-footer">
          <span class="glyphicon glyphicon-info-sign"></span> 支付密码用于转账接口以及API退款时使用，默认为123456
        </div>
</div>
<?php
}elseif($mod=='template'){
	$mblist = \lib\Template::getList();
?>
<style>.mblist{margin-bottom: 20px;} .mblist img{height: 110px;}</style>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">首页模板设置</h3></div>
<div class="panel-body">
  <h4>当前使用模板：</h4>
  <div class="row text-center">
	  <div class="col-xs-6 col-sm-4">
		<img class="img-responsive img-thumbnail img-rounded" src="/template/<?php echo $conf['template']?>/preview.png" onerror="this.src='/assets/img/NoImg.png'">
	  </div>
	  <div class="col-xs-6 col-sm-4">
		<p>模板名称：<?php echo $conf['template']?></p>
	  </div>
  </div>
  <hr/>
  <h4>更换模板：</h4>
  <div class="row text-center">
  <?php foreach($mblist as $template){?>
	  <div class="col-xs-6 col-sm-4 mblist">
		<a href="javascript:changeTemplate('<?php echo $template?>')"><img class="img-responsive img-thumbnail img-rounded" src="/template/<?php echo $template?>/preview.png" onerror="this.src='/assets/img/NoImg.png'" title="点击更换到该模板"><br/><?php echo $template?></a>
	  </div>
  <?php }?>
  </div>
</div>
</div>
<?php
}elseif($mod=='iptype'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">用户IP地址获取设置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
    <div class="form-group">
	  <label class="col-sm-2 control-label">用户IP地址获取方式</label>
	  <div class="col-sm-10"><select class="form-control" name="ip_type" default="<?php echo $conf['ip_type']?>"><option value="0">0_X_FORWARDED_FOR</option><option value="1">1_X_REAL_IP</option><option value="2">2_REMOTE_ADDR</option></select></div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span>
此功能设置用于防止用户伪造IP请求。<br/>
X_FORWARDED_FOR：之前的获取真实IP方式，极易被伪造IP<br/>
X_REAL_IP：在网站使用CDN的情况下选择此项，在不使用CDN的情况下也会被伪造<br/>
REMOTE_ADDR：直接获取真实请求IP，无法被伪造，但可能获取到的是CDN节点IP<br/>
<b>你可以从中选择一个能显示你真实地址的IP，优先选下方的选项。</b>
</div>
</div>
<script>
$(document).ready(function(){
	$.ajax({
		type : "GET",
		url : "ajax.php?act=iptype",
		dataType : 'json',
		async: true,
		success : function(data) {
			$("select[name='ip_type']").empty();
			var defaultv = $("select[name='ip_type']").attr('default');
			$.each(data, function(k, item){
				$("select[name='ip_type']").append('<option value="'+k+'" '+(defaultv==k?'selected':'')+'>'+ item.name +' - '+ item.ip +' '+ item.city +'</option>');
			})
		}
	});
})
</script>
<?php
}elseif($mod=='pay'){
	$wxpay_channel = $DB->getAll("SELECT * FROM pre_channel WHERE plugin='wxpay'");
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">支付与结算配置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
  <h4 style="text-align: center;">支付配置</h4>
	<div class="form-group">
	  <label class="col-sm-3 control-label">最大支付金额</label>
	  <div class="col-sm-9"><input type="text" name="pay_maxmoney" value="<?php echo $conf['pay_maxmoney']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">最小支付金额</label>
	  <div class="col-sm-9"><input type="text" name="pay_minmoney" value="<?php echo $conf['pay_minmoney']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">商品屏蔽关键词</label>
	  <div class="col-sm-9"><input type="text" name="blockname" value="<?php echo $conf['blockname']; ?>" class="form-control"/><font color="green">多个关键词用|隔开。如果触发屏蔽会在<a href="./risk.php">风控记录</a>里面显示</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">商品屏蔽显示内容</label>
	  <div class="col-sm-9"><input type="text" name="blockalert" value="<?php echo $conf['blockalert']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">商品名称自定义</label>
	  <div class="col-sm-9"><input type="text" name="ordername" value="<?php echo $conf['ordername']; ?>" class="form-control" placeholder="默认使用原商品名称"/><font color="green">支持变量值：[name]原商品名称，[time]时间戳，[qq]当前商户的联系QQ</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">本站网址(支付宝专用)</label>
	  <div class="col-sm-9"><input type="text" name="localurl_alipay" value="<?php echo $conf['localurl_alipay']; ?>" class="form-control" placeholder="留空默认使用当前网址"/><font color="green">适用于网站有多个绑定域名，由于支付宝官方限制域名，使用未登记域名会有违约风险，填写指定网址后，使用支付宝支付都会跳转到该网址再跳转到支付宝。必须以http://或https://开头，以/结尾，留空则使用当前网址</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">本站网址(微信专用)</label>
	  <div class="col-sm-9"><input type="text" name="localurl_wxpay" value="<?php echo $conf['localurl_wxpay']; ?>" class="form-control" placeholder="留空默认使用当前网址"/><font color="green">适用于网站有多个绑定域名，由于微信公众号只能授权一个域名，填写指定网址后，使用微信公众号支付或获取openid都会跳转到该网址再跳转到微信。必须以http://或https://开头，以/结尾，留空则使用当前网址</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">开启余额充值</label>
	  <div class="col-sm-9"><select class="form-control" name="recharge" default="<?php echo $conf['recharge']?>"><option value="1">开启</option><option value="0">关闭</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">开启一码支付</label>
	  <div class="col-sm-9"><select class="form-control" name="onecode" default="<?php echo $conf['onecode']?>"><option value="1">开启</option><option value="0">关闭</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">微信短网址生成通道</label>
	  <div class="col-sm-9"><select class="form-control" name="wxurl" default="<?php echo $conf['wxurl']?>"><option value="0">关闭</option><?php foreach($wxpay_channel as $channel){echo '<option value="'.$channel['id'].'">'.$channel['name'].'</option>';} ?></select><font color="green">请先添加支付插件为wxpay的支付通道<br/>只需开通服务号即可使用(可以不开通微信支付)</font></div>
	</div><br/>
	<h4 style="text-align: center;">结算配置</h4>
	<div class="form-group">
	  <label class="col-sm-3 control-label">结算总开关</label>
	  <div class="col-sm-9"><select class="form-control" name="settle_open" default="<?php echo $conf['settle_open']?>"><option value="0">关闭结算功能</option><option value="1">只开启每日自动结算</option><option value="2">只开启手动申请结算</option><option value="3">开启自动+手动结算</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">手动申请结算周期</label>
	  <div class="col-sm-9"><select class="form-control" name="settle_type" default="<?php echo $conf['settle_type']?>"><option value="0">T+0（可提现全部余额）</option><option value="1">T+1（可提现1天前的余额）</option></select><font color="green">该选项只适用于手动申请结算</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">最低结算金额</label>
	  <div class="col-sm-9"><input type="text" name="settle_money" value="<?php echo $conf['settle_money']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">结算手续费</label>
	  <div class="col-sm-9"><div class="input-group"><input type="text" name="settle_rate" value="<?php echo $conf['settle_rate']; ?>" class="form-control"/><span class="input-group-addon">%</span></div></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">结算手续费最小</label>
	  <div class="col-sm-9"><input type="text" name="settle_fee_min" value="<?php echo $conf['settle_fee_min']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">结算手续费最大</label>
	  <div class="col-sm-9"><input type="text" name="settle_fee_max" value="<?php echo $conf['settle_fee_max']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">支付宝结算开关</label>
	  <div class="col-sm-9"><select class="form-control" name="settle_alipay" default="<?php echo $conf['settle_alipay']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">微信结算开关</label>
	  <div class="col-sm-9"><select class="form-control" name="settle_wxpay" default="<?php echo $conf['settle_wxpay']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">QQ钱包结算开关</label>
	  <div class="col-sm-9"><select class="form-control" name="settle_qqpay" default="<?php echo $conf['settle_qqpay']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">银行卡结算开关</label>
	  <div class="col-sm-9"><select class="form-control" name="settle_bank" default="<?php echo $conf['settle_bank']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<?php
}elseif($mod=='gonggao'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">其他公告与排版设置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-2 control-label">用户中心弹出公告</label>
	  <div class="col-sm-10"><textarea class="form-control" name="modal" rows="5" placeholder="不填写则不显示弹出公告"><?php echo $conf['modal']?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">首页底部排版</label>
	  <div class="col-sm-10"><textarea class="form-control" name="footer" rows="3" placeholder="可填写备案号等"><?php echo $conf['footer']?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/><br/>
	  <a href="./gonggao.php" class="btn btn-default btn-block">用户中心公告列表</a>
	 </div>
	</div>
  </form>
</div>
<?php
}elseif($mod=='transfer'){
	$alipay_channel = $DB->getAll("SELECT * FROM pre_channel WHERE plugin='alipay'");
	$wxpay_channel = $DB->getAll("SELECT * FROM pre_channel WHERE plugin='wxpay'");
	$qqpay_channel = $DB->getAll("SELECT * FROM pre_channel WHERE plugin='qqpay'");
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">企业付款配置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-3 control-label">付款方显示名称</label>
	  <div class="col-sm-9"><input type="text" name="transfer_name" value="<?php echo $conf['transfer_name']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">付款默认备注</label>
	  <div class="col-sm-9"><input type="text" name="transfer_desc" value="<?php echo $conf['transfer_desc']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">支付宝转账接口通道</label>
	  <div class="col-sm-9"><select class="form-control" name="transfer_alipay" default="<?php echo $conf['transfer_alipay']?>"><option value="0">关闭</option><?php foreach($alipay_channel as $channel){echo '<option value="'.$channel['id'].'">'.$channel['name'].'</option>';} ?></select><font color="green">请先添加支付插件为alipay的支付通道</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">微信企业付款通道</label>
	  <div class="col-sm-9"><select class="form-control" name="transfer_wxpay" default="<?php echo $conf['transfer_wxpay']?>"><option value="0">关闭</option><?php foreach($wxpay_channel as $channel){echo '<option value="'.$channel['id'].'">'.$channel['name'].'</option>';} ?></select><font color="green">请先添加支付插件为wxpay的支付通道<br/>请将<a href="https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=4_3" target="_blank" rel="noreferrer">API证书</a>放置于/plugins/wxpay/cert/文件夹</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">QQ钱包企业付款通道</label>
	  <div class="col-sm-9"><select class="form-control" name="transfer_qqpay" default="<?php echo $conf['transfer_qqpay']?>"><option value="0">关闭</option><?php foreach($qqpay_channel as $channel){echo '<option value="'.$channel['id'].'">'.$channel['name'].'</option>';} ?></select><font color="green">请先添加支付插件为qqpay的支付通道<br/>请将<a href="https://qpay.qq.com/buss/wiki/206/1213" target="_blank" rel="noreferrer">API证书</a>放置于/plugins/qqpay/cert/文件夹</font></div>
	</div><br/>
	<div id="setform1" style="<?php echo $conf['transfer_qqpay']==0?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">QQ钱包操作员账号</label>
	  <div class="col-sm-9"><input type="text" name="qq_op_userid" value="<?php echo $conf['qq_op_userid']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">QQ钱包操作员密码</label>
	  <div class="col-sm-9"><input type="text" name="qq_op_userpwd" value="<?php echo $conf['qq_op_userpwd']; ?>" class="form-control"/></div>
	</div><br/>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<script>
$("select[name='transfer_qqpay']").change(function(){
	if($(this).val() > 0){
		$("#setform1").show();
	}else{
		$("#setform1").hide();
	}
});
</script>
<?php
}elseif($mod=='certificate'){
	$alipay_channel = $DB->getAll("SELECT * FROM pre_channel WHERE plugin='alipay'");
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">实名认证接口配置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
    <div class="form-group">
	  <label class="col-sm-3 control-label">实名认证接口通道</label>
	  <div class="col-sm-9"><select class="form-control" name="cert_channel" default="<?php echo $conf['cert_channel']?>"><option value="0">关闭</option><?php foreach($alipay_channel as $channel){echo '<option value="'.$channel['id'].'">'.$channel['name'].'</option>';} ?></select><font color="green">请先添加支付插件为alipay的支付通道，需要申请支付宝身份验证接口</font></div>
	</div><br/>
	<div id="setform1" style="<?php echo $conf['cert_channel']==0?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">商户强制认证</label>
	  <div class="col-sm-9"><select class="form-control" name="cert_force" default="<?php echo $conf['cert_force']?>"><option value="0">关闭</option><option value="1">开启</option></select><font color="green">开启后商户必须实名认证，才能正常使用支付接口收款</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">实名认证费用</label>
	  <div class="col-sm-9"><input type="text" name="cert_money" value="<?php echo $conf['cert_money']; ?>" class="form-control" placeholder="留空或0为免认证费用"/><font color="green">由于支付宝身份验证接口是1元/次，所以你可以设置实名认证收费，认证成功从商户余额扣除，如果是付费注册商户建议改为免认证费</font></div>
	</div><br/>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<script>
$("select[name='cert_channel']").change(function(){
	if($(this).val() > 0){
		$("#setform1").show();
	}else{
		$("#setform1").hide();
	}
});
</script>
<?php
}elseif($mod=='oauth'){
	$alipay_channel = $DB->getAll("SELECT * FROM pre_channel WHERE plugin='alipay'");
	$wxpay_channel = $DB->getAll("SELECT * FROM pre_channel WHERE plugin='wxpay'");
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">快捷登录配置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-3 control-label">QQ快捷登录</label>
	  <div class="col-sm-9"><select class="form-control" name="login_qq" default="<?php echo $conf['login_qq']?>"><option value="0">关闭</option><option value="1">QQ互联官方快捷登录</option><option value="2">QQ扫码快捷登录(有异地风险)</option></select><a href="https://connect.qq.com" target="_blank" rel="noreferrer">申请地址</a>，回调地址填写：<?php echo $siteurl.'user/connect.php';?></div>
	</div><br/>
	<div id="setform1" style="<?php echo $conf['login_qq']!=1?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-3 control-label">QQ快捷登录Appid</label>
	  <div class="col-sm-9"><input type="text" name="login_qq_appid" value="<?php echo $conf['login_qq_appid']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">QQ快捷登录Appkey</label>
	  <div class="col-sm-9"><input type="text" name="login_qq_appkey" value="<?php echo $conf['login_qq_appkey']; ?>" class="form-control"/></div>
	</div><br/>
	</div>
	<div class="form-group">
	  <label class="col-sm-3 control-label">支付宝快捷登录</label>
	  <div class="col-sm-9"><select class="form-control" name="login_alipay" default="<?php echo $conf['login_alipay']?>"><option value="0">关闭</option><?php foreach($alipay_channel as $channel){echo '<option value="'.$channel['id'].'">'.$channel['name'].'</option>';} ?></select><font color="green">请先添加支付插件为alipay的支付通道</font><br/><a href="https://openhome.alipay.com/platform/appManage.htm" target="_blank" rel="noreferrer">申请地址</a>，应用内添加功能"获取会员信息"，授权回调地址填写：<?php echo $siteurl.'user/oauth.php';?></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">微信快捷登录</label>
	  <div class="col-sm-9"><select class="form-control" name="login_wx" default="<?php echo $conf['login_wx']?>"><option value="0">关闭</option><?php foreach($wxpay_channel as $channel){echo '<option value="'.$channel['id'].'">'.$channel['name'].'</option>';} ?></select><font color="green">请先添加支付插件为wxpay的支付通道</font><br/>需要有服务号，在公众号后台配置网页授权域名：<?php echo $_SERVER['HTTP_HOST'];?></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<script>
$("select[name='login_qq']").change(function(){
	if($(this).val() == 1){
		$("#setform1").show();
	}else{
		$("#setform1").hide();
	}
});
</script>
<?php
}elseif($mod=='mailtest'){
	$mail_name = $conf['mail_recv']?$conf['mail_recv']:$conf['mail_name'];
	if(!empty($mail_name)){
	$result=send_mail($mail_name,'邮件发送测试。','这是一封测试邮件！<br/><br/>来自：'.$siteurl);
	if($result==1)
		showmsg('邮件发送成功！',1);
	else
		showmsg('邮件发送失败！'.$result,3);
	}
	else
		showmsg('您还未设置邮箱！',3);
}elseif($mod=='mail'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">发信邮箱设置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-2 control-label">发信模式</label>
	  <div class="col-sm-10"><select class="form-control" name="mail_cloud" default="<?php echo $conf['mail_cloud']?>"><option value="0">SMTP发信</option><option value="1">搜狐Sendcloud</option><option value="2">阿里云邮件推送</option></select></div>
	</div><br/>
	<div id="frame_set1" style="<?php echo $conf['mail_cloud']>1?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-2 control-label">SMTP服务器</label>
	  <div class="col-sm-10"><input type="text" name="mail_smtp" value="<?php echo $conf['mail_smtp']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">SMTP端口</label>
	  <div class="col-sm-10"><input type="text" name="mail_port" value="<?php echo $conf['mail_port']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">邮箱账号</label>
	  <div class="col-sm-10"><input type="text" name="mail_name" value="<?php echo $conf['mail_name']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">邮箱密码</label>
	  <div class="col-sm-10"><input type="text" name="mail_pwd" value="<?php echo $conf['mail_pwd']; ?>" class="form-control"/></div>
	</div><br/>
	</div>
	<div id="frame_set2" style="<?php echo $conf['mail_cloud']==0?'display:none;':null; ?>">
	<div class="form-group">
	  <label class="col-sm-2 control-label">API_USER</label>
	  <div class="col-sm-10"><input type="text" name="mail_apiuser" value="<?php echo $conf['mail_apiuser']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">API_KEY</label>
	  <div class="col-sm-10"><input type="text" name="mail_apikey" value="<?php echo $conf['mail_apikey']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">发信邮箱</label>
	  <div class="col-sm-10"><input type="text" name="mail_name2" value="<?php echo $conf['mail_name2']; ?>" class="form-control"/></div>
	</div><br/>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">收信邮箱</label>
	  <div class="col-sm-10"><input type="text" name="mail_recv" value="<?php echo $conf['mail_recv']; ?>" class="form-control" placeholder="不填默认为发信邮箱"/></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/><?php if($conf['mail_name']){?>[<a href="set.php?mod=mailtest">给 <?php echo $conf['mail_recv']?$conf['mail_recv']:$conf['mail_name']?> 发一封测试邮件</a>]<?php }?>
	 </div><br/>
	</div>
  </form>
</div>
<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span>
使用普通模式发信时，建议使用QQ邮箱，SMTP服务器smtp.qq.com，端口465，密码不是QQ密码也不是邮箱独立密码，是QQ邮箱设置界面生成的<a href="https://service.mail.qq.com/cgi-bin/help?subtype=1&&no=1001256&&id=28"  target="_blank" rel="noreferrer">授权码</a>。<br/>阿里云邮件推送：<a href="https://www.aliyun.com/product/directmail" target="_blank" rel="noreferrer">点此进入</a>｜<a href="https://usercenter.console.aliyun.com/#/manage/ak" target="_blank" rel="noreferrer">获取AK/SK</a>
</div>
</div>
<script>
$("select[name='mail_cloud']").change(function(){
	if($(this).val() == 0){
		$("#frame_set1").show();
		$("#frame_set2").hide();
	}else{
		$("#frame_set1").hide();
		$("#frame_set2").show();
	}
});
</script>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">短信接口设置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-2 control-label">接口选择</label>
	  <div class="col-sm-10"><select class="form-control" name="sms_api" default="<?php echo $conf['sms_api']?>"><option value="0">978W短信接口</option><option value="1">腾讯云短信接口</option><option value="2">阿里云短信接口</option></select></div>
	</div><br/>
	<div class="form-group" id="showAppId" style="<?php echo $conf['sms_api']==0?'display:none;':null; ?>">
	  <label class="col-sm-2 control-label">AppId</label>
	  <div class="col-sm-10"><input type="text" name="sms_appid" value="<?php echo $conf['sms_appid']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">AppKey</label>
	  <div class="col-sm-10"><input type="text" name="sms_appkey" value="<?php echo $conf['sms_appkey']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group" id="showSign" style="<?php echo $conf['sms_api']==0?'display:none;':null; ?>">
	  <label class="col-sm-2 control-label">短信签名内容</label>
	  <div class="col-sm-10"><input type="text" name="sms_sign" value="<?php echo $conf['sms_sign']; ?>" class="form-control"/><font color="green">必须是已添加、并通过审核的短信签名。</font></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">商户注册模板ID</label>
	  <div class="col-sm-10"><input type="text" name="sms_tpl_reg" value="<?php echo $conf['sms_tpl_reg']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">找回密码模板ID</label>
	  <div class="col-sm-10"><input type="text" name="sms_tpl_find" value="<?php echo $conf['sms_tpl_find']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">修改结算账号模板ID</label>
	  <div class="col-sm-10"><input type="text" name="sms_tpl_edit" value="<?php echo $conf['sms_tpl_edit']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div><br/>
	</div>
  </form>
</div>
<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span>
978W短信接口：<a href="http://admin.978w.cn" target="_blank" rel="noreferrer">点此进入</a><br/>腾讯云短信接口：<a href="https://console.cloud.tencent.com/sms/smslist" target="_blank" rel="noreferrer">点此进入</a><br/>阿里云短信接口：<a href="https://dysms.console.aliyun.com/dysms.htm" target="_blank" rel="noreferrer">点此进入</a>
</div>
</div>
<script>
$("select[name='sms_api']").change(function(){
	if($(this).val() == 0){
		$("#showAppId").hide();
		$("#showSign").hide();
	}else{
		$("#showAppId").show();
		$("#showSign").show();
	}
});
</script>
<?php
}elseif($mod=='cron'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">计划任务设置</h3></div>
<div class="panel-body">
  <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-2 control-label">计划任务访问密钥</label>
	  <div class="col-sm-10"><input type="text" name="cronkey" value="<?php echo $conf['cronkey']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">计划任务列表</h3></div>
<div class="panel-body">
<p>以下网址每天0点定时访问一次即可，也可以设置1分钟一次的定时任务。</p>
<p>订单统计任务</p>
<li class="list-group-item"><?php echo $siteurl?>cron.php?do=order&key=<?php echo $conf['cronkey']; ?></li>
<br/>
<p>自动生成结算任务</p>
<li class="list-group-item"><?php echo $siteurl?>cron.php?do=settle&key=<?php echo $conf['cronkey']; ?></li>
</div>
</div>
<?php
}
elseif($mod=='upimg'){
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">更改首页LOGO</h3></div>
<div class="panel-body">';
if($_POST['s']==1){
if(copy($_FILES['file']['tmp_name'], ROOT.'assets/img/logo.png')){
	echo "成功上传文件!<br>（可能需要清空浏览器缓存才能看到效果，按Ctrl+F5即可一键刷新缓存）";
}else{
	echo "上传失败，可能没有文件写入权限";
}
}
echo '<form action="set.php?mod=upimg" method="POST" enctype="multipart/form-data"><label for="file"></label><input type="file" name="file" id="file" /><input type="hidden" name="s" value="1" /><br><input type="submit" class="btn btn-primary btn-block" value="确认上传" /></form><br>现在的图片：<br><img src="../assets/img/logo.png?r='.rand(10000,99999).'" style="max-width:100%">';
echo '</div></div>';
}
?>
    </div>
  </div>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default")||0);
}
function checkURL(obj)
{
	var url = $(obj).val();

	if (url.indexOf(" ")>=0){
		url = url.replace(/ /g,"");
	}
	if (url.toLowerCase().indexOf("http://")<0 && url.toLowerCase().indexOf("https://")<0){
		url = "http://"+url;
	}
	if (url.slice(url.length-1)!="/"){
		url = url+"/";
	}
	$(obj).val(url);
}
function saveSetting(obj){
	if($("input[name='localurl_alipay']").length>0 && $("input[name='localurl_alipay']").val()!=''){
		checkURL("input[name='localurl_alipay']");
	}
	if($("input[name='localurl_wxpay']").length>0 && $("input[name='localurl_wxpay']").val()!=''){
		checkURL("input[name='localurl_wxpay']");
	}
	if($("input[name='localurl']").length>0 && $("input[name='localurl']").val()!=''){
		checkURL("input[name='localurl']");
	}
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=set',
		data : $(obj).serialize(),
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert('设置保存成功！', {
					icon: 1,
					closeBtn: false
				}, function(){
				  window.location.reload()
				});
			}else{
				layer.alert(data.msg, {icon: 2})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
	return false;
}
function changeTemplate(template){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=set',
		data : {template:template},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert('更换模板成功！', {
					icon: 1,
					closeBtn: false
				}, function(){
				  window.location.reload()
				});
			}else{
				layer.alert(data.msg, {icon: 2})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
	return false;
}
</script>