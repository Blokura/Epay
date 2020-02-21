<?php
/**
 * 订单列表
**/
include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");


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
function display_operation($status, $trade_no){
	if($status==1)
		$msg = '<li><a href="javascript:setStatus(\''.$trade_no.'\', 0)">改未完成</a></li><li><a href="javascript:apirefund(\''.$trade_no.'\')">API退款</a></li><li><a href="javascript:refund(\''.$trade_no.'\')">手动退款</a></li><li><a href="javascript:freeze(\''.$trade_no.'\')">冻结订单</a></li><li role="separator" class="divider"></li><li><a href="javascript:callnotify(\''.$trade_no.'\')">重新通知</a></li><li><a href="javascript:setStatus(\''.$trade_no.'\', 5)">删除订单</a></li>';
	elseif($status==2)
		$msg = '<li><a href="javascript:setStatus(\''.$trade_no.'\', 0)">改未完成</a></li><li><a href="javascript:setStatus(\''.$trade_no.'\', 1)">改已完成</a></li><li role="separator" class="divider"></li><li><a href="javascript:callnotify(\''.$trade_no.'\')">重新通知</a></li><li><a href="javascript:setStatus(\''.$trade_no.'\', 5)">删除订单</a></li>';
	elseif($status==3)
		$msg = '<li><a href="javascript:unfreeze(\''.$trade_no.'\')">解冻订单</a></li><li role="separator" class="divider"></li><li><a href="javascript:callnotify(\''.$trade_no.'\')">重新通知</a></li><li><a href="javascript:setStatus(\''.$trade_no.'\', 5)">删除订单</a></li>';
	else
		$msg = '<li><a href="javascript:setStatus(\''.$trade_no.'\', 1)">改已完成</a></li><li role="separator" class="divider"></li><li><a href="javascript:callnotify(\''.$trade_no.'\')">重新通知</a></li><li><a href="javascript:setStatus(\''.$trade_no.'\', 5)">删除订单</a></li>';
	return $msg;
}

$paytype = [];
$paytypes = [];
$rs = $DB->getAll("SELECT * FROM pre_type");
foreach($rs as $row){
	$paytype[$row['id']] = $row['showname'];
	$paytypes[$row['id']] = $row['name'];
}
unset($rs);

$sqls="";
$links='';
if(isset($_GET['uid']) && !empty($_GET['uid'])) {
	$uid = intval($_GET['uid']);
	$sqls.=" AND A.`uid`='$uid'";
	$links.='&uid='.$uid;
}
if(isset($_GET['type']) && $_GET['type']>0) {
	$type = intval($_GET['type']);
	$sqls.=" AND A.`type`='$type'";
	$links.='&type='.$type;
}elseif(isset($_GET['channel']) && $_GET['channel']>0) {
	$channel = intval($_GET['channel']);
	$sqls.=" AND A.`channel`='$channel'";
	$links.='&channel='.$channel;
}
if(isset($_GET['dstatus']) && $_GET['dstatus']>0) {
	$dstatus = intval($_GET['dstatus']);
	$sqls.=" AND A.status={$dstatus}";
	$links.='&dstatus='.$dstatus;
}
if(isset($_GET['value']) && !empty($_GET['value'])) {
	if($_GET['column']=='name'){
		$sql=" A.`{$_GET['column']}` like '%{$_GET['value']}%'";
	}elseif($_GET['column']=='addtime'){
		$kws = explode('>',$_GET['value']);
		$sql=" AND A.`addtime`>='{$kws[0]}' AND A.`addtime`<='{$kws[1]}'";
	}else{
		$sql=" A.`{$_GET['column']}`='{$_GET['value']}'";
	}
	$sql.=$sqls;
	$numrows=$DB->getColumn("SELECT count(*) from pre_order A WHERE{$sql}");
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 条订单';
	$link='&column='.$_GET['column'].'&value='.$_GET['value'].$links;
}else{
	$sql=" 1";
	$sql.=$sqls;
	$numrows=$DB->getColumn("SELECT count(*) from pre_order A WHERE{$sql}");
	$con='共有 <b>'.$numrows.'</b> 条订单';
	$link=$links;
}
?>
	  <form name="form1" id="form1">
	  <div class="table-responsive">
<?php echo $con?>
        <table class="table table-striped table-bordered table-vcenter">
          <thead><tr><th>系统订单号<br/>商户订单号</th><th>商户号<br/>网站域名</th><th>商品名称<br/>订单金额</th><th>实际支付<br/>商户分成</th><th>支付方式(通道ID)<br/>支付插件</th><th>创建时间<br/>完成时间</th><th>支付状态<br/>通知状态</th><th>操作</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT A.*,B.plugin FROM pre_order A LEFT JOIN pre_channel B ON A.channel=B.id WHERE{$sql} order by trade_no desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '<tr><td><input type="checkbox" name="checkbox[]" id="list1" value="'.$res['trade_no'].'" onClick="unselectall1()"><b><a href="javascript:showOrder(\''.$res['trade_no'].'\')" title="点击查看详情">'.$res['trade_no'].'</a></b><br/>'.$res['out_trade_no'].'</td><td><a href="./ulist.php?my=search&column=uid&value='.$res['uid'].'" target="_blank">'.$res['uid'].'</a><br/><a onclick="openlink(\'http://'.$res['domain'].'\')">'.$res['domain'].'</a></td><td>'.$res['name'].'<br/>￥<b>'.$res['money'].'</b></td><td>￥<b>'.$res['realmoney'].'</b><br/>￥<b>'.$res['getmoney'].'</b></td><td><img src="/assets/icon/'.$paytypes[$res['type']].'.ico" width="16" onerror="this.style.display=\'none\'">'.$paytype[$res['type']].'('.$res['channel'].')<br/>'.$res['plugin'].'</td><td>'.$res['addtime'].'<br/>'.$res['endtime'].'</td><td>'.display_status($res['status'], $res['notify']).'</td><td><div class="btn-group" role="group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">操作订单 <span class="caret"></span></button><ul class="dropdown-menu">'.display_operation($res['status'], $res['trade_no']).'</ul></div></td></tr>';
}
?>
          </tbody>
        </table>
<input name="chkAll1" type="checkbox" id="chkAll1" onClick="this.value=check1(this.form.list1)" value="checkbox">&nbsp;全选&nbsp;
<select name="status"><option selected>操作订单</option><option value="0">改未完成</option><option value="1">改已完成</option><option value="2">冻结订单</option><option value="3">解冻订单</option><option value="4">删除订单</option></select>
<button type="button" onclick="operation()">确定</button>
      </div>
	 </form>
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
