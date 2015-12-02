jQuery(document).ready(function($){
	$ = jQuery;
	$('.loadRecentPosts .icon-spin3,.loadCirclePosts .icon-spin3,.loadPortfolioPosts .icon-spin3, .loadSquareRedPosts .icon-spin3').click(function(){
		$(this).addClass('animateload');
		setTimeout(function(){
    		$('.loadRecentPosts .icon-spin3,.loadCirclePosts .icon-spin3,.loadPortfolioPosts .icon-spin3, .loadSquareRedPosts .icon-spin3').removeClass('animateload');
		}, 1000);
	});
	$('.circleModal').on('show', function () {
		$(this).parents('.circleAnimation').addClass('btnClicked');
	});
	$('.circleModal').on('hidden', function () {
		$(this).parents('.circleAnimation').removeClass('btnClicked');
	});

	jQuery('.squareModal').each(function(count,item) {
		jQuery(item).css({ position: "absolute", visibility: "hidden", display: "block" });
		jQuery(item).find('.postSlider').show().each(function(index,element) {
			jQuery(element).find('li').css('width',jQuery(element).width());
			jQuery(element).find('ul').css('width',jQuery(element).find('li').size() * jQuery(element).find('li').width());//Initialize upper image slider
		});
		jQuery(item).css({ position: "", visibility: "", display: "" });
	});

	if($('.circleModal').length !== 0) {
		$('.circleModal').css({ position: "absolute", visibility: "hidden", display: "block" });
		$('.circleModal .postSlider').show().each(function(index,element) {
			$(element).find('li').css('width',$(element).width());
			$(element).find('ul').css('width',$(element).find('li').size() * $(element).find('li').width());//Initialize upper image slider
		});
		$('.circleModal').css({ position: "", visibility: "", display: "" });
	}
});
