<?php
/**
 * this file enables the use of GIFs as featured images
 */

/**
 * uses JIT hooks , to check if thumb is GIF adding hooks if handle GIFs
 * and a hook to remove those hooks lateron
 *
 * @uses image_downsize
 * @uses wp_get_attachment_image_attributes
 * @uses end_fetch_post_thumbnail_html
 *
 * @param int $post_id
 * @param int $post_thumbnail_id
 * @param string $size
 */
function circleflip_add_gif_support_hooks( $post_id, $post_thumbnail_id, $size ) {
	$thumb_meta = wp_get_attachment_metadata( $post_thumbnail_id );
	if ( false === $thumb_meta || empty( $thumb_meta ) )
		return;
	$thumb_filetype = wp_check_filetype( $thumb_meta['file'] );
	if ( 'gif' == $thumb_filetype['ext'] ) {
		add_filter( 'image_downsize', 'circleflip_return_original_image', 11, 3 );
		add_filter( 'wp_get_attachment_image_attributes', 'circleflip_add_gif_class', 10, 2 );
		add_action( 'end_fetch_post_thumbnail_html', 'circleflip_remove_gif_support_hooks', 10, 3 );
	}
}

add_action( 'begin_fetch_post_thumbnail_html', 'circleflip_add_gif_support_hooks', 10, 3 );

/**
 * ignore the specified size , returns original image
 */
function circleflip_return_original_image( $out, $id, $size ) {
	remove_filter( 'image_downsize', 'circleflip_return_original_image', 11 );
	return image_downsize( $id, 'full' );
}

/**
 * adds a class to identifiy GIF images
 */
function circleflip_add_gif_class( $attr, $attachment ) {
	$attr['class'] = $attr['class'] . ' gifImage';
	return $attr;
}

function circleflip_remove_gif_support_hooks( $post_id, $post_thumbnail_id, $size ) {
	remove_filter( 'wp_get_attachment_image_attributes', 'circleflip_add_gif_class', 10 );
}