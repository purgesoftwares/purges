<?php
/** sidebar-image.php
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0	- 05.02.2012
 */

tha_sidebars_before(); ?>
<section id="secondary" class="widget-area span4" role="complementary">
	<?php
	tha_sidebar_top();
	
	if ( ! dynamic_sidebar( 'image' ) ) {
		the_widget( 'creiden_Image_Meta_Widget', array(), array(
			'before_widget'	=>	'<aside id="the-bootstrap-image-meta" class="widget the-bootstrap-image-meta">',
			'after_widget'	=>	'</aside>',
			'before_title'	=>	'<h3 class="widget-title">',
			'after_title'	=>	'</h3>',
		) );
	}
	
	tha_sidebar_bottom(); ?>
</section><!-- #secondary .widget-area -->
<?php tha_sidebars_after();


/* End of file sidebar-image.php */
/* Location: ./wp-content/themes/circleflip/sidebar-image.php */