/**
 * @author Creiden
 */
jQuery(document).ready(function($){
	// Text Sliders
	$('.clientsLogos').carousel('pause');//stop autoplay
	
	$('.clientsLogos').each(function(i){
		$this = $(this);
		$this.attr('id','myCarousel_clients_'+i);
		$this.find('.carousel-control').attr('href','#myCarousel_clients_'+i);
	});
		
	$('.clientsLogos').bind('slid',function(){
        var height = $(this).find('.item.active').height();
        //alert(height);
		$(this).find('.carousel-inner').css('height',height);
    });
    
    $(window).resize(function(){
		$('.clientsLogos').each(function(i){
			var height = $(this).find('.item.active').height();
			$(this).find('.carousel-inner').css('height',height);
		});
    });
	$('.clientsLogos').click(function() {
	  $(this).data('carousel').options.interval=false;
	});
});