<?php
/**
 * 支付方式
**/
include("../includes/common.php");
$title='支付方式';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-md-8 center-block" style="float: none;">
<?php
function display_device($device){
	if($device==1)
		return 'PC';
	elseif($device==2)
		return 'Mobile';
	else
		return 'PC+Mobile';
}

$list = $DB->getAll("SELECT * FROM pre_type");
?>
<div class="modal" id="modal-store" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInX">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span
							aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modal-title">支付方式修改/添加</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form-store">
					<input type="hidden" name="action" id="action"/>
					<input type="hidden" name="id" id="id"/>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right"></label>
						<div class="col-sm-10">
							<div class="alert alert-warning">
								注意：同一个调用值+支持设备不能重复
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">调用值</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" id="name" placeholder="仅限英文，要与支付文档一致">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">显示名称</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="showname" id="showname" placeholder="仅显示使用">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">支持设备</label>
						<div class="col-sm-10">
							<select name="device" id="device" class="form-control">
								<option value="0">PC+Mobile</option>
								<option value="1">PC</option>
								<option value="2">Mobile</option>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary" id="store" onclick="save()">保存</button>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-info">
   <div class="panel-heading"><h3 class="panel-title">系统共有 <b><?php echo count($list);?></b> 个支付方式&nbsp;<span class="pull-right"><a href="javascript:addframe()" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> 新增</a></span></h3></div>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>调用值</th><th>名称</th><th>支持设备</th><th>状态</th><th>操作</th></tr></thead>
          <tbody>
<?php
foreach($list as $res)
{
echo '<tr><td><b>'.$res['name'].'</b></td><td>'.$res['showname'].'</td><td>'.display_device($res['device']).'</td><td>'.($res['status']==1?'<a class="btn btn-xs btn-success" onclick="setStatus('.$res['id'].',0)">已开启</a>':'<a class="btn btn-xs btn-warning" onclick="setStatus('.$res['id'].',1)">已关闭</a>').'</td><td><a class="btn btn-xs btn-info" onclick="editframe('.$res['id'].')">编辑</a>&nbsp;<a class="btn btn-xs btn-danger" onclick="delItem('.$res['id'].')">删除</a></td></tr>';
}
?>
          </tbody>
        </table>
      </div>
	</div>
    </div>
  </div>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
function addframe(){
	$("#modal-store").modal('show');
	$("#modal-title").html("新增支付方式");
	$("#action").val("add");
	$("#id").val('');
	$("#name").val('');
	$("#showname").val('');
	$("#device").val(0);
}
function editframe(id){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=getPayType&id='+id,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				$("#modal-store").modal('show');
				$("#modal-title").html("修改支付方式");
				$("#action").val("edit");
				$("#id").val(data.data.id);
				$("#name").val(data.data.name);
				$("#showname").val(data.data.showname);
				$("#device").val(data.data.device);
			}else{
				layer.alert(data.msg, {icon: 2})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function save(){
	if($("#name").val()==''||$("#showname").val()==''){
		layer.alert('请确保各项不能为空！');return false;
	}
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=savePayType',
		data : $("#form-store").serialize(),
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert(data.msg,{
					icon: 1,
					closeBtn: false
				}, function(){
				  window.location.reload()
				});
			}else{
				layer.alert(data.msg, {icon: 2})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function delItem(id) {
	if(id<4){
		layer.msg('系统自带支付方式暂不支持删除');
		return false;
	}
	var confirmobj = layer.confirm('你确实要删除此支付方式吗？', {
	  btn: ['确定','取消']
	}, function(){
	  $.ajax({
		type : 'GET',
		url : 'ajax.php?act=delPayType&id='+id,
		dataType : 'json',
		success : function(data) {
			if(data.code == 0){
				window.location.reload()
			}else{
				layer.alert(data.msg, {icon: 2});
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
function setStatus(id,status) {
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=setPayType&id='+id+'&status='+status,
		dataType : 'json',
		success : function(data) {
			if(data.code == 0){
				window.location.reload()
			}else{
				layer.msg(data.msg, {icon:2, time:1500});
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
</script>