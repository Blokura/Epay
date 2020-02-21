<?php
include("../includes/common.php");
if($islogin2==1){}else exit('{"code":-3,"msg":"No Login"}');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

if(strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])===false)exit('{"code":403}');

@header('Content-Type: application/json; charset=UTF-8');

switch($act){
case 'getcount':
	$lastday=date("Y-m-d",strtotime("-1 day"));
	$today=date("Y-m-d");

	$orders=$DB->getColumn("SELECT count(*) FROM pre_order WHERE uid={$uid} AND status=1");
	$orders_today=$DB->getColumn("SELECT count(*) from pre_order WHERE uid={$uid} AND status=1 AND date='$today'");

	$settle_money=$DB->getColumn("SELECT sum(getmoney) FROM pre_settle WHERE uid={$uid} and status=1");
	$settle_money=round($settle_money,2);

	$order_today['all']=$DB->getColumn("SELECT sum(getmoney) FROM pre_order WHERE uid={$uid} AND status=1 AND date='$today'");
	$order_today['all']=round($order_today['all'],2);
	$order_today['alipay']=$DB->getColumn("SELECT sum(getmoney) FROM pre_order WHERE uid={$uid} AND type=(SELECT id FROM pre_type WHERE name='alipay') AND status=1 AND date='$today'");
	$order_today['alipay']=round($order_today['alipay'],2);
	$order_today['wxpay']=$DB->getColumn("SELECT sum(getmoney) FROM pre_order WHERE uid={$uid} AND type=(SELECT id FROM pre_type WHERE name='wxpay') AND status=1 AND date='$today'");
	$order_today['wxpay']=round($order_today['wxpay'],2);
	$order_today['qqpay']=$DB->getColumn("SELECT sum(getmoney) FROM pre_order WHERE uid={$uid} AND type=(SELECT id FROM pre_type WHERE name='qqpay') AND status=1 AND date='$today'");
	$order_today['qqpay']=round($order_today['qqpay'],2);

	$order_lastday['all']=$DB->getColumn("SELECT sum(getmoney) FROM pre_order WHERE uid={$uid} AND status=1 AND date='$lastday'");
	$order_lastday['all']=round($order_lastday['all'],2);
	$order_lastday['alipay']=$DB->getColumn("SELECT sum(getmoney) FROM pre_order WHERE uid={$uid} AND type=(SELECT id FROM pre_type WHERE name='alipay') AND status=1 AND date='$lastday'");
	$order_lastday['alipay']=round($order_lastday['alipay'],2);
	$order_lastday['wxpay']=$DB->getColumn("SELECT sum(getmoney) FROM pre_order WHERE uid={$uid} AND type=(SELECT id FROM pre_type WHERE name='wxpay') AND status=1 AND date='$lastday'");
	$order_lastday['wxpay']=round($order_lastday['wxpay'],2);
	$order_lastday['qqpay']=$DB->getColumn("SELECT sum(getmoney) FROM pre_order WHERE uid={$uid} AND type=(SELECT id FROM pre_type WHERE name='qqpay') AND status=1 AND date='$lastday'");
	$order_lastday['qqpay']=round($order_lastday['qqpay'],2);

	$result=['code'=>0, 'orders'=>$orders, 'orders_today'=>$orders_today, 'settle_money'=>$settle_money, 'order_today'=>$order_today, 'order_lastday'=>$order_lastday];
	exit(json_encode($result));
break;
case 'sendcode':
	$situation=trim($_POST['situation']);
	$target=daddslashes(htmlspecialchars(strip_tags(trim($_POST['target']))));
	if(isset($_SESSION['send_mail']) && $_SESSION['send_mail']>time()-10){
		exit('{"code":-1,"msg":"请勿频繁发送验证码"}');
	}
	$GtSdk = new \lib\GeetestLib($conf['CAPTCHA_ID'], $conf['PRIVATE_KEY']);

	$data = array(
		'user_id' => $uid, # 网站用户id
		'client_type' => "web", # web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
		'ip_address' => $clientip # 请在此处传输用户请求验证时所携带的IP
	);

	if ($_SESSION['gtserver'] == 1) {   //服务器正常
		$result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
		if ($result) {
			//echo '{"status":"success"}';
		} else{
			exit('{"code":-1,"msg":"验证失败，请重新验证"}');
		}
	}else{  //服务器宕机,走failback模式
		if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
			//echo '{"status":"success"}';
		}else{
			exit('{"code":-1,"msg":"验证失败，请重新验证"}');
		}
	}
	if($conf['verifytype']==1){
		if($situation=='bind'){
			$phone=$target;
			if(empty($phone) || strlen($phone)!=11){
				exit('{"code":-1,"msg":"请填写正确的手机号码！"}');
			}
			if($phone==$userrow['phone']){
				exit('{"code":-1,"msg":"你填写的手机号码和之前一样"}');
			}
			$row=$DB->getRow("select * from pre_user where phone='$phone' limit 1");
			if($row){
				exit('{"code":-1,"msg":"该手机号码已经绑定过其它商户"}');
			}
		}else{
			if(empty($userrow['phone']) || strlen($userrow['phone'])!=11){
				exit('{"code":-1,"msg":"请先绑定手机号码！"}');
			}
			$phone=$userrow['phone'];
		}
		$row=$DB->getRow("select * from pre_regcode where `to`='$phone' order by id desc limit 1");
		if($row['time']>time()-60){
			exit('{"code":-1,"msg":"两次发送短信之间需要相隔60秒！"}');
		}
		$count=$DB->getColumn("select count(*) from pre_regcode where `to`='$phone' and time>'".(time()-3600*24)."'");
		if($count>2){
			exit('{"code":-1,"msg":"该手机号码发送次数过多，暂无法发送！"}');
		}
		$count=$DB->getColumn("select count(*) from pre_regcode where ip='$clientip' and time>'".(time()-3600*24)."'");
		if($count>5){
			exit('{"code":-1,"msg":"你今天发送次数过多，已被禁止发送"}');
		}
		$code = rand(111111,999999);
		$result = send_sms($phone, $code, 'edit');
		if($result===true){
			if($DB->exec("insert into `pre_regcode` (`uid`,`type`,`code`,`to`,`time`,`ip`,`status`) values ('".$uid."','3','".$code."','".$phone."','".time()."','".$clientip."','0')")){
				$_SESSION['send_mail']=time();
				exit('{"code":0,"msg":"succ"}');
			}else{
				exit('{"code":-1,"msg":"写入数据库失败。'.$DB->error().'"}');
			}
		}else{
			exit('{"code":-1,"msg":"短信发送失败 '.$result.'"}');
		}
	}else{
		if($situation=='bind'){
			$email=$target;
			if(!preg_match('/^[A-z0-9._-]+@[A-z0-9._-]+\.[A-z0-9._-]+$/', $email)){
				exit('{"code":-1,"msg":"邮箱格式不正确"}');
			}
			if($email==$userrow['email']){
				exit('{"code":-1,"msg":"你填写的邮箱和之前一样"}');
			}
			$row=$DB->getRow("select * from pre_user where email='$email' limit 1");
			if($row){
				exit('{"code":-1,"msg":"该邮箱已经绑定过其它商户"}');
			}
		}else{
			if(empty($userrow['email']) || strpos($userrow['email'],'@')===false){
				exit('{"code":-1,"msg":"请先绑定邮箱！"}');
			}
			$email=$userrow['email'];
		}
		$row=$DB->getRow("select * from pre_regcode where `to`='$email' order by id desc limit 1");
		if($row['time']>time()-60){
			exit('{"code":-1,"msg":"两次发送邮件之间需要相隔60秒！"}');
		}
		$count=$DB->getColumn("select count(*) from pre_regcode where `to`='$email' and time>'".(time()-3600*24)."'");
		if($count>6){
			exit('{"code":-1,"msg":"该邮箱发送次数过多，请更换邮箱！"}');
		}
		$count=$DB->getColumn("select count(*) from pre_regcode where ip='$clientip' and time>'".(time()-3600*24)."'");
		if($count>10){
			exit('{"code":-1,"msg":"你今天发送次数过多，已被禁止发送"}');
		}
		$sub = $conf['sitename'].' - 验证码获取';
		$code = rand(1111111,9999999);
		if($situation=='settle')$msg = '您正在修改结算账号信息，验证码是：'.$code;
		elseif($situation=='mibao')$msg = '您正在修改密保邮箱，验证码是：'.$code;
		elseif($situation=='bind')$msg = '您正在绑定新邮箱，验证码是：'.$code;
		else $msg = '您的验证码是：'.$code;
		$result = send_mail($email, $sub, $msg);
		if($result===true){
			if($DB->exec("insert into `pre_regcode` (`uid`,`type`,`code`,`to`,`time`,`ip`,`status`) values ('".$uid."','2','".$code."','".$email."','".time()."','".$clientip."','0')")){
				$_SESSION['send_mail']=time();
				exit('{"code":0,"msg":"succ"}');
			}else{
				exit('{"code":-1,"msg":"写入数据库失败。'.$DB->error().'"}');
			}
		}else{
			file_put_contents('mail.log',$result);
			exit('{"code":-1,"msg":"邮件发送失败"}');
		}
	}
