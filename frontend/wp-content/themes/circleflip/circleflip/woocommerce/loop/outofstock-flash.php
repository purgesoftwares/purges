<?php
/**
 * Product loop sale flash
 *
 * @author 		Creiden
 * @package 	CircleFlip
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
<?php if ( ! $product->is_in_stock() ) : ?>
	<div class="itemSale clearfix">
		<p class="onsale"> <?php _e( 'out of stock', 'woocommerce' ) ?></p>
	</div>
<?php endif; ?>