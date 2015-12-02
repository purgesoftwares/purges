jQuery(document).ready(function($){
	$(window).load(function() {
		$('.masonryContainer').show();
		var container = jQuery('.masonryContainer');
		container.masonry({
			itemSelector : '.masonryContainer .masonryItem'
		});
		if($('.masonryModal').length !== 0) {
			$('.masonryModal').css({ position: "absolute", visibility: "hidden", display: "block" });
			$('.masonryModal .postSlider').show().each(function(index,element) {
				$(element).find('li').css('width',$(element).width());
				$(element).find('ul').css('width',$(element).find('li').size() * $(element).find('li').width());//Initialize upper image slider
			});
			$('.masonryModal').css({ position: "", visibility: "", display: "" });
		}
		$('.loading_portfolio').hide();
	});
	$(window).resize(function(){
		var container = jQuery('.masonryContainer');
		container.masonry({
			itemSelector : '.masonryContainer .masonryItem'
		});
	});

});
