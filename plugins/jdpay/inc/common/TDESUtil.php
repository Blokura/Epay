<?php

class TDESUtil {
	
	/**
	 * 将元数据进行补位后进行3DES加密
	 * <p/>
	 * 补位后 byte[] = 描述有效数据长度(int)的byte[]+原始数据byte[]+补位byte[]
	 *
	 * @param
	 *        	sourceData 元数据字符串
	 * @return 返回3DES加密后的16进制表示的字符串
	 */
	public static function encrypt2HexStr($keys, $sourceData) {
		$length = strlen($sourceData);
		$result = '';
		for($i = 0; $i < 4; $i ++) {
			$shift = (4 - 1 - $i) * 8;
			$result .= chr(($length >> $shift) & 0x000000FF);
		}
		$result .= $sourceData;
		$add = 8 - ($length+4) % 8;
		if($add>0){
			for($i=0; $i<$add; $i++){
				$result .= chr(0);
			}
		}
		$desdata = self::encrypt( $result, $keys );
		return bin2hex( $desdata );
	}
	
	/**
	 * 3DES 解密 进行了补位的16进制表示的字符串数据
	 *
	 * @return
	 *
	 */
	public static function decrypt4HexStr($keys, $data) {
		$unDesResult = self::decrypt(hex2bin($data),$keys);

		$length=0;
		for($i = 0; $i < 4; $i ++) {
			$shift = (4 - 1 - $i) * 8;
			$length += (ord($unDesResult[$i]) & 0x000000FF) << $shift;
		}
		$result = substr($unDesResult, 4, $length);

		return $result;
	}
	
	// 加密算法
	public static function encrypt($input, $key) {
		return openssl_encrypt($input, 'des-ede3', $key, OPENSSL_NO_PADDING, "");
	}
	// 解密算法
	public static function decrypt($encrypted, $key) {
		return openssl_decrypt($encrypted, 'des-ede3', $key, OPENSSL_NO_PADDING, "");
	}
}
