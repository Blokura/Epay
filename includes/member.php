<?php
$clientip=real_ip($conf['ip_type']?$conf['ip_type']:0);

if(isset($_COOKIE["admin_token"]))
{
	$token=authcode(daddslashes($_COOKIE['admin_token']), 'DECODE', SYS_KEY);
	list($user, $sid, $expiretime) = explode("\t", $token);
	$session=md5($conf['admin_user'].$conf['admin_pwd'].$password_hash);
	if($session==$sid && $expiretime>time()) {
		$islogin=1;
	}
}
if(isset($_COOKIE["user_token"]))
{
	$token=authcode(daddslashes($_COOKIE['user_token']), 'DECODE', SYS_KEY);
	list($uid, $sid, $expiretime) = explode("\t", $token);
	$uid = intval($uid);
	$userrow=$DB->getRow("SELECT * FROM pay_user WHERE uid='{$uid}' limit 1");
	$session=md5($userrow['uid'].$userrow['key'].$password_hash);
	if($session==$sid && $expiretime>time()) {
		$islogin2=1;
	}
}
?>