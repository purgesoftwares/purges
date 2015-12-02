<?php
function circleflip_save_like_post_meta() {
	$likes_num = get_post_meta( $_POST['post_id'], '_likes',true );
	if(isset($_COOKIE["like_{$_POST['post_id']}"])) {
		if($_COOKIE["like_{$_POST['post_id']}"] != 1){
			$likes_num++;
			$_COOKIE["like_{$_POST['post_id']}"] = 1;
			update_post_meta($_POST['post_id'], '_likes', $likes_num);
		}else{
			$_COOKIE["like_{$_POST['post_id']}"] = 0;
			$likes_num--;
			update_post_meta($_POST['post_id'], '_likes', $likes_num);
		}
	}
	//var_dump($_COOKIE);
	echo $likes_num
	;
	die;
 }

add_action('wp_ajax_save_post_like', 'circleflip_save_like_post_meta');
add_action('wp_ajax_nopriv_save_post_like', 'circleflip_save_like_post_meta');

function circleflip_cp_loadmore() {
	add_filter( 'circleflip_post_format_gallery_html', 'circleflip_gallery_circleformat', 10, 5 );
	add_filter( 'circleflip_post_format_video_html'   , 'circleflip_video_circleformat', 10, 5 );
	add_filter( 'circleflip_post_format_standard_html'   , 'circleflip_standard_circleformat', 10, 5 );
	add_filter( 'circleflip_post_format_audio_html'   , 'circleflip_audio_circleformat', 10, 5 );
	add_filter( 'circleflip_post_format_media_size',  'circleflip_full_video_size', 10, 5);
	add_filter('circleflip_post_format_meta', 'circleflip_gallery_layout',10,5);
	$post_or_portfolio = isset( $_POST['post_or_portfolio'] ) && 'portfolio' == $_POST['post_or_portfolio'] ?
			'circleflip-portfolio' : 'post';
	$cat_key = 'post' == $post_or_portfolio ? 'cat' : 'tax_query';
	if ( 'circleflip-portfolio' == $post_or_portfolio) {
		$tax_query = array(
			array(
				'taxonomy' => 'circleflip-portfolio-cats',
				'field' => 'id',
				'terms' => isset( $_POST['cat_id'] ) ? explode(',', $_POST['cat_id'] ) : array(),
			),
		);
	} else {
		$tax_query = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
	}
	switch ($_POST['post_type']) {
			// Latest
			case '0':
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
			// Popular
			case '1':
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						'post_type' => $post_or_portfolio,
	                    'orderby' => 'post__in',
	                    'post_status' => 'publish',
	                    $cat_key => $tax_query,
	                    'post__in' =>$wpdb->get_col("SELECT post_id, COUNT(*) as total FROM views_count WHERE 1 = 1 GROUP BY post_id ORDER BY total $post_order"),
	                    'paged' => $_POST['pageNumber'],
	                    'order' => 'DESC'
					);
				break;
			default:
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => 'post',
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
		}
		if ( empty( $_POST['cat_id'] ) ) {
			unset( $args[$cat_key] );
		}
		$output = circleflip_query($args);
		foreach($output as $post){
			if (has_post_thumbnail($post->ID)) {
				$image_id = get_post_thumbnail_id($post->ID);
				$image_attributes = wp_get_attachment_image_src($image_id,'circle-posts');
				$image =  '<div class="circleAnimationImage" style="background-image: url('.$image_attributes[0].')"></div>';
			} else {
				 $image =  '<div class="circleAnimationImage" style="background-image: url('.cr_get_option('post_default','').')"></div>';
			}
			$post -> postData   =  '<div class="'.$_POST['layout'].' circlePost animate_CF"><div class="circleAnimation '.$_POST['animation'].'">'.$image.'<div class="circleAnimation '.$_POST['animation'].'">'.circleflip_get_post_format_media( $post->ID, 'circle-posts', 'my_unique_circle_posts' ).'</div></div></div>';
			}

		echo json_encode($output);
	die();
}
add_action('wp_ajax_circle_posts_loadmore', 'circleflip_cp_loadmore');
add_action('wp_ajax_nopriv_circle_posts_loadmore', 'circleflip_cp_loadmore');