break;
case 'verifycode':
	$code=trim(daddslashes($_POST['code']));
	if($conf['verifytype']==1){
		$row=$DB->getRow("select * from pre_regcode where uid='$uid' and type=3 and code='$code' and `to`='{$userrow['phone']}' order by id desc limit 1");
	}else{
		$row=$DB->getRow("select * from pre_regcode where uid='$uid' and type=2 and code='$code' and `to`='{$userrow['email']}' order by id desc limit 1");
	}
	if(!$row){
		exit('{"code":-1,"msg":"验证码不正确！"}');
	}
	if($row['time']<time()-3600 || $row['status']>0){
		exit('{"code":-1,"msg":"验证码已失效，请重新获取"}');
	}
	$_SESSION['verify_ok']=$uid;
	$DB->exec("update `pre_regcode` set `status` ='1' where `id`='{$row['id']}'");
	exit('{"code":1,"msg":"succ"}');
break;
case 'completeinfo':
	$type=intval($_POST['stype']);
	$account=daddslashes(htmlspecialchars(strip_tags(trim($_POST['account']))));
	$username=daddslashes(htmlspecialchars(strip_tags(trim($_POST['username']))));
	$email=daddslashes(htmlspecialchars(strip_tags(trim($_POST['email']))));
	$qq=daddslashes(htmlspecialchars(strip_tags(trim($_POST['qq']))));
	$url=daddslashes(htmlspecialchars(strip_tags(trim($_POST['url']))));

	if($account==null || $username==null || $qq==null || $url==null){
		exit('{"code":-1,"msg":"请确保每项都不为空"}');
	}
	if($type==1 && strlen($account)!=11 && strpos($account,'@')==false){
		exit('{"code":-1,"msg":"请填写正确的支付宝账号！"}');
	}
	if($type==2 && strlen($account)<3){
		exit('{"code":-1,"msg":"请填写正确的微信"}');
	}
	if($type==3 && (strlen($account)<5 || strlen($account)>10 || !is_numeric($account))){
		exit('{"code":-1,"msg":"请填写正确的QQ号码"}');
	}
	if(strlen($qq)<5 || strlen($account)>10 || !is_numeric($qq)){
		exit('{"code":-1,"msg":"请填写正确的QQ"}');
	}
	if(strlen($url)<4 || strpos($url,'.')==false){
		exit('{"code":-1,"msg":"请填写正确的网站域名！"}');
	}
	if($conf['verifytype']==1){
		if(!preg_match('/^[A-z0-9._-]+@[A-z0-9._-]+\.[A-z0-9._-]+$/', $email)){
			exit('{"code":-1,"msg":"邮箱格式不正确"}');
		}
		if($email!=$userrow['email']){
			$row=$DB->getRow("select * from pre_user where email='$email' limit 1");
			if($row){
				exit('{"code":-1,"msg":"该邮箱已经绑定过其它商户，如需找回，请退出登录后找回密码"}');
			}
			$sqls=",`email` ='{$email}'";
		}
	}
	$sqs=$DB->exec("update `pre_user` set `settle_id` ='{$type}',`account` ='{$account}',`username` ='{$username}',`qq` ='{$qq}',`url` ='{$url}'{$sqls} where `uid`='$uid'");
	if($sqs!==false){
		exit('{"code":1,"msg":"succ"}');
	}else{
		exit('{"code":-1,"msg":"保存失败！'.$DB->error().'"}');
	}
