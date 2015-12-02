<?php
function circleflip_get_post_format_media( $post_id = null, $size = 'thumbnail', $ident = false ) {
	$post = get_post( $post_id );
	if ( ! $post )
		return false;

	$post_id = $post->ID;
	$media_html = '';

	$format = get_post_format( $post_id );
	$slugs = get_post_format_slugs();
	$format_slug = $format ? $slugs[$format] : $slugs['standard'];
	$meta = get_post_meta( $post_id, '_circleflip_post_formats', true);
	$meta = apply_filters('circleflip_post_format_meta', $meta,$format_slug,$post_id,$size,$ident);
	$size_info = circleflip_get_size_dimensions( $size );
	$size_info = apply_filters('circleflip_post_format_media_size', $size_info, $format_slug, $post_id, $size, $ident );
	$audiovideo = array(
		'url'	 => '',
		'args'	 => array(
			'width'	 => $size_info['width'],
			'height' => $size_info['height']
		),
		'html5'	 => false
	);
	switch ( $format_slug ) {
		case 'audio':
			if ( ! empty( $meta['audio_embed'] ) ) {
				$audiovideo['url'] = $meta['audio_embed'];
			} else if ( ! empty( $meta['audio_id'] ) ) {
				$audiovideo['url'] = wp_get_attachment_url( $meta['audio_id'] );
				$audiovideo['html5'] = true;
			}
			$media_html = circleflip_get_wp_media( 'audio', $audiovideo['url'], $audiovideo['args'], $audiovideo['html5'] );
			break;
		case 'video':
			if ( ! empty( $meta['video_embed'] ) ) {
				$audiovideo['url'] = $meta['video_embed'];
				unset( $audiovideo['args']['height'] );
			} else if ( ! empty( $meta['video_id'] ) ) {
				$audiovideo['url'] = wp_get_attachment_url( $meta['video_id'] );
				$audiovideo['html5'] = true;
			}
			$media_html = circleflip_get_wp_media( 'video', $audiovideo['url'], $audiovideo['args'], $audiovideo['html5'] );
			break;
		case 'gallery':
			if ( ! empty( $meta['gallery'] ) ){
				$media_html = circleflip_get_gallery( $meta['gallery'], $meta['gallery_layout'] );
			}
			break;
		case 'standard':
			$media_html = '<a href="' . get_the_permalink($post_id) . '">'. get_the_post_thumbnail( $post_id, $size ) . '</a>';
	}
	$media_html = apply_filters( "circleflip_post_format_{$format_slug}_html", $media_html, $post_id, $size, $ident, $audiovideo );
	$media_html = apply_filters( "circleflip_post_format_html", $media_html, $format_slug, $post_id, $size, $ident, $audiovideo );
	return $media_html;
}

function circleflip_get_size_dimensions( $size ) {
	global $_wp_additional_image_sizes;

	if ( isset( $_wp_additional_image_sizes[$size] ) ) {
		return array(
			'width'	 => intval( $_wp_additional_image_sizes[$size]['width'] ),
			'height' => intval( $_wp_additional_image_sizes[$size]['height'] ),
		);
	} else {
		return array(
			'width' => get_option( "{$size}_size_w" ),
			'height' => get_option( "{$size}_size_h" ),
		);
	}
}

function circleflip_get_wp_media( $type, $url, $args = array(), $html5 = false ) {
	$url = trim( $url );
	if ( ! $type || ! $url )
		return false;
	$html5_func = "wp_{$type}_shortcode";
	if ( ! $html5 ) {
		return wp_oembed_get( $url, $args );
	} else if ( $html5 && function_exists( $html5_func ) ) {
		$args['src'] = $url;
		return $html5_func( $args );
	}
}

