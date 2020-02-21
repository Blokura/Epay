<?php
/**
 * 风控记录
**/
include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");


if(isset($_GET['value']) && !empty($_GET['value'])) {
	$sql=" `{$_GET['column']}`='{$_GET['value']}'";
	$numrows=$DB->getColumn("SELECT count(*) from pre_risk WHERE{$sql}");
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 条记录';
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
	$numrows=$DB->getColumn("SELECT count(*) from pre_risk WHERE 1");
	$sql=" 1";
	$con='共有 <b>'.$numrows.'</b> 条记录';
}
?>
	  <div class="table-responsive">
<?php echo $con?>
        <table class="table table-striped table-bordered table-vcenter">
          <thead><tr><th>ID</th><th>商户号</th><th>风控类型</th><th>风控网址</th><th>风控内容</th><th>时间</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM pre_risk WHERE{$sql} order by id desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '<tr><td><b>'.$res['id'].'</b></td><td><b><a href="./ulist.php?column=uid&value='.$res['uid'].'" target="_blank">'.$res['uid'].'</a></b></td><td>关键词屏蔽</td><td>'.$res['url'].'</td><td>'.$res['content'].'</td><td>'.$res['date'].'</td></tr>';
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
