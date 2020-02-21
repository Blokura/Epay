$(function(){
//	点击头部导航事件
	$(".navBox .navBox_right .nav li a").on('click',function(){
		$(this).addClass("active").parent("li").siblings().find("a").removeClass("active");
	});
	$(".navBox .navBox_right .btn_common").on('click',function(){
		$(this).addClass("active").siblings(".btn_common").removeClass("active");
	});
//	点击右侧返回事件
	$(".right_scrollTop").click(function() {
	    $("html,body").animate({scrollTop: 0}, 600);
	});
//	点击右侧事件
	$(".right_fixed .right_common").hover(function(){
		$(this).find(".rightShow_common").show().animate({marginRight: '0px'}, '1s');;
		$(this).find(".rightPhoto_common").hide();
		},function(){
			$(this).find(".rightShow_common").hide();
			$(this).find(".rightPhoto_common").show();
		});
	
	
})
