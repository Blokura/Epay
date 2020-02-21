// *************************************************************************//
// ! This is main JS file that contains custom scripts used in this template*/
// *************************************************************************//
/**
	Navigation File

	01. Carousel
	02. Custom Select
	03. Mobile Menu

 */

$( document ).ready(function() {
	"use strict";
	// **********************************************************************//
	// 01. Carousel
	// **********************************************************************//
	$('.base-slider, .slider').owlCarousel({
		loop: true,
		margin: 0,
		nav: true,
		navText: ["<img src='/assets/index/images/arrow-left.png'>","<img src='/assets/index/images/arrow-right.png'>"],
		dots: false,
		item: 1,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			1000:{
				items:1
			}
		}
	});
	$('.partner-slider').owlCarousel({
		loop: true,
		margin: 0,
		nav: false,
		autoplay: true,
		dots: false,
		item: 5,
		responsive:{
			0:{
				items:2
			},
			600:{
				items:3
			},
			1000:{
				items:5
			}
		}
	});

	// **********************************************************************//
	// 02. Custom Select
	// **********************************************************************//
/*	$('select').each(function(){
		var $this = $(this), numberOfOptions = $(this).children('option').length;

		$this.addClass('select-hidden'); 
		$this.wrap('<div class="select"></div>');
		$this.after('<div class="select-styled"></div>');

		var $styledSelect = $this.next('div.select-styled');
		$styledSelect.text($this.children('option').eq(0).text());

		var $list = $('<ul />', {
			'class': 'select-options'
		}).insertAfter($styledSelect);

		for (var i = 0; i < numberOfOptions; i++) $('<li />', {
			rel: $this.children('option').eq(i).val(),
			text: $this.children('option').eq(i).text()
		}).appendTo($list);

		var $listItems = $list.children('li');

		$styledSelect.click(function(e) {
			e.stopPropagation();
			$('div.select-styled.active').not(this).each(function(){
				$(this).removeClass('active').next('ul.select-options').hide();
			});
			$(this).toggleClass('active').next('ul.select-options').toggle();
		});

		$listItems.click(function(e) {
			e.stopPropagation();
			$styledSelect.text($(this).text()).removeClass('active');
			$this.val($(this).attr('rel'));
			$list.hide();
		});

		$(document).click(function() {
			$styledSelect.removeClass('active');
			$list.hide();
		});

	});*/

	// **********************************************************************//
	// 03. Mobile Menu
	// **********************************************************************//
	$('.mobile-menu-btn').on('click', function(){
		$(this).toggleClass('active');
		$('header').toggleClass('active');
		$('body').toggleClass('mobile-menu-open');
	});

});