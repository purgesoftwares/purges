<?php
/** header.php
 *
 * Displays Header Style 3
 *
 * @author		Creiden
 * @package		Circleflip
 * @version     1.0
 */

?>
<header id="branding" role="banner" class="headerStyle4 headerStyle3" style="height: <?php echo cr_get_option("header_height",''); ?>px;">
	<div class="container">
	<div id="menuContainer" style="height: <?php echo cr_get_option("header_height",''); ?>px;">
		<div id="logoWrapper" class="left" style="width: <?php echo cr_get_option('logo_wrapper_width'); ?>px;height: <?php echo cr_get_option('header_height'); ?>px;">
			<?php if(is_rtl()) { ?>
				<?php if(cr_get_option('rtl_theme_logo') != ''){ ?> 
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php echo esc_url( cr_get_option( 'rtl_theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
					</a>
				<?php } ?>
			<?php } else {?>
				<?php if(cr_get_option('theme_logo') != ''){ ?> 
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php echo esc_url( cr_get_option( 'theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
					</a>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="right closed navigationButton" style="margin-top: <?php echo esc_attr( (cr_get_option( "header_height", '' ) / 2) - 26 ); ?>px;">
			<span class="icon-menu-3"></span>
		</div>
	</div>
	<?php if ( get_header_image() ) : ?>
	<a id="header-image" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo circleflip_get_custom_header()->width; ?>" height="<?php echo circleflip_get_custom_header()->height; ?>" alt="" />
	</a>
	<?php endif; // if ( get_header_image() ) ?>
	<?php if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<nav id="breadcrumb" class="breadcrumb">', '</nav>' );
	}
	tha_header_bottom(); ?>
	</div>
</header><!-- #branding -->
<?php
tha_header_after();
/* End of file header.php */
?>