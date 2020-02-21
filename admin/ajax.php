<?php
include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

if(strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])===false)exit('{"code":403}');

@header('Content-Type: application/json; charset=UTF-8');

switch($act){
case 'getcount':
	$thtime=date("Y-m-d").' 00:00:00';
	$count1=$DB->getColumn("SELECT count(*) from pre_order");
	$count2=$DB->getColumn("SELECT count(*) from pre_user");

	$paytype = [];
	$rs = $DB->getAll("SELECT id,name,showname FROM pre_type WHERE status=1");
	foreach($rs as $row){
		$paytype[$row['id']] = $row['showname'];
	}
	unset($rs);

	$channel = [];
	$rs = $DB->getAll("SELECT id,name FROM pre_channel WHERE status=1");
	foreach($rs as $row){
		$channel[$row['id']] = $row['name'];
	}
	unset($rs);

	$tongji_cachetime=getSetting('tongji_cachetime', true);
	$tongji_cache = $CACHE->read('tongji');
	if($tongji_cachetime+3600>=time() && $tongji_cache){
		$array = unserialize($tongji_cache);
		$result=["code"=>0,"type"=>"cache","paytype"=>$paytype,"channel"=>$channel,"count1"=>$count1,"count2"=>$count2,"usermoney"=>round($array['usermoney'],2),"settlemoney"=>round($array['settlemoney'],2),"order_today"=>$array['order_today'],"order"=>[]];
	}else{
		$usermoney=$DB->getColumn("SELECT SUM(money) FROM pre_user WHERE money!='0.00'");
		$settlemoney=$DB->getColumn("SELECT SUM(money) FROM pre_settle");

		$today=date("Y-m-d");
		$rs=$DB->query("SELECT type,channel,money from pre_order where status=1 and date>='$today'");
		foreach($paytype as $id=>$type){
			$order_paytype[$id]=0;
		}
		foreach($channel as $id=>$type){
			$order_channel[$id]=0;
		}
		while($row = $rs->fetch())
		{
			$order_paytype[$row['type']]+=$row['money'];
			$order_channel[$row['channel']]+=$row['money'];
		}
		foreach($order_paytype as $k=>$v){
			$order_paytype[$k] = round($v,2);
		}
		foreach($order_channel as $k=>$v){
			$order_channel[$k] = round($v,2);
		}
		$allmoney=0;
		foreach($order_paytype as $order){
			$allmoney+=$order;
		}
		$order_today['all']=round($allmoney,2);
		$order_today['paytype']=$order_paytype;
		$order_today['channel']=$order_channel;

		saveSetting('tongji_cachetime',time());
		$CACHE->save('tongji',serialize(["usermoney"=>$usermoney,"settlemoney"=>$settlemoney,"order_today"=>$order_today]));

		$result=["code"=>0,"type"=>"online","paytype"=>$paytype,"channel"=>$channel,"count1"=>$count1,"count2"=>$count2,"usermoney"=>round($usermoney,2),"settlemoney"=>round($settlemoney,2),"order_today"=>$order_today,"order"=>[]];
	}
	for($i=1;$i<7;$i++){
		$day = date("Ymd", strtotime("-{$i} day"));
		if($order_tongji = $CACHE->read('order_'.$day)){
			$result["order"][$day] = unserialize($order_tongji);
		}else{
			break;
		}
	}
	exit(json_encode($result));
break;
case 'uploadimg':
	if($_POST['do']=='upload'){
		$type = $_POST['type'];
		$filename = $type.'_'.md5_file($_FILES['file']['tmp_name']).'.png';
		$fileurl = 'assets/img/Product/'.$filename;
		if(copy($_FILES['file']['tmp_name'], ROOT.'assets/img/Product/'.$filename)){
			exit('{"code":0,"msg":"succ","url":"'.$fileurl.'"}');
		}else{
			exit('{"code":-1,"msg":"上传失败，请确保有本地写入权限"}');
		}
	}
	exit('{"code":-1,"msg":"null"}');
break;
case 'setStatus':
	$trade_no=trim($_GET['trade_no']);
	$status=is_numeric($_GET['status'])?intval($_GET['status']):exit('{"code":200}');
	if($status==5){
		if($DB->exec("DELETE FROM pre_order WHERE trade_no='$trade_no'"))
			exit('{"code":200}');
		else
			exit('{"code":400,"msg":"删除订单失败！['.$DB->error().']"}');
	}else{
		if($DB->exec("update pre_order set status='$status' where trade_no='$trade_no'")!==false)
			exit('{"code":200}');
		else
			exit('{"code":400,"msg":"修改订单失败！['.$DB->error().']"}');
	}
break;
case 'order':
	$trade_no=trim($_GET['trade_no']);
	$row=$DB->getRow("select A.*,B.showname typename,C.name channelname from pre_order A,pre_type B,pre_channel C where trade_no='$trade_no' and A.type=B.id and A.channel=C.id limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前订单不存在或未成功选择支付通道！"}');
	$result=array("code"=>0,"msg"=>"succ","data"=>$row);
	exit(json_encode($result));
break;
case 'operation':
	$status=is_numeric($_POST['status'])?intval($_POST['status']):exit('{"code":-1,"msg":"请选择操作"}');
	$checkbox=$_POST['checkbox'];
	$i=0;
	foreach($checkbox as $trade_no){
		if($status==4)$DB->exec("DELETE FROM pre_order WHERE trade_no='$trade_no'");
		elseif($status==3){
			$row=$DB->getRow("select uid,getmoney,status from pre_order where trade_no='$trade_no' limit 1");
			if($row && $row['status']==3 && $row['getmoney']>0){
				if(changeUserMoney($row['uid'], $row['getmoney'], true, '解冻订单', $trade_no))
					$DB->exec("update pre_order set status='1' where trade_no='$trade_no'");
			}
		}
		elseif($status==2){
			$row=$DB->getRow("select uid,getmoney,status from pre_order where trade_no='$trade_no' limit 1");
			if($row && $row['status']==1 && $row['getmoney']>0){
				if(changeUserMoney($row['uid'], $row['getmoney'], false, '冻结订单', $trade_no))
					$DB->exec("update pre_order set status='3' where trade_no='$trade_no'");
			}
		}
		else $DB->exec("update pre_order set status='$status' where trade_no='$trade_no' limit 1");
		$i++;
	}
	exit('{"code":0,"msg":"成功改变'.$i.'条订单状态"}');
break;
case 'getmoney': //退款查询
	if(!$conf['admin_paypwd'])exit('{"code":-1,"msg":"你还未设置支付密码"}');
	$trade_no=trim($_POST['trade_no']);
	$api=isset($_POST['api'])?intval($_POST['api']):0;
	$row=$DB->getRow("select * from pre_order where trade_no='$trade_no' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前订单不存在！"}');
	if($row['status']!=1)
		exit('{"code":-1,"msg":"只支持退款已支付状态的订单"}');
	if($api==1){
		if(!$row['api_trade_no'])
			exit('{"code":-1,"msg":"接口订单号不存在"}');
		$channel = \lib\Channel::get($row['channel']);
		if(!$channel){
			exit('{"code":-1,"msg":"当前支付通道信息不存在"}');
		}
		if(\lib\Plugin::isrefund($channel['plugin'])==false){
			exit('{"code":-1,"msg":"当前支付通道不支持API退款"}');
		}
		$money = $row['money'];
	}else{
		$money = $row['getmoney'];
	}
	exit('{"code":0,"money":"'.$money.'"}');
break;
case 'refund': //退款操作
	$trade_no=trim($_POST['trade_no']);
	$row=$DB->getRow("select uid,getmoney,status from pre_order where trade_no='$trade_no' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前订单不存在！"}');
	if($row['status']!=1)
		exit('{"code":-1,"msg":"只支持退款已支付状态的订单"}');
	if($row['getmoney']>0){
		changeUserMoney($row['uid'], $row['getmoney'], false, '订单退款', $trade_no);
		$DB->exec("update pre_order set status='2' where trade_no='$trade_no'");
	}
	exit('{"code":0,"msg":"已成功从UID:'.$row['uid'].'扣除'.$row['getmoney'].'元余额"}');
break;
case 'apirefund': //API退款操作
	$trade_no=trim($_POST['trade_no']);
	$paypwd=trim($_POST['paypwd']);
	if($paypwd!=$conf['admin_paypwd'])
		exit('{"code":-1,"msg":"支付密码输入错误！"}');
	$row=$DB->getRow("select uid,money,getmoney,status from pre_order where trade_no='$trade_no' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前订单不存在！"}');
	if($row['status']!=1)
		exit('{"code":-1,"msg":"只支持退款已支付状态的订单"}');
	$message = null;
	if(api_refund($trade_no, $message)){
		if($row['getmoney']>0){
			if(changeUserMoney($row['uid'], $row['getmoney'], false, '订单退款', $trade_no)){
				$addstr = '，并成功从UID:'.$row['uid'].'扣除'.$row['getmoney'].'元余额';
			}
			$DB->exec("update pre_order set status='2' where trade_no='$trade_no'");
		}
		exit('{"code":0,"msg":"API退款成功！退款金额￥'.$row['money'].$addstr.'"}');
	}else{
		exit('{"code":-1,"msg":"API退款失败：'.$message.'"}');
	}
break;
case 'freeze': //冻结订单
	$trade_no=trim($_POST['trade_no']);
	$row=$DB->getRow("select uid,getmoney,status from pre_order where trade_no='$trade_no' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前订单不存在！"}');
	if($row['status']!=1)
		exit('{"code":-1,"msg":"只支持冻结已支付状态的订单"}');
	if($row['getmoney']>0){
		changeUserMoney($row['uid'], $row['getmoney'], false, '订单冻结', $trade_no);
		$DB->exec("update pre_order set status='3' where trade_no='$trade_no'");
	}
	exit('{"code":0,"msg":"已成功从UID:'.$row['uid'].'冻结'.$row['getmoney'].'元余额"}');
break;
case 'unfreeze': //解冻订单
	$trade_no=trim($_POST['trade_no']);
	$row=$DB->getRow("select uid,getmoney,status from pre_order where trade_no='$trade_no' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前订单不存在！"}');
	if($row['status']!=3)
		exit('{"code":-1,"msg":"只支持解冻已冻结状态的订单"}');
	if($row['getmoney']>0){
		changeUserMoney($row['uid'], $row['getmoney'], true, '订单解冻', $trade_no);
		$DB->exec("update pre_order set status='1' where trade_no='$trade_no'");
	}
	exit('{"code":0,"msg":"已成功为UID:'.$row['uid'].'恢复'.$row['getmoney'].'元余额"}');
break;
case 'notify':
	$trade_no=trim($_POST['trade_no']);
	$row=$DB->getRow("select * from pre_order where trade_no='$trade_no' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前订单不存在！"}');
	$url=creat_callback($row);
	if($row['notify']>0)
		$DB->exec("update pre_order set notify=0 where trade_no='$trade_no'");
	exit('{"code":0,"url":"'.($_POST['isreturn']==1?$url['return']:$url['notify']).'"}');
break;
case 'getPayType':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_type where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前支付方式不存在！"}');
	$result = ['code'=>0,'msg'=>'succ','data'=>$row];
	exit(json_encode($result));
break;
case 'setPayType':
	$id=intval($_GET['id']);
	$status=intval($_GET['status']);
	$row=$DB->getRow("select * from pre_type where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前支付方式不存在！"}');
	$sql = "UPDATE pre_type SET status='$status' WHERE id='$id'";
	if($DB->exec($sql))exit('{"code":0,"msg":"修改支付方式成功！"}');
	else exit('{"code":-1,"msg":"修改支付方式失败['.$DB->error().']"}');
break;
case 'delPayType':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_type where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前支付方式不存在！"}');
	$row=$DB->getRow("select * from pre_channel where type='$id' limit 1");
	if($row)
		exit('{"code":-1,"msg":"删除失败，存在使用该支付方式的支付通道"}');
	$sql = "DELETE FROM pre_type WHERE id='$id'";
	if($DB->exec($sql))exit('{"code":0,"msg":"删除支付方式成功！"}');
	else exit('{"code":-1,"msg":"删除支付方式失败['.$DB->error().']"}');
break;
case 'savePayType':
	if($_POST['action'] == 'add'){
		$name=trim($_POST['name']);
		$showname=trim($_POST['showname']);
		$device=intval($_POST['device']);
		if(!preg_match('/^[a-zA-Z0-9]+$/',$name)){
			exit('{"code":-1,"msg":"调用值不符合规则"}');
		}
		$row=$DB->getRow("select * from pre_type where name='$name' and device='$device' limit 1");
		if($row)
			exit('{"code":-1,"msg":"同一个调用值+支持设备不能重复"}');
		$sql = "INSERT INTO pre_type (name, showname, device, status) VALUES ('{$name}','{$showname}',{$device},1)";
		if($DB->exec($sql))exit('{"code":0,"msg":"新增支付方式成功！"}');
		else exit('{"code":-1,"msg":"新增支付方式失败['.$DB->error().']"}');
	}else{
		$id=intval($_POST['id']);
		$name=trim($_POST['name']);
		$showname=trim($_POST['showname']);
		$device=intval($_POST['device']);
		if(!preg_match('/^[a-zA-Z0-9]+$/',$name)){
			exit('{"code":-1,"msg":"调用值不符合规则"}');
		}
		$row=$DB->getRow("select * from pre_type where name='$name' and device='$device' and id<>$id limit 1");
		if($row)
			exit('{"code":-1,"msg":"同一个调用值+支持设备不能重复"}');
		$sql = "UPDATE pre_type SET name='{$name}',showname='{$showname}',device='{$device}' WHERE id='$id'";
		if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改支付方式成功！"}');
		else exit('{"code":-1,"msg":"修改支付方式失败['.$DB->error().']"}');
	}
break;
case 'getPlugin':
	$name = trim($_GET['name']);
	$row=$DB->getRow("select * from pre_plugin where name='$name'");
	if($row){
		$result = ['code'=>0,'msg'=>'succ','data'=>$row];
		exit(json_encode($result));
	}
	else exit('{"code":-1,"msg":"当前支付插件不存在！"}');
break;
case 'getPlugins':
	$typeid = intval($_GET['typeid']);
	$type=$DB->getColumn("select name from pre_type where id='$typeid' limit 1");
	if(!$type)
		exit('{"code":-1,"msg":"当前支付方式不存在！"}');
	$list=$DB->getAll("select name,showname from pre_plugin where types like '%$type%'");
	if($list){
		$result = ['code'=>0,'msg'=>'succ','data'=>$list];
		exit(json_encode($result));
	}
	else exit('{"code":-1,"msg":"没有找到支持该支付方式的插件"}');
break;
case 'getChannel':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_channel where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前支付通道不存在！"}');
	$result = ['code'=>0,'msg'=>'succ','data'=>$row];
	exit(json_encode($result));
break;
case 'getChannels':
	$typeid = intval($_GET['typeid']);
	$type=$DB->getColumn("select name from pre_type where id='$typeid' limit 1");
	if(!$type)
		exit('{"code":-1,"msg":"当前支付方式不存在！"}');
	$list=$DB->getAll("select id,name from pre_channel where type='$typeid' and status=1");
	if($list){
		$result = ['code'=>0,'msg'=>'succ','data'=>$list];
		exit(json_encode($result));
	}
	else exit('{"code":-1,"msg":"没有找到支持该支付方式的通道"}');
break;
case 'setChannel':
	$id=intval($_GET['id']);
	$status=intval($_GET['status']);
	$row=$DB->getRow("select * from pre_channel where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前支付通道不存在！"}');
	if($status==1 && (empty($row['appid']) || empty($row['appkey']))){
		exit('{"code":-1,"msg":"请先配置好密钥后再开启"}');
	}
	$sql = "UPDATE pre_channel SET status='$status' WHERE id='$id'";
	if($DB->exec($sql))exit('{"code":0,"msg":"修改支付通道成功！"}');
	else exit('{"code":-1,"msg":"修改支付通道失败['.$DB->error().']"}');
break;
case 'delChannel':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_channel where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前支付通道不存在！"}');
	$sql = "DELETE FROM pre_channel WHERE id='$id'";
	if($DB->exec($sql))exit('{"code":0,"msg":"删除支付通道成功！"}');
	else exit('{"code":-1,"msg":"删除支付通道失败['.$DB->error().']"}');
break;
case 'saveChannel':
	if($_POST['action'] == 'add'){
		$name=trim($_POST['name']);
		$rate=trim($_POST['rate']);
		$type=intval($_POST['type']);
		$plugin=trim($_POST['plugin']);
		if(!preg_match('/^[0-9.]+$/',$rate)){
			exit('{"code":-1,"msg":"分成比例不符合规则"}');
		}
		$row=$DB->getRow("select * from pre_channel where name='$name' limit 1");
		if($row)
			exit('{"code":-1,"msg":"支付通道名称重复"}');
		$sql = "INSERT INTO pre_channel (name, rate, type, plugin) VALUES ('{$name}', '{$rate}', {$type}, '{$plugin}')";
		if($DB->exec($sql))exit('{"code":0,"msg":"新增支付通道成功！"}');
		else exit('{"code":-1,"msg":"新增支付通道失败['.$DB->error().']"}');
	}else{
		$id=intval($_POST['id']);
		$name=trim($_POST['name']);
		$rate=trim($_POST['rate']);
		$type=intval($_POST['type']);
		$plugin=trim($_POST['plugin']);
		if(!preg_match('/^[0-9.]+$/',$rate)){
			exit('{"code":-1,"msg":"分成比例不符合规则"}');
		}
		$row=$DB->getRow("select * from pre_channel where name='$name' and id<>$id limit 1");
		if($row)
			exit('{"code":-1,"msg":"支付通道名称重复"}');
		$sql = "UPDATE pre_channel SET name='{$name}',rate='{$rate}',type='{$type}',plugin='{$plugin}' WHERE id='$id'";
		if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改支付通道成功！"}');
		else exit('{"code":-1,"msg":"修改支付通道失败['.$DB->error().']"}');
	}
break;
case 'channelInfo':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_channel where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前支付通道不存在！"}');
	$apptype = explode(',',$row['apptype']);
	$plugin=$DB->getRow("select `inputs`,`select` from `pre_plugin` where `name`='{$row['plugin']}' limit 1");
	if(!$plugin)
		exit('{"code":-1,"msg":"当前支付插件不存在！"}');
	$arr = explode(',',$plugin['inputs']);
	$inputs = [];
	foreach($arr as $item){
		$a = explode(':',$item);
		$inputs[$a[0]] = $a[1];
	}
	$data = '<div class="modal-body"><form class="form" id="form-info">';
	if(!empty($plugin['select'])){
		$arr = explode(',',$plugin['select']);
		$select = '';
		foreach($arr as $item){
			$a = explode(':',$item);
			$select .= '<label><input type="checkbox" '.(in_array($a[0],$apptype)?'checked':null).' name="apptype[]" value="'.$a[0].'">'.$a[1].'</label>&nbsp;';
		}
		$data .= '<div class="form-group"><input type="hidden" id="isapptype" name="isapptype" value="1"/><label>请选择可用的接口：</label><br/><div class="checkbox">'.$select.'</div></div>';
	}
	if($inputs['appid'])$data .= '<div class="form-group"><label>'.$inputs['appid'].'：</label><br/><input type="text" id="appid" name="appid" value="'.$row['appid'].'" class="form-control" required/></div>';
	if($inputs['appkey'])$data .= '<div class="form-group"><label>'.$inputs['appkey'].'：</label><br/><textarea id="appkey" name="appkey" rows="2" class="form-control" required>'.$row['appkey'].'</textarea></div>';
	if($inputs['appsecret'])$data .= '<div class="form-group"><label>'.$inputs['appsecret'].'：</label><br/><textarea id="appsecret" name="appsecret" rows="2" class="form-control" required>'.$row['appsecret'].'</textarea></div>';
	if($inputs['appurl'])$data .= '<div class="form-group"><label>'.$inputs['appurl'].'：</label><br/><input type="text" id="appurl" name="appurl" value="'.$row['appurl'].'" class="form-control" required/></div>';
	if($inputs['appmchid'])$data .= '<div class="form-group"><label>'.$inputs['appmchid'].'：</label><br/><input type="text" id="appmchid" name="appmchid" value="'.$row['appmchid'].'" class="form-control" required/></div>';

	$data .= '<button type="button" id="save" onclick="saveInfo('.$id.')" class="btn btn-primary btn-block">保存</button></form></div>';
	$result=array("code"=>0,"msg"=>"succ","data"=>$data);
	exit(json_encode($result));
break;
case 'saveChannelInfo':
	$id=intval($_GET['id']);
	$appid=isset($_POST['appid'])?trim($_POST['appid']):null;
	$appkey=isset($_POST['appkey'])?trim($_POST['appkey']):null;
	$appsecret=isset($_POST['appsecret'])?trim($_POST['appsecret']):null;
	$appurl=isset($_POST['appurl'])?trim($_POST['appurl']):null;
	$appmchid=isset($_POST['appmchid'])?trim($_POST['appmchid']):null;
	if(isset($_POST['isapptype'])){
		if(!isset($_POST['apptype']) || count($_POST['apptype'])<=0)exit('{"code":-1,"msg":"请至少选择一个可用的支付接口"}');
		$apptype=implode(',',$_POST['apptype']);
	}else{
		$apptype=null;
	}
	$sql = "UPDATE pre_channel SET appid='{$appid}',appkey='{$appkey}',appsecret='{$appsecret}',appurl='{$appurl}',appmchid='{$appmchid}',apptype='{$apptype}' WHERE id='$id'";
	if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改支付密钥成功！"}');
	else exit('{"code":-1,"msg":"修改支付密钥失败['.$DB->error().']"}');
break;
case 'getRoll':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_roll where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前轮询组不存在！"}');
	$result = ['code'=>0,'msg'=>'succ','data'=>$row];
	exit(json_encode($result));
break;
case 'setRoll':
	$id=intval($_GET['id']);
	$status=intval($_GET['status']);
	$row=$DB->getRow("select * from pre_roll where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前轮询组不存在！"}');
	if($status==1 && empty($row['info'])){
		exit('{"code":-1,"msg":"请先配置好支付通道后再开启"}');
	}
	$sql = "UPDATE pre_roll SET status='$status' WHERE id='$id'";
	if($DB->exec($sql))exit('{"code":0,"msg":"修改轮询组成功！"}');
	else exit('{"code":-1,"msg":"修改轮询组失败['.$DB->error().']"}');
break;
case 'delRoll':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_roll where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前轮询组不存在！"}');
	$sql = "DELETE FROM pre_roll WHERE id='$id'";
	if($DB->exec($sql))exit('{"code":0,"msg":"删除轮询组成功！"}');
	else exit('{"code":-1,"msg":"删除轮询组失败['.$DB->error().']"}');
break;
case 'saveRoll':
	if($_POST['action'] == 'add'){
		$name=trim($_POST['name']);
		$type=intval($_POST['type']);
		$kind=intval($_POST['kind']);
		$row=$DB->getRow("select * from pre_roll where name='$name' limit 1");
		if($row)
			exit('{"code":-1,"msg":"轮询组名称重复"}');
		$sql = "INSERT INTO pre_roll (name, type, kind) VALUES ('{$name}', {$type}, {$kind})";
		if($DB->exec($sql))exit('{"code":0,"msg":"新增轮询组成功！"}');
		else exit('{"code":-1,"msg":"新增轮询组失败['.$DB->error().']"}');
	}else{
		$id=intval($_POST['id']);
		$name=trim($_POST['name']);
		$type=intval($_POST['type']);
		$kind=intval($_POST['kind']);
		$row=$DB->getRow("select * from pre_roll where name='$name' and id<>$id limit 1");
		if($row)
			exit('{"code":-1,"msg":"轮询组名称重复"}');
		$sql = "UPDATE pre_roll SET name='{$name}',type='{$type}',kind='{$kind}' WHERE id='$id'";
		if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改轮询组成功！"}');
		else exit('{"code":-1,"msg":"修改轮询组失败['.$DB->error().']"}');
	}
break;
case 'rollInfo':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_roll where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前轮询组不存在！"}');
	$list=$DB->getAll("select id,name from pre_channel where type='{$row['type']}' and status=1");
	if(!$list)exit('{"code":-1,"msg":"没有找到支持该支付方式的通道"}');
	if(!empty($row['info'])){
		$arr = explode(',',$row['info']);
		$info = [];
		foreach($arr as $item){
			$a = explode(':',$item);
			$info[] = ['channel'=>$a[0], 'weight'=>$a[1]?$a[1]:1];
		}
	}else{
		$info = null;
	}
	$result=array("code"=>0,"msg"=>"succ","channels"=>$list,"info"=>$info);
	exit(json_encode($result));
break;
case 'saveRollInfo':
	$id=intval($_GET['id']);
	$row=$DB->getRow("select * from pre_roll where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前轮询组不存在！"}');
	$list=$_POST['list'];
	if(empty($list))
		exit('{"code":-1,"msg":"通道配置不能为空！"}');
	$info = '';
	foreach($list as $a){
		$info .= $row['kind']==1 ? $a['channel'].':'.$a['weight'].',' : $a['channel'].',';
	}
	$info = trim($info,',');
	if(empty($info))
		exit('{"code":-1,"msg":"通道配置不能为空！"}');
	$sql = "UPDATE pre_roll SET info='{$info}' WHERE id='$id'";
	if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改轮询组成功！"}');
	else exit('{"code":-1,"msg":"修改轮询组失败['.$DB->error().']"}');
break;
case 'getGroup':
	$gid=intval($_GET['gid']);
	$row=$DB->getRow("select * from pre_group where gid='$gid' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前用户组不存在！"}');
	$result = ['code'=>0,'msg'=>'succ','gid'=>$gid,'name'=>$row['name'],'info'=>json_decode($row['info'],true)];
	exit(json_encode($result));
break;
case 'delGroup':
	$gid=intval($_GET['gid']);
	$row=$DB->getRow("select * from pre_group where gid='$gid' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前用户组不存在！"}');
	$sql = "DELETE FROM pre_group WHERE gid='$gid'";
	if($DB->exec($sql))exit('{"code":0,"msg":"删除用户组成功！"}');
	else exit('{"code":-1,"msg":"删除用户组失败['.$DB->error().']"}');
break;
case 'saveGroup':
	if($_POST['action'] == 'add'){
		$name=trim($_POST['name']);
		$row=$DB->getRow("select * from pre_group where name='$name' limit 1");
		if($row)
			exit('{"code":-1,"msg":"用户组名称重复"}');
		$info=$_POST['info'];
		$info=json_encode($info);
		$sql = "INSERT INTO pre_group (name, info) VALUES ('{$name}', '{$info}')";
		if($DB->exec($sql))exit('{"code":0,"msg":"新增用户组成功！"}');
		else exit('{"code":-1,"msg":"新增用户组失败['.$DB->error().']"}');
	}elseif($_POST['action'] == 'changebuy'){
		$gid=intval($_POST['gid']);
		$status=intval($_POST['status']);
		$sql = "UPDATE pre_group SET isbuy='{$status}' WHERE gid='$gid'";
		if($DB->exec($sql))exit('{"code":0,"msg":"修改上架状态成功！"}');
		else exit('{"code":-1,"msg":"修改上架状态失败['.$DB->error().']"}');
	}else{
		$gid=intval($_POST['gid']);
		$name=trim($_POST['name']);
		$row=$DB->getRow("select * from pre_group where name='$name' and gid<>$gid limit 1");
		if($row)
			exit('{"code":-1,"msg":"用户组名称重复"}');
		$info=$_POST['info'];
		$info=json_encode($info);
		$sql = "UPDATE pre_group SET name='{$name}',info='{$info}' WHERE gid='$gid'";
		if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改用户组成功！"}');
		else exit('{"code":-1,"msg":"修改用户组失败['.$DB->error().']"}');
	}
break;
case 'saveGroupPrice':
	$prices = $_POST['price'];
	$sorts = $_POST['sort'];
	foreach($prices as $gid=>$item){
		$price = trim($item);
		$sort = trim($sorts[$gid]);
		if(empty($price)||!is_numeric($price))exit('{"code":-1,"msg":"GID:'.$gid.'的售价填写错误"}');
		$DB->exec("UPDATE pre_group SET price='{$price}',sort='{$sort}' WHERE gid='$gid'");
	}
	exit('{"code":0,"msg":"保存成功！"}');
break;
case 'setUser':
	$uid=intval($_GET['uid']);
	$type=trim($_GET['type']);
	$status=intval($_GET['status']);
	if($type=='pay')$sql = "UPDATE pre_user SET pay='$status' WHERE uid='$uid'";
	elseif($type=='settle')$sql = "UPDATE pre_user SET settle='$status' WHERE uid='$uid'";
	elseif($type=='group')$sql = "UPDATE pre_user SET gid='$status' WHERE uid='$uid'";
	else $sql = "UPDATE pre_user SET status='$status' WHERE uid='$uid'";
	if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改用户成功！"}');
	else exit('{"code":-1,"msg":"修改用户失败['.$DB->error().']"}');
break;
case 'resetUser':
	$uid=intval($_GET['uid']);
	$key = random(32);
	$sql = "UPDATE pre_user SET `key`='$key' WHERE uid='$uid'";
	if($DB->exec($sql)!==false)exit('{"code":0,"msg":"重置密钥成功","key":"'.$key.'"}');
	else exit('{"code":-1,"msg":"重置密钥失败['.$DB->error().']"}');
break;
case 'user_settle_info':
	$uid=intval($_GET['uid']);
	$rows=$DB->getRow("select * from pre_user where uid='$uid' limit 1");
	if(!$rows)
		exit('{"code":-1,"msg":"当前用户不存在！"}');
	$data = '<div class="form-group"><div class="input-group"><div class="input-group-addon">结算方式</div><select class="form-control" id="pay_type" default="'.$rows['settle_id'].'">'.($conf['settle_alipay']?'<option value="1">支付宝</option>':null).''.($conf['settle_wxpay']?'<option value="2">微信</option>':null).''.($conf['settle_qqpay']?'<option value="3">QQ钱包</option>':null).''.($conf['settle_bank']?'<option value="4">银行卡</option>':null).'</select></div></div>';
	$data .= '<div class="form-group"><div class="input-group"><div class="input-group-addon">结算账号</div><input type="text" id="pay_account" value="'.$rows['account'].'" class="form-control" required/></div></div>';
	$data .= '<div class="form-group"><div class="input-group"><div class="input-group-addon">真实姓名</div><input type="text" id="pay_name" value="'.$rows['username'].'" class="form-control" required/></div></div>';
	$data .= '<input type="submit" id="save" onclick="saveInfo('.$uid.')" class="btn btn-primary btn-block" value="保存">';
	$result=array("code"=>0,"msg"=>"succ","data"=>$data,"pay_type"=>$rows['settle_id']);
	exit(json_encode($result));
break;
case 'user_settle_save':
	$uid=intval($_POST['uid']);
	$pay_type=trim(daddslashes($_POST['pay_type']));
	$pay_account=trim(daddslashes($_POST['pay_account']));
	$pay_name=trim(daddslashes($_POST['pay_name']));
	$sds=$DB->exec("update `pre_user` set `settle_id`='$pay_type',`account`='$pay_account',`username`='$pay_name' where `uid`='$uid'");
	if($sds!==false)
		exit('{"code":0,"msg":"修改记录成功！"}');
	else
		exit('{"code":-1,"msg":"修改记录失败！'.$DB->error().'"}');
break;
case 'user_cert':
	$uid=intval($_GET['uid']);
	$rows=$DB->getRow("select cert,certno,certname,certtime from pre_user where uid='$uid' limit 1");
	if(!$rows)
		exit('{"code":-1,"msg":"当前用户不存在！"}');
	$result = ['code'=>0,'msg'=>'succ','uid'=>$uid,'cert'=>$rows['cert'],'certno'=>$rows['certno'],'certname'=>$rows['certname'],'certtime'=>$rows['certtime']];
	exit(json_encode($result));
break;
case 'recharge':
	$uid=intval($_POST['uid']);
	$do=$_POST['actdo'];
	$rmb=floatval($_POST['rmb']);
	$row=$DB->getRow("select uid,money from pre_user where uid='$uid' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前用户不存在！"}');
	if($do==1 && $rmb>$row['money'])$rmb=$row['money'];
	if($do==0){
		changeUserMoney($uid, $rmb, true, '后台加款');
	}else{
		changeUserMoney($uid, $rmb, false, '后台扣款');
	}
	exit('{"code":0,"msg":"succ"}');
break;
case 'create_batch':
	$count=$DB->getColumn("SELECT count(*) from pre_settle where status=0");
	if($count==0)exit('{"code":-1,"msg":"当前不存在待结算的记录"}');
	$batch=date("Ymd").rand(111,999);
	$allmoney = 0;
	$rs=$DB->query("SELECT * from pre_settle where status=0");
	while($row = $rs->fetch())
	{
		$DB->exec("UPDATE pre_settle SET batch='$batch',status=2 WHERE id='{$row['id']}'");
		$allmoney+=$row['realmoney'];
	}
	$DB->exec("INSERT INTO `pre_batch` (`batch`, `allmoney`, `count`, `time`, `status`) VALUES ('{$batch}', '{$allmoney}', '{$count}', '{$date}', '0')");

	exit('{"code":0,"msg":"succ","batch":"'.$batch.'","count":"'.$count.'","allmoney":"'.$allmoney.'"}');
break;
case 'complete_batch':
	$batch=trim($_POST['batch']);
	$DB->exec("UPDATE pre_settle SET status=1 WHERE batch='$batch'");
	exit('{"code":0,"msg":"succ"}');
break;
case 'setSettleStatus':
	$id=intval($_GET['id']);
	$status=intval($_GET['status']);
	if($status==4){
		if($DB->exec("DELETE FROM pre_settle WHERE id='$id'"))
			exit('{"code":200}');
		else
			exit('{"code":400,"msg":"删除记录失败！['.$DB->error().']"}');
	}else{
		if($status==1){
			$sql = "update pre_settle set status='$status',endtime='$date',result=NULL where id='$id'";
		}else{
			$sql = "update pre_settle set status='$status',endtime=NULL where id='$id'";
		}
		if($DB->exec($sql)!==false)
			exit('{"code":200}');
		else
			exit('{"code":400,"msg":"修改记录失败！['.$DB->error().']"}');
	}
break;
case 'opslist':
	$status=$_POST['status'];
	$checkbox=$_POST['checkbox'];
	$i=0;
	foreach($checkbox as $id){
		if($status==4){
			$sql = "DELETE FROM pre_settle WHERE id='$id'";
		}elseif($status==1){
			$sql = "update pre_settle set status='$status',endtime='$date',result=NULL where id='$id'";
		}else{
			$sql = "update pre_settle set status='$status',endtime=NULL where id='$id'";
		}
		$DB->exec($sql);
		$i++;
	}
	exit('{"code":0,"msg":"成功改变'.$i.'条记录状态"}');
break;
case 'settle_result':
	$id=intval($_POST['id']);
	$row=$DB->getRow("select * from pre_settle where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前结算记录不存在！"}');
	$result = ['code'=>0,'msg'=>'succ','result'=>$row['result']];
	exit(json_encode($result));
break;
case 'settle_setresult':
	$id=intval($_POST['id']);
	$result=trim($_POST['result']);
	$row=$DB->getRow("select * from pre_settle where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前结算记录不存在！"}');
	$sds = $DB->exec("UPDATE pre_settle SET result='$result' WHERE id='$id'");
	if($sds!==false)
		exit('{"code":0,"msg":"修改成功！"}');
	else
		exit('{"code":-1,"msg":"修改失败！'.$DB->error().'"}');
break;
case 'settle_info':
	$id=intval($_GET['id']);
	$rows=$DB->getRow("select * from pre_settle where id='$id' limit 1");
	if(!$rows)
		exit('{"code":-1,"msg":"当前结算记录不存在！"}');
	$data = '<div class="form-group"><div class="input-group"><div class="input-group-addon">结算方式</div><select class="form-control" id="pay_type" default="'.$rows['type'].'">'.($conf['settle_alipay']?'<option value="1">支付宝</option>':null).''.($conf['settle_wxpay']?'<option value="2">微信</option>':null).''.($conf['settle_qqpay']?'<option value="3">QQ钱包</option>':null).''.($conf['settle_bank']?'<option value="4">银行卡</option>':null).'</select></div></div>';
	$data .= '<div class="form-group"><div class="input-group"><div class="input-group-addon">结算账号</div><input type="text" id="pay_account" value="'.$rows['account'].'" class="form-control" required/></div></div>';
	$data .= '<div class="form-group"><div class="input-group"><div class="input-group-addon">真实姓名</div><input type="text" id="pay_name" value="'.$rows['username'].'" class="form-control" required/></div></div>';
	$data .= '<input type="submit" id="save" onclick="saveInfo('.$id.')" class="btn btn-primary btn-block" value="保存">';
	$result=array("code"=>0,"msg"=>"succ","data"=>$data,"pay_type"=>$rows['type']);
	exit(json_encode($result));
break;
case 'settle_save':
	$id=intval($_POST['id']);
	$pay_type=trim(daddslashes($_POST['pay_type']));
	$pay_account=trim(daddslashes($_POST['pay_account']));
	$pay_name=trim(daddslashes($_POST['pay_name']));
	$sds=$DB->exec("update `pre_settle` set `type`='$pay_type',`account`='$pay_account',`username`='$pay_name' where `id`='$id'");
	if($sds!==false)
		exit('{"code":0,"msg":"修改记录成功！"}');
	else
		exit('{"code":-1,"msg":"修改记录失败！'.$DB->error().'"}');
break;
case 'paypwd_check':
	if(isset($_SESSION['paypwd']) && $_SESSION['paypwd']==$conf['admin_paypwd'])
		exit('{"code":0,"msg":"ok"}');
	else
		exit('{"code":-1,"msg":"error"}');
break;
case 'paypwd_input':
	$paypwd=trim($_POST['paypwd']);
	if(!$conf['admin_paypwd'])exit('{"code":-1,"msg":"你还未设置支付密码"}');
	if($paypwd == $conf['admin_paypwd']){
		$_SESSION['paypwd'] = $paypwd;
		exit('{"code":0,"msg":"ok"}');
	}else{
		exit('{"code":-1,"msg":"支付密码错误！"}');
	}
break;
case 'paypwd_reset':
	unset($_SESSION['paypwd']);
	exit('{"code":0,"msg":"ok"}');
break;
case 'set':
	foreach($_POST as $k=>$v){
		saveSetting($k, $v);
	}
	$ad=$CACHE->clear();
	if($ad)exit('{"code":0,"msg":"succ"}');
	else exit('{"code":-1,"msg":"修改设置失败['.$DB->error().']"}');
break;
case 'setGonggao':
	$id=intval($_GET['id']);
	$status=intval($_GET['status']);
	$sql = "UPDATE pre_anounce SET status='$status' WHERE id='$id'";
	if($DB->exec($sql))exit('{"code":0,"msg":"修改状态成功！"}');
	else exit('{"code":-1,"msg":"修改状态失败['.$DB->error().']"}');
break;
case 'delGonggao':
	$id=intval($_GET['id']);
	$sql = "DELETE FROM pre_anounce WHERE id='$id'";
	if($DB->exec($sql))exit('{"code":0,"msg":"删除公告成功！"}');
	else exit('{"code":-1,"msg":"删除公告失败['.$DB->error().']"}');
break;
case 'getServerIp':
	$ip = getServerIp();
	exit('{"code":0,"ip":"'.$ip.'"}');
break;
case 'epayurl':
	$id = intval($_GET['id']);
	$conf['payapi']=$id;
	if($url = pay_api()){
		exit('{"code":0,"url":"'.$url.'"}');
	}else{
		exit('{"code":-1}');
	}
break;
case 'iptype':
	$result = [
	['name'=>'0_X_FORWARDED_FOR', 'ip'=>real_ip(0), 'city'=>get_ip_city(real_ip(0))],
	['name'=>'1_X_REAL_IP', 'ip'=>real_ip(1), 'city'=>get_ip_city(real_ip(1))],
	['name'=>'2_REMOTE_ADDR', 'ip'=>real_ip(2), 'city'=>get_ip_city(real_ip(2))]
	];
	exit(json_encode($result));
break;
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}