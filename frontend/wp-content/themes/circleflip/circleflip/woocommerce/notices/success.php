<?php
/**
 * Show messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>

<?php foreach ( $messages as $message ) : ?>
	<div class="aq_alert note cf noanimation animate_CF woocommerce-message woocommerceAlert">
		<button type="button" class="close" data-dismiss="alert">&#120;</button>
		<h5><?php echo wp_kses_post( $message ); ?></h5>
	</div>
<?php endforeach; ?>
