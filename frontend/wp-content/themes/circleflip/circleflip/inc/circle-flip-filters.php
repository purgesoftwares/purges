<?php
function circleflip_navbar_classes($classes) {
	switch (cr_get_option('header_style')) {
		case 'style1':
				$classes[] = 'right';
			break;
		case 'style2':
				$classes[] = 'right';
			break;
		case 'style3':
			if(cr_get_option('top_left_area_settings') == 'main_navigation') {
				$classes[] = 'left';
			} else if(cr_get_option('top_left_area_settings') == 'header_menu') {
				$classes[] = 'left';
			}
			else {
				$classes[] = 'right';
			}
			break;
		case 'style4':
				if(cr_get_option('top_left_area_settings') == 'main_navigation') {
					$classes[] = 'left';
				} else if(cr_get_option('top_left_area_settings') == 'header_menu') {
					$classes[] = 'left';
				}
				else {
					$classes[] = 'right';
				}
			break;
		default:

			break;
	}
	return $classes;
}
add_filter('circleflip_navbar_classes','circleflip_navbar_classes', 10, 1);

function circleflip_navbar_classes_main($classes) {
	switch (cr_get_option('header_style')) {
		case 'style1':
				$classes[] = 'right';
			break;
		case 'style2':
				$classes[] = 'right';
			break;
		case 'style3':
				$classes[] = 'right';
			break;
		case 'style4':
				$classes[] = 'right';
			break;
		default:
				$classes[] = 'right';
			break;
	}
	return $classes;
}
add_filter('circleflip_navbar_classes_main','circleflip_navbar_classes_main', 10, 1);
	function circleflip_full_video_size( $size_info, $format_slug, $post_id, $size, $ident ) {
		if ( 'video' == $format_slug && 'my_unique_square_posts' == $ident) {
				$size_info['width'] = 640;
				$size_info['height'] = 360;
		}
		else if ( 'video' == $format_slug && 'my_unique_circle_posts' == $ident) {
			$size_info['width'] = 640;
			$size_info['height'] = 360;
		}
		else if ( 'video' == $format_slug && 'my_unique_portfolio_posts' == $ident) {
			$size_info['width'] = 640;
			$size_info['height'] = 360;
		}
		else if ( 'video' == $format_slug && 'my_unique_squarered_posts' == $ident) {
			$size_info['width'] = 640;
			$size_info['height'] = 360;
		}
		else if ( 'video' == $format_slug && 'my_unique_masonary_posts' == $ident) {
			$size_info['width'] = 640;
			$size_info['height'] = 360;
		}
		return $size_info;
	}
	function circleflip_gallery_layout($meta,$format_slug,$post_id,$size,$ident) {
		if ( 'my_unique_square_posts' == $ident && 'gallery' == $format_slug) {
			$meta['gallery_layout'] = 'layout4';
		}
		else if ( 'my_unique_circle_posts' == $ident && 'gallery' == $format_slug) {
				$meta['gallery_layout'] = 'layout4';
		}
		else if ( 'my_unique_portfolio_posts' == $ident && 'gallery' == $format_slug) {
				$meta['gallery_layout'] = 'layout4';
		}
		else if ( 'my_unique_squarered_posts' == $ident && 'gallery' == $format_slug) {
				$meta['gallery_layout'] = 'layout4';
		}
		else if ( 'my_unique_masonary_posts' == $ident && 'gallery' == $format_slug) {
				$meta['gallery_layout'] = 'layout4';
		}
		return $meta;
	}
	function circleflip_standard_squareformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		if ( 'my_unique_square_posts' == $ident ) {
			$src = '';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_full[0];
			}
			ob_start();
			?>
			<div class="squarePostImg">
				<div class="squarePostCont">
					<div class="squareAlignMid">
						<div class="squareAlignMid2">
							<div class="linkZoomCont">
								<?php if(circleflip_valid($src)) { ?>
									<a href="<?php echo esc_url($src) ?>" class="zoomRecent" rel="prettyPhoto"></a>
								<?php }?>
								<a href="<?php echo get_permalink( $post_id ) ?>" class="linkRecent"></a>
							</div>
						</div>
					</div>
				</div>
				<?php if(circleflip_valid($src)) { ?>
					<?php echo wp_get_attachment_image( $image_id, $size) ?>
				<?php } else { ?>
					<?php echo circleflip_get_default_image($size) ?>
				<?php }
			$media_html = ob_get_clean() . '</div>';
		}
		return $media_html;
	}
	function circleflip_video_squareformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		if ( 'my_unique_square_posts' == $ident ) {
			$src = '';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_full[0];
			}
			ob_start();
			?>
			<div class="squarePostImg">

				<div class="squarePostCont">
					<div class="squareAlignMid">
						<div class="squareAlignMid2">
							<div class="linkZoomCont">
								<?php $unique_var = uniqid() . mt_rand(); ?>
								<a href="#<?php echo esc_attr($post_id . '-' . $unique_var) ?>" rel="prettyPhoto" class="zoomRecent icon-play"></a>
								<a href="<?php echo get_permalink( $post_id ) ?>" class="linkRecent"></a>
							</div>
						</div>
					</div>
				</div>
				<?php if(circleflip_valid($src)) { ?>
					<?php echo wp_get_attachment_image( $image_id, $size) ?>
				<?php } else { ?>
					<?php echo circleflip_get_default_image($size) ?>
				<?php } ?>
				<div id="<?php echo esc_attr($post_id . '-' . $unique_var) ?>" class="hide">
					<div>
						<?php echo $media_html ?>
					 </div>
				</div>
			<?php
			$media_html = ob_get_clean(). '</div>';
		}
		return  $media_html;
	}
	function circleflip_audio_squareformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		if ( 'my_unique_square_posts' == $ident ) {
			$src = '';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_full[0];
			}
			ob_start();
			?>
			<div class="squarePostImg">

				<div class="squarePostCont">
					<div class="squareAlignMid">
						<div class="squareAlignMid2">
							<div class="linkZoomCont">
								<?php $unique_var = uniqid() . mt_rand(); ?>
								<a href="#<?php echo esc_attr($post_id . '-' . $unique_var) ?>" rel="prettyPhoto" class="zoomRecent icon-note-beamed"></a>
								<a href="<?php echo get_permalink( $post_id ) ?>" class="linkRecent"></a>
							</div>
						</div>
					</div>
				</div>
				<?php if(circleflip_valid($src)) { ?>
					<?php echo wp_get_attachment_image( $image_id, $size) ?>
				<?php } else { ?>
					<?php echo circleflip_get_default_image($size) ?>
				<?php } ?>
				<div id="<?php echo esc_attr($post_id . '-' . $unique_var) ?>" class="hide">
					<div>
						<?php echo $media_html ?>
					</div>
				</div>
			<?php
			$media_html = ob_get_clean(). '</div>';
		}
		return  $media_html;
	}
	function circleflip_gallery_squareformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		if ( 'my_unique_square_posts' == $ident ) {
			$src = '';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_full[0];
			}
			$meta = get_post_meta( $post_id, '_circleflip_post_formats', true);
			$gallery_ids = isset($meta['gallery']) ? $meta['gallery'] : array();//get all the gallery images ids
			$first_image_full = wp_get_attachment_image_src( $gallery_ids[0], 'full');//Get First image of gallery
			$first_image_full = $first_image_full[0];
			ob_start();
			?>
			<div class="squarePostImg squarePostGallery">
			<div class="squarePostCont">
				<div class="squareAlignMid">
					<div class="squareAlignMid2">
						<div class="linkZoomCont">
								<?php $unique_var = uniqid() . mt_rand(); ?>
							<a href="<?php echo esc_url($first_image_full);?>" rel="prettyPhoto[pp_gal_<?php echo esc_attr($post_id.'-'.$unique_var) ;?>]" class="zoomRecent icon-picture"></a>
							<a href="<?php echo get_permalink( $post_id ) ?>" class="linkRecent"></a>
						</div>
					</div>
				</div>
			</div>
			<?php if(circleflip_valid($src)) { ?>
				<?php echo wp_get_attachment_image( $image_id, $size) ?>
			<?php } else { ?>
				<?php echo circleflip_get_default_image($size) ?>
			<?php } ?>

			<div id="<?php echo esc_attr($post_id.'-'.$unique_var) ?>" class="hide">
				<div>
					<?php //echo $media_html ?>
					<?php  
						foreach ($gallery_ids as $key => $value) {
							if($key!=0){
								$image_pretty_full = wp_get_attachment_image_src( $value, 'full' );
								$image_pretty_full = $image_pretty_full[0];
								echo '<a href="'.esc_url($image_pretty_full).'" rel="prettyPhoto[pp_gal_'.esc_attr($post_id.'-'.$unique_var).']"></a>';
							}
						};
					?>
				 </div>
			</div>
			<?php
			$media_html = ob_get_clean(). '</div>';
		}
		return  $media_html;
	}

	function circleflip_standard_circleformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
			$post = get_post($post_id);
			if ( 'my_unique_circle_posts' == $ident ) {
				$src = '';
				if ( has_post_thumbnail( $post_id ) ) {
					$image_id = get_post_thumbnail_id( $post_id );
					$image_full = wp_get_attachment_image_src( $image_id, 'full' );
					$src = $image_full[0];
				}
				ob_start();
				?>
				<div class="circleAnimationArea animationContainer">
					<div class="circleAnimationSingle animationWrap">
							<?php
								if (has_post_thumbnail($post->ID)) {
									$image_id = get_post_thumbnail_id($post->ID);
									$image_attributes = wp_get_attachment_image_src($image_id,'circle-posts');
									$image_full = wp_get_attachment_image_src( $image_id, 'full' );
									$src = $image_full[0];
							 		echo '<div class="circleAnimationImage front" style="background-image: url('.$image_attributes[0].')"></div>';
								} else {
									echo '<div class="circleAnimationImage" style="background-image: url('.cr_get_option('post_default','').')"></div>';
								}
							?>
						<div class="circleAnimationDetails back circlePostDetails">
							<div class="circleDetailsWrapper">
								<a href="<?php echo esc_url($src) ?>" class="zoomRecent zoomCircle" rel="prettyPhoto"></a>
								<a href="<?php echo get_permalink( $post->ID ) ?>" class="circlePostTitle"><h4><?php echo get_the_title( $post->ID ) ?></h4></a>
								<p>
									 by <a href="<?php echo get_author_posts_url($post -> post_author); ?>" class="circlePostAuthor"><?php the_author_meta('display_name', $post -> post_author);?></a>
								</p>
								<?php
									if(circleflip_valid($src)) {
								?>
								<?php
									}
								 ?>
							</div>
						</div>
					</div>
				</div>
				<?php
				$media_html = ob_get_clean();
			}
			return  $media_html;
		}
	function circleflip_video_circleformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
			$post = get_post($post_id);
			if ( 'my_unique_circle_posts' == $ident ) {
				$src = '';
				if ( has_post_thumbnail( $post_id ) ) {
					$image_id = get_post_thumbnail_id( $post_id );
					$image_full = wp_get_attachment_image_src( $image_id, 'full' );
					$src = $image_full[0];
				}
				ob_start();
				?>
				<div class="circleAnimationArea animationContainer">
					<div class="circleAnimationSingle animationWrap">
						<!-- <div class="circleAnimationImage front"> -->
							<?php
								if (has_post_thumbnail($post->ID)) {
									$image_id = get_post_thumbnail_id($post->ID);
									$image_attributes = wp_get_attachment_image_src($image_id,'circle-posts');
							 		 echo '<div class="circleAnimationImage front" style="background-image: url('.$image_attributes[0].')"></div>';
									//echo '<div class="circleAnimationImage" data-image="'.$image_attributes[0].'" style="background: url('.get_template_directory_uri().'/img/common/preloader.gif'.') no-repeat 50px 50px"></div>';
								} else {
									 echo '<div class="circleAnimationImage" style="background-image: url('.cr_get_option('post_default','').')"></div>';
									//echo '<div class="circleAnimationImage" data-image="'.cr_get_option('post_default','').'" style="background: url('.get_template_directory_uri().'/img/common/preloader.gif'.') no-repeat 50px 50px"></div>';
								}
							?>
						<!-- </div> -->
						<div class="circleAnimationDetails back circlePostDetails">
							<div class="circleDetailsWrapper">
								<?php $unique_var = uniqid() . mt_rand(); ?>
								<a href="#post-<?php echo esc_attr($post_id . '-' . $unique_var) ?>" rel="prettyPhoto" class="zoomRecent zoomCircle icon-play"></a>
								<a href="<?php echo get_permalink( $post->ID ) ?>" class="circlePostTitle"><h4><?php echo get_the_title( $post->ID ) ?></h4></a>
								<p>
									by <a href="<?php echo get_author_posts_url($post -> post_author); ?>" class="circlePostAuthor"><?php the_author_meta('display_name', $post -> post_author);?></a>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div id="post-<?php echo esc_attr($post_id . '-' . $unique_var) ?>" class="hide">
					<div>
						<?php echo $media_html ?>
					 </div>
				</div>
				<?php
				$media_html = ob_get_clean();
			}
			return  $media_html;
		}
	function circleflip_audio_circleformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
			$post = get_post($post_id);
			if ( 'my_unique_circle_posts' == $ident ) {
				$src = '';
				if ( has_post_thumbnail( $post_id ) ) {
					$image_id = get_post_thumbnail_id( $post_id );
					$image_full = wp_get_attachment_image_src( $image_id, 'full' );
					$src = $image_full[0];
				}
				ob_start();
				?>
				<div class="circleAnimationArea animationContainer">
					<div class="circleAnimationSingle animationWrap">
							<?php
								if (has_post_thumbnail($post->ID)) {
									$image_id = get_post_thumbnail_id($post->ID);
									$image_attributes = wp_get_attachment_image_src($image_id,'circle-posts');
							 		echo '<div class="circleAnimationImage front" style="background-image: url('.$image_attributes[0].')"></div>';
							 		//echo '<div class="circleAnimationImage front" data-image="'.$image_attributes[0].'" style="background: url('.get_template_directory_uri().'/img/common/preloader.gif'.') no-repeat 50px 50px"></div>';
								} else {
									echo '<div class="circleAnimationImage" style="background-image: url('.cr_get_option('post_default','').')"></div>';
									//echo '<div class="circleAnimationImage" data-image="'.cr_get_option('post_default','').'" style="background: url('.get_template_directory_uri().'/img/common/preloader.gif'.') no-repeat 50px 50px"></div>';
								}
							?>
						<div class="circleAnimationDetails back circlePostDetails">
							<div class="circleDetailsWrapper">
								<?php $unique_var = uniqid() . mt_rand(); ?>
								<a href="#post-<?php echo esc_attr($post_id . '-' . $unique_var) ?>" rel="prettyPhoto" class="zoomRecent zoomCircle icon-note-beamed"></a>
								<a href="<?php echo get_permalink( $post->ID ) ?>" class="circlePostTitle"><h4><?php echo get_the_title( $post->ID ) ?></h4></a>
								<p>
									by <a href="<?php echo get_author_posts_url($post -> post_author); ?>" class="circlePostAuthor"><?php the_author_meta('display_name', $post -> post_author);?></a>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div id="post-<?php echo esc_attr($post_id . '-' . $unique_var) ?>" class="hide">
					<div>
						<?php echo $media_html ?>
					</div>
				</div>
				<?php
				$media_html = ob_get_clean();
			}
			return  $media_html;
		}
	function circleflip_gallery_circleformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
			$post = get_post($post_id);
			if ( 'my_unique_circle_posts' == $ident ) {
				$src = '';
				if ( has_post_thumbnail( $post_id ) ) {
					$image_id = get_post_thumbnail_id( $post_id );
					$image_full = wp_get_attachment_image_src( $image_id, 'full' );
					$src = $image_full[0];
				}
				$meta = get_post_meta( $post_id, '_circleflip_post_formats', true);
				$gallery_ids = isset($meta['gallery']) ? $meta['gallery'] : array();//get all the gallery images ids
				$first_image_full = wp_get_attachment_image_src( $gallery_ids[0], 'full');//Get First image of gallery
				$first_image_full = $first_image_full[0];
				ob_start();
				?>
				<div class="circleAnimationArea animationContainer">
					<div class="circleAnimationSingle animationWrap">
							<?php
								if (has_post_thumbnail($post->ID)) {
									$image_id = get_post_thumbnail_id($post->ID);
									$image_attributes = wp_get_attachment_image_src($image_id,'circle-posts');
							 		echo '<div class="circleAnimationImage front" style="background-image: url('.$image_attributes[0].')"></div>';
							 		//echo '<div class="circleAnimationImage front" data-image="'.$image_attributes[0].'" style="background: url('.get_template_directory_uri().'/img/common/preloader.gif'.') no-repeat 50px 50px"></div>';
								} else {
									echo '<div class="circleAnimationImage" style="background-image: url('.cr_get_option('post_default','').')"></div>';
									//echo '<div class="circleAnimationImage" data-image="'.cr_get_option('post_default','').'" style="background: url('.get_template_directory_uri().'/img/common/preloader.gif'.') no-repeat 50px 50px"></div>';
								}
							?>
						<?php $unique_var = uniqid() . mt_rand(); ?>
						<div class="circleAnimationDetails back circlePostDetails">
							<div class="circleDetailsWrapper">
								<a href="<?php echo esc_url($first_image_full);?>" rel="prettyPhoto[pp_gal_<?php echo esc_attr($post_id.'-'.$unique_var) ;?>]" class="zoomRecent zoomCircle icon-picture"></a>
								<a href="<?php echo get_permalink( $post->ID ) ?>" class="circlePostTitle"><h4><?php echo get_the_title( $post->ID ) ?></h4></a>
								<p>
									by <a href="<?php echo get_author_posts_url($post -> post_author); ?>" class="circlePostAuthor"><?php the_author_meta('display_name', $post -> post_author);?></a>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div id="<?php echo esc_attr($post_id.'-'.$unique_var) ?>" class="hide">
					<div>
						<?php //echo $media_html ?>
						<?php  
							foreach ($gallery_ids as $key => $value) {
								if($key!=0){
									$image_pretty_full = wp_get_attachment_image_src( $value, 'full' );
									$image_pretty_full = $image_pretty_full[0];
									echo '<a href="'.$image_pretty_full.'" rel="prettyPhoto[pp_gal_'.$post_id.'-'.$unique_var.']"></a>';
								}
							};
						?>
					 </div>
				</div>
				<?php
				$media_html = ob_get_clean();
			}
			return  $media_html;
		}

	function circleflip_standard_portfolioformat( $media_html, $post_id, $size, $ident, $audiovideo ) {

		$post = get_post($post_id);
		if ( 'my_unique_portfolio_posts' == $ident ) {
			$src = '';$image_recent='';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, 'full' );
				$image_recent = wp_get_attachment_image_src( $image_id, 'recent_home_posts' );
				$src = $image_full[0];
			}
			ob_start();
			?>
			<div class="portfolioHomeCont">
				<div class="portfolioHomeCont2">
					<div class="portfolioHomeCont2Inner">
						<a href="<?php echo get_permalink( $post->ID ) ?>"><p class="portfolioHomeTitle"><?php echo get_the_title( $post->ID ) ?></p></a>
						<div class="ZoomContStyle3">
							<?php if(circleflip_valid($src)) { ?>
								<a href="<?php echo esc_url($src); ?>" class="zoomStyle3" rel="prettyPhoto"></a>
							<?php } ?>
								<a href="<?php echo get_permalink( $post->ID ) ?>" class="linkStyle3"></a>
						</div>
					</div>
				</div>
			</div>
			 <?php
				$media_html = ob_get_clean();
		}
		return $media_html;

	}
	function circleflip_video_portfolioformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_portfolio_posts' == $ident ) {
			$src = '';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, 'recent_home_posts' );
				$src = $image_full[0];
			}
			ob_start();
			?>
			<div class="portfolioHomeCont">
				<div class="portfolioHomeCont2">
					<div class="portfolioHomeCont2Inner">
						<a href="<?php echo get_permalink( $post->ID ) ?>"><p class="portfolioHomeTitle"><?php echo get_the_title( $post->ID ) ?></p></a>
						<div class="ZoomContStyle3">
								<?php $unique_var = uniqid() . mt_rand(); ?>
							<a href="#postportfolio-<?php echo esc_attr($post_id.'-'.$unique_var) ?>" rel="prettyPhoto" class="zoomStyle3 icon-play"></a>
							<a href="<?php echo get_permalink( $post->ID ) ?>" class="linkStyle3"></a>
						</div>
					</div>
				</div>
			</div>
			<div id="postportfolio-<?php echo esc_attr($post_id.'-'.$unique_var) ?>" class="hide">
				<div>
					<?php echo $media_html ?>
				 </div>
			</div>
			<?php
			$media_html = ob_get_clean();
		}
		return  $media_html;
	}
	function circleflip_audio_portfolioformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_portfolio_posts' == $ident ) {
			$src = '';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, 'recent_home_posts' );
				$src = $image_full[0];
			}
			ob_start();
			?>
			<div class="portfolioHomeCont">
				<div class="portfolioHomeCont2">
					<div class="portfolioHomeCont2Inner">
						<a href="<?php echo get_permalink( $post->ID ) ?>"><p class="portfolioHomeTitle"><?php echo get_the_title( $post->ID ) ?></p></a>
						<div class="ZoomContStyle3">
								<?php $unique_var = uniqid() . mt_rand(); ?>
							<a href="#postportfolio-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" rel="prettyPhoto" class="zoomStyle3 icon-note-beamed"></a>
							<a href="<?php echo get_permalink( $post->ID ) ?>" class="linkStyle3"></a>
						</div>
					</div>
				</div>
			</div>
			<div id="postportfolio-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="hide">
				<div>
					<?php echo $media_html ?>
				</div>
			</div>
			<?php
			$media_html = ob_get_clean();
		}
		return  $media_html;
	}
	function circleflip_gallery_portfolioformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_portfolio_posts' == $ident ) {
			$src = '';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, 'full' );
				$src = $image_full[0];
			}
			$meta = get_post_meta( $post_id, '_circleflip_post_formats', true);
			$gallery_ids = isset($meta['gallery']) ? $meta['gallery'] : array();//get all the gallery images ids
			if(!empty($gallery_ids[0])) {
				$first_image_full = wp_get_attachment_image_src( $gallery_ids[0], 'full');//Get First image of gallery
				$first_image_full = $first_image_full[0];
			} else {
				$first_image_full='';
			}
			ob_start();
			?>
				<?php $unique_var = uniqid() . mt_rand(); ?>
			<div class="portfolioHomeCont">
				<div class="portfolioHomeCont2">
					<div class="portfolioHomeCont2Inner">
						<a href="<?php echo get_permalink( $post->ID ) ?>"><p class="portfolioHomeTitle"><?php echo get_the_title( $post->ID ) ?></p></a>
						<div class="ZoomContStyle3">
							<?php 
							if($first_image_full != '') {
							 ?>
								<a href="<?php echo esc_url($first_image_full);?>" rel="prettyPhoto[pp_gal_<?php echo esc_attr($post_id.'-'.$unique_var) ;?>]" class="zoomStyle3 icon-picture"></a>
								<?php } ?>
							<a href="<?php echo get_permalink( $post->ID ) ?>" class="linkStyle3"></a>
						</div>
					</div>
				</div>
			</div>
			<div id="postportfolio-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="hide">
				<div>
					<?php //echo $media_html ?>
					<?php  
						foreach ($gallery_ids as $key => $value) {
							if($key!=0){
								$image_pretty_full = wp_get_attachment_image_src( $value, 'full' );
								$image_pretty_full = $image_pretty_full[0];
								echo '<a href="'.$image_pretty_full.'" rel="prettyPhoto[pp_gal_'.$post_id.'-'.$unique_var.']"></a>';
							}
						};
					?>
				 </div>
			</div>
			<?php
			$media_html = ob_get_clean();
		}
		return  $media_html;
	}

	function circleflip_standard_squareredformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_squarered_posts' == $ident ) {
			$src = '';$image_recent='';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, 'full' );
				$image_recent = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_full[0];
			}
			ob_start();
			?>
				<!-- IMAGE -->
				<div class="itemImageWrap">
					<?php if(circleflip_valid($image_recent)) { ?>
							<?php echo wp_get_attachment_image( $image_id, $size) ?>
						<?php } else { ?>
								<?php echo circleflip_get_default_image($size) ?>
							 <?php
						}?>
					<!-- HOVER CONTAINER -->
					<div class="portfolioHoverCont">
						<!-- TITLE -->
						<div class="alignMid1">
							<div class="alignMid2">
								<a href="<?php echo get_permalink($post->ID); ?>"><p class="portHoverTitle"><?php echo get_the_title($post->ID); ?></p></a>
							</div>
						</div>
						<!-- ZOOM & LINK -->
						<?php if(circleflip_valid($src)) { ?>
							<a href="<?php echo esc_url($src); ?>" class="zoomPort" rel="prettyPhoto"></a>
						<?php } ?>
						<a href="<?php echo get_permalink($post->ID); ?>" class="linkPort" ></a>
					</div>
				</div>
			 <?php
				$media_html = ob_get_clean();
		}
		return $media_html;

	}
	function circleflip_video_squareredformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_squarered_posts' == $ident ) {
			$src = '';$image_recent='';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, 'full' );
				$image_recent = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_full[0];
			}
			ob_start();
			?>
				<!-- IMAGE -->
				<div class="itemImageWrap">
					<?php if(circleflip_valid($image_recent)) { ?>
							<?php echo wp_get_attachment_image( $image_id, $size) ?>
					<?php } else { ?>
							<?php echo circleflip_get_default_image($size) ?>
					<?php } ?>
					<!-- HOVER CONTAINER -->
					<div class="portfolioHoverCont">
						<!-- TITLE -->
						<div class="alignMid1">
							<div class="alignMid2">
								<p class="portHoverTitle"><?php echo get_the_title($post->ID); ?></p>
							</div>
						</div>
						<!-- ZOOM & LINK -->
						<?php $unique_var = uniqid() . mt_rand();?>
						<a href="#postsquarered-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" rel="prettyPhoto" class="zoomPort icon-play"></a>
						<a href="<?php echo get_permalink($post->ID); ?>" class="linkPort"></a>
					</div>
				</div>
			<div id="postsquarered-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="hide">
				<div>
					<?php echo $media_html ?>
				 </div>
			</div>
			<?php
			$media_html = ob_get_clean();
		}
		return  $media_html;
	}
	function circleflip_audio_squareredformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_squarered_posts' == $ident ) {
			$src = '';$image_recent='';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, 'full' );
				$image_recent = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_full[0];
			}
			ob_start();
			?>
				<!-- IMAGE -->
				<div class="itemImageWrap">
					<?php if(circleflip_valid($image_recent)) { ?>
							<?php echo wp_get_attachment_image( $image_id, $size) ?>
						<?php } else { ?>
								<?php echo circleflip_get_default_image($size) ?>
							 <?php
						}?>
					<!-- HOVER CONTAINER -->
					<div class="portfolioHoverCont">
						<!-- TITLE -->
						<div class="alignMid1">
							<div class="alignMid2">
								<p class="portHoverTitle"><?php echo get_the_title($post->ID); ?></p>
							</div>
						</div>
						<!-- ZOOM & LINK -->
						<?php $unique_var = uniqid() . mt_rand(); ?>
						<a href="#postsquarered-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" rel="prettyPhoto" class="zoomPort icon-note-beamed"></a>
						<a href="<?php echo get_permalink($post->ID); ?>" class="linkPort"></a>
					</div>
				</div>
			<div id="postsquarered-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="hide">
				<div>
					<?php echo $media_html ?>
				</div>
			</div>
			<?php
			$media_html = ob_get_clean();
		}
		return  $media_html;
	}
	function circleflip_gallery_squareredformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_squarered_posts' == $ident ) {
			$src = '';$image_recent='';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_full = wp_get_attachment_image_src( $image_id, 'full' );
				$image_recent = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_full[0];
			}
			$meta = get_post_meta( $post_id, '_circleflip_post_formats', true);
			$gallery_ids = isset($meta['gallery']) ? $meta['gallery'] : array();//get all the gallery images ids
			$first_image_full = wp_get_attachment_image_src( $gallery_ids[0], 'full');//Get First image of gallery
			$first_image_full = $first_image_full[0];
			ob_start();
			?>
				<!-- IMAGE -->
				<div class="itemImageWrap">
					<?php if(circleflip_valid($image_recent)) { ?>
							<?php echo wp_get_attachment_image( $image_id, $size) ?>
						<?php } else { ?>
								<?php echo circleflip_get_default_image($size) ?>
							 <?php
						}?>
					<!-- HOVER CONTAINER -->
					<div class="portfolioHoverCont">
						<!-- TITLE -->
						<div class="alignMid1">
							<div class="alignMid2">
								<p class="portHoverTitle"><?php echo get_the_title($post->ID); ?></p>
							</div>
						</div>
						<!-- ZOOM & LINK -->
						<?php $unique_var = uniqid() . mt_rand() ?>
						<a href="<?php echo esc_url($first_image_full);?>" rel="prettyPhoto[pp_gal_<?php echo esc_attr($post_id.'-'.$unique_var) ;?>]" class="zoomPort icon-picture"></a>
						<a href="<?php echo get_permalink($post->ID); ?>" class="linkPort"></a>
					</div>
				</div>
			<div id="postsquarered-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="hide">
				<div>
					<?php  
						foreach ($gallery_ids as $key => $value) {
							if($key!=0){
								$image_pretty_full = wp_get_attachment_image_src( $value, 'full' );
								$image_pretty_full = $image_pretty_full[0];
								echo '<a href="'.$image_pretty_full.'" rel="prettyPhoto[pp_gal_'.$post_id.'-'.$unique_var.']"></a>';
							}
						};
					?>
				 </div>
			</div>
			<?php
			$media_html = ob_get_clean();
		}
		return  $media_html;
	}

	function circleflip_standard_masonaryformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_masonary_posts' == $ident ) {
			ob_start();
				$src = '';
				if ( has_post_thumbnail( $post_id ) ) {
					$image_id = get_post_thumbnail_id( $post_id );
					$image_attributes = wp_get_attachment_image_src($image_id,'masonry_post');
					$image_full = wp_get_attachment_image_src( $image_id, 'full' );
					$src = $image_full[0];
				}
			?>
			  	<div class="masonryPostCont">
			  		<div class="masonryPostCont2">
			  			<div class="masonryPostCont2Inner">
			  				<a href="<?php echo get_permalink( $post->ID ) ?>">
				  				<p class="masonryPostTitle"><?php echo get_the_title( $post->ID ) ?></p>
				  				</a>
				  			<div class="ZoomContStyle3">
				  				<?php if ( has_post_thumbnail( $post_id ) ) { ?>
				  					<a href="<?php echo esc_url($image_full[0]); ?>" class="zoomStyle3" rel="prettyPhoto"></a>
				  				<?php } ?>
				  				<a href="<?php echo get_permalink( $post->ID ) ?>" class="linkStyle3"></a>
				  			</div>
			  			</div>
			  		</div>
			  	</div>
			<?php
			$media_html .= ob_get_clean();
		}
		return $media_html;
	}
	function circleflip_video_masonaryformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
			$post = get_post($post_id);
			if ( 'my_unique_masonary_posts' == $ident ) {
				$src = '';
				if ( has_post_thumbnail( $post_id ) ) {
					$image_id = get_post_thumbnail_id( $post_id );
					$image_full = wp_get_attachment_image_src( $image_id, 'full' );
					$src = $image_full[0];
				}
				ob_start();
				?>
				<div class="masonryPostCont">
			  		<div class="masonryPostCont2">
			  			<div class="masonryPostCont2Inner">
			  				<a href="<?php echo get_permalink( $post->ID ) ?>">
								<p class="masonryPostTitle"><?php echo get_the_title( $post->ID ) ?></p>
				  				</a>
							<?php $unique_var = uniqid() . mt_rand() ?>
				  			<div class="ZoomContStyle3">
				  				<a href="" data-toggle="modal" data-target="#postmasonry-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="zoomStyle3 icon-play"></a>
				  				<a href="<?php echo get_permalink( $post->ID ) ?>" class="linkStyle3"></a>
				  			</div>
			  			</div>
			  		</div>
			  	</div>
				<?php if(circleflip_valid($src)) { ?>
					<?php echo wp_get_attachment_image( $image_id, $size) ?>
				<?php } else { ?>
					<?php echo circleflip_get_default_image($size) ?>
				<?php } ?>

				<div id="postmasonry-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="modal hide fade">
					<div class="modal-body">
						<?php echo $media_html ?>
					 </div>
				</div>
				<?php
				$media_html = ob_get_clean();
			}
			return  $media_html;
		}

		function circleflip_gallery_masonaryformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
			if ( 'my_unique_masonary_posts' == $ident ) {
				$post = get_post($post_id);
				$src = '';
				if ( has_post_thumbnail( $post_id ) ) {
					$image_id = get_post_thumbnail_id( $post_id );
					$image_full = wp_get_attachment_image_src( $image_id, 'full' );
					$src = $image_full[0];
				}
				ob_start();
				?>
				<div class="masonryPostCont">
			  		<div class="masonryPostCont2">
			  			<div class="masonryPostCont2Inner">
			  				<a href="<?php echo get_permalink( $post->ID ) ?>">
				  				<p class="masonryPostTitle"><?php echo get_the_title( $post->ID ) ?></p>
				  				</a>
							<?php $unique_var = uniqid() . mt_rand(); ?>
				  			<div class="ZoomContStyle3">
				  				<a href="" data-toggle="modal" data-target="#postmasonry-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="zoomStyle3 icon-picture"></a>
				  				<a href="<?php echo get_permalink( $post->ID ) ?>" class="linkStyle3"></a>
				  			</div>
			  			</div>
			  		</div>
			  	</div>
				<?php if(circleflip_valid($src)) { ?>
					<?php echo wp_get_attachment_image( $image_id, $size) ?>
				<?php } else { ?>
					<?php echo circleflip_get_default_image($size) ?>
				<?php } ?>

				<div id="postmasonry-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="masonryModal galleryModal modal hide fade">
					<div class="modal-body">
						<?php echo $media_html ?>
					 </div>
				</div>
				<?php
				$media_html = ob_get_clean();
		}
			return  $media_html;
	}
	function circleflip_audio_masonaryformat( $media_html, $post_id, $size, $ident, $audiovideo ) {
			if ( 'my_unique_masonary_posts' == $ident ) {
				$post = get_post($post_id);
				$src = '';
				if ( has_post_thumbnail( $post_id ) ) {
					$image_id = get_post_thumbnail_id( $post_id );
					$image_full = wp_get_attachment_image_src( $image_id, 'full' );
					$src = $image_full[0];
				}
				ob_start();
				?>
				<div class="masonryPostCont">
			  		<div class="masonryPostCont2">
			  			<div class="masonryPostCont2Inner">
			  				<a href="<?php echo get_permalink( $post->ID ) ?>">
				  				<p class="masonryPostTitle"><?php echo get_the_title( $post->ID ) ?></p>
				  				</a>
							<?php $unique_var = uniqid() . mt_rand(); ?>
				  			<div class="ZoomContStyle3">
				  				<a href="" data-toggle="modal" data-target="#postmasonry-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="zoomStyle3 icon-note-beamed"></a>
				  				<a href="<?php echo get_permalink( $post->ID ) ?>" class="linkStyle3"></a>
				  			</div>
			  			</div>
			  		</div>
			  	</div>
				<?php if(circleflip_valid($src)) { ?>
					<?php echo wp_get_attachment_image( $image_id, $size) ?>
				<?php } else { ?>
					<?php echo circleflip_get_default_image($size) ?>
				<?php } ?>

				<div id="postmasonry-<?php echo esc_attr( $post_id . '-' . $unique_var ) ?>" class="modal hide fade">
					<div class="modal-body">
						<?php echo $media_html ?>
					 </div>
				</div>
				<?php
				$media_html = ob_get_clean();
		}
			return  $media_html;
	}

	function circleflip_standard_mag1format( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_mag1_posts' == $ident ) {
			$src = '';$image_mag='';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_mag = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_mag[0];
			}
			ob_start();
			?>
			
			<!-- Magazine post Image -->
			<div class="image">
				<?php
				if(circleflip_valid($src)) { ?>
					<?php echo wp_get_attachment_image( $image_id, $size) ?>
				<?php } else {
					echo circleflip_get_default_image($size) ?>
				<?php } ?>
				<div class="magazinePostDate">
					<span class="magazineDay"><?php echo get_the_time( 'd', $post -> ID ) ?></span>
					<span class="magazineMonth"><?php echo get_the_time( 'M', $post -> ID ) ?></span>
				</div>
			</div>
			<!-- Magazine post Right part -->
			<div class="magazineData">
				<!-- Magazine post title -->
				<?php
				$original_title = $post -> post_title;
				$mag_post_title = circleflip_string_limit_characters($original_title,'30');
				?>
				<a  class="magazinePostTitle" href="<?php echo get_permalink($post -> ID); ?>"><h4><?php echo esc_html($mag_post_title); ?></h4></a>
				<!-- Magazine post Categories -->
				<div class="magazineCategories">
					<?php
					$post_categories = wp_get_post_categories( $post->ID );
					$cats = array();
						
					for ($i=0; $i < count($post_categories) && $i<2 ; $i++) {//less than 2 to get only 2 categories
						$cat = get_category( $post_categories[$i] );
						$cat_name = $cat -> name;
						$cat_link = get_category_link($cat -> cat_ID);
						//$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
						if($i != count($post_categories)-1 && $i != 1){
							echo ' <a href='.esc_url($cat_link).'><p>'.esc_html($cat_name).' , </p></a>';
						}
						else {
							echo ' <a href='.esc_url($cat_link).'><p>'.esc_html($cat_name).'</p></a>';
							echo '<p>/</p>';
						}
					}
					?>
					<!-- Magazine post Author -->
					<a class="magazinePostAuthor" href="<?php echo get_author_posts_url($post->ID) ?>"><p class="color"><?php the_author_meta( 'display_name',$post -> post_author); ?></p></a>
				</div>
			</div>
			 <?php
				$media_html = ob_get_clean();
		}
		return $media_html;

	}
