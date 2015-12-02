<?php
	class Circleflip_flickr_widget extends WP_Widget {
		function __construct() {
			parent::__construct(false, 'CF Flickr Widget');
		}
		function form($instance) {
			// outputs the options form on admin
			$flickr_title = isset($instance['title']) ? ($instance['title']) : 'Flickr Stream';
	    	$flickr_id = isset($instance['id']) ? ($instance['id']) : '';
			$flickr_no = isset($instance['flickr_no']) ? ($instance['flickr_no']) : 9;
		 	?>
		 	<p>
		 		<strong>Note: </strong> Please Use this widget only once in page.
		 	</p>
            <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($flickr_title); ?>" /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id('id')); ?>"><?php _e('Flickr id:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('id')); ?>" name="<?php echo esc_attr($this->get_field_name('id')); ?>" type="text" value="<?php echo esc_attr($flickr_id); ?>" /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id('flickr_no')); ?>"><?php _e('How many image to get?:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr_no')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr_no')); ?>" type="text" value="<?php echo esc_attr($flickr_no); ?>" /></label></p>

        <?php
		}
		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['id'] = strip_tags($new_instance['id']);
			$instance['flickr_no'] = strip_tags($new_instance['flickr_no']);
			return $instance;
		}

		function flickr_widget(){
			wp_enqueue_style('flickr_css', get_template_directory_uri() . '/css/widgets/flickr_widget.css');
		}
		function widget($args, $instance) {
			// outputs the content of the widget
			if($args['id'] == 'sidebar-footerwidgetarea')
				 $footer_width = 'span'.circleflip_calculate_widget_width();
			else 
				$footer_width = '';			
			extract( $args );
			$this->flickr_widget();
       		 $flickr_title = apply_filters('widget_title', $instance['title']);?>
				<li class="flickrWidget widget customWidget <?php echo esc_attr($footer_width); ?>" id="flickrStream">
					<?php if($flickr_title!=null){ ?>
						<div class="widgetDot"></div>
						<h3 class="widgetTitle grid2"><?php echo esc_html($flickr_title);?></h3>
					<?php }; ?>
					<ul class="flickrList clearfix"></ul>
				</li>
				<?php
				wp_register_script('flickr',get_template_directory_uri() . '/js/flickr.js');
				wp_enqueue_script('flickr');
				wp_register_script('flickrCustom',get_template_directory_uri() . '/scripts/modules/flickr_custom.js');
				wp_enqueue_script('flickrCustom');
				wp_register_script('pretty',get_template_directory_uri() . '/js/prettyPhoto.js');
				wp_enqueue_script('pretty');
				wp_register_style('prettyStyle', get_template_directory_uri() . '/css/prettyphoto/style/prettyPhoto.css');
				wp_enqueue_style('prettyStyle');

				wp_localize_script('flickrCustom', 'global_flickr', array(
					'limit' => $instance['flickr_no'],
					'id' => $instance['id'] ,
				));
				?>
			<?php }
		}
	register_widget('Circleflip_flickr_widget');