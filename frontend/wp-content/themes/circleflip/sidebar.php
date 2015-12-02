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

if (have_posts()):
	 while (have_posts()) : the_post();
	$post_custom_values = get_post_custom_values('_sidebar', $post->ID);
	if(!empty($post_custom_values) && isset($post_custom_values)) {
		$sidebar = array_shift($post_custom_values);
		$sidebars = cr_get_option('sidebars', array());
		if(circleflip_valid($sidebar) && circleflip_valid($sidebars))
		{
			if (in_array($sidebar, $sidebars)) :
				dynamic_sidebar($sidebar);
			endif;	
		}
	}
	endwhile;
endif;
	tha_sidebar_bottom(); ?>
</section><!-- #secondary .widget-area -->
<?php tha_sidebars_after();?>
<?php
/* End of file sidebar.php */
/* Location: ./wp-content/themes/circleflip/sidebar.php */