function circleflip_standard_mag2format( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_mag2_posts' == $ident ) {
			$src = '';$image_mag='';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_mag = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_mag[0];
			}
			ob_start();
			?>
			
			<!-- Magazine post Image -->
			<div class="image">
				<?php
				if(circleflip_valid($src)) { ?>
					<?php echo wp_get_attachment_image( $image_id, $size) ?>
				<?php } else {
					echo circleflip_get_default_image($size) ?>
				<?php } ?>
				<div class="magazinePostDate">
					<span class="magazineDay"><?php echo get_the_time( 'd', $post -> ID ) ?></span>
					<span class="magazineMonth"><?php echo get_the_time( 'M', $post -> ID ) ?></span>
				</div>
			</div>
			<!-- Magazine post Right part -->
			<div class="magazineData">
				<!-- Magazine post title -->
				<?php
				$original_title = $post -> post_title;
				$mag_post_title = circleflip_string_limit_words($original_title,'2');
				?>
				<a  class="magazinePostTitle" href="<?php echo get_permalink($post -> ID); ?>"><h4><?php echo esc_html($mag_post_title); ?></h4></a>
				<!-- Magazine post Categories -->
				<div class="magazineCategories">
					<?php
					$post_categories = wp_get_post_categories( $post->ID );
					$cats = array();
						
					for ($i=0; $i < count($post_categories) && $i<2 ; $i++) {//less than 2 to get only 2 categories
						$cat = get_category( $post_categories[$i] );
						$cat_name = $cat -> name;
						$cat_link = get_category_link($cat -> cat_ID);
						//$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
						if($i != count($post_categories)-1 && $i != 1){
							echo ' <a href='.esc_url($cat_link).'><p>'.esc_html($cat_name).' , </p></a>';
						}
						else {
							echo ' <a href='.esc_url($cat_link).'><p>'.esc_html($cat_name).'</p></a>';
							echo '<p>/</p>';
						}
					}
					?>
					<!-- Magazine post Author -->
					<a class="magazinePostAuthor" href="<?php echo get_author_posts_url($post->ID) ?>"><p class="color"><?php the_author_meta( 'display_name',$post -> post_author); ?></p></a>
				</div>
				<!-- Magazine post excerpt -->
				<?php
				$original_text = sanitize_text_field($post -> post_content);
				$mag_post_text = circleflip_string_limit_characters($original_text,'90');
				?>
				<p class="magazinePostExcerpt"><?php echo esc_html($mag_post_text); ?></p>
				<!-- Magazine post views & comments number -->
				<div class="magazinePostViews">
					<span class="icon-eye"></span>
					<span class="mag_views_no">
						<?php 
						if(cr_get_option("rtl" , '0') == '1'){
						$standard = array("0","1","2","3","4","5","6","7","8","9");
						$east_arabic = array("&#1632;","&#1633;","&#1634;","&#1635;","&#1636;","&#1637;","&#1638;","&#1639;","&#1640;","&#1641;");
							$numOfViews = circleflip_read_number_of_views($post->ID);
							$numOfViews = str_replace($standard , $east_arabic , $numOfViews);
						}
						else{
							$numOfViews = circleflip_read_number_of_views($post->ID);
						}
						echo esc_html($numOfViews); ?>
					</span>
				</div>
				<div class="magazinePostComments">
					<span class="icon-comment-1"></span>
					<span class="mag_comments_no">
						<?php comments_number('0'); ?>
					</span>
				</div>
				<div class="magazinePostBtn">
					<!-- <a href="<?php the_permalink(); ?>"><?php _e('more..','circleflip')?></a> -->
					<a href="<?php echo get_permalink($post -> ID); ?>" class="btnStyle1 red btnSmall btnCenter">
						<span><?php _e('more..','circleflip')?></span>
						<span class="btnBefore"></span>
						<span class="btnAfter"></span>
						
					</a>
				</div>
			</div>
			 <?php
				$media_html = ob_get_clean();
		}
		return $media_html;

	}
