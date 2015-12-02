<?php
	class Circleflip_images_widget extends WP_Widget {
		function __construct() {
			parent::__construct(false, 'CF Images Widget');
		}
		function form($instance) {
			$this->if__i__();
			// outputs the options form on admin
			$instance = wp_parse_args($instance, array(
				'title' => 'Awards & Recognitions',
				'images' => array(),
			));
			extract($instance);
		 	?>
		 	<p>
		 		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
		 			<?php _e('Title:','circleflip'); ?>
		 			<input class="widefat"
		 			id="<?php echo esc_attr($this->get_field_id('title')); ?>"
		 			name="<?php echo esc_attr($this->get_field_name('title')); ?>"
		 			type="text" value="<?php echo esc_attr($title); ?>" />
	 			</label>
 			</p>
		 	<br />


			<p>Images :</p>
			<div id="<?php echo esc_attr($this->get_field_id('images-container')) ?>">
				<?php foreach( $instance['images'] as $single_image) : ?>
				<div class="crdn-single-image" style="position: relative;">
					<button class="crdn-remove-single-image" type="button">X</button>
					<p>
						<label>
							Target Link:
							<input class="widefat"
								   name="<?php echo esc_attr($this->get_field_name('image_target')) ?>[]"
								   type="text" value="<?php echo esc_url($single_image[0]) ?>" />
						</label>
				   	</p>
				   	<p style="overflow: hidden;">
						<label>
							<span style="display: block">Image:</span>
							<input class="widefat upload_input"  style="float: left;width: 70%;"
								   name="<?php echo esc_attr($this->get_field_name('image_link')) ?>[]"
								   type="text" value="<?php echo esc_url($single_image[1])?>" />
						   <button type="button" class="circleflip-media-uploader" style="float: right;width: 23%;">Upload</button>
						</label>
				   	</p>
				   	<hr />
			   </div>
				<?php endforeach ?>
			</div>
			
			<input type="button" value="New Image" 
						   class="crdn-t-add-image"
						   data-target="#<?php echo esc_attr($this->get_field_id( 'images-container' )) ?>"
						   data-image="<?php echo esc_attr($this->get_field_name( 'image_link' )) ?>"
						   data-imgtarget="<?php echo esc_attr($this->get_field_name( 'image_target' )) ?>"
						   id="<?php echo esc_attr($this->get_field_id( 'add-image-field' )) ?>"/>
			
			<br />
			<br />
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
			
			<?php }
				function if__i__() {
				if ( '__i__' !== $this->number ){
					return;
				}
			?>
			
			<style>
			.crdn-remove-single-image{
				position: absolute;
				right: 0px;
				top: -5px;
				background: rgb(204, 204, 204);
				border: 1px solid white;
				cursor: pointer;
				font-family: Arial;
				font-weight: bold;
				font-size: 12px;
				color: white;
				padding: 1px 4px 1px 4px;
				border-radius: 4px;
			}
			.crdn-remove-single-image:hover {
				background: rgb(163, 163, 163);
			}
			</style>
			<script id="crdn-tmpl-image-field" type="text/tmpl">
				<div class="crdn-single-image" style="position: relative;">
					<button class="crdn-remove-single-image" type="button">X</button>
					<p>
						<label>
							Image target:
							<input class="widefat"
								   name="<%=data.imgtarget%>[]"
								   type="text" value="" />
						</label>
				   	</p>
				   	<p style="overflow: hidden;">
						<label>
							<span style="display: block">Image:</span>
							<input class="widefat upload_input" style="float: left;width: 70%;"
								   name="<%=data.image%>[]"
								   type="text" value="" />
						   <button type="button" class="circleflip-media-uploader" style="float: right;width: 23%;">Upload</button>
						</label>
				   	</p>
				   	<hr />
			   	</div>
			</script>

        <?php
		}
		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			$instance = $old_instance;
			$image_links = array_map(null, $new_instance['image_target'], $new_instance['image_link']);
			unset($new_instance['image_target']);
			unset($new_instance['image_link']);
			$instance = array_map('strip_tags', $new_instance);
			$instance['images'] = ! empty($image_links) ? $image_links : array();
			return $instance;
		}
		function image_widget(){
			wp_enqueue_style('image_css', get_template_directory_uri() . '/css/widgets/images_widget.css');
		}
		function widget($args, $instance) {
			// outputs the content of the widget
			extract( $args );
			$this->image_widget();
			$title = apply_filters('widget_title', $instance['title']);
			$images = isset($instance['images']) && !empty($instance['images']) ? $instance['images'] : array();
			if($args['id'] == 'sidebar-footerwidgetarea')
				 $footer_width = 'span'.circleflip_calculate_widget_width();
			else 
				$footer_width = '';
			 ?>
				<li class="imagesWidget widget customWidget <?php echo esc_attr($footer_width) ?>">
					<?php if($title != null) { ?>
						<div class="widgetDot"></div>
						<h3 class="widgetTitle grid2"><?php echo esc_html($title);?></h3>
					<?php } ?>
					<ul class="imagesWidgetList">
						<?php foreach( $images as $single_image) : ?>
							<li>
								<a href="<?php echo esc_url($single_image[0]); ?>" target="_blank">
									<img src="<?php echo esc_url($single_image[1]); ?>" alt=""/>
								</a>
							</li>
						<?php endforeach ?>
					</ul>
				</li>
			<?php }
		}
	register_widget('Circleflip_images_widget');