/**
 * @author Creiden
 */
jQuery(document).ready(function($){
	// Text Sliders
	
	$('.testimonialsSection').not('.no_bullets_arrows, .bullets_case').carousel('pause');//stop autoplay for arrows case
	
	$(window).load(function(){
		$('.testimonialsSection').each(function(i){
			var $this = $(this);
			$this.attr('id','myCarousel_testimonials'+i);
			$this.find('.carousel-control').attr('href','#myCarousel_testimonials'+i);
			$this.find('.carousel-indicators li').attr('data-target','#myCarousel_testimonials'+i);
			var height = $this.find('.item.active').outerHeight(true);
			$this.find('.carousel-inner').css('height',height);
			
		});
	});
		
	$('.testimonialsSection').bind('slid',function(){
        var height = $(this).find('.item.active').outerHeight(true);
        //alert(height);
		$(this).find('.carousel-inner').css('height',height);
    });
    
    $(window).resize(function(){
		$('.testimonialsSection').each(function(i){
			var height = $(this).find('.item.active').outerHeight(true);
			$(this).find('.carousel-inner').css('height',height);
		});
    });
	console.log('end');
	
});