function circleflip_get_gallery( $ids, $layout = false ) {
	global $post;
	$html = '';
	ob_start();
	$src = wp_get_attachment_image_src( $ids[0], 'full' );
	switch ($layout) {
		case 'layout1':
			?>
			<!-- Gallery First Style -->
			<div class="galleryStyle1 galleryBlock">
				<!-- Large Image Div  -->
				<div class="largeImage">
					<div class="galleryCont">
						<div class="galleryAlignMid">
							<div class="galleryAlignMid2">
								<div class="linkZoomCont">
									<a href="<?php echo esc_url($src[0]) ?>"  rel="prettyphoto" class="zoomRecent"></a>
								</div>
							</div>
						</div>
					</div>
					<a href="<?php echo esc_url($src[0]) ?>" rel="prettyphoto">
						<?php echo wp_get_attachment_image( $ids[0], 'full') ?>
					</a>
				</div>
					<ul class="galleryThumbnails">
					<?php
						foreach ( $ids as $id ) {
							$src = wp_get_attachment_image_src( $id, 'full' );
							?>
							<li data-large="<?php echo esc_url($src[0])?>" class="animateCr">
								<div class="galleryCont">
									<div class="galleryAlignMid">
										<div class="galleryAlignMid2">
											<div class="linkZoomCont">
												<a href="<?php echo esc_url($src[0])?>"  rel="prettyphoto" class="zoomRecent"></a>
											</div>
										</div>
									</div>
								</div>
								<?php echo wp_get_attachment_image( $id, 'thumbnail') ?>
							</li>
						<?php
						}
						?>
					</ul>
				</div>
	<?php
			break;
		case 'layout2':
			?>
			<!-- Gallery Second Style -->
			<div class="galleryStyle2 galleryBlock">
				<!-- Large Image Div  -->
				<div class="largeImage">
					<div class="galleryCont">
						<div class="galleryAlignMid">
							<div class="galleryAlignMid2">
								<div class="linkZoomCont">
									<a href="<?php echo esc_url($src[0]) ?>"  rel="prettyphoto" class="zoomRecent"></a>
								</div>
							</div>
						</div>
					</div>
					<a href="<?php echo esc_url($src[0]) ?>" rel="prettyphoto">
						<?php echo wp_get_attachment_image( $ids[0], 'full') ?>
					</a>
				</div>
				<!-- List of Thumbnails-->
				<div class="arrows_gallery">
					<div class="galleryIconArrow galleryIconArrowTop">
						<a class="next icon-down-open-mini" href="#"></a> 
    				</div>
    				<div class="galleryIconArrow galleryIconArrowBottom">
						<a class="prev icon-up-open-mini" href="#"></a>
					</div>
				</div>
					<ul class="galleryThumbnails">
						<?php
						foreach ( $ids as $id ) {
							$src = wp_get_attachment_image_src( $id, 'full' );
							$thumb = wp_get_attachment_image_src( $id ,'thumbnailGallery');
							?>
						<li data-large="<?php echo esc_url($src[0]) ?>" class="animateCr">
							<div class="galleryCont">
									<div class="galleryAlignMid">
										<div class="galleryAlignMid2">
											<div class="linkZoomCont">
												<a href="<?php echo esc_url($src[0]) ?>"  rel="prettyphoto" class="zoomRecent"></a>
											</div>
										</div>
									</div>
								</div>
							<a href="<?php echo esc_url($src[0]) ?>" rel="prettyphoto">
								<?php echo wp_get_attachment_image( $id, 'thumbnailGallery' ) ?>
							</a>
						</li>
						<?php
						}
						?>
					</ul>
					<div style="clear: both;"></div>
			</div>
			<!-- Gallery Second Style End -->
			<?php
			break;
		case 'layout3':
			?>
			<!-- Gallery Third Style -->
			<div class="galleryStyle3 galleryBlock">
				<!-- List of Thumbnails-->
				<ul class="galleryThumbnails">
					<?php foreach ( $ids as $id ) {
						$src = wp_get_attachment_image_src( $id, 'full' );
						$thumb = wp_get_attachment_image_src( $id ,'thumbnail');
						?>
					<li data-large="<?php echo esc_url($src[0]) ?>" class="animateCr">
						<div class="galleryCont">
								<div class="galleryAlignMid">
									<div class="galleryAlignMid2">
										<div class="linkZoomCont">
											<a href="<?php echo esc_url($src[0]) ?>"  rel="prettyphoto" class="zoomRecent"></a>
										</div>
									</div>
								</div>
							</div>
						<a href="<?php echo esc_url($src[0]) ?>" rel="prettyphoto">
							<?php echo wp_get_attachment_image( $id, 'thumbnail') ?>
						</a>
					</li>
					<?php }  ?>
				</ul>
			</div>
			<?php
			break;
		case 'layout4':
			?>
			<div class="containerLoader">
				<div class="loader"><span class="topLoader"></span><span class="bottomLoader"></span></div>
			</div>
			<div class="carousel-gallery">
                <ul class="clearfix">
                <?php
                $first = true;
					foreach ( $ids as $id ) {
						$active = '';
						 if ( $first )
					    {
					    	$active = 'active';
					        // do something
					        $first = false;
					    }
						?>
					<li class="<?php echo esc_attr($active);?>">
						<?php echo wp_get_attachment_image( $id, 'gallery_slider' ) ?>
	                 </li>
					<?php
						}
					?>
                </ul>
                <a class="left carousel-control" href="#"><span class="icon-left-open-big"></span></a>
                <a class="right carousel-control" href="#"><span class="icon-right-open-big"></span></a>
              </div>
			<!-- Slider Images End -->
		<?php
			break;
		default:

			break;
	}
	$html .= ob_get_clean();
	return $html;
}


function circleflip_resize_media_if_sidebar( $size_info, $format_slug, $post_id, $size, $ident ) {
	//_sidebar-position
	if ( 'video' == $format_slug || 'audio' == $format_slug ) {
		global $wp_query;
		if ( ! empty( $wp_query->post ) ) {
			$sidebar = get_post_meta( $wp_query->post->ID, '_sidebar-position', true );
			if ( ! empty( $sidebar ) && in_array( $sidebar, array('left', 'right') ) ) {
				$size_info['width'] -= 400;
			}
		}
	}
	return $size_info;
}

add_filter( 'circleflip_post_format_media_size', 'circleflip_resize_media_if_sidebar', 10, 5 );