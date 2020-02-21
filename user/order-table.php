<?php
/**
 * 订单列表
**/
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");


function display_status($status,$notify){
	if($status==1)
		$msg = '<font color=green>已支付</font>';
	elseif($status==2)
		$msg = '<font color=red>已退款</font>';
	elseif($status==3)
		$msg = '<font color=red>已冻结</font>';
	else
		$msg = '<font color=blue>未支付</font>';
	if($notify==0 && $status>0)
		$msg .= '<br/><font color=green>通知成功</font>';
	elseif($status>0)
		$msg .= '<br/><font color=red>通知失败</font>';
	return $msg;
}

$paytype = [];
$paytypes = [];
$rs = $DB->getAll("SELECT * FROM pre_type WHERE status=1");
foreach($rs as $row){
	$paytype[$row['id']] = $row['showname'];
	$paytypes[$row['id']] = $row['name'];
}
unset($rs);

$sql=" uid=$uid";
$links='';
if(isset($_GET['paytype']) && $_GET['paytype']>0) {
	$paytype = intval($_GET['paytype']);
	$sql.=" AND A.`type`='$paytype'";
	$links.='&paytype='.$paytype;
}
if(isset($_GET['dstatus']) && $_GET['dstatus']==1) {
	$sql.=" AND A.status=1";
	$links.='&dstatus=1';
}
if(isset($_GET['kw']) && !empty($_GET['kw'])) {
	$kw=daddslashes($_GET['kw']);
	if($_GET['type']==1){
		$sql.=" AND A.`trade_no`='{$kw}'";
	}elseif($_GET['type']==2){
		$sql.=" AND A.`out_trade_no`='{$kw}'";
	}elseif($_GET['type']==3){
		$sql.=" AND A.`name` like '%{$kw}%'";
	}elseif($_GET['type']==4){
		$sql.=" AND A.`money`='{$kw}'";
	}elseif($_GET['type']==5){
		$kws = explode('>',$kw);
		$sql.=" AND A.`addtime`>='{$kws[0]}' AND A.`addtime`<='{$kws[1]}'";
	}
	$numrows=$DB->getColumn("SELECT count(*) from pre_order A WHERE{$sql}");
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 条订单';
	$link='&type='.$_GET['type'].'&kw='.$_GET['kw'].$links;
}else{
	$numrows=$DB->getColumn("SELECT count(*) from pre_order A WHERE{$sql}");
	$con='共有 <b>'.$numrows.'</b> 条订单';
	$link=$links;
}
?>
	  <div class="table-responsive">
        <table class="table table-striped table-bordered table-vcenter">
          <thead><tr><th>系统订单号/商户订单号</th><th>商品名称</th><th>商品金额</th><th>支付方式</th><th>创建时间/完成时间</th><th>状态</th><th>操作</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT A.*,B.plugin FROM pre_order A LEFT JOIN pre_channel B ON A.channel=B.id WHERE{$sql} order by trade_no desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '<tr><td>'.$res['trade_no'].'<br/>'.$res['out_trade_no'].'</td><td>'.$res['name'].'</td><td>￥ <b>'.$res['money'].'</b></td><td> <b><img src="/assets/icon/'.$paytypes[$res['type']].'.ico" width="16" onerror="this.style.display=\'none\'">'.$paytype[$res['type']].'</b></td><td>'.$res['addtime'].'<br/>'.$res['endtime'].'</td><td>'.display_status($res['status'], $res['notify']).'</td><td><a href="./record.php?type=3&kw='.$res['trade_no'].'" class="btn btn-info btn-xs">明细</a>&nbsp;<a href="javascript:callnotify(\''.$res['trade_no'].'\')" class="btn btn-success btn-xs">补单</a></td></tr>';
}
?>
          </tbody>
        </table>
      </div>
<?php
echo'<div class="text-center"><ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$first.$link.'\')">首页</a></li>';
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$prev.$link.'\')">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
$start=$page-10>1?$page-10:1;
$end=$page+10<$pages?$page+10:$pages;
for ($i=$start;$i<$page;$i++)
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$i.$link.'\')">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$end;$i++)
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$i.$link.'\')">'.$i .'</a></li>';
if ($page<$pages)
{
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$next.$link.'\')">&raquo;</a></li>';
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$last.$link.'\')">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul></div>';
