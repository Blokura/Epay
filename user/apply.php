<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='申请提现';
include './head.php';
?>
<?php

function display_type($type){
	if($type==1)
		return '支付宝';
	elseif($type==2)
		return '微信';
	elseif($type==3)
		return 'QQ钱包';
	elseif($type==4)
		return '银行卡';
	else
		return 1;
}

if($conf['settle_open']==0||$conf['settle_open']==1)exit('未开启手动申请提现');

if($conf['settle_type']==1){
	$today=date("Y-m-d").' 00:00:00';
	$rs=$DB->query("SELECT realmoney from pre_order where uid={$uid} and status=1 and endtime>='$today'");
	$order_today=0;
	while($row = $rs->fetch())
	{
		$order_today+=$row['realmoney'];
	}
	$enable_money=round($userrow['money']-$order_today,2);
	if($enable_money<0)$enable_money=0;
}else{
	$enable_money=$userrow['money'];
}

if(isset($_GET['act']) && $_GET['act']=='do'){
	if($_POST['submit']=='申请提现'){
		$money=daddslashes(strip_tags($_POST['money']));
		if(!is_numeric($money) || !preg_match('/^[0-9.]+$/', $money))exit("<script language='javascript'>alert('提现金额输入不规范');history.go(-1);</script>");
		if($enable_money<$conf['settle_money']){
			exit("<script language='javascript'>alert('满{$conf['settle_money']}元才可以提现！');history.go(-1);</script>");
		}
		if($money<$conf['settle_money']){
			exit("<script language='javascript'>alert('最低提现金额为{$conf['settle_money']}元');history.go(-1);</script>");
		}
		if($userrow['settle']==0){
			exit("<script language='javascript'>alert('您的商户出现异常，无法提现');history.go(-1);</script>");
		}
		if($conf['settle_rate']>0){
			$fee=round($money*$conf['settle_rate']/100,2);
			if($fee<$conf['settle_fee_min'])$fee=$conf['settle_fee_min'];
			if($fee>$conf['settle_fee_max'])$fee=$conf['settle_fee_max'];
			$realmoney=$money-$fee;
		}else{
			$realmoney=$money;
		}
		if($DB->exec("INSERT INTO `pre_settle` (`uid`, `type`, `username`, `account`, `money`, `realmoney`, `addtime`, `status`) VALUES ('{$uid}', '{$userrow['settle_id']}', '{$userrow['username']}', '{$userrow['account']}', '{$money}', '{$realmoney}', '{$date}', '0')")){
			changeUserMoney($uid, $money, false, '手动提现');
		}
		exit("<script language='javascript'>alert('申请提现成功！');window.location.href='./settle.php';</script>");
	}
}


?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">申请提现</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			申请提现
		</div>
		<div class="panel-body">
			<form class="form-horizontal devform" action="./apply.php?act=do" method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label">提现方式</label>
					<div class="col-sm-9">
						<div class="input-group"><input class="form-control" type="text" value="<?php echo display_type($userrow['settle_id'])?>" disabled><a href="./editinfo.php" class="input-group-addon">修改收款账号</a></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">提现账号</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value="<?php echo $userrow['account']?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">你的姓名</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value="<?php echo $userrow['username']?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">当前余额</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value="<?php echo $userrow['money']?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">可提现余额</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="tmoney" value="<?php echo $enable_money?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">申请提现余额</label>
					<div class="col-sm-9">
						<div class="input-group"><input class="form-control" type="text" name="money" value="" required><a href="javascript:inputMoney()" class="input-group-addon">全部</a></div>
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><input type="submit" name="submit" value="申请提现" class="btn btn-primary form-control"/><br/>
				 </div>
			</form>
			<footer class="panel-footer">
				<div class="col-sm-offset-2 col-sm-6"><br/>
				<h4><span class="glyphicon glyphicon-info-sign"></span>注意事项</h4>
					当前最低提现金额为<b><?php echo $conf['settle_money']?></b>元<br/>
					当前手动提现模式是：<?php echo $conf['settle_type']==1?'<b>T+1</b>，可提现余额为截止到前一天你的收入':'<b>T+0</b>，可提现余额为截止到现在你的收入';?><br/>
					申请提现后，你的款项将在1个工作日内下发到指定账户内。
				</div>
			</footer>
		</div>
	</div>
</div>
    </div>
  </div>

<?php include 'foot.php';?>
<script>
function inputMoney(){
	$("input[name='money']").val($("input[name='tmoney']").val());
}
</script>