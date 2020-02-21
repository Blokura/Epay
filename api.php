<?php
$nosession = true;
require './includes/common.php';
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
$url=daddslashes($_GET['url']);
$authcode=daddslashes($_GET['authcode']);


if($act=='apply')
{
	$pid=intval($_GET['pid']);
	$key=daddslashes($_GET['key']);
	$row=$DB->getRow("SELECT * FROM pre_user WHERE uid='{$pid}' limit 1");
	if($row && $row['status']==1 && $row['apply']==1){
		$type=0;
		$key = random(32);
		$sds=$DB->exec("INSERT INTO `pre_user` (`key`, `url`, `addtime`, `pay`, `settle`, `status`, `upuid`) VALUES ('{$key}', '{$url}', '{$date}', '1', '1', '1', '{$row['uid']}')");
		$pid=$DB->lastInsertId();

		if($sds){
			$result=array("code"=>1,"msg"=>"添加支付商户成功！","pid"=>$pid,"key"=>$key,"type"=>$type);
		}else{
			$result=array("code"=>-1,"msg"=>"添加支付商户失败！");
		}
	}else{
		$result=array("code"=>-1,"msg"=>"当前商户没有权限");
	}
}
elseif($act=='query')
{
	$pid=intval($_GET['pid']);
	$key=daddslashes($_GET['key']);
	$row=$DB->getRow("SELECT * FROM pre_user WHERE uid='{$pid}' limit 1");
	if($row){
		if($key==$row['key']){
			$orders=$DB->getColumn("SELECT count(*) from pre_order WHERE uid={$pid}");

			$lastday=date("Y-m-d",strtotime("-1 day")).' 00:00:00';
			$today=date("Y-m-d").' 00:00:00';
			$order_today=$DB->query("SELECT sum(money) from pre_order where uid={$pid} and status=1 and endtime>='$today'")->fetchColumn();

			$order_lastday=$DB->query("SELECT sum(money) from pre_order where uid={$pid} and status=1 and endtime>='$lastday' and endtime<'$today'")->fetchColumn();

			//$settle_money=$DB->query("SELECT sum(money) from pre_settle where uid={$pid} and status=1")->fetchColumn();

			$result=array("code"=>1,"pid"=>$pid,"key"=>$key,"type"=>$row['settle_id'],"active"=>$row['status'],"money"=>$row['money'],"account"=>$row['account'],"username"=>$row['username'],"settle_money"=>$conf['settle_money'],"settle_fee"=>$conf['settle_fee'],"money_rate"=>$conf['money_rate'],"orders"=>$orders,"order_today"=>$order_today,"order_lastday"=>$order_lastday);
		}else{
			$result=array("code"=>-2,"msg"=>"KEY校验失败");
		}
	}else{
		$result=array("code"=>-3,"msg"=>"PID不存在");
	}
}
elseif($act=='change')
{
	$pid=intval($_GET['pid']);
	$key=daddslashes($_GET['key']);
	$stype=daddslashes($_GET['type']);
	$account=daddslashes($_GET['account']);
	$username=daddslashes($_GET['username']);
	$row=$DB->query("SELECT * FROM pre_user WHERE uid='{$pid}' limit 1")->fetch();
	if($row){
		if($key==$row['key']){
			if($account==null || $username==null){
				$result=array("code"=>-1,"msg"=>"保存错误,请确保每项都不为空!");
			}elseif($row['settle']!=2 && !empty($row['account']) && !empty($row['username']) && $row['account']!=$account){
				$result=array("code"=>-1,"msg"=>"为保障您的资金安全，暂不支持直接修改结算账号信息，如需修改请进入商户中心".$siteurl);
			}else{
				$sds=$DB->exec("update `pre_user` set `account`='{$account}',`username`='{$username}',`settle_id`='{$stype}',`url`='{$url}' where uid='{$pid}' limit 1");
				if($sds>=0){
					$result=array("code"=>1,"msg"=>"修改收款账号成功！","pid"=>$pid,"key"=>$key,"type"=>$type);
				}else{
					$result=array("code"=>-1,"msg"=>"修改收款账号失败！");
				}
			}
		}else{
			$result=array("code"=>-2,"msg"=>"KEY校验失败");
		}
	}else{
		$result=array("code"=>-3,"msg"=>"PID不存在");
	}
}
elseif($act=='settle')
{
	$pid=intval($_GET['pid']);
	$key=daddslashes($_GET['key']);
	$limit=$_GET['limit']?intval($_GET['limit']):10;
	if($limit>50)$limit=50;
	$row=$DB->query("SELECT * FROM pre_user WHERE uid='{$pid}' limit 1")->fetch();
	if($row){
		if($key==$row['key']){
			$rs=$DB->query("SELECT * FROM pre_settle WHERE uid='{$pid}' order by id desc limit {$limit}");
			while($row=$rs->fetch()){
				$data[]=$row;
			}
			if($rs){
				$result=array("code"=>1,"msg"=>"查询结算记录成功！","pid"=>$pid,"key"=>$key,"type"=>$type,"data"=>$data);
			}else{
				$result=array("code"=>-1,"msg"=>"查询结算记录失败！");
			}
		}else{
			$result=array("code"=>-2,"msg"=>"KEY校验失败");
		}
	}else{
		$result=array("code"=>-3,"msg"=>"PID不存在");
	}
}
elseif($act=='order')
{
	$pid=intval($_GET['pid']);
	$key=daddslashes($_GET['key']);
	$row=$DB->query("SELECT * FROM pre_user WHERE uid='{$pid}' limit 1")->fetch();
	if($row){
		if($key==$row['key']){
			if(isset($_GET['trade_no'])){
				$trade_no=daddslashes($_GET['trade_no']);
				$row=$DB->query("SELECT * FROM pre_order WHERE uid='{$pid}' and trade_no='{$trade_no}' limit 1")->fetch();
			}elseif(isset($_GET['out_trade_no'])){
				$out_trade_no=daddslashes($_GET['out_trade_no']);
				$row=$DB->query("SELECT * FROM pre_order WHERE uid='{$pid}' and out_trade_no='{$out_trade_no}' limit 1")->fetch();
			}else{
				exit('{"code":-4,"msg":"参数不完整"}');
			}
			if($row){
				$result=array("code"=>1,"msg"=>"查询订单号成功！","trade_no"=>$row['trade_no'],"out_trade_no"=>$row['out_trade_no'],"type"=>$row['type'],"pid"=>$row['pid'],"addtime"=>$row['addtime'],"endtime"=>$row['endtime'],"name"=>$row['name'],"money"=>$row['money'],"status"=>$row['status']);
			}else{
				$result=array("code"=>-1,"msg"=>"订单号不存在");
			}
		}else{
			$result=array("code"=>-2,"msg"=>"KEY校验失败");
		}
	}else{
		$result=array("code"=>-3,"msg"=>"PID不存在");
	}
}
elseif($act=='orders')
{
	$pid=intval($_GET['pid']);
	$key=daddslashes($_GET['key']);
	$limit=$_GET['limit']?intval($_GET['limit']):10;
	if($limit>50)$limit=50;
	$row=$DB->query("SELECT * FROM pre_user WHERE uid='{$pid}' limit 1")->fetch();
	if($row){
		if($key==$row['key']){
			$rs=$DB->query("SELECT * FROM pre_order WHERE uid='{$pid}' order by trade_no desc limit {$limit}");
			while($row=$rs->fetch()){
				$data[]=$row;
			}
			if($rs){
				$result=array("code"=>1,"msg"=>"查询订单记录成功！","data"=>$data);
			}else{
				$result=array("code"=>-1,"msg"=>"查询订单记录失败！");
			}
		}else{
			$result=array("code"=>-2,"msg"=>"KEY校验失败");
		}
	}else{
		$result=array("code"=>-3,"msg"=>"PID不存在");
	}
}
else
{
	$result=array("code"=>-5,"msg"=>"No Act!");
}

echo json_encode($result);

?>