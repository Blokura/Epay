<?php
error_reporting(0);
require '../config.php';

function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}

@header('Content-Type: text/html; charset=UTF-8');

try{
	$db=new PDO("mysql:host=".$dbconfig['host'].";dbname=".$dbconfig['dbname'].";port=".$dbconfig['port'],$dbconfig['user'],$dbconfig['pwd']);
}catch(Exception $e){
	exit('链接数据库失败:'.$e->getMessage());
}
date_default_timezone_set("PRC");
$date = date("Y-m-d");
$db->exec("set names utf8");

$version = 0;
if($rs = $db->query("SELECT v FROM pay_config WHERE k='version'")){
	$version = $rs->fetchColumn();
}

if($version<2001){
	$sqls = file_get_contents('update.sql');
	$sqls=explode(';', $sqls);
	$sqls[]="INSERT INTO `pay_config` VALUES ('syskey', '".random(32)."')";
	$sqls[]="INSERT INTO `pay_config` VALUES ('build', '".$date."')";
	$sqls[]="INSERT INTO `pay_config` VALUES ('cronkey', '".rand(111111,999999)."')";
	$sqls[]="INSERT INTO `pay_config` VALUES ('localurl', 'http://{$_SERVER['HTTP_HOST']}/')";
	$sqls[]="UPDATE `pay_config` SET `v` = '2001' where `v` = 'version'";
}else{
	exit('你的网站已经升级到最新版本了');
}
$success=0;$error=0;$errorMsg=null;
foreach ($sqls as $value) {
	$value=trim($value);
	if(!empty($value)){
		$value = str_replace('pre_',$dbconfig['dbqz'].'_',$value);
		if($db->exec($value)===false){
			$error++;
			$dberror=$db->errorInfo();
			$errorMsg.=$dberror[2]."<br>";
		}else{
			$success++;
		}
	}
}
echo '成功执行SQL语句'.$success.'条，失败'.$error.'条！<br/>';
if($errorMsg){
echo '<div class="alert alert-danger text-center" role="alert">'.$errorMsg.'</div>';
}
echo '<hr/><a href="/">点此返回首页</a>';
?>