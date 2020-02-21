<?php
include("../includes/common.php");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

if(strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])===false)exit('{"code":403}');

@header('Content-Type: application/json; charset=UTF-8');

switch($act){
case 'testpay':
	if(!$conf['test_open'])exit('{"code":-1,"msg":"未开启测试支付"}');
	$money=trim(daddslashes($_POST['money']));
	$typeid=intval($_POST['typeid']);
	$name = '支付测试';
	if(!$_POST['csrf_token'] || $_POST['csrf_token']!=$_SESSION['csrf_token'])exit('{"code":-1,"msg":"CSRF TOKEN ERROR"}');
	if($money<=0 || !is_numeric($money) || !preg_match('/^[0-9.]+$/', $money))exit('{"code":-1,"msg":"金额不合法"}');
	if($conf['pay_maxmoney']>0 && $money>$conf['pay_maxmoney'])exit('{"code":-1,"msg":"最大支付金额是'.$conf['pay_maxmoney'].'元"}');
	if($conf['pay_minmoney']>0 && $money<$conf['pay_minmoney'])exit('{"code":-1,"msg":"最小支付金额是'.$conf['pay_minmoney'].'元"}');
	$trade_no=date("YmdHis").rand(11111,99999);
	$return_url=$siteurl.'user/test.php?ok=1&trade_no='.$trade_no;
	$domain=getdomain($return_url);
	if(!$DB->exec("INSERT INTO `pre_order` (`trade_no`,`out_trade_no`,`uid`,`tid`,`addtime`,`name`,`money`,`notify_url`,`return_url`,`domain`,`ip`,`status`) VALUES (:trade_no, :out_trade_no, :uid, 3, NOW(), :name, :money, :notify_url, :return_url, :domain, :clientip, 0)", [':trade_no'=>$trade_no, ':out_trade_no'=>$trade_no, ':uid'=>$conf['test_pay_uid'], ':name'=>$name, ':money'=>$money, ':notify_url'=>$return_url, ':return_url'=>$return_url, ':domain'=>$domain, ':clientip'=>$clientip]))exit('{"code":-1,"msg":"创建订单失败，请返回重试！"}');
	$result = ['code'=>0, 'msg'=>'succ', 'url'=>'../submit2.php?typeid='.$typeid.'&trade_no='.$trade_no];
	exit(json_encode($result));
break;
case 'login':
	$type=intval($_POST['type']);
	$user=trim(daddslashes($_POST['user']));
	$pass=trim(daddslashes($_POST['pass']));
	if(empty($user) || empty($pass))exit('{"code":-1,"msg":"请确保各项不能为空"}');
	if(!$_POST['csrf_token'] || $_POST['csrf_token']!=$_SESSION['csrf_token'])exit('{"code":-1,"msg":"CSRF TOKEN ERROR"}');

	if($conf['captcha_open_login']==1){
		$GtSdk = new \lib\GeetestLib($conf['CAPTCHA_ID'], $conf['PRIVATE_KEY']);
		$data = array(
			'user_id' => 'public', # 网站用户id
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
	}

	if($type==1 && is_numeric($user) && strlen($user)<=6)$type=0;
	if($type==1){
		$userrow=$DB->getRow("SELECT * FROM pre_user WHERE email='{$user}' OR phone='{$user}' limit 1");
		$pass=getMd5Pwd($pass, $userrow['uid']);
	}else{
		$userrow=$DB->getRow("SELECT * FROM pre_user WHERE uid='{$user}' limit 1");
		if($userrow && $userrow['keylogin']==0){
			exit('{"code":-1,"msg":"该商户未开启密钥登录，请使用账号密码登录！"}');
		}
	}
	if($userrow && ($type==0 && $pass==$userrow['key'] || $type==1 && $pass==$userrow['pwd'])) {
		$uid = $userrow['uid'];
		if($user_id=$_SESSION['Oauth_alipay_uid']){
			$DB->exec("update `pre_user` set `alipay_uid` ='$user_id' where `uid`='$uid'");
			unset($_SESSION['Oauth_alipay_uid']);
		}
		if($qq_uid=$_SESSION['Oauth_qq_uid']){
			$DB->exec("update `pre_user` set `qq_uid` ='$qq_uid' where `uid`='$uid'");
			unset($_SESSION['Oauth_qq_uid']);
		}
		$city=get_ip_city($clientip);
		$DB->exec("insert into `pre_log` (`uid`,`type`,`date`,`ip`,`city`) values ('".$uid."','普通登录','".$date."','".$clientip."','".$city."')");
		$session=md5($uid.$userrow['key'].$password_hash);
		$expiretime=time()+604800;
		$token=authcode("{$uid}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
		ob_clean();
		setcookie("user_token", $token, time() + 604800);
		$DB->exec("update `pre_user` set `lasttime` ='$date' where `uid`='$uid'");
		if(empty($userrow['account']) || empty($userrow['username'])){
			$result=array("code"=>0,"msg"=>"登录成功！正在跳转到收款账号设置","url"=>"./editinfo.php?start=1");
		}else{
			$result=array("code"=>0,"msg"=>"登录成功！正在跳转到用户中心","url"=>"./");
		}
		unset($_SESSION['csrf_token']);
	}else {
		$result=array("code"=>-1,"msg"=>"用户名或密码不正确！");
	}
	exit(json_encode($result));
break;
case 'captcha':
	$GtSdk = new \lib\GeetestLib($conf['CAPTCHA_ID'], $conf['PRIVATE_KEY']);
	$data = array(
		'user_id' => isset($uid)?$uid:'public', # 网站用户id
		'client_type' => "web", # web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
		'ip_address' => $clientip # 请在此处传输用户请求验证时所携带的IP
	);
	$status = $GtSdk->pre_process($data, 1);
	$_SESSION['gtserver'] = $status;
	$_SESSION['user_id'] = isset($uid)?$uid:'public';
	echo $GtSdk->get_response_str();
break;
case 'sendcode':
	$sendto=daddslashes(htmlspecialchars(strip_tags(trim($_POST['sendto']))));
	if($conf['reg_open']==0)exit('{"code":-1,"msg":"未开放商户申请"}');
	if(isset($_SESSION['send_mail']) && $_SESSION['send_mail']>time()-10){
		exit('{"code":-1,"msg":"请勿频繁发送验证码"}');
	}

	$GtSdk = new \lib\GeetestLib($conf['CAPTCHA_ID'], $conf['PRIVATE_KEY']);

	$data = array(
		'user_id' => 'public', # 网站用户id
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
		$phone = $sendto;
		$row=$DB->getRow("select * from pre_user where phone='$phone' limit 1");
		if($row){
			exit('{"code":-1,"msg":"该手机号已经注册过商户，如需找回商户信息，请返回登录页面点击找回商户"}');
		}
		$row=$DB->getRow("select * from pre_regcode where `to`='$phone' order by id desc limit 1");
		if($row['time']>time()-60){
			exit('{"code":-1,"msg":"两次发送短信之间需要相隔60秒！"}');
		}
		$count=$DB->getColumn("select count(*) from pre_regcode where `to`='$phone' and time>'".(time()-3600*24)."'");
		if($count>2){
			exit('{"code":-1,"msg":"该手机号码发送次数过多，请更换号码！"}');
		}
		$count=$DB->getColumn("select count(*) from pre_regcode where ip='$clientip' and time>'".(time()-3600*24)."'");
		if($count>5){
			exit('{"code":-1,"msg":"你今天发送次数过多，已被禁止注册"}');
		}
		$code = rand(111111,999999);
		$result = send_sms($phone, $code, 'reg');
		if($result===true){
			if($DB->exec("insert into `pre_regcode` (`type`,`code`,`to`,`time`,`ip`,`status`) values ('1','".$code."','".$phone."','".time()."','".$clientip."','0')")){
				$_SESSION['send_mail']=time();
				exit('{"code":0,"msg":"succ"}');
			}else{
				exit('{"code":-1,"msg":"写入数据库失败。'.$DB->error().'"}');
			}
		}else{
			exit('{"code":-1,"msg":"短信发送失败 '.$result.'"}');
		}
	}else{
		$email = $sendto;
		$row=$DB->getRow("select * from pre_user where email='$email' limit 1");
		if($row){
			exit('{"code":-1,"msg":"该邮箱已经注册过商户，如需找回商户信息，请返回登录页面点击找回商户"}');
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
			exit('{"code":-1,"msg":"你今天发送次数过多，已被禁止注册"}');
		}
		$sub = $conf['sitename'].' - 验证码获取';
		$code = rand(1111111,9999999);
		$msg = '您的验证码是：'.$code;
		$result = send_mail($email, $sub, $msg);
		if($result===true){
			if($DB->exec("insert into `pre_regcode` (`type`,`code`,`to`,`time`,`ip`,`status`) values ('0','".$code."','".$email."','".time()."','".$clientip."','0')")){
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
case 'reg':
	if($conf['reg_open']==0)exit('{"code":-1,"msg":"未开放商户申请"}');
	$email=daddslashes(htmlspecialchars(strip_tags(trim($_POST['email']))));
	$phone=daddslashes(htmlspecialchars(strip_tags(trim($_POST['phone']))));
	$code=trim(daddslashes($_POST['code']));
	$pwd=trim(daddslashes($_POST['pwd']));

	if(isset($_SESSION['reg_submit']) && $_SESSION['reg_submit']>time()-600){
		exit('{"code":-1,"msg":"请勿频繁注册"}');
	}
	if($conf['verifytype']==1 && empty($phone) || $conf['verifytype']==0 && empty($email) || empty($code) || empty($pwd)){
		exit('{"code":-1,"msg":"请确保各项不能为空"}');
	}
	if(!$_POST['csrf_token'] || $_POST['csrf_token']!=$_SESSION['csrf_token'])exit('{"code":-1,"msg":"CSRF TOKEN ERROR"}');
	if (strlen($pwd) < 6) {
		exit('{"code":-1,"msg":"密码不能低于6位"}');
	}elseif ($pwd == $email) {
		exit('{"code":-1,"msg":"密码不能和邮箱相同"}');
	}elseif ($pwd == $phone) {
		exit('{"code":-1,"msg":"密码不能和手机号码相同"}');
	}elseif (is_numeric($pwd)) {
		exit('{"code":-1,"msg":"密码不能为纯数字"}');
	}
	if($conf['verifytype']==1){
		if(!is_numeric($phone) || strlen($phone)!=11){
			exit('{"code":-1,"msg":"手机号码不正确"}');
		}
		$row=$DB->getRow("select * from pre_user where phone='$phone' limit 1");
		if($row){
			exit('{"code":-1,"msg":"该手机号已经注册过商户，如需找回商户信息，请返回登录页面点击找回商户"}');
		}
	}else{
		if(!preg_match('/^[A-z0-9._-]+@[A-z0-9._-]+\.[A-z0-9._-]+$/', $email)){
			exit('{"code":-1,"msg":"邮箱格式不正确"}');
		}
		$row=$DB->getRow("select * from pre_user where email='$email' limit 1");
		if($row){
			exit('{"code":-1,"msg":"该邮箱已经注册过商户，如需找回商户信息，请返回登录页面点击找回商户"}');
		}
	}
	if($conf['verifytype']==1){
		$row=$DB->getRow("select * from pre_regcode where type=1 and code='$code' and `to`='$phone' order by id desc limit 1");
	}else{
		$row=$DB->getRow("select * from pre_regcode where type=0 and code='$code' and `to`='$email' order by id desc limit 1");
	}
	if(!$row){
		exit('{"code":-1,"msg":"验证码不正确！"}');
	}
	if($row['time']<time()-3600 || $row['status']>0){
		exit('{"code":-1,"msg":"验证码已失效，请重新获取"}');
	}
	if($conf['reg_pay']==1){
		$gid = $DB->getColumn("SELECT gid FROM pre_user WHERE uid='{$conf['reg_pay_uid']}' limit 1");
		if($gid===false)exit('{"code":-1,"msg":"注册收款商户ID不存在"}');
		$return_url = $siteurl.'user/reg.php?regok=1';
		$trade_no=date("YmdHis").rand(11111,99999);
		$domain=getdomain($return_url);
		if(!$DB->exec("INSERT INTO `pre_order` (`trade_no`,`out_trade_no`,`uid`,`tid`,`addtime`,`name`,`money`,`notify_url`,`return_url`,`domain`,`ip`,`status`) VALUES (:trade_no, :out_trade_no, :uid, 1, NOW(), :name, :money, :notify_url, :return_url, :domain, :clientip, 0)", [':trade_no'=>$trade_no, ':out_trade_no'=>$trade_no, ':uid'=>$conf['reg_pay_uid'], ':name'=>'商户申请', ':money'=>$conf['reg_pay_price'], ':notify_url'=>$return_url, ':return_url'=>$return_url, ':domain'=>$domain, ':clientip'=>$clientip]))
			exit('{"code":-1,"msg":"创建订单失败，请返回重试！"}');

		$cacheData = ['verifytype'=>$conf['verifytype'], 'email'=>$email, 'phone'=>$phone, 'pwd'=>$pwd, 'addtime'=>$date, 'codeid'=>$row['id']];
		$sds = $CACHE->save('reg_'.$trade_no ,$cacheData, time()+3600);
		if($sds){
			$paytype = \lib\Channel::getTypes($gid);
			$result=array("code"=>2,"msg"=>"订单创建成功！","trade_no"=>$trade_no,"need"=>$conf['reg_pay_price'],"paytype"=>$paytype);
			unset($_SESSION['csrf_token']);
		}else{
			$result=array("code"=>-1,"msg"=>"订单创建失败！".$DB->error());
		}
	}else{
		$key = random(32);
		$sds=$DB->exec("INSERT INTO `pre_user` (`key`, `money`, `email`, `phone`, `addtime`, `pay`, `settle`, `keylogin`, `apply`, `status`) VALUES (:key, '0.00', :email, :phone, NOW(), 1, 1, 0, 0, 1)", [':key'=>$key, ':email'=>$email, ':phone'=>$phone]);
		$uid=$DB->lastInsertId();
		if($sds){
			$pwd = getMd5Pwd($pwd, $uid);
			$DB->exec("update `pre_user` set `pwd` ='{$pwd}' where `uid`='$uid'");
			if(!empty($email)){
				$sub = $conf['sitename'].' - 注册成功通知';
				$msg = '<h2>商户注册成功通知</h2>感谢您注册'.$conf['sitename'].'！<br/>您的登录账号：'.($info['email']?$info['email']:$info['phone']).'<br/>您的商户ID：'.$uid.'<br/>您的商户秘钥：'.$key.'<br/>'.$conf['sitename'].'官网：<a href="http://'.$_SERVER['HTTP_HOST'].'/" target="_blank">'.$_SERVER['HTTP_HOST'].'</a><br/>【<a href="'.$siteurl.'user/" target="_blank">商户管理后台</a>】';
				$result = send_mail($email, $sub, $msg);
			}
			$DB->exec("update `pre_regcode` set `status` ='1' where `id`='{$row['id']}'");
			$_SESSION['reg_submit']=time();
			$result=array("code"=>1,"msg"=>"申请商户成功！","uid"=>$uid,"key"=>$key);
			unset($_SESSION['csrf_token']);
		}else{
			$result=array("code"=>-1,"msg"=>"申请商户失败！".$DB->error());
		}
	}
	exit(json_encode($result));
break;
case 'sendcode2':
	$verifytype=$_POST['type'];
	$sendto=daddslashes(htmlspecialchars(strip_tags(trim($_POST['sendto']))));
	if(isset($_SESSION['send_mail']) && $_SESSION['send_mail']>time()-10){
		exit('{"code":-1,"msg":"请勿频繁发送验证码"}');
	}

	$GtSdk = new \lib\GeetestLib($conf['CAPTCHA_ID'], $conf['PRIVATE_KEY']);

	$data = array(
		'user_id' => 'public', # 网站用户id
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

	if($verifytype=='phone'){
		$phone = $sendto;
		$userrow=$DB->getRow("select * from pre_user where phone='$phone' limit 1");
		if(!$userrow){
			exit('{"code":-1,"msg":"该手机号未找到注册商户"}');
		}
		$row=$DB->getRow("select * from pre_regcode where `to`='$phone' order by id desc limit 1");
		if($row['time']>time()-60){
			exit('{"code":-1,"msg":"两次发送短信之间需要相隔60秒！"}');
		}
		$count=$DB->getColumn("select count(*) from pre_regcode where `to`='$phone' and time>'".(time()-3600*24)."'");
		if($count>2){
			exit('{"code":-1,"msg":"该手机号码发送次数过多，请更换号码！"}');
		}
		$count=$DB->getColumn("select count(*) from pre_regcode where ip='$clientip' and time>'".(time()-3600*24)."'");
		if($count>5){
			exit('{"code":-1,"msg":"你今天发送次数过多，已被禁止找回密码"}');
		}
		$code = rand(111111,999999);
		$result = send_sms($phone, $code, 'find');
		if($result===true){
			if($DB->exec("insert into `pre_regcode` (`uid`,`type`,`code`,`to`,`time`,`ip`,`status`) values ('".$userrow['uid']."','5','".$code."','".$phone."','".time()."','".$clientip."','0')")){
				$_SESSION['send_mail']=time();
				exit('{"code":0,"msg":"succ"}');
			}else{
				exit('{"code":-1,"msg":"写入数据库失败。'.$DB->error().'"}');
			}
		}else{
			exit('{"code":-1,"msg":"短信发送失败 '.$result.'"}');
		}
	}else{
		$email = $sendto;
		$userrow=$DB->getRow("select * from pre_user where email='$email' limit 1");
		if(!$userrow){
			exit('{"code":-1,"msg":"该邮箱未找到注册商户"}');
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
			exit('{"code":-1,"msg":"你今天发送次数过多，已被禁止找回密码"}');
		}
		$sub = $conf['sitename'].' - 重置密码验证';
		$code = rand(1111111,9999999);
		$msg = '您的验证码是：'.$code.'，用于'.$conf['sitename'].'重置密码，请勿泄露验证码，如非本人操作请忽略。';
		$result = send_mail($email, $sub, $msg);
		if($result===true){
			if($DB->exec("insert into `pre_regcode` (`uid`,`type`,`code`,`to`,`time`,`ip`,`status`) values ('".$userrow['uid']."','4','".$code."','".$email."','".time()."','".$clientip."','0')")){
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
case 'findpwd':
	$verifytype=$_POST['type'];
	$account=daddslashes(htmlspecialchars(strip_tags(trim($_POST['account']))));
	$code=trim(daddslashes($_POST['code']));
	$pwd=trim(daddslashes($_POST['pwd']));

	if(empty($account) || empty($code) || empty($pwd)){
		exit('{"code":-1,"msg":"请确保各项不能为空"}');
	}
	if(!$_POST['csrf_token'] || $_POST['csrf_token']!=$_SESSION['csrf_token'])exit('{"code":-1,"msg":"CSRF TOKEN ERROR"}');
	if (strlen($pwd) < 6) {
		exit('{"code":-1,"msg":"密码不能低于6位"}');
	}elseif ($pwd == $account && $verifytype=='email') {
		exit('{"code":-1,"msg":"密码不能和邮箱相同"}');
	}elseif ($pwd == $account && $verifytype=='phone') {
		exit('{"code":-1,"msg":"密码不能和手机号码相同"}');
	}elseif (is_numeric($pwd)) {
		exit('{"code":-1,"msg":"密码不能为纯数字"}');
	}
	if($verifytype=='phone'){
		if(!is_numeric($account) || strlen($account)!=11){
			exit('{"code":-1,"msg":"手机号码不正确"}');
		}
		$userrow=$DB->getRow("select * from pre_user where phone='$account' limit 1");
		if(!$userrow){
			exit('{"code":-1,"msg":"该手机号未找到注册商户"}');
		}
	}else{
		if(!preg_match('/^[A-z0-9._-]+@[A-z0-9._-]+\.[A-z0-9._-]+$/', $account)){
			exit('{"code":-1,"msg":"邮箱格式不正确"}');
		}
		$userrow=$DB->getRow("select * from pre_user where email='$account' limit 1");
		if(!$userrow){
			exit('{"code":-1,"msg":"该邮箱未找到注册商户"}');
		}
	}
	if($verifytype=='phone'){
		$row=$DB->getRow("select * from pre_regcode where type=5 and code='$code' and `to`='$account' order by id desc limit 1");
	}else{
		$row=$DB->getRow("select * from pre_regcode where type=4 and code='$code' and `to`='$account' order by id desc limit 1");
	}
	if(!$row){
		exit('{"code":-1,"msg":"验证码不正确！"}');
	}
	if($row['time']<time()-3600 || $row['status']>0){
		exit('{"code":-1,"msg":"验证码已失效，请重新获取"}');
	}

	$pwd = getMd5Pwd($pwd, $userrow['uid']);
	$sqs=$DB->exec("update `pre_user` set `pwd` ='{$pwd}' where `uid`='{$userrow['uid']}'");
	if($sqs!==false){
		exit('{"code":1,"msg":"重置密码成功！请牢记新密码"}');
	}else{
		exit('{"code":-1,"msg":"重置密码失败！'.$DB->error().'"}');
	}
break;
case 'qrcode':
	unset($_SESSION['openid']);
	if(!empty($conf['localurl_wxpay']) && !strpos($conf['localurl_wxpay'],$_SERVER['HTTP_HOST'])){
		$qrcode = $conf['localurl_wxpay'].'user/openid.php?sid='.session_id();
	}else{
		$qrcode = $siteurl.'user/openid.php?sid='.session_id();
	}
	$result=array("code"=>0,"msg"=>"succ","url"=>$qrcode);
	exit(json_encode($result));
	break;
case 'getopenid':
	if(isset($_SESSION['openid']) && !empty($_SESSION['openid'])){
		$result=array("code"=>0,"msg"=>"succ","openid"=>$_SESSION['openid']);
	}else{
		$result=array("code"=>-1);
	}
	exit(json_encode($result));
	break;
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}