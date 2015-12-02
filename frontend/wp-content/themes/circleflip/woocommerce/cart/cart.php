<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();

?> 
	<?php do_action( 'woocommerce_before_cart' ); ?>
	<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="cartTable shop_table cart" cellspacing="0">
		<thead>
			<tr>
				<th class="productRemove"><h5>&nbsp;</h5></th>
				<th class="productThumbnail"><h5><?php _e( 'Preview', 'woocommerce' ); ?></h5></th>
				<th class="productName"><h5><?php _e( 'Product', 'woocommerce' ); ?></h5></th>
				<th class="productPrice"><h5><?php _e( 'Price', 'woocommerce' ); ?></h5></th>
				<th class="productQuantity"><h5><?php _e( 'Quantity', 'woocommerce' ); ?></h5></th>
				<th class="productTotal"><h5><?php _e( 'Total', 'woocommerce' ); ?></h5></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="productRemove">
							<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s"><span class="icon-cancel-circled color"></span></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
							?>
						</td>

						<td class="productThumbnail">
							<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $_product->is_visible() )
									echo $thumbnail;
								else
									printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
							?>
						</td>

						<td class="productName">
							<?php
								if ( ! $_product->is_visible() )
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								else
									echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );

								// Meta data
								echo WC()->cart->get_item_data( $cart_item );

								// Backorder notification
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
									echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
							?>
						</td>

						<td class="productPrice">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td>

						<td class="productQuantity">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
							?>
						</td>

						<td class="productTotal">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_cart_contents' );
			?>
			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>

	<div class="cartNavigation clearfix">
		<?php if ( WC()->cart->coupons_enabled() ) { ?>
			<div class="applyCoupons clearfix">

				<input name="coupon_code" type="text" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" />
				<label class="btnStyle2 red">
					<span><input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" /></span>
					<span class="btnBefore"></span>
					<span class="btnAfter"></span>
				</label>
				<?php do_action('woocommerce_cart_coupon'); ?>

			</div>
		<?php } ?>

		<div class="updateCart">
			<label class="btnStyle2 red withIcon">
				<span class="btnIcon icon-cw"></span>
				<span>
					<input type="submit" class="button" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" />
				</span>
				<span class="btnBefore"></span>
				<span class="btnAfter"></span>
			</label>
		</div>
		<div class="checkoutCart">
			<label class="btnStyle2 red withIcon">
				<div class="btnIcon icon-forward-1"></div>
				<span>
					<input type="submit" class="checkout-button button alt wc-forward" name="proceed" value="<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?>" />
				</span>
				<span class="btnBefore"></span>
				<span class="btnAfter"></span>
			</label>
		</div>
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

		<?php wp_nonce_field( 'woocommerce-cart' ); ?>
	</div>	
		
	<?php do_action( 'woocommerce_after_cart_table' ); ?>

	</form>

	<div class="cart-collaterals row">

		<?php do_action( 'woocommerce_cart_collaterals' ); ?>

		<?php woocommerce_cart_totals(); ?>

		<?php woocommerce_shipping_calculator(); ?>

	</div>

	<?php do_action( 'woocommerce_after_cart' ); ?>
