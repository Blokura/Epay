<?php
/**
 * 商户列表
**/
include("../includes/common.php");
$title='商户列表';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$select = '';
$rs = $DB->getAll("SELECT * FROM pre_group");
foreach($rs as $row){
	$select .= '<option value="'.$row['gid'].'">'.$row['name'].'</option>';
}
unset($rs);
?>
<style>
#orderItem .orderTitle{word-break:keep-all;}
#orderItem .orderContent{word-break:break-all;}
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
<div class="modal" id="modal-rmb">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">余额充值与扣除</h4>
			</div>
			<div class="modal-body">
				<form id="form-rmb" onsubmit="return false;">
					<input type="hidden" name="uid" value="">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon p-0">
								<select name="do"
										style="-webkit-border-radius: 0;height:20px;border: 0;outline: none !important;border-radius: 5px 0 0 5px;padding: 0 5px 0 5px;">
									<option value="0">充值</option>
									<option value="1">扣除</option>
								</select>
							</span>
							<input type="number" class="form-control" name="rmb" placeholder="输入金额">
							<span class="input-group-addon">元</span>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary" id="recharge">确定</button>
			</div>
		</div>
	</div>
</div>
<form onsubmit="return searchUser()" method="GET" class="form-inline">
  <div class="form-group">
    <label>搜索</label>
	<select name="column" class="form-control"><option value="uid">商户号</option><option value="key">密钥</option><option value="account">结算账号</option><option value="username">结算姓名</option><option value="url">域名</option><option value="qq">QQ</option><option value="phone">手机号码</option><option value="email">邮箱</option></select>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="value" placeholder="搜索内容">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>&nbsp;<a href="./uset.php?my=add" class="btn btn-success">添加商户</a>
  <a href="javascript:listTable('start')" class="btn btn-default" title="刷新订单列表"><i class="fa fa-refresh"></i></a>
</form>

<div id="listTable"></div>
    </div>
  </div>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script src="//cdn.staticfile.org/clipboard.js/1.7.1/clipboard.min.js"></script>
<script>
function listTable(query){
	var url = window.document.location.href.toString();
	var queryString = url.split("?")[1];
	query = query || queryString;
	if(query == 'start' || query == undefined){
		query = '';
		history.replaceState({}, null, './ulist.php');
	}else if(query != undefined){
		history.replaceState({}, null, './ulist.php?'+query);
	}
	layer.closeAll();
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ulist-table.php?'+query,
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
function searchUser(){
	var column=$("select[name='column']").val();
	var value=$("input[name='value']").val();
	if(value==''){
		listTable();
	}else{
		listTable('column='+column+'&value='+value);
	}
	return false;
}
function showKey(uid,key){
	var clipboard;
	var confirmobj = layer.confirm(key+'<input type="hidden" id="copyContent" value="'+key+'"/>', {
	  title:'查看密钥',shadeClose:true,btn: ['复制','重置','关闭'], success: function(){
		clipboard = new Clipboard('.layui-layer-btn0',{text: function() {return key;}});
		clipboard.on('success', function (e) {
			alert('复制成功！');
		});
		clipboard.on('error', function (e) {
			alert('复制失败，请长按链接后手动复制');
		});
	  }
	  ,end: function(){
		clipboard.destroy();
	  }
	}, function(){
	}, function(){
		$.ajax({
			type : 'GET',
			url : 'ajax.php?act=resetUser&uid='+uid,
			dataType : 'json',
			success : function(data) {
				if(data.code == 0){
					alert('重置密钥成功！');
					showKey(uid,data.key);
				}else{
					layer.alert(data.msg, {icon:2});
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
function setStatus(uid,type,status) {
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=setUser&uid='+uid+'&type='+type+'&status='+status,
		dataType : 'json',
		success : function(data) {
			if(data.code == 0){
				listTable();
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
function editGroup(uid, gid){
	layer.open({
	  type: 1,
	  shadeClose: true,
	  title: '修改用户组',
	  content: '<div class="modal-body"><form class="form" id="form-info"><div class="form-group"><select class="form-control" id="gid"><?php echo $select?></select><button type="button" id="save" onclick="saveGroup('+uid+')" class="btn btn-primary btn-block">保存</button></div></form></div>',
	  success: function(){
		  $("#gid").val(gid)
	  }
	});
}
function saveGroup(uid){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	var gid = $("#gid").val();
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=setUser&uid='+uid+'&type=group&status='+gid,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert(data.msg,{
					icon: 1,
					closeBtn: false
				});
				listTable();
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
function showRecharge(uid) {
	$("input[name='uid']").val(uid);
	$('#modal-rmb').modal('show');
}
function inputInfo(uid) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=user_settle_info&uid='+uid,
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
function saveInfo(uid) {
	var pay_type=$("#pay_type").val();
	var pay_account=$("#pay_account").val();
	var pay_name=$("#pay_name").val();
	if(pay_account=='' || pay_name==''){layer.alert('请确保每项不能为空！');return false;}
	$('#save').val('Loading');
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : "POST",
		url : "ajax.php?act=user_settle_save",
		data : {uid:uid,pay_type:pay_type,pay_account:pay_account,pay_name:pay_name},
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
function showCert(uid) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax.php?act=user_cert&uid='+uid,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				var item = '<table class="table table-condensed table-hover">';
				item += '<tr><td class="info">认证途径</td><td colspan="5">'+(data.cert==1?'支付宝快捷认证':'未实名认证')+'</td></tr><tr><td class="info">真实姓名</td><td colspan="5">'+data.certname+'</td></tr><tr><td class="info">身份证号</td><td colspan="5">'+data.certno+'</td></tr><tr><td class="info">认证时间</td><td colspan="5">'+data.certtime+'</td></tr>';
				item += '</table>';
				layer.open({
				  type: 1,
				  shadeClose: true,
				  title: '查看实名认证信息',
				  skin: 'layui-layer-rim',
				  content: item
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
$(document).ready(function(){
	$("#recharge").click(function(){
		var uid=$("input[name='uid']").val();
		var actdo=$("select[name='do']").val();
		var rmb=$("input[name='rmb']").val();
		if(rmb==''){layer.alert('请输入金额');return false;}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax.php?act=recharge",
			data : {uid:uid,actdo:actdo,rmb:rmb},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					layer.msg('修改余额成功');
					$('#modal-rmb').modal('hide');
					listTable();
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
	listTable();
})
</script>