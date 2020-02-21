<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='一码支付';
include './head.php';
?>
<?php
if(!$conf['onecode'])exit('未开启一码支付');

$merchant = authcode($uid, 'ENCODE', SYS_KEY);
$code_url = $siteurl.'paypage/?merchant='.urlencode($merchant);
if(isset($_SESSION['onecode_url'])){
	$code_url = $_SESSION['onecode_url'];
}else{
	$code_url = getdwz($code_url);
	if($code_url){
		$_SESSION['onecode_url'] = $code_url;
	}
}
?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">一码支付</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			<i class="fa fa-list"></i>&nbsp;产品介绍
		</div>
		<div class="panel-body">
		<p>一码支付是基于一个收款二维码，支持支付宝、微信、QQ等主流支付方式的收款产品。</p>
<p>商家只需要一个固定的二维码，就可以完成支付宝、微信、QQ等主流支付方式的收款，方便快捷。</p>
		</div>
	</div>
	<div class="row">
	<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			<i class="fa fa-qrcode"></i>&nbsp;一码支付配置
		</div>
		<div class="panel-body">
			<form class="form-horizontal devform">
				<div class="form-group">
					<label class="col-sm-3 control-label">收款方名称</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="codename" value="<?php echo $userrow['codename']?>" placeholder="留空默认显示“<?php echo $userrow['username']?>”" onkeydown="if(event.keyCode==13){$('#editName').click()}">
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-3 col-sm-8"><input type="button" id="editName" value="保存" class="btn btn-primary form-control"/><br/>
				 </div>
				</div>
			</form>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			<i class="fa fa-qrcode"></i>&nbsp;你的一码支付收款链接
		</div>
		<div class="panel-body">
		<p>你可以将收款链接发到QQ、微信等聊天工具，别人点击后可以直接输入金额付款。</p>
			<div class="form-group">
				<input class="form-control" type="text" id="code_url" value="<?php echo $code_url?>" readonly>
			</div>
			<p class="text-center"><a href="javascript:;" class="btn btn-success copy-btn" data-clipboard-text="<?php echo $code_url?>" title="点击复制">点击复制</a></p>
		</div>
	</div>
	</div>
	<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			<i class="fa fa-qrcode"></i>&nbsp;你的一码支付收款码
		</div>
		<div class="panel-body text-center">
			<input type="hidden" id="recName" value="<?php echo $userrow['codename']?$userrow['codename']:$userrow['username']?>">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">选择收款码风格</span>
					<select class="form-control" id="styleName">
					<option value="dongxue">风格1-冬雪</option>
					<option value="pikaqiu">风格2-皮卡丘</option>
					<option value="kanuobudingmao">风格3-布叮猫</option>
					<option value="niannianyouyu">风格4-年年有余</option>
					<option value="xiaohuangren">风格5-小黄人</option>
					<option value="qitao">风格6-乞讨</option>
					<option value="baobei">风格7-宝贝</option>
					<option value="toushi">风格8-投食</option>
					<option value="gongzhu">风格9-公主</option>
					<option value="qiuzanzhu">风格10-求赞助</option>
					<option value="huanyingdashang">风格11-欢迎打赏</option>
					<option value="yinlian">风格12-银联</option>
					<option value="yitiji">风格13-一体机</option>
					<option value="maomi">风格14-猫咪</option>
					<option value="longmao">风格15-龙猫</option>
					</select>
				</div>
			</div>
			<div id="load"><img src="/assets/img/loading.gif">&nbsp;正在生成中</div>
			<div id="qrcode" style="display:none;"><img class="img-responsive center-block" alt="收款码" id="endImg" style="max-width: 300px;"/><br/><a href="javascript:;" id="downImg" class="btn btn-success btn-sm">长按图片或点我保存</a></div>
			<div class="hide">
				<div id="code"></div>
				<canvas id="canvas"></canvas>
			</div>
		</div>
	</div>
	</div>
	</div>
</div>
    </div>
  </div>

<?php include 'foot.php';?>
<script src="../assets/layer/layer.js"></script>
<script src="//cdn.staticfile.org/clipboard.js/1.7.1/clipboard.min.js"></script>
<script src="//cdn.staticfile.org/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script src="//cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="./assets/js/onecode.js"></script>
