<?php

function circleflip_post_formats_register_metabox($post_type, $post) {
	if ( 'comment' == $post_type ) {
		return;
	}
	$format = get_post_format( $post->ID );
	$format = $format ? ucfirst( $format ) : 'Standard';
	$args = array(
		'id'			 => "circleflip-post-formats-metabox",
		'title'			 => "Post Format: {$format}",
		'callback'		 => 'circleflip_post_formats_render_metabox',
		'context'		 => 'normal',
		'priority'		 => 'high',
		'callback_args'	 => NULL
	);
	extract( $args );

	add_meta_box( $id, $title, $callback, 'post', $context, $priority, $callback_args ); //metabox for posts
	add_meta_box( $id, $title, $callback, 'circleflip-portfolio', $context, $priority, $callback_args ); //metabox for circleflip-portfolio
}

add_action( 'add_meta_boxes', 'circleflip_post_formats_register_metabox', 10, 2 );

function circleflip_post_formats_render_metabox() {
	wp_nonce_field( __FILE__, "_circleflip_post_formats[_nonce]" );
	get_template_part( 'partials/metabox', 'post-formats' );
	wp_enqueue_script(
                'jquery-circleflip-mediaframe',
				 get_template_directory_uri() . '/js/jquery.circleflip.mediaframe.js',
                array('jquery', 'underscore')
			);
	wp_enqueue_script(
				'circleflip-metabox-post-formats',
				get_template_directory_uri() . '/js/metabox.post.formats.js',
				array('jquery', 'underscore', 'jquery-circleflip-mediaframe')
			);
}

function circleflip_post_formats_save_metabox( $post_id ) {
	if ( ! isset( $_POST['_circleflip_post_formats'] ) // we have data
			|| ! wp_verify_nonce( $_POST['_circleflip_post_formats']['_nonce'], __FILE__ )
			|| defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE
			|| ! current_user_can( 'edit_post', $post_id )
	) {
		return $post_id;
	}

	$format = get_post_format( $post_id );
	$data = array();
	if( 'audio' === $format ) {
		if ( ! empty( $_POST['_circleflip_post_formats']['audio_id'] ) ) {
			$data['audio_id'] = ( int ) $_POST['_circleflip_post_formats']['audio_id'];
		} else {
			$data['audio_embed'] = $_POST['_circleflip_post_formats']['audio_embed'];
		}
	} else if ( 'video' === $format ) {
		if ( ! empty( $_POST['_circleflip_post_formats']['video_id'] ) ) {
			$data['video_id'] = ( int ) $_POST['_circleflip_post_formats']['video_id'];
		} else {
			$data['video_embed'] = $_POST['_circleflip_post_formats']['video_embed'];
		}
	} else if ( 'gallery' === $format ) {
		$ids_string = $_POST['_circleflip_post_formats']['gallery'];
		$data['gallery'] = wp_parse_id_list( $ids_string );
		$data['gallery_layout'] = $_POST['_circleflip_post_formats']['layout'];
	}

	update_post_meta( $post_id, '_circleflip_post_formats', $data );
}

add_action( 'save_post', 'circleflip_post_formats_save_metabox' );