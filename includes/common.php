<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(defined('IN_CRONLITE'))return;
define('IN_CRONLITE', true);
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');
define('TEMPLATE_ROOT', ROOT.'template/');
define('PLUGIN_ROOT', ROOT.'plugins/');
date_default_timezone_set('Asia/Shanghai');
$date = date("Y-m-d H:i:s");

if(!$nosession)session_start();

$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].'/';

if(is_file(SYSTEM_ROOT.'360safe/360webscan.php')){//360网站卫士
//    require_once(SYSTEM_ROOT.'360safe/360webscan.php');
}

include_once(SYSTEM_ROOT."autoloader.php");
Autoloader::register();

include_once(SYSTEM_ROOT."security.php");

require ROOT.'config.php';
define('DBQZ', $dbconfig['dbqz']);

if(!$dbconfig['user']||!$dbconfig['pwd']||!$dbconfig['dbname'])//检测安装1
{
header('Content-type:text/html;charset=utf-8');
echo '你还没安装！<a href="/install/">点此安装</a>';
exit();
}

$DB = new \lib\PdoHelper($dbconfig);

if($DB->query("select * from pre_config where 1")==FALSE)//检测安装2
{
header('Content-type:text/html;charset=utf-8');
echo '你还没安装！<a href="/install/">点此安装</a>';
exit();
}


$CACHE=new \lib\Cache();
$conf=$CACHE->pre_fetch();
define('SYS_KEY', $conf['syskey']);
if(!$conf['localurl'])$conf['localurl'] = $siteurl;
$password_hash='!@#%!s!0';

include_once(SYSTEM_ROOT."functions.php");
include_once(SYSTEM_ROOT."member.php");

if (!file_exists(ROOT.'install/install.lock') && file_exists(ROOT.'install/index.php')) {
	sysmsg('<h2>检测到无 install.lock 文件</h2><ul><li><font size="4">如果您尚未安装本程序，请<a href="./install/">前往安装</a></font></li><li><font size="4">如果您已经安装本程序，请手动放置一个空的 install.lock 文件到 /install 文件夹下，<b>为了您站点安全，在您完成它之前我们不会工作。</b></font></li></ul><br/><h4>为什么必须建立 install.lock 文件？</h4>它是安装保护文件，如果检测不到它，就会认为站点还没安装，此时任何人都可以安装/重装你的网站。<br/><br/>');exit;
}
?>