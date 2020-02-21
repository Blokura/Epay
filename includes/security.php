<?php
function x_real_ip(){
$ip = $_SERVER['REMOTE_ADDR'];
if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
	foreach ($matches[0] AS $xip) {
		if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
			$ip = $xip;
			break;
		}
	}
} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
	$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
} elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
	$ip = $_SERVER['HTTP_X_REAL_IP'];
}
return $ip;
}

function cc_defender(){
	$iptoken = md5(x_real_ip().date('Ymd')).md5(time().rand(11111,99999));
	if(!isset($_COOKIE['sec_defend']) || substr($_COOKIE['sec_defend'],0,32)!==substr($iptoken,0,32)){
		if(!$_COOKIE['sec_defend_time'])$_COOKIE['sec_defend_time']=0;
		$sec_defend_time=$_COOKIE['sec_defend_time']+1;
		$x = new \lib\hieroglyphy();
		$setCookie = $x->hieroglyphyString($iptoken);
		header('Content-type:text/html;charset=utf-8');
		if($sec_defend_time>=10)exit('浏览器不支持COOKIE或者不正常访问！');
		echo '<html><head><meta http-equiv="pragma" content="no-cache"><meta http-equiv="cache-control" content="no-cache"><meta http-equiv="content-type" content="text/html;charset=utf-8"><title>正在加载中</title><script>function setCookie(name,value){var exp = new Date();exp.setTime(exp.getTime() + 60*60*1000);document.cookie = name + "="+ escape (value).replace(/\+/g, \'%2B\') + ";expires=" + exp.toGMTString() + ";path=/";}function getCookie(name){var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");if(arr=document.cookie.match(reg))return unescape(arr[2]);else return null;}var sec_defend_time=getCookie(\'sec_defend_time\')||0;sec_defend_time++;setCookie(\'sec_defend\','.$setCookie.');setCookie(\'sec_defend_time\',sec_defend_time);if(sec_defend_time>1)window.location.href="./index.php";else window.location.reload();</script></head><body></body></html>';
		exit;
	}elseif(isset($_COOKIE['sec_defend_time'])){
		setcookie("sec_defend_time", "", time() - 604800, '/');
	}
}

@header("Cache-Control: no-store, no-cache, must-revalidate");
@header("Pragma: no-cache");
if($is_defend==true){
	if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')include_once(SYSTEM_ROOT."txprotect.php");
	cc_defender();
}
?>