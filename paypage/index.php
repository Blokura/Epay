<?php
include("./inc.php");
if(isset($_GET['merchant'])){
	$merchant=isset($_GET['merchant'])?trim($_GET['merchant']):showerror('参数不完整');
	$uid = authcode($merchant, 'DECODE', SYS_KEY);
	if(!$uid || !is_numeric($uid))showerror('参数错误');
}elseif(isset($_SESSION['paypage_uid'])){
	$uid = intval($_SESSION['paypage_uid']);
}else{
	showerror('参数错误');
}
$userrow=$DB->getRow("select * from pre_user where uid='$uid' limit 1");
if(!$userrow || $userrow['status']==0 || $userrow['pay']==0)showerror('当前商户不存在或已被封禁');
if($conf['cert_force']==1 && $userrow['cert']==0){
	showerror('当前商户未完成实名认证，无法收款');
}

$_SESSION['paypage_uid'] = $uid;

$direct = '0';
$type = check_paytype();
if($type){
	$submitData = \lib\Channel::submit($type, $userrow['gid']);
	$apptype = explode(',',$submitData['apptype']);
	if($type == 'alipay' && in_array('4',$apptype)){
		$openId = alipayOpenId($submitData['channel']);
		$direct = '1';
	}elseif($type == 'wxpay' && in_array('2',$apptype)){
		$openId = weixinOpenId($submitData['channel']);
		$direct = '1';
	}elseif($type == 'qqpay' && in_array('2',$apptype)){
		$direct = '1';
	}
	$_SESSION['paypage_typeid'] = $submitData['typeid'];
	$_SESSION['paypage_channel'] = $submitData['channel'];
	$_SESSION['paypage_rate'] = $submitData['rate'];
}

$codename = !empty($userrow['codename'])?$userrow['codename']:$userrow['username'];
$csrf_token = md5(mt_rand(0,999).time());
$_SESSION['paypage_token'] = $csrf_token;
?>
<html lang="zh-cn">
<head>
    <title>向商户付款</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/style.css?version=1.0.0">
</head>
<body>
<div class="layout-flex wrap">

  <!-- content start -->
  <div class="content">
      <div class="mar20">
          <table>
              <tbody>
                  <tr>
                      <td><span class="sico_pay" style="margin:5px 5px 10px 5px"></span></td>
                      <td  class="selTitle"><?php echo $codename?></td>
                  </tr>
              </tbody>
          </table>
      </div>
    <form name="payForm" action="dopay" method="post">
        <input type="hidden" name="uid" id="uid" value="<?php echo $uid?>">
        <input type="hidden" name="token" id="token" value="<?php echo $csrf_token?>">
        <input type="hidden" name="paytype" id="paytype" value="<?php echo $type?>">
		<input type="hidden" name="direct" id="direct" value="<?php echo $direct?>">
		<input type="hidden" name="payer" id="payer" value="<?php echo $openId?>">
		<input type="hidden" name="trade_no" id="trade_no" value="">
        <div class="set_amount">
        	<div class="payMoney marLeft10">请输入付款金额</div>
            <div class="amount_bd">
                <i class="i_money marLeft10" style="">¥</i>
                <span class="input_simu " id="amount"></span>

                <!-- 模拟input -->
                <em class="line_simu" id="line"></em>
                <!-- 模拟闪烁的光标 -->
                <div  id="clearBtn"  style="touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>
                <!-- 清除按钮 -->
            </div>
        </div>
    </form>

  </div>
  <!-- content end -->

  <div class="copyRight">由 <span style="font-weight:bold"><?php echo $conf['sitename']?></span> 提供服务支持</div>
  <!-- 键盘 -->
  <div class="keyboard">
      <table class="key_table" id="keyboard" style="touch-action:pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
          <tbody>
              <tr>
                <td class="key border b_rgt_btm" data-value="1">1</td>
                <td class="key border b_rgt_btm" data-value="2">2</td>
                <td class="key border b_rgt_btm" data-value="3">3</td>
                <td class="key border b_btm clear" data-value="delete"></td>
              </tr>
              <tr>
                <td class="key border b_rgt_btm" data-value="4">4</td>
                <td class="key border b_rgt_btm" data-value="5">5</td>
                <td class="key border b_rgt_btm" data-value="6">6</td>
                <td class="pay_btn" rowspan="3" id="payBtn" style="touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><em>确认</em>支付</td>
              </tr>
              <tr>
                <td class="key border b_rgt_btm" data-value="7">7</td>
                <td class="key border b_rgt_btm" data-value="8">8</td>
                <td class="key border b_rgt_btm" data-value="9">9</td>
              </tr>
              <tr>
                <td colspan="2" class="key border b_rgt" data-value="0">0</td>
                <td class="key border b_rgt" data-value="dot">.</td>
              </tr>
          </tbody>
      </table>
  </div>

</div>

<script src="//cdn.staticfile.org/jquery/3.4.1/jquery.min.js"></script>
<script src="//open.mobile.qq.com/sdk/qqapi.js?_bid=152"></script>
<script src="js/hammer.js"></script>
<script src="js/common.js"></script>
<script src="js/pay.js?v=1002"></script>
<script>
    var tips = new Tips();
</script>
</body>
</html>