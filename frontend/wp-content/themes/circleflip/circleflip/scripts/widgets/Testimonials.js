/**
 * @author Creiden
 */
jQuery(document).ready(function($){
	// Text Sliders
	$('.testimonialsSlider').carousel('pause');//stop autoplays
	$('.footerList .testimonials').addClass('span3');
	$(window).load(function(){
		$('.testimonialsSlider').each(function(i){
			$(this).attr('id','myCarousel-testimonials_'+i);
			$(this).find('.carousel-control').attr('href','#myCarousel-testimonials_'+i);
			var height = $(this).find('.item.active').height()+5;
			$(this).find('.carousel-inner').css('height',height);
		});
	});
		
	$('.testimonialsSlider').bind('slid',function(){
        var height = $(this).find('.item.active').height()+5;
        //alert(height);
		$(this).find('.carousel-inner').css('height',height);
    });
    
    $(window).resize(function(){
		$('.testimonialsSlider').each(function(i){
			var height = $(this).find('.item.active').height()+5;
			$(this).find('.carousel-inner').css('height',height);
		});
    });
	$('.testimonialsSlider').click(function() {
	  $(this).data('carousel').options.interval=false;
	});
});