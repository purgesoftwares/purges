<?php 
	class Circleflip_recent_post_widget extends WP_Widget {
		function __construct() {
			parent::__construct(false, 'CF Recent Posts Thumbnails');
		}
		function form($instance) {
			// outputs the options form on admin
			$title = isset($instance['title']) ? ($instance['title']) : 'Recent Posts';
			$number = isset($instance['number']) ? ($instance['number']) : '6';
		 	?>
		 	<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		 	<p><label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number of posts to show:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
		 	<?php 
		}
		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = strip_tags($new_instance['number']);
			return $instance;
		}
		function widget($args, $instance) {
			// outputs the content of the widget
			wp_enqueue_style('recent_posts',get_template_directory_uri() . "/css/widgets/recent_posts.css",'2.0.3');
			extract( $args );
			$title = apply_filters('widget_title', $instance['title']);
			$number = apply_filters('widget_number', $instance['number']);
			if($args['id'] == 'sidebar-footerwidgetarea')
				 $footer_width = 'span'.circleflip_calculate_widget_width();
			else 
				$footer_width = '';
			 ?>
				<li class="recentPost widget customWidget <?php echo esc_attr($footer_width) ?>">
					<?php if($title != null) { ?>
						<div class="widgetDot"></div>
						<h3 class="widgetTitle grid2"><?php echo esc_html($title);?></h3>
						<div class="recentPostPrev"></div>
						<div class="recentPostNext"></div>
					<div class="Carousel_recent">
						
					<?php }
					 $args = array(
						'numberposts' => -1,
				       	'orderby' => 'date',
				       	'order' => 'DESC',
						 'suppress_filters' => false,
				    );
						$posts = get_posts($args);
						$x = 0;
						$y = 0;
						$numberPost = 0;
						foreach ($posts as $post) {
							if(get_the_post_thumbnail($post->ID, 'cf-recent-posts') != null) {
								if($number < count($posts) ){
									if($numberPost == $number){
										break;
									}	
									$numberPost++;
								}
							if($x == $y+6 || $x == 0){
								$x = $y;
								
								?>
								<div class="container_Recent">
						 <?php	} ?>
								
							<div class="recent">
								<a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php echo get_the_post_thumbnail($post->ID, 'cf-recent-posts'); ?></a>
							</div>
							<?php
							$x++;
							if($x == $y+6){
							?>
							</div>
							<?php } 
							}
						}
					?>
					</div>
					</li>
			<?php }
		}
	register_widget('Circleflip_recent_post_widget');