break;
case 'edit_settle':
	$type=intval($_POST['stype']);
	$account=daddslashes(htmlspecialchars(strip_tags(trim($_POST['account']))));
	$username=daddslashes(htmlspecialchars(strip_tags(trim($_POST['username']))));

	if($account==null || $username==null){
		exit('{"code":-1,"msg":"请确保每项都不为空"}');
	}
	if($type==1 && strlen($account)!=11 && strpos($account,'@')==false){
		exit('{"code":-1,"msg":"请填写正确的支付宝账号！"}');
	}
	if($type==2 && strlen($account)<3){
		exit('{"code":-1,"msg":"请填写正确的微信"}');
	}
	if($type==3 && (strlen($account)<5 || strlen($account)>10 || !is_numeric($account))){
		exit('{"code":-1,"msg":"请填写正确的QQ号码"}');
	}
	if($userrow['type']!=2 && !empty($userrow['account']) && !empty($userrow['username']) && ($userrow['account']!=$account || $userrow['username']!=$username) && $_SESSION['verify_ok']!==$uid){
		if($conf['verifytype']==1 && (empty($userrow['phone']) || strlen($userrow['phone'])!=11)){
			exit('{"code":-1,"msg":"请先绑定手机号码！"}');
		}elseif($conf['verifytype']==0 && (empty($userrow['email']) || strpos($userrow['email'],'@')===false)){
			exit('{"code":-1,"msg":"请先绑定邮箱！"}');
		}
		exit('{"code":2,"msg":"need verify"}');
	}
	$sqs=$DB->exec("update `pre_user` set `settle_id` ='{$type}',`account` ='{$account}',`username` ='{$username}' where `uid`='$uid'");
	if($sqs!==false){
		exit('{"code":1,"msg":"succ"}');
	}else{
		exit('{"code":-1,"msg":"保存失败！'.$DB->error().'"}');
	}
