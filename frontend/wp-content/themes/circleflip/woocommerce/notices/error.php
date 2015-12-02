<?php
/**
 * Show error messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>
<div class="aq_alert warn cf noanimation animate_CF woocommerce-info woocommerceAlert">
	<button type="button" class="close" data-dismiss="alert">&#120;</button>
	<ul class="woocommerce-error">
		<?php foreach ( $messages as $message ) : ?>
			<li><p><?php echo wp_kses_post( $message ); ?></p></li>
		<?php endforeach; ?>
	</ul>
</div>