/**
 * @author Creiden
 */
jQuery(document).ready(function($){
	// Text Sliders
	$('.textSlider').carousel('pause');//stop autoplay
	
	$('.textSlider').each(function(i){
		$(this).attr('id','myCarousel_'+i);
		$(this).find('.carousel-control').attr('href','#myCarousel_'+i);
		var height = $(this).find('.item.active').height()+5;
		$(this).find('.carousel-inner').css('height',height);
	});
		
	$('.textSlider').bind('slid',function(){
        var height = $(this).find('.item.active').height()+5;
        //alert(height);
		$(this).find('.carousel-inner').css('height',height);
    });
    
    $(window).resize(function(){
		$('.textSlider').each(function(i){
			var height = $(this).find('.item.active').height()+5;
			$(this).find('.carousel-inner').css('height',height);
		});
    });
	$('.textSlider').click(function() {
	  $(this).data('carousel').options.interval=false;
	});
	setInterval(function() {
		$('.right.carousel-control').click();
	},5000);
});