break;
case 'edit_info':
	$email=daddslashes(htmlspecialchars(strip_tags(trim($_POST['email']))));
	$qq=daddslashes(htmlspecialchars(strip_tags(trim($_POST['qq']))));
	$url=daddslashes(htmlspecialchars(strip_tags(trim($_POST['url']))));
	$keylogin=intval($_POST['keylogin']);

	if($qq==null || $url==null){
		exit('{"code":-1,"msg":"请确保每项都不为空"}');
	}
	if($conf['verifytype']==1){
		if($email!=$userrow['email']){
			$row=$DB->getRow("select * from pre_user where email='$email' limit 1");
			if($row){
				exit('{"code":-1,"msg":"该邮箱已经绑定过其它商户，如需找回，请退出登录后找回密码"}');
			}
		}
		$sqs=$DB->exec("update `pre_user` set `email` ='{$email}',`qq` ='{$qq}',`url` ='{$url}',`keylogin` ='{$keylogin}' where `uid`='$uid'");
	}else{
		$sqs=$DB->exec("update `pre_user` set `qq` ='{$qq}',`url` ='{$url}',`keylogin` ='{$keylogin}' where `uid`='$uid'");
	}
	if($sqs!==false){
		exit('{"code":1,"msg":"succ"}');
	}else{
		exit('{"code":-1,"msg":"保存失败！'.$DB->error().'"}');
	}
break;
case 'edit_mode':
	$mode=intval($_POST['mode']);

	$sqs=$DB->exec("update `pre_user` set `mode` ='{$mode}' where `uid`='$uid'");
	if($sqs!==false){
		exit('{"code":1,"msg":"succ"}');
	}else{
		exit('{"code":-1,"msg":"保存失败！'.$DB->error().'"}');
	}
