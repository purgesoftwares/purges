<?php
	class Circleflip_shortcode extends WP_Widget {
		function __construct () {
			parent::__construct(false, 'CF Shortcode Widget');
		}
		function form($instance) {
			// outputs the options form on admin
			$shortcode = isset($instance['shortcode']) ? ($instance['shortcode']) : '';
		 	?>
            <p><label for="<?php echo esc_attr($this->get_field_id('shortcode')); ?>"><?php _e('shortcode:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('shortcode')); ?>" name="<?php echo esc_attr($this->get_field_name('shortcode')); ?>" type="text" value="<?php echo esc_attr($shortcode); ?>" /></label></p>
        <?php
		}
		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			$instance = $old_instance;
			$instance['shortcode'] = strip_tags($new_instance['shortcode']);
			return $instance;
		}
		function widget($args, $instance) {
			 // outputs the content of the widget
			 extract( $args );
			 $shortcode = $instance['shortcode'];
				echo do_shortcode(htmlspecialchars_decode($shortcode));
			}
		}
	register_widget('Circleflip_shortcode');