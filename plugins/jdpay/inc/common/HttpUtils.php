<?php

/**
 * HTTP工具类
 *
 * @author wywangzhenlong
 *        
 */
class HttpUtils {

	public function http_post_data($url, $data_string ) {

		$TIMEOUT = 30;	//超时时间(秒)

		$ch = curl_init ();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    	curl_setopt($ch, CURLOPT_TIMEOUT, $TIMEOUT);
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $TIMEOUT-2);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml;charset=utf-8'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$return_content = curl_exec($ch);
		$return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return array (
				$return_code,
				$return_content 
		);
	}

}
