<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>
<?php global $_is_cf_shop_masonry ?>
<div class="row">
	<ul class="products<?php if ( (! isset( $_is_cf_shop_masonry ) || false !== $_is_cf_shop_masonry) && cr_get_option( 'woocommerce_masonry' ) ) : ?> cf-masonry-container<?php endif ?>">
	