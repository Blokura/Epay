<?php
/**
 * 支付通道
**/
include("../includes/common.php");
$title='支付通道';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-md-10 center-block" style="float: none;">
<?php

$paytype = [];
$type_select = '';
$rs = $DB->getAll("SELECT * FROM pre_type");
foreach($rs as $row){
	$paytype[$row['id']] = $row['showname'];
	$type_select .= '<option value="'.$row['id'].'">'.$row['showname'].'</option>';
}
unset($rs);

$list = $DB->getAll("SELECT * FROM pre_channel");
?>
<div class="modal" id="modal-store" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInX">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span
							aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modal-title">支付通道修改/添加</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form-store">
					<input type="hidden" name="action" id="action"/>
					<input type="hidden" name="id" id="id"/>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">显示名称</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" id="name" placeholder="仅显示使用，不要与其他通道名称重复">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">分成比例</label>
						<div class="col-sm-10">
							<div class="input-group"><input type="text" class="form-control" name="rate" id="rate" placeholder="在没配置用户组的情况下以此费率为准"><span class="input-group-addon">%</span></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">支付方式</label>
						<div class="col-sm-10">
							<select name="type" id="type" class="form-control" onchange="changeType()">
								<option value="0">请选择支付方式</option><?php echo $type_select; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">支付插件</label>
						<div class="col-sm-10">
							<select name="plugin" id="plugin" class="form-control">
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
   <div class="panel-heading"><h3 class="panel-title">系统共有 <b><?php echo count($list);?></b> 个支付通道&nbsp;<span class="pull-right"><a href="javascript:addframe()" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> 新增</a></span></h3></div>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>显示名称</th><th>分成比例</th><th>支付方式</th><th>支付插件</th><th>状态</th><th>操作</th></tr></thead>
          <tbody>
<?php
foreach($list as $res)
{
echo '<tr><td><b>'.$res['id'].'</b></td><td>'.$res['name'].'</td><td>'.$res['rate'].'</td><td>'.$paytype[$res['type']].'</td><td><span onclick="showPlugin(\''.$res['plugin'].'\')" title="查看支付插件详情">'.$res['plugin'].'</span></td><td>'.($res['status']==1?'<a class="btn btn-xs btn-success" onclick="setStatus('.$res['id'].',0)">已开启</a>':'<a class="btn btn-xs btn-warning" onclick="setStatus('.$res['id'].',1)">已关闭</a>').'</td><td><a class="btn btn-xs btn-primary" onclick="editInfo('.$res['id'].')">配置密钥</a>&nbsp;<a class="btn btn-xs btn-info" onclick="editframe('.$res['id'].')">编辑</a>&nbsp;<a class="btn btn-xs btn-danger" onclick="delItem('.$res['id'].')">删除</a>&nbsp;<a href="./order.php?channel='.$res['id'].'" target="_blank" class="btn btn-xs btn-warning">订单</a></td></tr>';
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
function changeType(plugin){
	plugin = plugin || null;
	var typeid = $("#type").val();
	if(typeid==0)return;
	$("#plugin").empty();
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=getPlugins&typeid='+typeid,
		dataType : 'json',
		success : function(data) {
			if(data.code == 0){
				$.each(data.data, function (i, res) {
					$("#plugin").append('<option value="'+res.name+'">'+res.showname+'</option>');
				})
				if(plugin!=null)$("#plugin").val(plugin);
			}else{
				layer.msg(data.msg, {icon:2, time:1500})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function addframe(){
	$("#modal-store").modal('show');
	$("#modal-title").html("新增支付通道");
	$("#action").val("add");
	$("#id").val('');
	$("#name").val('');
	$("#rate").val('');
	$("#type").val(0);
	$("#plugin").empty();
}
function editframe(id){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=getChannel&id='+id,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				$("#modal-store").modal('show');
				$("#modal-title").html("修改支付通道");
				$("#action").val("edit");
				$("#id").val(data.data.id);
				$("#name").val(data.data.name);
				$("#rate").val(data.data.rate);
				$("#type").val(data.data.type);
				changeType(data.data.plugin)
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
	if($("#name").val()==''||$("#rate").val()==''){
		layer.alert('请确保各项不能为空！');return false;
	}
	if($("#type").val()==0){
		layer.alert('请选择支付方式！');return false;
	}
	if($("#plugin").val()==0 || $("#plugin").val()==null){
		layer.alert('请选择支付插件！');return false;
	}
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=saveChannel',
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
	var confirmobj = layer.confirm('你确实要删除此支付通道吗？', {
	  btn: ['确定','取消']
	}, function(){
	  $.ajax({
		type : 'GET',
		url : 'ajax.php?act=delChannel&id='+id,
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
		url : 'ajax.php?act=setChannel&id='+id+'&status='+status,
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
function editInfo(id){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=channelInfo&id='+id,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				var area = [$(window).width() > 520 ? '520px' : '100%', ';max-height:100%'];
				layer.open({
				  type: 1,
				  area: area,
				  title: '配置对接密钥',
				  skin: 'layui-layer-rim',
				  content: data.data
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
function saveInfo(id){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=saveChannelInfo&id='+id,
		data : $("#form-info").serialize(),
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
function showPlugin(name){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=getPlugin&name='+name,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				var item = '<table class="table table-condensed table-hover">';
				item += '<tr><td class="info">插件名称</td><td colspan="5">'+data.data.name+'</td></tr><tr><td class="info">插件描述</td><td colspan="5">'+data.data.showname+'</td></tr><tr><td class="info">插件网址</td><td colspan="5"><a href="'+data.data.link+'" target="_blank">'+data.data.author+'</a></td></tr><tr><td class="info">插件路径</td><td colspan="5">/plugins/'+data.data.name+'/</td></tr>';
				item += '</table>';
				layer.open({
				  type: 1,
				  shadeClose: true,
				  title: '支付插件详情',
				  content: item
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
</script>