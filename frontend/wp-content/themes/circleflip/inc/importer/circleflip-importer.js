( function( $, wp ) {

	$( document ).ready( function() {
		var required = $( '#install-demo-required' );
		var support = $( '#install-demo-support' );
		var success = $( '#install-demo-success' );
		var plugins = $( '#install-demo-plugins-list' );
		var spinner = $( '#install-demo-spinner' );
		$( '#install-demo' ).on( 'click', function() {
			spinner.show();
			plugins.hide().removeClass( 'in' );
			required.hide().removeClass( 'in' );
			support.hide().removeClass( 'in' );
			success.hide().removeClass( 'in' );
			wp.ajax.post( 'circleflip-import-demo', {
				_ajax_nonce: circleflipOneClickDemo.nonce
			} )
				.done( function( result ) {
					plugins.hide().removeClass( 'in' );
					required.hide().removeClass( 'in' );
					support.hide().removeClass( 'in' );

					success.fadeIn( function() {
						$( this ).addClass( 'in' );
					} );
				} )
				.fail( function( result ) {
					if ( ! result || ! result.template || ! result.plugins ) {
						support.fadeIn( function() {
							$( this ).addClass( 'in' );
						} );
						return;
					}
					var rows = [ ];
					var tmpl = _.template( result.template, null, {variable: 'data'} );
					_.each( result.plugins, function( plugin ) {
						rows.push( tmpl( plugin ) );
					} );
					success.hide().removeClass( 'in' );
					support.hide().removeClass( 'in' );
					required.fadeIn( function() {
						$( this ).addClass( 'in' );
					} );
					plugins.fadeIn( function() {
						$( this ).addClass( 'in' );
					} ).find( 'tbody' ).append( rows );
				} )
				.always( function() {
					spinner.hide();
				} );
		} );
	} );

}( jQuery, wp ) );