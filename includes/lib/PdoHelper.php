<?php
namespace lib;

class PdoHelper
{
	private $sqlPrefix = "pre_";//SQL数据表前缀识别字符
	private $db;
	private $fetchStyle = \PDO::FETCH_ASSOC;
	private $prefix;

	/**
	 * PdoHelper constructor.
	 *
	 * @param array $dbconfig 数据库信息
	 */
	function __construct($dbconfig)
	{
		$this->prefix = $dbconfig['dbqz'].'_';
		try {
			$this->db = new \PDO("mysql:host={$dbconfig['host']};dbname={$dbconfig['dbname']};port={$dbconfig['port']}",$dbconfig['user'],$dbconfig['pwd']);
		} catch (Exception $e) {
			exit('链接数据库失败:' . $e->getMessage());
		}
		$this->db->exec("set sql_mode = ''");
		$this->db->exec("set names utf8");
	}

	/**
	 * 设置结果集方式
	 *
	 * @param string $_style
	 */
	public function setFetchStyle($_style)
	{
		$this->fetchStyle = $_style;
	}

	/**
	 * 替换数据表前缀
	 * @param $_sql
	 *
	 * @return mixed
	 */
	private function dealPrefix($_sql){
		return str_replace($this->sqlPrefix,$this->prefix,$_sql);
	}

	/**
	 * 获取PDOStatement
	 * @param string $_sql
	 * @param array $_array
	 *
	 * @return \PDOStatement
	 */
	public function query($_sql, $_array = null)
	{
		$_sql = $this->dealPrefix($_sql);
		if (is_array($_array)) {
			$stmt = $this->db->prepare($_sql);
			if($stmt) $stmt->execute($_array);
		} else {
			$stmt = $this->db->query($_sql);
		}
		return $stmt;
	}

	/**
	 * 查询一条结果
	 *
	 * @param string $_sql string
	 * @param array $_array array
	 *
	 * @return mixed
	 */
	public function getRow($_sql, $_array = null)
	{
		$_sql = $this->dealPrefix($_sql);
		if (is_array($_array)) {
			$stmt = $this->db->prepare($_sql);
			if($stmt) $stmt->execute($_array);
		} else {
			$stmt = $this->db->query($_sql);
		}
		if($stmt) {
			return $stmt->fetch($this->fetchStyle);
		}else{
			return false;
		}
	}

	/**
	 * 获取所有结果
	 *
	 * @param string $_sql
	 * @param array $_array
	 *
	 * @return array
	 */
	public function getAll($_sql, $_array = null)
	{
		$_sql = $this->dealPrefix($_sql);
		if (is_array($_array)) {
			$stmt = $this->db->prepare($_sql);
			if($stmt) $stmt->execute($_array);
		} else {
			$stmt = $this->db->query($_sql);
		}
		if($stmt) {
			return $stmt->fetchAll($this->fetchStyle);
		}else{
			return false;
		}
	}

	/**
	 * 获取结果数
	 * @param string $_sql
	 * @param array $_array
	 *
	 * @return int
	 */
	public function getCount($_sql, $_array = null)
	{
		$_sql = $this->dealPrefix($_sql);
		$stmt = $this->db->prepare($_sql);
		if($stmt) {
			$stmt->execute($_array);
			return $stmt->rowCount();
		}else{
			return false;
		}
	}

	/**
	 * 获取一个字段值
	 * @param string $_sql
	 * @param array $_array
	 *
	 * @return int
	 */
	public function getColumn($_sql, $_array = null)
	{
		$_sql = $this->dealPrefix($_sql);
		if (is_array($_array)) {
			$stmt = $this->db->prepare($_sql);
			if($stmt) $stmt->execute($_array);
		} else {
			$stmt = $this->db->query($_sql);
		}
		if($stmt) {
			return $stmt->fetchColumn();
		}else{
			return false;
		}
	}

	/**
	 * 执行语句
	 * @param string $_sql
	 * @param array $_array
	 *
	 * @return int|\PDOStatement
	 */
	public function exec($_sql, $_array = null)
	{
		$_sql = $this->dealPrefix($_sql);
		if (is_array($_array)) {
			$stmt = $this->db->prepare($_sql);
			if($stmt) {
				return $stmt->execute($_array);
			}else{
				return false;
			}
		} else {
			return $this->db->exec($_sql);
		}
	}

	/**
	 * 返回最后插入行的ID
	 *
	 * @return int|\PDOStatement
	 */
	public function lastInsertId()
	{
		return $this->db->lastInsertId();
	}

	/**
	 * 返回错误信息
	 *
	 * @return string|\PDOStatement
	 */
	public function error()
	{
		$error = $this->db->errorInfo();
		return '['.$error[1].']'.$error[2];
	}

	function __get($name)
	{
		return $this->$name;
	}

	function __destruct()
	{
		$this->db = null;
	}


}