<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='购买会员';
include './head.php';
?>
<style>
.table>tbody>tr>td{vertical-align: middle;}
</style>
<?php

if($conf['group_buy']==0)exit('未开启购买会员');

$paytype = [];
$paytypes = [];
$rs = $DB->getAll("SELECT * FROM pre_type");
foreach($rs as $row){
	$paytype[$row['id']] = $row['showname'];
	$paytypes[$row['id']] = $row['name'];
}
unset($rs);

function display_info($info){
	global $paytype,$paytypes;
	$result = '';
	$arr = json_decode($info, true);
	foreach($arr as $k=>$v){
		if($v['channel']==0)continue;
		$result .= '<label><img src="/assets/icon/'.$paytypes[$k].'.ico" width="18px" title="'.$v['channel'].'">&nbsp;'.$paytype[$k].'('.$v['rate'].'%)</label>&nbsp;&nbsp;';
	}
	return substr($result,0,-1);
}

$paytypem = \lib\Channel::getTypes($userrow['gid']);
$list = $DB->getAll("SELECT * FROM pre_group WHERE isbuy=1 ORDER BY SORT ASC");
$group=[];
foreach($list as $row){
	$group[$row['gid']] = $row['name'];
}
$csrf_token = md5(mt_rand(0,999).time());
$_SESSION['csrf_token'] = $csrf_token;
?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">购买会员</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="row" id="listFrame">
	<div class="col-xs-12">
	<?php if(isset($_GET['ok']) && $_GET['ok']==1){
	$order = $DB->getRow("SELECT * FROM pre_order WHERE trade_no=:trade_no limit 1", [':trade_no'=>$_GET['trade_no']]);
	if($order){
		$start = strpos($order['name'],'#')+1;
		$end = strrpos($order['name'],'#');
		$id=intval(substr($order['name'],$start,$end-$start));
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  会员等级 <b><?php echo $group[$id]?></b> 已开通成功！
	</div>
	<?php }}?>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			<i class="fa fa-shopping-cart"></i>&nbsp;购买会员
		</div>
		<div class="panel-body">
		<div class="list-group-item">
		  <b>当前会员等级：</b><font color="red"><?php echo $group[$userrow['gid']]?></font>
		</div>
		<div class="line line-dashed b-b line-lg pull-in"></div>
        <table class="table table-striped table-hover">
          <thead><tr><th>会员等级</th><th>可用支付通道及费率</th><th>售价</th><th>操作</th></tr></thead>
          <tbody>
<?php
foreach($list as $res){
	echo '<tr><td><b>'.$res['name'].'</b></td><td>'.display_info($res['info']).'</td><td><span style="font-size:20px;font-weight:700;color:#f40;">'.$res['price'].'</span></td><td>'.($userrow['gid']==$res['gid']?'<a class="btn btn-sm btn-info" href="javascript:;" disabled>当前等级</a>':'<a class="btn btn-sm btn-info" href="javascript:buy('.$res['gid'].')">立即购买</a>').'</td></tr>';
}
?>
		  </tbody>
        </table>
		</div>
	</div>
	</div>
	</div>
	<div class="row" id="infoFrame" style="display:none;">
	<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
	<button class="btn btn-default btn-block" onclick="back()"><i class="fa fa-reply"></i>&nbsp;返回列表</button>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			<i class="fa fa-shopping-cart"></i>&nbsp;购买会员
		</div>
		<div class="panel-body">
        <form class="form-horizontal devform">
			<input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
			<input type="hidden" name="group_id" value="">
				<div class="form-group">
					<label class="col-sm-3 control-label">会员等级</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="group_name" value="" readonly="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">有效期</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="group_expire" value="" readonly="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">售价</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="group_price" value="" readonly="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">支付方式</label>
					<div class="col-sm-8">
						<div class="radio">
						<label class="i-checks"><input type="radio" name="type" value="0"><i></i>余额支付</label>&nbsp;
						<?php foreach($paytypem as $row){?>
						  <label class="i-checks"><input type="radio" name="type" value="<?php echo $row['id']?>" rate="<?php echo $row['rate']?>"><i></i><?php echo $row['showname']?>
						  </label>&nbsp;
						<?php }?>
						</div>
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-3 col-sm-8"><input type="button" id="submit" value="立即购买" class="btn btn-success form-control"/><br/>
				 </div>
				</div>
			</form>
		</div>
	</div>
	</div>
	</div>
</div>
    </div>
  </div>

<?php include 'foot.php';?>
<script src="../assets/layer/layer.js"></script>
<script>
function buy(gid){
	var ii = layer.load();
	$.ajax({
		type: "POST",
		dataType: "json",
		data: {gid:gid},
		url: "ajax2.php?act=groupinfo",
		success: function (data, textStatus) {
			layer.close(ii);
			if (data.code == 0) {
				$("input[name='group_id']").val(gid);
				$("input[name='group_name']").val(data.name);
				$("input[name='group_expire']").val(data.expire);
				$("input[name='group_price']").val(data.price);
				$("#listFrame").slideUp();
				$("#infoFrame").slideDown();
			}else{
				layer.alert(data.msg, {icon: 0});
			}
		},
		error: function (data) {
			layer.msg('服务器错误', {icon: 2});
		}
	});
}
function back(){
	$("#listFrame").slideDown();
	$("#infoFrame").slideUp();
}
$(document).ready(function(){
	$("input[name=type]:first").attr("checked",true);
	$("#submit").click(function(){
		var csrf_token=$("input[name='csrf_token']").val();
		var gid=$("input[name='group_id']").val();
		var typeid=$("input[name=type]:checked").val();
		var ii = layer.load();
		$.ajax({
			type: "POST",
			dataType: "json",
			data: {gid:gid, typeid:typeid, csrf_token:csrf_token},
			url: "ajax2.php?act=groupbuy",
			success: function (data, textStatus) {
				layer.close(ii);
				if (data.code == 0) {
					window.location.href=data.url;
				}else if (data.code == 1) {
					layer.alert(data.msg, {icon: 1}, function(){ window.location.reload() });
				}else{
					layer.alert(data.msg, {icon: 2});
				}
			},
			error: function (data) {
				layer.msg('服务器错误', {icon: 2});
			}
		});
		return false;
	})
});
</script>