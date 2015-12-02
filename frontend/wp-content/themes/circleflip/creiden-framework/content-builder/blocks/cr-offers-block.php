<?php

/** A simple text block * */
class CR_Offers_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image'		 => 'posts.png',
			'name'		 => 'Offers',
			'size'		 => 'span6',
			'tab'		 => 'Content',
			'imagedesc'	 => 'post.jpg',
			'desc'		 => 'A section of blog posts, customized to your specifications.'
		);
		//create the block

		parent::__construct( 'CR_Offers_Block', $block_options );
	}

	function form( $instance ) {
		$defaults = array(
			'title'					 => '',
			'post_number'			 => '',
			'entrance_animation'	 => '',
			'post_cat_type'			 => 'offer',
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
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ) ?>">
						<?php _e( 'Which posts to show ?', 'circleflip-builder' ) ?>
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php echo circleflip_field_select( 'post_type', $block_id, array( 'latest' => 'Latest Posts', 'selected' => 'Selected Posts' ), isset( $post_type ) ? $post_type : 'Latest Posts', array( 'data-fd-handle="post_type"' ) ) ?>
					</span>
				</span>
			</p>
			<?php if ( post_type_exists( 'circleflip-offer' ) ) : ?>
				<p class="description" data-fd-rules='["post_type:regex:latest|popular"]'>
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id( 'post_selected_cats_offer' ) ) ?>">
							Selected Categories
						</label>
					</span>
					<span class="rightHalf">
						<?php
						$options_categories = array();
						$port_cats = circleflip_get_offer_categories();
						if ( $port_cats ) {
							foreach ( $port_cats as $cat ) {
								$options_categories[$cat->term_id] = $cat->name;
							}
						}

						echo circleflip_field_multiselect( 'post_selected_cats_offer', $block_id, $options_categories, isset( $post_selected_cats_offer ) ? $post_selected_cats_offer : ''  )
						?>
					</span>
				</p>
				<p class="description" data-fd-rules='["post_type:equal:selected"]'>
					<span class="leftHalf">
						<label for="<?php echo esc_attr( $this->get_field_id( 'post_selected_posts_offer' ) ) ?>">
							Selected Posts
						</label>
					</span>
					<span class="rightHalf">
						<?php
						$postNames = array();
						$port_items = circleflip_get_offer_items();
						foreach ( $port_items as $item ) {
							$postNames[$item->ID] = $item->post_title;
						}
						echo circleflip_field_multiselect( 'post_selected_posts_offer', $block_id, $postNames, isset( $post_selected_posts_offer ) ? $post_selected_posts_offer : ''  )
						?>
					</span>
				</p>
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
			'post_cat_type'		 => 'offer',
			'post_shape'		 => 'circle',
			'hover_style'		 => 'squarestyle1',
			'animation_number'	 => 0,
			'post_style'		 => 'circle',
			'post_type'			 => '',
			'masonry'			 => false,
			'type'				 => 'Thirds'
		);

		$post_cat_type = 'offer';

		$instance = wp_parse_args( $instance, $defaults );
		if ( $instance['entrance_animation'] == 'default' ) {
			$instance['entrance_animation'] = cr_get_option( 'block_animations' );
		}

		$this->offerPosts( $instance );
	}

	function offer_posts_enqueue() {
		wp_register_style( 'offers', get_template_directory_uri() . '/css/content-builder/offers.css' );
		wp_enqueue_style( 'offers' );
	}

	function offerPosts( $instance ) {
		extract( $instance );
		$this->offer_posts_enqueue();
		$offers = circleflip_query( $this->build_query_args( $instance ) );

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
		?>
		<div class="circleFlip row">
			<!-- Single Offer to repeat -->
			<?php foreach ( $offers as $offer ) : $offer_meta = get_post_meta( $offer->ID, 'cflip_offer_meta' ) ? get_post_meta( $offer->ID, 'cflip_offer_meta', true ) : ""; ?>
				<div class="<?php echo esc_attr($layout) ?>">
					<div class="offerPost">
						<?php echo get_the_post_thumbnail( $offer->ID, 'team_member' ); ?>
						<div class="offerPostContent">
							<a href="<?php echo esc_url(get_the_permalink( $offer->ID )) ?>"><h3 class="offers-title-text"><?php echo esc_html($offer->post_title); ?></h3></a>
							<div>
								<?php if ( $offer_meta['startDate'] & $offer_meta['endDate'] ) { ?>
									<div class="offerDate clearfix">
										<span class="icon-calendar"></span>
										<p><?php
											echo date( 'd M', strtotime( $offer_meta['startDate'] ) ) . ' - ';
											echo date( 'd M', strtotime( $offer_meta['endDate'] ) );
											?></p>
									</div>
								<?php } if ( $offer_meta['person'] ) { ?>
									<div class="offerUsers clearfix">
										<span class="icon-users"></span>
										<p><?php echo esc_html($offer_meta['person']); ?></p>
									</div>
								<?php } ?>
							</div>
							<div class="clearfix offerPostLastRow">
								<div class="offerPrice"><?php echo esc_html($offer_meta['price']); ?></div>
								<div class="offerLink">
									<a href="<?php echo esc_url(get_the_permalink( $offer->ID )) ?>">View Details</a>
								</div>
							</div>						
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		if ( $new_instance['post_shape'] == 'circle' ) {
			$new_instance['post_style'] = $new_instance['post_shape'];
		} elseif ( $new_instance['post_shape'] == 'magazine' ) {
			$new_instance['post_style'] = $new_instance['magazine_style'];
		} else {
			$new_instance['post_style'] = $new_instance['hover_style'];
		}
		$new_instance['post_order'] = 'desc';
		return parent::update( $new_instance, $old_instance );
	}

	function build_query_args( $instance ) {
		global $wpdb;
		extract( $instance );
		$args = array();
		$post_selected_cats = isset( ${"post_selected_cats_$post_cat_type"} ) ? ${"post_selected_cats_$post_cat_type"} : array();
		$post_selected_posts = isset( ${"post_selected_posts_$post_cat_type"} ) ? ${"post_selected_posts_$post_cat_type"} : array();
		$cat_key = 'tax_query';
		$tax_query = array(
			array(
				'taxonomy'	 => 'circleflip-offer-category',
				'field'		 => 'id',
				'terms'		 => isset( $post_selected_cats ) ? $post_selected_cats : array(),
			),
		);
		switch ( $post_type ) {
			// Latest
			case 'latest':
				$args = array(
					'posts_per_page' => $post_number,
					$cat_key		 => $tax_query,
					'post_type'		 => 'circleflip-offer',
					'orderby'		 => 'date',
					'order'			 => 'DESC',
					'paged'			 => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
					'post_status'	 => 'publish'
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
					'post_type'	 => 'circleflip-offer',
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
					'post_type'		 => 'circleflip-offer',
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

}