break;
case 'edit_bind':
	$email=daddslashes(htmlspecialchars(strip_tags(trim($_POST['email']))));
	$phone=daddslashes(htmlspecialchars(strip_tags(trim($_POST['phone']))));
	$code=daddslashes(trim($_POST['code']));

	if($code==null || $email==null && $phone==null){
		exit('{"code":-1,"msg":"请确保每项都不为空"}');
	}
	if(empty($_SESSION['verify_ok']) || $_SESSION['verify_ok']!=$uid){
		exit('{"code":2,"msg":"请先完成验证"}');
	}
	if($conf['verifytype']==1){
		$row=$DB->getRow("select * from pre_regcode where type=3 and code='$code' and `to`='$phone' order by id desc limit 1");
	}else{
		$row=$DB->getRow("select * from pre_regcode where type=2 and code='$code' and `to`='$email' order by id desc limit 1");
	}
	if(!$row){
		exit('{"code":-1,"msg":"验证码不正确！"}');
	}
	if($row['time']<time()-3600 || $row['status']>0){
		exit('{"code":-1,"msg":"验证码已失效，请重新获取"}');
	}
	if($conf['verifytype']==1){
		$sqs=$DB->exec("update `pre_user` set `phone` ='{$phone}' where `uid`='$uid'");
	}else{
		$sqs=$DB->exec("update `pre_user` set `email` ='{$email}' where `uid`='$uid'");
	}
	if($sqs!==false){
		exit('{"code":1,"msg":"succ"}');
	}else{
		exit('{"code":-1,"msg":"保存失败！'.$DB->error().'"}');
	}
break;
case 'checkbind':
	if($conf['verifytype']==1 && (empty($userrow['phone']) || strlen($userrow['phone'])!=11)){
		exit('{"code":1,"msg":"bind"}');
	}elseif($conf['verifytype']==0 && (empty($userrow['email']) || strpos($userrow['email'],'@')===false)){
		exit('{"code":1,"msg":"bind"}');
	}elseif(isset($_SESSION['verify_ok']) && $_SESSION['verify_ok']===$uid){
		exit('{"code":1,"msg":"bind"}');
	}else{
		exit('{"code":2,"msg":"need verify"}');
	}
break;
case 'resetKey':
	if(isset($_POST['submit'])){
		$key = random(32);
		$sql = "UPDATE pre_user SET `key`='$key' WHERE uid='$uid'";
		if($DB->exec($sql)!==false)exit('{"code":0,"msg":"重置密钥成功","key":"'.$key.'"}');
		else exit('{"code":-1,"msg":"重置密钥失败['.$DB->error().']"}');
	}
break;
case 'edit_pwd':
	$oldpwd=trim($_POST['oldpwd']);
	$newpwd=trim($_POST['newpwd']);
	$newpwd2=trim($_POST['newpwd2']);

	if(!empty($userrow['pwd']) && $oldpwd==null || $newpwd==null || $newpwd2==null){
		exit('{"code":-1,"msg":"请确保每项都不为空"}');
	}
	if(!empty($userrow['pwd']) && getMd5Pwd($oldpwd, $uid)!=$userrow['pwd']){
		exit('{"code":-1,"msg":"旧密码不正确"}');
	}
	if($newpwd!=$newpwd2){
		exit('{"code":-1,"msg":"两次输入密码不一致！"}');
	}
	if($oldpwd==$newpwd){
		exit('{"code":-1,"msg":"旧密码和新密码相同！"}');
	}
	if (strlen($newpwd) < 6) {
		exit('{"code":-1,"msg":"新密码不能低于6位"}');
	}elseif ($newpwd == $userrow['email']) {
		exit('{"code":-1,"msg":"新密码不能和邮箱相同"}');
	}elseif ($newpwd == $userrow['phone']) {
		exit('{"code":-1,"msg":"新密码不能和手机号码相同"}');
	}elseif (is_numeric($newpwd)) {
		exit('{"code":-1,"msg":"新密码不能为纯数字"}');
	}
	$pwd = getMd5Pwd($newpwd, $uid);
	$sqs=$DB->exec("update `pre_user` set `pwd` ='{$pwd}' where `uid`='$uid'");
	if($sqs!==false){
		exit('{"code":1,"msg":"修改密码成功！请牢记新密码"}');
	}else{
		exit('{"code":-1,"msg":"修改密码失败！'.$DB->error().'"}');
	}
