<?php
include("./inc.php");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

if(strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])===false)exit('{"code":403}');

@header('Content-Type: application/json; charset=UTF-8');

$uid=intval($_POST['uid']);
$money=daddslashes($_POST['money']);
$payer=daddslashes($_POST['payer']);
$paytype=$_POST['paytype'];
$direct=intval($_POST['direct']);
if($_POST['token']!=$_SESSION['paypage_token'])exit('{"code":-1,"msg":"CSRF TOKEN ERROR"}');
if(!$uid || $uid!=$_SESSION['paypage_uid'])exit('{"code":-1,"msg":"收款方信息无效"}');
if($money<=0 || !is_numeric($money) || !preg_match('/^[0-9.]+$/', $money))exit('{"code":-1,"msg":"金额不合法"}');
if($conf['pay_maxmoney']>0 && $money>$conf['pay_maxmoney'])exit('{"code":-1,"msg":"最大支付金额是'.$conf['pay_maxmoney'].'元"}');
if($conf['pay_minmoney']>0 && $money<$conf['pay_minmoney'])exit('{"code":-1,"msg":"最小支付金额是'.$conf['pay_minmoney'].'元"}');

$trade_no=date("YmdHis").rand(11111,99999);
$return_url=$siteurl.'paypage/success.php?trade_no='.$trade_no;
$domain=getdomain($return_url);
if(!$DB->exec("INSERT INTO `pre_order` (`trade_no`,`out_trade_no`,`uid`,`tid`,`addtime`,`name`,`money`,`notify_url`,`return_url`,`domain`,`ip`,`status`) VALUES (:trade_no, :out_trade_no, :uid, 3, NOW(), :name, :money, :notify_url, :return_url, :domain, :clientip, 0)", [':trade_no'=>$trade_no, ':out_trade_no'=>$trade_no, ':uid'=>$uid, ':name'=>'在线收款', ':money'=>$money, ':notify_url'=>$return_url, ':return_url'=>$return_url, ':domain'=>$domain, ':clientip'=>$clientip]))exit('{"code":-1,"msg":"创建订单失败，请返回重试！"}');

$_SESSION['paypage_trade_no'] = $trade_no;

$result=[];
$result['code']=0;
$result['msg']='succ';
$result['trade_no']=$trade_no;
$result['direct']=$direct;

if(!empty($paytype) && isset($_SESSION['paypage_typeid']) && isset($_SESSION['paypage_channel']) && isset($_SESSION['paypage_rate'])){
	$typeid = intval($_SESSION['paypage_typeid']);
	$channel = intval($_SESSION['paypage_channel']);
	if($direct==1){
		if($userrow['mode']==1){
			$realmoney = round($money*(100+100-$_SESSION['paypage_rate'])/100,2);
			$getmoney = $money;
		}else{
			$realmoney = $money;
			$getmoney = round($money*$_SESSION['paypage_rate']/100,2);
		}
		$DB->exec("UPDATE pre_order SET type='$typeid',channel='$channel',realmoney='$realmoney',getmoney='$getmoney' WHERE trade_no='$trade_no'");
		$ordername = 'onlinepay'.time();
		$ordername = !empty($conf['ordername'])?ordername_replace($conf['ordername'],$ordername,$uid):$ordername;
		if($paytype=='alipay'){
			$paydata = alipay_jspay($channel,$trade_no,$realmoney,$ordername,$payer);
		}elseif($paytype=='wxpay'){
			$paydata = wxpay_jspay($channel,$trade_no,$realmoney,$ordername,$payer);
		}elseif($paytype=='qqpay'){
			$paydata = qqpay_jspay($channel,$trade_no,$realmoney,$ordername);
		}
		$result['paydata'] = $paydata;
	}else{
		$result['url'] = '/submit2.php?typeid='.$typeid.'&trade_no='.$trade_no;
	}
}else{
	$result['url'] = '/cashier.php?trade_no='.$trade_no;
}

exit(json_encode($result));