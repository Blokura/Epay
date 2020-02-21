<?php
namespace lib;

class PayUtils {

	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	static public function createLinkstring($para) {
		$arg  = "";
		foreach ($para as $key=>$val) {
			$arg.=$key."=".$val."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,-1);

		return $arg;
	}
	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	static public function createLinkstringUrlencode($para) {
		$arg  = "";
		foreach ($para as $key=>$val) {
			$arg.=$key."=".urlencode($val)."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,-1);

		return $arg;
	}
	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */
	static public function paraFilter($para) {
		$para_filter = array();
		foreach ($para as $key=>$val) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else $para_filter[$key] = $para[$key];
		}
		return $para_filter;
	}
	/**
	 * 对数组排序
	 * @param $para 排序前的数组
	 * return 排序后的数组
	 */
	static public function argSort($para) {
		ksort($para);
		reset($para);
		return $para;
	}
	/**
	 * 签名字符串
	 * @param $prestr 需要签名的字符串
	 * @param $key 私钥
	 * return 签名结果
	 */
	static public function md5Sign($prestr, $key) {
		$prestr = $prestr . $key;
		return md5($prestr);
	}

	/**
	 * 验证签名
	 * @param $prestr 需要签名的字符串
	 * @param $sign 签名结果
	 * @param $key 私钥
	 * return 签名结果
	 */
	static public function md5Verify($prestr, $sign, $key) {
		$prestr = $prestr . $key;
		$mysgin = md5($prestr);

		if($mysgin == $sign) {
			return true;
		}
		else {
			return false;
		}
	}
}
