<?php
include("../includes/common.php");
$title='彩虹易支付管理中心';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<?php
?>
<div class="container" style="padding-top:70px;">
<div class="col-xs-12 col-lg-9 center-block" style="float: none;">
<div class="row">
    <div class="col-xs-12 col-lg-8">
      <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title" id="title">后台管理首页</h3></div>
          <ul class="list-group">
            <li class="list-group-item"><span class="glyphicon glyphicon-stats"></span> <b>订单总数：</b><span id="count1"></span></li>
			<li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>商户数量：</b><span id="count2"></span></li>
			<li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>总计余额：</b><span id="usermoney"></span>元（1小时更新一次）</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>结算总额：</b><span id="settlemoney"></span>元（1小时更新一次）</li>
            <li class="list-group-item"><span class="glyphicon glyphicon-time"></span> <b>现在时间：</b> <?=$date?></li>
			</li>
          </ul>
      </div>
	</div>
	<div class="col-xs-12 col-lg-4">
      <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title" id="title">管理员信息</h3></div>
          <ul class="list-group text-center">
            <li class="list-group-item">
			<img src="<?php echo ($conf['kfqq'])?'//q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$conf['kfqq'].'&src_uin='.$conf['kfqq'].'&fid='.$conf['kfqq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'../assets/img/user.png'?>" alt="avatar" class="img-circle img-thumbnail"></br>
			<span class="text-muted"><strong>用户名：</strong><font color="blue"><?php echo $conf['admin_user']?></font></span><br/><span class="text-muted"><strong>用户权限：</strong><font color="orange">管理员</font></span></li>
			<li class="list-group-item"><a href="../" class="btn btn-xs btn-default">返回首页</a>&nbsp;<a href="./set.php?mod=account" class="btn btn-xs btn-info">修改密码</a>&nbsp;<a href="./login.php?logout" class="btn btn-xs btn-danger">退出登录</a>
			</li>
          </ul>
      </div>
	</div>
</div>
	  <div class="panel panel-success">
	    <div class="panel-heading"><h3 class="panel-title">支付方式收入统计（1小时更新一次）</h3></div>
          <table class="table table-bordered table-striped">
		    <thead><tr id="paytype_head"><th>日期</th></thead>
            <tbody id="paytype_list">
			</tbody>
          </table>
      </div>
	  <div class="panel panel-warning">
	    <div class="panel-heading"><h3 class="panel-title">支付通道收入统计（1小时更新一次）</h3></div>
          <table class="table table-bordered table-striped">
		    <thead><tr id="channel_head"><th>日期</th></thead>
            <tbody id="channel_list">
			</tbody>
          </table>
      </div>
    </div>
  </div>
<script>
$(document).ready(function(){
	$('#title').html('正在加载数据中...');
	$.ajax({
		type : "GET",
		url : "ajax.php?act=getcount",
		dataType : 'json',
		async: true,
		success : function(data) {
			$('#title').html('后台管理首页');
			$('#count1').html(data.count1);
			$('#count2').html(data.count2);
			$('#usermoney').html(data.usermoney);
			$('#settlemoney').html(data.settlemoney);

			var paytype=new Array();
			$.each(data.paytype, function(k, v){
				paytype.push(k);
				$("#paytype_head").append('<th>'+v+'</th>');
			});
			$("#paytype_head").append('<th>总计</th>');
			var order = '';
			$.each(paytype, function(k, v){
				if(typeof data.order_today.paytype[v] != "undefined")order+='<td>'+data.order_today.paytype[v]+'</td>';
				else order+='<td>0</td>';
			});
			$("#paytype_list").append('<tr><td>今日</td>'+order+'<td>'+data.order_today.all+'</td></tr>');
			$.each(data.order, function(k, v){
				var order = '';
				$.each(paytype, function(key, value){
					if(typeof v.paytype[value] != "undefined")order+='<td>'+v.paytype[value]+'</td>';
					else order+='<td>0</td>';
				});
				$("#paytype_list").append('<tr><td>'+k+'</td>'+order+'<td>'+v.all+'</td></tr>');
			});

			var channel=new Array();
			$.each(data.channel, function(k, v){
				channel.push(k);
				$("#channel_head").append('<th>'+v+'</th>');
			});
			$("#channel_head").append('<th>总计</th>');
			var order = '';
			$.each(channel, function(k, v){
				if(typeof data.order_today.channel[v] != "undefined")order+='<td>'+data.order_today.channel[v]+'</td>';
				else order+='<td>0</td>';
			});
			$("#channel_list").append('<tr><td>今日</td>'+order+'<td>'+data.order_today.all+'</td></tr>');
			$.each(data.order, function(k, v){
				var order = '';
				$.each(channel, function(key, value){
					if(typeof v.channel[value] != "undefined")order+='<td>'+v.channel[value]+'</td>';
					else order+='<td>0</td>';
				});
				$("#channel_list").append('<tr><td>'+k+'</td>'+order+'<td>'+v.all+'</td></tr>');
			});
		}
	});
})
</script>