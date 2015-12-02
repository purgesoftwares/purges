var globalApp, mapBlockView;

( function( $, Backbone, _, wp, l10n ) {

	var app = {
		Views: {},
		Models: {},
		Collections: {}
	};

	/* ************************************************************************** *
	 *                                 # VIEWS                                    *
	 * ************************************************************************** */

	/** Main View
	 *
	 * responsible for initializing all subviews and collections
	 * behaves as a singleton init once then move around the DOM reseting data each time
	 */
	app.Views.App = Backbone.View.extend( {
		className: 'circleflip-googlemaps-frame',
		state: {settings: {}, locations: [ ]},
		template: function( data ) {
			return wp.template( 'cfgm-frame' )( data );
		},
		initialize: function( options ) {
			this.setState( options && options.state || {}, _.extend( {silent: true}, options ) );
			this.render();
		},
		/**
		 * this view is not meant to be re-rendered,
		 * its init-once move around kinda view
		 *
		 * @return app.Views.App
		 */
		render: function() {
			// build the regions to target with subviews
			this.$el.html( this.template() );

			this.errors = app.errors = new app.Collections.Errors();
			this.errorsView = app.errorsView = new app.Views.Errors( {el: this.$( '.cfgm-error' ), collection: this.errors} );

			// Errors passed from server
			if ( ! _.isEmpty( l10n.errors ) ) {
				_.each( l10n.errors, function( error_code ) {
					app.errors.add( {'msg': l10n.text[error_code]} );
				} );
			}

			this.mapView = new app.Views.Map( {el: this.$( '.cfgm-map-container' ), collection: this.state.locations} );

			this.locationListView = new app.Views.LocationList( {el: this.$( '.cfgm-locations' ), collection: this.state.locations} );
			
			// listen to Edit requests
			this.listenTo( this.state.locations, {
				'edit': this._editItem
			} );
			this.settingsView = new app.Views.Settings( {el: this.$( '.cfgm-settings' ), model: this.state.settings} );
			return this;
		},
		/** populate the current view data
		 * 
		 * @param object state
		 * @param object options
		 * @returns app.Views.App
		 */
		setState: function( state, options ) {

			state = _.defaults( state, {settings: {}, locations: [ ]} );

			this.state.locations = new app.Collections.Locations( state.locations );
			this.state.settings = new app.Models.Settings( state.settings );

			return this;
		},
		getState: function() {
			return {
				settings: this.state.settings.toJSON(),
				locations: this.state.locations.toJSON()
			};
		},
		remove: function(){
			this.errorsView.remove();
			this.mapView.remove();
			this.locationListView.remove();
			this.editView && this.editView.remove();

			this.errors.reset( [ ], {silent: true} );
			this.state.locations.reset( [ ], {silent: true} );

			return Backbone.View.prototype.remove.apply( this, arguments );
		},
		detach: function() {
			this.$el.detach();
			return this;
		},
		_editItem: function( model ) {
			// save refrence of Editing window for use across the app
			this.editView = new app.Views.LocationEdit( {model: model} );
			this.$( '.cfgm-rightpanel' ).append( this.editView.render().el );
			this.editView.open();

			this.listenTo( this.editView, 'closed', function() {
				this.editView = null;
			} );
		}
	} );

// ----------------------------------------------------------------------------


	/**
	 * renders a map on the el
	 */

	app.Views.Map = Backbone.View.extend( {
		template: function( data ) {
			return wp.template( 'cfgm-map-container' )( data );
		},
		initialize: function() {
			this.render();
		},
		render: function() {
			// make sure google api is loaded
			if ( ! this.checkGoogle() ) {
				return this;
			}
			this.$el.html( this.template() );
			this.map = new google.maps.Map( this.$( '.cfgm-map' ).get( 0 ), {
				center: this.computeCenter(), // prope the collection for possible primary location
				zoom: 5,
				zoomControlOptions: {
					style: google.maps.ZoomControlStyle.SMALL,
					position: google.maps.ControlPosition.RIGHT_TOP
				},
				streetViewControl: false,
				rotateControl: false,
				panControl: false
			} );
			// Initialize map toolbar
			this.toolbarView = new app.Views.mapToolbar( {
				el: this.$( '.cfgm-map-toolbar' ),
				collection: this.collection,
				map: this.getMap()
			} );
//			this.map.controls[google.maps.ControlPosition.TOP_LEFT].push( this.toolbarView.el );
			this.markersView = new app.Views.Markers( {collection: this.collection, map: this.getMap()} );

			return this;
		},
		remove: function() {
			this.markersView.remove();
			this.toolbarView.remove();
			this.map = null;
			return Backbone.View.prototype.remove.apply( this, arguments );
		},
		checkGoogle: function() {
			if ( ! _.isObject( google ) && false ) {
				//notify the user we failed to load google maps api
				this.error = this.error || new app.Models.Error( {'msg': l10n.text.GOOGLE_404} );
				app.errors.add( this.error );
				return false;
			}
			if ( this.error ) {
				app.errors.remove( this.error );
				delete this.error;
			}
			return true;
		},
		getMap: function() {
			return this.map;
		},
		computeCenter: function() {
			var primaryLocation = this.collection.findWhere( {primary: true} ),
				latLng = primaryLocation ? primaryLocation.get( 'latLng' ) : {lat: 26.8357675, lng: 30.7956597}; // Egypt

			return new google.maps.LatLng( latLng.lat, latLng.lng );
		},
		/**
		 * fix broken UI when map is detached/attached
		 */
		refresh: function() {
			google.maps.event.trigger( this.getMap(), 'resize' );
			this.getMap().setCenter( this.computeCenter() );
		}
	} );

// ----------------------------------------------------------------------------



	app.Views.Errors = Backbone.View.extend( {
		template: function( data ) {
			return wp.template( 'cfgm-error' )( data );
		},
		initialize: function( options ) {
			this.render();
			this.listenTo( this.collection, 'reset add remove', this.render );
		},
		render: function() {
			this.$el.html( this.template( this.collection.toJSON() ) );
			return this;
		}
	} );

// ----------------------------------------------------------------------------


	/**
	 * render a collection of app.Model.Location as markers
	 */
	app.Views.Markers = Backbone.View.extend( {
		selected: null,
		initialize: function( options ) {
			this.map = options && options.map || null;

			this.listenTo( this.collection, {
				'reset': this.reset,
				'add': this.addOne,
				'remove': this.removeOne,
				'select': this.select,
				'deselect': this.deselect
			} );

			// Editing one location
			this.listenTo( Backbone, 'editing', this._startEditing );

			this.markers = {};
			this.render();
		},
		_startEditing: function( model, editView ) {
			var marker, oldCenter;
			this.editing = true;
			this.listenTo( editView, {
				open: function() {
					marker = new app.Views.Marker( {model: model, selectable: false} );
					_.each( this.markers, function( m ) {
						m.getMarker().setMap( null );
					} );
				},
				opened: function() {
					marker.getMarker().setMap( this.map );
					oldCenter = this.map.getCenter();
					this.map.panTo( marker.getMarker().getPosition() );
				},
				close: function() {
					marker.getMarker().setMap( null );
					_.each( this.markers, function( m ) {
						m.getMarker().setMap( this.map );
					}, this );
				},
				closed: function() {
					this.map.panTo( oldCenter );
					this.editing = false;
				},
			} );
		},
		render: function() {
			this.collection.each( this.addMarker, this );
			return this;
		},
		addMarker: function( location ) {
			var markerView = new app.Views.Marker( {model: location, map: this.map} );
			// hold a refrence to the view for later ops
			this.markers[location.cid] = markerView;
			return this;
		},
		addOne: function( model ) {
			this.addMarker( model );
			this.map.panTo( new google.maps.LatLng( model.get( 'latLng' ).lat, model.get( 'latLng' ).lng ) );
		},
		reset: function( collection, options ) {
			_.invoke( this.markers, 'remove' );
			this._reset();
			this.render();
		},
		_reset: function(){
			this.markers = [];
			this.selected = null;
		},
		removeOne: function( model ) {
			if ( _.has( this.markers, model.cid ) ) {
				this.markers[model.cid].remove();
				delete this.markers[model.cid];
			}
		},
		remove: function() {
			_.invoke( this.markers, 'remove' );
			this._reset();
			return Backbone.View.prototype.remove.apply( this, arguments );
		},
		select: function( model ) {
			model = this.collection.get( model );
			if ( model && _.has( this.markers, model.cid ) ) {
				this.deselect( this.selected );
				this.markers[model.cid].select();
				this.selected = model;
			}
		},
		deselect: function( model ) {
			model = this.collection.get( model );
			if ( model && _.has( this.markers, model.cid ) ) {
				this.markers[model.cid].deselect();
				this.selected = null;
			}
		}
	} );

// ----------------------------------------------------------------------------


	/**
	 * render app.Model.Location as marker on a given map
	 */
	app.Views.Marker = Backbone.View.extend( {
		selected: false,
		initialize: function( options ) {
			options = _.defaults( options, {
				map: null,
				selectable: true
			} );
			this.map = options.map;
			this.selectable = options.selectable;
			this.marker = null;
			this.listenTo( this.model, {
				'change:title': this._titleChanged, // change title
				'change:latLng': this._latLngChanged, // model changed latLng, update marker
				'change:hide': this._visibilityChanged
			} );
			this.render();
			// listen to user dragging the marker around
			google.maps.event.addListener( this.marker, 'position_changed', _.bind( this._positionChanged, this ) );

			if ( this.selectable ) {
				// listen to click, to fire select/unselect events
				google.maps.event.addListener( this.marker, 'click', _.bind( this._markerClicked, this ) );
			}
		},
		render: function() {
			this.marker = new google.maps.Marker( {
				position: new google.maps.LatLng( this.model.get( 'latLng' ).lat, this.model.get( 'latLng' ).lng ),
				map: this.map,
				draggable: true,
				title: this.model.get( 'title' )
			} );

			return this;
		},
		getMarker: function() {
			return this.marker;
		},
		/**
		 * override Backbone.View.remove to clean up marker references
		 */
		remove: function() {
			// delete the marker, google takes care of it
			this.getMarker().setMap( null );
			// stop listening to events on this marker
			google.maps.event.clearInstanceListeners( this.getMarker() );
			delete this.marker;
			delete this.model;

			return Backbone.View.prototype.remove.apply( this, arguments );
		},
		_titleChanged: function() {
			this.getMarker().setTitle( this.model.get( 'title' ) );
		},
		_latLngChanged: function() {
			var newPosition = new google.maps.LatLng( this.model.get( 'latLng' ).lat, this.model.get( 'latLng' ).lng );
			// make sure its a new lat/lng pair, stops circular reference issues
			if ( this.getMarker().getPosition().equals( newPosition ) ) {
				return;
			}
			this.getMarker().setPosition( newPosition );
		},
		_positionChanged: function() {
			var newPosition = this.getMarker().getPosition();
			this.model.set( 'latLng', {
				lat: newPosition.lat(),
				lng: newPosition.lng()
			} );
		},
		_markerClicked: function() {
			if ( this.selected ) {
				this.model.deselect();
				return;
			}
			this.model.select();
		},
		_visibilityChanged: function() {
			this.getMarker().setVisible( ! this.model.get( 'hide' ) );
			this[this.selected ? 'select' : 'deselect']();
		},
		select: function() {
			if ( ! this.selectable ) {
				return;
			}
			this.selected = true;
			this.getMarker().setAnimation( google.maps.Animation.BOUNCE );
			/*
			 * google.maps.Map.panTo doesn't play nicely with marker animation,
			 * the animation fails in an unpredictable manner
			 */
//			this.getMarker().getMap().panTo( this.getMarker().getPosition() );
		},
		deselect: function() {
			if ( ! this.selectable ) {
				return;
			}
			this.selected = false;
			this.getMarker().setAnimation( null );
		}
	} );

// ----------------------------------------------------------------------------



	app.Views.mapToolbar = Backbone.View.extend( {
		template: function(data) {
			return wp.template( 'cfgm-map-toolbar' )( data );
		},
		initialize: function( options ) {
			this.map = options && options.map || null;
			this.render();
		},
		render: function() {
			this.$el.html( this.template() );
			this.search = new app.Views.mapSearch( {el: this.$( '.cfgm-map-toolbar-search' ), collection: this.collection, map: this.map} );
			return this;
		},
		remove: function(){
			this.search.remove();
			this.map = null;
			return Backbone.View.prototype.remove.apply( this, arguments );
		}
	} );

	app.Views.mapSearch = Backbone.View.extend( {
		events: {
			'keydown .cfgm-map-search' : '_killKey'
		},
		template: function( data ) {
			return wp.template( 'cfgm-map-search' )( data );
		},
		initialize: function( options ) {
			this.map = options && options.map || null;
			this.render();

			this.listenTo( Backbone, 'editing', function( model, editView ) {
				this.listenTo( editView, {
					opened: function(){
						this.$( 'input' ).prop( 'disabled', true );
					},
					closed: function(){
						this.$( 'input' ).prop( 'disabled', false );
					}
				} );
			} );

			google.maps.event.addListener( this.autocomplete, 'place_changed', _.bind( this.addPlace, this ) );
		},
		render: function() {
			this.$el.html( this.template() );
			this.autocomplete = new google.maps.places.Autocomplete( this.$( '.cfgm-map-search' ).get( 0 ) );
			this.autocomplete.bindTo( 'bounds', this.map );
			return this;
		},
		remove: function() {
			google.maps.event.clearInstanceListeners( this.autocomplete );
			return Backbone.View.prototype.remove.apply( this, arguments );
		},
		addPlace: function() {
			var model = new app.Models.AutocompleteLocation( this.autocomplete.getPlace() );
			this.collection.add( model );
			model.select();
		},
		_killKey: function( e ) {
			var ENTER = 13, ESC = 27, key = ( e.keyCode || e.which );
			if ( key === ESC || key === ENTER ) {
				e.preventDefault();
				e.stopPropagation();
			}
		}
	} );

// ----------------------------------------------------------------------------



	app.Views.LocationList = Backbone.View.extend( {
		items: {},
		selected: null,
		template: function(data){
			return wp.template( 'cfgm-locationlist' )( data );
		},
		initialize: function(){
			this.listenTo( this.collection, {
				'add': this.addLocation,
				'reset': this.reset,
				'remove': this.removeOne,
				'select': this.select,
				'deselect': this.deselect
			} );
			this.render();
		},
		render: function(){
			this.$el.html( this.template() );

			if ( _.size( this.items ) ) {
				_.each( _.clone( this.items ), function( itemView ) {
					if ( this.collection.get( itemView.model.cid ) ) {
						itemView.$el.detach();
					} else {
						this.removeOne( itemView.model );
					}
				}, this );
			}

			this.collection.each( function( model ) {
				if ( ! _.has( this.items, model.cid ) ) {
					this.items[model.cid] = new app.Views.LocationItem( {model: model} );
				}
			}, this );

			this.$( '.cfgm-locationlist-body' ).append( _.pluck( this.items, 'el' ) );
			return this;
		},
		addLocation: function( model ) {
			this.items[model.cid] = new app.Views.LocationItem( {model: model} );
			this.$( '.cfgm-locationlist-body' ).append( this.items[model.cid].el );
		},
		reset: function(){
			_.invoke( this.items, 'remove' );
			this._reset();
			this.render();
		},
		_reset: function(){
			this.items = {};
			this.selected = null;
		},
		removeOne: function( model ) {
			if ( _.has( this.items, model.cid ) ) {
				this.items[model.cid].remove();
				delete this.items[model.cid];
			}
		},
		remove: function(){
			_.invoke( this.items, 'remove' );
			this._reset();
			return Backbone.View.prototype.remove.apply( this, arguments );
		},
		select: function( model ) {
			model = this.collection.get( model );
			if ( model && _.has( this.items, model.cid ) ) {
				this.deselect( this.selected );
				this.items[model.cid].select();
				this.selected = model;
			}
		},
		deselect: function( model ) {
			model = this.collection.get( model );
			if ( model && _.has( this.items, model.cid ) ) {
				this.items[model.cid].deselect();
				this.selected = null;
			}
		}
	} );

// ----------------------------------------------------------------------------



	app.Views.LocationItem = Backbone.View.extend( {
		id: function(){
			return _.uniqueId( 'location-item-' );
		},
		tagName: 'tr',
		className: function(){
			var classes = [ 'cfgm-location' ];
			this.model.get( 'primary' ) && classes.push( 'cfgm-location-primary' );
			this.model.get( 'hide' ) && classes.push( 'cfgm-location-hidden' );
			this.selected && classes.push( 'cfgm-location-selected' );
			return classes.join( ' ' );
		},
		events: {
			'click .cfgm-location-action-hide': '_toggleHidden',
			'click .cfgm-location-action-primary': '_setAsPrimary',
			'click .cfgm-location-action-delete': '_actionDelete',
			'click .cfgm-location-action-edit': '_actionEdit',
			'click .cfgm-location-title': '_toggleSelect'
		},
		template: function( data ) {
			return wp.template( 'cfgm-location' )( data );
		},
		initialize: function(){
			this.render();
			this.listenTo( this.model, {
				'change:hide': this.renderClassName,
				'change:primary': this.renderClassName,
				'change:title': this.render
			} );
		},
		render: function(){
			this.$el.html( this.template( this.model.toJSON() ) );
			return this;
		},
		renderClassName: function(){
			this.el.className = _.result( this, 'className' );
		},
		_toggleHidden: function() {
			this.model.set( 'hide', ! this.model.get( 'hide' ) );
		},
		_setAsPrimary: function() {
			this.model.set( 'primary', true );
		},
		_actionDelete: function() {
			this.model.collection.remove( this.model );
		},
		_actionEdit: function() {
			this.model.trigger( 'edit', this.model );
		},
		select: function() {
			this.selected = true;
			this.renderClassName();
		},
		deselect: function() {
			this.selected = false;
			this.renderClassName();
		},
		_toggleSelect: function() {
			this.model[this.selected ? 'deselect' : 'select']();
		}
	} );

// ----------------------------------------------------------------------------



	app.Views.LocationEdit = Backbone.View.extend( {
		className: 'cfgm-edit cfgm-content-panel',
		template: function( data ) {
			return wp.template( 'cfgm-edit' )( data );
		},
		events: {
			'click .cfgm-location-action-hide': '_toggleHidden',
			'click .cfgm-location-action-primary': '_setAsPrimary',
			'click .cfgm-location-action-delete': '_actionDelete',
			'click .cfgm-edit-action-cancel': '_discard',
			'click .cfgm-edit-action-save': '_save',
			'keyup [data-attribute="title"]': '_updateFrameTitle',
			'keydown [data-attribute]': '_advanceFocus',
			'change [data-attribute]': '_updateMockModel'
		},
		initialize: function( options ) {
			this._model = this.model.clone();

			this.listenTo( this._model, {
				'remove': this._delete,
				'change:hide': this.renderHeaderClasses,
				'change:primary': this.renderHeaderClasses,
				'change:image': this.updateImage,
				'change:latLng': this.updateLatLng
			} );

			this.imageSelect = new app.Views.ImageSelect( {model: this._model} );

			this.listenTo( this, 'opened', function() {
				this.$( '[data-attribute]' ).first().focus();
			} );

			Backbone.trigger( 'editing', this._model, this );
		},
		open: function() {
			// Make sure the initial state is applied.
			window.getComputedStyle( this.el ).opacity;

			this.$el
				.one( this.transition.end, _.bind( function() {
					this.trigger( 'opened', this );
				}, this ) );
			this.trigger( 'open', this );
			this._emulateTransitionEnd( 300 );
			this.$el.addClass( 'cfgm-edit-open' );
		},
		close: function() {
			this.$el
				.one( this.transition.end, _.bind( function() {
					this.trigger( 'closed', this );
					this.remove();
				}, this ) );
			this.trigger( 'close', this );
			this._emulateTransitionEnd( 300 );
			this.$el.removeClass( 'cfgm-edit-open' );
		},
		_discard: function(){
			this.close();
		},
		_save: function(){
			this.close();
			this.model.set( this._model.toJSON() );
		},
		_updateFrameTitle: function( e ) {
			if ( e.isDefaultPrevented() ) {
				return;
			}
			this.$( '.cfgm-edit-title' ).text( this.$( '[data-attribute="title"]' ).val() );
		},
		_advanceFocus: function( evt ) {
			if ( evt.isDefaultPrevented() || 'TEXTAREA' === evt.target.nodeName ) {
				return;
			}

			if ( ! ( 'Enter' === evt.key /* DOM 3 */ || 'U+000A' === evt.key /* IE9 */ || 0x0D === evt.keyCode ) ) {
				return;
			}

			evt.preventDefault();
			evt.stopPropagation();
			var fields = this.$( '[data-attribute]' ),
				currentIndex = fields.index( evt.target );

			if ( currentIndex === ( fields.length - 1 ) ) {
				// last item advance to save
				this.$( '.cfgm-edit-action-save' ).focus();
			} else {
				fields.eq( currentIndex + 1 ).focus();
			}
		},
		_toggleHidden: function() {
			this._model.set( 'hide', ! this.model.get( 'hide' ) );
		},
		_setAsPrimary: function() {
			this._model.set( 'primary', true );
		},
		_actionDelete: function() {
			this._model.trigger( 'remove' );
		},
		_updateMockModel: function( evt ) {
			var $el = $( evt.target );
			this._model.set( $el.data( 'attribute' ), $el.val() );
		},
		_delete: function() {
			this.model.collection.remove( this.model );
			this.close();
		},
		render: function(){
			this.imageSelect.$el.detach();
			this.$el.html( this.template( this._model.toJSON() ) );
			this.$( '[data-attribute="image"]' ).after( this.imageSelect.render().el );
			return this;
		},
		renderHeaderClasses: function(){
			var classes = [ 'cfgm-edit-header' ];
			this._model.get( 'primary' ) && classes.push( 'cfgm-location-primary' );
			this._model.get( 'hide' ) && classes.push( 'cfgm-location-hidden' );

			this.$( '.cfgm-edit-header' )[0].className = classes.join( ' ' );
		},
		updateImage: function(){
			this.$( '[data-attribute="image"]' ).val( this._model.get( 'image' ) );
		},
		updateLatLng: function(){
			this.$( '[data-ignore-attribute="latLng"]' ).val( this._model.get( 'latLng' ).lat.toFixed( 6 ) + ', ' + this._model.get( 'latLng' ).lng.toFixed( 6 ) );
		},
		remove: function() {
			delete this._model;
			this.imageSelect.remove();
			return Backbone.View.prototype.remove.apply( this, arguments );
		},
		_emulateTransitionEnd: function( duration ) {
			var called = false, $el = this.$el, transitionEnd = this.transition.end;
			$el.one( transitionEnd, function() {
				called = true;
			} );
			var callback = function() {
				if ( ! called )
					$el.trigger( transitionEnd );
			};
			setTimeout( callback, duration );
		},
		transition: ( function() {
			var style = document.documentElement.style,
				transitions = {
					WebkitTransition: 'webkitTransitionEnd',
					MozTransition: 'transitionend',
					OTransition: 'oTransitionEnd otransitionend',
					transition: 'transitionend'
				}, transition;

			transition = _.find( _.keys( transitions ), function( transition ) {
				return ! _.isUndefined( style[ transition ] );
			} );

			return transition && {
				end: transitions[ transition ]
			};
		}() )
	} );

// ----------------------------------------------------------------------------



	app.Views.ImageSelect = Backbone.View.extend( {
		className: function(){
			var classes = [ 'cfgm-media-box' ];
			this.model.get( 'image' ) && classes.push( 'cfgm-has-media' );
			return classes.join( ' ' );
		},
		template: function( data ) {
			return wp.template( 'cfgm-media' )( data );
		},
		events: {
			'click [data-action="add"]': '_open',
			'click [data-action="change"]': '_open',
			'click [data-action="remove"]': '_remove',
		},
		initialize: function( options ) {
			this._attachment = this.model.get( 'image' ) && wp.media.attachment( this.model.get( 'image' ) );
			this.frame = wp.media( {
				frame: 'select',
				library: {
					type: 'image'
				},
				multiple: false,
			} );

			this.listenTo( this.model, 'change:image', this.render );
			this.frame.on( 'select', _.bind( this.updateImage, this ), this );
		},
		_open: function(){
			this.frame.open();
			this.frame.state().get( 'selection' ).reset( this._attachment );
		},
		_remove: function(){
			this.frame.state() && this.frame.state().get( 'selection' ).reset();
			this._attachment = null;
			this.model.set('image', 0);
			this.$el.removeClass( 'cfgm-has-media' );
		},
		updateImage: function() {
			this._attachment = this.frame.state( ).get( 'selection' ).first();
			this.$el.addClass( 'cfgm-has-media' );
			this.model.set( 'image', this._attachment.id );
		},
		render: function() {
			if ( this._attachment && ! _.has( this._attachment.toJSON(), 'url' ) ) {
				this._attachment.fetch().done( _.bind( this.render, this ) );
				return this;
			}
            this.$el.html(this.template(this.toJSON()));
            return this;
		},
		toJSON: function() {
			if ( ! this._attachment ) {
				return {image: false};
			}
			var attachmentSizes = this._attachment.toJSON().sizes,
				size = _.find( [ 'thumbnail', 'post-thumbnail', 'full' ], function( size ) {
					if ( _.has( attachmentSizes, size ) ) {
						return true;
					}
				} );

			return {image: attachmentSizes[size] || false};
		},
		remove: function(){
			this.frame.off(null, null, this);
			return Backbone.View.prototype.remove.apply( this, arguments );
		}
	} );

// ----------------------------------------------------------------------------



	app.Views.Settings = Backbone.View.extend( {
		template: function( data ) {
			return wp.template( 'cfgm-settings' )( data );
		},
		events: {
			'change [data-attribute]': '_updateModel',
			'keydown [data-attribute]': '_advanceFocus',
		},
		initialize: function() {
			this.listenTo( this.model, 'change:mapType', this._maybeDisableSettings );
			this.listenTo( this.model, 'change:mapType', this.render );
			this.listenTo( this.model, 'change:filters', this.render );
			this.render();
		},
		_maybeDisableFilters: function() {
			if ( 'static' === this.model.get( 'mapType' ) ) {
				this.model.set( {
					filters: false,
					expandable: false
				}, {silent: true} );
			}
		},
		render: function(){
			this.$el.html( this.template( this.model.toJSON() ) );
			return this;
		},
		_updateModel: function( evt ) {
			var target = $( evt.target ),
				attribute = target.data('attribute');
			switch(attribute) {
				case 'mapType':
				case 'filterLabel':
				case 'height':
					this.model.set( attribute, target.val() );
					break;
				case 'filters':
				case 'expandable':
					this.model.set( attribute, target.prop( 'checked' ) );
					break;
			}
		},
		_advanceFocus: function( evt ) {
			if ( evt.isDefaultPrevented() || 'TEXTAREA' === evt.target.nodeName ) {
				return;
			}

			if ( ! ( 'Enter' === evt.key /* DOM 3 */ || 'U+000A' === evt.key /* IE9 */ || 0x0D === evt.keyCode ) ) {
				return;
			}

			evt.preventDefault();
			evt.stopPropagation();
			var fields = this.$( '[data-attribute]' ),
				currentIndex = fields.index( evt.target );

			if ( currentIndex === ( fields.length - 1 ) ) {
				// do nothing
			} else {
				fields.eq( currentIndex + 1 ).focus();
			}
		}
	} );

	/* ************************************************************************** *
	 *                                 # MODLES                                   *
	 * ************************************************************************** */

	app.Models.Location = Backbone.Model.extend( {
		defaults: {
			title: '',
			description: '',
			address: '',
			image: 0,
			primary: false,
			hide: false,
			dimensionX: 0,
			latLng: {
				lat: 0,
				lng: 0
			}
		},
		stale: [],
		toJSON: function() {
			return this.omit( this.stale );
		},
		select: function() {
			this.trigger( 'select', this );
			return this;
		},
		deselect: function() {
			this.trigger( 'deselect', this );
			return this;
		}
	} );

// ----------------------------------------------------------------------------



	app.Models.AutocompleteLocation = app.Models.Location.extend( {
		constructor: function(attributes, options) {
			options = options ? _.extend( options, {parse: true} ) : {parse: true};
			this.stale.push( '_autocomplete' );
			app.Models.Location.call( this, attributes, options );
		},
		/*
		 * Sample autocomplete response object
		 *
		 * {
				"address_components": [
					{
						"long_name": "Alexandria",
						"short_name": "Alexandria",
						"types": [
							"locality",
							"political"
						]
					},
					.....
				],
				"adr_address": "Alexandria, <span class=\"region\">Alexandria Governorate</span>, <span class=\"country-name\">Egypt</span>",
				"formatted_address": "Alexandria, Alexandria Governorate, Egypt",
				"geometry": {
					"location": { // google.maps.LatLng object
						"k": 31.2000924,
						"B": 29.91873869999995
					},
					"viewport": { // google.maps.LatLngBounds object
						"Ea": {
							"k": 31.1173177,
							"j": 31.330904
						},
						"va": {
							"j": 29.823370100000034,
							"k": 30.08640170000001
						}
					}
				},
				"icon": "http://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png",
				"id": "9484b9a4f80721c0a448916823ac7e3feaf59cf5",
				"name": "Alexandria",
				"place_id": "ChIJ0w9xJpHE9RQRuWvuKabN4LQ",
				"reference": "CpQBjQAAAEKcE6sucrFZA3ukJforeTvIVCyjdNfDpx7fiw781NxIGuDPQZCdmqjnAj6ZT-chFBWbKfoFMD_trZtcI3oaviynvlKVpGvKUE1jLElMHP2VCShDCJq-ziDdEUjAO-kMStzbjBYn7rWI0pHpQlC4TnTmZOkfu3Y3doSi0h3uhsl7G2UYGe7xcnf8u_BLud8PHhIQZH9ivS44qOPkcCZyIP3zYBoUe_JfD9jmVRc0rzN_EdlnzX9Ltfo",
				"scope": "GOOGLE",
				"types": [
					"locality",
					"political"
				],
				"url": "https://maps.google.com/maps/place?q=Alexandria,+Alexandria+Governorate,+Egypt&ftid=0x14f5c49126710fd3:0xb4e0cda629ee6bb9",
				"vicinity": "Alexandria",
				"html_attributions": [ ]
			}
		 *
		 * @param object
		 * @returns object
		 */
		parse: function( attrs ) {
			if ( attrs._autocomplete ) {
				return attrs;
			}

			var _attrs = {
				_autocomplete: attrs,
				title: attrs.name || '',
				address: attrs.formatted_address || '',
			};
			if ( attrs.geometry && attrs.geometry.location ) {
				_attrs.latLng = {
					lat: attrs.geometry.location.lat(),
					lng: attrs.geometry.location.lng()
				};
			}
			return _attrs;
		}
	} );

// ----------------------------------------------------------------------------



	app.Models.Error = Backbone.Model.extend( {
		defaults: {
			msg: ''
		}
	} );

// ----------------------------------------------------------------------------



	app.Models.Settings = Backbone.Model.extend( {
		defaults: {
			mapType: 'dynamic',
			filters: false,
			filterLabel: 'Filter',
			height: 300,
			expandable: false
		}
	} );

	/* ************************************************************************** *
	 *                               # COLLECTIONS                                *
	 * ************************************************************************** */

	app.Collections.Locations = Backbone.Collection.extend( {
		model: app.Models.Location,
		initialize: function(){
			this.on( {
				'change:primary': this._changePrimary,
				'add remove reset': this._ensurePrimary
			} );
		},
		/**
		 *
		 * @todo merge with _ensurePrimary, overcome possible recursion due to change events
		 */
		_changePrimary: function( model ) {
			// find all locations with primary = true;
			var primaries = this.where( {primary: true} );
			// there has to be at least one primary
			if ( ! primaries ) {
				model.set( 'primary', true );
			} else
			// only bother with primary = true, to turn off the other primaries
			if ( model.get( 'primary' ) ) {
				_.each( primaries, function( primary ) {
					if ( model.cid !== primary.cid ) {
						primary.set( 'primary', false );
					}
				} );
			}
		},
		reset: function( models, options ) {
			var r = Backbone.Collection.prototype.reset.apply( this, arguments );
			if ( options.silent ) {
				this._ensurePrimary( this, options );
			}
			return r;
		},
		_ensurePrimary: function( model, self, options ) {
			// reset passes (this, options), add/remove passes (model, this, options)
			if ( model === this ) {
				options = self;
			}
			if ( ! this.length ) {
				return;
			}
			var primary = this.where( {primary: true} );
			if ( primary.length !== 1 ) {
				if ( primary.length > 1 ) {
					_.chain( primary ).tail().invoke( 'set', 'primary', false, options );
				} else {
					this.first().set( 'primary', true, options );
				}
			}
		}
	} );

// ----------------------------------------------------------------------------



	app.Collections.Errors = Backbone.Collection.extend( {
		model: app.Models.Error
	} );

// ----------------------------------------------------------------------------


	$( document ).ready( function() {
		var mapBlockView;
		$( document ).on( 'show.bs.modal', function( e ) {
			if ( e.relatedTarget && $( e.relatedTarget ).closest( '.block' ).is( '.block-cr_gmap_block' ) ) {
				// initialize new App
				mapBlockView = new app.Views.App( {state: $( e.target ).find( '[data-_data]' ).data( '_data' )} );
				$( e.target ).find( '.modal-body' ).append( mapBlockView.el );
				// wait until modal is shown, force refresh to fix google maps resize issue
				$( this ).one( 'shown.bs.modal', function() {
					mapBlockView.mapView.refresh();
				} );
			}
		} )
			.on( 'hidden.bs.modal', '.modal', function() {
				if ( $( this ).closest( '.block' ).is( '.block-cr_gmap_block' ) ) {
					//write the current state
					$( this ).find( '[data-_data]' ).data( '_data', mapBlockView.getState() ).val( JSON.stringify( mapBlockView.getState() ) );
					mapBlockView.remove();
					mapBlockView = null;
				}
			} );
	} );

}( jQuery, Backbone, _, wp, circleflipPagebuilderGooglemaps ) );