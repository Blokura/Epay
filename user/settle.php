<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='结算记录';
include './head.php';
?>
<?php

function display_type($type){
	if($type==1)
		return '支付宝';
	elseif($type==2)
		return '微信';
	elseif($type==3)
		return 'QQ钱包';
	elseif($type==4)
		return '银行卡';
	else
		return 1;
}

function display_status($status, $id){
	if($status==1)
		return '<font color=green>已完成</font>';
	elseif($status==2)
		return '<font color=orange>正在结算</font>';
	elseif($status==3)
		return '<a href="javascript:showResult('.$id.')" title="点此查看失败原因"><font color=red>结算失败</font></a>';
	else
		return '<font color=blue>待结算</font>';
}

$numrows=$DB->query("SELECT * from pre_settle WHERE uid={$uid}")->rowCount();
$pagesize=20;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$list=$DB->query("SELECT * FROM pre_settle WHERE uid={$uid} order by id desc limit $offset,$pagesize")->fetchAll();

?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">结算记录</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			结算记录&nbsp;(<?php echo $numrows?>)
		</div>
		<div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>结算方式</th><th>结算账号</th><th>结算金额</th><th>实际到账</th><th>结算时间</th><th>状态</th></tr></thead>
          <tbody>
<?php
foreach($list as $res){
	echo '<tr><td>'.$res['id'].'</td><td>'.display_type($res['type']).($res['auto']!=1?'<small>[手动]</small>':null).'</td><td>'.$res['account'].'</td><td>￥ <b>'.$res['money'].'</b></td><td>￥ <b>'.$res['realmoney'].'</b></td><td>'.$res['addtime'].'</td><td>'.display_status($res['status'],$res['id']).'</td></tr>';
}
?>
		  </tbody>
        </table>
      </div>

	<footer class="panel-footer">
<?php
echo'<ul class="pagination">';
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
$start=$page-10>1?$page-10:1;
$end=$page+10<$pages?$page+10:$pages;
for ($i=$start;$i<$page;$i++)
echo '<li><a href="settle.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$end;$i++)
echo '<li><a href="settle.php?page='.$i.$link.'">'.$i .'</a></li>';
if ($page<$pages)
{
echo '<li><a href="settle.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="settle.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
</footer>
	</div>
</div>
    </div>
  </div>

<?php include 'foot.php';?>

<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
function showResult(id) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax2.php?act=settle_result&id='+id,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert(data.msg, {icon:0, title:'失败原因'});
			}else{
				layer.alert(data.msg, {icon:2});
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
</script>