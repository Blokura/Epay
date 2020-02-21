<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='资金明细';
include './head.php';
?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">资金明细</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			<h3 class="panel-title">资金明细<a href="javascript:listTable('start')" class="btn btn-default btn-xs pull-right" title="刷新明细列表"><i class="fa fa-refresh"></i></a></h3>
		</div>
	  <div class="row wrapper">
	    <form onsubmit="return searchOrder()" method="GET" class="form">
		  <div class="col-md-2">
	        <div class="form-group">
			<select class="form-control" name="type">
			  <option value="1">操作类型</option>
			  <option value="2">变更金额</option>
			  <option value="3">关联订单号</option>
			</select>
		    </div>
		  </div>
		  <div class="col-md-6">
			<div class="form-group" id="searchword">
			  <input type="text" class="form-control" name="kw" placeholder="搜索内容">
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
</div>
    </div>
  </div>

<?php include 'foot.php';?>
<a style="display: none;" href="" id="vurl" rel="noreferrer" target="_blank"></a>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
function listTable(query){
	var url = window.document.location.href.toString();
	var queryString = url.split("?")[1];
	query = query || queryString;
	if(query == 'start' || query == undefined){
		query = '';
		history.replaceState({}, null, './record.php');
	}else if(query != undefined){
		history.replaceState({}, null, './record.php?'+query);
	}
	layer.closeAll();
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'record-table.php?'+query,
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
	if(kw==''){
		listTable();
	}else{
		listTable('type='+type+'&kw='+kw);
	}
	return false;
}
$(document).ready(function(){
	listTable();
})
</script>