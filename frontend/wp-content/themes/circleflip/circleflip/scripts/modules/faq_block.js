/**
 * @author Creiden
 */
+ (function( $, window, document, undefined ) {

    jQuery( document ).ready( function() {
    	jQuery('.faqContainer').each(function(){
    		var container = jQuery(this);
	        var filters = jQuery(this).find( '.filter-options' ).find( 'li' );
	        container.isotope( {
	            itemSelector: jQuery(this).find('.faqItem'),
	            layoutMode: 'straightDown'
	          //  filter: circleflipMixitupConfig.category
	        } );
	        filters.on( 'click', function() {
	            var jQuerythis = jQuery( this );
	            filters.removeClass( 'active' );
	            jQuerythis.addClass( 'active' );
	            container.isotope( { filter: jQuerythis.data( 'filter' ) } );
	        } );
    	});
    } );
}( jQuery, window, document ));