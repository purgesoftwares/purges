<?php
/** header.php
 *
 * Displays Header Style 9
 *
 * @author		Creiden
 * @package		Circleflip
 * @version     1.0
 */
?>
<?php if(cr_get_option('sticky_header') == 1){
	echo '<div class="headerWrapper">';
} ?>
<header id="branding" role="banner" class="headerStyle9 mainHeader" style="height: <?php echo cr_get_option("header_height",''); ?>px;">
	<div class="container clearfix">
		<div class="clearfix" id="menuContainer" style="height: <?php echo cr_get_option("header_height",''); ?>px;">
			<div class="menuContainer">
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
								<img src="<?php echo esc_url(cr_get_option('theme_logo')); ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo esc_attr(cr_get_option('logo_width')); ?>" height="<?php echo esc_attr(cr_get_option('logo_height')); ?>" style="left:<?php echo esc_attr(cr_get_option('logo_left')); ?>px;top: <?php echo esc_attr(cr_get_option('logo_top')); ?>px;"/>
							</a>
						<?php } ?>
					<?php } ?>
				</div>
	
			<?php if ( has_nav_menu( 'primary' )) : ?>
				<div class="menuButtonResponsive">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse-main">
						<span class="icon-menu"></span>
					</a>
				</div>
			</div>
			<div <?php circleflip_navbar_class_main(); ?>>
				<div class="navbar-inner" style="height: <?php echo esc_attr( cr_get_option( "header_height", '' ) ); ?>px;">
					<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
	
					<div class="navCollapse-main navCollapse">
						<?php /* wp_nav_menu( array(
							'theme_location'	=>	'primary',
							'menu_class'		=>	'nav right',
							'depth'				=>	13,
							'fallback_cb'		=>	false,
							'walker'			=>	new Circleflip_Nav_Walker,
						) );
						*/?>
						<?php uberMenu_easyIntegrate(); ?>
				    </div>
				</div>
			</div>
			<?php endif; ?>
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
</header><!-- #branding -->
<?php if(cr_get_option('sticky_header') == 1){
		echo '</div>';
	}
tha_header_after();
/* End of file header.php */
?>