function circleflip_rp_loadmore() {
	add_filter( 'circleflip_post_format_gallery_html', 'circleflip_gallery_squareformat', 10, 5 );
	add_filter( 'circleflip_post_format_standard_html', 'circleflip_standard_squareformat', 10, 5 );
	add_filter( 'circleflip_post_format_video_html'   , 'circleflip_video_squareformat', 10, 5 );
	add_filter( 'circleflip_post_format_media_size', 'circleflip_full_video_size', 10, 5);

	add_filter('circleflip_post_format_meta', 'circleflip_gallery_layout',10,5);
	$post_or_portfolio = isset( $_POST['post_or_portfolio'] ) && 'portfolio' == $_POST['post_or_portfolio'] ?
				'circleflip-portfolio' : 'post';
	$cat_key = 'post' == $post_or_portfolio ? 'cat' : 'tax_query';
	if ( 'circleflip-portfolio' == $post_or_portfolio) {
		$tax_query = array(
			array(
				'taxonomy' => 'circleflip-portfolio-cats',
				'field' => 'id',
				'terms' => isset( $_POST['cat_id'] ) ? explode(',', $_POST['cat_id'] ) : array(),
			),
		);
	} else {
		$tax_query = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
	}
	switch ($_POST['post_type']) {
			// Latest
			case '0':
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
						//'posts_per_archive_page' => $posts_per_page

					);
				break;
			// Popular
			case '1':
				global $wpdb;
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						'post_type' => $post_or_portfolio,
	                    'orderby' => 'post__in',
	                    'post_status' => 'publish',
	                    $cat_key => $tax_query,
	                    'post__in' =>$wpdb->get_col("SELECT post_id, COUNT(*) as total FROM views_count WHERE 1 = 1 GROUP BY post_id ORDER BY total $post_order"),
	                    'paged' => $_POST['pageNumber'],
	                    'order' => 'DESC'
					);
				break;
			default:
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
						//'posts_per_archive_page' => $posts_per_page

					);
				break;
		}
		if ( empty( $_POST['cat_id'] ) ) {
			unset( $args[$cat_key] );
		}
			 $output = circleflip_query($args);
			 foreach ($output as $post) : setup_postdata($post);
			 $text = strip_tags($post->post_content);
			 $post -> postData   = '
					<div class="'.$_POST['layout'].' squarePost">'
							.circleflip_get_post_format_media( $post->ID, 'recent_home_posts', 'my_unique_square_posts' ). '
						<a href="'.$post->guid.'"><p class="squarePostTitle">'.$post->post_title.'</p></a>
						<p class="squarePostText">
							'.circleflip_string_limit_characters($text,140).'
						</p>
					</div> ';
				endforeach;
		echo json_encode($output);
		die;
}
add_action('wp_ajax_recent_posts_loadmore', 'circleflip_rp_loadmore');
add_action('wp_ajax_nopriv_recent_posts_loadmore', 'circleflip_rp_loadmore');
function circleflip_portfolio_loadmore() {
add_filter( 'circleflip_post_format_gallery_html',  'circleflip_gallery_portfolioformat', 10, 5 );
		add_filter( 'circleflip_post_format_standard_html','circleflip_standard_portfolioformat', 10, 5 );
		add_filter( 'circleflip_post_format_video_html'   ,'circleflip_video_portfolioformat', 10, 5 );
		add_filter( 'circleflip_post_format_audio_html'   ,'circleflip_audio_portfolioformat', 10, 5 );
		add_filter( 'circleflip_post_format_media_size','circleflip_full_video_size', 10, 5);
		add_filter('circleflip_post_format_meta','circleflip_gallery_layout',10,5);
		/*
		 * Latest Posts - Popular - Selected Posts
		 * Blog Posts - Portfolio
		 * with Latest or Popular (Selected Categories Multiple Select)
		 * Order -> Ascending or descending
		 * Number of Posts
		 */
		$post_or_portfolio = isset( $_POST['post_or_portfolio'] ) && 'portfolio' == $_POST['post_or_portfolio'] ?
			'circleflip-portfolio' : 'post';
		$cat_key = 'post' == $post_or_portfolio ? 'cat' : 'tax_query';
		if ( 'circleflip-portfolio' == $post_or_portfolio) {
			$tax_query = array(
				array(
					'taxonomy' => 'circleflip-portfolio-cats',
					'field' => 'id',
					'terms' => isset( $_POST['cat_id'] ) ? explode(',', $_POST['cat_id'] ) : array(),
				),
			);
		} else {
			$tax_query = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
		}
		switch ($_POST['post_type']) {
			// Latest
			case '0':
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
			// Popular
			case '1':
				global $wpdb;
					$args = array(

						'posts_per_page' => $_POST['postsnumber'],
						'post_type' => $post_or_portfolio,
	                    'orderby' => 'post__in',
	                    'post_status' => 'publish',
	                    $cat_key => $tax_query,
	                    'post__in' =>$wpdb->get_col("SELECT post_id, COUNT(*) as total FROM views_count WHERE 1 = 1 GROUP BY post_id ORDER BY total $post_order"),
	                    'paged' => $_POST['pageNumber'],
	                    'order' => 'DESC'
					);
				break;
			default:
				$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
		}
		if ( empty( $_POST['cat_id'] ) ) {
			unset( $args[$cat_key] );
		}
		$output = circleflip_query($args);
		switch ($_POST['layout']) {
			case 'span4':
				$image_size = 'recent_home_posts_two';
			break;
			case 'span3':
				$image_size = 'recent_home_posts';
				break;
			default:
				$image_size = 'recent_home_posts_two';
				break;
		}
		foreach($output as $post){

			 $src = '';$image_recent='';
				if ( has_post_thumbnail( $post->ID ) ) {
					$post_img = wp_get_attachment_image($post->ID, $image_size);
				  } else {
					if($image_size == 'recent_home_posts_two') {
						$width = '367';
						$height = '195';
					 } else {
						$width = '270';
						$height = '150';
					 }
					 $post_img = circleflip_get_default_image( $image_size );
					}
				 $post -> postData   = '
					<div class="'.$_POST['layout'].' portfolioHome">
						<div class="portfolioHomeImg">
								'.$post_img. circleflip_get_post_format_media( $post->ID, $image_size, 'my_unique_portfolio_posts' ).'
						</div>
					</div>';
				 }
		echo json_encode($output);
	die();
}
add_action('wp_ajax_portfolio_posts_loadmore', 'circleflip_portfolio_loadmore');
add_action('wp_ajax_nopriv_portfolio_posts_loadmore', 'circleflip_portfolio_loadmore');


