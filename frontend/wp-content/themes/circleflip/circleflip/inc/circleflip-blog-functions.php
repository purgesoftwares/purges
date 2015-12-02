<?php

function circleflip_blog_excerpt_limit( $limit ) {
	global $wp_query;
	// $wp_query->post holds the original post before the subquery
	if ( ! empty( $wp_query->post ) && is_page() && circleflip_is_blog_template( $wp_query->post->ID ) ) {
		$limit = 440;
	}
	return $limit;
}

add_filter( 'excerpt_length', 'circleflip_blog_excerpt_limit' );

function circleflip_blog_thumbnail_fallback( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
//	global $_wp_additional_image_sizes, $wp_query;
	if (! $html ) {
		$html = circleflip_get_default_image( $size );
//		if ( cr_get_option( 'post_default', false ) ) {
//			$html = '<img src="' . cr_get_option('post_default') . '"">';
//		} else if ( ! $post_thumbnail_id && isset( $_wp_additional_image_sizes[$size] ) ) {
//			$html = "<img src='http://placehold.it/"
//					. "{$_wp_additional_image_sizes[$size]['width']}x"
//					. "{$_wp_additional_image_sizes[$size]['height']}'>";
//		}
	}
	return $html;
}

add_filter( 'post_thumbnail_html', 'circleflip_blog_thumbnail_fallback', 10, 5 );

/**
 * Metabox
 */

function circleflip_blog_register_layout_metabox() {
    $args = array(
		'id'			 => 'circleflip-blog-layout',
		'title'			 => 'Blog Layout',
		'callback'		 => 'circleflip_blog_render_layout_metabox',
		'post_type'		 => 'page',
		'context'		 => 'normal',
		'priority'		 => 'high',
		'callback_args'	 => NULL
	);

    extract( $args );
    add_meta_box( $id, $title, $callback, $post_type, $context, $priority, $callback_args ); //metabox for posts
}

add_action('add_meta_boxes', "circleflip_blog_register_layout_metabox");

function circleflip_blog_render_layout_metabox() {
	global $post;
	$selected = get_post_meta($post->ID, '_circleflip_blog_layout', true) ? get_post_meta($post->ID, '_circleflip_blog_layout', true) : 'layout-one';
	wp_nonce_field(__FILE__, 'circleflip_blog_layout');
	?>
	<div>
		<label>
			<input type="radio" name="_circleflip_blog_layout" value="layout-one" <?php checked($selected, 'layout-one')?>> Layout one
		</label>
		<label>
			<input type="radio" name="_circleflip_blog_layout" value="layout-two" <?php checked($selected, 'layout-two')?>> Layout two
		</label>
	</div>
	<script>
	(function($){
		$(document).ready(function(){
			var toggleBlogLayoutMetabox = function(){
				$("#circleflip-blog-layout").toggle('templates/template-blog.php' == $('#page_template').val());
			};
			toggleBlogLayoutMetabox();
			$("#page_template").on('change', toggleBlogLayoutMetabox);
		});
	}(jQuery));
	</script>
	<?php
}

function circleflip_blog_save_layout_metabox( $post_id ) {
    if (
            ( ! isset( $_POST['circleflip_blog_layout'] ) || ! wp_verify_nonce( $_POST['circleflip_blog_layout'], __FILE__ ))
            || (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
            || ('page' == $_POST['post_type'] && ! current_user_can( 'edit_page', $post_id ))
    )
		return $post_id;

	if ( circleflip_is_blog_template( $post_id ) )
		update_post_meta( $post_id, '_circleflip_blog_layout', $_POST['_circleflip_blog_layout']);
}

add_action('save_post', "circleflip_blog_save_layout_metabox");

function circleflip_is_blog_template( $post_id ) {
	return 'templates/template-blog.php' === get_post_meta( $post_id, '_wp_page_template', true );
}

/* **************************************************************************
						BLOG AJAX WITH BACKBONE ( ALPHA )
   ************************************************************************** */
function circleflip_ajax_get_posts(){
	global $wp_query, $post;
	$args = wp_parse_args( $_GET, array(
		'posts_per_page'		 => cr_get_option( 'blog_posts_per_page', 5 ),
		'cat'					 => implode( ',', array_filter( cr_get_option( 'blog_selected_cat', array() ) ) ),
		'post_type'				 => 'post',
		'orderby'				 => 'date',
		'order'					 => 'DESC',
		'paged'					 => 1,
		'post_status'			 => 'publish',
		'posts_per_archive_page' => cr_get_option( 'blog_posts_per_page', 5 )
			) );
	$wp_query = new WP_Query( $args );
	
	if ( have_posts() ) {
		while ( have_posts() ) { the_post();
			$post->post_excerpt = apply_filters('the_excerpt', get_the_excerpt());
			$post->post_title = get_the_title();
			$post->post_thumbnail = get_the_post_thumbnail( get_the_ID(), 'blog_posts_3_full' );
			$post->post_permalink = esc_url( apply_filters( 'the_permalink', get_permalink() ) );
			$post->author = array(
				'display_name'	 => apply_filters( 'the_author_display_name', get_the_author_meta( 'display_name' ), $post->post_author ),
				'posts_link'	 => get_author_posts_url( get_the_author_meta( 'ID' ) ),
			);
			$cats = wp_get_post_categories( get_the_ID(), array('fields' => 'all') );
			$categories = array();
			if ( ! empty( $cats ) ) {
				foreach ( $cats as $cat ) {
					$categories[] = array(
						'name'	 => $cat->name,
						'url'	 => get_category_link( $cat ),
					);
				}
			}
			$post->categories = $categories;
			$_tags = wp_get_post_tags( get_the_ID(), array('fields' => 'all') );
			$tags = array();
			if ( ! empty( $_tags ) ) {
				foreach ( $_tags as $tag ) {
					$tags[] = array(
						'name'	 => $tag->name,
						'url'	 => get_tag_link( $tag ),
					);
				}
			}
			$post->tags = $tags;
			$post->humman_time_diff = human_time_diff( get_post_time() );
			unset($post->post_content);
		}
		wp_send_json_success( $wp_query->posts );
	} else {
		wp_send_json_error();
	}
}

add_action( 'wp_ajax_cf_get_posts', 'circleflip_ajax_get_posts' );
add_action( 'wp_ajax_nopriv_cf_get_posts', 'circleflip_ajax_get_posts' );

function circleflip_blog_thumbnail_ajax_fallback( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
	global $_wp_additional_image_sizes, $wp_query;
	if (! $html && ! empty( $wp_query->post ) && 'blog_posts_3_full' === $size ) {
		if ( cr_get_option( 'post_default', false ) ) {
			$html = '<img src="' . cr_get_option('post_default') . '"">';
		} else if ( ! $post_thumbnail_id && isset( $_wp_additional_image_sizes[$size] ) ) {
			$html = "<img src='http://placehold.it/"
					. "{$_wp_additional_image_sizes[$size]['width']}x"
					. "{$_wp_additional_image_sizes[$size]['height']}'>";
		}
	}
	return $html;
}

//add_filter( 'post_thumbnail_html', 'circleflip_blog_thumbnail_ajax_fallback', 10, 5 );