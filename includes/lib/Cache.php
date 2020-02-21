<?php
namespace lib;

class Cache {
	public function get($key) {
		global $_CACHE;
		return $_CACHE[$key];
	}
	public function read($key = 'config') {
		global $DB;
		$value = $DB->getColumn("SELECT v FROM pre_cache WHERE k=:key LIMIT 1", [':key'=>$key]);
		return $value;
	}
	public function save($key ,$value, $expire=0) {
		if (is_array($value)) $value = serialize($value);
		global $DB;
		return $DB->exec("REPLACE INTO pre_cache VALUES (:key, :value, :expire)", [':key'=>$key, ':value'=>$value, ':expire'=>$expire]);
	}
	public function pre_fetch(){
		global $_CACHE;
		$_CACHE=array();
		$cache = $this->read('config');
		$_CACHE = @unserialize($cache);
		if(empty($_CACHE['version']))$_CACHE = $this->update();
		return $_CACHE;
	}
	public function update() {
		global $DB;
		$cache = array();
		$result = $DB->getAll("SELECT * FROM pre_config");
		foreach($result as $row){
			$cache[ $row['k'] ] = $row['v'];
		}
		$this->save('config', $cache);
		return $cache;
	}
	public function clear($key = 'config') {
		global $DB;
		return $DB->exec("UPDATE pre_cache SET v='' WHERE k=:key", [':key'=>$key]);
	}
	public function clean() {
		global $DB;
		return $DB->exec("DELETE FROM pre_cache WHERE expire>0 AND expire<'".time()."'");
	}
}
