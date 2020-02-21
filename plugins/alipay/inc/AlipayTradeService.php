<?php
/**
 * Created by PhpStorm.
 * User: xudong.ding
 * Date: 16/5/19
 * Time: 下午2:09
 */
require_once PAY_ROOT.'inc/lib/AopClient.php';
require_once PAY_ROOT.'inc/model/request/AlipayTradeCreateRequest.php';
require_once PAY_ROOT.'inc/model/request/AlipayTradePagePayRequest.php';
require_once PAY_ROOT.'inc/model/request/AlipayTradeWapPayRequest.php';
require_once PAY_ROOT.'inc/model/request/AlipayTradePrecreateRequest.php';
require_once PAY_ROOT.'inc/model/request/AlipayTradeQueryRequest.php';
require_once PAY_ROOT.'inc/model/request/AlipayTradeRefundRequest.php';
require_once PAY_ROOT.'inc/model/request/AlipayTradeCloseRequest.php';
require_once PAY_ROOT.'inc/model/request/AlipayTradeFastpayRefundQueryRequest.php';
require_once PAY_ROOT.'inc/model/result/AlipayF2FPrecreateResult.php';
require_once PAY_ROOT.'inc/model/result/AlipayF2FQueryResult.php';
require_once PAY_ROOT.'inc/model/result/AlipayF2FRefundResult.php';
require_once PAY_ROOT.'inc/model/builder/AlipayTradeQueryContentBuilder.php';
require PAY_ROOT.'inc/config.php';

class AlipayTradeService {

	//支付宝网关地址
	public $gateway_url = "https://openapi.alipay.com/gateway.do";

	//异步通知回调地址
	public $notify_url;

	//同步通知回调地址
	public $return_url;

	//签名类型
	public $sign_type;

	//支付宝公钥地址
	public $alipay_public_key;

	//商户私钥地址
	public $private_key;

	//应用id
	public $appid;

	//编码格式
	public $charset = "UTF-8";


	public $token = NULL;
	
	//返回数据格式
	public $format = "json";

	//签名方式
	public $signtype = "RSA2";


