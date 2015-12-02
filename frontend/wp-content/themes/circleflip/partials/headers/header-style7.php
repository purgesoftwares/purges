<?php
/** header.php
 *
 * Displays Header Style 7
 *
 * @author		Creiden
 * @package		Circleflip
 * @version     1.0
 */

?>
<div id="overlaySlider">
	<div class="headerSlider">
		<?php echo do_shortcode(cr_get_option('overlayheader_slider','')); ?>
	</div>
	<header id="branding" role="banner" class="headerStyle2 headerStyle7 mainHeader">
			<div class="menuContainer">
				<div id="logoWrapper" style="width: <?php echo cr_get_option('logo_wrapper_width'); ?>px;height: <?php echo cr_get_option('header_height'); ?>px;">
					<?php if(is_rtl()) { ?>
						<?php if(cr_get_option('rtl_theme_logo') != ''){ ?> 
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<img src="<?php echo esc_url( cr_get_option( 'rtl_theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
							</a>
						<?php } ?>
					<?php } else {?>
						<?php if(cr_get_option('theme_logo') != ''){ ?> 
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<img src="<?php echo esc_url(cr_get_option('theme_logo')); ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo esc_attr(cr_get_option('logo_width')); ?>" height="<?php echo esc_attr(cr_get_option('logo_height')); ?>" style="left:<?php echo esc_attr(cr_get_option('logo_left')); ?>px;top: <?php echo esc_attr(cr_get_option('logo_top')); ?>px;"/>
							</a>
						<?php } ?>
					<?php } ?>
				</div>
			<?php if ( has_nav_menu( 'primary' )) : ?>
				<div class="menuButtonResponsive">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-menu"></span>
					</a>
				</div>
			</div>
			<div class="menuWrapper">
				<div <?php circleflip_navbar_class(); ?>>
					<div class="navbar-inner">
						<div class="container">
							<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
							
							<div class="navCollapse">
								<?php wp_nav_menu( array(
									'theme_location'	=>	'primary',
									'menu_class'		=>	'nav right',
									'depth'				=>	13,
									'fallback_cb'		=>	false,
									'walker'			=>	new Circleflip_Nav_Walker,
								) );
								?>
						    </div>
						</div>
					</div>
				</div>
			</div>
			<?php else : ?>
			</div>
			<?php endif; ?>
		<?php if ( get_header_image() ) : ?>
		<a id="header-image" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo circleflip_get_custom_header()->width; ?>" height="<?php echo circleflip_get_custom_header()->height; ?>" alt="" />
		</a>
		<?php endif; // if ( get_header_image() )
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<nav id="breadcrumb" class="breadcrumb">', '</nav>' );
		}
		tha_header_bottom(); ?>
	</header><!-- #branding -->
</div>
<?php
	tha_header_after();
	/* End of file header.php */
?>