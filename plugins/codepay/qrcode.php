<?php
if(!defined('IN_PLUGIN'))exit();

require_once(PAY_ROOT."inc/codepay_config.php");

@header('Content-Type: text/html; charset=UTF-8');
$qr=''; //初始化一个默认的二维码

$codepay_path="https://codepay.fateqq.com";

$typename = $DB->getColumn("SELECT name FROM pre_type WHERE id='{$order['type']}' LIMIT 1");

if ($typename == 'wxpay') {
	$typeName = '微信';
    $type = 3;
} else if ($typename == 'qqpay' || $typename == 'tenpay') {
	$typeName = 'QQ';
    $type = 2;
} else {
    $type = 1;
    $typeName = '支付宝';
}

$price = $order['money'];
$param = TRADE_NO;

$pay_id = $clientip;
$data = array(
    "id" => $codepay_config['id'],//平台ID号
    "type" => $type,//支付方式
    "price" => $price,//原价
    "pay_id" => $pay_id, //可以是用户ID,站内商户订单号,用户名
    "param" => $param,//自定义参数
//            "https" => 1,//启用HTTPS
    "act" => $codepay_config['act'],
    "outTime" => $codepay_config['outTime'],//二维码超时设置
    "page" => $codepay_config['page'],//付款页面展示方式
    "return_url" => $siteurl.'pay/codepay/return/'.TRADE_NO.'/',//付款后附带加密参数跳转到该页面
    "notify_url" => $conf['localurl'].'pay/codepay/notify/'.TRADE_NO.'/',//付款后通知该页面处理业务
    "style" => $codepay_config['style'],//付款页面风格
    "user_ip" => $clientip,//用户IP
    "out_trade_no" => $param,//单号去重复
    "createTime" => time(),//服务器时间
    "qrcode_url" => $codepay_config['qrcode_url'],//本地化二维码
    "chart" => strtolower('utf-8')//字符编码方式
    //其他业务参数根据在线开发文档，添加参数.文档地址:https://codepay.fateqq.com/apiword/
    //如"参数名"=>"参数值"
);
function create_link($params,$codepay_key,$host=""){
    ksort($params); //重新排序$data数组
    reset($params); //内部指针指向数组中的第一个元素
    $sign = '';
    $urls = '';
    foreach ($params AS $key => $val) {
        if ($val == '') continue;
        if ($key != 'sign') {
            if ($sign != '') {
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式
        }
    }

    $key = md5($sign . $codepay_key);//替换为自己的密钥
    $query = $urls . '&sign=' . $key; //创建订单所需的参数
    $apiHost=$host?$host:"http://api2.xiuxiu888.com/creat_order/?";
    $url = $apiHost.$query; //支付页面
    return array("url"=>$url,"query"=>$query,"sign"=>$sign,"param"=>$urls);
}
$back=create_link($data,$codepay_config['key']);

$user_data = array(
    "return_url" => $siteurl.'pay/codepay/return/'.TRADE_NO.'/',
    "type" => $type,
    "outTime" => $codepay_config["outTime"],
    "codePay_id" => $codepay_config["id"],
    "out_trade_no" => $param,
    "price" => $price,
    'money'=>$price,
    'order_id'=>$param,
    "subject"=>$row['name']
    ); //传给网页JS去执行


$user_data["qrcode_url"] = $codepay_config["qrcode_url"];

//中间那log 默认为8秒后隐藏
//改为自己的替换img目录下的use_开头的图片 你要保证你的二维码遮挡不会影响扫码
//二维码容错率决定你能遮挡多少部分
$user_data["logShowTime"] = $user_data["qrcode_url"]?1:8*1000;


$codepay_json = get_curl($back['url']);

if(empty($codepay_json)){
    $data['call']="callback";
    $data['page']="3";
    $back=create_link($data,$codepay_config['key']);
    $codepay_html='<script src="'.$back['url'].'"></script>';
}else{
    $codepay_data = json_decode($codepay_json);
    $qr = $codepay_data ? $codepay_data->qrcode : '';
    $user_data["money"]=$codepay_data&&$codepay_data->money ? $codepay_data->money : $price;
    $codepay_html="<script>callback({$codepay_json})</script>";
}

?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $codepay_config['chart'] ?>">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="format-detection" content="telephone=no,email=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title><?php echo $typeName ?>扫码支付</title>
    <link href="<?php echo $codepay_path?>/css/wechat_pay.css" rel="stylesheet" media="screen">
    <link href="//cdn.staticfile.org/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
<div class="body">
    <h1 class="mod-title">
        <span class="ico_log ico-<?php echo $type ?>"></span>
    </h1>

    <div class="mod-ct">
        <div class="order" style="color:red;font-size:16px">请务必规定时间内支付下面显示的金额
        </div>

        <div class="amount"  style="position: relative;" ><span id="money">￥<?php echo $price ?></span><div style="position: absolute;font-size: 10px;top: 29px;left: 75%;"><a href="#" class="copy" id="copy" data-clipboard-text="<?php echo $user_data['money']?>">复制金额</a></div></div>
        <div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">
            <div data-role="qrPayImg" class="qrcode-img-area">
                <div class="ui-loading qrcode-loading" data-role="qrPayImgLoading" style="display: none;">加载中</div>
                <div style="position: relative;display: inline-block;">
                    <img id='show_qrcode' alt="加载中..." src="<?php echo $qr ?>" width="210" height="210" style="display: block;">
                    <img onclick="$('#use').hide()" id="use" src="<?php echo $codepay_path?>/img/use_<?php echo $type ?>.png"
                         style="position: absolute;top: 50%;left: 50%;width:32px;height:32px;margin-left: -21px;margin-top: -21px">
                </div>
            </div>


        </div>

<!--        这里加一些自己的提示-->
        <div class="time-item" id="msg">
            <h1>二维码过期时间</h1>
            <strong id="hour_show">0时</strong>
            <strong id="minute_show">0分</strong>
            <strong id="second_show">0秒</strong>
        </div>

        <div class="tip">
            <div class="ico-scan"></div>
            <div class="tip-text">
                <p>请使用<?php echo $typeName ?>扫一扫</p>
                <p>扫描二维码完成支付</p>
                <p><div id="kf" style="display:none;"></div></p>
            </div>
        </div>

        <div class="detail" id="orderDetail">
            <dl class="detail-ct" id="desc" style="display: none;">


            </dl>
            <a href="javascript:void(0)" class="arrow"><i class="ico-arrow"></i></a>
        </div>

        <div class="tip-text">
        </div>


    </div>
    <div class="foot">
        <div class="inner">
            <p>手机用户可保存上方二维码到手机中</p>
            <p>在<?php echo $typeName ?>扫一扫中选择“相册”即可</p>
            <p><div id="kfqq"></div></p>
        </div>
    </div>

</div>
<div class="copyRight"></div>
<!--注意下面加载顺序 顺序错乱会影响业务-->
<script src="<?php echo $codepay_path?>/js/jquery-1.10.2.min.js"></script>
<!--[if lt IE 8]>
<script src="<?php echo $codepay_path?>/js/json3.min.js"></script><![endif]-->
<script>
    var user_data =<?php echo json_encode($user_data);?>
</script>
<script src="<?php echo $codepay_path?>/js/notify.js"></script>
<script src="<?php echo $codepay_path?>/js/codepay_util.js?v=2.1"></script>
<?php echo $codepay_html;?>
<script src="//cdn.staticfile.org/toastr.js/latest/js/toastr.min.js"></script>
<script src="//cdn.staticfile.org/clipboard.js/1.7.1/clipboard.min.js"></script>
<script>
    setTimeout(function () {
        $('#use').hide()
    }, user_data.logShowTime || 10000);


    check_pay = function () {
        $.get("/getshop.php?trade_no=" + user_data.out_trade_no + "&r=" + Math.random(1), function (result) {
            if (result.code == 1) {
                alert('您所购买的商品已付款成功，感谢购买！');
                window.location.href = result.backurl;
            } else {
                setTimeout(function () {
                    check_pay() }, 3000);//3秒检测一次自己的数据是否成功
            }

        }, 'json');
    }
    check_pay();
    var clipboard = new Clipboard('.copy');
    clipboard.on('success', function (e) {
        toastr.success("复制成功,可扫码付款时候粘贴到金额栏付款");

    });
    clipboard.on('error', function(e) {
        document.querySelector('.copy');
        toastr.warning("复制失败,请记住下必须付款的金额 不能多不能少否则不能成功");
    });

</script>

</body>
</html>