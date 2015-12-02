<?php
/** sidebar.php
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0	- 05.02.2012
 */

tha_sidebars_before(); ?>
<section id="secondary" class="widget-area span4" role="complementary">
	<?php tha_sidebar_top();

	if (is_active_sidebar('shop')) :
			dynamic_sidebar('shop');
	endif;
	tha_sidebar_bottom(); ?>
</section><!-- #secondary .widget-area -->
<?php tha_sidebars_after();?>
<?php
/* End of file sidebar.php */
/* Location: ./wp-content/themes/circleflip/sidebar.php */