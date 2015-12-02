+ ( function( $, window, document ) {

	$( document ).ready( function() {
		var container = $( '.ourHolder' );
		var filters = $( '#circleflip-filters' ).find( 'li' );
		container.imagesLoaded( function() {
			container.isotope( {
				itemSelector: '.item',
				layoutMode: circleflipMixitupConfig.layoutMode,
				filter: circleflipMixitupConfig.category,
			} );
			setTimeout( function() {

				$( '.loading_portfolio' ).fadeOut( 'slow', function() {
					container.css( 'visibility', 'visible' );
				} );

			}, 300 );
		} );
		filters.on( 'click', function() {
			var $this = $( this );
			filters.removeClass( 'active' );
			$this.addClass( 'active' );
			container.isotope( {filter: $this.data( 'filter' )} );
		} );
		$( '.circleflip-portfolio-filter' ).on( 'click', function(e) {
			e.preventDefault();
			var $this = $( this );
			filters.removeClass( 'active' );
			filters.filter( '[data-filter="' + $this.data( 'filter' ) + '"]' ).addClass( 'active' );
			container.isotope( {filter: $this.data( 'filter' )} );
		} );
		
		if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1 ){
			$( window ).load( function(){
				$('.ourHolder .item').addClass('PRTransition');
			});				
		}else{
			$('.ourHolder .item').addClass('PRTransition');
		}
		$( window ).smartresize( function() {
			setTimeout( function() {
				container.isotope( 'reLayout' );
			}, 350 );
		} );
	} );
}( jQuery, window, document ) );
