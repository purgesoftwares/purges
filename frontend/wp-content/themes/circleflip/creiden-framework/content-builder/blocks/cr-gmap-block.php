<?php

class CR_GMap_Block extends AQ_Block {

	const API_KEY = 'AIzaSyDM2PmY1O5Aj7NJlboE8vOz6ILc5u2AowQ';

	public function __construct( $id_base = false, $block_options = array() ) {

		parent::__construct( 'cr_gmap_block', array(
			'tab'		 => 'Content',
			'name'		 => __( 'Google Map', 'circleflip' ),
			/* translators: google maps block description */
			'desc'		 => _x( 'Adds a dynamic/static google map', 'google maps block description', 'circleflip' ),
			'size'		 => 'span6',
			'image'		 => 'google_map.png',
			'imagedesc'	 => 'map.jpg',
			'_data'		 => array(
				'settings'	 => array(
					'mapType'		 => 'dynamic',
					'filters'		 => false,
					'expandable'	 => false,
					'height'		 => 300,
					'filterLabel'	 => 'Filter',
				),
				'locations'	 => array()
			), // main datastore
		) );

		$api_key = cr_get_option( 'google_api_key', self::API_KEY );

		add_action( 'circleflip_aq-page-builder-admin-enqueue', array( $this, 'admin_enqueue' ) );
		add_action( 'circleflip_aq-page-builder-admin-enqueue', array( $this, 'print_templates' ) );
	}

	/** Display the block
	 * 
	 * @param array $instance
	 */
	public function block( $instance ) {
		$instance = $this->parse_args( $instance );
		switch ( $instance['_data']['settings']['mapType'] ) {
			case 'static':
				$this->do_static_map( $instance );
				break;
			case 'dynamic':
				$this->do_dynamic_map( $instance );
				break;
		}
	}
	
	/** Prepare instance data
	 * 
	 * makes sure data is ready for use, also adds computed properties
	 * 
	 * @param array $instance
	 * @return array
	 */
	public function parse_args( $instance ) {
		$instance = $this->_transform( $instance );
		$instance['_data']['settings']['raw_height'] = $instance['_data']['settings']['height'];
		$instance['_data']['settings']['height'] = $instance['_data']['settings']['height'] == '-1' ? '100%' : $instance['_data']['settings']['height'] . 'px';
		return $instance;
	}
	
	/** Print google maps static IMG
	 * 
	 * @param array $instance
	 */
	public function do_static_map( $instance ) {
		echo vsprintf( '<img src="%s" width="%d" height="%d" alt="%s">', $this->get_static_map_src( $instance ) );
	}

