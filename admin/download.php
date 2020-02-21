<?php
include("../includes/common.php");

if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$batch=$_GET['batch'];
$allmoney=$_GET['allmoney'];
$data='';
$rs=$DB->query("SELECT * from pre_settle where batch='$batch' order by type asc,id asc");

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

$i=0;
while($row = $rs->fetch())
{
	$i++;
	$data.=$i.','.display_type($row['type']).','.$row['account'].','.mb_convert_encoding($row['username'], "GB2312", "UTF-8").','.$row['money'].',彩虹易支付自动结算'."\r\n";
}

$date=date("Ymd");
$file="商户流水号,收款方式,收款账号,收款人姓名,付款金额（元）,付款理由\r\n";
$file.=$data;

$file_name='pay_'.date("YmdHis").'.csv';
$file_size=strlen($file);
header("Content-Description: File Transfer");
header("Content-Type:application/force-download");
header("Content-Length: {$file_size}");
header("Content-Disposition:attachment; filename={$file_name}");
echo $file;
?>