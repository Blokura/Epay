<?php
if(!defined('IN_PLUGIN'))exit();

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
	if(!empty($conf['localurl_wxpay']) && !strpos($conf['localurl_wxpay'],$_SERVER['HTTP_HOST'])){
		echo "<script>window.location.href='{$conf['localurl_alipay']}pay/wxpay/jspay/{$trade_no}/?d=1';</script>";exit;
	}
	echo "<script>window.location.href='/pay/wxpay/jspay/{$trade_no}/?d=1';</script>";
}elseif(checkmobile()==true){
	if(in_array('3',$channel['apptype'])){
		if(!empty($conf['localurl_wxpay']) && !strpos($conf['localurl_wxpay'],$_SERVER['HTTP_HOST'])){
			echo "<script>window.location.href='{$conf['localurl_alipay']}pay/wxpay/h5/{$trade_no}/';</script>";exit;
		}
		echo "<script>window.location.href='/pay/wxpay/h5/{$trade_no}/';</script>";
	}elseif(in_array('2',$channel['apptype'])){
		if(!empty($conf['localurl_wxpay']) && !strpos($conf['localurl_wxpay'],$_SERVER['HTTP_HOST'])){
			echo "<script>window.location.href='{$conf['localurl_alipay']}pay/wxpay/wap/{$trade_no}/';</script>";exit;
		}
		echo "<script>window.location.href='/pay/wxpay/wap/{$trade_no}/?sitename={$sitename}';</script>";
	}else{
		echo "<script>window.location.href='/pay/wxpay/qrcode/{$trade_no}/?sitename={$sitename}';</script>";
	}
}else{
	echo "<script>window.location.href='/pay/wxpay/qrcode/{$trade_no}/?sitename={$sitename}';</script>";
}
