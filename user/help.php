<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='使用说明';
include './head.php';
?>
<?php

?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">使用说明</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			使用说明
		</div>
		<div class="panel-body">
		<h3>1分钟读懂<?php echo $conf['sitename']?>交易规则</h3>
			<div style="line-height:26px"><span style="white-space:nowrap;"> 
<p style="white-space:normal;margin-bottom:14px;color:#333333;font-family:'microsoft yahei';font-size:14px;line-height:24px;">
	<strong>一、交易即时到账</strong> 
</p>
<p style="white-space:normal;margin-bottom:14px;color:#333333;font-family:'microsoft yahei';font-size:14px;line-height:24px;">
	你的客户通过<?php echo $conf['sitename']?>中任意一种付款方式（支付宝、微信支付、财付通、QQ钱包）付款成功后均会时时到账于你的<?php echo $conf['sitename']?>账户，你可以在用户中心或订单记录中查看。
</p>
<p style="white-space:normal;margin-bottom:14px;color:#333333;font-family:'microsoft yahei';font-size:14px;line-height:24px;">
	<strong>二、T+1提现方案详解</strong> 
</p>
<p style="white-space:normal;margin-top:0px;margin-bottom:10px;padding:0px;border:0px;font-size:14px;line-height:25px;color:#79848E;font-family:'Microsoft YaHei', 'Heiti SC', simhei, 'Lucida Sans Unicode', 'Myriad Pro', 'Hiragino Sans GB', Verdana;text-indent:2em;background-color:#FFFFFF;">
	1、星期一、<span style="font-size:13px;line-height:20px;text-indent:26px;">星期</span>二、<span style="font-size:13px;line-height:20px;text-indent:26px;">星期</span>三、<span style="font-size:13px;line-height:20px;text-indent:26px;">星期</span>四、<span style="color:#79848E;font-family:'Microsoft YaHei', 'Heiti SC', simhei, 'Lucida Sans Unicode', 'Myriad Pro', 'Hiragino Sans GB', Verdana;font-size:14px;line-height:25px;text-indent:28px;white-space:normal;background-color:#FFFFFF;">星期五、</span><span style="color:#79848E;font-family:'Microsoft YaHei', 'Heiti SC', simhei, 'Lucida Sans Unicode', 'Myriad Pro', 'Hiragino Sans GB', Verdana;white-space:normal;font-size:13px;line-height:20px;text-indent:26px;">星期</span><span style="color:#79848E;font-family:'Microsoft YaHei', 'Heiti SC', simhei, 'Lucida Sans Unicode', 'Myriad Pro', 'Hiragino Sans GB', Verdana;font-size:14px;line-height:25px;text-indent:28px;white-space:normal;background-color:#FFFFFF;">六、</span><span style="color:#79848E;font-family:'Microsoft YaHei', 'Heiti SC', simhei, 'Lucida Sans Unicode', 'Myriad Pro', 'Hiragino Sans GB', Verdana;white-space:normal;font-size:13px;line-height:20px;text-indent:26px;">星期</span><span style="color:#79848E;font-family:'Microsoft YaHei', 'Heiti SC', simhei, 'Lucida Sans Unicode', 'Myriad Pro', 'Hiragino Sans GB', Verdana;font-size:14px;line-height:25px;text-indent:28px;white-space:normal;background-color:#FFFFFF;">日</span>，0点~23点59分59秒间提现的资金将于次日23点前到账。
</p>
<!--p style="white-space:normal;margin-top:0px;margin-bottom:10px;padding:0px;border:0px;font-size:14px;line-height:25px;color:#79848E;font-family:'Microsoft YaHei', 'Heiti SC', simhei, 'Lucida Sans Unicode', 'Myriad Pro', 'Hiragino Sans GB', Verdana;text-indent:2em;background-color:#FFFFFF;">
	<span style="font-size:13px;line-height:20px;text-indent:26px;">2、国家法定节假日期间提现的资金将于 节假日后第一个工作日23点前到账。</span> 
</p-->
<p style="white-space:normal;margin-bottom:14px;color:#333333;font-family:'microsoft yahei';font-size:14px;line-height:24px;">
	<strong>三、提现费率</strong> 
