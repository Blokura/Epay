<?php
/**
 * 商户信息
**/
include("../includes/common.php");
$title='商户信息';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php

$usergroup = [];
$select = '';
$rs = $DB->getAll("SELECT * FROM pre_group");
foreach($rs as $row){
	$usergroup[$row['gid']] = $row['name'];
	$select.='<option value="'.$row['gid'].'">'.$row['name'].'</option>';
}
unset($rs);

$my=isset($_GET['my'])?$_GET['my']:null;

if($my=='add')
{
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">添加商户</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./uset.php?my=add_submit" method="POST">
<div class="form-group">
<label>结算方式:</label><br><select class="form-control" name="settle_id">
'.($conf['settle_alipay']?'<option value="1">支付宝</option>':null).'
'.($conf['settle_wxpay']?'<option value="2">微信</option>':null).'
'.($conf['settle_qqpay']?'<option value="3">QQ钱包</option>':null).'
'.($conf['settle_bank']?'<option value="4">银行卡</option>':null).'
</select>
</div>
<div class="form-group">
<label>结算账号:</label><br>
<input type="text" class="form-control" name="account" value="" required>
</div>
<div class="form-group">
<label>结算账号姓名:</label><br>
<input type="text" class="form-control" name="username" value="" required>
</div>
<div class="form-group">
<label>手机号(登录账号):</label><br>
<input type="text" class="form-control" name="phone" value="" placeholder="可留空">
</div>
<div class="form-group">
<label>邮箱(登录账号):</label><br>
<input type="text" class="form-control" name="email" value="" placeholder="可留空">
</div>
<div class="form-group">
<label>登录密码:</label><br>
<input type="text" class="form-control" name="pwd" value="" placeholder="留空则只能使用密钥登录">
</div>
<div class="form-group">
<label>ＱＱ:</label><br>
<input type="text" class="form-control" name="qq" value="" placeholder="可留空">
</div>
<div class="form-group">
<label>网站域名:</label><br>
<input type="text" class="form-control" name="url" value="" placeholder="可留空">
</div>
<div class="form-group">
<label>用户组:</label><br>
<select class="form-control" name="gid">'.$select.'</select>
</div>
<div class="form-group">
<label>真实姓名:</label><br>
<input type="text" class="form-control" name="certname" value="" placeholder="可留空">
</div>
<div class="form-group">
<label>身份证号:</label><br>
<input type="text" class="form-control" name="certno" value="" placeholder="可留空" maxlength="18">
</div>
<div class="form-group">
<label>是否实名认证:</label><br><select class="form-control" name="cert"><option value="0">0_未实名</option><option value="1">1_已实名</option></select>
</div>
<div class="form-group">
<label>手续费扣除模式:</label><br><select class="form-control" name="mode"><option value="0">余额扣费</option><option value="1">订单加费</option></select>
</div>
<div class="form-group">
<label>支付权限:</label><br><select class="form-control" name="pay"><option value="1">1_开启</option><option value="0">0_关闭</option></select>
</div>
<div class="form-group">
<label>结算权限:</label><br><select class="form-control" name="settle"><option value="1">1_开启</option><option value="0">0_关闭</option></select>
</div>
<div class="form-group">
<label>商户状态:</label><br><select class="form-control" name="status"><option value="1">1_正常</option><option value="0">0_封禁</option></select>
</div>
<input type="submit" class="btn btn-primary btn-block"
value="确定添加"></form>';
echo '<br/><a href="./ulist.php">>>返回商户列表</a>';
echo '</div></div>';
}
elseif($my=='edit')
{
$uid=intval($_GET['uid']);
$row=$DB->getRow("select * from pre_user where uid='$uid' limit 1");
if(!$row)showmsg('该商户不存在',4);
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">修改商户信息</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./uset.php?my=edit_submit&uid='.$uid.'" method="POST">
<div class="form-group">
<label>结算方式:</label><br><select class="form-control" name="settle_id" default="'.$row['settle_id'].'">
'.($conf['settle_alipay']?'<option value="1">支付宝</option>':null).'
'.($conf['settle_wxpay']?'<option value="2">微信</option>':null).'
'.($conf['settle_qqpay']?'<option value="3">QQ钱包</option>':null).'
'.($conf['settle_bank']?'<option value="4">银行卡</option>':null).'
</select>
</div>
<div class="form-group">
<label>结算账号:</label><br>
<input type="text" class="form-control" name="account" value="'.$row['account'].'" required>
</div>
<div class="form-group">
<label>结算账号姓名:</label><br>
<input type="text" class="form-control" name="username" value="'.$row['username'].'" required>
</div>
<div class="form-group">
<label>商户余额:</label><br>
<input type="text" class="form-control" name="money" value="'.$row['money'].'" required>
</div>
<div class="form-group">
<label>手机号(登录账号):</label><br>
<input type="text" class="form-control" name="phone" value="'.$row['phone'].'" placeholder="可留空">
</div>
<div class="form-group">
<label>邮箱(登录账号):</label><br>
<input type="text" class="form-control" name="email" value="'.$row['email'].'" placeholder="可留空">
</div>
<div class="form-group">
<label>ＱＱ:</label><br>
<input type="text" class="form-control" name="qq" value="'.$row['qq'].'" placeholder="可留空">
</div>
<div class="form-group">
<label>网站域名:</label><br>
<input type="text" class="form-control" name="url" value="'.$row['url'].'" placeholder="可留空">
</div>
<div class="form-group">
<label>用户组:</label><br>
<select class="form-control" name="gid" default="'.$row['gid'].'">'.$select.'</select>
</div>
<div class="form-group">
<label>真实姓名:</label><br>
<input type="text" class="form-control" name="certname" value="'.$row['certname'].'" placeholder="可留空">
</div>
<div class="form-group">
<label>身份证号:</label><br>
<input type="text" class="form-control" name="certno" value="'.$row['certno'].'" placeholder="可留空" maxlength="18">
</div>
<div class="form-group">
<label>是否实名认证:</label><br><select class="form-control" name="cert" default="'.$row['cert'].'"><option value="0">0_未实名</option><option value="1">1_已实名</option></select>
</div>
<div class="form-group">
<label>手续费扣除模式:</label><br><select class="form-control" name="mode" default="'.$row['mode'].'"><option value="0">余额扣费</option><option value="1">订单加费</option></select>
</div>
<div class="form-group">
<label>支付权限:</label><br><select class="form-control" name="pay" default="'.$row['pay'].'"><option value="1">1_开启</option><option value="0">0_关闭</option></select>
</div>
<div class="form-group">
<label>结算权限:</label><br><select class="form-control" name="settle" default="'.$row['settle'].'"><option value="1">1_开启</option><option value="0">0_关闭</option></select>
</div>
<div class="form-group">
<label>商户状态:</label><br><select class="form-control" name="status" default="'.$row['status'].'"><option value="1">1_正常</option><option value="0">0_封禁</option></select>
</div>
<div class="form-group">
<label>重置登录密码:</label><br>
<input type="text" class="form-control" name="pwd" value="" placeholder="不重置密码请留空">
</div>
<input type="submit" class="btn btn-primary btn-block" value="确定修改"></form>
';
echo '<br/><a href="./ulist.php">>>返回商户列表</a>';
echo '</div></div>
<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default")||0);
}
</script>';
}
elseif($my=='add_submit')
{
$gid=$_POST['gid'];
$settle_id=$_POST['settle_id'];
$account=$_POST['account'];
$username=$_POST['username'];
$money='0.00';
$url=$_POST['url'];
$email=$_POST['email'];
$qq=$_POST['qq'];
$phone=$_POST['phone'];
$certno=$_POST['certno'];
$certname=$_POST['certname'];
$cert=$_POST['cert'];
$mode=$_POST['mode'];
$pay=$_POST['pay'];
$settle=$_POST['settle'];
$status=$_POST['status'];
if($account==NULL or $username==NULL){
showmsg('保存错误,请确保加*项都不为空!',3);
} else {
$key = random(32);
$sds=$DB->exec("INSERT INTO `pre_user` (`gid`, `key`, `account`, `username`, `money`, `url`, `addtime`, `settle_id`, `phone`, `email`, `qq`, `certno`, `certname`, `cert`, `mode`, `pay`, `settle`, `status`) VALUES ('{$gid}', '{$key}', '{$account}', '{$username}', '{$money}', '{$url}', '{$date}', '{$settle_id}', '{$phone}', '{$email}', '{$qq}', '{$certno}', '{$certname}', '{$cert}', '{$mode}', '{$pay}', '{$settle}', '{$status}')");
$uid=$DB->lastInsertId();
if($sds){
	if(!empty($_POST['pwd'])){
		$pwd = getMd5Pwd(trim($_POST['pwd']), $uid);
		$DB->exec("update `pre_user` set `pwd` ='{$pwd}' where `uid`='$uid'");
	}
	showmsg('添加商户成功！商户ID：'.$uid.'<br/>密钥：'.$key.'<br/><br/><a href="./ulist.php">>>返回商户列表</a>',1);
}else
	showmsg('添加商户失败！<br/>错误信息：'.$DB->error(),4);
}
}
elseif($my=='edit_submit')
{
$uid=$_GET['uid'];
$rows=$DB->getRow("select * from pre_user where uid='$uid' limit 1");
if(!$rows)
	showmsg('当前商户不存在！',3);
$gid=$_POST['gid'];
$settle_id=$_POST['settle_id'];
$account=$_POST['account'];
$username=$_POST['username'];
$money=$_POST['money'];
$url=$_POST['url'];
$email=$_POST['email'];
$qq=$_POST['qq'];
$phone=$_POST['phone'];
$certno=$_POST['certno'];
$certname=$_POST['certname'];
$cert=$_POST['cert'];
$mode=$_POST['mode'];
$pay=$_POST['pay'];
$settle=$_POST['settle'];
$status=$_POST['status'];
if($account==NULL or $username==NULL){
showmsg('保存错误,请确保加*项都不为空!',3);
} else {
$sql="update `pre_user` set `gid` ='$gid',`account` ='{$account}',`username` ='{$username}',`settle_id` ='$settle_id',`money` ='{$money}',`url` ='{$url}',`email` ='$email',`qq` ='$qq',`phone` ='$phone',`certno` ='$certno',`certname` ='$certname',`cert` ='$cert',`mode` ='$mode',`pay` ='$pay',`settle` ='$settle',`status` ='$status' where `uid`='$uid'";
if(!empty($_POST['pwd'])){
	$pwd = getMd5Pwd(trim($_POST['pwd']), $uid);
	$sqs=$DB->exec("update `pre_user` set `pwd` ='{$pwd}' where `uid`='$uid'");
}
if($DB->exec($sql)!==false||$sqs)
	showmsg('修改商户信息成功！<br/><br/><a href="./ulist.php">>>返回商户列表</a>',1);
else
	showmsg('修改商户信息失败！'.$DB->error(),4);
}
}
elseif($my=='delete')
{
$uid=$_GET['uid'];
$sql="DELETE FROM pre_user WHERE uid='$uid'";
if($DB->exec($sql))
	exit("<script language='javascript'>alert('删除商户成功！');history.go(-1);</script>");
else
	exit("<script language='javascript'>alert(''删除商户失败！".$DB->error()."');history.go(-1);</script>");
}
?>
    </div>
  </div>
