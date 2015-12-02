<?php

if ( ! function_exists( 'circleflip_make_missing_intermediate_size' ) ) {

	/** generate new image sizes for old uploads
	 * 
	 * @param mixed $out
	 * @param int $id
	 * @param string|array $size
	 * @return mixed
	 */
	function circleflip_make_missing_intermediate_size( $out, $id, $size ) {
		$skip_sizes = array( 'full', 'large', 'medium', 'thumbnail', 'thumb' );
		if ( is_array( $size ) || in_array( $size, $skip_sizes ) )
			return $out;

		// the size exists and the attachment doesn't have a pre-generated file of that size
		// or the intermediate size defintion changed ( during development )
		if ( circleflip_intermediate_size_exists( $size ) 
				&& ( ! circleflip_image_has_intermediate_size( $id, $size ) || circleflip_has_intermediate_size_changed( $id, $size ) ) 
			) {
			// get info registerd by add_image_size
			$size_info = circleflip_get_intermediate_size_info( $size );
			// get path to the original file
			$file_path = get_attached_file( $id );
			// resize the image
			$resized_file = image_make_intermediate_size( $file_path, $size_info['width'], $size_info['height'], $size_info['crop'] );
			if ( $resized_file ) {
				// we have a resized image, get the attachment metadata and add the new size to it
				$metadata = wp_get_attachment_metadata( $id );
				$metadata['sizes'][$size] = $resized_file;
				if ( wp_update_attachment_metadata( $id, $metadata ) ) {
					// update succeded, call image_downsize again , DRY
					return image_downsize( $id, $size );
				}
			} else {
				// failed to generate the resized image
				// call image_downsize with `full` to prevent infinit loop
				return image_downsize( $id, 'full' );
			}
		}

		// pre-existing intermediate size
		return $out;
	}

	add_filter( 'image_downsize', 'circleflip_make_missing_intermediate_size', 10, 3 );
}

if ( ! function_exists( 'circleflip_intermediate_size_exists' ) ) {

	/** check if a size was added by add_image_size
	 * 
	 * @global array $_wp_additional_image_sizes
	 * @param string $size
	 * @return bool TRUE if $size exists false otherwise
	 */
	function circleflip_intermediate_size_exists( $size ) {
		global $_wp_additional_image_sizes;
		return in_array( $size, array_keys( $_wp_additional_image_sizes ) );
	}

}

if ( ! function_exists( 'circleflip_image_has_intermediate_size' ) ) {

	/** check if a size was generated for the attachment
	 * 
	 * @param int $id attachment id to check.
	 * @param type $size the size as specified in add_image_size.
	 * @return bool TRUE if the size was generated | FALSE otherwise
	 */
	function circleflip_image_has_intermediate_size( $id, $size ) {
		$metadata = wp_get_attachment_metadata( $id );
		return isset( $metadata['sizes'][$size] );
	}

}

if ( ! function_exists( 'circleflip_get_intermediate_size_info' ) ) {

	/** get info related to a media size
	 * 
	 * @global array $_wp_additional_image_sizes
	 * @param string $size
	 * @return array {
	 * 			int  $width,
	 * 			int  $height,
	 * 			bool $crop
	 * 		}
	 */
	function circleflip_get_intermediate_size_info( $size ) {
		global $_wp_additional_image_sizes;
		if ( isset( $_wp_additional_image_sizes[$size] ) ) {
			return $_wp_additional_image_sizes[$size];
		} else {
			return array(
				'width'	 => get_option( "{$size}_size_w" ),
				'height' => get_option( "{$size}_size_h" ),
				'crop'	 => get_option( "{$size}_crop" ),
			);
		}
	}

}

if ( ! function_exists( 'circleflip_has_intermediate_size_changed' ) ) {
	
	function circleflip_has_intermediate_size_changed( $id, $size ) {
		$metadata = wp_get_attachment_metadata( $id );
		$size_info = circleflip_get_intermediate_size_info( $size );
		if ( ($size_info['width'] === 0 || $size_info['width'] === $metadata['sizes'][$size]['width']) 
				&& ($size_info['height'] === 0 || $size_info['height'] === $metadata['sizes'][$size]['height']) 
			) {
			return false;
		}
		return true;
	}
}