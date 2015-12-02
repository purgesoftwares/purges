<?php
/** author.php
 *
 * The template for displaying Author Archive pages.
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0 - 07.02.2012
 */

get_header(); ?>
<div class="mainPageTitle">
	<div class="colorContainer">
		<div class="container">
			<h1><?php echo esc_html( sprintf( __( 'Posts By: %s', 'circleflip' ), get_the_author_meta( 'display_name' ) ) ); ?></h1>
		</div>
	</div>
</div>	
<div class="container">
	<div class="row">
		<?php $position_class = cr_get_option('author_layout','right');
			  $sidebarClass = '';
			if($position_class == 'right' ||  $position_class == 'left'){ 
				if($position_class == 'right'){
					$sidebarClass = 'left';
				}else{
					$sidebarClass = 'right';
				}
				
				?>
		<section id="primary" class="span9 <?php echo esc_attr( $sidebarClass ) ?>">
			<?php }else{ ?>
				<section id="primary" class="span12">
			<?php }
		 ?>
			<?php tha_content_before(); ?>
			<div id="content" role="main">
				<?php tha_content_top();
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						get_template_part( 'partials/blog', 'layout-one' );
					}
					circleflip_content_nav( 'nav-below' );
				}
				else {
					get_template_part( '/partials/content', 'not-found' );
				}

				tha_content_bottom(); ?>
			</div><!-- #content -->
			<?php tha_content_after(); ?>
			
		</section><!-- #primary -->
		<?php if($position_class == 'left' || $position_class == 'right') { ?>
		<section class="span3"> 
			<aside class="sidebar <?php echo esc_attr( $position_class ); ?>">
				<ul>
					<?php dynamic_sidebar(cr_get_option('author_sidebar')); ?>
				</ul>
			</aside>
		</section>
		<?php }?>
	</div>
</div>
<?php
get_footer();
/* End of file template-blog.php */
/* Location: ./wp-content/themes/circleflip/_full_width.php */