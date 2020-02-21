<?php
/* *
 * 码支付异步通知页面
 */

if(!defined('IN_PLUGIN'))exit();
require_once(PAY_ROOT."inc/codepay_config.php");
ksort($_POST); //排序post参数
reset($_POST); //内部指针指向数组中的第一个元素
$sign = '';
foreach ($_POST AS $key => $val) {
    if ($val == '') continue;
    if ($key != 'sign') {
        if ($sign != '') {
            $sign .= "&";
            $urls .= "&";
        }
        $sign .= "$key=$val"; //拼接为url参数形式
        $urls .= "$key=" . urlencode($val); //拼接为url参数形式
    }
}

if (!$_POST['pay_no'] || md5($sign . $codepay_config['key']) != $_POST['sign']) { //不合法的数据 KEY密钥为你的密钥
    exit('fail');
} else { //合法的数据

    $out_trade_no = daddslashes($_POST['param']);

    //流水号
    $trade_no = daddslashes($_POST['pay_no']);

	$price = (float)$_POST['price'];

	if($out_trade_no == TRADE_NO && round($price,2)==round($order['money'],2) && $order['status']==0){
		if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='$out_trade_no'")){
			$DB->exec("update `pre_order` set `api_trade_no` ='$trade_no',`endtime` ='$date',`date` =NOW() where `trade_no`='$out_trade_no'");
			processOrder($order);
		}
	}

    exit('success');
}

?>