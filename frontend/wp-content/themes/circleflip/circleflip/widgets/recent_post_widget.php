<?php
	class Circleflip_recent_post_text extends WP_Widget {
		function __construct() {
			parent::__construct(false, __('CF Recent Posts', 'circleflip') );
		}
		
		function form($instance) {
			// outputs the options form on admin
			$latest_title = isset($instance['title']) ? ($instance['title']) : 'Latest Posts';
	    	$latest_count = isset($instance['count']) ? ($instance['count']) : '2';
		 	?>
            <p>
            	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
            		<?php _e('Title:','circleflip'); ?> 
            		<input class="widefat" 
            			   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
            			   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
            			   type="text" 
            			   value="<?php echo esc_attr($latest_title); ?>" />
        		</label>
    		</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('count')); ?>">
					<?php _e('How many post to show?','circleflip'); ?> 
					<input class="widefat" 
						   id="<?php echo esc_attr($this->get_field_id('count')); ?>" 
						   name="<?php echo esc_attr($this->get_field_name('count')); ?>" 
						   type="text" 
						   value="<?php echo esc_attr($latest_count); ?>" />
			    </label>
		   </p>

        <?php
		}
		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['count'] = strip_tags($new_instance['count']);
			return $instance;
		}
		function widget($args, $instance) {
			// outputs the content of the widget
			wp_enqueue_style('recent_posts',get_template_directory_uri() . "/css/widgets/recent_posts.css",'2.0.3');
			extract( $args );
       		$latest_title = apply_filters('widget_title', $instance['title']);
			
       		echo $before_widget;
       		?>
				<!-- Widget Title -->
				<?php echo $before_title, $latest_title, $after_title;?>
				<?php
					 $latest_count = $instance['count'];
					 $args = array(
					 	'post_status' => 'publish',
					 	'post_type' => 'post',
					 	'order' => 'DESC',
					 	'posts_per_page' => (int) $latest_count,
					 );
					 
					 $the_query = new WP_Query( $args );
					 add_filter('excerpt_more', array($this, 'excerpt_more'));
					 add_filter('wp_trim_words', array($this, 'trim_excerpt'), 10, 4);
					 if ( $the_query->have_posts() ):
					 while ( $the_query->have_posts() ) :$the_query->the_post();
	       		?>
	       		<!-- Single Post -->
				<div class="footerPost clearfix">
					<!-- Image -->
					<?php
					if (has_post_thumbnail()) { 
						the_post_thumbnail('cf-recent-posts');
					}
					else{
						echo circleflip_get_default_image('cf-recent-posts') ?>
					<?php } ?>
					<!-- Title -->
					<a href="<?php the_permalink(); ?>">
						<h4>
							<?php the_title(); ?>
						</h4>
					</a>
					<!-- Text -->
					<?php the_excerpt() ?>
					<!-- Date -->
					<span><?php printf( _x( '%s ago', 'post published time', 'circleflip' ), human_time_diff( get_the_date( 'U', get_the_ID() ) ) ) ?></span>
				</div>
				<?php
					 endwhile;
					 endif;
					 wp_reset_postdata();
					 remove_filter('wp_trim_words', array($this, 'trim_excerpt'), 10);
					 remove_filter('excerpt_more', array($this, 'excerpt_more'));
				 ?>
			
		<?php 
			echo $after_widget;
			}

			public function trim_excerpt($text, $num_words, $more, $original_text) {
				
				 $trim_letters = substr($original_text,0,50); 
				 remove_filter('wp_trim_words', array($this, 'trim_excerpt'), 10);
				 $text = wp_trim_words( $original_text, str_word_count($trim_letters)-1, $more ); 
				 add_filter('wp_trim_words', array($this, 'trim_excerpt'), 10, 4);
				 return $text;
			}
			
			public function excerpt_more($more) {
				return '<a href="' . get_permalink(get_the_ID()) . '">' . _x('... More', 'posts read more', 'circleflip') . '</a>';
			}
		}
	register_widget('Circleflip_recent_post_text');