	/** Print markup & enqueue scripts for google map
	 * 
	 * @param array $instance
	 */
	public function do_dynamic_map( $instance ) {
		wp_enqueue_script( 'circleflip-googlemaps-block', get_template_directory_uri() . '/creiden-framework/content-builder/assets/js/blocks/circleflip-googlemaps-block.js', array( 'jquery', 'jquery-ui-slider', 'underscore' ), null, true );
		wp_enqueue_style( 'circleflip-googlemaps-block', get_template_directory_uri() . '/css/content-builder/gmaps.css' );
		$this->enqueue_infowindow_tmpl();
		foreach ( $instance['_data']['locations'] as $i => $location ) {
			if ( $location['image'] ) {
				$instance['_data']['locations'][$i]['image'] = wp_get_attachment_image_src( $location['image'], 'thumbnail' );
			}
		}
		?>
		<div class="cfgm-block">
			<div class="mapCont">
				<?php if ( $instance['_data']['settings']['expandable'] ) : ?>
					<div class="mapLeftMore"></div>
				<?php endif; ?>
				<div class="cr-map-canvas"
					 data-markers="<?php echo esc_attr( json_encode( $instance['_data']['locations'] ) ) ?>"
					 data-settings="<?php echo esc_attr( json_encode( $instance['_data']['settings'] ) ) ?>"
					 style="width: 100%; height: <?php echo esc_attr($instance['_data']['settings']['height']) ?>;"></div>
			</div>
			<?php if ( $instance['_data']['settings']['filters'] ): ?>
			<div class="clear"></div>
			<div class="cfgm-filters">
				<h3><?php echo esc_html($instance['_data']['settings']['filterLabel']) ?>
					<?php $_dimensionX_values = wp_list_pluck( $instance[ '_data' ][ 'locations' ], 'dimensionX' ) ?>
					<span class="cfgm-filter-text">$<?php echo min( $_dimensionX_values ) ?> - $<?php echo max( $_dimensionX_values ) ?></span>
				</h3>
				<div class="cfgm-filter-range"></div>
			</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/** enqueue footer action once
	 * 
	 * @staticvar boolean $_did_one
	 * @return void
	 */
	public function enqueue_infowindow_tmpl() {
		static $_did_one = false;
		if ( $_did_one ) {
			return;
		}

		add_action( 'wp_print_footer_scripts', array( $this, 'print_infowindow_tmpl' ) );
		$_did_one = true;
	}

	/** Print InfoWindow template
	 * 
	 * the template is used by circleflip-googlemaps-block.js to render location details
	 * 
	 */
	public function print_infowindow_tmpl() {
		?>
		<script type="text/html" id="tmpl-cfgm-infowindow">
			<div class="cfgm-infowindow <# print(function(data){
				var classes = [];
				data.image || classes.push('cfgm-infowindow-noimage');
				data.title || classes.push('cfgm-infowindow-notitle');
				data.address || classes.push('cfgm-infowindow-noaddress');
				data.description || classes.push('cfgm-infowindow-nodescription');
				return classes.join(' ');
			}(data)) #>">
				<#if(data.image){#>
					<div class="cfgm-infowindow-image">
						<img src="{{data.image[0]}}"
							 <#if(data.image[1]){#>width="{{data.image[1]}}"<#}#>
							 <#if(data.image[2]){#>heigh="{{data.image[2]}}"<#}#>
							 alt="">
					</div>
				<#}#>
				<div class="cfgm-infowindow-content">
					<#if(data.title){#><h5 class="cfgm-infowidow-title">{{{data.title}}}
						<#if(false !== data.dimensionX){#><span>${{data.dimensionX}}</span><#}#>
					</h5><#}#>
					<#if(data.address){#><p class="cfgm-infowidow-address">{{{data.address}}}</p><#}#>
					<#if(data.description){#><p class="cfgm-infowidow-description">{{{data.description}}}</p><#}#>
				</div>
			</div>
		</script>
		<?php
	}

	public function form( $instance ) {
		$instance = $this->_transform( $instance );
		printf( '<input type="hidden" id="%s" name="%s" value="%s" data-_data="%3$s">',
				esc_attr( $this->get_field_id( '_data' ) ),
				esc_attr( $this->get_field_name( '_data' ) ),
				esc_attr( json_encode( $instance['_data'] ) )
		);
	}

	public function admin_enqueue() {
		wp_register_script( 'circleflip-google-maps', 'https://maps.googleapis.com/maps/api/js?libraries=places' );
		wp_register_script( 'circleflip-pagebuilder-googlemaps', get_template_directory_uri() . '/creiden-framework/content-builder/assets/js/blocks/circleflip-pagebuilder-googlemaps.js', array( 'jquery', 'underscore', 'wp-util', 'circleflip-google-maps' ), null, true );
		wp_register_style( 'circleflip-pagebuilder-googlemaps', get_template_directory_uri() . '/creiden-framework/content-builder/assets/css/circleflip-pagebuilder-googlemaps.css', array( 'colors' ) );
		wp_enqueue_script( 'circleflip-pagebuilder-googlemaps' );
		wp_enqueue_style( 'circleflip-pagebuilder-googlemaps' );

		$errors = array();
		wp_localize_script( 'circleflip-pagebuilder-googlemaps', 'circleflipPagebuilderGooglemaps', array(
			'config' => array(
				'apiKey' => 'AIzaSyDM2PmY1O5Aj7NJlboE8vOz6ILc5u2AowQ',
			),
			'text'	 => array(
				'GOOGLE_404' => __( 'Google maps failed to load', 'circleflip' ),
				'NO_API_KEY' => __( "<em>Google API key</em> is missing in [insert link here]", 'circlelfip' ),
			),
			'errors' => $errors,
		) );
	}

	/** Print templates for Block editing screen
	 * 
	 */
	public function print_templates() {
		?>
		<script type="text/tmpl" id="tmpl-cfgm-frame">
			<div class="cfgm-rightpanel cfgm-panel-container">
				<div class="cfgm-main cfgm-content-panel">
					<div class="cfgm-locations"></div>
					<div class="cfgm-settings"></div>
				</div>
			</div>
			<div class="cfgm-leftpanel">
				<div class="cfgm-error"></div>
				<div class="cfgm-map-container"></div>
			</div>
		</script>
		<script type="text/html" id="tmpl-cfgm-settings">
			<div class="cfgm-edit-field-row">
				<div class="cfgm-edit-field-title">
					Map Type
				</div>
				<div class="cfgm-edit-field">
					<select class="large-text" data-attribute="mapType">
						<option value="static" <#if('static' === data.mapType){#>selected<#}#>>Static</option>
						<option value="dynamic" <#if('dynamic' === data.mapType){#>selected<#}#>>Dynamic</option>
					</select>
				</div>
			</div>
			<#if('dynamic' === data.mapType){#>
				<div class="cfgm-edit-field-row">
					<div class="cfgm-edit-field-title">
						Expandable
					</div>
					<div class="cfgm-edit-field">
						<input type="checkbox" data-attribute="expandable" <#if(data.expandable){#>checked<#}#>>
					</div>
				</div>
			<#}#>
			<#if('dynamic' === data.mapType){#>
				<div class="cfgm-edit-field-row">
					<div class="cfgm-edit-field-title">
						Filters
					</div>
					<div class="cfgm-edit-field">
						<input type="checkbox" data-attribute="filters" <#if(data.filters){#>checked<#}#>>
					</div>
				</div>
			<#}#>
			<#if(data.filters){#>
				<div class="cfgm-edit-field-row">
					<div class="cfgm-edit-field-title">
						Filter label
					</div>
					<div class="cfgm-edit-field">
						<input class="large-text" type="text" data-attribute="filterLabel" value="{{data.filterLabel}}">
					</div>
				</div>
			<#}#>
			<div class="cfgm-edit-field-row">
				<div class="cfgm-edit-field-title">
					Height
				</div>
				<div class="cfgm-edit-field">
					<input class="large-text" type="text" data-attribute="height" value="{{data.height}}">
				</div>
			</div>
		</script>
		<script type="text/tmpl" id="tmpl-cfgm-map-container">
			<div class="cfgm-map-toolbar"></div>
			<div class="cfgm-map"></div>
		</script>
		<script type="text/tmpl" id="tmpl-cfgm-map-toolbar">
			<div class="cfgm-map-toolbar-pin">
				<span class="dashicons dashicons-location cfgm-map-pin"></span>
			</div>
			<div class="cfgm-map-toolbar-search"></div>
		</script>
		<script type="text/tmpl" id="tmpl-cfgm-map-search">
			<input type="text" class="cfgm-map-search">
		</script>
		<script type="text/tmpl" id="tmpl-cfgm-error">
			<#_.each( data, function( error ){#>
				<div class="error"><p>{{{error.msg}}}</p></div>
			<#} );#>
		</script>
		<script type="text/tmpl" id="tmpl-cfgm-locationlist">
			<p><?php _e( 'Locations:', 'circleflip' ) ?></p>
			<table class="widefat cfgm-locationlist">
				<thead>
					<tr>
						<th class="cfgm-location-key"></th>
						<th class="cfgm-location-title"><?php _e( 'Title', 'circleflip' ) ?></th>
						<th class="cfgm-location-actions"><?php _e( 'Actions', 'circleflip' ) ?></th>
					</tr>
				</thead>
				<tbody class="cfgm-locationlist-body"></tbody>
				<tfoot>
					<tr><th colspan="3">Start by adding a location</td></tr>
				</tfoot>
			</table>
		</script>
		<script type="text/tmpl" id="tmpl-cfgm-location">
			<th class="cfgm-location-key"><span class="dashicons dashicons-admin-network cfgm-location-action-primary" title="<?php _e('Primary Location', 'circleflip') ?>"></th>
			<th class="cfgm-location-title"><#if(data.title){#>{{data.title}}<#}else{#><?php echo _e( '(no title)', 'circleflip' ) ?><#}#></th>
			<td class="cfgm-location-actions">
				<span class="dashicons dashicons-edit cfgm-location-action-edit" title="<?php _e( 'Edit Location', 'circleflip' ) ?>"></span>
				<span class="dashicons dashicons-visibility cfgm-location-action-hide" title="<#if(!data.hide){#><?php _e( 'Hide Location', 'circleflip' ) ?><#}else{#><?php _e( 'Show Location', 'circleflip' ) ?><#}#>"></span>
				<span class="dashicons dashicons-trash cfgm-location-action-delete" title="<?php _e( 'Delete Location', 'circleflip' ) ?>"></span>
			</td>
		</script>
		<script type="text/tmpl" id="tmpl-cfgm-edit">
			<div class="cfgm-edit-header<#if(data.hide){#> cfgm-location-hidden<#}#><#if(data.primary){#> cfgm-location-primary<#}#>">
				<div class="cfgm-location-key"><span class="dashicons dashicons-admin-network cfgm-location-action-primary" title="<?php _e('Primary Location', 'circleflip') ?>"></div>
				<div class="cfgm-location-actions">
					<span class="dashicons dashicons-visibility cfgm-location-action-hide" title="<#if(!data.hide){#><?php _e( 'Hide Location', 'circleflip' ) ?><#}else{#><?php _e( 'Show Location', 'circleflip' ) ?><#}#>"></span>
					<span class="dashicons dashicons-trash cfgm-location-action-delete" title="<?php _e( 'Delete Location', 'circleflip' ) ?>"></span>
				</div>
				<h4 class="cfgm-location-title">
					<span class="cfgm-edit-pretitle"><?php _e( 'Editing:', 'circleflip' ) ?> </span>
					<span class="cfgm-edit-title">{{data.title}}</span>
				</h4>
			</div>
			<div class="cfgm-edit-body">
				<div class="cfgm-edit-field-row">
					<div class="cfgm-edit-field-title">
						LatLng
					</div>
					<div class="cfgm-edit-field">
						<input class="large-text" data-ignore-attribute="latLng" type="text" value="{{data.latLng.lat}} , {{data.latLng.lng}}" readonly>
					</div>
				</div>
				<div class="cfgm-edit-field-row">
					<div class="cfgm-edit-field-title">
						Title
					</div>
					<div class="cfgm-edit-field">
						<input class="large-text" data-attribute="title" type="text" value="{{data.title}}">
					</div>
				</div>
				<div class="cfgm-edit-field-row">
					<div class="cfgm-edit-field-title">
						Address
					</div>
					<div class="cfgm-edit-field">
						<input class="large-text" data-attribute="address" type="text" value="{{data.address}}">
					</div>
				</div>
				<div class="cfgm-edit-field-row">
					<div class="cfgm-edit-field-title">
						Description
					</div>
					<div class="cfgm-edit-field">
						<textarea class="large-text" data-attribute="description">{{data.description}}</textarea>
					</div>
				</div>
				<div class="cfgm-edit-field-row">
					<div class="cfgm-edit-field-title">
						Image
					</div>
					<div class="cfgm-edit-field">
						<input class="large-text" data-attribute="image" type="hidden" value="{{data.image}}">
					</div>
				</div>
				<div class="cfgm-edit-field-row">
					<div class="cfgm-edit-field-title">
						Filterable Value
					</div>
					<div class="cfgm-edit-field">
						<input class="large-text" data-attribute="dimensionX" type="number" value="{{data.dimensionX}}">
					</div>
				</div>
			</div>
			<div class="cfgm-edit-footer">
				<button class="button-secondary cfgm-edit-action-cancel" type="button"><?php _e( 'Cancel', 'circleflip' ) ?></button>
				<button class="button-primary cfgm-edit-action-save" type="button"><?php _e( 'Save Location', 'circleflip' ) ?></button>
			</div>
		</script>
		<script type="text/html" id="tmpl-cfgm-media">
			<#if (data.image) {#><img src="{{data.image.url}}" width="{{data.image.width}}" height="{{data.image.height}}"><#}#>
			<div class="cfgm-media-box-controls">
				<#if (data.image) {#>
					<button type="button" data-action="change" class="dashicons dashicons-edit button-secondary" title="Change"></button>
					<button type="button" data-action="remove" class="dashicons dashicons-trash button-secondary" title="Remove"></button>
				<#}else{#>
					<button type="button" data-action="add" class="dashicons dashicons-plus button-secondary" title="Add"></button>
				<#}#>
			</div>
		</script>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance['_data'] = ( array ) json_decode( wp_unslash( $new_instance['_data'] ), true );
		return parent::update( $new_instance, $old_instance );
	}

	/** Transform old instance to new instance schema
	 * 
	 * @param array $instance
	 * @return array
	 */
	protected function _transform( $instance ) {
		$_old_defaults = array(
			'latLng'		 => '0,0',
			'address'		 => '',
			'mapType'		 => 'static',
			'extend_anchor'	 => false,
			'show_marker'	 => true,
			'api_key'		 => '',
			'height'		 => 300
		);

		$_sim = array_intersect_key( $instance, $_old_defaults );

		if ( ! empty( $_sim ) ) {
			// there is some old keys
			$instance = wp_parse_args( $instance, $this->block_options );
			if ( isset( $instance['latLng'] ) ) {
				//build a location out of old data
				//and assume it is the primary location
				$_lat_lng = explode( ',', $instance['latLng'] );
				//clear primary location before we continue
				//@todo: will new/old data mix? ever?
				foreach ( $instance['_data']['locations'] as $i => $location ) {
					$instance['_data']['locations'][$i]['primary'] = false;
				}
				$instance['_data']['locations'][] = array(
					'title'			 => '',
					'description'	 => '',
					'image'			 => 0,
					'dimensionX'	 => 0,
					'latLng'		 => array(
						'lat'	 => $_lat_lng[0],
						'lng'	 => $_lat_lng[1],
					),
					'address'		 => isset( $instance['address'] ) ? $instance['address'] : '',
					'primary'		 => true,
					'hide'			 => isset( $instance['show_marker'] ) ?  ! $instance['show_marker'] : false,
				);

				unset( $instance['latLng'] );
			}

			if ( isset( $instance['address'] ) ) {
				unset( $instance['address'] );
			}

			if ( isset( $instance['show_marker'] ) ) {
				unset( $instance['show_marker'] );
			}

			if ( isset( $instance['api_key'] ) ) {
				unset( $instance['api_key'] );
			}

			if ( isset($instance['mapType'])  ) {
				$instance['_data']['settings']['mapType'] = $instance['mapType'];
				unset( $instance['mapType'] );
			}

			if ( isset($instance['height'])  ) {
				$instance['_data']['settings']['height'] = ( int ) $instance['height'];
				unset( $instance['height'] );
			}

			if ( isset($instance['extend_anchor'])  ) {
				$instance['_data']['settings']['expandable'] = !! $instance['extend_anchor'];
				unset( $instance['extend_anchor'] );
			}

		}
		return $instance;
	}

	/** Build Google Maps static map url
	 * 
	 * @param array $instance
	 * @return array {
	 *		$url    string Google maps image url,
	 *		$width  int    map width,
	 *		$height int    map height,
	 *		$alt    string primary location address
	 *	}
	 */
	protected function get_static_map_src( $instance ) {
		$width = 1170 * (intval( substr( $instance['size'], 4 ) ) / 12);
		$height = $instance['_data']['settings']['height'];
		$primary_marker = wp_list_filter( $instance['_data']['locations'], array( 'primary' => true ) );
		$center = $this->_format_location_latlng(  ! empty( $primary_marker ) ? array_shift( $primary_marker ) : ''  );
		$base_url = set_url_scheme( "//maps.googleapis.com/maps/api/staticmap" );

		$markers = array_map( array( $this, '_format_location_latlng' ), wp_list_filter( $instance['_data']['locations'], array( 'hide' => false ) ) );
		$markers_fragment = implode( '|', $markers );

		$args = array(
			'center' => $center,
			'size'	 => sprintf( '%dx%d', absint( $width ), absint( $height ) ),
			'scale'	 => 2,
		);

		if ( ! empty( $markers ) ) {
			$args['markers'] = $markers_fragment;
		}

		if ( 1 === count( $instance['_data']['locations'] ) ) {
			$args['zoom'] = 10;
		}

		$map_url = add_query_arg( $args, $base_url );

		return array(
			'url'	 => esc_url( $map_url ),
			'width'	 => esc_attr( $width ),
			'height' => esc_attr( $height ),
			'alt'	 => esc_attr( $primary_marker->address )
		);
	}

	/** Format LatLng obj to {1,3}.{6},{1,3}.{6}
	 * 
	 * @param stdClass $location
	 * @return string comma-seprated LatLng
	 */
	protected function _format_location_latlng( $location = null ) {
		if ( ! $location || ! is_array( $location ) ) {
			return '31.2,29.8';
		}

		return implode( ',', array( number_format( $location['latLng']['lat'], 6 ), number_format( $location['latLng']['lng'], 6 ) ) );
	}

}