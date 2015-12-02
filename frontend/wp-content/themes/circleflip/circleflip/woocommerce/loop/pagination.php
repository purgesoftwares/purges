<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wp_query;

if ( $wp_query->max_num_pages <= 1 )
	return;
?>
<nav class="woocommerce-pagination pagination pagination-centered grid3">
	<?php
	/*@todo handle rtl*/
	$links = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base' 			=> str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
			'format' 		=> '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '&larr;',
			'next_text' 	=> '&rarr;',
			'type'			=> 'array',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) ) );
	?>
	
		<ul>
			<?php foreach($links as $link):
				$current = (preg_match("/class=['\"][\w\s-_]*current/", $link) !== 0) ? 'class="current"' : '';
				$link = preg_replace("/class=['\"](.*?)current(.*?)['\"]/", "class=\"$1 $2\"", $link);
				$link = preg_replace("/class=['\"](.*?)['\"]/", "class=\"$1 inactive\"", $link)
			?>
			<li <?php echo $current?>><?php echo $link?></li>
		<?php endforeach; ?>
		</ul>
</nav>