<?php

class Circleflip_Import_Meta {
	
	protected $_media_pool = array();
	
	public function filter__circleflip_post_formats( $block, $new_id, $old ) {
		if ( ! empty( $block ) && ! empty( $block['gallery'] ) ) {
			$block['gallery'] = $this->get_rand_media( 'post', count( $block['gallery'] ) );
		}
		return $block;
	}
	
	public function filter__product_image_gallery( $block, $new_id, $old ) {
		if ( ! empty( $block ) ) {
			$old_ids = explode( ',', $block );
			if ( ! empty( $old_ids ) ) {
				$block = implode( ',', $this->get_rand_media( 'product', count( $old_ids ) ) );
			}
		}
		return $block;
	}
	
	public function filter__thumbnail_id( $block, $new_id, $old ) {
		if ( ! empty( $block ) ) {
			$block = $this->get_rand_media( 'product' === $old['post_type'] ? 'product' : 'post' );
		}
		return $block;
	}

	public function __construct() {
		add_filter( 'wp_import_post_meta', array( $this, 'router' ), 10, 3 );
		$this->import_media();
	}

	public function router( $meta_data, $post_id, $_post ) {
		foreach ( $meta_data as &$meta_field ) {
			if ( $this->has_filter( $meta_field['key'] ) ) {
				$meta_field['value'] = maybe_unserialize( $meta_field['value'] );
				$meta_field['value'] = $this->{"filter_{$meta_field['key']}"}( $meta_field['value'], $post_id, $_post );
			}
		}
		unset( $meta_field );
		return $meta_data;
	}

	public function return_meta_field( &$meta_data, $field ) {
		$return = '';
		foreach ( $meta_data as $i => $meta_field ) {
			if ( $field === $meta_field['key'] ) {
				$meta_field['value'] = maybe_unserialize( $meta_field['value'] );
				$return = $meta_field;
				unset( $meta_data[$i] );
				break;
			}
		}
		return $return;
	}

	public function has_filter( $block ) {
		return method_exists( $this, 'filter_' . $block );
	}
	
	public function get_rand_media( $block, $number = 1 ) {
		$where = isset( $this->_media_pool[$block] ) ? $block : 'misc';
		if ( 1 === $number ) {
			return $this->_media_pool[$where][array_rand( $this->_media_pool[$where] )];
		}
		$rands = array_rand( $this->_media_pool[$where], min( $number, count( $this->_media_pool[$where] ) ) );
		return array_values( array_intersect_key( $this->_media_pool[$where], array_flip( $rands ) ) );
	}

	public function import_media() {
		$post = get_default_post_to_edit( 'attachment' );
		$post->post_category = array();
		$done = array();
		foreach ( $this->_get_media() as $block => $media ) {
			foreach ( $media as $m ) {
				if ( isset( $done[$m] ) ) {
					$this->_media_pool[$block][] = $done[$m];
					continue;
				}
				$upload = circleflip_importer_fetch_local_file( $m );
				if ( is_wp_error( $upload ) ) {
					continue;
				}
				
				if ( $info = wp_check_filetype( $upload['file'] ) ) {
					$post->post_mime_type = $info['type'];
				} else {
					continue;
				}
				
				$post->guid = $upload['url'];
				
				$post_id = wp_insert_attachment( $post, $upload['file'] );
//				wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );
				
				$this->_media_pool[$block][] = $post_id;
				$done[$m] = $post_id;
			}
		}
	}
	
	public function _get_media() {
		$base = get_template_directory() . '/inc/importer/res';
		return array(
			'post'		 => array(
				$base . '/featured-image-1.jpg',
				$base . '/featured-image-2.jpg',
				$base . '/featured-image-3.jpg',
				$base . '/featured-image-4.jpg',
				$base . '/featured-image-5.jpg',
				$base . '/featured-image-6.jpg',
				$base . '/featured-image-7.jpg',
				$base . '/featured-image-8.jpg',
				$base . '/featured-image-9.jpg',
				$base . '/featured-image-10.jpg',
				$base . '/featured-image-11.jpg',
			),
			'product'	 => array(
				$base . '/shop/product-1.jpg',
				$base . '/shop/product-2.jpg',
				$base . '/shop/product-3.jpg',
				$base . '/shop/product-4.jpg',
			),
		);
	}

}