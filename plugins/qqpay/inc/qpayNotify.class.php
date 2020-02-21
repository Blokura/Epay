<?php
/**
 * QpayNotify.php 业务调用方可做二次封装
 * Created by HelloWorld
 * vers: v1.0.0
 * User: Tencent.com
 */
require_once (PAY_ROOT.'inc/qpayMchUtil.class.php');
class QpayNotify{
    private $params;
	private $sign;

	function getParams() {
		$post_data = file_get_contents("php://input");
		$params =  QpayMchUtil::xmlToArray($post_data);
		$this->params = $params;
		$this->sign = $params['sign'];
		return $params;
	}

	function verifySign() {
		$sign = QpayMchUtil::getSign($this->params);
		return $sign == $this->sign;
	}

}