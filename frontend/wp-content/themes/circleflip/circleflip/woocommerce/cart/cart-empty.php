<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

?>
<div class="container">
<h5 class="cart-empty"><?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?></h5>

<?php do_action( 'woocommerce_cart_is_empty' ); ?>
	<p class="return-to-shop grid2">
		<a class="button wc-backward btnStyle1 btnLarge withIcon red" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
			<span class="icon-basket btnIcon"></span>
			<span><?php _e( 'Return To Shop', 'woocommerce' ) ?></span>
			<span class="btnAfter"></span>
			<span class="btnBefore"></span>
		</a>
	</p>
</div>