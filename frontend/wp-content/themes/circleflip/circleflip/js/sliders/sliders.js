jQuery(window).load(function($) {
	if(jQuery('.nivoSlider').length !== 0) {
		jQuery('.nivoSlider').nivoSlider();
	}

	if(jQuery('#ei-slider').length !== 0) {
	    jQuery('#ei-slider').show().eislideshow({
			animation			: 'center',
			autoplay			: true,
			slideshow_interval	: 3000,
			titlesFactor		: 0
	    });
   	}
   	if(jQuery('#va-accordion').length !==0 )
   	{
		jQuery('#va-accordion').vaccordion({
			visibleSlices	: 5,
			expandedHeight	: 250,
			animOpacity		: 0.1,
			contentAnimSpeed: 100
		});
   	}
	if(jQuery('.kwicks').length !== 0) {
		//var accordion = jQuery('#accordion-slider').parents('.aq-block').width();
		jQuery('.kwicks').show().kwicks({
			maxSize : '75%',
			//spacing : 2,
			//autoplay : false,
			behavior: 'menu'
			//time : 4000
		});
	}
   	if(jQuery('#sb-slider').length !== 0) {
	   	var Page = (function() {
	   		$ = jQuery;
			 $navArrows = $( '#nav-arrows' ).hide(),
				$shadow = $( '#shadow' ).hide(),
				slicebox = $( '#sb-slider' ).slicebox( {
					onReady : function() {

						$navArrows.show();
						$shadow.show();

					},
					orientation : 'r',
					cuboidsRandom : true,
					disperseFactor : 30
				} ),

				init = function() {
					initEvents();
				},
				initEvents = function() {
					// add navigation events
					$navArrows.children( ':first' ).on( 'click', function() {
						slicebox.next();
						return false;
					} );
					$navArrows.children( ':last' ).on( 'click', function() {
						slicebox.previous();
						return false;
					} );
				};
				return { init : init };
	})();
	Page.init();
	setInterval(function() {
		slicebox.next();
	},5000);
}
});
//Window Resize
jQuery(window).resize(function($){
});