break;
case 'edit_codename':
	$codename=daddslashes(htmlspecialchars(strip_tags(trim($_POST['codename']))));

	$sqs=$DB->exec("update `pre_user` set `codename` ='{$codename}' where `uid`='$uid'");
	if($sqs!==false){
		exit('{"code":1,"msg":"保存成功！"}');
	}else{
		exit('{"code":-1,"msg":"保存失败！'.$DB->error().'"}');
	}
break;
case 'certificate':
	$certname=daddslashes(htmlspecialchars(strip_tags(trim($_POST['certname']))));
	$certno=daddslashes(htmlspecialchars(strip_tags(trim($_POST['certno']))));
	if(!$_POST['csrf_token'] || $_POST['csrf_token']!=$_SESSION['csrf_token'])exit('{"code":-1,"msg":"CSRF TOKEN ERROR"}');
	if($userrow['cert']==1)exit('{"code":-1,"msg":"你已完成实名认证"}');
	if($conf['cert_money']>0 && $userrow['money']<$conf['cert_money'])exit('{"code":-1,"msg":"账户余额不足'.$conf['cert_money'].'元，无法完成认证"}');
	if(empty($certname) || empty($certno))exit('{"code":-1,"msg":"请确保各项不能为空"}');
	if(strlen($certname)<3)exit('{"code":-1,"msg":"姓名填写错误"}');
	if(!is_idcard($certno))exit('{"code":-1,"msg":"身份证号不正确"}');
	/*$row=$DB->getRow("SELECT uid,phone,email FROM pre_user WHERE certname='$certname' AND certno='$certno' AND cert=1 LIMIT 1");
	if($row){
		exit('{"code":-2,"msg":"账号:'.($row['phone']?$row['phone']:$row['email']).'(商户ID:'.$row['uid'].')已经使用此身份认证，是否将该认证信息关联到当前商户？关联需要输入商户ID '.$row['uid'].' 的商户密钥","uid":"'.$row['uid'].'"}');
	}*/
	$channel = \lib\Channel::get($conf['cert_channel']);
	if(!$channel)exit('{"code":-1,"msg":"当前实名认证通道信息不存在"}');
	define("IN_PLUGIN", true);
	define("PAY_ROOT", PLUGIN_ROOT.'alipay/');
	require_once PAY_ROOT."inc/AlipayCertifyService.php";
	$certify = new AlipayCertifyService($config);
	$outer_order_no = date("YmdHis").rand(000,999).$uid;
	$certifyResult = $certify->initialize($outer_order_no, $certname, $certno, 'SMART_FACE');
	if(isset($certifyResult['certify_id'])){
		$_SESSION[$uid.'_certify_id']=$certifyResult['certify_id'];
		$sqs=$DB->exec("update `pre_user` set `certno` ='{$certno}',`certname` ='{$certname}' where `uid`='$uid'");
		if($sqs!==false){
			exit('{"code":1,"msg":"succ","certify_id":"'.$certifyResult['certify_id'].'","url":"'.$siteurl.'user/alipaycert.php?id='.$certifyResult['certify_id'].'"}');
		}else{
			exit('{"code":-1,"msg":"保存信息失败'.$DB->error().'"}');
		}
	}else{
		exit('{"code":-1,"msg":"支付宝接口返回异常['.$certifyResult['sub_code'].']'.$certifyResult['sub_msg'].'"}');
	}
break;
case 'cert_query':
	$certify_id = isset($_POST['certify_id'])?$_POST['certify_id']:exit('{"code":-1,"msg":"param is error"}');
	if(!$_POST['csrf_token'] || $_POST['csrf_token']!=$_SESSION['csrf_token'])exit('{"code":-1,"msg":"CSRF TOKEN ERROR"}');
	if(isset($_SESSION[$uid.'_certify_id']) && $_SESSION[$uid.'_certify_id'] == $certify_id){
		$channel = \lib\Channel::get($conf['cert_channel']);
		if(!$channel)exit('{"code":-1,"msg":"当前实名认证通道信息不存在"}');
		define("IN_PLUGIN", true);
		define("PAY_ROOT", PLUGIN_ROOT.'alipay/');
		require_once PAY_ROOT."inc/AlipayCertifyService.php";
		$certify = new AlipayCertifyService($config);
		$certifyResult = $certify->query($certify_id);
		if(isset($certifyResult['passed'])){
			if($certifyResult['passed'] == 'T'){
				unset($_SESSION[$uid]['certify_id']);
				$DB->exec("update `pre_user` set `cert`=1,`certtime`='$date' where `uid`='$uid'");
				if($conf['cert_money']>0){
					changeUserMoney($uid, $conf['cert_money'], false, '实名认证');
				}
				exit('{"code":1,"msg":"succ","passed":true}');
			}else{
				exit('{"code":1,"msg":"succ","passed":false}');
			}
		}else{
			exit('{"code":-1,"msg":"支付宝接口返回异常['.$certifyResult['sub_code'].']'.$certifyResult['sub_msg'].'"}');
		}
	}else{
		exit('{"code":-1,"msg":"Access Denied"}');
	}
