<?php
/**
 * Created by PhpStorm.
 * User: xudong.ding
 * Date: 16/5/19
 * Time: 下午2:09
 */
require_once PAY_ROOT.'inc/lib/AopClient.php';
require_once PAY_ROOT.'inc/model/request/AlipayUserCertifyOpenInitializeRequest.php';
require_once PAY_ROOT.'inc/model/request/AlipayUserCertifyOpenCertifyRequest.php';
require_once PAY_ROOT.'inc/model/request/AlipayUserCertifyOpenQueryRequest.php';
require PAY_ROOT.'inc/config.php';

class AlipayCertifyService {

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
	public $return_url;

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
		$this->return_url = $alipay_config['cert_return_url'];
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

	//身份认证初始化服务
	public function initialize($outer_order_no, $cert_name, $cert_no, $biz_code = 'SMART_FACE') {
		
		$BizContent = array(
			'outer_order_no' => $outer_order_no, //商户请求的唯一标识
			'biz_code' => $biz_code, //认证场景码
			'identity_param' => [
				'identity_type' => 'CERT_INFO', //身份信息参数类型
				'cert_type' => 'IDENTITY_CARD', //证件类型
				'cert_name' => $cert_name, //真实姓名
				'cert_no' => $cert_no, //证件号码
				],
			'merchant_config' => ['return_url'=>$this->return_url], //商户个性化配置
		);
		$request = new AlipayUserCertifyOpenInitializeRequest();
		$request->setBizContent(json_encode($BizContent));

		$response = $this->aopclientRequestExecute($request);
		$response = $response->alipay_user_certify_open_initialize_response;
		
		if(!empty($response->code)&&$response->code == 10000){
			$result = array('certify_id'=>$response->certify_id);
		}else{
			$result = array('code'=>$response->code, 'msg'=>$response->msg, 'sub_code'=>$response->sub_code, 'sub_msg'=>$response->sub_msg);
		}

		return $result;

	}

	//身份认证开始认证
	public function certify($certify_id) {

		$BizContent = array(
			'certify_id' => $certify_id,
		);
		$request = new AlipayUserCertifyOpenCertifyRequest();
		$request->setBizContent(json_encode($BizContent));

		$response = $this->aopclientRequestPageExecute($request);
		
		return $response;

	}

	//身份认证记录查询
	public function query($certify_id) {
		
		$BizContent = array(
			'certify_id' => $certify_id,
		);
		$request = new AlipayUserCertifyOpenQueryRequest();
		$request->setBizContent(json_encode($BizContent));

		$response = $this->aopclientRequestExecute($request);
		$response = $response->alipay_user_certify_open_query_response;
		
		if(!empty($response->code)&&$response->code == 10000){
			$result = array('passed'=>$response->passed[0], 'identity_info'=>$response->identity_info, 'material_info'=>$response->material_info);
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

	/**
	 * 使用SDK执行提交页面接口请求
	 * @param unknown $request
	 * @param string $token
	 * @param string $appAuthToken
	 * @return string $$result
	 */
	private function aopclientRequestPageExecute($request, $token = NULL, $appAuthToken = NULL) {

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
		$result = $aop->pageExecute($request,$token,$appAuthToken);

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