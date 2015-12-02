<?php
/**
 * Cart errors page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php wc_print_notices(); ?>

<h5><?php _e( 'There are some issues with the items in your cart (shown above). Please go back to the cart page and resolve these issues before checking out.', 'woocommerce' ) ?></h5>

<?php do_action( 'woocommerce_cart_has_errors' ); ?>
<p class="return-to-shop grid2">
	<a class="button wc-backward btnStyle1 btnLarge withIcon red" href="<?php echo get_permalink(wc_get_page_id( 'cart' ) ); ?>">
		<span class="icon-basket btnIcon"></span>
		<span><?php _e( 'Return To Cart', 'woocommerce' ) ?></span>
		<span class="btnAfter"></span>
		<span class="btnBefore"></span>
	</a>
</p>