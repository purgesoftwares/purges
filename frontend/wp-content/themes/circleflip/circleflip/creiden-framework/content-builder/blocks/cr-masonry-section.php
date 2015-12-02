<?php
/** A simple text block **/
class CR_Masonry_Section extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'masonry.png',
			'name' => 'Masonry Posts',
			'size' => 'span6'
		);

		//create the block
		parent::__construct('CR_Masonry_Section', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'title' => '',
			'post_number' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>">
					Title
				</label>
				<span class="description_text">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porta arcu at odio venenatis tincidunt. Cras mollis mi gravida velit tincidunt porta. Donec bibendum leo at iaculis rhoncus. Sed rutrum,
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('title', $block_id, $title, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('post_type') ) ?>">
					Posts Type
				</label>
				<span class="description_text">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porta arcu at odio venenatis tincidunt. Cras mollis mi gravida velit tincidunt porta. Donec bibendum leo at iaculis rhoncus. Sed rutrum,
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('post_type', $block_id, array('Latest Posts','Popular Posts','Selected Posts'), isset($post_type) ? $post_type : 'Latest Posts', array( 'data-fd-handle="post_type"' )) ?>
				</span>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('post_cat_type') ) ?>">
					Posts Category Type
				</label>
				<span class="description_text">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porta arcu at odio venenatis tincidunt. Cras mollis mi gravida velit tincidunt porta. Donec bibendum leo at iaculis rhoncus. Sed rutrum,
				</span>
			</span>
			<span class="rightHalf sel">
				<?php
				echo circleflip_field_multiselect('post_cat_type', $block_id, array('blog','portfolio'), isset($post_cat_type) ? $post_cat_type : '') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('post_selected_cats') ) ?>">
					Selected Categories
				</label>
				<span class="description_text">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porta arcu at odio venenatis tincidunt. Cras mollis mi gravida velit tincidunt porta. Donec bibendum leo at iaculis rhoncus. Sed rutrum,
				</span>
			</span>
			<span class="rightHalf">
				<?php
				$options_categories = circleflip_get_categories();
				echo circleflip_field_multiselect('post_selected_cats', $block_id, $options_categories, isset($post_selected_cats) ? $post_selected_cats : '') ?>
			</span>
		</p>
		<p class="description" data-fd-rules='["post_type:equal:2"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('post_selected_posts') ) ?>">
					Selected Posts
				</label>
				<span class="description_text">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porta arcu at odio venenatis tincidunt. Cras mollis mi gravida velit tincidunt porta. Donec bibendum leo at iaculis rhoncus. Sed rutrum,
				</span>
			</span>
			<span class="rightHalf">
				<?php
				$postNames = circleflip_get_posts();
				echo circleflip_field_multiselect('post_selected_posts', $block_id, $postNames, isset($post_selected_posts) ? $post_selected_posts : '') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('post_order') ) ?>">
					Posts Order
				</label>
				<span class="description_text">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porta arcu at odio venenatis tincidunt. Cras mollis mi gravida velit tincidunt porta. Donec bibendum leo at iaculis rhoncus. Sed rutrum,
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('post_order', $block_id, array('asc'=>'Ascending','desc'=>'Descending'), isset($post_order) ? $post_order : 'asc') ?>
				</span>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('type') ) ?>">
					Layout Style
				</label>
				<span class="description_text">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porta arcu at odio venenatis tincidunt. Cras mollis mi gravida velit tincidunt porta. Donec bibendum leo at iaculis rhoncus. Sed rutrum,
				</span>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('type', $block_id, array('Thirds','Fourths'), isset($type) ? $type : 'Thirds') ?>
				</span>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
			<label for="<?php echo esc_attr( $this->get_field_id('post_number') ) ?>">
				Number of Posts
			</label>
			<span class="description_text">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque porta arcu at odio venenatis tincidunt. Cras mollis mi gravida velit tincidunt porta. Donec bibendum leo at iaculis rhoncus. Sed rutrum,
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('post_number', $block_id, $post_number, $size = 'full') ?>
			</span>
		</p>
		<?php
	}

	function block($instance) {
		extract($instance);
		$this->masonry_Posts();
		add_filter( 'circleflip_post_format_gallery_html' ,  'circleflip_gallery_masonaryformat',  10, 5 );
		add_filter( 'circleflip_post_format_standard_html',  'circleflip_standard_masonaryformat', 10, 5 );
		add_filter( 'circleflip_post_format_video_html'   ,  'circleflip_video_masonaryformat',    10, 5 );
		add_filter( 'circleflip_post_format_audio_html'   ,  'circleflip_audio_masonaryformat',    10, 5 );
		add_filter( 'circleflip_post_format_media_size'   ,  'circleflip_full_video_size',         10, 5 );
		add_filter( 'circleflip_post_format_meta'         ,  'circleflip_gallery_layout',			10, 5 );
		/*
		 * Latest Posts - Popular - Selected Posts
		 * Blog Posts - Portfolio
		 * with Latest or Popular (Selected Categories Multiple Select)
		 * Order -> Ascending or descending
		 * Number of Posts
		 */
		switch ($post_type) {
			// Latest
			case '0':
					$args = array(
						'posts_per_page' => $post_number,
						'cat' => isset($post_selected_cats) ? implode(',',$post_selected_cats) : '',
						'post_type' => 'post',
						'orderby' => 'date',
						'order' => 'DESC',
						'post_status' => 'publish'
					);
				break;
			// Popular
			case '1':
				global $wpdb;
					$args = array(

						'posts_per_page' => $post_number,
						'post_type' => 'post',
	                    'orderby' => 'post__in',
	                    'post_status' => 'publish',
	                    'cat' => isset($post_selected_cats) ? implode(',',$post_selected_cats) : '',
	                    'post__in' =>$wpdb->get_col("SELECT post_id, COUNT(*) as total FROM views_count WHERE 1 = 1 GROUP BY post_id ORDER BY total $post_order"),
	                    'order' => 'DESC'
					);
				break;
			// Selected Posts
			case '2':
					if(circleflip_valid($post_selected_posts)) {
						$selectedPosts = implode(",", $post_selected_posts);
					} else {
						$selectedPosts = '';
					}
					$args = array(
	                    'include' => $selectedPosts,
	                    'orderby' => 'date',
	                    'order' => 'DESC'
	                );
				break;
			default:

				break;
		}
		$output = circleflip_query($args);
		switch ($type) {
			case '0':
				$layout = 'span4';
			break;
			case '1':
				$layout = 'span3';
				break;
			default:
				$layout = 'span4';
				break;
		}
		if ($output):?>
			<div class="masonary">
				<div class="dotHeader"></div>
				<div class="titleBlock"><h3><?php echo esc_html($title) ?></h3></div>
			</div>
			<div class="row masonryRow">
				<div class="loading_portfolio"></div>
				<div class="masonryContainer clearfix">
					<?php
					 foreach ($output as $post) : setup_postdata($post);
				?>
				  <div class="masonryItem <?php echo esc_attr($layout); ?>">
				  	<div class="masonryItemInner">
						<?php echo circleflip_get_post_format_media( $post->ID, 'masonry_post', 'my_unique_masonary_posts' ); ?>
				  	</div>
				  </div>

				<?php
				 endforeach;
				 echo '</div></div>';
			endif;
		circleflip_end_query();
	}
		function masonry_Posts() {
			wp_register_style('masonrySectionCSS',get_template_directory_uri().'/css/content-builder/masonrySection.css');
			wp_enqueue_style('masonrySectionCSS');
			wp_register_script('masonrySectionJS',get_template_directory_uri().'/scripts/modules/jquery.masonry.min.js');
			wp_enqueue_script('masonrySectionJS');
			wp_register_script('masonrySectionCustomJS',get_template_directory_uri().'/scripts/modules/masonry.custom.js');
			wp_enqueue_script('masonrySectionCustomJS');
			wp_register_script('pretty',get_template_directory_uri() . '/js/prettyPhoto.js',array('jquery'),'2.0.3',true);
			wp_enqueue_script('pretty');
			wp_register_style('prettyStyle', get_template_directory_uri() . '/css/prettyphoto/style/prettyPhoto.css',array('jquery'),'2.0.3',true);
			wp_enqueue_style('prettyStyle');
		}
}
