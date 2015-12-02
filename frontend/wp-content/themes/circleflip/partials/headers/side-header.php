<?php
/** header.php
 *
 * Displays Header Style 1
 *
 * @author		Creiden
 * @package		Circleflip
 * @version     1.0
 */
?>
<?php
?>
<header id="branding" role="banner" class="sideHeader <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?>">
	<!-- Side Bar -->
	<div class="topHeader lightContent responsiveCheck sideHeaderBar" style="background-color: #e32831;">
		<div class="headerWrapper">
			<div class="container">
				<div class="headerRow">
					<!-- Side Header Toggle -->
					<div class="sideToggle">
						<span class="icon-menu"></span>
					</div>
					<!-- Side Header Toggle End -->
					<!-- Bottom Items -->
					<div class="sideBottom">
						<!-- Header Social -->
						<div class="headerSocial headerRight">
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
					</div>
					<!-- Bottom Items End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Side Bar End -->
	<!-- Main Header -->
	<div class="mainHeader darkContent responsiveCheck" style="background-color: white;">
		<div class="headerWrapper">
			<div class="container">
				<div class="headerRow">
					<!-- Logo -->
					<div class="logoWrapper headerLeft" style="width: <?php echo esc_attr(cr_get_option('logo_wrapper_width')); ?>px;height: <?php echo esc_attr(cr_get_option('header_height')); ?>px;">
						<a href="<?php echo esc_url(home_url('/')); ?>"> <?php if(( defined( 'ICL_LANGUAGE_CODE' ) && 'ar' === ICL_LANGUAGE_CODE) ) {
						?><img src="<?php echo esc_url(cr_get_option('rtl_theme_logo')); ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo esc_attr(cr_get_option('logo_width')); ?>" height="<?php echo esc_attr(cr_get_option('logo_height')); ?>" style="left:<?php echo esc_attr(cr_get_option('logo_left')); ?>px;top: <?php echo esc_attr(cr_get_option('logo_top')); ?>px;"/> <?php } else { ?><img src="<?php echo esc_url(cr_get_option('theme_logo')); ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo esc_attr(cr_get_option('logo_width')); ?>" height="<?php echo esc_attr(cr_get_option('logo_height')); ?>" style="left:<?php echo esc_attr(cr_get_option('logo_left')); ?>px;top: <?php echo esc_attr(cr_get_option('logo_top')); ?>px;"/> <?php } ?></a>
					</div>
					<!-- Logo End -->
					<!-- Bottom Items --> 
					<div class="sideBottom">
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
						<!-- Header Social -->
						<div class="headerSocial headerRight">
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
					</div>
					<!-- Bottom Items End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Main Header End -->
	<!-- Top Header -->
	<div class="topHeader darkContent responsiveCheck" style="background-color: wheat;">
		<div class="headerWrapper">
			<div class="container">
				<div class="headerRow">
					<!-- Bottom Items -->
					<div class="sideBottom">
						<!-- Toggled Menu -->
						<div class="toggledMenu headerRight <?php if ( is_user_logged_in() ) {echo 'adminTop';} ?>">
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
						<!-- Toggled Menu End -->
						<!-- Header Social -->
						<div class="headerSocial headerRight">
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
					</div>
					<!-- Bottom Items End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Top Header End -->
	<!-- Main Header -->
	<div class="mainHeader lightContent responsiveCheck" style="background-color: #5a5a5a;">
		<div class="headerWrapper">
			<div class="container">
				<div class="headerRow">
					<!-- Logo -->
					<div class="logoWrapper headerLeft" style="width: <?php echo esc_attr(cr_get_option('logo_wrapper_width')); ?>px;height: <?php echo esc_attr(cr_get_option('header_height')); ?>px;">
						<a href="<?php echo esc_url(home_url('/')); ?>"> <?php if(( defined( 'ICL_LANGUAGE_CODE' ) && 'ar' === ICL_LANGUAGE_CODE) ) {
						?><img src="<?php echo esc_url(cr_get_option('rtl_theme_logo')); ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo esc_attr(cr_get_option('logo_width')); ?>" height="<?php echo esc_attr(cr_get_option('logo_height')); ?>" style="left:<?php echo esc_attr(cr_get_option('logo_left')); ?>px;top: <?php echo esc_attr(cr_get_option('logo_top')); ?>px;"/> <?php } else { ?><img src="<?php echo esc_url(cr_get_option('theme_logo')); ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo esc_attr(cr_get_option('logo_width')); ?>" height="<?php echo esc_attr(cr_get_option('logo_height')); ?>" style="left:<?php echo esc_attr(cr_get_option('logo_left')); ?>px;top: <?php echo esc_attr(cr_get_option('logo_top')); ?>px;"/> <?php } ?></a>
					</div>
					<!-- Logo End -->
					<!-- Menu -->
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
					<!-- Menu End -->
					<!-- Bottom Items End -->
					<div class="sideBottom">
						<!-- Header Ads -->
						<div class="headerImage">
							<a href="<?php echo cr_get_option('header_ad_link') ?>" target="_blank">
								<img src="<?php echo cr_get_option('header_ad_area');?>" width="580" height="300" />
							</a>
						</div>
						<!-- Header Ads -->
					</div>
					<!-- Bottom Items End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Main Header End -->
	
	
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