<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='余额充值';
include './head.php';
?>
<?php
$paytype = \lib\Channel::getTypes($userrow['gid']);
$csrf_token = md5(mt_rand(0,999).time());
$_SESSION['csrf_token'] = $csrf_token;
?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">余额充值</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="row">
	<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
	<?php if(isset($_GET['ok']) && $_GET['ok']==1){
	$order = $DB->getRow("SELECT * FROM pre_order WHERE trade_no=:trade_no limit 1", [':trade_no'=>$_GET['trade_no']]);
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  恭喜你成功充值<strong><?php echo $order['money']?></strong>元余额！
	</div>
	<?php }?>
	<div class="alert alert-info text-md">
		<p>充值手续费按当前商户通道费率收取，支付没到账请联系客服进行补单。</p><p>充值的余额仅限用于平台消费或订单退款资金，严禁频繁大额充值后提现，否则封禁商户并冻结余额！</p>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			<i class="fa fa-cny"></i>&nbsp;余额充值
		</div>
		<div class="panel-body">
			<form class="form-horizontal devform">
			<input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
				<div class="form-group">
					<label class="col-sm-3 control-label">当前余额</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="rmoney" value="<?php echo $userrow['money']?> 元" readonly="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">充值金额</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="money" value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">支付方式</label>
					<div class="col-sm-8">
						<div class="radio">
						<?php foreach($paytype as $row){?>
						  <label class="i-checks"><input type="radio" name="type" value="<?php echo $row['id']?>" rate="<?php echo $row['rate']?>"><i></i><?php echo $row['showname']?>
						  </label>&nbsp;
						<?php }?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">共需支付</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="need" value="" readonly="">
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-3 col-sm-8"><input type="button" id="submit" value="充值" class="btn btn-success form-control"/><br/>
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
function showneed(){
	var money = parseFloat($("input[name='money']").val());
	var rate = parseFloat($("input[name=type]:checked").attr('rate'));
	if(isNaN(money) || isNaN(rate))return;
	var need = (money + money * (1-rate/100)).toFixed(2);
	$("input[name='need']").val(need)
}
$(document).ready(function(){
	$("input[name=type]:first").attr("checked",true);
	$("input[name='money']").blur(function(){
		showneed()
	});
	$("input[name='type']").click(function(){
		showneed()
	});
	$("#submit").click(function(){
		var csrf_token=$("input[name='csrf_token']").val();
		var money=$("input[name='money']").val();
		var typeid=$("input[name=type]:checked").val();
		if(money==''){
			layer.alert("金额不能为空");
			return false;
		}
		var ii = layer.load();
		$.ajax({
			type: "POST",
			dataType: "json",
			data: {money:money, typeid:typeid, csrf_token:csrf_token},
			url: "ajax2.php?act=recharge",
			success: function (data, textStatus) {
				layer.close(ii);
				if (data.code == 0) {
					window.location.href=data.url;
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