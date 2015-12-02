<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
<?php if ( $product->is_on_sale() ) : ?>
	<div class="itemSale clearfix">
		<?php echo apply_filters( 'woocommerce_sale_flash', '<p class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</p>', $post, $product ); ?>
	</div>
<?php endif; ?>