/**
 * @author Creiden
 */
jQuery(document).ready(function($){
	// Text Sliders
	$('.RecentPostSlider').carousel('pause');//stop autoplays
	
	$('.RecentPostSlider').each(function(i){
		$(this).attr('id','myCarousel-recentPost_'+i);
		$(this).find('.carousel-control').attr('href','#myCarousel-recentPost_'+i);
		var height = $(this).find('.item.active').height()+5;
		$(this).find('.carousel-inner').css('height',height);
	});
		
	$('.RecentPostSlider').bind('slid',function(){
        var height = $(this).find('.item.active').height()+5;
        //alert(height);
		$(this).find('.carousel-inner').css('height',height);
    });
    
    $(window).resize(function(){
		$('.RecentPostSlider').each(function(i){
			var height = $(this).find('.item.active').height()+5;
			$(this).find('.carousel-inner').css('height',height);
		});
    });
	$('.RecentPostSlider').click(function() {
	  $(this).data('carousel').options.interval=false;
	});
});