	function __construct($alipay_config){
		$this->gateway_url = $alipay_config['gatewayUrl'];
		$this->appid = $alipay_config['app_id'];
		$this->sign_type = $alipay_config['sign_type'];
		$this->private_key = $alipay_config['merchant_private_key'];
		$this->alipay_public_key = $alipay_config['alipay_public_key'];
		$this->charset = $alipay_config['charset'];
		$this->notify_url = $alipay_config['notify_url'];
		$this->return_url = $alipay_config['return_url'];
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
	function AlipayWapPayService($alipay_config) {
		$this->__construct($alipay_config);
	}

	/**
	 * 使用SDK执行提交页面接口请求
	 * @param unknown $request
	 * @param $ispage  是否是页面接口，电脑网站支付是页面表单接口。
	 * @return string $result
	 */
	private function aopclientRequestExecute($request, $ispage=false) {

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
		if($ispage)
		{
			$result = $aop->pageExecute($request,"post");
		}
		else 
		{
			$result = $aop->Execute($request);
		}

		//打开后，将url形式请求报文写入log文件
		//$this->writeLog("response: ".var_export($result,true));
		return $result;
	}

	/**
	 * alipay.trade.create
	 * @param $builder 业务参数，使用build中的对象生成。
	 * @return $response 支付宝返回的信息
 	*/
	public function create($req) {
		$bizContent = $req->getBizContent();
		$this->writeLog($bizContent);

		$request = new AlipayTradeCreateRequest();
		$request->setBizContent ( $bizContent );
		$request->setNotifyUrl ( $this->notify_url );

		// 首先调用支付api
		$response = $this->aopclientRequestExecute ( $request );
		$response = $response->alipay_trade_create_response;

		$result = new AlipayF2FPrecreateResult($response);
		if(!empty($response)&&("10000"==$response->code)){
			$result->setTradeStatus("SUCCESS");
		} elseif($this->tradeError($response)){
			$result->setTradeStatus("UNKNOWN");
		} else {
			$result->setTradeStatus("FAILED");
		}
		return $result;
	}

	//当面付2.0预下单(生成二维码)
	public function qrPay($req) {
		$bizContent = $req->getBizContent();
		$this->writeLog($bizContent);

		$request = new AlipayTradePrecreateRequest();
		$request->setBizContent ( $bizContent );
		$request->setNotifyUrl ( $this->notify_url );

		// 首先调用支付api
		$response = $this->aopclientRequestExecute ( $request );
		$response = $response->alipay_trade_precreate_response;

		$result = new AlipayF2FPrecreateResult($response);
		if(!empty($response)&&("10000"==$response->code)){
			$result->setTradeStatus("SUCCESS");
		} elseif($this->tradeError($response)){
			$result->setTradeStatus("UNKNOWN");
		} else {
			$result->setTradeStatus("FAILED");
		}
		return $result;
	}

	/**
	 * alipay.trade.page.pay
	 * @param $builder 业务参数，使用build中的对象生成。
	 * @return $response 支付宝返回的信息
 	*/
	public function pagePay($builder) {
	
		$biz_content=$builder->getBizContent();
		//打印业务参数
		$this->writeLog($biz_content);
	
		$request = new AlipayTradePagePayRequest();
	
		$request->setNotifyUrl($this->notify_url);
		$request->setReturnUrl($this->return_url);
		$request->setBizContent ( $biz_content );
	
		// 首先调用支付api
		$response = $this->aopclientRequestExecute ($request,true);
		// $response = $response->alipay_trade_wap_pay_response;
		return $response;
	}

	/**
	 * alipay.trade.wap.pay
	 * @param $builder 业务参数，使用build中的对象生成。
	 * @return $response 支付宝返回的信息
 	*/
	public function wapPay($builder) {
	
		$biz_content=$builder->getBizContent();
		//打印业务参数
		$this->writeLog($biz_content);
	
		$request = new AlipayTradeWapPayRequest();
	
		$request->setNotifyUrl($this->notify_url);
		$request->setReturnUrl($this->return_url);
		$request->setBizContent ( $biz_content );
	
		// 首先调用支付api
		$response = $this->aopclientRequestExecute ($request,true);
		// $response = $response->alipay_trade_wap_pay_response;
		return $response;
	}

	/**
	 * alipay.trade.refund (统一收单交易退款接口)
	 * @param $builder 业务参数，使用build中的对象生成。
	 * @return $response 支付宝返回的信息
	 */
	public function refund($req) {
		$bizContent = $req->getBizContent();
		$this->writeLog($bizContent);
		$request = new AlipayTradeRefundRequest();
		$request->setBizContent ( $bizContent );
		$response = $this->aopclientRequestExecute ( $request );

		$response = $response->alipay_trade_refund_response;

		$result = new AlipayF2FRefundResult($response);
		if(!empty($response)&&("10000"==$response->code)){
			$result->setTradeStatus("SUCCESS");
		} elseif ($this->tradeError($response)){
			$result->setTradeStatus("UNKNOWN");
		} else {
			$result->setTradeStatus("FAILED");
		}

		return $result;
	}

	/**
	 * alipay.trade.close (统一收单交易关闭接口)
	 * @param $builder 业务参数，使用build中的对象生成。
	 * @return $response 支付宝返回的信息
	 */
	public function close($builder){
		$biz_content=$builder->getBizContent();
		//打印业务参数
		$this->writeLog($biz_content);
		$request = new AlipayTradeCloseRequest();
		$request->setBizContent ( $biz_content );
	
		$response = $this->aopclientRequestExecute ($request);
		$response = $response->alipay_trade_close_response;
		return $response;
	}
	
	/**
	 * 退款查询   alipay.trade.fastpay.refund.query (统一收单交易退款查询)
	 * @param $builder 业务参数，使用build中的对象生成。
	 * @return $response 支付宝返回的信息
	 */
	public function refundQuery($builder){
		$biz_content=$builder->getBizContent();
		//打印业务参数
		$this->writeLog($biz_content);
		$request = new AlipayTradeFastpayRefundQueryRequest();
		$request->setBizContent ( $biz_content );
	
		$response = $this->aopclientRequestExecute ($request);
		$response = $response->alipay_trade_fastpay_refund_query_response;
		return $response;
	}


	/**
	 * alipay.trade.query (统一收单线下交易查询)
	 * @param $builder 业务参数，使用build中的对象生成。
	 * @return $response 支付宝返回的信息
 	*/
	public function query($builder) {
		$biz_content = $builder->getBizContent();
		//$this->writeLog($biz_content);
		$request = new AlipayTradeQueryRequest();
		$request->setBizContent ( $biz_content );
		$response = $this->aopclientRequestExecute ( $request );

		return $response->alipay_trade_query_response;
	}

	/**
	 * alipay.trade.query (统一收单线下交易查询)
	 * @param $tradeNo 支付宝交易号
	 * @return $response 支付宝返回的信息
 	*/
	public function orderQuery($tradeNo) {
		$queryContentBuilder = new AlipayTradeQueryContentBuilder();
		$queryContentBuilder->setTradeNo($tradeNo);
		$response = $this->query($queryContentBuilder);
		return $response;
	}

	// 当面付2.0消费查询
	public function queryTradeResult($req){
		$response = $this->query($req);
		$result = new AlipayF2FQueryResult($response);

		if($this->querySuccess($response)){
			// 查询返回该订单交易支付成功
			$result->setTradeStatus("SUCCESS");

		} elseif ($this->tradeError($response)){
			//查询发生异常或无返回，交易状态未知
			$result->setTradeStatus("UNKNOWN");
		} else {
			//其他情况均表明该订单号交易失败
			$result->setTradeStatus("FAILED");
		}
		return $result;

	}

	// 查询返回“支付成功”
	protected function querySuccess($queryResponse){
		return !empty($queryResponse)&&
				$queryResponse->code == "10000"&&
				($queryResponse->trade_status == "TRADE_SUCCESS"||
					$queryResponse->trade_status == "TRADE_FINISHED");
	}

	// 查询返回“交易关闭”
	protected function queryClose($queryResponse){
		return !empty($queryResponse)&&
		$queryResponse->code == "10000"&&
		$queryResponse->trade_status == "TRADE_CLOSED";
	}

	// 交易异常，或发生系统错误
	protected function tradeError($response){
		return empty($response)||
					$response->code == "20000";
	}
	

	/**
	 * alipay.data.dataservice.bill.downloadurl.query (查询对账单下载地址)
	 * @param $builder 业务参数，使用build中的对象生成。
	 * @return $response 支付宝返回的信息
	 */
	public function downloadurlQuery($builder){
		$biz_content=$builder->getBizContent();
		//打印业务参数
		$this->writeLog($biz_content);
		$request = new alipaydatadataservicebilldownloadurlqueryRequest();
		$request->setBizContent ( $biz_content );
	
		$response = $this->aopclientRequestExecute ($request);
		$response = $response->alipay_data_dataservice_bill_downloadurl_query_response;
		return $response;
	}

	/**
	 * 验签方法
	 * @param $arr 验签支付宝返回的信息，使用支付宝公钥。
	 * @return boolean
	 */
	public function check($arr){
		$aop = new AopClient();
		$aop->alipayrsaPublicKey = $this->alipay_public_key;
		$result = $aop->rsaCheckV1($arr, $this->alipay_public_key, $this->signtype);
		if($result){
			$queryResponse = $this->orderQuery($arr['trade_no']);
			$result = $this->querySuccess($queryResponse);
		}
		return $result;
	}

	public function writeLog($text) {
		// $text=iconv("GBK", "UTF-8//IGNORE", $text);
		//$text = characet ( $text );
		file_put_contents ( PAY_ROOT."inc/log/log.txt", date ( "Y-m-d H:i:s" ) . "  " . $text . "\r\n", FILE_APPEND );
	}

}