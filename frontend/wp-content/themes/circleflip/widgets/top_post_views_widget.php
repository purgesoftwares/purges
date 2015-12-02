<?php 
	class Circleflip_top_post_view_widget extends WP_Widget {
		function __construct() {
			parent::__construct(false, 'CF Top Post Preview Widget');
		}
		function form($instance) {
			// outputs the options form on admin
			$title = isset($instance['title']) ? ($instance['title']) : 'Top Post Preview';
			$number = isset($instance['number']) ? ($instance['number']) : '6';
		 	?>
		 	<p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		 	<p><label for="<?php echo esc_attr( $this->get_field_id('number') ); ?>"><?php _e('Number of posts to show:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
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
			wp_enqueue_style('top_post',get_template_directory_uri() . "/css/widgets/top_post.css",'2.0.3');
			extract( $args );
			$title = apply_filters('widget_title', $instance['title']);
			$number = apply_filters('widget_number', $instance['number']);
			if($args['id'] == 'sidebar-footerwidgetarea')
				 $footer_width = 'span'.circleflip_calculate_widget_width();
			else 
				$footer_width = '';
			 ?>
				<li class="topPost topPostwidth widget customWidget topPost_list_item <?php echo esc_attr($footer_width); ?>">
					<?php if($title != null) { ?>
						<div class="widgetDot"></div>
						<h3 class="widgetTitle grid2"><?php echo esc_html($title);?></h3>
						<div id="topPostPrev" class="topPostPrev topPostPrev"></div>
						<div id="topPostNext" class="topPostNext topPostNext"></div>
					<div class="carousel_topPost">
						
					<?php }
					  $posts_per_page = get_query_var('posts_per_page'); 
						 $paged = intval(get_query_var('paged')); 
						 $paged = ($paged) ? $paged : 1; 
						 $args = array(
						'posts_per_page' => $posts_per_page,
						'paged' => $paged,
						'more' => $more = 0,
						'orderby' => 'comment_count',
						'order' => 'DESC',
						 'suppress_filters' => false,
						);
						$posts = get_posts($args);
						$x = 0;
						foreach ($posts as $post) {
							if(get_the_post_thumbnail($post->ID,'cf-top-post') != null) {
								if($number < count($posts) ){
									if($x == $number){
										break;
									}
									$x++;
								}
								?>
								
							<div class="topPost carousel-inner">
								<a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'cf-top-post' ); ?></a>
							</div>
							<?php } ?>
					<?php	}
					?>
					</div>
				</li>
			<?php }
		}
	register_widget('Circleflip_top_post_view_widget');