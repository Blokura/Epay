<?php
/**
 * 结算列表
**/
include("../includes/common.php");
$title='结算列表';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<style>
.form-inline .form-control {
    display: inline-block;
    width: auto;
    vertical-align: middle;
}
.form-inline .form-group {
    display: inline-block;
    margin-bottom: 0;
    vertical-align: middle;
}
</style>
  <div class="container" style="padding-top:70px;">
    <div class="col-md-12 center-block" style="float: none;">

<form onsubmit="return searchSettle()" method="GET" class="form-inline">
  <div class="form-group">
    <label>搜索</label>
	<select name="column" class="form-control"><option value="uid">商户号</option><option value="type">结算方式</option><option value="account">结算账号</option><option value="username">姓名</option><option value="batch">批次号</option></select>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="value" placeholder="搜索内容">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>
  <a href="settle.php" class="btn btn-success">批量结算</a>
  <a href="javascript:listTable('start')" class="btn btn-default" title="刷新明细列表"><i class="fa fa-refresh"></i></a>
</form>

<div id="listTable"></div>
    </div>
  </div>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script>
var checkflag1 = "false";
function check1(field) {
if (checkflag1 == "false") {
for (i = 0; i < field.length; i++) {
field[i].checked = true;}
checkflag1 = "true";
return "false"; }
else {
for (i = 0; i < field.length; i++) {
field[i].checked = false; }
checkflag1 = "false";
return "true"; }
}

function unselectall1()
{
    if(document.form1.chkAll1.checked){
	document.form1.chkAll1.checked = document.form1.chkAll1.checked&0;
	checkflag1 = "false";
    }
}

function listTable(query){
	var url = window.document.location.href.toString();
	var queryString = url.split("?")[1];
	query = query || queryString;
	if(query == 'start' || query == undefined){
		query = '';
		history.replaceState({}, null, './slist.php');
	}else if(query != undefined){
		history.replaceState({}, null, './slist.php?'+query);
	}
	layer.closeAll();
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'slist-table.php?'+query,
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
function searchSettle(){
	var column=$("select[name='column']").val();
	var value=$("input[name='value']").val();
	if(value==''){
		listTable();
	}else{
		listTable('column='+column+'&value='+value);
	}
	return false;
}
function operation(){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=opslist',
		data : $('#form1').serialize(),
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				listTable();
				layer.alert(data.msg);
			}else{
				layer.alert(data.msg);
			}
		},
		error:function(data){
			layer.msg('请求超时');
			listTable();
		}
	});
	return false;
}
function setStatusDo(id, status) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'get',
		url : 'ajax.php',
		data : 'act=setSettleStatus&id=' + id + '&status=' + status,
		dataType : 'json',
		success : function(ret) {
			layer.close(ii);
			if (ret['code'] != 200) {
				alert(ret['msg'] ? ret['msg'] : '操作失败');
			}
			listTable();
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function setStatus(id, status) {
	if(status==4){
		var confirmobj = layer.confirm('你确实要删除此记录吗？删除记录并不会退回余额', {
			btn: ['确定','取消']
		}, function(){
			setStatusDo(id, status);
		});
	}else{
		setStatusDo(id, status);
	}
}
function setResult(id) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=settle_result',
		data : {id:id},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.prompt({title: '填写失败原因', value: data.result, formType: 2}, function(text, index){
					var ii = layer.load(2, {shade:[0.1,'#fff']});
				$.ajax({
					type : 'POST',
					url : 'ajax.php?act=settle_setresult',
					data : {id:id,result:text},
					dataType : 'json',
					success : function(data) {
						layer.close(ii);
						if(data.code == 0){
							layer.msg('填写失败原因成功');
						}else{
							layer.alert(data.msg);
						}
					},
					error:function(data){
						layer.msg('服务器错误');
						return false;
					}
				});
			});
			}else{
				layer.alert(data.msg);
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function inputInfo(id) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=settle_info&id='+id,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.open({
				  type: 1,
				  title: '修改数据',
				  skin: 'layui-layer-rim',
				  content: data.data,
				  success: function(){
					  $("#pay_type").val(data.pay_type);
				  }
				});
			}else{
				layer.alert(data.msg);
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	});
}
function saveInfo(id) {
	var pay_type=$("#pay_type").val();
	var pay_account=$("#pay_account").val();
	var pay_name=$("#pay_name").val();
	if(pay_account=='' || pay_name==''){layer.alert('请确保每项不能为空！');return false;}
	$('#save').val('Loading');
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : "POST",
		url : "ajax.php?act=settle_save",
		data : {id:id,pay_type:pay_type,pay_account:pay_account,pay_name:pay_name},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.msg('保存成功！');
				listTable();
			}else{
				layer.alert(data.msg);
			}
			$('#save').val('保存');
		} 
	});
}
$(document).ready(function(){
	listTable();
})
</script>