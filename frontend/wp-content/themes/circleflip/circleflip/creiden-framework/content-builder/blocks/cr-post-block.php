<?php

/** A simple text block * */
class CR_Post_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image'		 => 'posts.png',
			'name'		 => 'Posts Block',
			'size'		 => 'span6',
			'home'		 => 'homePage',
			'tab'		 => 'Content',
			'imagedesc'	 => 'post.jpg',
			'desc'		 => 'A section of blog posts, customized to your specifications.'
		);

		//create the block
		parent::__construct( 'CR_Post_Block', $block_options );
	}

	function form( $instance ) {
		$defaults = array(
			'title'					 => '',
			'post_number'			 => '',
			'entrance_animation'	 => '',
			'post_cat_type'			 => 'blog',
			'post_shape'			 => 'circle',
			'hover_style'			 => 'squarestyle1',
			'animation_number'		 => 0,
			'post_style'			 => 'circle',
			'post_type'				 => '',
			'masonry'				 => false,
			'check_element_color'	 => 0,
			'elements_color'		 => ''
		);
		$instance = wp_parse_args( $instance, $defaults );
		extract( $instance );
		$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();
		?>
		<div class="block-container" data-post-shape="<?php echo esc_attr($post_shape) ?>" data-posts2show="<?php echo esc_attr($post_type) ?>">
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>">
						<?php _e( 'Block title', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_input( 'title', $block_id, $title, $size = 'full' ) ?>
				</span>
			</p>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'titleIcon' ) ) ?>">
						Title Icon:
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php $titleIconOption = array( 'without Icon', 'with Icon' ); ?>
						<?php echo circleflip_field_select( 'titleIcon', $block_id, $titleIconOption, isset( $titleIcon ) ? $titleIcon : 'without Icon'  ) ?>
					</span>
				</span>
			</p>
			<p class="description crdn-post-shape">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'post_shape' ) ) ?>">
						<?php _e( 'Post shape', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select postsStyle">
						<?php //echo circleflip_field_select( 'post_shape', $block_id, array( 'circle' => 'Circle', 'square' => 'Square' ), $post_shape, array('data-fd-handle="post_shape"') ) ?>
						<?php echo circleflip_field_select( 'post_shape', $block_id, array( 'circle' => 'Circle', 'square' => 'Square', 'magazine' => 'Magazine' ), $post_shape, array( 'data-fd-handle="post_shape"' ) ) ?>
					</span>
				</span>
			</p>
			<!-- only visible when post_shape is square -->
			<p class="description" data-fd-rules='["post_shape:equal:square"]'>
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'hover_style' ) ) ?>">
						<?php _e( 'Hover style', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select postsStyle">
						<?php echo circleflip_field_select( 'hover_style', $block_id, array( 'squarestyle1' => 'layout 1', 'squarestyle2' => 'layout 2', 'squarestyle3' => 'layout 3' ), isset( $post_style ) ? $post_style : 'circle', array( 'data-fd-handle="post_hover"' ) ) ?>
					</span>
				</span>
			</p>
			<p class="description" data-fd-rules='["post_shape:equal:square", "post_hover:equal:squarestyle1"]'>
				<img style="display: block;margin:0 auto; " src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/hover_1.png" alt=""/>
			</p>
			<p class="description" data-fd-rules='["post_shape:equal:square", "post_hover:equal:squarestyle2"]'>
				<img style="display: block;margin:0 auto; " src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/hover_2.png" alt=""/>
			</p>
			<p class="description" data-fd-rules='["post_shape:equal:square", "post_hover:equal:squarestyle3"]'>
				<img style="display: block;margin:0 auto; " src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/hover_3.png" alt=""/>
			</p>
			<p class="description" data-fd-rules='["post_shape:equal:square"]'>
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'masonry' ) ) ?>">
						<?php _e( 'Masonry', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf postsStyle">
						<?php echo circleflip_field_checkbox( 'masonry', $block_id, $masonry, array( 'data-fd-handle="masonry"' ) ) ?>
					</span>
				</span>
			</p>
			<!-- only visible when post_shape is circle -->
			<p class="description circlePostsShow" data-fd-rules='["post_shape:equal:circle"]'>
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'animation_number' ) ) ?>">
						<?php _e( 'Hover style', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php echo circleflip_field_select( 'animation_number', $block_id, array( 'animation 1', 'animation 2', 'animation 3', 'animation 4' ), isset( $animation_number ) ? $animation_number : 'animation 1'  ) ?>
					</span>
				</span>
			</p>
			<!-- only visible when post_shape is Magazine -->
			<p class="description AnnouncementCheckIcon" data-fd-rules='["post_shape:equal:magazine"]'>
				<span class="leftHalf ">
					<label for="<?php echo esc_attr( $this->get_field_id( 'check_element_color' ) ) ?>">
						Do you want custom color for this block elements?
					</label>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_checkbox( 'check_element_color', $block_id, (isset( $check_element_color )) ? $check_element_color : 0, array( 'data-fd-handle="check_element_color"' ) ) ?>
				</span>
			</p>
			<div class="description half last adminColorButton" data-fd-rules='["post_shape:equal:magazine", "check_element_color:equal:1"]'>
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'elements_color' ) ) ?>">
						Main Color for this block elements
					</label>
					<span class="description_text">
					</span>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_color_picker( 'elements_color', $block_id, $elements_color ) ?>
				</span>
			</div>
			<p class="description circlePostsShow" data-fd-rules='["post_shape:equal:magazine"]'>
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'magazine_style' ) ) ?>">
						<?php _e( 'Magazine style', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php echo circleflip_field_select( 'magazine_style', $block_id, array( 'magazinestyle1' => 'Magazine Style 1', 'magazinestyle2' => 'Magazine Style 2', 'magazinestyle3' => 'Magazine Style 3', 'magazinestyle4' => 'Magazine Style 4' ), isset( $magazine_style ) ? $magazine_style : 'magazinestyle1', array( 'data-fd-handle="magazine_style"' ) ) ?>
					</span>
				</span>
			</p>
			<p class="description" data-fd-rules='["post_shape:equal:magazine", "magazine_style:equal:magazinestyle1"]'>
				<img style="display: block;margin:0 auto; " src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/mag_style1.png" alt=""/>
			</p>
			<p class="description" data-fd-rules='["post_shape:equal:magazine", "magazine_style:equal:magazinestyle2"]'>
				<img style="display: block;margin:0 auto; " src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/mag_style2.png" alt=""/>
			</p>
			<p class="description" data-fd-rules='["post_shape:equal:magazine", "magazine_style:equal:magazinestyle3"]'>
				<img style="display: block;margin:0 auto; " src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/mag_style3.png" alt=""/>
			</p>
			<p class="description" data-fd-rules='["post_shape:equal:magazine", "magazine_style:equal:magazinestyle4"]'>
				<img style="display: block;margin:0 auto; " src="<?php echo get_template_directory_uri(); ?>/creiden-framework/content-builder/assets/images/mag_style4.png" alt=""/>
			</p>
			<p class="description" data-fd-rules='["post_shape:regex:circle|square"]'>
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ) ?>">
						Layout Style
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php echo circleflip_field_select( 'type', $block_id, array( 'Thirds', 'Fourths' ), isset( $type ) ? $type : 'Thirds'  ) ?>
					</span>
				</span>
			</p>
			<p class="description" data-fd-rules='["post_shape:equal:magazine"]'>
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'type_mag' ) ) ?>">
						Layout Style
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php echo circleflip_field_select( 'type_mag', $block_id, array( 'Thirds', 'Fourths', 'Half' ), isset( $type_mag ) ? $type_mag : 'Half'  ) ?>
					</span>
				</span>
			</p>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ) ?>">
						<?php _e( 'Which posts to show ?', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php echo circleflip_field_select( 'post_type', $block_id, array( 'latest' => 'Latest Posts', 'popular' => 'Popular Posts', 'selected' => 'Selected Posts' ), isset( $post_type ) ? $post_type : 'Latest Posts', array( 'data-fd-handle="post_type"' ) ) ?>
					</span>
				</span>
			</p>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'post_cat_type' ) ) ?>">
						Posts Category Type
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php
						$_post_cat_types = array( 'blog' => 'Blog' );
						if ( post_type_exists( 'circleflip-portfolio' ) ) {
							$_post_cat_types['portfolio'] = 'Portfolio';
						} else {
							$_post_cat_type = 'blog';
						}
						echo circleflip_field_select( 'post_cat_type', $block_id, $_post_cat_types, isset( $post_cat_type ) ? $post_cat_type : '', array( 'data-fd-handle="post_cat_type"' ) )
						?>
					</span>
				</span>
			</p>
			<div data-fd-rules='["post_cat_type:equal:blog"]'>
				<p class="description" data-fd-rules='["post_type:regex:latest|popular"]'>
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id( 'post_selected_cats_blog' ) ) ?>">
							Selected Categories
						</label>
					</span>
					<span class="rightHalf">
						<?php
						$options_categories = circleflip_get_categories();
						echo circleflip_field_multiselect( 'post_selected_cats_blog', $block_id, $options_categories, isset( $post_selected_cats ) ? $post_selected_cats : ''  )
						?>
					</span>
				</p>
				<p class="description" data-fd-rules='["post_type:equal:selected"]'>
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id( 'post_selected_posts_blog' ) ) ?>">
							Selected Posts
						</label>
					</span>
					<span class="rightHalf">
						<?php
						$postNames = circleflip_get_posts();
						echo circleflip_field_multiselect( 'post_selected_posts_blog', $block_id, $postNames, isset( $post_selected_posts_blog ) ? $post_selected_posts_blog : ''  )
						?>
					</span>
				</p>
			</div>
			<?php if ( post_type_exists( 'circleflip-portfolio' ) ) : ?>
				<div data-fd-rules='["post_cat_type:equal:portfolio"]'>
					<p class="description" data-fd-rules='["post_type:regex:latest|popular"]'>
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id( 'post_selected_cats_portfolio' ) ) ?>">
								Selected Categories
							</label>
						</span>
						<span class="rightHalf">
							<?php
							$options_categories = array();
							$port_cats = circleflip_get_portfolio_categories();
							if ( $port_cats ) {
								foreach ( $port_cats as $cat ) {
									$options_categories[$cat->term_id] = $cat->name;
								}
							}
							echo circleflip_field_multiselect( 'post_selected_cats_portfolio', $block_id, $options_categories, isset( $post_selected_cats_portfolio ) ? $post_selected_cats_portfolio : ''  )
							?>
						</span>
					</p>
					<p class="description" data-fd-rules='["post_type:equal:selected"]'>
						<span class="leftHalf">
							<label for="<?php echo esc_attr( $this->get_field_id( 'post_selected_posts_portfolio' ) ) ?>">
								Selected Posts
							</label>
						</span>
						<span class="rightHalf">
							<?php
							$postNames = array();
							$port_items = circleflip_get_portfolio_items();
							foreach ( $port_items as $item ) {
								$postNames[$item->ID] = $item->post_title;
							}
							echo circleflip_field_multiselect( 'post_selected_posts_portfolio', $block_id, $postNames, isset( $post_selected_posts_portfolio ) ? $post_selected_posts_portfolio : ''  )
							?>
						</span>
					</p>
				</div>
			<?php endif; ?>
			<p class="description" data-fd-rules='["post_type:regex:latest|popular"]'>
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ) ?>">
						<?php _e( 'How many posts to show ?', 'circleflip-builder' ) ?>
					</label>
					<span sclass="description_text">-1 To Get All Posts</span>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_input( 'post_number', $block_id, $post_number, $size = 'full' ) ?>
				</span>
			</p>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'reload_section' ) ) ?>">
						Reload Section
					</label>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_select( 'reload_section', $block_id, array( 'enable' => 'Enable', 'disable' => 'Disable' ), isset( $reload_section ) ? $reload_section : ''  ) ?>
				</span>
			</p>
			<p class="description half">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'entrance_animation' ) ) ?>">
						<?php _e( 'Animation', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php
						$animation_options = array(
							'default'		 => 'Default',
							'noanimation'	 => 'no animation',
							'cr_left'		 => 'Fade To Left',
							'cr_right'		 => 'Fade To Right',
							'cr_top'		 => 'Fade To Up',
							'cr_bottom'		 => 'Fade To Down',
							'cr_popup'		 => 'Popout',
							'cr_fade'		 => 'Fade in',
						);
						echo circleflip_field_select( 'entrance_animation', $block_id, $animation_options, $entrance_animation );
						?>
					</span>
					<span class="entrance_animation_sim"></span>
				</span>
			</p>
		</div>
		<?php
	}

	function block( $instance ) {
		$defaults = array(
			'title'				 => '',
			'post_number'		 => '',
			'entrance_animation' => '',
			'post_cat_type'		 => 'blog',
			'post_shape'		 => 'circle',
			'hover_style'		 => 'squarestyle1',
			'animation_number'	 => 0,
			'post_style'		 => 'circle',
			'post_type'			 => '',
			'masonry'			 => false,
		);
		$instance = wp_parse_args( $instance, $defaults );
		if ( $instance['entrance_animation'] == 'default' ) {
			$instance['entrance_animation'] = cr_get_option( 'block_animations' );
		}
		switch ( $instance['post_style'] ) {
			case 'circle':
				$this->circlePosts( $instance );
				break;
			case 'squarestyle1':
				$this->squarePosts( $instance );
				break;
			case 'squarestyle2':
				$this->squarePostsWhite( $instance );
				break;
			case 'squarestyle3':
				$this->squarePostsRed( $instance );
				break;
			case 'magazinestyle1':
				$this->magazineStyle1( $instance );
				break;
			case 'magazinestyle2':
				$this->magazineStyle2( $instance );
				break;
			case 'magazinestyle3':
				$this->magazineStyle3( $instance );
				break;
			case 'magazinestyle4':
				$this->magazineStyle4( $instance );
				break;
			default:

				break;
		}
	}

	function update( $new_instance, $old_instance ) {
		if ( $new_instance['post_shape'] == 'circle' ) {
			$new_instance['post_style'] = $new_instance['post_shape'];
		} elseif ( $new_instance['post_shape'] == 'magazine' ) {
			$new_instance['post_style'] = $new_instance['magazine_style'];
		} else {
			$new_instance['post_style'] = $new_instance['hover_style'];
		}
		//$new_instance['post_style'] = 'circle' == $new_instance['post_shape'] ? $new_instance['post_shape'] : $new_instance['hover_style'];
		$new_instance['post_order'] = 'desc';
		return parent::update( $new_instance, $old_instance );
	}

	function build_query_args( $instance ) {
		global $wpdb;
		extract( $instance );
		$args = array();
		$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();
		$post_selected_posts = isset( ${"post_selected_posts_$post_cat_type"} ) ? ${"post_selected_posts_$post_cat_type"} : array();
		$cat_key = 'blog' == $post_cat_type ? 'cat' : 'tax_query';
		if ( 'portfolio' == $post_cat_type ) {
			$tax_query = array(
				array(
					'taxonomy'	 => 'circleflip-portfolio-cats',
					'field'		 => 'id',
					'terms'		 => isset( $post_selected_cats ) ? $post_selected_cats : array(),
				),
			);
		} else {
			$tax_query = isset( $post_selected_cats ) ? implode( ',', $post_selected_cats ) : '';
		}
		switch ( $post_type ) {
			// Latest
			case 'latest':
				$args = array(
					'posts_per_page' => $post_number,
					$cat_key		 => $tax_query,
					'post_type'		 => 'blog' === $post_cat_type ? 'post' : 'circleflip-portfolio',
					'orderby'		 => 'date',
					'order'			 => 'DESC',
					'paged'			 => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
					'post_status'	 => 'publish'
				);
				break;
			// Popular
			case 'popular':
				$args = array(
					'posts_per_page' => $post_number,
					'post_type'		 => 'blog' === $post_cat_type ? 'post' : 'circleflip-portfolio',
					'orderby'		 => 'post__in',
					'post_status'	 => 'publish',
					$cat_key		 => $tax_query,
					'post__in'		 => $wpdb->get_col( "SELECT post_id, COUNT(*) as total FROM views_count WHERE 1 = 1 GROUP BY post_id ORDER BY total" ),
					'paged'			 => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
					'order'			 => 'DESC'
				);
				break;
			// Selected Posts
			case 'selected':
				if ( circleflip_valid( $post_selected_posts ) ) {
					$selectedPosts = implode( ",", $post_selected_posts );
				} else {
					$selectedPosts = '';
				}
				$post_selected_cats = '';
				$args = array(
					'post_type'	 => 'blog' === $post_cat_type ? 'post' : 'circleflip-portfolio',
					'include'	 => $selectedPosts,
					'orderby'	 => 'date',
					'paged'		 => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
					'order'		 => 'DESC'
				);
				break;
			default:
				$args = array(
					'posts_per_page' => $post_number,
					$cat_key		 => $tax_query,
					'post_type'		 => 'blog' === $post_cat_type ? 'post' : 'circleflip-portfolio',
					'orderby'		 => 'date',
					'order'			 => 'DESC',
					'paged'			 => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
					'post_status'	 => 'publish'
				);
				break;
		}
		if ( empty( $post_selected_cats ) ) {
			unset( $args[$cat_key] );
		}
		$args['suppress_filters'] = false;
		return $args;
	}

	function circle_posts_enqueue() {
		wp_register_style( 'circleposts', get_template_directory_uri() . '/css/content-builder/circleposts.css' );
		wp_enqueue_style( 'circleposts' );
		wp_register_script( 'recentJS', get_template_directory_uri() . '/scripts/modules/recent.js', array( 'jquery' ), '2.0.3', true );
		wp_enqueue_script( 'recentJS' );
		wp_register_script( 'pretty', get_template_directory_uri() . '/js/prettyPhoto.js', array( 'jquery' ), '2.0.3', true );
		wp_enqueue_script( 'pretty' );
		wp_register_style( 'prettyStyle', get_template_directory_uri() . '/css/prettyphoto/style/prettyPhoto.css' );
		wp_enqueue_style( 'prettyStyle' );
	}

	function circlePosts( $instance ) {
		extract( $instance );
		$this->circle_posts_enqueue();
		add_filter( 'circleflip_post_format_gallery_html', 'circleflip_gallery_circleformat', 10, 5 );
		add_filter( 'circleflip_post_format_standard_html', 'circleflip_standard_circleformat', 10, 5 );
		add_filter( 'circleflip_post_format_video_html', 'circleflip_video_circleformat', 10, 5 );
		add_filter( 'circleflip_post_format_audio_html', 'circleflip_audio_circleformat', 10, 5 );
		add_filter( 'circleflip_post_format_media_size', 'circleflip_full_video_size', 10, 5 );
		add_filter( 'circleflip_post_format_meta', 'circleflip_gallery_layout', 10, 5 );
		/*
		 * Latest Posts - Popular - Selected Posts
		 * Blog Posts - Portfolio
		 * with Latest or Popular (Selected Categories Multiple Select)
		 * Order -> Ascending or descending
		 * Number of Posts
		 */
		$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();

		$output = circleflip_query( $this->build_query_args( $instance ) );
		switch ( $type ) {
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
		switch ( $animation_number ) {
			case '0':
				$animation = 'animation1';
				break;
			case '1':
				$animation = 'animation2';
				break;
			case '2':
				$animation = 'animation3';
				break;
			case '3':
				$animation = 'animation4';
				break;
			default:
				$animation = 'animation1';
				break;
		}
		$titleIconClass;
		switch ( $titleIcon ) {
			case 0:
				$titleIconClass = 'withoutIcon';
				break;
			case 1:
				$titleIconClass = 'withIcon';
				break;
			default:
				$titleIconClass = 'withoutIcon';
		}
		$titleIconHead = '';
		if ( $titleIconClass == 'withIcon' ) {
			$iconHead;
			if ( ( defined( "ICL_LANGUAGE_CODE" ) && "ar" === ICL_LANGUAGE_CODE ) ) {
				$iconHead = "icon-left-open-mini";
			} else {
				$iconHead = "icon-right-open-mini";
			}
			$titleIconHead = '<div class="headerDot"><span class="' . esc_attr($iconHead) . '"></span></div>';
		}
		if ( $output ):
			?>
			<?php if ( circleflip_valid( $title ) || ($post_type != 2 && $reload_section == 'enable') ) { ?>
				<div class="CirclePosts">
					<?php if ( circleflip_valid( $title ) ) { ?>
						<div class="titleBlock">
							<h3><?php echo $titleIconHead . esc_html( $title ); ?></h3>
						</div>
					<?php } ?>
					<?php if ( $post_type != 2 && $reload_section == 'enable' ) { ?>
						<?php if ( ! circleflip_valid( $title ) ) { ?>
							<div class="titleBlock">
								<h3></h3>
							</div>
						<?php } ?>
						<a class="loadCirclePosts"
						   data-pagenumber="2"
						   data-posttype="<?php echo esc_attr($post_type) ?>"
						   data-animation="<?php echo esc_attr($animation); ?>"
						   data-layout="<?php echo esc_attr($layout); ?>"
						   data-postsnumber="<?php echo esc_attr($post_number); ?>"
						   data-cats="<?php echo isset( $post_selected_cats ) ? esc_attr(implode( ',', $post_selected_cats )) : '' ?>"
						   data-post-or-portfolio="<?php echo esc_attr($post_cat_type) ?>">
							<span class="icon-spin3"></span> </a>
					<?php } ?>
				</div>
			<?php } ?>
			<div class="circleFlip row">
				<?php
				global $post;
				foreach ( $output as $post ) : setup_postdata( $post );
					?>
					<div class="<?php echo esc_attr($layout); ?> circlePost animateCr">
						<div class="circleAnimation <?php echo esc_attr($animation) ?>">
							<?php
							$image_attributes[0] = '';
							if ( has_post_thumbnail( $post->ID ) ) {
								$image_id = get_post_thumbnail_id( $post->ID );
								$image_attributes = wp_get_attachment_image_src( $image_id, 'circle-posts' );
								echo '<div class="circleAnimationImage" data-image="' . esc_url($image_attributes[0]) . '" style="background-image: url(' . esc_url($image_attributes[0]) . ')"></div>';
								//echo '<div class="circleAnimationImage" data-image="'.$image_attributes[0].'"></div>';
							} else {
								echo '<div class="circleAnimationImage" data-image="' . esc_url($image_attributes[0]) . '" style="background-image: url(' . esc_url(cr_get_option( 'post_default', '' )) . ')"></div>';
								// echo '<div class="circleAnimationImage" data-image="'.cr_get_option('post_default','').'"></div>';
							}
							?>
							<div class="circleAnimation <?php echo esc_attr($animation) ?>">
								<?php echo circleflip_get_post_format_media( $post->ID, 'circle-posts', 'my_unique_circle_posts' ); ?>
							</div>
						</div>
					</div>

				<?php endforeach; ?>
			</div>
			<?php
		endif;
		circleflip_end_query();
	}

	function square_posts_enqueue() {
		wp_register_style( 'squareposts1', get_template_directory_uri() . '/css/content-builder/squareposts.css' );
		wp_enqueue_style( 'squareposts1' );
		wp_register_script( 'pretty', get_template_directory_uri() . '/js/prettyPhoto.js', array( 'jquery' ), '2.0.3', true );
		wp_enqueue_script( 'pretty' );
		wp_register_script( 'recentJS', get_template_directory_uri() . '/scripts/modules/recent.js', array( 'jquery' ), '2.0.3', true );
		wp_enqueue_script( 'recentJS' );
		wp_register_style( 'prettyStyle', get_template_directory_uri() . '/css/prettyphoto/style/prettyPhoto.css' );
		wp_enqueue_style( 'prettyStyle' );
		wp_enqueue_script( 'cf-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js' );
	}

	function squarePosts( $instance ) {
		extract( $instance );
		$this->square_posts_enqueue();
		add_filter( 'circleflip_post_format_gallery_html', 'circleflip_gallery_squareformat', 10, 5 );
		add_filter( 'circleflip_post_format_standard_html', 'circleflip_standard_squareformat', 10, 5 );
		add_filter( 'circleflip_post_format_video_html', 'circleflip_video_squareformat', 10, 5 );
		add_filter( 'circleflip_post_format_audio_html', 'circleflip_audio_squareformat', 10, 5 );
		add_filter( 'circleflip_post_format_media_size', 'circleflip_full_video_size', 10, 5 );
		add_filter( 'circleflip_post_format_meta', 'circleflip_gallery_layout', 10, 5 );
		/*
		 * Latest Posts - Popular - Selected Posts
		 * Blog Posts - Portfolio
		 * with Latest or Popular (Selected Categories Multiple Select)
		 * Order -> Ascending or descending
		 * Number of Posts
		 */

		$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();

		$output = circleflip_query( $this->build_query_args( $instance ) );
		switch ( $type ) {
			case '0':
				$layout = 'span4';
				$image_size = 'recent_home_posts_two';
				break;
			case '1':
				$layout = 'span3';
				$image_size = 'recent_home_posts';
				break;
			default:
				$layout = 'span4';
				$image_size = 'recent_home_posts_two';
				break;
		}
		$image_size = ! empty( $instance['masonry'] ) ? 'masonry-post' : $image_size;
		$masonry_class = ! empty( $instance['masonry'] ) ? ' cf-masonry' : '';
		$titleIconClass;
		switch ( $titleIcon ) {
			case 0:
				$titleIconClass = 'withoutIcon';
				break;
			case 1:
				$titleIconClass = 'withIcon';
				break;
			default:
				$titleIconClass = 'withoutIcon';
		}
		$titleIconHead = '';
		if ( $titleIconClass == 'withIcon' ) {
			$iconHead;
			if ( ( defined( "ICL_LANGUAGE_CODE" ) && "ar" === ICL_LANGUAGE_CODE ) ) {
				$iconHead = "icon-left-open-mini";
			} else {
				$iconHead = "icon-right-open-mini";
			}
			$titleIconHead = '<div class="headerDot"><span class="' . esc_attr($iconHead) . '"></span></div>';
		}
		if ( $output ):
			?>
			<div class="squarePostsWrapper">
				<?php if ( circleflip_valid( $title ) || ($post_type != 2 && $reload_section == "enable") ) { ?>
					<div class="portfolio titleBlock">
						<?php if ( circleflip_valid( $title ) ) { ?>
							<h3 class="alignLeft">
								<?php echo $titleIconHead . esc_html( $title ); ?>
							</h3>
						<?php } ?>
						<?php if ( $post_type != 2 && $reload_section == "enable" ) { ?>
							<?php if ( ! circleflip_valid( $title ) ) { ?>
								<h3 class="alignLeft"></h3>
							<?php } ?>
							<a class="loadRecentPosts"
							   data-pagenumber="2"
							   data-posttype="<?php echo esc_attr($post_type) ?>"
							   data-layout="<?php echo esc_attr($layout); ?>"
							   data-postsnumber="<?php echo esc_attr($post_number); ?>"
							   data-cats="<?php echo isset( $post_selected_cats ) ? esc_attr(implode( ',', $post_selected_cats )) : '' ?>"
							   data-post-or-portfolio="<?php echo esc_attr($post_cat_type) ?>">
								<span class="icon-spin3"></span> </a>
						<?php } ?>
					</div>
				<?php } ?>
				<div class="circleFlip row <?php if ( ! empty( $instance['masonry'] ) ) : ?>cf-masonry-container<?php endif; ?>">

					<?php
					global $post;
					foreach ( $output as $post ) : setup_postdata( $post );
						?>
						<div class="<?php echo esc_attr($layout . ' ' . $entrance_animation . $masonry_class); ?> squarePost animateCr">
							<?php echo circleflip_get_post_format_media( $post->ID, $image_size, 'my_unique_square_posts' ); ?>
							<?php if ( empty( $instance['masonry'] ) ): ?>
								<a href="<?php echo esc_url($post->guid); ?>"><h3 class="squarePostTitle"><?php echo esc_html($post->post_title); ?></h3></a>
								<p class="squarePostText">
									<?php
									$text = strip_tags( $post->post_content );
									echo circleflip_string_limit_characters( $text, 140 );
									?>
								</p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
		endif;
		circleflip_end_query();
	}

	function squarePostsWhite( $instance ) {
		extract( $instance );
		$this->square_white_enqueue();
		add_filter( 'circleflip_post_format_gallery_html', 'circleflip_gallery_portfolioformat', 10, 5 );
		add_filter( 'circleflip_post_format_standard_html', 'circleflip_standard_portfolioformat', 10, 5 );
		add_filter( 'circleflip_post_format_video_html', 'circleflip_video_portfolioformat', 10, 5 );
		add_filter( 'circleflip_post_format_audio_html', 'circleflip_audio_portfolioformat', 10, 5 );
		add_filter( 'circleflip_post_format_media_size', 'circleflip_full_video_size', 10, 5 );
		add_filter( 'circleflip_post_format_meta', 'circleflip_gallery_layout', 10, 5 );
		/*
		 * Latest Posts - Popular - Selected Posts
		 * Blog Posts - Portfolio
		 * with Latest or Popular (Selected Categories Multiple Select)
		 * Order -> Ascending or descending
		 * Number of Posts
		 */
		$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();
		$output = circleflip_query( $this->build_query_args( $instance ) );
		switch ( $type ) {
			case '0':
				$layout = 'span4';
				$image_size = 'recent_home_posts_two';
				break;
			case '1':
				$layout = 'span3';
				$image_size = 'recent_home_posts';
				break;
			default:
				$layout = 'span4';
				$image_size = 'recent_home_posts_two';
				break;
		}
		$image_size = ! empty( $instance['masonry'] ) ? 'masonry-post' : $image_size;
		$masonry_class = ! empty( $instance['masonry'] ) ? ' cf-masonry' : '';
		$titleIconClass;
		switch ( $titleIcon ) {
			case 0:
				$titleIconClass = 'withoutIcon';
				break;
			case 1:
				$titleIconClass = 'withIcon';
				break;
			default:
				$titleIconClass = 'withoutIcon';
		}
		$titleIconHead = '';
		if ( $titleIconClass == 'withIcon' ) {
			$iconHead;
			if ( ( defined( "ICL_LANGUAGE_CODE" ) && "ar" === ICL_LANGUAGE_CODE ) ) {
				$iconHead = "icon-left-open-mini";
			} else {
				$iconHead = "icon-right-open-mini";
			}
			$titleIconHead = '<div class="headerDot"><span class="' . esc_attr($iconHead) . '"></span></div>';
		}
		if ( $output ):
			?>
			<div class="squarePostsWhiteWrapper">
				<?php if ( circleflip_valid( $title ) || ($post_type != 2 && $reload_section == "enable") ) { ?>
					<div class="portfolio titleBlock">
						<?php if ( circleflip_valid( $title ) ) { ?>
							<h3>
								<?php echo $titleIconHead . esc_html( $title ); ?>
							</h3>
						<?php } ?>
						<?php if ( $post_type != 2 && $reload_section == "enable" ) { ?>
							<?php if ( ! circleflip_valid( $title ) ) { ?>
								<h3></h3>
							<?php } ?>
							<a class="loadPortfolioPosts"
							   data-pagenumber="2"
							   data-layout="<?php echo esc_attr($layout); ?>"
							   data-posttype="<?php echo esc_attr($post_type) ?>"
							   data-postsnumber="<?php echo esc_attr($post_number); ?>"
							   data-cats="<?php echo isset( $post_selected_cats ) ? esc_attr(implode( ',', $post_selected_cats )) : '' ?>"
							   data-post-or-portfolio="<?php echo esc_attr($post_cat_type) ?>">
								<span class="icon-spin3"></span> </a>
						<?php } ?>
					</div>
				<?php } ?>
				<div class="circleFlip row <?php if ( ! empty( $instance['masonry'] ) ) : ?>cf-masonry-container<?php endif; ?>">
					<?php
					global $post;
					foreach ( $output as $post ) : setup_postdata( $post );
						?>
						<div class="<?php echo esc_attr($layout . ' ' . $entrance_animation . $masonry_class) ?> portfolioHome animateCr">
							<div class="portfolioHomeImg">
								<?php if ( has_post_thumbnail( $post->ID ) ) { ?>
									<?php echo get_the_post_thumbnail( $post->ID, $image_size ) ?>
								<?php } else { ?>
									<?php echo circleflip_get_default_image( $image_size ) ?>
									<?php
								}
								echo circleflip_get_post_format_media( $post->ID, $image_size, 'my_unique_portfolio_posts' );
								?>
							</div>
						</div>
						<?php
					endforeach;
					echo '</div>';
					echo '</div>';
				endif;
				circleflip_end_query();
			}

			function square_white_enqueue() {
				wp_register_style( 'squareposts', get_template_directory_uri() . '/css/content-builder/squareposts.css' );
				wp_enqueue_style( 'squareposts' );
				wp_register_script( 'pretty', get_template_directory_uri() . '/js/prettyPhoto.js', array( 'jquery' ), '2.0.3', true );
				wp_enqueue_script( 'pretty' );
				wp_register_script( 'recentJS', get_template_directory_uri() . '/scripts/modules/recent.js', array( 'jquery' ), '2.0.3', true );
				wp_enqueue_script( 'recentJS' );
				wp_register_style( 'prettyStyle', get_template_directory_uri() . '/css/prettyphoto/style/prettyPhoto.css' );
				wp_enqueue_style( 'prettyStyle' );
				wp_enqueue_script( 'cf-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js' );
			}

			function squarePostsRed( $instance ) {
				extract( $instance );
				$this->square_red_enqueue();
				add_filter( 'circleflip_post_format_gallery_html', 'circleflip_gallery_squareredformat', 10, 5 );
				add_filter( 'circleflip_post_format_standard_html', 'circleflip_standard_squareredformat', 10, 5 );
				add_filter( 'circleflip_post_format_video_html', 'circleflip_video_squareredformat', 10, 5 );
				add_filter( 'circleflip_post_format_audio_html', 'circleflip_audio_squareredformat', 10, 5 );
				add_filter( 'circleflip_post_format_media_size', 'circleflip_full_video_size', 10, 5 );
				add_filter( 'circleflip_post_format_meta', 'circleflip_gallery_layout', 10, 5 );
				/*
				 * Latest Posts - Popular - Selected Posts
				 * Blog Posts - Portfolio
				 * with Latest or Popular (Selected Categories Multiple Select)
				 * Order -> Ascending or descending
				 * Number of Posts
				 */
				$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();
				$output = circleflip_query( $this->build_query_args( $instance ) );
				switch ( $type ) {
					case '0':
						$layout = 'span4';
						$image_size = 'recent_home_posts_two';
						break;
					case '1':
						$layout = 'span3';
						$image_size = 'recent_home_posts';
						break;
					default:
						$layout = 'span4';
						$image_size = 'recent_home_posts_two';
						break;
				}
				$image_size = ! empty( $instance['masonry'] ) ? 'masonry-post' : $image_size;
				$masonry_class = ! empty( $instance['masonry'] ) ? ' cf-masonry' : '';
				$titleIconClass;
				switch ( $titleIcon ) {
					case 0:
						$titleIconClass = 'withoutIcon';
						break;
					case 1:
						$titleIconClass = 'withIcon';
						break;
					default:
						$titleIconClass = 'withoutIcon';
				}
				$titleIconHead = '';
				if ( $titleIconClass == 'withIcon' ) {
					$iconHead;
					if ( ( defined( "ICL_LANGUAGE_CODE" ) && "ar" === ICL_LANGUAGE_CODE ) ) {
						$iconHead = "icon-left-open-mini";
					} else {
						$iconHead = "icon-right-open-mini";
					}
					$titleIconHead = '<div class="headerDot"><span class="' . esc_attr($iconHead) . '"></span></div>';
				}
				if ( $output ):
					?>
					<div class="squarePostsRedWrapper">
						<?php if ( circleflip_valid( $title ) || ($post_type != 2 && $reload_section == "enable") ) { ?>
							<div class="portfolio titleBlock">
								<?php if ( circleflip_valid( $title ) ) { ?>
									<h3>
										<?php echo $titleIconHead . esc_html( $title ); ?>
									</h3>
								<?php } ?>
								<?php if ( $post_type != 2 && $reload_section == "enable" ) { ?>
									<?php if ( ! circleflip_valid( $title ) ) { ?>
										<h3></h3>
									<?php } ?>
									<a class="loadSquareRedPosts"
									   data-pagenumber="2"
									   data-layout="<?php echo esc_attr($layout); ?>"
									   data-posttype="<?php echo esc_attr($post_type) ?>"
									   data-postsnumber="<?php echo esc_attr($post_number); ?>"
									   data-cats="<?php echo isset( $post_selected_cats ) ? esc_attr(implode( ',', $post_selected_cats )) : '' ?>"
									   data-post-or-portfolio="<?php echo esc_attr($post_cat_type) ?>">
										<span class="icon-spin3"></span> </a>
								<?php } ?>
							</div>
						<?php } ?>
						<div class="circleFlip row <?php if ( ! empty( $instance['masonry'] ) ) : ?>cf-masonry-container<?php endif; ?>">
							<ul class="ourHolder">
								<?php
								global $post;
								foreach ( $output as $post ) : setup_postdata( $post );
									?>
									<li class="circleflip-portfolio squarered <?php echo esc_attr($layout . ' ' . $entrance_animation . $masonry_class) ?> item animateCr">
										<?php echo circleflip_get_post_format_media( $post->ID, $image_size, 'my_unique_squarered_posts' ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
					<?php
				endif;
				circleflip_end_query();
			}

			function square_red_enqueue() {
				wp_register_style( 'portfolioStyle', get_template_directory_uri() . '/css/parts/portfolio.css' );
				wp_enqueue_style( 'portfolioStyle' );
				wp_register_script( 'recentJS', get_template_directory_uri() . '/scripts/modules/recent.js', array( 'jquery' ), '2.0.3', true );
				wp_enqueue_script( 'recentJS' );
				wp_register_script( 'pretty', get_template_directory_uri() . '/js/prettyPhoto.js', array( 'jquery' ), '2.0.3', true );
				wp_enqueue_script( 'pretty' );
				wp_register_style( 'prettyStyle', get_template_directory_uri() . '/css/prettyphoto/style/prettyPhoto.css' );
				wp_enqueue_style( 'prettyStyle' );
				wp_enqueue_script( 'cf-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js' );
			}

			function magazine_style1_enqueue() {
				wp_register_style( 'magazineStyle', get_template_directory_uri() . '/css/content-builder/magazineposts.css' );
				wp_enqueue_style( 'magazineStyle' );
			}

			function magazineStyle1( $instance ) {
				extract( $instance );
				$this->magazine_style1_enqueue();
				/*
				 * Latest Posts - Popular - Selected Posts
				 * Blog Posts - Portfolio
				 * with Latest or Popular (Selected Categories Multiple Select)
				 * Order -> Ascending or descending
				 * Number of Posts
				 */

				$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();

				$output = circleflip_query( $this->build_query_args( $instance ) );
				switch ( $type_mag ) {
					case '0':
						$layout = 'span4';
						$image_size = 'thumbnail';
						break;
					case '1':
						$layout = 'span3';
						$image_size = 'thumbnail';
						break;
					case '2':
						$layout = 'span6';
						$image_size = 'thumbnail';
					default:
						$layout = 'span6';
						$image_size = 'thumbnail';
						break;
				}
				$titleIconClass;
				switch ( $titleIcon ) {
					case 0:
						$titleIconClass = 'withoutIcon';
						break;
					case 1:
						$titleIconClass = 'withIcon';
						break;
					default:
						$titleIconClass = 'withoutIcon';
				}
				$titleIconHead = '';
				if ( $titleIconClass == 'withIcon' ) {
					$iconHead;
					if ( ( defined( "ICL_LANGUAGE_CODE" ) && "ar" === ICL_LANGUAGE_CODE ) ) {
						$iconHead = "icon-left-open-mini";
					} else {
						$iconHead = "icon-right-open-mini";
					}
					$titleIconHead = '<div class="headerDot"><span class="' . esc_attr($iconHead) . '"></span></div>';
				}
				if ( $output ):
					?>
					<div class="magazineStyle magazineStyle1">
						<?php if ( circleflip_valid( $title ) || ($post_type != 2 && $reload_section == "enable") ) { ?>
							<div class="titleBlock">
								<?php if ( circleflip_valid( $title ) ) { ?>
									<h3 class="alignLeft">
										<?php echo $titleIconHead . esc_html( $title ); ?>
									</h3>
								<?php } ?>
								<?php if ( $post_type != 2 && $reload_section == "enable" ) { ?>
									<?php if ( ! circleflip_valid( $title ) ) { ?>
										<h3 class="alignLeft"></h3>
									<?php } ?>
									<a class="loadMagazinePosts loadMagazine1Posts"
									   data-pagenumber="2"
									   data-posttype="<?php echo esc_attr($post_type) ?>"
									   data-layout="<?php echo esc_attr($layout); ?>"
									   data-postsnumber="<?php echo esc_attr($post_number); ?>"
									   data-cats="<?php echo isset( $post_selected_cats ) ? esc_attr(implode( ',', $post_selected_cats )) : '' ?>"
									   data-post-or-portfolio="<?php echo esc_attr($post_cat_type) ?>">
										<span class="icon-spin3"></span> </a>
								<?php } ?>
							</div>
						<?php } ?>
						<div class="circleFlip row">

							<?php
							global $post;
							foreach ( $output as $post ) : setup_postdata( $post );
								?>
								<div class="<?php echo esc_attr($layout . ' ' . $entrance_animation); ?> magazinePost magazinePost1 animateCr">
									<!-- Magazine post Image -->
									<div class="image">
										<?php if ( has_post_thumbnail( $post->ID ) ) { ?>
											<?php echo get_the_post_thumbnail( $post->ID, $image_size ) ?>
											<?php
										} else {
											echo circleflip_get_default_image( $image_size )
											?>
										<?php } ?>
										<div class="magazinePostDate">
											<span class="magazineDay"><?php echo get_the_date( 'd' ) ?></span>
											<span class="magazineMonth"><?php echo get_the_date( 'M' ) ?></span>
										</div>
									</div>
									<!-- Magazine post Right part -->
									<div class="magazineData">
										<!-- Magazine post title -->
										<?php
										$original_title = $post->post_title;
										$mag_post_title = circleflip_string_limit_characters( $original_title, '30' );
										?>
										<a  class="magazinePostTitle" href="<?php the_permalink(); ?>"><h4><?php echo esc_html($mag_post_title); ?></h4></a>
										<!-- Magazine post Categories -->
										<div class="magazineCategories">
											<?php
											$post_categories = wp_get_post_categories( get_the_ID() );
											$cats = array();

											for ( $i = 0; $i < count( $post_categories ) && $i < 2; $i ++ ) {//less than 2 to get only 2 categories
												$cat = get_category( $post_categories[$i] );
												$cat_name = $cat->name;
												$cat_link = get_category_link( $cat->cat_ID );
												//$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
												if ( $i != count( $post_categories ) - 1 && $i != 1 ) {
													echo ' <a href=' . esc_url($cat_link) . '><p>' . esc_html($cat_name) . ' , </p></a>';
												} else {
													echo ' <a href=' . esc_url($cat_link) . '><p>' . esc_html($cat_name) . '</p></a>';
													echo '<p>/</p>';
												}
											}
											?>
											<!-- Magazine post Author -->
											<a class="magazinePostAuthor" href="<?php echo esc_url(get_author_posts_url( $post->post_author )) ?>"><p class="color"><?php the_author_meta( 'display_name' ) ?></p></a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<?php if ( $check_element_color == 1 ) { ?>
						<style>
				<?php $id_modified = str_replace( '_', '-', $block_id ); ?>
							#<?php echo $id_modified ?> .magazinePost1 .image .magazinePostDate, 
							#<?php echo $id_modified ?> .magazinePostViews .mag_views_no, 
							#<?php echo $id_modified ?> .magazinePostComments .mag_comments_no{
								background-color: <?php echo $elements_color; ?>;
							}
							#<?php echo $id_modified ?> .magazinePostTitle h4:hover, 
							#<?php echo $id_modified ?> .magazineCategories a p:hover, 
							#<?php echo $id_modified ?> .color {
								color: <?php echo $elements_color; ?>!important;
							}
							#<?php echo $id_modified ?> .magazinePostViews .mag_views_no, 
							#<?php echo $id_modified ?> .magazinePostComments .mag_comments_no {
								border-color:  <?php echo $elements_color; ?>;
							}
						</style>
						<?php
					}
				endif;
				circleflip_end_query();
			}

			function magazine_style2_enqueue() {
				wp_register_style( 'magazineStyle', get_template_directory_uri() . '/css/content-builder/magazineposts.css' );
				wp_enqueue_style( 'magazineStyle' );
			}

			function magazineStyle2( $instance ) {
				extract( $instance );
				$this->magazine_style2_enqueue();
				/*
				 * Latest Posts - Popular - Selected Posts
				 * Blog Posts - Portfolio
				 * with Latest or Popular (Selected Categories Multiple Select)
				 * Order -> Ascending or descending
				 * Number of Posts
				 */

				$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();

				$output = circleflip_query( $this->build_query_args( $instance ) );
				switch ( $type_mag ) {
					case '0':
						$layout = 'span4';
						$image_size = 'thumbnail';
						break;
					case '1':
						$layout = 'span3';
						$image_size = 'thumbnail';
						break;
					case '2':
						$layout = 'span6';
						$image_size = 'thumbnail';
					default:
						$layout = 'span6';
						$image_size = 'thumbnail';
						break;
				}
				$titleIconClass;
				switch ( $titleIcon ) {
					case 0:
						$titleIconClass = 'withoutIcon';
						break;
					case 1:
						$titleIconClass = 'withIcon';
						break;
					default:
						$titleIconClass = 'withoutIcon';
				}
				$titleIconHead = '';
				if ( $titleIconClass == 'withIcon' ) {
					$iconHead;
					if ( ( defined( "ICL_LANGUAGE_CODE" ) && "ar" === ICL_LANGUAGE_CODE ) ) {
						$iconHead = "icon-left-open-mini";
					} else {
						$iconHead = "icon-right-open-mini";
					}
					$titleIconHead = '<div class="headerDot"><span class="' . esc_attr($iconHead) . '"></span></div>';
				}
				if ( $output ):
					?>
					<div class="magazineStyle magazineStyle2">
						<?php if ( circleflip_valid( $title ) || ($post_type != 2 && $reload_section == "enable") ) { ?>
							<div class="titleBlock">
								<?php if ( circleflip_valid( $title ) ) { ?>
									<h3 class="alignLeft">
										<?php echo $titleIconHead . esc_html( $title ); ?>
									</h3>
								<?php } ?>
								<?php if ( $post_type != 2 && $reload_section == "enable" ) { ?>
									<?php if ( ! circleflip_valid( $title ) ) { ?>
										<h3 class="alignLeft"></h3>
									<?php } ?>
									<a class="loadMagazinePosts loadMagazine2Posts"
									   data-pagenumber="2"
									   data-posttype="<?php echo esc_attr($post_type) ?>"
									   data-layout="<?php echo esc_attr($layout); ?>"
									   data-postsnumber="<?php echo esc_attr($post_number); ?>"
									   data-cats="<?php echo isset( $post_selected_cats ) ? esc_attr(implode( ',', $post_selected_cats )) : '' ?>"
									   data-post-or-portfolio="<?php echo esc_attr($post_cat_type) ?>">
										<span class="icon-spin3"></span> </a>
								<?php } ?>
							</div>
						<?php } ?>
						<div class="circleFlip row">

							<?php
							global $post;
							foreach ( $output as $post ) : setup_postdata( $post );
								?>
								<div class="<?php echo esc_attr($layout . ' ' . $entrance_animation); ?> magazinePost magazinePost2 animateCr">
									<!-- Magazine post Image -->
									<div class="image">
										<?php if ( has_post_thumbnail( $post->ID ) ) { ?>
											<?php echo get_the_post_thumbnail( $post->ID, $image_size ) ?>
											<?php
										} else {
											echo circleflip_get_default_image( $image_size )
											?>
										<?php } ?>
										<div class="magazinePostDate">
											<span class="magazineDay"><?php echo get_the_date( 'd' ) ?></span>
											<span class="magazineMonth"><?php echo get_the_date( 'M' ) ?></span>
										</div>
									</div>
									<!-- Magazine post Right part -->
									<div class="magazineData">
										<!-- Magazine post title -->
										<?php
										$original_title = $post->post_title;
										$mag_post_title = circleflip_string_limit_words( $original_title, '2' );
										?>
										<a  class="magazinePostTitle" href="<?php the_permalink(); ?>"><h4><?php echo esc_html($mag_post_title); ?></h4></a>
										<!-- Magazine post Categories -->
										<div class="magazineCategories">
											<?php
											$post_categories = wp_get_post_categories( get_the_ID() );
											$cats = array();

											for ( $i = 0; $i < count( $post_categories ) && $i < 2; $i ++ ) {//less than 2 to get only 2 categories
												$cat = get_category( $post_categories[$i] );
												$cat_name = $cat->name;
												$cat_link = get_category_link( $cat->cat_ID );
												//$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
												if ( $i != count( $post_categories ) - 1 && $i != 1 ) {
													echo ' <a href=' . esc_url($cat_link) . '><p>' . esc_html($cat_name) . ' , </p></a>';
												} else {
													echo ' <a href=' . esc_url($cat_link) . '><p>' . esc_html($cat_name) . '</p></a>';
													echo '<p>/</p>';
												}
											}
											?>
											<!-- Magazine post Author -->
											<a class="magazinePostAuthor" href="<?php echo get_author_posts_url( $post->post_author ) ?>"><p class="color"><?php the_author_meta( 'display_name' ) ?></p></a>
										</div>
										<!-- Magazine post excerpt -->
										<?php
										$original_text = sanitize_text_field( $post->post_content );
										$mag_post_text = circleflip_string_limit_characters( $original_text, 90 );
										?>
										<p class="magazinePostExcerpt"><?php echo $mag_post_text; ?></p>
										<!-- Magazine post views & comments number -->
										<div class="magazinePostViews">
											<span class="icon-eye"></span>
											<span class="mag_views_no">
												<?php
												if ( cr_get_option( "rtl", '0' ) == '1' ) {
													$standard = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" );
													$east_arabic = array( "&#1632;", "&#1633;", "&#1634;", "&#1635;", "&#1636;", "&#1637;", "&#1638;", "&#1639;", "&#1640;", "&#1641;" );
													$numOfViews = circleflip_read_number_of_views( get_the_ID() );
													$numOfViews = str_replace( $standard, $east_arabic, $numOfViews );
												} else {
													$numOfViews = circleflip_read_number_of_views( get_the_ID() );
												}
												echo esc_html($numOfViews);
												?>
											</span>
										</div>
										<div class="magazinePostComments">
											<span class="icon-comment-1"></span>
											<span class="mag_comments_no">
												<?php comments_number( '0' ); ?>
											</span>
										</div>
										<div class="magazinePostBtn">
												<!-- <a href="<?php the_permalink(); ?>"><?php _e( 'more..', 'circleflip' ) ?></a> -->
											<a href="<?php the_permalink(); ?>" class="btnStyle1 red btnSmall btnCenter">
												<span><?php _e( 'more..', 'circleflip' ) ?></span>
												<span class="btnBefore"></span>
												<span class="btnAfter"></span>

											</a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<?php if ( $check_element_color == 1 ) { ?>
						<style>
				<?php $id_modified = str_replace( '_', '-', $block_id ); ?>
							#<?php echo $id_modified ?> .magazinePost2 .image .magazinePostDate, 
							#<?php echo $id_modified ?> .magazinePostViews .mag_views_no, 
							#<?php echo $id_modified ?> .magazinePostComments .mag_comments_no, 
							#<?php echo $id_modified ?> [class*="btnStyle"].red{
								background-color: <?php echo $elements_color; ?>;
							}
							#<?php echo $id_modified ?> .magazinePostTitle h4:hover, 
							#<?php echo $id_modified ?> .magazineCategories a p:hover, 
							#<?php echo $id_modified ?> .color {
								color: <?php echo $elements_color; ?>!important;
							}
							#<?php echo $id_modified ?> .magazinePostViews .mag_views_no, 
							#<?php echo $id_modified ?> .magazinePostComments .mag_comments_no, 
							#<?php echo $id_modified ?> [class*="btnStyle"].red .btnAfter, 
							#<?php echo $id_modified ?> [class*="btnStyle"].red .btnBefore{
								border-color:  <?php echo $elements_color; ?>;
							}
						</style>
						<?php
					}
				endif;
				circleflip_end_query();
			}

			function magazine_style3_enqueue() {
				wp_register_style( 'magazineStyle', get_template_directory_uri() . '/css/content-builder/magazineposts.css' );
				wp_enqueue_style( 'magazineStyle' );
			}

			function magazineStyle3( $instance ) {
				extract( $instance );
				$this->magazine_style3_enqueue();
				/*
				 * Latest Posts - Popular - Selected Posts
				 * Blog Posts - Portfolio
				 * with Latest or Popular (Selected Categories Multiple Select)
				 * Order -> Ascending or descending
				 * Number of Posts
				 */

				$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();

				$output = circleflip_query( $this->build_query_args( $instance ) );
				switch ( $type_mag ) {
					case '0':
						$layout = 'span4';
						$image_size = 'recent_home_posts_two';
						break;
					case '1':
						$layout = 'span3';
						$image_size = 'recent_home_posts';
						break;
					case '2':
						$layout = 'span6';
						$image_size = 'magazine_half';
						break;
					default:
						$layout = 'span4';
						$image_size = 'recent_home_posts_two';
						break;
				}
				$titleIconClass;
				switch ( $titleIcon ) {
					case 0:
						$titleIconClass = 'withoutIcon';
						break;
					case 1:
						$titleIconClass = 'withIcon';
						break;
					default:
						$titleIconClass = 'withoutIcon';
				}
				$titleIconHead = '';
				if ( $titleIconClass == 'withIcon' ) {
					$iconHead;
					if ( ( defined( "ICL_LANGUAGE_CODE" ) && "ar" === ICL_LANGUAGE_CODE ) ) {
						$iconHead = "icon-left-open-mini";
					} else {
						$iconHead = "icon-right-open-mini";
					}
					$titleIconHead = '<div class="headerDot"><span class="' . esc_attr($iconHead) . '"></span></div>';
				}
				if ( $output ):
					?>
					<div class="magazineStyle magazineStyle3">
						<?php if ( circleflip_valid( $title ) || ($post_type != 2 && $reload_section == "enable") ) { ?>
							<div class="titleBlock">
								<?php if ( circleflip_valid( $title ) ) { ?>
									<h3 class="alignLeft">
										<?php echo $titleIconHead . esc_html( $title ); ?>
									</h3>
								<?php } ?>
								<?php if ( $post_type != 2 && $reload_section == "enable" ) { ?>
									<?php if ( ! circleflip_valid( $title ) ) { ?>
										<h3 class="alignLeft"></h3>
									<?php } ?>
									<a class="loadMagazinePosts loadMagazine3Posts"
									   data-pagenumber="2"
									   data-posttype="<?php echo esc_attr($post_type) ?>"
									   data-layout="<?php echo esc_attr($layout); ?>"
									   data-postsnumber="<?php echo esc_attr($post_number); ?>"
									   data-cats="<?php echo isset( $post_selected_cats ) ? esc_attr(implode( ',', $post_selected_cats )) : '' ?>"
									   data-post-or-portfolio="<?php echo esc_html($post_cat_type) ?>">
										<span class="icon-spin3"></span> </a>
								<?php } ?>
							</div>
						<?php } ?>
						<div class="circleFlip row">

							<?php
							global $post;
							foreach ( $output as $post ) : setup_postdata( $post );
								?>
								<div class="<?php echo esc_attr($layout . ' ' . $entrance_animation); ?> magazinePost magazinePost3 animateCr">
									<!-- Magazine post Image -->
									<div class="image">
										<?php if ( has_post_thumbnail( $post->ID ) ) { ?>
											<?php echo get_the_post_thumbnail( $post->ID, $image_size ) ?>
											<?php
										} else {
											echo circleflip_get_default_image( $image_size )
											?>
										<?php } ?>

									</div>
									<!-- Magazine post Right part -->
									<div class="magazineData">
										<!-- Magazine post Categories -->
										<div class="magazineCategories">
											<?php
											$post_categories = wp_get_post_categories( get_the_ID() );
											$cats = array();
											for ( $i = 0; $i < count( $post_categories ); $i ++ ) {
												$cat = get_category( $post_categories[$i] );
												$cat_name = $cat->name;
												$cat_link = get_category_link( $cat->cat_ID );
												//$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
												if ( $i != count( $post_categories ) - 1 ) {
													echo ' <a href=' . esc_url($cat_link) . '><p>' . esc_html($cat_name) . ' , </p></a>';
												} else {
													echo ' <a href=' . esc_url($cat_link) . '><p>' . esc_html($cat_name) . '</p></a>';
												}
											}
											?>
										</div>
										<!-- Magazine post title -->
										<?php
										$original_title = $post->post_title;
										$mag_post_title = circleflip_string_limit_characters( $original_title, '45' );
										?>
										<a  class="magazinePostTitle" href="<?php the_permalink(); ?>"><h4><?php echo $mag_post_title; ?></h4></a>
										<!-- Magazine post Date -->
										<div class="magazinePostDate">
											<span><?php echo get_the_date( 'd M Y' ) ?> </span>
											<p> /</p>
											<!-- Magazine post Author -->
											<a class="magazinePostAuthor" href="<?php echo esc_url(get_author_posts_url( $post->post_author )) ?>"><p><?php the_author_meta( 'display_name' ) ?></p></a>
										</div>
										<!-- Magazine post excerpt -->
										<?php
										$original_text = sanitize_text_field( $post->post_content );
										$mag_post_text = circleflip_string_limit_characters( $original_text, '125' );
										?>
										<p class="magazinePostExcerpt"><?php echo esc_html($mag_post_text); ?></p>
										<!-- Magazine post views & comments number -->
										<div class="magazinePostViews">
											<span class="icon-eye"></span>
											<span class="mag_views_no">
												<?php
												if ( cr_get_option( "rtl", '0' ) == '1' ) {
													$standard = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" );
													$east_arabic = array( "&#1632;", "&#1633;", "&#1634;", "&#1635;", "&#1636;", "&#1637;", "&#1638;", "&#1639;", "&#1640;", "&#1641;" );
													$numOfViews = circleflip_read_number_of_views( get_the_ID() );
													$numOfViews = str_replace( $standard, $east_arabic, $numOfViews );
												} else {
													$numOfViews = circleflip_read_number_of_views( get_the_ID() );
												}
												echo esc_html($numOfViews);
												?>
											</span>
										</div>
										<div class="magazinePostComments">
											<span class="icon-comment-1"></span>
											<span class="mag_comments_no">
												<?php comments_number( '0' ); ?>
											</span>
										</div>
										<div class="magazinePostBtn">
												<!-- <a href="<?php the_permalink(); ?>"><?php _e( 'more..', 'circleflip' ) ?></a> -->
											<a href="<?php the_permalink(); ?>" class="">
												<span><?php _e( 'Read More..', 'circleflip' ) ?></span>
											</a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<?php if ( $check_element_color == 1 ) { ?>
						<style>
				<?php $id_modified = str_replace( '_', '-', $block_id ); ?>
							#<?php echo $id_modified ?> .magazinePost3 .image .magazinePostDate, 
							#<?php echo $id_modified ?> .magazinePostViews .mag_views_no, 
							#<?php echo $id_modified ?> .magazinePostComments .mag_comments_no, 
							#<?php echo $id_modified ?> [class*="btnStyle"].red{
								background-color: <?php echo $elements_color; ?>;
							}
							#<?php echo $id_modified ?> .magazinePostTitle h4:hover, 
							#<?php echo $id_modified ?> .magazineCategories a p:hover, 
							#<?php echo $id_modified ?> .color, 
							#<?php echo $id_modified ?> .magazinePost3 .magazinePostBtn a:hover, 
							#<?php echo $id_modified ?> .magazinePost3 .magazinePostAuthor p:hover{
								color: <?php echo $elements_color; ?>!important;
							}
							#<?php echo $id_modified ?> .magazinePostViews .mag_views_no, 
							#<?php echo $id_modified ?> .magazinePostComments .mag_comments_no, 
							#<?php echo $id_modified ?> .magazinePost3 .magazinePostBtn a:hover{
								border-color:  <?php echo $elements_color; ?>;
							}
						</style>
						<?php
					}
				endif;
				circleflip_end_query();
			}

			function magazine_style4_enqueue() {
				wp_register_style( 'magazineStyle', get_template_directory_uri() . '/css/content-builder/magazineposts.css' );
				wp_enqueue_style( 'magazineStyle' );
			}

			function magazineStyle4( $instance ) {
				extract( $instance );
				$this->magazine_style4_enqueue();
				/*
				 * Latest Posts - Popular - Selected Posts
				 * Blog Posts - Portfolio
				 * with Latest or Popular (Selected Categories Multiple Select)
				 * Order -> Ascending or descending
				 * Number of Posts
				 */

				$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();

				$output = circleflip_query( $this->build_query_args( $instance ) );
				switch ( $type_mag ) {
					case '0':
						$layout = 'span4';
						$image_size = 'recent_home_posts_two';
						break;
					case '1':
						$layout = 'span3';
						$image_size = 'recent_home_posts';
						break;
					case '2':
						$layout = 'span6';
						$image_size = 'magazine_half';
						break;
					default:
						$layout = 'span4';
						$image_size = 'recent_home_posts_two';
						break;
				}
				$titleIconClass;
				switch ( $titleIcon ) {
					case 0:
						$titleIconClass = 'withoutIcon';
						break;
					case 1:
						$titleIconClass = 'withIcon';
						break;
					default:
						$titleIconClass = 'withoutIcon';
				}
				$titleIconHead = '';
				if ( $titleIconClass == 'withIcon' ) {
					$iconHead;
					if ( ( defined( "ICL_LANGUAGE_CODE" ) && "ar" === ICL_LANGUAGE_CODE ) ) {
						$iconHead = "icon-left-open-mini";
					} else {
						$iconHead = "icon-right-open-mini";
					}
					$titleIconHead = '<div class="headerDot"><span class="' . esc_attr($iconHead) . '"></span></div>';
				}
				if ( $output ):
					?>
					<div class="magazineStyle magazineStyle4">
						<?php if ( circleflip_valid( $title ) || ($post_type != 2 && $reload_section == "enable") ) { ?>
							<div class="titleBlock">
								<?php if ( circleflip_valid( $title ) ) { ?>
									<h3 class="alignLeft">
										<?php echo $titleIconHead . esc_html( $title ); ?>
									</h3>
								<?php } ?>
								<?php if ( $post_type != 2 && $reload_section == "enable" ) { ?>
									<?php if ( ! circleflip_valid( $title ) ) { ?>
										<h3 class="alignLeft"></h3>
									<?php } ?>
									<a class="loadMagazinePosts loadMagazine4Posts"
									   data-pagenumber="2"
									   data-posttype="<?php echo esc_attr($post_type) ?>"
									   data-layout="<?php echo esc_attr($layout); ?>"
									   data-postsnumber="<?php echo esc_attr($post_number); ?>"
									   data-cats="<?php echo isset( $post_selected_cats ) ? esc_attr(implode( ',', $post_selected_cats )) : '' ?>"
									   data-post-or-portfolio="<?php echo esc_attr($post_cat_type) ?>">
										<span class="icon-spin3"></span> </a>
								<?php } ?>
							</div>
						<?php } ?>
						<div class="circleFlip row">

							<?php
							global $post;
							foreach ( $output as $post ) : setup_postdata( $post );
								?>
								<div class="<?php echo esc_attr($layout . ' ' . $entrance_animation); ?> magazinePost magazinePost4 animateCr">
									<!-- Magazine post Image -->
									<div class="image">
										<?php if ( has_post_thumbnail( $post->ID ) ) { ?>
											<?php echo get_the_post_thumbnail( $post->ID, $image_size ) ?>
											<?php
										} else {
											echo circleflip_get_default_image( $image_size )
											?>
										<?php } ?>

									</div>
									<!-- Magazine post Right part -->
									<div class="magazineData">
										<!-- Magazine post Author -->
										<div class="magazinePostAuthor">
											<?php echo get_avatar( $post->post_author ); ?>
											<a href="<?php echo esc_url(get_author_posts_url( $post->post_author )) ?>"><p><?php the_author_meta( 'display_name' ) ?> </p></a>
										</div>
										<!-- Magazine post Date -->
										<div class="magazinePostDate">
											<p> /</p>
											<span><?php echo get_the_date( 'd M Y' ) ?></span>
										</div>
										<!-- Magazine post title -->
										<?php
										$original_title = $post->post_title;
										$mag_post_title = circleflip_string_limit_characters( $original_title, '45' );
										?>
										<a  class="magazinePostTitle" href="<?php the_permalink(); ?>"><h4><?php echo esc_html($mag_post_title); ?></h4></a>
										<!-- Magazine post Categories -->
										<div class="magazineCategories">
											<?php
											$post_categories = wp_get_post_categories( get_the_ID() );
											$cats = array();
											for ( $i = 0; $i < count( $post_categories ); $i ++ ) {
												$cat = get_category( $post_categories[$i] );
												$cat_name = $cat->name;
												$cat_link = get_category_link( $cat->cat_ID );
												//$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
												if ( $i != count( $post_categories ) - 1 ) {
													echo ' <a href=' . esc_url($cat_link) . '><p>' . esc_html($cat_name) . ' , </p></a>';
												} else {
													echo ' <a href=' . esc_url($cat_link) . '><p>' . esc_html($cat_name) . '</p></a>';
												}
											}
											?>
										</div>
										<!-- Magazine post excerpt -->
										<?php
										$original_text = sanitize_text_field( $post->post_content );
										$mag_post_text = circleflip_string_limit_characters( $original_text, '125' );
										?>
										<p class="magazinePostExcerpt"><?php echo $mag_post_text; ?></p>
										<!-- Magazine post views & comments number -->
										<div class="magazinePostViews">
											<span class="icon-eye"></span>
											<span class="mag_views_no">
												<?php
												if ( cr_get_option( "rtl", '0' ) == '1' ) {
													$standard = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" );
													$east_arabic = array( "&#1632;", "&#1633;", "&#1634;", "&#1635;", "&#1636;", "&#1637;", "&#1638;", "&#1639;", "&#1640;", "&#1641;" );
													$numOfViews = circleflip_read_number_of_views( get_the_ID() );
													$numOfViews = str_replace( $standard, $east_arabic, $numOfViews );
												} else {
													$numOfViews = circleflip_read_number_of_views( get_the_ID() );
												}
												echo esc_html($numOfViews);
												?>
											</span>
										</div>
										<div class="magazinePostComments">
											<span class="icon-comment-1"></span>
											<span class="mag_comments_no">
												<?php comments_number( '0' ); ?>
											</span>
										</div>
										<div class="magazinePostBtn">
												<!-- <a href="<?php the_permalink(); ?>"><?php _e( 'more..', 'circleflip' ) ?></a> -->
											<a href="<?php the_permalink(); ?>" class="">
												<span><?php _e( 'Read More..', 'circleflip' ) ?></span>
											</a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<?php if ( $check_element_color == 1 ) { ?>
						<style>
				<?php $id_modified = str_replace( '_', '-', $block_id ); ?>
							#<?php echo $id_modified ?> .magazinePost4 .image .magazinePostDate, 
							#<?php echo $id_modified ?> .magazinePostViews .mag_views_no, 
							#<?php echo $id_modified ?> .magazinePostComments .mag_comments_no, 
							#<?php echo $id_modified ?> [class*="btnStyle"].red{
								background-color: <?php echo $elements_color; ?>;
							}
							#<?php echo $id_modified ?> .magazinePostTitle h4:hover, 
							#<?php echo $id_modified ?> .color, 
							#<?php echo $id_modified ?> .magazinePost4 .magazinePostBtn a:hover, 
							#<?php echo $id_modified ?> .magazinePost4 .magazinePostAuthor p:hover, 
							#<?php echo $id_modified ?> .magazinePost4 .magazineCategories p{
								color: <?php echo $elements_color; ?>!important;
							}
							#<?php echo $id_modified ?> .magazinePostViews .mag_views_no, 
							#<?php echo $id_modified ?> .magazinePostComments .mag_comments_no, 
							#<?php echo $id_modified ?> .magazinePost4 .magazinePostBtn a:hover{
								border-color:  <?php echo $elements_color; ?>;
							}
						</style>
						<?php
					}
				endif;
				circleflip_end_query();
			}

		}
		