</p>
<table class="table table-striped table-condensed" width="735" style="color:#666666;font-family:'Helvetica Neue', 'Hiragino Sans GB', 'WenQuanYi Micro Hei', 'Microsoft Yahei', sans-serif;font-size:15.54px;line-height:24.864px;">
	<tbody style="box-sizing:border-box;margin:0px;padding:0px;border:0px;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:inherit;font-family:inherit;vertical-align:baseline;">
		<tr class="info firstRow" style="box-sizing:border-box;margin:0px;padding:0px;border:0px;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:inherit;font-family:inherit;vertical-align:baseline;">
			<td style="box-sizing:border-box;margin:0px;padding-top:11px;padding-right:0px;padding-bottom:11px;border:none;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:17px;font-family:inherit;vertical-align:top;background-color:#D9EDF7;">
				<p style="box-sizing:border-box;margin-bottom:10px;border:0px;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:inherit;font-family:inherit;vertical-align:baseline;color:#000000;text-indent:2em;">
					<strong style="box-sizing:border-box;margin:0px;padding:0px;border:0px;font-style:inherit;font-variant:inherit;font-stretch:inherit;font-size:inherit;line-height:inherit;font-family:inherit;vertical-align:baseline;">单笔提现金额</strong> 
				</p>
			</td>
			<td style="box-sizing:border-box;margin:0px;padding-top:11px;padding-right:0px;padding-bottom:11px;border:none;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:17px;font-family:inherit;vertical-align:top;background-color:#D9EDF7;">
				<p style="box-sizing:border-box;margin-bottom:10px;border:0px;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:inherit;font-family:inherit;vertical-align:baseline;color:#000000;text-indent:2em;">
					<strong style="box-sizing:border-box;margin:0px;padding:0px;border:0px;font-style:inherit;font-variant:inherit;font-stretch:inherit;font-size:inherit;line-height:inherit;font-family:inherit;vertical-align:baseline;">提现费率</strong> 
				</p>
			</td>
		</tr>
		<tr style="box-sizing:border-box;margin:0px;padding:0px;border:0px;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:inherit;font-family:inherit;vertical-align:baseline;background-color:#F4F6F8;">
			<td style="box-sizing:border-box;margin:0px;padding-top:11px;padding-right:0px;padding-bottom:11px;border:none;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:17px;font-family:inherit;vertical-align:top;">
				<p style="box-sizing:border-box;margin-bottom:10px;border:0px;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:inherit;font-family:inherit;vertical-align:baseline;color:#000000;text-indent:2em;">
					大于10元起提上不封顶
				</p>
			</td>
			<td style="box-sizing:border-box;margin:0px;padding-top:11px;padding-right:0px;padding-bottom:11px;border:none;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:17px;font-family:inherit;vertical-align:top;">
				<p style="box-sizing:border-box;margin-bottom:10px;border:0px;font-style:inherit;font-variant:inherit;font-weight:inherit;font-stretch:inherit;font-size:inherit;line-height:inherit;font-family:inherit;vertical-align:baseline;color:#000000;text-indent:2em;">
					0.5%（最高25元）
				</p>
			</td>
		</tr>
	</tbody>
</table>
<p style="white-space:normal;margin-bottom:14px;color:#333333;font-family:'microsoft yahei';font-size:14px;line-height:24px;">
	提现时手续费不足1元按1元收取
</p>
<p style="white-space:normal;margin-bottom:14px;color:#333333;font-family:'microsoft yahei';font-size:14px;line-height:24px;">
	<strong>四、多种结算方式</strong> 
</p>
<p style="white-space:normal;margin-bottom:14px;color:#333333;font-family:'microsoft yahei';font-size:14px;line-height:24px;">
	<span style="font-family:'Microsoft YaHei', 'Heiti SC', simhei, 'Lucida Sans Unicode', 'Myriad Pro', 'Hiragino Sans GB', Verdana;font-size:13px;line-height:20px;text-indent:26px;background-color:#FFFFFF;"><?php echo $conf['sitename']?></span>官方企业支付宝 -&gt; 您的个人支付宝（小额）
</p>
<p style="white-space:normal;margin-bottom:14px;color:#333333;font-family:'microsoft yahei';font-size:14px;line-height:24px;">
	<span style="font-family:'Microsoft YaHei', 'Heiti SC', simhei, 'Lucida Sans Unicode', 'Myriad Pro', 'Hiragino Sans GB', Verdana;font-size:13px;line-height:20px;text-indent:26px;background-color:#FFFFFF;"><?php echo $conf['sitename']?></span>官方对公账户 -&gt; 您的个人银行卡（大额）
</p>
</span></div>

		</div>
	</div>
</div>
    </div>
  </div>

<?php include 'foot.php';?>