jQuery( document ).ready( function( $ ) {
    var start_date_el = $( '[name="circleflip-offer[duration][start]"]' );
    var end_date_el = $( '[name="circleflip-offer[duration][end]"]' );
    
    start_date_el.on( 'change', function() {
	end_date_el.attr( 'min', $( this ).val() );
    } );
} )