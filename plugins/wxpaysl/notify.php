<?php
if(!defined('IN_PLUGIN'))exit();
require_once PAY_ROOT."inc/WxPay.Api.php";
require_once PAY_ROOT."inc/WxPay.Notify.php";

//初始化日志
//$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		//Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		//file_put_contents('log.txt',"call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		global $DB,$date,$order;
		if($data['return_code']=='SUCCESS'){
			if($data['result_code']=='SUCCESS'){
				if($data['out_trade_no'] == TRADE_NO && $data['total_fee']==strval($order['money']*100) && $order['status']==0){
					if($DB->exec("update `pre_order` set `status` ='1' where `trade_no`='".TRADE_NO."'")){
						$DB->exec("update `pre_order` set `api_trade_no` ='{$data['transaction_id']}',`endtime` ='$date',`buyer` ='{$data['openid']}',`date`=NOW() where `trade_no`='".TRADE_NO."'");
						processOrder($order);
					}
					return true;
				}else{
					$msg='该订单已经处理';
					return true;
				}
			}else{
				$msg='['.$data['err_code'].']'.$data['err_code_des'];
				return false;
			}
		}else{
			$msg='['.$data['return_code'].']'.$data['return_msg'];
			return false;
		}
		return true;
	}
}

//Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
