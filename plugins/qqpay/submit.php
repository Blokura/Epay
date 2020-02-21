<?php
if(!defined('IN_PLUGIN'))exit();

if(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/')!==false && in_array('2',$channel['apptype'])){
	echo "<script>window.location.href='/pay/qqpay/jspay/{$trade_no}/';</script>";
}elseif(checkmobile()==true){
	echo "<script>window.location.href='/pay/qqpay/wap/{$trade_no}/?sitename={$sitename}';</script>";
}else{
	echo "<script>window.location.href='/pay/qqpay/qrcode/{$trade_no}/?sitename={$sitename}';</script>";
}
