<?php
/**
 *
 * 
 *
 * @author		Creiden
 * @package		Circleflip
 * @version     1.0
 */
?>
<?php
?>
<header id="branding" role="banner" class="defaultHeader"><!-- defaultHeader overlayedHeader <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?> -->
	<style>
		.overlayedHeader .stickyHeader.activeSticky {
			background-color: <?php echo 'white';?> !important;
		}
	</style>
	<!-- Top Header -->
	<div class="topHeader lightContent responsiveCheck stickyHeader stickyHeader1 <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?>" style="background-color: #E32831;">
		<div class="headerWrapper">
			<div class="container">
				<div class="headerRow">
					<!-- Toggled Menu -->
					<div class="headerMenu responsiveCheck headerLeft <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?>">
						<div class="toggleMenuBtn"><span class="icon-menu"></span></div>
						<div class="menuWrapper">
							<?php
							wp_nav_menu(array('theme_location' => 'header-menu', 
							'menu_class' => 'clearfix menuContent', 
							'depth' => 13, 'fallback_cb' => false, 
							'walker' => new Circleflip_Nav_Walker
							));
							?>
						</div>
					</div>
					<!-- Toggled Menu End -->
					<!-- Menu -->
					<div class="headerMenu responsiveCheck headerRight <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?>">
						<div class="toggleMenuBtn"><span class="icon-menu"></span></div>
						<div class="menuWrapper">
							<?php
							wp_nav_menu(array('theme_location' => 'header-menu', 
							'menu_class' => 'clearfix menuContent', 
							'depth' => 13, 'fallback_cb' => false, 
							'walker' => new Circleflip_Nav_Walker
							));
							?>
						</div>
					</div>
					<!-- Menu End -->
				</div>
			</div>
		</div>
		<style>
			.overlayedHeader .stickyHeader1.activeSticky {
				background-color: <?php echo '#e32831';?> !important;
			}
		</style>
	</div>
	<!-- Top Header End -->
	<!-- Top Header -->
	<div class="topHeader darkContent responsiveCheck stickyHeader stickyHeader2 justFixed <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?>" style="background-color: wheat;">
		<div class="headerWrapper">
			<div class="container">
				<div class="headerRow">
					<!-- Logo -->
					<div class="logoWrapper headerLeft" style="width: <?php echo esc_attr(cr_get_option('logo_wrapper_width')); ?>px;height: <?php echo esc_attr(cr_get_option('header_height')); ?>px;">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if(( defined( 'ICL_LANGUAGE_CODE' ) && 'ar' === ICL_LANGUAGE_CODE) ) { ?>
								<img src="<?php echo esc_url( cr_get_option( 'rtl_theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
							<?php } else {?>
								<img src="<?php echo esc_url( cr_get_option( 'theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
							<?php } ?>
						</a>
					</div>
					<!-- Logo End -->
					<!-- Header Social -->
					<div class="headerSocial headerLeft">
						<ul>
							<li class="headerFlip">
								<a href="#" target="_blank">
									<div class="back">
										<i class="icon-gplus"></i>
									</div>
									<div class="front">
										<i class="icon-gplus"></i>
									</div>
								</a>
							</li>
							<li class="headerFlip">
								<a href="#" target="_blank">
									<div class="back">
										<i class="icon-facebook"></i>
									</div>
									<div class="front">
										<i class="icon-facebook"></i>
									</div>
								</a>
							</li>
							<li class="headerFlip">
								<a href="#" target="_blank">
									<div class="back">
										<i class="icon-twitter"></i>
									</div>
									<div class="front">
										<i class="icon-twitter"></i>
									</div>
								</a>
							</li>
						</ul>
					</div>
					<!-- Header Social End -->
					<!-- Toggled Menu -->
					<div class="headerMenu responsiveCheck headerLeft <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?>">
						<div class="toggleMenuBtn"><span class="icon-menu"></span></div>
						<div class="menuWrapper">
							<?php
							wp_nav_menu(array('theme_location' => 'header-menu', 
							'menu_class' => 'clearfix menuContent', 
							'depth' => 13, 'fallback_cb' => false, 
							'walker' => new Circleflip_Nav_Walker
							));
							?>
						</div>
					</div>
					<!-- Toggled Menu End -->
					<!-- Menu -->
					<div class="headerMenu responsiveCheck headerRight <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?>">
						<div class="toggleMenuBtn"><span class="icon-menu"></span></div>
						<div class="menuWrapper">
							<?php
							wp_nav_menu(array('theme_location' => 'header-menu', 
							'menu_class' => 'clearfix menuContent', 
							'depth' => 13, 'fallback_cb' => false, 
							'walker' => new Circleflip_Nav_Walker
							));
							?>
						</div>
					</div>
					<!-- Menu End -->
				</div>
			</div>
		</div>
		<style>
			.overlayedHeader .stickyHeader2.activeSticky {
				background-color: <?php echo 'wheat';?> !important;
			}
			.stickyHeader2.activeSticky {
				top: 40px;
			}
			.stickyHeader2.activeSticky.adminTop {
				top: 72px;
			}
		</style>
	</div>
	<!-- Top Header End -->
	<!-- Main Header -->
	<div class="mainHeader darkContent responsiveCheck" style="background-color: #fff;">
		<div class="headerWrapper">
			<div class="container">
				<div class="headerRow">
					<!-- Logo -->
					<div class="logoWrapper headerLeft" style="width: <?php echo esc_attr(cr_get_option('logo_wrapper_width')); ?>px;height: <?php echo esc_attr(cr_get_option('header_height')); ?>px;">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if(( defined( 'ICL_LANGUAGE_CODE' ) && 'ar' === ICL_LANGUAGE_CODE) ) { ?>
								<img src="<?php echo esc_url( cr_get_option( 'rtl_theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
							<?php } else {?>
								<img src="<?php echo esc_url( cr_get_option( 'theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
							<?php } ?>
						</a>
					</div>
					<!-- Logo End -->
					<!-- Header Social -->
					<div class="headerSocial headerRight logoSibling1">
						<ul>
							<li class="headerFlip">
								<a href="#" target="_blank">
									<div class="back">
										<i class="icon-gplus"></i>
									</div>
									<div class="front">
										<i class="icon-gplus"></i>
									</div>
								</a>
							</li>
							<li class="headerFlip">
								<a href="#" target="_blank">
									<div class="back">
										<i class="icon-facebook"></i>
									</div>
									<div class="front">
										<i class="icon-facebook"></i>
									</div>
								</a>
							</li>
							<li class="headerFlip">
								<a href="#" target="_blank">
									<div class="back">
										<i class="icon-twitter"></i>
									</div>
									<div class="front">
										<i class="icon-twitter"></i>
									</div>
								</a>
							</li>
						</ul>
					</div>
					<!-- Header Social End -->
					<!-- Menu -->
					<div class="headerMenu responsiveCheck headerRight <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?> logoSibling1">
						<div class="toggleMenuBtn"><span class="icon-menu"></span></div>
						<div class="menuWrapper">
							<?php
							wp_nav_menu(array('theme_location' => 'header-menu', 
							'menu_class' => 'clearfix menuContent', 
							'depth' => 13, 'fallback_cb' => false, 
							'walker' => new Circleflip_Nav_Walker
							));
							?>
						</div>
					</div>
					<!-- Menu End -->
				</div>
			</div>
		</div>
		<style>
			.logoSibling1.headerMenu.responsiveCheck,
			.logoSibling1.headerMenu .menuContent > li > a,
			.logoSibling1 .headerMenuSearch > span,
			.logoSibling1.headerMenu .menuContent,
			.logoSibling1.headerMenu #megaMenu ul.megaMenu li.menu-item.ss-nav-menu-mega > a, 
			.logoSibling1.headerMenu #megaMenu ul.megaMenu li.menu-item.ss-nav-menu-mega > span.um-anchoremulator,
			.logoSibling1.headerMenu #megaMenu .headerMenuSearch > span,
			.logoSibling1.headerSocial,
			.logoSibling1.toggledMenu {
				height: <?php echo cr_get_option('header_height'); ?>px;
			}
		</style>
	</div>
	<!-- Main Header -->
	<div class="mainHeader darkContent responsiveCheck">
		<div class="headerWrapper">
			<div class="container">
				<div class="headerRow">
					<!-- Logo -->
					<div class="logoWrapper headerLeft" style="width: <?php echo esc_attr(cr_get_option('logo_wrapper_width')); ?>px;height: <?php echo esc_attr(cr_get_option('header_height')); ?>px;">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if(( defined( 'ICL_LANGUAGE_CODE' ) && 'ar' === ICL_LANGUAGE_CODE) ) { ?>
								<img src="<?php echo esc_url( cr_get_option( 'rtl_theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
							<?php } else {?>
								<img src="<?php echo esc_url( cr_get_option( 'theme_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo esc_attr( cr_get_option( 'logo_width' ) ); ?>" height="<?php echo esc_attr( cr_get_option( 'logo_height' ) ); ?>" style="left:<?php echo esc_attr( cr_get_option( 'logo_left' ) ); ?>px;top: <?php echo esc_attr( cr_get_option( 'logo_top' ) ); ?>px;"/>
							<?php } ?>
						</a>
					</div>
					<!-- Logo End -->
					<!-- Menu -->
					<div class="toggledMenu responsiveCheck headerRight <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?> logoSibling2">
						<div class="toggleMenuBtn"><span class="icon-menu"></span></div>
						<div class="menuWrapper">
							<div class="closeMenu"><span class="icon-cancel"></span></div>
							<?php
							wp_nav_menu(array('theme_location' => 'header-menu', 
							'menu_class' => 'clearfix menuContent', 
							'depth' => 13, 'fallback_cb' => false, 
							'walker' => new Circleflip_Nav_Walker
							));
							?>
						</div>
					</div>
					<!-- Menu End -->
				</div>
			</div>
		</div>
		<style>
			.logoSibling2.headerMenu,
			.logoSibling2.headerMenu .menuContent > li > a,
			.logoSibling2 .headerMenuSearch > span,
			.logoSibling2.headerMenu .menuContent,
			.logoSibling2.headerMenu #megaMenu ul.megaMenu li.menu-item.ss-nav-menu-mega > a, 
			.logoSibling2.headerMenu #megaMenu ul.megaMenu li.menu-item.ss-nav-menu-mega > span.um-anchoremulator,
			.logoSibling2.headerMenu #megaMenu .headerMenuSearch > span,
			.logoSibling2.headerSocial,
			.logoSibling2.toggledMenu {
				height: <?php echo cr_get_option('header_height');?>px;
			}
		</style>
	</div>
	<!-- Main Header End -->
	<div class="mainHeader darkContent responsiveCheck">
		<div class="headerWrapper">
			<div class="headerRow">
				<!-- Header Ads -->
				<div class="headerImage headerCenter">
					<a href="<?php echo esc_url(cr_get_option('header_ad_link')) ?>" target="_blank">
						<img src="<?php echo esc_url(cr_get_option('header_ad_area'));?>" width="" height="" />
					</a>
				</div>
				<!-- Header Ads -->
			</div>
		</div>
	</div>
	<!-- Main Header -->
	<div class="mainHeader darkContent responsiveCheck" style="background-color: #fff;">
		<div class="headerWrapper">
			<!-- Menu -->
			<div class="headerMenu responsiveCheck headerCenter <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?>">
				<div class="toggleMenuBtn"><span class="icon-menu"></span></div>
				<div class="menuWrapper">
					<?php
					wp_nav_menu(array('theme_location' => 'header-menu', 
					'menu_class' => 'clearfix menuContent', 
					'depth' => 13, 'fallback_cb' => false, 
					'walker' => new Circleflip_Nav_Walker
					));
					?>
				</div>
			</div>
			<!-- Menu End -->
		</div>
	</div>
	
	
	<?php if ( get_header_image() ) :
	?>
	<a id="header-image" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"> <img src="<?php header_image(); ?>" width="<?php echo circleflip_get_custom_header()->width; ?>" height="<?php echo circleflip_get_custom_header()->height; ?>" alt="" /> </a>
	<?php endif; // if ( get_header_image() ) ?>
	<?php
		if (function_exists('yoast_breadcrumb')) {
			yoast_breadcrumb('<nav id="breadcrumb" class="breadcrumb">', '</nav>');
		}
		tha_header_bottom();
 ?>
</header><!-- #branding -->
<?php
	tha_header_after();
	/* End of file header.php */
?>