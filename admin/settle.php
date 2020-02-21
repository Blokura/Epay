<?php
/**
 * 批量结算
**/
include("../includes/common.php");
$title='批量结算';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<style>
img.logo{width:14px;height:14px;margin:0 5px 0 3px;}
</style>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">批量结算操作<span class="pull-right"><a href="javascript:createBatch()" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> 生成结算批次</a></span></h3></div>
		<table class="table table-striped">
          <thead><tr><th>批次号</th><th>总金额</th><th>总数量</th><th>生成时间</th><th>操作</th></thead>
          <tbody>
<?php
$pagesize=15;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM pre_batch order by time desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '<tr><td><b>'.$res['batch'].'</b></td><td>'.$res['allmoney'].'</td><td>'.$res['count'].'</td><td>'.$res['time'].'</td><td><a href="./slist.php?batch='.$res['batch'].'" class="btn btn-xs btn-info">结算列表</a>&nbsp;<a href="./download.php?batch='.$res['batch'].'&allmoney='.$res['allmoney'].'" class="btn btn-xs btn-warning">下载CSV</a>&nbsp;<a href="javascript:transfer(\''.$res['batch'].'\')" class="btn btn-xs btn-success">批量转账</a>&nbsp;<a href="javascript:completeBatch(\''.$res['batch'].'\')" class="btn btn-xs btn-primary">改为完成</a></td></tr>';
}
?>
		  </tbody>
        </table>
<?php
echo'<div class="text-center"><ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="settle.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="settle.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="settle.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
if($pages>=10)$sss=$page+10;else $sss=$pages;
for ($i=$page+1;$i<=$sss;$i++)
echo '<li><a href="settle.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="settle.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="settle.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul></div>';
#分页
?>
		<div class="panel-footer">
          <span class="glyphicon glyphicon-info-sign"></span> 结算标准：金额大于<?php echo $conf['settle_money']?>元，或主动申请的<br/><span class="glyphicon glyphicon-info-sign"></span> 点击 生成结算批次 之后会将所有"<font color="blue">待结算</font>"状态的记录更改为"<font color="orange">正在结算</font>"，通过转账接口转账之后会将状态更改为"<font color="green">已完成</font>"，如果是手动转账，需要手动将状态更改为"<font color="green">已完成</font>"
        </div>
      </div>
    </div>
  </div>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
function createBatch(){
	var confirmobj = layer.confirm('你确定要生成结算批次吗？', {
	  btn: ['确定','取消']
	}, function(){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=create_batch',
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert('生成结算批次成功！该批次总数量:'+data.count+'，总金额:'+data.allmoney, {
					icon: 1,
					closeBtn: false
				},function(){
					window.location.reload();
				});
			}else{
				layer.alert(data.msg, {icon: 0})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
	}, function(){
	  layer.close(confirmobj);
	});
}
function transfer(batch){
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=paypwd_check',
		dataType : 'json',
		success : function(data) {
			if(data.code == 0){
				var paymsg = '';
				paymsg+='<a class="btn btn-default btn-block" href="transfer_alipay.php?batch='+batch+'" style="margin-top:10px;"><img width="20" src="../assets/icon/alipay.ico" class="logo">支付宝接口转账</a>';
				paymsg+='<a class="btn btn-default btn-block" href="transfer_wx.php?batch='+batch+'" style="margin-top:10px;"><img width="20" src="../assets/icon/wechat.ico" class="logo">微信企业付款</a>';
				paymsg+='<a class="btn btn-default btn-block" href="transfer_qq.php?batch='+batch+'" style="margin-top:10px;"><img width="20" src="../assets/icon/qqpay.ico" class="logo">QQ钱包企业付款</a>';
				layer.alert('<center>'+paymsg+'<hr><a class="btn btn-default btn-block" onclick="layer.closeAll()">关闭</a></center>',{
					btn:[],
					title:'请选择批量转账方式',
					closeBtn: false
				});
			}else{
				layer.prompt({title: '请输入支付密码', value: '', formType: 1}, function(text, index){
					$.ajax({
						type : 'POST',
						url : 'ajax.php?act=paypwd_input',
						data : {paypwd:text},
						dataType : 'json',
						success : function(data) {
							if(data.code == 0){
								transfer(batch);
							}else{
								layer.alert(data.msg, {icon: 2})
							}
						},
						error:function(data){
							layer.msg('服务器错误');
							return false;
						}
					});
				})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function completeBatch(batch){
	var confirmobj = layer.confirm('是否将该批次所有结算记录状态改为已完成？', {
	  btn: ['确定','取消']
	}, function(){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=complete_batch',
		data : {batch: batch},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert(data.msg, {
					icon: 1,
					closeBtn: false
				});
			}else{
				layer.alert(data.msg, {icon: 0})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
	}, function(){
	  layer.close(confirmobj);
	});
}
</script>