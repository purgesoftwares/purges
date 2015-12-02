(function( $, _, window, document, undefined ) {
	
	var LOADING = 0,
		DONE = 1,
		mapBuilder = _.once( initGoogleMap ),
		buildConfigObject;
	
	$( document ).ready( function() {
		var spinnerSelector = '.spinner',
			hideIfLoading = '.hide-if-loading',
			$builder = $( '#cf-w-google-map-thickbox' ),
			$mapCanvas = $( '#cf-w-google-map-canvas' );
			
		$( document ).on( 'click', '.cf-w-google-map-builder', function( event ) {
			var $this = $( this ),
				$text = $this.find( '.cf-hide-if-loading' ),
				$spinner = $this.find( '.spinner' ),
				config = buildConfigObject( $this.closest( '.cf-w-gm-container' ) );
				
			// config is only used the first time the function fires
			mapBuilder( config )
				.progress( toggleSpinner( $text, $spinner ) )
				//load the map with current widget config
				.done( loadMapConfig( config ) )
				//show the Darn Map in a THICKBOX !
				.done( showMapBuilderTB )
				// wait for the user to click DONE
				.done( addListeners( config ) );
		} );
	} );
	
	function loadMapConfig( config ) {
		return function( builderObj ) {
			console.log( getConfig( config ) );
			builderObj.loadConfig( getConfig( config ) );
		}
	}
	
	buildConfigObject = (function() {
		var selectors = {
				lat: '.cf-w-gm-lat',
				lng: '.cf-w-gm-lng',
				zoom: '.cf-w-gm-zoom',
				mapTypeId: '.cf-w-gm-mapTypeId',
				markerLat: '.cf-w-gm-marker-lat',
				markerLng: '.cf-w-gm-marker-lng',
				markerShow: '.cf-w-gm-marker-show'
			},
		keys = _.keys( selectors ),
		val = function() {
			if ( this.is( selectors.markerShow ) ){
				console.log( 'this.is markershow', this.prop( 'checked' ) );
				console.log( this );
				return this.prop( 'checked' );
			}
			return this.val();
		};
		return _.memoize( function( context ) {
			var fields = _.object( keys, _.map( selectors, function( value, index, selectors ) {
				return context.find( value );
			} ) );
			return {
				set: function( field, value ) {
					if ( _.isObject( field ) ){
						_.map( field, function( value, key ) {
							fields[key] && fields[key].val( value );
						} );
					} else if ( fields[field] ) {
						fields[field].val( value );
					}
				},
				get: function( field, def ) {
					if ( ! field ) {
						return _.object( keys, _.invoke( fields, val ) );
					}
					return (fields[field] && fields[field].val()) || def || false;
				}
			};
		}, function( object ) {
			return object.attr( 'id' ) || (object.attr( 'id', _.uniqueId( 'cf-w-gm-' ) ) && object.attr( 'id' ))
		} );
	}());
	
	function showMapBuilderTB( map ) {
		tb_show( 'CF Google Map', '#TB_inline?inlineId=cf-w-google-map-thickbox' );
	}
	
	function addListeners( configObj ) {
		return function( builder ) {
			$( '#TB_window' ).one( 'click', '.cf-w-google-maps-done', function() {
				var dim = builder.map.getCenter().toString().slice(1, - 1).split(','),
					mdim = builder.marker.getVisible() ? builder.marker.getPosition().toString().slice( 1, - 1 ).split( ',' ) : dim;
				configObj.set( {
					lat: dim[0],
					lng: dim[1],
					zoom: builder.map.getZoom(),
					mapTypeId: builder.map.getMapTypeId(),
					markerLat: mdim[0],
					markerLng: mdim[1]
				} );
				console.log( builder.map.getBounds().toString() );
				tb_remove();
			} );
		}
	}
	
	function toggleSpinner( $text, $spinner ) {
		return function( flag ) {
			if ( LOADING === flag ) {
				$text.hide();
				$spinner.css( 'display', 'inline-block' );
			} else if ( DONE === flag ) {
				$text.show();
				$spinner.hide();
			}
		}
	}
	
	function initGoogleMap( config ) {
		var map = new $.Deferred();

		map.notify( LOADING );

		loadGoogleMapAPI().done( function() {
			map.notify( DONE );
			map.resolve( builderObject( getConfig( config ) ) );
		} );
		
		return map.promise();
	}
	
	function loadGoogleMapAPI() {
		return new $.Deferred( function( deferred ) {
			google.load( 'maps', '3.13', {
				other_params:'sensor=false',
				callback: function() {
					deferred.resolve();
				}
			} );
		} ).promise();
	}
	
	function builderObject( firstConfig ) {
		var map = new google.maps.Map( $( '#cf-w-google-map-canvas' )[0], _.extend( firstConfig.map, {
			visualRefresh: true,
			mapTypeControlOptions: {
				mapTypeIds: _.values( google.maps.MapTypeId ),
				style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
			}
		} ) ),
			marker = new google.maps.Marker( _.extend( firstConfig.marker, {map: map, draggable: true} ) ); 
		return {
			map: map,
			marker: marker,
			loadConfig: function( config ) {
				map.setOptions( config.map );
				marker.setOptions( config.marker );
			}
		}
	}
	
	function getConfig( configObj ) {
		var all_config = configObj.get();
		
		return {
			map: {
				center: new google.maps.LatLng( all_config.lat, all_config.lng ),
				zoom: parseInt( all_config.zoom, 10 ),
				mapTypeId: all_config.mapTypeId
			},
			marker: {
				position: new google.maps.LatLng( all_config.markerLat, all_config.markerLng ),
				visible: all_config.markerShow
			}
		}
	}
	
}( jQuery, _, window, document ));