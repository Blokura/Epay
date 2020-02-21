<?php
/**
 * Created by PhpStorm.
 * User: xudong.ding
 * Date: 16/5/19
 * Time: 下午2:09
 */
require_once PAY_ROOT.'inc/lib/AopClient.php';
require_once PAY_ROOT.'inc/model/request/AlipaySystemOauthTokenRequest.php';
require_once PAY_ROOT.'inc/model/request/AlipayUserInfoShareRequest.php';
require PAY_ROOT.'inc/config.php';

class AlipayOauthService {

	//支付宝网关地址
	public $gateway_url = "https://openapi.alipay.com/gateway.do";

	//异步通知回调地址
	public $notify_url;

	//签名类型
	public $sign_type;

	//支付宝公钥地址
	public $alipay_public_key;

	//商户私钥地址
	public $private_key;

	//授权回调地址
	public $redirect_uri;

	//应用id
	public $appid;

	//编码格式
	public $charset = "UTF-8";

	public $token = NULL;

	//返回数据格式
	public $format = "json";

	//签名方式
	public $signtype = "RSA";


	function __construct($alipay_config){
		$this->gateway_url = $alipay_config['gatewayUrl'];
		$this->appid = $alipay_config['app_id'];
		$this->sign_type = $alipay_config['sign_type'];
		$this->private_key = $alipay_config['merchant_private_key'];
		$this->alipay_public_key = $alipay_config['alipay_public_key'];
		$this->redirect_uri = $alipay_config['redirect_uri'];
		$this->charset = $alipay_config['charset'];
		$this->signtype = $alipay_config['sign_type'];

		if(empty($this->appid)||trim($this->appid)==""){
			throw new Exception("appid should not be NULL!");
		}
		if(empty($this->private_key)||trim($this->private_key)==""){
			throw new Exception("private_key should not be NULL!");
		}
		if(empty($this->alipay_public_key)||trim($this->alipay_public_key)==""){
			throw new Exception("alipay_public_key should not be NULL!");
		}
		if(empty($this->charset)||trim($this->charset)==""){
			throw new Exception("charset should not be NULL!");
		}
		if(empty($this->gateway_url)||trim($this->gateway_url)==""){
			throw new Exception("gateway_url should not be NULL!");
		}
		if(empty($this->sign_type)||trim($this->sign_type)==""){
			throw new Exception("sign_type should not be NULL");
		}

	}

	//跳转支付宝授权页面
	public function oauth() {

		$param = array('app_id'=>$this->appid, 'scope'=>'auth_base', 'redirect_uri'=>$this->redirect_uri);
		$url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?'.http_build_query($param);

		Header("Location: $url");
		exit();

	}

	//换取授权访问令牌
	public function getToken($code, $grant_type = 'authorization_code') {

		$request = new AlipaySystemOauthTokenRequest();
		if($grant_type == 'refresh_token'){
			$request->setGrantType("refresh_token");
			$request->setRefreshToken($code);
		}else{
			$request->setGrantType("authorization_code");
			$request->setCode($code);
		}

		$response = $this->aopclientRequestExecute($request);
		$response = $response->alipay_system_oauth_token_response;
		
		if(!empty($response) && $response->user_id){
			$result = array('user_id'=>$response->user_id, 'access_token'=>$response->access_token);
		}else{
			$result = array('code'=>$response->code, 'msg'=>$response->msg, 'sub_code'=>$response->sub_code, 'sub_msg'=>$response->sub_msg);
		}

		return $result;

	}

	//支付宝会员授权信息查询
	public function userinfo($accessToken) {

		$request = new AlipayUserInfoShareRequest();

		$response = $this->aopclientRequestExecute($request, $accessToken);
		$response = $response->alipay_user_info_share_response;
		
		if(!empty($response) && $response->code == "10000"){
			$result = json_decode(json_encode($response), true);
		}else{
			$result = array('code'=>$response->code, 'msg'=>$response->msg, 'sub_code'=>$response->sub_code, 'sub_msg'=>$response->sub_msg);
		}

		return $result;

	}

	/**
	 * 使用SDK执行提交页面接口请求
	 * @param unknown $request
	 * @param string $token
	 * @param string $appAuthToken
	 * @return string $$result
	 */
	private function aopclientRequestExecute($request, $token = NULL, $appAuthToken = NULL) {

		$aop = new AopClient ();
		$aop->gatewayUrl = $this->gateway_url;
		$aop->appId = $this->appid;
		$aop->signType = $this->sign_type;
		$aop->rsaPrivateKey = $this->private_key;
		$aop->alipayrsaPublicKey = $this->alipay_public_key;
		$aop->apiVersion = "1.0";
		$aop->postCharset = $this->charset;

		$aop->format=$this->format;
		// 开启页面信息输出
		$aop->debugInfo=true;
		$result = $aop->execute($request,$token,$appAuthToken);

		//打开后，将url形式请求报文写入log文件
		//$this->writeLog("response: ".var_export($result,true));
		return $result;
	}

	function writeLog($text) {
		// $text=iconv("GBK", "UTF-8//IGNORE", $text);
		//$text = characet ( $text );
		file_put_contents ( PAY_ROOT."inc/log/log.txt", date ( "Y-m-d H:i:s" ) . "  " . $text . "\r\n", FILE_APPEND );
	}

}