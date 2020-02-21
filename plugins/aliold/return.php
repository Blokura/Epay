<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */
if(!defined('IN_PLUGIN'))exit();

require_once(PAY_ROOT."inc/alipay.config.php");
require_once(PAY_ROOT."inc/alipay_notify.class.php");

@header('Content-Type: text/html; charset=UTF-8');

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {
	//商户订单号
	$out_trade_no = daddslashes($_GET['out_trade_no']);

	//支付宝交易号
	$trade_no = daddslashes($_GET['trade_no']);

	//交易状态
	$trade_status = $_GET['trade_status'];

	//交易金额
	$total_fee = $_GET['total_fee'];

    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		if($out_trade_no == TRADE_NO && round($total_fee,2)==round($order['money'],2)){
			$url=creat_callback($order);

			if($order['status']==0){
				if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='".TRADE_NO."'")){
					$DB->exec("update `pre_order` set `api_trade_no` ='$trade_no',`endtime` ='$date',`date` =NOW() where `trade_no`='".TRADE_NO."'");
					processOrder($order,false);
				}
				echo '<script>window.location.href="'.$url['return'].'";</script>';
			}else{
				echo '<script>window.location.href="'.$url['return'].'";</script>';
			}
		}else{
			sysmsg('订单信息校验失败');
		}
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
}
else {
    //验证失败
	sysmsg('支付宝返回验证失败！');
}

?>