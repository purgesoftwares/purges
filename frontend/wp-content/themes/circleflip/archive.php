<?php
/** archive.php
 *
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0 - 07.02.2012
 */

get_header(); ?>

	<div class="mainPageTitle">
		<div class="colorContainer">
			<div class="container">
				<h1>
					<?php
					if ( is_day() ) :
						echo esc_html( sprintf( __( 'Daily Archives: %s', 'circleflip' ), get_the_date() ) );
					elseif ( is_month() ) :
						echo esc_html( sprintf( __( 'Monthly Archives: %s', 'circleflip' ), get_the_date( 'F Y' ) ) );
					elseif ( is_year() ) :
						echo esc_html( sprintf( __( 'Yearly Archives: %s', 'circleflip' ), get_the_date( 'Y' ) ) );
					else :
						esc_html_e( 'Blog Archives', 'circleflip' );
					endif; ?>
				</h1>
			</div>
		</div>
	</div>
	<?php if ( have_posts() ) : ?>
		<div class="container">
			<div class="row">
				<?php $position_class = cr_get_option('tags_layout','right');
					  $sidebarClass = '';
					if($position_class == 'right' ||  $position_class == 'left'){ 
						if($position_class == 'right'){
							$sidebarClass = 'left';
						}else{
							$sidebarClass = 'right';
						}
						
						?>
				<section class="span9 <?php echo esc_attr( $sidebarClass ) ?>">
					<?php }else{ ?>
						<section class="span12">
					<?php }
				 ?>
					<div id="content" role="main">
						<?php 
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
		
						?>
					</div>
				</section>
				<?php if($position_class == 'left' || $position_class == 'right') { ?>
				<section class="span3"> 
					<aside class="sidebar <?php echo esc_attr( $position_class ); ?>">
						<ul>
							<?php dynamic_sidebar(cr_get_option('tags_sidebar')); ?>
						</ul>
					</aside>
				</section>
				<?php } ?>
			</div>
		</div>
	<?php else :
		get_template_part( '/partials/content', 'not-found' );
	endif;
	?>

<?php
get_footer();


/* End of file archive.php */
/* Location: ./wp-content/themes/circleflip/archive.php */