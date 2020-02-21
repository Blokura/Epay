<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='订单记录';
include './head.php';
?>
<?php

$type_select = '<option value="0">所有支付方式</option>';
$rs = $DB->getAll("SELECT * FROM pre_type WHERE status=1");
foreach($rs as $row){
	$type_select .= '<option value="'.$row['id'].'">'.$row['showname'].'</option>';
}
unset($rs);

?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">订单记录</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			<h3 class="panel-title">订单记录<a href="javascript:searchClear()" class="btn btn-default btn-xs pull-right" title="刷新订单列表"><i class="fa fa-refresh"></i></a></h3>
		</div>
	  <div class="row wrapper">
	    <form onsubmit="return searchOrder()" method="GET" class="form">
		  <div class="col-md-2">
	        <div class="form-group">
			<select class="form-control" name="type">
			  <option value="1">系统订单号</option>
			  <option value="2">商户订单号</option>
			  <option value="3">商品名称</option>
			  <option value="4">商品金额</option>
			  <option value="5">交易时间</option>
			</select>
		    </div>
		  </div>
		  <div class="col-md-6">
			<div class="form-group" id="searchword">
			  <input type="text" class="form-control" name="kw" placeholder="搜索内容，时间支持区间查询 例如2018-06-07 16:15>2018-07-06 14:00">
			</div>
		  </div>
		  <div class="col-md-2">
			<div class="form-group">
			  <select name="paytype" class="form-control" default="<?php echo $_GET['type']?$_GET['type']:0?>"><?php echo $type_select?></select>
		    </div>
		  </div>
		  <div class="col-md-2">
			 <div class="form-group">
				<button class="btn btn-default" type="submit">搜索</button>
			 </div>
		  </div>
		</form>
      </div>
<div id="listTable"></div>
	</div>
<?php if($DB->getRow("SHOW TABLES LIKE 'pay_order_old'")){echo '<a href="./order_old.php" class="btn btn-default btn-xs">历史订单查询</a>';}?>
</div>
    </div>
  </div>

<?php include 'foot.php';?>
<a style="display: none;" href="" id="vurl" rel="noreferrer" target="_blank"></a>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
var dstatus = 0;
function listTable(query){
	var url = window.document.location.href.toString();
	var queryString = url.split("?")[1];
	query = query || queryString;
	if(query == 'start' || query == undefined){
		query = '';
		history.replaceState({}, null, './order.php');
	}else if(query != undefined){
		history.replaceState({}, null, './order.php?'+query);
	}
	layer.closeAll();
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'order-table.php?dstatus='+dstatus+'&'+query,
		dataType : 'html',
		cache : false,
		success : function(data) {
			layer.close(ii);
			$("#listTable").html(data)
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function searchOrder(){
	var type=$("select[name='type']").val();
	var kw=$("input[name='kw']").val();
	var paytype=$("select[name='paytype']").val();
	if(kw==''){
		listTable('paytype='+paytype);
	}else{
		listTable('type='+type+'&kw='+kw+'&paytype='+paytype);
	}
	return false;
}
function searchClear(){
	$("select[name='type']").val(1);
	$("input[name='kw']").val('');
	$("select[name='paytype']").val(0);
	listTable('start');
}
function callnotify(trade_no){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax2.php?act=notify',
		data : {trade_no:trade_no},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				$("#vurl").attr("href",data.url);
				document.getElementById("vurl").click();
				listTable();
			}else{
				layer.alert(data.msg);
			}
		},
		error:function(data){
			layer.msg('服务器错误');
		}
	});
	return false;
}
function callreturn(trade_no){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax2.php?act=notify',
		data : {trade_no:trade_no,isreturn:1},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				$("#vurl").attr("href",data.url);
				document.getElementById("vurl").click();
				listTable();
			}else{
				layer.alert(data.msg);
			}
		},
		error:function(data){
			layer.msg('服务器错误');
		}
	});
	return false;
}
$(document).ready(function(){
	var items = $("select[default]");
	for (i = 0; i < items.length; i++) {
		$(items[i]).val($(items[i]).attr("default")||0);
	}
	listTable();
	$("#dstatus").change(function () {
		var val = $(this).val();
		dstatus = val;
		listTable();
	});
})
</script>