function circleflip_standard_mag3format( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_mag3_posts' == $ident ) {
			$src = '';$image_mag='';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_mag = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_mag[0];
			}
			ob_start();
			?>
			<!-- Magazine post Image -->
			<div class="image">
				<?php
				if(circleflip_valid($src)) { ?>
					<?php echo wp_get_attachment_image( $image_id, $size) ?>
				<?php } else {
					echo circleflip_get_default_image($size) ?>
				<?php } ?>
			</div>
			<!-- Magazine post Right part -->
			<div class="magazineData">
				<!-- Magazine post Categories -->
				<div class="magazineCategories">
					<?php
					$post_categories = wp_get_post_categories( $post->ID );
					$cats = array();
					for ($i=0; $i < count($post_categories) ; $i++) {
						$cat = get_category( $post_categories[$i] );
						$cat_name = $cat -> name;
						$cat_link = get_category_link($cat -> cat_ID);
						//$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
						if($i != count($post_categories)-1){
							echo ' <a href='.esc_url($cat_link).'><p>'.esc_html($cat_name).' , </p></a>';
						}
						else {
							echo ' <a href='.esc_url($cat_link).'><p>'.esc_html($cat_name).'</p></a>';
						}
					}
					?>
				</div>
				<!-- Magazine post title -->
				<?php
				$original_title = $post -> post_title;
				$mag_post_title = circleflip_string_limit_characters($original_title,'45');
				?>
				<a  class="magazinePostTitle" href="<?php echo get_permalink($post -> ID); ?>"><h4><?php echo esc_html($mag_post_title); ?></h4></a>
				<!-- Magazine post Date -->
				<div class="magazinePostDate">
					<span><?php echo get_the_date( 'd M Y' , $post -> ID) ?> </span>
					<p> /</p>
					<!-- Magazine post Author -->
					<a class="magazinePostAuthor" href="<?php echo get_author_posts_url($post -> post_author) ?>"><p><?php the_author_meta( 'display_name',$post -> post_author ) ?></p></a>
				</div>
				<!-- Magazine post excerpt -->
				<?php
				$original_text = sanitize_text_field($post -> post_content);
				$mag_post_text = circleflip_string_limit_characters($original_text,'125');
				?>
				<p class="magazinePostExcerpt"><?php echo esc_html($mag_post_text); ?></p>
				<!-- Magazine post views & comments number -->
				<div class="magazinePostViews">
					<span class="icon-eye"></span>
					<span class="mag_views_no">
						<?php 
						if(cr_get_option("rtl" , '0') == '1'){
						$standard = array("0","1","2","3","4","5","6","7","8","9");
						$east_arabic = array("&#1632;","&#1633;","&#1634;","&#1635;","&#1636;","&#1637;","&#1638;","&#1639;","&#1640;","&#1641;");
							$numOfViews = circleflip_read_number_of_views($post -> ID);
							$numOfViews = str_replace($standard , $east_arabic , $numOfViews);
						}
						else{
							$numOfViews = circleflip_read_number_of_views($post -> ID);
						}
						echo esc_html($numOfViews); ?>
					</span>
				</div>
				<div class="magazinePostComments">
					<span class="icon-comment-1"></span>
					<span class="mag_comments_no">
						<?php comments_number('0'); ?>
					</span>
				</div>
				<div class="magazinePostBtn">
					<!-- <a href="<?php the_permalink(); ?>"><?php _e('more..','circleflip')?></a> -->
					<a href="<?php echo get_permalink($post -> ID); ?>" class="">
						<span><?php _e('Read More..','circleflip')?></span>
					</a>
				</div>
			</div>
			 <?php
				$media_html = ob_get_clean();
		}
		return $media_html;

	}
