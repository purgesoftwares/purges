<?php 
	class Circleflip_Testimonials extends WP_Widget {
		function __construct() {
			parent::__construct(false, 'CF Testimonials Widget');
		}
		
		function form($instance) {
			$this->if__i__();
			// outputs the options form on admin
			$instance = wp_parse_args($instance, array(
				'title' => 'Testimonials',
				'testimonials' => array(),
			));
			extract($instance);
			?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title for widget:','circleflip'); ?> 
					<input class="widefat" 
						   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
						   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
						   type="text" value="<?php echo esc_attr($title); ?>" />
				</label>
			</p>
			<p>Testimonials:</p>
			<div id="<?php echo esc_attr($this->get_field_id('testimonials-container')) ?>">
				<?php foreach( $instance['testimonials'] as $testimonial_item) : ?>
				<div class="crdn-testimonial-item closed cssTrans" style="position: relative;">
					<div class="test_collapse_title">
						<h4>Testimonial</h4>
						<button class="crdn-collapse-testimonial-item plus" type="button"></button>
						<button class="crdn-remove-testimonial-item" type="button">X</button>
					</div>
					<p>
						<label>
							<?php _e('Text:','circleflip'); ?> 
							<textarea style="height: 70px" class="widefat" 
									  name="<?php echo esc_attr($this->get_field_name( 'testimonial_text' )) ?>[]"><?php echo esc_textarea( $testimonial_item[0] ) ?></textarea>
						</label>
					</p>
		            <p style="overflow: hidden;">
		            	<label>
		            		<span style="display: block"><?php _e('Image :','circleflip'); ?></span>
		            		<input class="widefat upload_input" style="float: left;width: 70%;" 
		            			   name="<?php echo esc_attr($this->get_field_name('testimonial_image')) ?>[]" 
		            			   type="text" value="<?php echo esc_url($testimonial_item[1])?>" />
		            		<button type="button" class="circleflip-media-uploader" style="float: right;width: 23%;">Upload</button>
		            	</label>
	            	</p>
					<p style="float: left;width: 43%;">
						<label>
							<?php _e('Name:','circleflip'); ?> 
							<input class="widefat" 
								   name="<?php echo esc_attr($this->get_field_name('testimonial_name')); ?>[]" 
								   type="text" value="<?php echo esc_attr($testimonial_item[2])?>" />
						</label>
					</p>
					<p style="float: right;width: 43%;">
						<label>
							<?php _e('Job:','circleflip'); ?> 
							<input class="widefat" 
								   name="<?php echo esc_attr($this->get_field_name('testimonial_job')); ?>[]" 
								   type="text" value="<?php echo esc_attr($testimonial_item[3])?>" />
						</label>
					</p>
					<div style="clear: both;"></div>
				</div>
				<?php endforeach ?>
			</div>
			<input type="button" value="New Testimonial" 
						   class="crdn-t-add-testmonial"
						   data-target="#<?php echo esc_attr($this->get_field_id( 'testimonials-container' )) ?>"
						   data-text="<?php echo esc_attr($this->get_field_name( 'testimonial_text' )) ?>"
						   data-image="<?php echo esc_attr($this->get_field_name( 'testimonial_image' )) ?>"
						   data-name="<?php echo esc_attr($this->get_field_name( 'testimonial_name' )) ?>"
						   data-job="<?php echo esc_attr($this->get_field_name( 'testimonial_job' )) ?>"
						   id="<?php echo esc_attr($this->get_field_id( 'add-testimonial-field' )) ?>"/>
			<script>
				jQuery(function($){
					$( 'button.circleflip-media-uploader' ).circleflip_MediaFrame( {
						title: 'Select Image for widget',
						onSelect: function( attachment ) {
							$( this ).siblings( '.upload_input' ).val( attachment[0].url );
						}
					} );
				});
			</script>
        <?php 
		}
		
		function if__i__() {
			if ( '__i__' !== $this->number ){
				return;
			}
			?>
			<style>
			.crdn-remove-testimonial-item{
				position: absolute;
				right: 30px;
				top: 6px;
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
			.crdn-remove-testimonial-item:hover {
				background: rgb(163, 163, 163);
			}
			.crdn-testimonial-item {
				border-top: 1px solid #eee;
				overflow: hidden;
				margin-bottom: 15px;
			}
			.cssTrans{
				-webkit-transition: 0.3s ease;
				-moz-transition: 0.3s ease;
				-o-transition: 0.3s ease;
				transition: 0.3s ease;
			}
			.crdn-testimonial-item.opened{
				height: 278px;
			}
			.crdn-testimonial-item.closed{
				height: 36px;
			}
			.crdn-collapse-testimonial-item{
				position: absolute;
				right: 10px;
				top: 6px;
				background: rgb(204, 204, 204);
				border: 1px solid white;
				cursor: pointer;
				font-family: Arial;
				font-weight: bold;
				font-size: 12px;
				color: white;
				padding: 0px 1px 1px 0px;
				border-radius: 4px;
				width: 18px;
			}
			.crdn-collapse-testimonial-item.plus:after {
				content: '+';
				font-family: 'Arial';
				font-size: 14px;
			}
			.crdn-collapse-testimonial-item.minus:after {
				content: '-';
				font-family: 'Arial';
				font-size: 14px;
			}
			.crdn-collapse-testimonial-item:hover {
				background: rgb(163, 163, 163);
			}
			.test_collapse_title{
				position: relative;
				background: #f0f0f0;
				padding: 10px 10px 10px 10px;
			}
			.test_collapse_title h4{
				margin: 0;
			}
			</style>
			<script id="crdn-tmpl-testmonial-field" type="text/tmpl">
			   	<div class="crdn-testimonial-item opened cssTrans" style="position: relative;">
			   		<div class="test_collapse_title">
						<h4>Testimonial</h4>
				   		<button class="crdn-collapse-testimonial-item minus" type="button"></button>
						<button class="crdn-remove-testimonial-item" type="button">X</button>
					</div>
					<p>
						<label>
							<?php _e('Text:','circleflip'); ?> 
							<textarea style="height: 70px" class="widefat" 
									  name="<%=data.text%>[]"></textarea>
							
						</label>
					</p>
		            <p style="overflow: hidden;">
		            	<label>
		            		<span style="display: block"><?php _e('Image :','circleflip'); ?></span> 
		            		<input class="widefat upload_input" style="float: left;width: 70%;" 
		            			   name="<%=data.image%>[]" 
		            			   type="text" value="" />
		            	<button type="button" class="circleflip-media-uploader" style="float: right;width: 23%;">Upload</button>
		            	</label>
	            	</p>
					<p style="float: left;width: 43%;">
						<label>
							<?php _e('Name:','circleflip'); ?> 
							<input class="widefat" 
								   name="<%= data.name %>[]" 
								   type="text" value="" />
						</label>
					</p>
					<p style="float: right;width: 43%;">
						<label>
							<?php _e('Job:','circleflip'); ?> 
							<input class="widefat" 
								   name="<%= data.job %>[]" 
								   type="text" value="" />
						</label>
					</p>
					<div style="clear: both;"></div>
				</div>
			</script>
			<?php
		}
		
		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			$instance = $old_instance;
			$testimonials_ = array_map(null, $new_instance['testimonial_text'], $new_instance['testimonial_image'], $new_instance['testimonial_name'], $new_instance['testimonial_job']);
			unset($new_instance['testimonial_text']);
			unset($new_instance['testimonial_image']);
			unset($new_instance['testimonial_name']);
			unset($new_instance['testimonial_job']);
			$instance = array_map('strip_tags', $new_instance);
			$instance['testimonials'] = ! empty($testimonials_) ? $testimonials_ : array();
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
       		$testimonials_ = $instance['testimonials'];
       	?>
       		 <li class="testimonials widget customWidget <?php echo esc_attr($footer_width) ?>">
			 	<?php if($title != null) { ?>
			 		<div class="widgetDot"></div>
					<h3 class="widgetTitle grid2"><?php echo esc_html($title);?></h3>
				<?php } ?>
				<div id="myCarousel-testimonials" class="carousel slide testimonialsSlider carousel-fade">
				<a class="left carousel-control" href="#myCarousel-testimonials" data-slide="prev"></a>
				<a class="right carousel-control" href="#myCarousel-testimonials" data-slide="next"></a>
					<div class="carousel-inner">
						<?php
						wp_enqueue_style('Testimonial',get_template_directory_uri() . "/css/widgets/Testimonial.css",'2.0.3');
						wp_register_script('TestimonialJS',get_template_directory_uri() . "/scripts/widgets/Testimonials.js",array('jquery'),'2.0.3',false);
						wp_enqueue_script('TestimonialJS');
				
						$i=0; 
						foreach( $instance['testimonials'] as $testimonials_) : ?>
						<?php $tab_selected = $i == 0 ? 'active' : ''; $i++;  ?>
						<div class="item <?php echo esc_attr($tab_selected); ?>">
							<div class="TContainer">
								<div class="textwidget">
									<?php if($testimonials_[0] != null) { ?>
									<p class="TText"><?php echo esc_html($testimonials_[0]); ?></p> 
									<?php } ?>
								</div>
								<div class="testmonialsBottom">
								<?php if($testimonials_[1] != null) { ?>
									<div class="image"><img src="<?php echo esc_url($testimonials_[1]); ?>" alt ="testimonials photo" /></div>
								<?php } ?>
									<div class="testimonialspersonnal">
										<?php if($testimonials_[2] != null) { ?>
										<p class="TName"><?php echo esc_html($testimonials_[2]); ?></p>
										<?php } ?>
										<?php if($testimonials_[3] != null) { ?>
										<p class="TJob"><?php echo esc_html($testimonials_[3]); ?></p>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</li>
			<?php 
			}
	}
	register_widget('Circleflip_Testimonials');