<?php

/**
 * This File is designed for our custom functions
 *
 * @since	1.0.0 - 06.23.2013
 * @author	Creiden
 */

/**
 * Simple wrapper for native get_template_part()
 * Allows you to pass in an array of parts and output them in your theme
 * e.g. <?php get_template_parts(array('part-1', 'part-2')); ?>
 *
 * @param 	array
 * @return 	void
 * @author 	Keir Whitaker
 **/
function circleflip_get_template_parts( $parts = array() ) {
	foreach( $parts as $part ) {
		get_template_part( $part );
	};
}

/**
 * Pass in a path and get back the page ID
 * e.g. get_page_id_from_path('about/terms-and-conditions');
 *
 * @param 	string
 * @return 	integer
 * @author 	Keir Whitaker
 **/
function circleflip_get_current_page_id() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	$page = get_page_by_path(str_replace(home_url(), '', $pageURL)  );
	if( $page ) {
		return $page->ID;
	} else {
		return null;
	};
}

/**
 * Get the category id from a category name
 *
 * @param 	string
 * @return 	string
 * @author 	Keir Whitaker
 */
function circleflip_get_category_id( $cat_name ){
	$term = get_term_by( 'name', $cat_name, 'category' );
	return $term->term_id;
}

function circleflip_valid($validate) {
	if(isset($validate) && !empty($validate)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function circleflip_query($arg) {
		$output = get_posts($arg);
		return $output;
}

function circleflip_end_query() {
	wp_reset_postdata();
}

function circleflip_get_number_of_views($post_id){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip=$_SERVER['HTTP_CLIENT_IP'];
		//Is it a proxy address
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		$visitor_ip = ip2long($ip);
		if(!isset($visitor_ip) || empty($visitor_ip)){
			$visitor_ip = '0';
		}
		// long2ip(ip2long($visitor_ip));
		//check if user has viewed or not
		global $wpdb;
		$visit = $wpdb->get_row("select views_count.id from views_count where post_id = {$post_id} AND visitor_ip = {$visitor_ip}");

		if(empty($visit)){
			 $wpdb->insert(
		                    'views_count', array(
		              		'post_id' => $post_id,
		                	'visitor_ip' => $visitor_ip,
		                    	)
							);
		}

		//get number of views for the post

		$total_number_of_views = $wpdb->get_var("select COUNT(*) from views_count where post_id = {$post_id}");
		return $total_number_of_views ;

}
function circleflip_read_number_of_views($post_id){
		global $wpdb;
		$number_of_views = $wpdb->get_var("select COUNT(*) from views_count where post_id = {$post_id}");
		return $number_of_views ;
}

function circleflip_get_categories() {
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	return $options_categories;
}

function circleflip_get_posts() {
	$allPosts = get_posts(array('numberposts'=>-1));
	$postNames = array();
	foreach ($allPosts as $key => $post) {
		$postNames[$post->ID]= $post->post_title . " on " . date("F j, Y g:i a",strtotime($post->post_date)). " by " . (get_user_by('id', $post->post_author)->display_name) ;
	}
	return $postNames;
}

function circleflip_string_limit_words($string, $word_limit) {
    $words = explode(' ', $string, ($word_limit + 1));
    if (count($words) > $word_limit)
    	array_pop($words);
    return implode(' ', $words);
}

function circleflip_string_limit_characters($string, $character_limit) {
	if(strlen($string) > $character_limit) {
			$string = mb_substr($string,0,$character_limit,'utf-8');
			$string = $string . ' ...';
	}
    return $string;
}

/* ========================================================================================================================

Pagination Function

======================================================================================================================== */
function circleflip_pagination($pages = '', $range = 4) {
	global $wp_query;

	$total_pages = $wp_query->max_num_pages;
	if (! $total_pages > 1) return;
	$rtlNext = '&raquo;';
	$rtlPrev = '&laquo;';
	if(cr_get_option('rtl')){
		$rtlPrev = '&raquo;';
		$rtlNext = '&laquo;';
	}
	$current_page = max(1, get_query_var('paged'));
	$big = 564897912;
	$pagination_args = array(
		// get_pagenum_link returns the correct link ( permalink or normal one )
		'base'		 => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
		'format'	 => '',
		'current'	 => $current_page,
		'total'		 => $total_pages,
		'type'		 => 'array',
		'prev_text'	 => $rtlPrev,
		'next_text'	 => $rtlNext
	);
	$links = paginate_links( $pagination_args );
	if(isset($links)&&!empty($links)){
?>
	<div class="pagination pagination-centered grid3">
		<ul>
	<?php foreach($links as $link):
		$current = (preg_match("/class=['\"][\w\s-_]*current/", $link) !== 0) ? 'class="current"' : '';
		$link = preg_replace("/class=['\"](.*?)current(.*?)['\"]/", "class=\"$1 $2\"", $link);
		$link = preg_replace("/class=['\"](.*?)['\"]/", "class=\"$1 inactive\"", $link)
	?>
		<li <?php echo $current?>><?php echo $link?></li>
	<?php endforeach; ?>
		</ul>
	</div>
		<?php }
}
function circleflip__pagination($args) {
	global $wp_query;
	$temp = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query( $args );
	if (function_exists("circleflip_pagination")) {
		circleflip_pagination();
	} else {
		wp_link_pages();
	}
	 $wp_query = $temp;
}

function circleflip_is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

/* ================================================================================== *
 *								CREIDEN GENERATE QR CODE							  *
* ================================================================================== */

if(!function_exists("circleflip_generate_qr")){
	function circleflip_generate_qr(){
		check_ajax_referer("creiden_generate_qr");
		require_once get_template_directory() . "/widgets/QR/phpqrcode/phpqrcode.php";
		$url = esc_url($_GET['url']);
		$ecc = in_array($_GET['ecc'], array("L", "M", "Q", "H")) ? $_GET['ecc'] : "L";
		QRcode::png($url, false, $ecc, 6, 2);
		die();
	}

	add_action("wp_ajax_creiden_qr", "circleflip_generate_qr");
	add_action("wp_ajax_nopriv_creiden_qr", "circleflip_generate_qr");
}

/* =========================================================================== *
 *						CRIEDEN THEMEOPTIONS CANCEL RESPONSE
 * =========================================================================== */

if(!function_exists("circleflip_cancel_options_redirect")){

	function circleflip_cancel_options_redirect($location, $status){
		if(circleflip_is_ajax()){
			$p_url = parse_url($location);
			if(isset($p_url['query'])){
				$qs = array();
				parse_str($p_url['query'], $qs);
				if(isset($qs['page']) && $qs['page'] === 'options-framework'){
					return false;
				}
			}
		}
		return $location;
	}

	add_filter("wp_redirect", "circleflip_cancel_options_redirect", 10, 2);

	function circleflip_is_ajax() {
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
				&&
				($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
	}
}

/* =========================================================================== *
								BACKUP & RESTORE
 * =========================================================================== */

if ( ! function_exists( "circleflip_backup_options" ) ) {

	function circleflip_backup_options() {
		$backup = get_option( 'rojo' );
		$backup['backup_log'] = date( 'r' );

		update_option( 'rojo_backups', $backup );
		echo $backup['backup_log'];
		die();
	}

	add_action( "wp_ajax_creiden_backup_options", "circleflip_backup_options" );

	function circleflip_restore_options() {
		$backup = get_option( 'rojo_backups' );
		update_option( 'rojo', $backup );
	}

	add_action( "wp_ajax_creiden_restore_options", "circleflip_restore_options" );
}

// retrieves the attachment ID from the file URL
function circleflip_get_image_id( $image_url ) {
	global $wpdb;
	$cache = wp_cache_get( md5( $image_url ), 'attachment_urls' );
	if ( false === $cache ) {
		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );
		$cache = ! empty( $attachment ) ? $attachment[0] : 0;
		wp_cache_add( md5( $image_url ), $cache, 'attachment_urls' );
	}
	return $cache;
}

function circleflip_get_default_image( $size = 'full' ) {
	$url = cr_get_option( 'post_default' );
	if ( $url ) {
		$id = circleflip_get_image_id( $url );
		if ( $id ) {
			return wp_get_attachment_image( $id, $size );
		}
	}
	return '';
}

/* 
 * make sure wp_is_mobile is available
 * because wp-cli (https://github.com/wp-cli/wp-cli/commit/58ea052de3090dc5738ef933fde2120ac39fe64e), stopped loading vars.php
 * and oupted for defining $pagenow their own way
 */
if ( ! function_exists( 'wp_is_mobile' ) ) {

	function wp_is_mobile() {
		static $is_mobile;

		if ( isset( $is_mobile ) )
			return $is_mobile;

		if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$is_mobile = false;
		} elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) !== false // many mobile devices (all iPhone, iPad, etc.)
				|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], 'Silk/' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], 'Kindle' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], 'BlackBerry' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' ) !== false ) {
			$is_mobile = true;
		} else {
			$is_mobile = false;
		}

		return $is_mobile;
	}

}
/**
 * Nicely format the array
 * @since	1.0.0 - 06.23.2013
 * @author	Creiden
 */

function print_a( $a ) {
	print( '<pre>' );
	print_r( $a );
	print( '</pre>' );
}