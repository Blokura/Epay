$('.gh').click(function(){if($('.header').hasClass('selected')){$('.header,.gh').removeClass('selected');$('.nav-wrap').slideUp();}
else{$('.header,.gh').addClass('selected');$('.nav-wrap').slideDown();}})
$(function(){wow=new WOW({animateClass:"animated",});wow.init();$(".nav li").click(function(){$(this).addClass('on').siblings().removeClass('on')})});