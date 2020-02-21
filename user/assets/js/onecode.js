var config;
// 生成收款码
function makeDiyBg(element, qrWidth, qrHeight, url, foreground, background, imgUrl, imgWidth, imgHeight, font, fontColor, recName, recNameLeft, recNameTop, qrLeft, qrTop) {
	$(element).qrcode({
		render: "canvas",
		width: qrWidth,
		height: qrHeight,
		text: url,
		foreground: foreground,
		background: background
	});
	var canvas = document.getElementById('canvas');
	canvas.width = imgWidth;
	canvas.height = imgHeight;
	var ctx = canvas.getContext("2d");
	var img = new Image();
	img.crossOrigin = "Anonymous"
	img.src = imgUrl;
	img.onload = function () {
		// 生成背景图
		var bg = ctx.createPattern(img, "no-repeat");
		ctx.fillStyle = bg;
		ctx.fillRect(0, 0, imgWidth, imgHeight);
		// 生成收款名
		ctx.textAlign = "center";
		ctx.font = font;
		ctx.fillStyle = fontColor;
		if (recName) {
			if (!recNameLeft) {
				recNameLeft = imgWidth / 2;
			}
			ctx.fillText("扫码向 " + recName + " 付款", recNameLeft, recNameTop);
		}
		// 在canvas上生成二维码
		var canvasOld = document.getElementsByTagName('canvas')[0];
		ctx.drawImage(canvasOld, qrLeft, qrTop);


		var image = new Image();
		image.crossOrigin = "Anonymous"
		image.src = canvas.toDataURL("image/png");
		$("#endImg").attr("src", image.src);
		$("#load").hide();
		$("#qrcode").show();
	}
}
function showQrCode(styleName){
	$("#load").show();
	$("#qrcode").hide();
	$("#code").empty();
	styleName = styleName || 'dongxue';
	var qrWidth = config[styleName].qrWidth;
	var qrHeight = config[styleName].qrHeight;
	var foreground = config[styleName].foreground;
	var background = config[styleName].background;
	var imgWidth = config[styleName].imgWidth;
	var imgHeight = config[styleName].imgHeight;
	var font = config[styleName].font;
	var fontColor = config[styleName].fontColor;
	var recNameLeft = config[styleName].recNameLeft;
	var recNameTop = config[styleName].recNameTop;
	var qrLeft = config[styleName].qrLeft;
	var qrTop = config[styleName].qrTop;
	var nowUrl = config[styleName].url;
	makeDiyBg("#code", qrWidth, qrHeight, $("#code_url").val(), foreground, background, nowUrl, imgWidth, imgHeight, font, fontColor, $("#recName").val(), recNameLeft, recNameTop, qrLeft, qrTop);
}
$(document).ready(function(){
	var clipboard = new Clipboard('.copy-btn');
	clipboard.on('success', function (e) {
		layer.msg('复制成功！', {icon: 1});
	});
	clipboard.on('error', function (e) {
		layer.msg('复制失败，请长按链接后手动复制', {icon: 2});
	});
	$("#editName").click(function(){
		var codename=$("input[name='codename']").val();
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax2.php?act=edit_codename",
			data : {codename:codename},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 1){
					layer.alert(data.msg, {icon: 1}, function(){window.location.reload()});
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	//点击按钮保存图片
	$("#downImg").click(function () {
		var img = document.getElementById('endImg');
		var url = img.src;
		var a = document.createElement('a');
		var event = new MouseEvent('click');
		a.download = '一码支付-' + document.getElementById("recName").value;
		a.href = url;
		a.dispatchEvent(event);
	});
	$("#styleName").change(function(){
		$.cookie('styleName',$(this).val());
		showQrCode($(this).val());
	});
	if($.cookie('styleName')){
		$("#styleName").val($.cookie('styleName'));
	}
	$.ajax({
		type: 'get',
		url: "./assets/js/config.json",
		dataType: "json",
		async: true,
		success: function (data) {
			config = data;
			$("#styleName").change();
		}
	})
})