function circleflip_standard_mag4format( $media_html, $post_id, $size, $ident, $audiovideo ) {
		$post = get_post($post_id);
		if ( 'my_unique_mag4_posts' == $ident ) {
			$src = '';$image_mag='';
			if ( has_post_thumbnail( $post_id ) ) {
				$image_id = get_post_thumbnail_id( $post_id );
				$image_mag = wp_get_attachment_image_src( $image_id, $size );
				$src = $image_mag[0];
			}
			ob_start();
			?>
			
			<!-- Magazine post Image -->
			<div class="image">
				<?php
				if(circleflip_valid($src)) { ?>
					<?php echo wp_get_attachment_image( $image_id, $size) ?>
				<?php } else {
					echo circleflip_get_default_image($size) ?>
				<?php } ?>
			</div>
			<!-- Magazine post Right part -->
			<div class="magazineData">
				<!-- Magazine post Author -->
				<div class="magazinePostAuthor">
					<?php echo get_avatar($post -> post_author); ?>
					<a href="<?php echo get_author_posts_url($post -> post_author) ?>"><p><?php the_author_meta( 'display_name',$post -> post_author ) ?> </p></a>
				</div>
				<!-- Magazine post Date -->
				<div class="magazinePostDate">
					<p> /</p>
					<span><?php echo get_the_date( 'd M Y' , $post -> ID) ?></span>
				</div>
				<!-- Magazine post title -->
				<?php
				$original_title = $post -> post_title;
				$mag_post_title = circleflip_string_limit_characters($original_title,'45');
				?>
				<a  class="magazinePostTitle" href="<?php echo get_permalink($post -> ID); ?>"><h4><?php echo esc_html($mag_post_title); ?></h4></a>
				<!-- Magazine post Categories -->
				<div class="magazineCategories">
					<?php
					$post_categories = wp_get_post_categories( $post->ID );
					$cats = array();
					for ($i=0; $i < count($post_categories) ; $i++) {
						$cat = get_category( $post_categories[$i] );
						$cat_name = $cat -> name;
						$cat_link = get_category_link($cat -> cat_ID);
						//$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
						if($i != count($post_categories)-1){
							echo ' <a href='.esc_url($cat_link).'><p>'.esc_html($cat_name).' , </p></a>';
						}
						else {
							echo ' <a href='.esc_url($cat_link).'><p>'.esc_html($cat_name).'</p></a>';
						}
					}
					?>
				</div>
				<!-- Magazine post excerpt -->
				<?php
				$original_text = sanitize_text_field($post -> post_content);
				$mag_post_text = circleflip_string_limit_characters($original_text,'125');
				?>
				<p class="magazinePostExcerpt"><?php echo esc_html($mag_post_text); ?></p>
				<!-- Magazine post views & comments number -->
				<div class="magazinePostViews">
					<span class="icon-eye"></span>
					<span class="mag_views_no">
						<?php 
						if(cr_get_option("rtl" , '0') == '1'){
						$standard = array("0","1","2","3","4","5","6","7","8","9");
						$east_arabic = array("&#1632;","&#1633;","&#1634;","&#1635;","&#1636;","&#1637;","&#1638;","&#1639;","&#1640;","&#1641;");
							$numOfViews = circleflip_read_number_of_views($post -> ID);
							$numOfViews = str_replace($standard , $east_arabic , $numOfViews);
						}
						else{
							$numOfViews = circleflip_read_number_of_views($post -> ID);
						}
						echo esc_html($numOfViews); ?>
					</span>
				</div>
				<div class="magazinePostComments">
					<span class="icon-comment-1"></span>
					<span class="mag_comments_no">
						<?php comments_number('0'); ?>
					</span>
				</div>
				<div class="magazinePostBtn">
					<!-- <a href="<?php the_permalink(); ?>"><?php _e('more..','circleflip')?></a> -->
					<a href="<?php echo get_permalink($post -> ID); ?>" class="">
						<span><?php _e('Read More..','circleflip')?></span>
					</a>
				</div>
			</div>
			 <?php
				$media_html = ob_get_clean();
		}
		return $media_html;

	}