function circleflip_squarered_loadmore() {
		add_filter( 'circleflip_post_format_gallery_html',  'circleflip_gallery_squareredformat', 10, 5 );
		add_filter( 'circleflip_post_format_standard_html','circleflip_standard_squareredformat', 10, 5 );
		add_filter( 'circleflip_post_format_video_html'   ,'circleflip_video_squareredformat', 10, 5 );
		add_filter( 'circleflip_post_format_audio_html'   ,'circleflip_audio_squareredformat', 10, 5 );
		add_filter( 'circleflip_post_format_media_size','circleflip_full_video_size', 10, 5);
		add_filter('circleflip_post_format_meta','circleflip_gallery_layout',10,5);
		/*
		 * Latest Posts - Popular - Selected Posts
		 * Blog Posts - Portfolio
		 * with Latest or Popular (Selected Categories Multiple Select)
		 * Order -> Ascending or descending
		 * Number of Posts
		 */
		$post_or_portfolio = isset( $_POST['post_or_portfolio'] ) && 'portfolio' == $_POST['post_or_portfolio'] ?
			'circleflip-portfolio' : 'post';
		$cat_key = 'post' == $post_or_portfolio ? 'cat' : 'tax_query';
		if ( 'circleflip-portfolio' == $post_or_portfolio) {
			$tax_query = array(
				array(
					'taxonomy' => 'circleflip-portfolio-cats',
					'field' => 'id',
					'terms' => isset( $_POST['cat_id'] ) ? explode(',', $_POST['cat_id'] ) : array(),
				),
			);
		} else {
			$tax_query = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
		}
		switch ($_POST['post_type']) {
			// Latest
			case '0':
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
			// Popular
			case '1':
				global $wpdb;
					$args = array(

						'posts_per_page' => $_POST['postsnumber'],
						'post_type' => $post_or_portfolio,
	                    'orderby' => 'post__in',
	                    'post_status' => 'publish',
	                    $cat_key => $tax_query,
	                    'post__in' =>$wpdb->get_col("SELECT post_id, COUNT(*) as total FROM views_count WHERE 1 = 1 GROUP BY post_id ORDER BY total $post_order"),
	                    'paged' => $_POST['pageNumber'],
	                    'order' => 'DESC'
					);
				break;
			default:
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
		}
		if ( empty( $_POST['cat_id'] ) ) {
			unset( $args[$cat_key] );
		}
		$output = circleflip_query($args);
		switch ($_POST['layout']) {
			case 'span4':
				$image_size = 'recent_home_posts_two';
			break;
			case 'span3':
				$image_size = 'recent_home_posts';
				break;
			default:
				$image_size = 'recent_home_posts_two';
				break;
		}
		foreach($output as $post){
			 $post -> postData   = '
				<li class="'.$_POST['layout'].' circleflip-portfolio item">
							'. circleflip_get_post_format_media( $post->ID, $image_size, 'my_unique_squarered_posts' ).'
				</li>';
			 }
		echo json_encode($output);
	die();
}
add_action('wp_ajax_squarered_posts_loadmore', 'circleflip_squarered_loadmore');
add_action('wp_ajax_nopriv_squarered_posts_loadmore', 'circleflip_squarered_loadmore');