break;
/*case 'cert_bind':
	$touid=intval($_POST['touid']);
	$certname=daddslashes(htmlspecialchars(strip_tags(trim($_POST['certname']))));
	$certno=daddslashes(htmlspecialchars(strip_tags(trim($_POST['certno']))));
	if(!$_POST['csrf_token'] || $_POST['csrf_token']!=$_SESSION['csrf_token'])exit('{"code":-1,"msg":"CSRF TOKEN ERROR"}');
	if($userrow['cert']==1)exit('{"code":-1,"msg":"你已完成实名认证"}');
	if(empty($certname) || empty($certno))exit('{"code":-1,"msg":"请确保各项不能为空"}');
	if(strlen($certname)<3)exit('{"code":-1,"msg":"姓名填写错误"}');
	if(!is_idcard($certno))exit('{"code":-1,"msg":"身份证号不正确"}');
	$row=$DB->getRow("SELECT uid,certname,certno,cert FROM pre_user WHERE uid='$touid' LIMIT 1");
	if($row && $row['cert']==1 && $row['certname']==$certname && $row['certno']==$certno){
		$sqs=$DB->exec("update `pre_user` set `cert`='1',`certno`='{$certno}',`certname`='{$certname}',`certtime`='{$date}' where `uid`='$uid'");
		if($sqs!==false){
			exit('{"code":1,"msg":"关联实名认证成功！"}');
		}else{
			exit('{"code":-1,"msg":"关联实名认证失败！'.$DB->error().'"}');
		}
	}else{
		exit('{"code":-1,"msg":"关联实名认证失败！"}');
	}
break;*/
case 'notify':
	$trade_no=daddslashes(trim($_POST['trade_no']));
	$row=$DB->getRow("select * from pre_order where trade_no='$trade_no' AND uid=$uid limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前订单不存在！"}');
	if($row['status']==0)exit('{"code":-1,"msg":"订单尚未支付，无法重新通知！"}');
	$url=creat_callback_user($row,$userrow['key']);
	if($row['notify']>0)
		$DB->exec("update pre_order set notify=0 where trade_no='$trade_no'");
	exit('{"code":0,"url":"'.($_POST['isreturn']==1?$url['return']:$url['notify']).'"}');
break;
case 'settle_result':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_settle where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前结算记录不存在！"}');
	$result = ['code'=>0,'msg'=>$row['result']];
	exit(json_encode($result));
