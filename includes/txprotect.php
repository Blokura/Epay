<?php
/*
反腾讯网址安全检测系统
Description:屏蔽腾讯电脑管家网址安全检测
Author:消失的彩虹海
*/
if($nosecu==true)return;
//IP屏蔽
$iptables='236000768~236001023|992312699|3419245824~3419246079|1728519168~1728520191';
$remoteiplong=bindec(decbin(ip2long(x_real_ip())));
foreach(explode('|',$iptables) as $iprows){
	if($remoteiplong==$iprows)exit('欢迎使用！');
	$ipbanrange=explode('~',$iprows);
	if($remoteiplong>=$ipbanrange[0] && $remoteiplong<=$ipbanrange[1])
		exit('欢迎使用！');
}
if(strpos($_SERVER['HTTP_REFERER'], 'urls.tr.com')!==false||strpos($_SERVER['HTTP_REFERER'], 'sc.wsd.com')!==false){
	$_SESSION['txprotectblock']=true;
}
//HEADER特征屏蔽
if(!isset($_SERVER['HTTP_ACCEPT']) || preg_match("/manager/", strtolower($_SERVER['HTTP_USER_AGENT'])) || isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']=='' || strpos($_SERVER['HTTP_USER_AGENT'], 'ozilla')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla')===false || preg_match("/Windows NT 6.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*' || preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*' || preg_match("/vnd.wap.wml/", $_SERVER['HTTP_ACCEPT']) && preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_REFERER'], 'urls.tr.com')!==false || strpos($_SERVER['HTTP_REFERER'], 'sc.wsd.com')!==false || strpos($_SERVER['HTTP_REFERER'], '/membercomprehensive/')!==false || strpos($_SERVER['HTTP_REFERER'], '111.202.27.196')!==false || isset($_COOKIE['ASPSESSIONIDQASBQDRC']) || empty($_SERVER['HTTP_USER_AGENT']) || preg_match("/Alibaba.Security.Heimdall/", $_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_USER_AGENT'], 'wechatdevtools/')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'libcurl/')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'python')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'Go-http-client')!==false || $_SESSION['txprotectblock']==true) {
	exit('欢迎使用！');
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Coolpad Y82-520')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'Mac OS X 10_12_4')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'Baiduspider/')===false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'Android')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'Baiduspider/')===false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'en')!==false && strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'zh')===false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'en-')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'zh')===false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS 9_1')!==false && $_SERVER['HTTP_CONNECTION']=='close') {
	exit('您当前浏览器不支持或操作系统语言设置非中文，无法访问本站！');
}