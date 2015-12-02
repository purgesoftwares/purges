( function( $, _ ) {

	jQuery( function( $ ) {

		var deferred = $.Deferred();

		deferred.promise().done( function() {
			// google maps is loaded
			initializeMapBlock();
			expandableAnimation();
		} );
		
		// make sure we don't loadd Google API multiple times
		if ( _.isUndefined(window.google) ) {
			window.__cfgm_async_load_callback = function() {
				deferred.resolve();
			};

			var script = document.createElement( 'script' );
			script.type = 'text/javascript';
			script.src = 'https://maps.googleapis.com/maps/api/js?v=3.17&' +
				'callback=__cfgm_async_load_callback';
			document.body.appendChild( script );
		} else {
			// Google API is already loaded
			deferred.resolve();
		}

	} );
	
	function initializeMapBlock() {
		var filter = '.cfgm-filter-range',
			filterContainer = '.cfgm-filters',
			filterText = '.cfgm-filter-text',
			mapCanvas = '.cr-map-canvas',
			_mapBlocks = $( '.cfgm-block' ),
			markerIcon = "data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAvCAMAAAC18jgTAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABaFBMVEXjORzbQizeQSvgRCvcQCveQyvfQyrdRCLdQirdRCrcRizdQyvfRCnfQSrgRifYOyfdRCjcQynjRyvfRCvbSSQAAADgRyndRCLcQynfQyreRCreRCneQyreRCncQCveQyveQynfQyrjORzgRCveQyrbQizeQyneQSvcQyneQyreQyreRCreQyreRCreQyreRCnfQyreRCnfQyrdQirdRCrcRizeQyneRCrdQyvfQyrfRCneQyrfQSrfRCneQyngRifeQyrYOyfeRCrdRCjcQynfQynjRyvfQynfRCveRCrbSSTeRCrgRyneRCreQyveQirdQisAAADeQinfQyreQyoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADeQyrjYk3wrKH64t7++vn64d3fRy/xsKb//v3////ys6nfSjL2zcb2zsjxsabkY07//fzxrKH++/r99vX539vxraLkY0/++/v+9/ZT3t4zAAAAX3RSTlMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA9Xmcjq+JoknPedCYr6I9IvWMnr+fv14d62fNx/gB38qjW3OP43rfYhjA3iUlCnEuRHkwfHGeZUVVkBPtQ9AggNERMWFxkYGkNlaYgAAAABYktHRGjLbPQiAAAACXBIWXMAAAsSAAALEgHS3X78AAACAUlEQVQ4y32T+1/SUBiHX/GUtjEtHEJcpg6BlMxLihpYaXm/JJkXZDjFULqImlD/foftnLMdOPP56eX7fT7b2bsBANDl64Ju9CQUfhmJxmLRSDwceoq6rdjGErShYZMxPKK1CXpi1OQYTehuIZkyO0glHSEdNQVE01RICntsJO1eT5kepHRcI5QwPUkgBEhzzn9+Ubm8/H5x7jyLhqBnhP6qXl3XLK5//KTZUA+E6H6qv2qM31W6sRCEqXxTc3FF01cQJ1P91i3c1kkchwiZ7mocdyQeA7qkCi9USDwOGTLd88I9iTPwWiz8IfEEvBHf4oHEkzAlPmSDxFMwTaYm/5hNEk9DWrioG5qmwTfz2KpnfND79rGXNfsMpLkse7v1RuXvv4dGkwXZOQkkad77g5mXJJDlBW9hQZaxIC969Yu4BL/f/y4n7nN5RVFagn9JLCwpLQFhtIyof/+hD2MJ6KNImO2zhP4Wyyud/aRu/68sof9Tp/AZ3MLz1fZ+9QURAjZr63y/vkYKKgQ2uGXkNgLtwsCmW9gcYIJK2dp2+u0tFjuCurNL+90dJ4UgQVUH8zG7j+UHVZXmTMAoe9a3k/2iuEK3EAzu45eS2eciRyi0+Hpw8M0aOoTDo+OT4mmpZBil0mnx5PjokBcKxbJhGGcEPJaLBeEVsFYWXoGegcHi/24YmapfznlOAAAAAElFTkSuQmCC",
			infoWidnowTmpl = _.template( $( '#tmpl-cfgm-infowindow' ).html(), null, {
				evaluate: /<#([\s\S]+?)#>/g,
				interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
				escape: /\{\{([^\}]+?)\}\}(?!\})/g,
				variable: 'data'
			} );

		_mapBlocks.each( function( i, mapBlock ) {
			var $mapBlock = $( mapBlock ),
				$mapDiv = $mapBlock.find( mapCanvas ),
				mapData = $mapDiv.data(),
				// each map get an InfoWindow
				infoWindow = new google.maps.InfoWindow( { maxWidth: 320 } ),
				primaryMarker = _.findWhere( mapData.markers, {primary: true} ),
				map = new google.maps.Map( $mapDiv[0], {
					center: new google.maps.LatLng( primaryMarker.latLng.lat, primaryMarker.latLng.lng ),
					scrollwheel: false,
					zoom: 10
				} );
				
			// the expandable code depends on this reference
			$mapDiv.data( 'gmap', map );
			
			google.maps.event.addListener( infoWindow, 'closeclick', function() {
				delete infoWindow.__marker;
			} );
				
			_.each( mapData.markers, function( marker ) {
				marker.__marker = new google.maps.Marker( {
					map: map,
					position: new google.maps.LatLng( marker.latLng.lat, marker.latLng.lng ),
					title: marker.title,
					icon: markerIcon
				} );
				google.maps.event.addListener( marker.__marker, 'click', function() {
					infoWindow.__marker = marker.__marker;
					if ( ! mapData.settings.filters ) {
						marker.dimensionX = false;
					}
					infoWindow.setContent( infoWidnowTmpl( marker ) );
					infoWindow.open( map, marker.__marker );
				} );
			} );

			if ( mapData.settings.filters ) {
				var dimensionXValues = _.pluck( mapData.markers, 'dimensionX' ),
					minDimensionX = parseFloat( _.min( dimensionXValues ) ),
					maxDimensionX = parseFloat( _.max( dimensionXValues ) ),
					_paddedRange = _padRange( minDimensionX, maxDimensionX, 0.1 ),
					$filterContainer = $mapBlock.find( filterContainer ),
					$rangeDisplay = $filterContainer.find( filterText ),
					updateMarkers = _.throttle( // throttle because jQueryUI slide event fires on mouse move
							_.wrap( // wrap toggleMarkers to map jQueryUI event with function params
									_.partial( toggleMarkers, _, _, mapData.markers, infoWindow ), // fill in static arguments
									function ( fn, evt, ui ) {
										$rangeDisplay.text( '$' + ui.values[0] + ' - ' + '$' + ui.values[1] );
										fn( ui.values[0], ui.values[1] );
									} ), 100 );
				$mapBlock.find( filter ).slider( {
					min: _paddedRange.min,
					max: _paddedRange.max,
					range: true,
					values: [ minDimensionX, maxDimensionX ],
					slide: updateMarkers
				} );

				$filterContainer.length && map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push( $filterContainer[0] );
			}

		} );
	}
	
	function expandableAnimation() {
		var transition = ( function() {
			var thisBody = document.body || document.documentElement,
				thisStyle = thisBody.style,
				support = thisStyle.transition !== undefined || thisStyle.WebkitTransition !== undefined || thisStyle.MozTransition !== undefined || thisStyle.MsTransition !== undefined || thisStyle.OTransition !== undefined;
			return support;
		} )();
		//Animation code start
		$( '.aq-block-cr_gmap_block' ).each( function() {
			var left_space = ( ( $( this ).position().left ) - ( $( '.container' ).offset().left ) );
			var right_space = left_space + $( this ).width() + parseInt( $( this ).css( 'margin-left' ).slice( 0, - 2 ) );
			if ( right_space == $( '.container' ).width() ) {
				//IF Not (it is not at left & it is at right)
				$( this ).find( '.mapCont' ).addClass( 'mapRight' );
			}
		} );
		$( '.mapLeftMore' ).click( function() {
			var $this = $( this );
			var $parent = $this.parents( '.aq-block' );
			var width;
			if ( $( '.container' ).width() > 723 ) {
				width = $( '.container' ).width();
				$this.parent( '.mapCont' ).css( 'z-index', 5 );
				if ( $this.hasClass( 'clicked' ) ) {
					$this.removeClass( 'clicked' );
					$this.parent( '.mapCont' ).css( {
						'width': '100%'
					} );
					$parent.find( '.mapCont' ).css( 'margin-left', 0 );
				} else {
					$this.addClass( 'clicked' );
					$this.parent( '.mapCont' ).css( {
						'width': width
					} );
					var left_space = ( ( $parent.position().left ) - ( $( '.container' ).offset().left ) );
					var left_space_margin = left_space + parseInt( $parent.css( 'margin-left' ).slice( 0, - 2 ) );
					$parent.find( '.mapCont' ).css( 'marginLeft', - left_space_margin + 'px' );
				}

				if ( transition ) {
					$this.parent().on( "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function() {
						google.maps.event.trigger( $this.siblings( '.cr-map-canvas' ).data( 'gmap' ), 'resize' );
					} );
				} else {
					google.maps.event.trigger( $this.siblings( '.cr-map-canvas' ).data( 'gmap' ), 'resize' );
				}
			}

		} );

		$( window ).resize( function() {
			$( '.mapLeftMore' ).each( function() {
				var $this = $( this );
				var $parent = $this.parents( '.aq-block' );
				if ( $this.hasClass( 'clicked' ) && $( '.container' ).width() > 723 ) {
					var width;
					width = $( '.container' ).width();
					$this.parent( '.mapCont' ).css( {
						'width': width
					} );
					var left_space = ( ( $parent.position().left ) - ( $( '.container' ).offset().left ) );
					var left_space_margin = left_space + parseInt( $parent.css( 'margin-left' ).slice( 0, - 2 ) );
					$parent.find( '.mapCont' ).css( 'marginLeft', - left_space_margin + 'px' );
				}
				else if ( $this.hasClass( 'clicked' ) && $( '.container' ).width() < 723 ) {
					$this.parent( '.mapCont' ).css( {
						'width': '100%'
					} );
					$parent.find( '.mapCont' ).css( 'margin-left', 0 );
				}
			} );
		} );
		//Animation code end
	}
	
	function _padRange( min, max, factor ) {
		if ( !factor ) {
			factor = 0.1;
		}
		// find the range of numbers we are working with
		var _range = Math.abs( min - max ),
			// calculate padding relative to range
			_padding = Math.abs( _range * factor < 1 ? _range * factor : Math.floor( _range * factor ) );
		
		// if 0 , we can't go less
		if ( 0 !== min ) {
			// actual min is negative, no harm in more negative
			if ( 0 > min ) {
				min -= _padding;
			} else if ( 0 < min ) {
				// actual min is positive, we have to stay above zero
				min = ( min - _padding ) > 0 ? min - _padding : 0;
			}
		}
		max += _padding;
		return {
			min: min,
			max: max
		};
	}
	
	function toggleMarkers( minValue, maxValue, markers, infoWindow ) {
		_.each( markers, function ( m ) {
			m.__marker.setVisible( m.dimensionX >= minValue && m.dimensionX <= maxValue );
			if ( infoWindow.__marker === m.__marker && !m.__marker.getVisible() ) {
				infoWindow.close();
			}
		} );
	}
	
}( jQuery, _ ) );