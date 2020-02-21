<?php
/**
 * qpayMachAPI.php 业务调用方可做二次封装
 * Created by HelloWorld
 * vers: v1.0.0
 * User: Tencent.com
 */
require_once (PAY_ROOT.'inc/qpayMchUtil.class.php');
class QpayMchAPI{
    protected $url;
    protected $isSSL;
    protected $timeout;

    /**
     * QpayMchAPI constructor.
     *
     * @param       $url       接口url
     * @param       $isSSL     是否使用证书发送请求
     * @param int   $timeout   超时
     */
    public function __construct($url, $isSSL, $timeout = 5){
        $this->url = $url;
        $this->isSSL = $isSSL;
        $this->timeout = $timeout;
    }

    public function reqQpay($params){
        $ret = array();
        //商户号
        $params["mch_id"] = QpayMchConf::MCH_ID;
        //随机字符串
        $params["nonce_str"] = QpayMchUtil::createNoncestr();
        //签名
        $params["sign"] = QpayMchUtil::getSign($params);
        //生成xml
        $xml = QpayMchUtil::arrayToXml($params);

        if(isset($this->isSSL)){
            $ret =  QpayMchUtil::reqByCurlSSLPost($xml, $this->url, $this->timeout);
        }else{
            $ret =  QpayMchUtil::reqByCurlNormalPost($xml, $this->url, $this->timeout);
        }
        return $ret;
    }

}