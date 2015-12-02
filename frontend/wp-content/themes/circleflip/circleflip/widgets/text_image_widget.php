<?php 
	class Circleflip_text_image extends WP_Widget {
		function __construct() {
			parent::__construct(false, 'CF Image-Text-Shortcode Widget');
		}
		function form($instance) {
			// outputs the options form on admin
			$title = isset($instance['title']) ? ($instance['title']) : '';
			$firstLink = isset($instance['firstLink']) ? ($instance['firstLink']) : '#';
			$firstImg = isset($instance['firstImg']) ? ($instance['firstImg']) :  get_template_directory_uri().'/widgets/images/imageTextWidget.png';
			$text = isset($instance['text']) ? ($instance['text']) : 'Duis facilisis rhoncus turpis, et luctus turpis uam et. Nulla tunt um metus et congue.Duis facilisis rhoncus turpis, et luctus turpis uam et.<br/><br/>uctus turpis uam et. Nulla tunt um metus et congue.Duis facilisis rhoncus turpis, et luctus turpis uam et. ';
			$shortcode = isset($instance['shortcode']) ? ($instance['shortcode']) : '';
		 	?>
            <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>			
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('firstImg')); ?>">
					<?php _e('Image :','circleflip'); ?> 
					<input class="widefat upload_input" id="<?php echo esc_attr($this->get_field_id('firstImg')); ?>" 
						   name="<?php echo esc_attr($this->get_field_name('firstImg')); ?>" 
						   type="text" value="<?php echo esc_url($firstImg); ?>" />
						   
					<button type="button" class="circleflip-media-uploader">Upload</button>
				</label>
			</p>
			<p><label for="<?php echo esc_attr($this->get_field_id('firstLink')); ?>"><?php _e('Link for image :','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('firstLink')); ?>" name="<?php echo esc_attr($this->get_field_name('firstLink')); ?>" type="text" value="<?php echo esc_url($firstLink); ?>" /></label></p>
			<p><label for="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php _e('Text :','circleflip'); ?> <textarea style="height: 150px" class="widefat" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>"><?php echo esc_textarea($text); ?></textarea></label></p>
			<?php
				wp_enqueue_media();
				wp_enqueue_script( 'wp-media-frame',get_template_directory_uri(). "/js/jquery.circleflip.mediaframe.js");
            ?>
			<script type="text/javascript">
				jQuery(function($){
					$('button.circleflip-media-uploader').circleflip_MediaFrame({
			            title: 'Select Image for widget',
			            onSelect: function( attachment ) {
			            	$(this).siblings('.upload_input').val(attachment[0].url);
			            }
			        });
				});
			</script>
        <?php 
		}
		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['firstLink'] = strip_tags($new_instance['firstLink']);
			$instance['firstImg'] = strip_tags($new_instance['firstImg']);
			$instance['text'] =$new_instance['text'];
			return $instance;
		}
		function widget($args, $instance) {
			// outputs the content of the widget
			extract( $args );
			if($args['id'] == 'sidebar-footerwidgetarea')
				 $footer_width = 'span'.circleflip_calculate_widget_width();
			else 
				$footer_width = '';
       		 $title = apply_filters('widget_title', $instance['title']);
			 $firstLink = $instance['firstLink'];
			 $firstImg = $instance['firstImg'];
			 $text = $instance['text'];
			 ?>
			 
			 <li class="imageTextWidget widget customWidget <?php echo esc_attr($footer_width) ?>">
			 	<?php if($title != null) { ?>
			 		<div class="widgetDot"></div>
					<h3 class="widgetTitle grid2"><?php echo esc_html($title);?></h3>
				<?php } ?>
				<?php if($firstImg != null) {  ?>
				<?php if(($firstLink != null) || ($firstImg != null)) { ?>
						<?php if($firstLink != null){ ?>
							<a href="<?php echo esc_url($firstLink); ?>" target="_blank">
						<?php } ?>
								<img class="grid2" src="<?php echo esc_url($firstImg); ?>" alt=""/>
						<?php if($firstLink != null){ ?>
							</a>
						<?php }; ?>
				<?php } ?>
				<?php } ?>
				<?php if($text != null) { ?>
				<p class="textWidgetParagrph">
					<?php echo $text;?>
				</p>
				<?php } ?>
			</li>
			<?php }
		}
	register_widget('Circleflip_text_image');