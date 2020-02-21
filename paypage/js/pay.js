//insert
function keypress(e){
    e.preventDefault();
    var target = e.target;
    var value = target.getAttribute('data-value');
    var dot = valueCur.match(/\.\d{2,}$/);
    if(!value || (value !== 'delete' && dot)){
        return;
    }

    switch(value){
        case '0' :
            valueCur = valueCur === '0' ? valueCur : valueCur + value;
            break;
        case 'dot' : 
            valueCur = valueCur === '' ? valueCur : valueCur.indexOf('.') > -1 ? valueCur : valueCur + '.'; 
            break;
        case 'delete' : 
            valueCur = valueCur.slice(0,valueCur.length-1);
            break;
        default : 
            valueCur = valueCur === '0' ? value : valueCur + value;
    }

    if(!!valueCur && value !== 'delete' && value !== 'dot') {
        var re = /^\d{1,9}(\.\d{0,2})?$/;
        var limitLen = re.test(valueCur);
        if (!limitLen) {
            valueCur = valueCur.slice(0,valueCur.length-1);
            return;
        }
    }
    format();
}

//format
function format(){
    var arr = valueCur.split('.');
    var right = arr.length === 2 ? '.'+arr[1] : '';
    var num = arr[0];
    var left = '';
    while(num.length > 3){
        left = ',' + num.slice(-3) + left;
        num = num.slice(0,num.length - 3);
    }
    left = num + left;
    valueFormat = left+right;
    valueFinal = valueCur === '' ? 0 : parseFloat(valueCur);
    check();
}

//check
function check(){
    amount.innerHTML = valueFormat;
    if(valueFormat.length > 0){
        clearBtn.classList.remove('none');
    }else{
        clearBtn.classList.add('none');
    }
    if(valueFinal === 0 || valueCur.match(/\.$/)){
        payBtn.classList.add('disable');
    }else{
        payBtn.classList.remove('disable');
    }
}

//clear
function clearFun(){
    valueCur = '';
    valueFormat = '';
    valueFinal = 0;
    amount.innerHTML = '';
    clearBtn.classList.add('none');
    payBtn.classList.add('disable');
}

//submit
function submitFun(){	
    if(!submitAble || payBtn.classList.contains('disable')){
        return;
    }
    var txAmount = $("#txAmount").val();
    if (!!txAmount && txAmount > 0) {
        valueFinal = txAmount;
    }
    if(valueFinal == 0){	
        tips.show('请输入金额！');
        return;
    }

    var amount = valueFinal;
    var uid = $("#uid").val();
    var paytype = $("#paytype").val();
    var token = $("#token").val();
	var direct = $("#direct").val();
	var payer = $("#payer").val();

    submitAble = false;
    loading.show();
    new Post({
        url : 'ajax.php',
        dataType : 'json',
        data : {"money":amount,"payer":payer,"uid":uid,"paytype":paytype,"direct":direct,
            "token":token},
        error : function(){
            loading.hide();
            submitAble = true;
            //update by yuwm 2018.03.14
            tips.show('<span style="color:#959595;margin-top:5px">网络异常，请重新发起支付</span>');
        },
        success : function(data){
            loading.hide();
            if(data.code=="0"){//success
				$("#trade_no").val(data.trade_no);
				if (data.direct==1) {
					if (paytype == 'wxpay') {
                        WxpayJsPay(data.paydata);
					} else if (paytype == 'alipay') {
						AlipayJsPay(data.paydata);
					} else if (paytype == 'qqpay') {
						QQJsPay(data.paydata);
					}
				}else{
					window.location.href= data.url;
				}
            }else{
                tips.show(data.msg);
            }
            submitAble = true;
        }
    });
}

//region WX JS
function WxpayJsPay(payStr){
    var jsonPayStr = eval("("+payStr+")");
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        jsonPayStr,
        function(res){
            // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
            if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                // 支付成功则关闭窗口
                // tips.show("支付成功");
                //WeixinJSBridge.call('closeWindow');
                window.location.href="./success.php?trade_no="+$("#trade_no").val();
            } else if(res.err_msg == "get_brand_wcpay_request:cancel") {
                // tips.show("支付过程中用户取消");
            } else if(res.err_msg == "get_brand_wcpay_request:fail") {
                tips.show("支付失败");
            }else{
                tips.show("支付失败");
            }
        }
    );
}
//endregion

//region ALI JS
function AlipayJsPay(payStr) {
	var trade_no = $("#trade_no").val();
    Alipayready(function(){
        AlipayJSBridge.call("tradePay",{
            tradeNO: payStr
        }, function(result){
            var msg = "";
            if(result.resultCode == "9000"){
                //AlipayJSBridge.call('closeWebview');
				window.location.href="./success.php?trade_no="+$("#trade_no").val();
            }else if(result.resultCode == "8000"){
                msg = "正在处理中";
            }else if(result.resultCode == "4000"){
                msg = "订单支付失败";
            }else if(result.resultCode == "6002"){
                msg = "网络连接出错";
            }
            if (msg!="") {
                tips.show(msg);
            }
        });
    });
}
function Alipayready(callback) {
    // 如果jsbridge已经注入则直接调用
    if (window.AlipayJSBridge) {
        callback && callback();
    } else {
        // 如果没有注入则监听注入的事件
        document.addEventListener('AlipayJSBridgeReady', callback, false);
    }
}
//endregion

//region QQ JS
function QQJsPay(payStr){
	var trade_no = $("#trade_no").val();
	var jsonPayStr = eval("("+payStr+")");
	mqq.tenpay.pay({
		tokenId: jsonPayStr.tokenId,
		appInfo: "appid#"+jsonPayStr.appid+"|bargainor_id#"+jsonPayStr.bargainor_id+"|channel#wallet"
	}, function(result, resultCode){
		if(resultCode == 0){ //支付成功
			//mqq.ui.popBack();
			window.location.href="./success.php?trade_no="+$("#trade_no").val();
		}else{
			tips.show("支付失败");
		}
	});
}
//endregion


var keyboard = getId('keyboard');
var clearBtn = getId('clearBtn');
var payBtn = getId('payBtn');
var valueCur = '';
var valueFormat = '';
var submitAble = true;
var valueFinal = 0;

new Hammer(keyboard).on('tap',keypress);
new Hammer(payBtn).on('tap',submitFun);
new Hammer(clearBtn).on('tap',clearFun);