break;
case 'recharge':
	$money=trim(daddslashes($_POST['money']));
	$typeid=intval($_POST['typeid']);
	$name = '充值余额 UID:'.$uid;
	if(!$_POST['csrf_token'] || $_POST['csrf_token']!=$_SESSION['csrf_token'])exit('{"code":-1,"msg":"CSRF TOKEN ERROR"}');
	if($money<=0 || !is_numeric($money) || !preg_match('/^[0-9.]+$/', $money))exit('{"code":-1,"msg":"金额不合法"}');
	if($conf['pay_maxmoney']>0 && $money>$conf['pay_maxmoney'])exit('{"code":-1,"msg":"最大支付金额是'.$conf['pay_maxmoney'].'元"}');
	if($conf['pay_minmoney']>0 && $money<$conf['pay_minmoney'])exit('{"code":-1,"msg":"最小支付金额是'.$conf['pay_minmoney'].'元"}');
	$trade_no=date("YmdHis").rand(11111,99999);
	$return_url=$siteurl.'user/recharge.php?ok=1&trade_no='.$trade_no;
	$domain=getdomain($return_url);
	if(!$DB->exec("INSERT INTO `pre_order` (`trade_no`,`out_trade_no`,`uid`,`tid`,`addtime`,`name`,`money`,`notify_url`,`return_url`,`domain`,`ip`,`status`) VALUES (:trade_no, :out_trade_no, :uid, 2, NOW(), :name, :money, :notify_url, :return_url, :domain, :clientip, 0)", [':trade_no'=>$trade_no, ':out_trade_no'=>$trade_no, ':uid'=>$uid, ':name'=>$name, ':money'=>$money, ':notify_url'=>$return_url, ':return_url'=>$return_url, ':domain'=>$domain, ':clientip'=>$clientip]))exit('{"code":-1,"msg":"创建订单失败，请返回重试！"}');
	unset($_SESSION['csrf_token']);
	$result = ['code'=>0, 'msg'=>'succ', 'url'=>'../submit2.php?typeid='.$typeid.'&trade_no='.$trade_no];
	exit(json_encode($result));
break;
case 'groupinfo':
	$gid=intval($_POST['gid']);
	$row=$DB->getRow("select * from pre_group where gid='$gid' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前会员等级不存在！"}');
	if($row['isbuy']==0)
		exit('{"code":-1,"msg":"当前会员等级无法购买！"}');
	if($gid==$userrow['gid'])exit('{"code":-1,"msg":"你已购买此会员等级，请勿重复购买"}');
	if($row['expire']==0)$expire='永久';
	else $expire=$row['expire'].'个月';
	$result = ['code'=>0,'msg'=>'succ','gid'=>$gid,'name'=>$row['name'],'price'=>$row['price'],'expire'=>$expire];
	exit(json_encode($result));
break;
case 'groupbuy':
	$gid=intval($_POST['gid']);
	$row=$DB->getRow("select * from pre_group where gid='$gid' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前会员等级不存在！"}');
	if($row['isbuy']==0)
		exit('{"code":-1,"msg":"当前会员等级无法购买！"}');
	if($gid==$userrow['gid'])exit('{"code":-1,"msg":"你已购买此会员等级，请勿重复购买"}');
	if(!$_POST['csrf_token'] || $_POST['csrf_token']!=$_SESSION['csrf_token'])exit('{"code":-1,"msg":"CSRF TOKEN ERROR"}');
	$money = $row['price'];
	$typeid=intval($_POST['typeid']);
	if($typeid==0){
		if($money>$userrow['money'])exit('{"code":-1,"msg":"余额不足，请选择其他方式支付"}');
		changeUserMoney($uid, $money, false, '购买会员');
		changeUserGroup($uid, $gid);
		unset($_SESSION['csrf_token']);
		$result = ['code'=>1, 'msg'=>'购买会员成功！'];
		exit(json_encode($result));
	}else{
		$name = '购买会员 #'.$gid.'#';
		$trade_no=date("YmdHis").rand(11111,99999);
		$return_url=$siteurl.'user/groupbuy.php?ok=1&trade_no='.$trade_no;
		$domain=getdomain($return_url);
		if(!$DB->exec("INSERT INTO `pre_order` (`trade_no`,`out_trade_no`,`uid`,`tid`,`addtime`,`name`,`money`,`notify_url`,`return_url`,`domain`,`ip`,`status`) VALUES (:trade_no, :out_trade_no, :uid, 4, NOW(), :name, :money, :notify_url, :return_url, :domain, :clientip, 0)", [':trade_no'=>$trade_no, ':out_trade_no'=>$trade_no, ':uid'=>$uid, ':name'=>$name, ':money'=>$money, ':notify_url'=>$return_url, ':return_url'=>$return_url, ':domain'=>$domain, ':clientip'=>$clientip]))exit('{"code":-1,"msg":"创建订单失败，请返回重试！"}');
		unset($_SESSION['csrf_token']);
		$result = ['code'=>0, 'msg'=>'succ', 'url'=>'../submit2.php?typeid='.$typeid.'&trade_no='.$trade_no];
		exit(json_encode($result));
	}
break;
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}