function circleflip_mag1_loadmore() {
		add_filter( 'circleflip_post_format_standard_html','circleflip_standard_mag1format', 10, 5 );
		add_filter( 'circleflip_post_format_gallery_html',  'circleflip_standard_mag1format', 10, 5 );
		add_filter( 'circleflip_post_format_video_html'   ,'circleflip_standard_mag1format', 10, 5 );
		add_filter( 'circleflip_post_format_audio_html'   ,'circleflip_standard_mag1format', 10, 5 );
		add_filter( 'circleflip_post_format_media_size','circleflip_standard_mag1format', 10, 5);
		add_filter('circleflip_post_format_meta','circleflip_standard_mag1format',10,5);
		/*
		 * Latest Posts - Popular - Selected Posts
		 * Blog Posts - Portfolio
		 * with Latest or Popular (Selected Categories Multiple Select)
		 * Order -> Ascending or descending
		 * Number of Posts
		 */
		$post_or_portfolio = isset( $_POST['post_or_portfolio'] ) && 'portfolio' == $_POST['post_or_portfolio'] ?
			'circleflip-portfolio' : 'post';
		$cat_key = 'post' == $post_or_portfolio ? 'cat' : 'tax_query';
		if ( 'circleflip-portfolio' == $post_or_portfolio) {
			$tax_query = array(
				array(
					'taxonomy' => 'circleflip-portfolio-cats',
					'field' => 'id',
					'terms' => isset( $_POST['cat_id'] ) ? explode(',', $_POST['cat_id'] ) : array(),
				),
			);
		} else {
			$tax_query = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
		}
		switch ($_POST['post_type']) {
			// Latest
			case '0':
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
			// Popular
			case '1':
				global $wpdb;
					$args = array(

						'posts_per_page' => $_POST['postsnumber'],
						'post_type' => $post_or_portfolio,
	                    'orderby' => 'post__in',
	                    'post_status' => 'publish',
	                    $cat_key => $tax_query,
	                    'post__in' =>$wpdb->get_col("SELECT post_id, COUNT(*) as total FROM views_count WHERE 1 = 1 GROUP BY post_id ORDER BY total $post_order"),
	                    'paged' => $_POST['pageNumber'],
	                    'order' => 'DESC'
					);
				break;
			default:
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
		}
		if ( empty( $_POST['cat_id'] ) ) {
			unset( $args[$cat_key] );
		}
		$output = circleflip_query($args);
		switch ($_POST['layout']) {
			case 'span4':
				$image_size = 'thumbnail';
			break;
			case 'span3':
				$image_size = 'thumbnail';
				break;
			case 'span6':
				$image_size = 'thumbnail';
				break;
			default:
				$image_size = 'thumbnail';
				break;
		}
		foreach($output as $post){
			 $post -> postData   = '
				<div class="'.$_POST['layout'].'  magazinePost magazinePost1">
							'. circleflip_get_post_format_media( $post->ID, $image_size, 'my_unique_mag1_posts' ).'
				</div>';
			 }
		echo json_encode($output);
	die();
}
add_action('wp_ajax_mag1_posts_loadmore', 'circleflip_mag1_loadmore');
function circleflip_mag2_loadmore() {
		add_filter( 'circleflip_post_format_standard_html','circleflip_standard_mag2format', 10, 5 );
		add_filter( 'circleflip_post_format_gallery_html',  'circleflip_standard_mag2format', 10, 5 );
		add_filter( 'circleflip_post_format_video_html'   ,'circleflip_standard_mag2format', 10, 5 );
		add_filter( 'circleflip_post_format_audio_html'   ,'circleflip_standard_mag2format', 10, 5 );
		add_filter( 'circleflip_post_format_media_size','circleflip_standard_mag2format', 10, 5);
		add_filter('circleflip_post_format_meta','circleflip_standard_mag2format',10,5);
		/*
		 * Latest Posts - Popular - Selected Posts
		 * Blog Posts - Portfolio
		 * with Latest or Popular (Selected Categories Multiple Select)
		 * Order -> Ascending or descending
		 * Number of Posts
		 */
		$post_or_portfolio = isset( $_POST['post_or_portfolio'] ) && 'portfolio' == $_POST['post_or_portfolio'] ?
			'circleflip-portfolio' : 'post';
		$cat_key = 'post' == $post_or_portfolio ? 'cat' : 'tax_query';
		if ( 'circleflip-portfolio' == $post_or_portfolio) {
			$tax_query = array(
				array(
					'taxonomy' => 'circleflip-portfolio-cats',
					'field' => 'id',
					'terms' => isset( $_POST['cat_id'] ) ? explode(',', $_POST['cat_id'] ) : array(),
				),
			);
		} else {
			$tax_query = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
		}
		switch ($_POST['post_type']) {
			// Latest
			case '0':
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
			// Popular
			case '1':
				global $wpdb;
					$args = array(

						'posts_per_page' => $_POST['postsnumber'],
						'post_type' => $post_or_portfolio,
	                    'orderby' => 'post__in',
	                    'post_status' => 'publish',
	                    $cat_key => $tax_query,
	                    'post__in' =>$wpdb->get_col("SELECT post_id, COUNT(*) as total FROM views_count WHERE 1 = 1 GROUP BY post_id ORDER BY total $post_order"),
	                    'paged' => $_POST['pageNumber'],
	                    'order' => 'DESC'
					);
				break;
			default:
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
		}
		if ( empty( $_POST['cat_id'] ) ) {
			unset( $args[$cat_key] );
		}
		$output = circleflip_query($args);
		switch ($_POST['layout']) {
			case 'span4':
				$image_size = 'thumbnail';
			break;
			case 'span3':
				$image_size = 'thumbnail';
				break;
			case 'span6':
				$image_size = 'thumbnail';
				break;
			default:
				$image_size = 'thumbnail';
				break;
		}
		foreach($output as $post){
			 $post -> postData   = '
				<div class="'.$_POST['layout'].'  magazinePost magazinePost2">
							'. circleflip_get_post_format_media( $post->ID, $image_size, 'my_unique_mag2_posts' ).'
				</div>';
			 }
		echo json_encode($output);
	die();
}
add_action('wp_ajax_mag2_posts_loadmore', 'circleflip_mag2_loadmore');
function circleflip_mag3_loadmore() {
		add_filter( 'circleflip_post_format_standard_html','circleflip_standard_mag3format', 10, 5 );
		add_filter( 'circleflip_post_format_gallery_html',  'circleflip_standard_mag3format', 10, 5 );
		add_filter( 'circleflip_post_format_video_html'   ,'circleflip_standard_mag3format', 10, 5 );
		add_filter( 'circleflip_post_format_audio_html'   ,'circleflip_standard_mag3format', 10, 5 );
		add_filter( 'circleflip_post_format_media_size','circleflip_standard_mag3format', 10, 5);
		add_filter('circleflip_post_format_meta','circleflip_standard_mag3format',10,5);
		/*
		 * Latest Posts - Popular - Selected Posts
		 * Blog Posts - Portfolio
		 * with Latest or Popular (Selected Categories Multiple Select)
		 * Order -> Ascending or descending
		 * Number of Posts
		 */
		$post_or_portfolio = isset( $_POST['post_or_portfolio'] ) && 'portfolio' == $_POST['post_or_portfolio'] ?
			'circleflip-portfolio' : 'post';
		$cat_key = 'post' == $post_or_portfolio ? 'cat' : 'tax_query';
		if ( 'circleflip-portfolio' == $post_or_portfolio) {
			$tax_query = array(
				array(
					'taxonomy' => 'circleflip-portfolio-cats',
					'field' => 'id',
					'terms' => isset( $_POST['cat_id'] ) ? explode(',', $_POST['cat_id'] ) : array(),
				),
			);
		} else {
			$tax_query = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
		}
		switch ($_POST['post_type']) {
			// Latest
			case '0':
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
			// Popular
			case '1':
				global $wpdb;
					$args = array(

						'posts_per_page' => $_POST['postsnumber'],
						'post_type' => $post_or_portfolio,
	                    'orderby' => 'post__in',
	                    'post_status' => 'publish',
	                    $cat_key => $tax_query,
	                    'post__in' =>$wpdb->get_col("SELECT post_id, COUNT(*) as total FROM views_count WHERE 1 = 1 GROUP BY post_id ORDER BY total $post_order"),
	                    'paged' => $_POST['pageNumber'],
	                    'order' => 'DESC'
					);
				break;
			default:
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
		}
		if ( empty( $_POST['cat_id'] ) ) {
			unset( $args[$cat_key] );
		}
		$output = circleflip_query($args);
		switch ($_POST['layout']) {
			case 'span4':
				$layout = 'span4';
				$image_size = 'recent_home_posts_two';
			break;
			case 'span3':
				$layout = 'span3';
				$image_size = 'recent_home_posts';
				break;
			case 'span6':
				$layout = 'span6';
				$image_size = 'magazine_half';
				break;
			default:
				$layout = 'span4';
				$image_size = 'recent_home_posts_two';
				break;
		}
		foreach($output as $post){
			 $post -> postData   = '
				<div class="'.$_POST['layout'].'  magazinePost magazinePost3">
							'. circleflip_get_post_format_media( $post->ID, $image_size, 'my_unique_mag3_posts' ).'
				</div>';
			 }
		echo json_encode($output);
	die();
}
add_action('wp_ajax_mag3_posts_loadmore', 'circleflip_mag3_loadmore');
function circleflip_mag4_loadmore() {
		add_filter( 'circleflip_post_format_standard_html','circleflip_standard_mag4format', 10, 5 );
		add_filter( 'circleflip_post_format_gallery_html',  'circleflip_standard_mag4format', 10, 5 );
		add_filter( 'circleflip_post_format_video_html'   ,'circleflip_standard_mag4format', 10, 5 );
		add_filter( 'circleflip_post_format_audio_html'   ,'circleflip_standard_mag4format', 10, 5 );
		add_filter( 'circleflip_post_format_media_size','circleflip_standard_mag4format', 10, 5);
		add_filter('circleflip_post_format_meta','circleflip_standard_mag4format',10,5);
		/*
		 * Latest Posts - Popular - Selected Posts
		 * Blog Posts - Portfolio
		 * with Latest or Popular (Selected Categories Multiple Select)
		 * Order -> Ascending or descending
		 * Number of Posts
		 */
		$post_or_portfolio = isset( $_POST['post_or_portfolio'] ) && 'portfolio' == $_POST['post_or_portfolio'] ?
			'circleflip-portfolio' : 'post';
		$cat_key = 'post' == $post_or_portfolio ? 'cat' : 'tax_query';
		if ( 'circleflip-portfolio' == $post_or_portfolio) {
			$tax_query = array(
				array(
					'taxonomy' => 'circleflip-portfolio-cats',
					'field' => 'id',
					'terms' => isset( $_POST['cat_id'] ) ? explode(',', $_POST['cat_id'] ) : array(),
				),
			);
		} else {
			$tax_query = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
		}
		switch ($_POST['post_type']) {
			// Latest
			case '0':
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
			// Popular
			case '1':
				global $wpdb;
					$args = array(

						'posts_per_page' => $_POST['postsnumber'],
						'post_type' => $post_or_portfolio,
	                    'orderby' => 'post__in',
	                    'post_status' => 'publish',
	                    $cat_key => $tax_query,
	                    'post__in' =>$wpdb->get_col("SELECT post_id, COUNT(*) as total FROM views_count WHERE 1 = 1 GROUP BY post_id ORDER BY total $post_order"),
	                    'paged' => $_POST['pageNumber'],
	                    'order' => 'DESC'
					);
				break;
			default:
					$args = array(
						'posts_per_page' => $_POST['postsnumber'],
						$cat_key => $tax_query,
						'post_type' => $post_or_portfolio,
						'orderby' => 'date',
						'order' => 'DESC',
						'paged' => $_POST['pageNumber'],
						'post_status' => 'publish'
					);
				break;
		}
		if ( empty( $_POST['cat_id'] ) ) {
			unset( $args[$cat_key] );
		}
		$output = circleflip_query($args);
		switch ($_POST['layout']) {
			case 'span4':
				$layout = 'span4';
				$image_size = 'recent_home_posts_two';
			break;
			case 'span3':
				$layout = 'span3';
				$image_size = 'recent_home_posts';
				break;
			case 'span6':
				$layout = 'span6';
				$image_size = 'magazine_half';
				break;
			default:
				$layout = 'span4';
				$image_size = 'recent_home_posts_two';
				break;
		}
		foreach($output as $post){
			 $post -> postData   = '
				<div class="'.$_POST['layout'].'  magazinePost magazinePost4">
							'. circleflip_get_post_format_media( $post->ID, $image_size, 'my_unique_mag4_posts' ).'
				</div>';
			 }
		echo json_encode($output);
	die();
}
add_action('wp_ajax_mag4_posts_loadmore', 'circleflip_mag4_loadmore');
?>