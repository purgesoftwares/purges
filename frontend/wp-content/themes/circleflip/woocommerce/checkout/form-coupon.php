<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( ! WC()->cart->coupons_enabled() )
	return;

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ) );
$info_message .= ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>';
?>
<div class="checkoutCoupon">
	<div class="container">
		<div class="row">
			<?php wc_print_notice( $info_message, 'notice' ); ?>
			<div class="span12">
				<form class="checkout_coupon clearfix" method="post" style="display:none">
		
					<p class="form-row form-row-first">
						<input type="text" name="coupon_code" class="input-text" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
					</p>
		
					<p class="form-row form-row-last">
						<button type="submit" class="button btnStyle2 red" name="apply_coupon">
							<span><?php _e( 'Apply Coupon', 'woocommerce' ); ?></span>
							<span class="btnAfter"></span>
							<span class="btnBefore"></span>
						</button>
					</p>
				</form>
			</div>
		</div>
	</div>
</div>