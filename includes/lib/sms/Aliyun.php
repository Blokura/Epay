<?php
namespace lib\sms;

class Aliyun {
	private $AccessKeyId;
	private $AccessKeySecret;

	function __construct($AccessKeyId, $AccessKeySecret){
        $this->AccessKeyId = $AccessKeyId;
        $this->AccessKeySecret = $AccessKeySecret;
    }
	private function aliyunSignature($parameters, $accessKeySecret, $method)
	{
		ksort($parameters);
		$canonicalizedQueryString = '';
		foreach ($parameters as $key => $value) {
			$canonicalizedQueryString .= '&' . $this->percentEncode($key). '=' . $this->percentEncode($value);
		}
		$stringToSign = $method . '&%2F&' . $this->percentencode(substr($canonicalizedQueryString, 1));
		$signature = base64_encode(hash_hmac("sha1", $stringToSign, $accessKeySecret."&", true));

		return $signature;
	}
	private function percentEncode($str)
	{
		$res = urlencode($str);
		$res = preg_replace('/\+/', '%20', $res);
		$res = preg_replace('/\*/', '%2A', $res);
		$res = preg_replace('/%7E/', '~', $res);
		return $res;
	}
	public function send($phone, $code, $moban, $sign, $sitename){
		if(empty($this->AccessKeyId)||empty($this->AccessKeySecret))return false;
		$url='https://dysmsapi.aliyuncs.com/';
		$TemplateParam = json_encode(['code'=>$code]);
		$data=array(
			'Action' => 'SendSms',
			'PhoneNumbers' => $phone,
			'SignName' => $sign,
			'TemplateCode' => $moban,
			'TemplateParam' => $TemplateParam,
			'Format' => 'JSON',
			'RegionId' => 'cn-hangzhou',
			'Version' => '2017-05-25',
			'AccessKeyId' => $this->AccessKeyId,
			'SignatureMethod' => 'HMAC-SHA1',
			'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
			'SignatureVersion' => '1.0',
			'SignatureNonce' => random(8));
		$data['Signature'] = $this->aliyunSignature($data, $this->AccessKeySecret, 'POST');
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$json=curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$arr=json_decode($json,true);
		return $arr;
	}
}
