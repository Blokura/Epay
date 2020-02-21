<?php
/**
 * 结算列表
**/
include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

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
		return '<a href="javascript:setResult('.$id.')" title="点此填写失败原因"><font color=red>结算失败</font></a>';
	else
		return '<font color=blue>待结算</font>';
}

if(isset($_GET['batch']) && !empty($_GET['batch'])) {
	$sql=" `batch`='{$_GET['batch']}'";
	$numrows=$DB->getColumn("SELECT count(*) from pre_settle WHERE{$sql}");
	$con='批次号 '.$_GET['batch'].' 共有 <b>'.$numrows.'</b> 条结算记录';
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}elseif(isset($_GET['value']) && !empty($_GET['value'])) {
	$sql=" `{$_GET['column']}`='{$_GET['value']}'";
	$numrows=$DB->getColumn("SELECT count(*) from pre_settle WHERE{$sql}");
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 条结算记录';
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
	$numrows=$DB->getColumn("SELECT count(*) from pre_settle WHERE 1");
	$sql=" 1";
	$con='共有 <b>'.$numrows.'</b> 条结算记录';
}
?>
	<form name="form1" id="form1">
	  <div class="table-responsive">
<?php echo $con?>
        <table class="table table-striped table-bordered table-vcenter">
          <thead><tr><th>ID</th><th>商户号</th><th>结算方式</th><th>结算账号/姓名</th><th>结算金额/实际到账</th><th>添加时间</th><th>完成时间</th><th>状态</th><th>操作</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM pre_settle WHERE{$sql} order by id desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '<tr><td><input type="checkbox" name="checkbox[]" id="list1" value="'.$res['id'].'" onClick="unselectall1()"><b>'.$res['id'].'</b></td><td><a href="./ulist.php?column=uid&value='.$res['uid'].'" target="_blank">'.$res['uid'].'</a></td><td>'.display_type($res['type']).($res['auto']!=1?'<small>[手动]</small>':null).'</td><td><span onclick="inputInfo('.$res['id'].')">'.$res['account'].'&nbsp;'.$res['username'].'</span></td><td><b>'.$res['money'].'</b>&nbsp;/&nbsp;<b>'.$res['realmoney'].'</b></td><td>'.$res['addtime'].'</td><td>'.$res['endtime'].'</td><td>'.display_status($res['status'],$res['id']).'</td><td><select onChange="javascript:setStatus(\''.$res['id'].'\',this.value)" class=""><option selected>变更状态</option><option value="0">待结算</option><option value="1">已完成</option><option value="2">正在结算</option><option value="3">结算失败</option><option value="4">删除记录</option></select></td></tr>';
}
?>
          </tbody>
        </table>
		<input name="chkAll1" type="checkbox" id="chkAll1" onClick="this.value=check1(this.form.list1)" value="checkbox">&nbsp;全选&nbsp;
<select name="status"><option selected>批量修改</option><option value="0">待结算</option><option value="1">已完成</option><option value="2">正在结算</option><option value="3">结算失败</option><option value="4">删除记录</option></select>
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
