<?php

class Circleflip_Import_Builder {
	
	protected $_media_pool = array();

	public function filter_cr_gallery( $block, $new_id, $old_id ) {
		if ( ! empty( $block['ids'] ) ) {
			$block['ids'] = $this->get_rand_media( 'cr_gallery', count( $block['ids'] ) );
		}
		return $block;
	}
	
	public function filter_cr_features_home( $block, $new_id, $old_id ) {
		// 'link' => string '' (length=0)
		// 'choose_type' => string '0' (length=1)
		// 'icon' => string 'icon-export' (length=11)
		// 'imagesrc' => string '/' (length=1)
		// 'image' => string '' (length=0)
		// 'title' => string 'New Title' (length=9)
		// 'content' => string 'New Content' (length=11)
		// 'color' => string '' (length=0)
		if ( ! empty( $block['tabs'] ) ) {
			
			foreach ( $block['tabs'] as &$tab ) {
				if ( '1' === $tab['choose_type'] ) {
					$media_id = $this->get_rand_media( 'cr_features_home' );
					$tab['imagesrc'] = $media_id;
					$tab['image'] = wp_get_attachment_url( $media_id );
				}
			}
			unset( $tab );
		}
		return $block;
	}
	
	public function filter_cr_team_block( $block, $new_id, $old_id ) {
		//member_imageid
		//member_image
		
		$avatar_id = $this->get_rand_media( 'cr_team_block' );
		
		$block['member_imageid'] = $avatar_id;
		$block['member_image'] = wp_get_attachment_url( $avatar_id );

		return $block;
	}
	
	public function filter_aq_column_block( $block, $new_id, $old_id ) {
		//image_uploadid
		//image_upload

		$background_id = $this->get_rand_media( 'aq_column_block' );

		$block['image_uploadid'] = $background_id;
		$block['image_upload'] = wp_get_attachment_url( $background_id );

		return $block;
	}
	
	public function filter_cr_testimonials_section( $block, $new_id, $old_id ) {
		if ( ! empty( $block['tabs'] ) ) {
			foreach ( $block['tabs'] as &$tab ) {
				$media_id = $this->get_rand_media( 'cr_testimonials_section' );
				$tab['imagesrc'] = $media_id;
				$tab['image'] = wp_get_attachment_url( $media_id );
			}
			unset( $tab );
		}
		return $block;
	}
	
	public function filter_cr_carousel_block( $block, $new_id, $old_id ) {
		if ( ! empty( $block['tabs'] ) ) {
			foreach ( $block['tabs'] as &$tab ) {
				$media_id = $this->get_rand_media( 'cr_carousel_block' );
				$tab['imagesrc'] = $media_id;
				$tab['image'] = wp_get_attachment_url( $media_id );
			}
			unset( $tab );
		}
		return $block;
	}
	
	public function filter_cr_clinets_logos( $block, $new_id, $old_id ) {
		if ( ! empty( $block['tabs'] ) ) {
			foreach ( $block['tabs'] as &$tab ) {
				$media_id = $this->get_rand_media( 'cr_clinets_logos' );
				$tab['imagesrc'] = $media_id;
				$tab['image'] = wp_get_attachment_url( $media_id );
			}
			unset( $tab );
		}
		return $block;
	}
	
	public function filter_cr_advertisement_block( $block, $new_id, $old_id ) {
		if ( ! empty( $block['tabs'] ) ) {
			foreach ( $block['tabs'] as &$tab ) {
				$media_id = $this->get_rand_media( 'cr_advertisement_block' );
				$tab['imagesrc'] = $media_id;
				$tab['image'] = wp_get_attachment_url( $media_id );
			}
			unset( $tab );
		}
		return $block;
	}

	public function __construct() {
		add_filter( 'wp_import_post_meta', array( $this, 'router' ), 10, 3 );
		$this->import_media();
	}

	public function router( $meta_data, $post_id, $_post ) {
		//remap all aq_block_ meta fields property ( template_id )
		foreach ( $meta_data as &$meta_field ) {
			if ( substr( $meta_field['key'], 0, 9 ) !== 'aq_block_' ) {
				continue;
			}

			$meta_field['value'] = maybe_unserialize( base64_decode( $meta_field['value'] ) );
			if ( isset( $meta_field['value']['template_id'] ) ) {
				$meta_field['value']['template_id'] = $post_id;
			}
			
			if ( $this->has_filter( $meta_field['value'] ) ) {
				$meta_field['value'] = $this->{"filter_{$meta_field['value']['id_base']}"}( $meta_field['value'], $post_id, $_post['post_id'] );
			}
		}
		unset( $meta_field );
		
		// grab aq_template_ meta field and remove it from meta_data
		$template = $this->return_meta_field( $meta_data, 'aq_template_' . $_post['post_id'] );

		if ( ! $template ) {
			return $meta_data;
		}
		$template['key'] = 'aq_template_' . $post_id;
		if ( is_array( $template['value'] ) ) {
			
			// loop over all blocks applying filter functions with signature filter_{block id_base}
			foreach ( $template['value'] as &$block ) {
				$block['template_id'] = $post_id;

				if ( $this->has_filter( $block ) ) {
					$block = $this->{"filter_{$block['id_base']}"}( $block, $post_id, $_post['post_id'] );
				}
			}
			unset( $block );
			$meta_data[] = $template;
			
		}
		
		return $meta_data;
	}

	public function return_meta_field( &$meta_data, $field ) {
		$return = '';
		foreach ( $meta_data as $i => $meta_field ) {
			if ( $field === $meta_field['key'] ) {
				$meta_field['value'] = maybe_unserialize( base64_decode( $meta_field['value'] ) );
				$return = $meta_field;
				unset( $meta_data[$i] );
				break;
			}
		}
		return $return;
	}

	public function has_filter( $block ) {
		return method_exists( $this, 'filter_' . $block['id_base'] );
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
			'cr_features_home'			 => array(
				$base . '/icons-1.png',
				$base . '/icons-2.png',
				$base . '/icons-3.png',
				$base . '/icons-4.png',
			),
			'cr_team_block'				 => array(
				$base . '/avatar.jpg',
			),
			'cr_testimonials_section'	 => array(
				$base . '/avatar.jpg',
			),
			'aq_column_block'			 => array(
				$base . '/columns/column-background-1.jpg',
				$base . '/columns/column-background-2.jpg',
			),
			'cr_carousel_block'			 => array(
				$base . '/clients/client-1.png',
				$base . '/clients/client-2.png',
				$base . '/clients/client-3.png',
				$base . '/clients/client-4.png',
				$base . '/clients/client-5.png',
				$base . '/clients/client-6.png',
				$base . '/clients/client-7.png',
			),
			'cr_clinets_logos'			 => array(
				$base . '/clients/client-1.png',
				$base . '/clients/client-2.png',
				$base . '/clients/client-3.png',
				$base . '/clients/client-4.png',
				$base . '/clients/client-5.png',
				$base . '/clients/client-6.png',
				$base . '/clients/client-7.png',
			),
			'cr_advertisement_block'	 => array(
				$base . '/ad/tf_125x125_v1.gif',
				$base . '/ad/tf_180x100_v2.gif',
				$base . '/ad/tf_260x120_v3.gif',
				$base . '/ad/tf_300x250_v41.gif',
				$base . '/ad/tf_468x60_v11.gif',
				$base . '/ad/tf_728x90_v21.gif',
			),
			'cr_gallery'				 => array(
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
		);
	}

}