<?php
function circleflip_wc_shop_hooks() {
	// move the rating after the item thumbnail
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 25 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	
	// move add_to_cart before the title
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20 );
	
	// remove breadcrumbs , cuz we added them by direct call after the page title
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	
	// move up sells after the tabs
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	add_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 15 );
	
	// move related products after the tabs
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	add_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 20 );
	
	// don't enueue woocommerce css
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
	
	// size for masonry shop
	add_image_size( 'cf-wc-shop_catalog-masonry', 370 );
	
	add_filter( 'woocommerce_get_image_size_thumbnailGallery', 'circleflip_woocommerce_thumbnailGallery_size' );
	
	// fix Javascript dependency on wc-add-to-cart-variation
	add_action( 'woocommerce_before_template_part', 'circleflip_add_woocommerce_script_dependency', 10, 2 );
}

add_action( 'init', 'circleflip_wc_shop_hooks' );

function circleflip_wc_register_custom_functions() {
	if ( 
			( (is_shop() || is_product_category() || is_product_tag()) && ! cr_get_option( 'woocommerce_shop_sidebar', true ) ) // shop with no sidebar
			|| ( is_product() && ! cr_get_option( 'woocommerce_product_sidebar', false ) ) // single with no sidebar
	) {
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	}
	
}
add_action( 'woocommerce_before_main_content', 'circleflip_wc_register_custom_functions' );

function circleflip_wc_masonry_shop_image( $size ) {
	global $_is_cf_shop_masonry;
	if ( 'shop_catalog' === $size && (! isset( $_is_cf_shop_masonry ) || false !== $_is_cf_shop_masonry) && cr_get_option( 'woocommerce_masonry' ) ) {
		$size = 'cf-wc-shop_catalog-masonry';
	}
	return $size;
}
add_filter( 'post_thumbnail_size', 'circleflip_wc_masonry_shop_image' );

function circleflip_wc_shop_columns( $columns ) {
	if ( cr_get_option( 'woocommerce_shop_sidebar' ) )
		return 2;
	return 3;
}
add_filter( 'loop_shop_columns', 'circleflip_wc_shop_columns' );

function circleflip_wc_shop_catalog_size( $size ) {
	return array(
		'width'	 => 370,
		'height' => 270,
		'crop'	 => 1
	);
}
add_filter( 'woocommerce_get_image_size_shop_catalog', 'circleflip_wc_shop_catalog_size' );

function circleflip_wc_shop_single_size( $size ) {
	return array(
		'width'	 => 368,
		'height' => null,
		'crop'	 => 1
	);
}
add_filter( 'woocommerce_get_image_size_shop_single', 'circleflip_wc_shop_single_size' );

function circleflip_wc_shop_thumbnail_size( $size ) {
	return array(
		'width'	 => 115,
		'height' => 115,
		'crop'	 => 1
	);
}
add_filter( 'woocommerce_get_image_size_shop_thumbnail', 'circleflip_wc_shop_thumbnail_size' );

function circleflip_wc_mini_cart( $args = array() ) {
	
	?>
	<div id="cf-mini-cart" class="cart-dropdown <?php echo ( sizeof( WC()->cart->get_cart() ) > 0 ) ? 'cart-has-items' : 'cart-is-empty' ?>">
		<div class="cart-dropdown-header">
			<span class="icon-basket-1"></span>
		</div>
		<div class="cart-dropdown-elements">
			<?php woocommerce_mini_cart( $args ) ?>
		</div>
	</div>
	<?php
}

function circleflip_wc_mini_cart_fragment( $fragments ) {
	ob_start();
	circleflip_wc_mini_cart();
	$mini_cart = ob_get_clean();
	$fragments['div#cf-mini-cart'] = $mini_cart;
	return $fragments;
}
add_filter( 'add_to_cart_fragments', 'circleflip_wc_mini_cart_fragment' );

function circleflip_wc_mini_cart_in_menu( $items, $args ) {
	if ( isset($args->theme_location) && 'footer-menu' == $args->theme_location) {
		return $items;
	}
	if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
		ob_start();
		circleflip_wc_mini_cart();
		$items .= '<li>' . ob_get_clean() . '</li>';
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'circleflip_wc_mini_cart_in_menu', 10, 2 );

function circleflip_wc_out_of_stock_flash() {
	wc_get_template( 'loop/outofstock-flash.php' );
}
add_action( 'woocommerce_before_shop_loop_item_title', 'circleflip_wc_out_of_stock_flash' );


function circleflip_woocommerce_thumbnailGallery_size( $size ) {
	return array(
		'width'	 => '70',
		'height' => '70',
		'crop'	 => 1
	);
}

/** add 'wc-add-to-cart-variation' script as a dependency for 'circleflip-site'.
 * 
 * ensures that $variation_form variable is defined before site.js is called.
 * 
 * @since 1.3.4
 * @global WP_Scripts $wp_scripts
 */
function circleflip_add_woocommerce_script_dependency( $template_name ) {
	global $wp_scripts;

	if ( ! function_exists( 'is_product' ) || ! is_product() || 'single-product/add-to-cart/variable.php' !== $template_name ) {
		return;
	}

	$circleflip_site_script = $wp_scripts->query( 'circleflip-site' );
	
	if ( $circleflip_site_script instanceof _WP_Dependency && $wp_scripts->query( 'wc-add-to-cart-variation' ) ) {
		$circleflip_site_script->deps[] = 'wc-add-to-cart-variation';
	}
}