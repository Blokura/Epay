<?php
$nosession = true;
require './includes/common.php';

$type=isset($_GET['type'])?daddslashes($_GET['type']):exit('No type!');
$trade_no=isset($_GET['trade_no'])?daddslashes($_GET['trade_no']):exit('No trade_no!');

@header('Content-Type: text/html; charset=UTF-8');

$row=$DB->getRow("SELECT * FROM ".DBQZ."_order WHERE trade_no='{$trade_no}' limit 1");
if($row['status']>=1){
	$url=creat_callback($row);
	exit('{"code":1,"msg":"付款成功","backurl":"'.$url['return'].'"}');
}else{
	exit('{"code":-1,"msg":"未付款"}');
}

?>