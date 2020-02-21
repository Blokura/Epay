<?php
namespace lib;

class Plugin {

	static public function getList(){
		$dir = PLUGIN_ROOT;
		$dirArray[] = NULL;
		if (false != ($handle = opendir($dir))) {
			$i = 0;
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && strpos($file, ".")===false) {
					$dirArray[$i] = $file;
					$i++;
				}
			}
			closedir($handle);
		}
		return $dirArray;
	}

	static public function getConfig($name){
		$filename = PLUGIN_ROOT.$name.'/config.ini';
		if(file_exists($filename)){
			return parse_ini_file($filename);
		}else{
			return false;
		}
	}

	static public function load($s){
		if(preg_match('/^(.[a-zA-Z0-9]+)\/(.[a-zA-Z0-9]+)\/(.[0-9]+)\/$/',$s, $matchs)){
			$filename = PLUGIN_ROOT.$matchs[1].'/'.$matchs[2].'.php';
			if(file_exists($filename)){
				define("IN_PLUGIN", true);
				define("PAY_ROOT", PLUGIN_ROOT.$matchs[1].'/');
				define("TRADE_NO", $matchs[3]);
				define("PAY_PLUGIN", $matchs[1]);
				return $filename;
			}else{
				exit('Pay file not found');
			}
		}else{
			exit('error');
		}
	}

	static public function load2($plugin, $page, $trade_no){
		if(preg_match('/^(.[a-zA-Z0-9]+)$/',$plugin) && preg_match('/^(.[a-zA-Z0-9]+)$/',$page) && preg_match('/^(.[0-9]+)$/',$trade_no)){
			$filename = PLUGIN_ROOT.$plugin.'/'.$page.'.php';
			if(file_exists($filename)){
				define("IN_PLUGIN", true);
				define("PAY_ROOT", PLUGIN_ROOT.$plugin.'/');
				define("TRADE_NO", $trade_no);
				define("PAY_PLUGIN", $plugin);
				return $filename;
			}else{
				exit('Pay file not found');
			}
		}else{
			exit('error');
		}
	}

	static public function exists($name){
		$filename = PLUGIN_ROOT.$name.'/config.ini';
		if(file_exists($filename)){
			return true;
		}else{
			return false;
		}
	}

	static public function isrefund($name){
		$filename = PLUGIN_ROOT.$name.'/refund.php';
		if(file_exists($filename)){
			return true;
		}else{
			return false;
		}
	}

	static public function refund($plugin, $trade_no){
		if(preg_match('/^(.[a-zA-Z0-9]+)$/',$plugin) && preg_match('/^(.[0-9]+)$/',$trade_no)){
			$filename = PLUGIN_ROOT.$plugin.'/refund.php';
			if(file_exists($filename)){
				define("IN_REFUND", true);
				define("PAY_ROOT", PLUGIN_ROOT.$plugin.'/');
				define("TRADE_NO", $trade_no);
				define("PAY_PLUGIN", $plugin);
				return $filename;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	static public function updateAll(){
		global $DB;
		$DB->exec("TRUNCATE TABLE pre_plugin");
		$list = self::getList();
		foreach($list as $name){
			if($config = self::getConfig($name)){
				if($config['name']!=$name)continue;
				$DB->exec("INSERT INTO pre_plugin VALUES (:name, :showname, :author, :link, :types, :inputs, :select)", [':name'=>$config['name'], ':showname'=>$config['showname'], ':author'=>$config['author'], ':link'=>$config['link'], ':types'=>$config['types'], ':inputs'=>$config['inputs'], ':select'=>$config['select']]);
			}
		}
		return true;
	}

	static public function get($name){
		global $DB;
		$result = $DB->getRow("SELECT * FROM pre_plugin WHERE name='$name'");
		return $result;
	}

	static public function getAll(){
		global $DB;
		$result = $DB->getAll("SELECT * FROM pre_plugin");
		return $result;
	}
}
