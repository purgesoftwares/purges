<?php
/**
 * Description of class-circleflip-widget-google-maps
 *
 * @author ayman
 */

class Circleflip_Widget_Google_Maps extends WP_Widget {
	
	protected $_defaults;
	protected $_marker_defaults;

	public function __construct() {
		parent::__construct( false, __( 'CF Google Maps', 'circleflip' ) );
		wp_register_script(
				'cf-w-google-maps-admin',
				 get_template_directory_uri() . '/js/circleflip.widget.google.maps.admin.js',
				array('jquery', 'underscore', 'thickbox')
		);
		$this->_defaults = array(
			'title'		 => '',
			'zoom'		 => 8,
			'width'		 => 333,
			'height'	 => 333,
			'lat'		 => 31.224353,
			'lng'		 => 29.936192,
			'mapTypeId'	 => 'roadmap',
			'marker'	 => array(),
		);
		$this->_marker_defaults = array(
			'color'	 => 'red',
		);
		add_action( 'widgets_admin_page', array($this, 'editor') );
	}

	public function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->_defaults );
		if ( empty( $instance['marker']['lat'] ) ) {
			$instance['marker']['lat'] = $instance['lat'];
			$instance['marker']['lng'] = $instance['lng'];
			$instance['marker']['show'] = false;
		}
		$instance['marker'] = wp_parse_args( $instance['marker'], $this->_marker_defaults );
		?>
		<div class="cf-w-gm-container">
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'title' )) ?>">Title:</label>
				<input type="text" 
					   class="widefat"
					   id="<?php echo esc_attr($this->get_field_id( 'title' )) ?>" 
					   name="<?php echo esc_attr($this->get_field_name( 'title' )) ?>"
					   value="<?php echo esc_attr(esc_attr($instance['title'])) ?>">
			</p>
			<p>
				<input type="checkbox" 
					   class="cf-w-gm-marker-show"
					   id="<?php echo esc_attr($this->get_field_id( 'marker-show' )) ?>" 
					   name="<?php echo esc_attr($this->get_field_name( 'marker' )) ?>[show]"
					   <?php checked( $instance['marker']['show'] ) ?>>
				<label for="<?php echo esc_attr($this->get_field_id( 'marker-show' )) ?>">show marker in the front-end</label>
			</p>
			<p>
				<button type="button" 
						class="cf-w-google-map-builder button button-primary widefat"
						data-config='<?php echo esc_attr(json_encode( $instance )) ?>'>
					<span class="cf-hide-if-loading">let's Roll</span>
					<span class="spinner hidden" style="margin-top: 3px;float: none;"></span>
				</button>
			</p>
			<input type="hidden"
				   class="cf-w-gm-lat"
				   name="<?php echo esc_attr($this->get_field_name( 'lat' )) ?>" value="<?php echo esc_attr($instance['lat']) ?>">
			<input type="hidden"
				   class="cf-w-gm-lng"
				   name="<?php echo esc_attr($this->get_field_name( 'lng' )) ?>" value="<?php echo esc_attr($instance['lng']) ?>">
			<input type="hidden"
				   class="cf-w-gm-zoom"
				   name="<?php echo esc_attr($this->get_field_name( 'zoom' )) ?>" value="<?php echo esc_attr($instance['zoom']) ?>">
			<input type="hidden" 
				   class="cf-w-gm-marker-lat"
				   name="<?php echo esc_attr($this->get_field_name( 'marker' )) ?>[lat]" value="<?php echo esc_attr($instance['marker']['lat']) ?>">
			<input type="hidden" 
				   class="cf-w-gm-marker-lng"
				   name="<?php echo esc_attr($this->get_field_name( 'marker' )) ?>[lng]" value="<?php echo esc_attr($instance['marker']['lng']) ?>">
			<input type="hidden" 
				   class="cf-w-gm-mapTypeId"
				   name="<?php echo esc_attr($this->get_field_name( 'mapTypeId' )) ?>" value="<?php echo esc_attr($instance['mapTypeId']) ?>">
		</div>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance['marker']['show'] = isset( $new_instance['marker']['show'] );
		return $new_instance;
	}

	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->_defaults );
		$instance['marker'] = wp_parse_args( $instance['marker'], $this->_marker_defaults );
		echo $args['before_widget'];
		echo $args['before_title'], apply_filters('widget_title', $instance['title']), $args['after_title'];
		$this->render( $instance );
		echo $args['after_widget'];
	}
	
	public function editor( $instance ) {
		$this->enqueue();
		echo '<div id="cf-w-google-map-thickbox" class="hidden">',
				'<div id="cf-w-google-map-canvas" style="width: 100%;height: 360px">',
					'</div style="width:100%; height: 25px;">',
						'<button type="button" class="button button-primary cf-w-google-maps-done" style="float:right;margin-top: 10px;">Done"</button>',
					'<div>',
				'</div>',
			 '</div>';
	}
	
	protected function render( $instance ) {
		$s_m_args = array(
			'center'		 => "{$instance['lat']},{$instance['lng']}",
			'zoom'			 => $instance['zoom'],
			'size'			 => "{$instance['width']}x{$instance['height']}",
			'markers'		 => "color:{$instance['marker']['color']}|{$instance['marker']['lat']},{$instance['marker']['lng']}",
			'sensor'		 => 'false',
			'visual_refresh' => 'true',
			'scale'			 => 2,
		);
		if ( ! $instance['marker']['show'] )
			unset ( $s_m_args['markers'] );
		$static_map_url = add_query_arg( $s_m_args, 'http://maps.googleapis.com/maps/api/staticmap' );
		
		$g_m_args = array(
			'll'	 => "{$instance['lat']},{$instance['lng']}",
			'zoom'	 => $instance['zoom'],
		);
		$google_map_url = add_query_arg( $g_m_args, 'http://maps.google.com' );
		
		?>
		<a href="<?php echo esc_url($google_map_url) ?>">
			<img src="<?php echo esc_url($static_map_url) ?>">
		</a>
		<?php
	}
	
	protected function enqueue() {
		add_thickbox();
		wp_enqueue_script( 'cf-w-google-maps-admin' );
		wp_enqueue_script( 'cf-google-loader', 'https://www.google.com/jsapi' );
	}
}

add_action( 'widgets_init', 'circleflip_register_widget_google_maps' );

function circleflip_register_widget_google_maps() {
	register_widget( 'Circleflip_Widget_Google_Maps' );
}