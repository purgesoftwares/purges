<?php
/** content-image.php
 *
 * The template for displaying posts in the Image Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0 - 07.02.2012
 */


tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php tha_entry_top(); ?>
	
	<div class="entry-content clearfix">
		<?php
		the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'circleflip' ) );
		circleflip_link_pages(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php circleflip_posted_on(); ?>
	</footer><!-- .entry-footer -->
	
	<?php tha_entry_bottom(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php tha_entry_after();


/* End of file content-image.php */
/* Location: ./wp-content/themes/circleflip/partials/content-image.php */