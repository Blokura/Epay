<?php
namespace lib;

class Template {

	static public function getList(){
		$dir = TEMPLATE_ROOT;
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

	static public function load($name = 'index'){
		global $conf;
		$template = $conf['template']?$conf['template']:'default';
		if(!preg_match('/^[a-zA-Z0-9]+$/',$name))exit('error');
		$filename = TEMPLATE_ROOT.$template.'/'.$name.'.php';
		$filename_default = TEMPLATE_ROOT.'default/'.$name.'.php';
		if(file_exists($filename)){
			define("INDEX_ROOT",TEMPLATE_ROOT.$template.'/');
			define("STATIC_ROOT",'/template/'.$template.'/assets/');
			return $filename;
		}elseif(file_exists($filename_default)){
			define("INDEX_ROOT",TEMPLATE_ROOT.'default/');
			define("STATIC_ROOT",'/template/default/assets/');
			return $filename_default;
		}else{
			exit('Template file not found');
		}
	}

	static public function exists($template){
		$filename = TEMPLATE_ROOT.$template.'/index.php';
		if(file_exists($filename)){
			return true;
		}else{
			return false;
		}
	}
}
