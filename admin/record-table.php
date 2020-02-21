<?php
/**
 * 收支明细
**/
include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");


if(isset($_GET['value']) && !empty($_GET['value'])) {
	$sql=" `{$_GET['column']}`='{$_GET['value']}'";
	$numrows=$DB->getColumn("SELECT count(*) from pre_record WHERE{$sql}");
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 条记录';
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
	$numrows=$DB->getColumn("SELECT count(*) from pre_record WHERE 1");
	$sql=" 1";
	$con='共有 <b>'.$numrows.'</b> 条记录';
}
?>
	  <div class="table-responsive">
<?php echo $con?>
        <table class="table table-striped table-bordered table-vcenter">
          <thead><tr><th>商户号</th><th>操作类型</th><th>变更金额</th><th>变更前金额</th><th>变更后金额</th><th>时间</th><th>关联订单号</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM pre_record WHERE{$sql} order by id desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '<tr><td><b><a href="./ulist.php?column=uid&value='.$res['uid'].'" target="_blank">'.$res['uid'].'</a></b></td><td>'.($res['action']==2?'<font color="red">'.$res['type'].'</font>':'<font color="green">'.$res['type'].'</font>').'</td><td>'.($res['action']==2?'- ':'+ ').$res['money'].'</td><td>'.$res['oldmoney'].'</td><td>'.$res['newmoney'].'</td><td>'.$res['date'].'</td><td>'.($res['trade_no']?'<a href="./order.php?column=trade_no&value='.$res['trade_no'].'" target="_blank">'.$res['trade_no'].'</a>':'无').'</td></tr>';
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
