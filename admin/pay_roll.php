<?php
/**
 * 支付通道轮询设置
**/
include("../includes/common.php");
$title='支付通道轮询设置';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<style>
.form-inline .form-control{display: inline-block;width: auto;vertical-align: middle;}</style>
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
$rolltype = ['顺序轮询','随机轮询'];

$list = $DB->getAll("SELECT * FROM pre_roll");
?>
<div class="modal" id="modal-store" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInX">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span
							aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modal-title">轮询组修改/添加</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form-store">
					<input type="hidden" name="action" id="action"/>
					<input type="hidden" name="id" id="id"/>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right">显示名称</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" id="name" placeholder="仅显示使用，不要与其他轮询组名称重复">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">支付方式</label>
						<div class="col-sm-10">
							<select name="type" id="type" class="form-control">
								<option value="0">请选择支付方式</option><?php echo $type_select; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">轮询方式</label>
						<div class="col-sm-10">
							<select name="kind" id="kind" class="form-control">
							<option value="0">按顺序依次轮询</option><option value="1">按权重随机轮询</option>
							</select>
						</div>
					</div>
					<div class="form-group hide">
						<label class="col-sm-2 control-label">支付通道</label>
						<div class="col-sm-10">
							<select id="channel" class="form-control">
							</select>
						</div>
					</div>
					<!--div class="form-group">
						<label class="col-sm-2 control-label">通道配置</label>
						<div class="col-sm-10">
							<dl class="fieldlist" data-name="list" data-listidx="0">
								<dd class="form-inline">
									<select name="list[][channel]" class="form-control">
									</select>
									<input type="text" name="list[][weight]" class="form-control" value="" size="10" placeholder="权重(1-99)">
									<span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times"></i></span>
								</dd>
								<dd>
									<a href="javascript:;" class="btn btn-sm btn-success pay-append"><i class="fa fa-plus"></i> 追加</a>
								</dd>
							</dl>
						</div>
					</div-->
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary" id="store" onclick="save()">保存</button>
			</div>
			<div class="panel-footer">
          <span class="glyphicon glyphicon-info-sign"></span> 按顺序依次轮询不支持设置权重，按权重随机轮询支持设置每个通道的权重
        </div>
		</div>
	</div>
</div>

<div class="panel panel-info">
   <div class="panel-heading"><h3 class="panel-title">系统共有 <b><?php echo count($list);?></b> 个轮询组&nbsp;<span class="pull-right"><a href="javascript:addframe()" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> 新增</a></span></h3></div>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>显示名称</th><th>支付方式</th><th>轮询方式</th><th>轮询规则</th><th>状态</th><th>操作</th></tr></thead>
          <tbody>
<?php
foreach($list as $res)
{
echo '<tr><td><b>'.$res['id'].'</b></td><td>'.$res['name'].'</td><td>'.$paytype[$res['type']].'</td><td>'.$rolltype[$res['kind']].'</td><td>'.$res['info'].'</td><td>'.($res['status']==1?'<a class="btn btn-xs btn-success" onclick="setStatus('.$res['id'].',0)">已开启</a>':'<a class="btn btn-xs btn-warning" onclick="setStatus('.$res['id'].',1)">已关闭</a>').'</td><td><a class="btn btn-xs btn-primary" onclick="editInfo('.$res['id'].')">配置通道</a>&nbsp;<a class="btn btn-xs btn-info" onclick="editframe('.$res['id'].')">编辑</a>&nbsp;<a class="btn btn-xs btn-danger" onclick="delItem('.$res['id'].')">删除</a></td></tr>';
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
	$("#modal-title").html("新增轮询组");
	$("#action").val("add");
	$("#id").val('');
	$("#name").val('');
	$("#type").val(0);
	$("#kind").val(0);
}
function editframe(id){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=getRoll&id='+id,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				$("#modal-store").modal('show');
				$("#modal-title").html("修改轮询组");
				$("#action").val("edit");
				$("#id").val(data.data.id);
				$("#name").val(data.data.name);
				$("#type").val(data.data.type);
				$("#kind").val(data.data.kind);
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
	if($("#name").val()==''){
		layer.alert('请确保各项不能为空！');return false;
	}
	if($("#type").val()==0){
		layer.alert('请选择支付方式！');return false;
	}
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=saveRoll',
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
	var confirmobj = layer.confirm('你确实要删除此轮询组吗？', {
	  btn: ['确定','取消']
	}, function(){
	  $.ajax({
		type : 'GET',
		url : 'ajax.php?act=delRoll&id='+id,
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
		url : 'ajax.php?act=setRoll&id='+id+'&status='+status,
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
	$("#channel").empty();
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=rollInfo&id='+id,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				$.each(data.channels, function (i, res) {
					$("#channel").append('<option value="'+res.id+'">'+res.name+'</option>');
				})
				var item = '<div class="modal-body"><form class="form" id="form-info"><dl class="fieldlist" data-name="list" data-listidx="0">';
				item += '</dl><button type="button" id="save" onclick="saveInfo('+id+')" class="btn btn-primary btn-block">保存</button><br/>备注:顺序轮询设置权重值无效</form></div>';
				var area = [$(window).width() > 520 ? '520px' : '100%', '480px'];
				layer.open({
				  type: 1,
				  area: area,
				  title: '配置轮询组',
				  skin: 'layui-layer-rim',
				  content: item,
				  success: function(){
					  if(data.info == null){
						$(".fieldlist").append('<dd class="form-inline"><select name="list[0][channel]" class="form-control">'+$("#channel").html()+'</select> <input type="text" name="list[0][weight]" class="form-control" value="" size="10" placeholder="权重(1-99)"> <span class="btn btn-sm btn-danger" disabled><i class="fa fa-times"></i></span> </dd>');
					  }else{
						$.each(data.info, function (i, res) {
							var num = parseInt(Math.random()*(99999-10+1)+10,10);
							$(".fieldlist").append('<dd class="form-inline"><select name="list['+num+'][channel]" class="form-control" default="'+res.channel+'">'+$("#channel").html()+'</select> <input type="text" name="list['+num+'][weight]" class="form-control" value="'+res.weight+'" size="10" placeholder="权重(1-99)"> <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times"></i></span> </dd>');
							$("select[name='list["+num+"][channel]']").val(res.channel);
						})
					  }
					  $(".fieldlist").append('<dd><a href="javascript:;" class="btn btn-sm btn-success pay-append"><i class="fa fa-plus"></i> 追加</a></dd>');
				  }
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
		url : 'ajax.php?act=saveRollInfo&id='+id,
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
$(document).on("click", ".pay-append", function (e) {
	var select = $("#channel").html();
	var num = parseInt(Math.random()*(99999-10+1)+10,10);
	var html = '<dd class="form-inline"><select name="list['+num+'][channel]" class="form-control">'+select+'</select> <input type="text" name="list['+num+'][weight]" class="form-control" value="" size="10" placeholder="权重(1-99)"> <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times"></i></span> </dd>';
	$(this).parent().parent().find('dd[class="form-inline"]:last').append(html);
});
$(document).on("click", "dd .btn-remove", function () {
	var container = $(this).closest("dl");
	$(this).closest("dd").remove();
});
</script>