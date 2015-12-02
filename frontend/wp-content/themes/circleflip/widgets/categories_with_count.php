<?php 
	class Circleflip_category extends WP_Widget {
		function __construct() {
			parent::__construct(false, 'CF category Widget');
		}
		function form($instance) {
			// outputs the options form on admin
			$title = isset($instance['title']) ? $instance['title'] : '';
			?>
            <p><label for="<?php echo esc_attr($this->get_field_id('titleCategory')); ?>"><?php _e('Title:','circleflip'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        <?php 
		}
		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}
		function category_JS(){
			wp_enqueue_script('category_Count_css', get_template_directory_uri() . '/scripts/widgets/category_with_count.js');
			wp_enqueue_style('category_Count_js', get_template_directory_uri() . '/css/widgets/category_with_count.css');
		}
		function widget($args, $instance) {
			// outputs the content of the widget
			extract( $args );
			$this->category_JS();
       		$title = apply_filters('widget_title', $instance['title']);
			if($args['id'] == 'sidebar-footerwidgetarea')
				 $footer_width = 'span'.circleflip_calculate_widget_width();
			else 
				$footer_width = '';
			 ?>
			 
			 
			<li class="categoryCount widget customWidget <?php echo esc_attr($footer_width) ?>">
			 	<?php if($title != null) { ?>
			 		<div class="widgetDot"></div>
					<h3 class="widgetTitle grid2"><?php echo esc_html($title);?></h3>
				
				<?php 
				}
				$category_ids = get_terms( 'category', array('fields' => 'ids', 'get' => 'all') );
				foreach($category_ids as $cat_id) {
  					$cat_name = get_cat_name($cat_id);
					if($cat_name != 'Uncategorized'){
					?>
					<p class="widgetcategory_with_count  textwidget">
					<span class="left"><a href="<?php echo esc_url( get_category_link( $cat_id ) ); ?>"><?php echo esc_html($cat_name); ?></a></span>
					<?php
					$postsInCat = get_term_by('name',$cat_name,'category');
					$postsInCat = $postsInCat->count;
					?> <span class="right"><?php echo '('.$postsInCat.')'; ?></span>
					</p> 
				 <?php 
					}
				} ?>
			</li>
			<?php 
			}
	}
	register_widget('Circleflip_category');