$(document).ready(function(){
	$('.widgetcategory_with_count a').hover(function(){
		$(this).addClass('hoverlink');
		$(this).parent().parent().children('span').addClass('hoverlink');
	},function(){
		$(this).removeClass('hoverlink');
		$(this).parent().parent().children('span').removeClass('hoverlink');
	});
	$('.footerList .categoryCount').addClass('span3');
	$('.footerList .widgetcategory_with_count').addClass('span3');
	
});
	