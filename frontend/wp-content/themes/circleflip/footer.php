<?php
/** footer.php
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0	- 05.02.2012
 */
	
	tha_footer_before(); ?>
	<footer id="circleFlipFooter" role="contentinfo">
		<!-- #page-footer .clearfix -->
		<div class="container">
			<?php  if( is_active_sidebar( 'sidebar-footerwidgetarea' ) ) :?>
			<ul class="footerList row">
				<?php dynamic_sidebar( 'Footer Widget Area' );?>
			</ul>
			<?php endif; ?>
			<div id="toTop">
				<span class="icon-up-open-mini"></span>
			</div>
		</div>
		<div class="afterFooter">
			<div class="container">
				<p class="left">
					<?php echo esc_html( cr_get_option( 'copy_rights_text' ) ) ?>
				</p>
				<ul class="right">
					<?php wp_nav_menu( array(
						'container'			=>	'nav',
						'container_class'	=>	'subnav',
						'theme_location'	=>	'footer-menu',
						'menu_class'		=>	'credits nav nav-pills left',
						'depth'				=>	1,
						'fallback_cb'		=>	'',
						'walker'			=>	new Circleflip_Nav_Walker,
					) );
					?>
				</ul>
			</div>
		</div>
		<?php tha_footer_bottom(); ?>
	</footer><!-- #colophon -->
	<?php if ( cr_get_option( 'boxedlayout' ) ) {
			echo '</div><!-- .boxedLayout -->';
	} ?>
	<?php tha_footer_after(); ?>
	<?php wp_footer(); ?>
	</body>
</html>
<?php


/* End of file footer.php */
/* Location: ./wp-content/themes/circleflip/footer.php */