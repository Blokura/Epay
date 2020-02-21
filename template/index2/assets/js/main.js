$(function(){
	//wap下拉菜单
	$('.hd_nav').click(function(){	  
	  if(!$(this).hasClass('active')){
		$(this).addClass('active');
		$('.wap_nav').fadeIn(200);
	  }else{
		$(this).removeClass('active');
		$('.wap_nav').fadeOut(100);
	  }
	});
	
	//置顶
	var offset = 300,offset_opacity = 1200,scroll_top_duration = 700,$back_to_top = $('.cd-top');
	$(window).scroll(function(){
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
		if( $(this).scrollTop() > offset_opacity ) {$back_to_top.addClass('cd-fade-out');}
	});
	$back_to_top.on('click', function(event){event.preventDefault();$('body,html').animate({scrollTop: 0 ,}, scroll_top_duration);});	


});

//按钮倒计时
function clickButton(t){
	var obj = $("input[name='zymF']");
	obj.attr("disabled","disabled");/*按钮倒计时*/
	var time = t;
	var set=setInterval(function(){
	obj.val(--time+"(s)");
	}, 1000);/*等待时间*/
	setTimeout(function(){
	obj.attr("disabled",false).val("重新获取");/*倒计时*/
	clearInterval(set);
	}, 1000*t);
}











