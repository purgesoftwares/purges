<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
$two_buttons = true;
if ( 'variable' === $product->product_type ) {
	$two_buttons = false;
} else if ( 'grouped' === $product->product_type ) {
	$two_buttons = false;
} else if ( 'external' === $product->product_type ) {
	// force true, because exteranl product's is_purchasable() returns false
	$two_buttons = true;
} else if ( ! $product->is_purchasable() || ! $product->is_in_stock() ) {
	// simple product that's not purchasable or out-of-stock
	$two_buttons = false;
}
echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button addToCart flatBtn %s product_type_%s"><div class="clearfix"><span class="icon-basket-1"></span><p>%s</p></div></a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( $product->id ),
		esc_attr( $product->get_sku() ),
		($product->is_purchasable() ? 'add_to_cart_button' : '') . (! $two_buttons ? ' cf-one-button' : ''),
		esc_attr( $product->product_type ),
		esc_html( $product->add_to_cart_text() )
	),
$product );
?>
<?php if ( $two_buttons ) : ?>
	<a href="<?php the_permalink() ?>" class="itemMore flatBtn">
		<div class='clearfix'>
			<span class='icon-doc-text-1'></span>
			<p><?php _e( 'Read More', 'woocommerce' ) ?></p>
		</div>
	</a>
<?php endif; ?>