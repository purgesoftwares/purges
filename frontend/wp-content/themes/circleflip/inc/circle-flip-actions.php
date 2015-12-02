<?php

function circleflip_header_top_left() {
	switch ( cr_get_option( 'header_style' ) ) {
		case 'style1':

			break;
		case 'style2':

			break;
		case 'style3':
			switch ( cr_get_option( 'top_left_area_settings' ) ) {
				case 'contact':
					if ( is_rtl() ) {
						if ( cr_get_option( 'rtl_header_contact_link_settings' ) ) {
							printf( '<p><a href="%s">%s</a></p>',
								esc_url( cr_get_option( 'rtl_header_contact_link_settings' ) ),
								esc_html( cr_get_option( 'rtl_header_contact_settings' ) ) 
							);
						} else {
							printf( '<p>%s</p>', esc_html( cr_get_option( 'rtl_header_contact_settings' ) ) );
						}
					} else
					if ( cr_get_option( 'header_contact_link_settings' ) ) {
						printf( '<p><a href="%s">%s</a></p>',
							esc_url( cr_get_option( 'header_contact_link_settings' ) ),
							esc_html( cr_get_option( 'header_contact_settings' ) ) 
						);
					} else {
						printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
					}
				break;
				case 'social':
				circleflip_social_icons('left');
				break;
				case 'main_navigation':
				?>
				<div <?php circleflip_navbar_class(); ?>>
					<div class="container">
						<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
						<a class="btn btn-navbar">
							<span class="icon-menu"></span>
						</a>
						<div class="navCollapse nav-collapse-left">
							<?php
							wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_class' => 'nav left',
							'depth' => 13,
							'fallback_cb' => false,
							'walker' => new Circleflip_Nav_Walker,
							) );
							?>
						</div>
					</div>
				</div>
				<?php
				break;
				case 'header_menu':
				?>
				<div <?php circleflip_navbar_class(); ?>>
					<div class="container">
						<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
						<a class="btn btn-navbar">
							<span class="icon-menu"></span>
						</a>
						<div class="navCollapse nav-collapse-left">
							<?php
							wp_nav_menu( array(
							'theme_location' => 'header-menu',
							'menu_class' => 'nav left',
							'depth' => 13,
							'fallback_cb' => false,
							'walker' => new Circleflip_Nav_Walker,
							) );
							?>
						</div>
					</div>
				</div>
				<?php
				break;
				default:

				break;
			}
			break;
			case 'style4':
			switch (cr_get_option('top_left_area_settings')) {
			case 'contact':
				if ( cr_get_option( 'header_contact_link_settings' ) ) {
					printf( '<p><a href="%s">%s</a></p>', esc_url( cr_get_option( 'header_contact_link_settings' ) ), esc_html( cr_get_option( 'header_contact_settings' ) ));
				} else {
					printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
				}
		break;
	case 'social':
		circleflip_social_icons( 'left' );
		break;
	case 'main_navigation':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="navCollapse nav-collapse-left">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'	 => 'nav left',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'header_menu':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-left">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'header-menu',
						'menu_class'	 => 'nav left',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	default:

		break;
}
break;
case 'style9':
switch ( cr_get_option( 'top_left_area_settings' ) ) {
	case 'contact':
		if ( cr_get_option( 'header_contact_link_settings' ) ) {
			printf( '<p><a href="%s">%s</a></p>', esc_url( cr_get_option( 'header_contact_link_settings' ) ), esc_html( cr_get_option( 'header_contact_settings' ) ));
		} else {
			printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
		}
		break;
	case 'social':
		circleflip_social_icons( 'left' );
		break;
	case 'main_navigation':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="navCollapse nav-collapse-left">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'	 => 'nav left',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'header_menu':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-left">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'header-menu',
						'menu_class'	 => 'nav left',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	default:

		break;
}
break;
case 'style5':
switch ( cr_get_option( 'top_left_area_settings' ) ) {
	case 'contact':
		if ( cr_get_option( 'header_contact_link_settings' ) ) {
			printf( '<p><a href="%s">%s</a></p>', esc_url( cr_get_option( 'header_contact_link_settings' ) ), esc_html( cr_get_option( 'header_contact_settings' ) ));
		} else {
			printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
		}
		break;
	case 'social':
		circleflip_social_icons( 'left' );
		break;
	case 'main_navigation':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-left">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'	 => 'nav left',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'header_menu':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse-left">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<div class="nav-collapse nav-collapse-left">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'header-menu',
						'menu_class'	 => 'nav left',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	default:

		break;
}
break;
case 'style6':
switch ( cr_get_option( 'top_left_area_settings' ) ) {
	case 'contact':
		if ( cr_get_option( 'header_contact_link_settings' ) ) {
			printf( '<p><a href="%s">%s</a></p>', esc_url( cr_get_option( 'header_contact_link_settings' ) ), esc_html( cr_get_option( 'header_contact_settings' ) ));
		} else {
			printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
		}
		break;
	case 'social':
		circleflip_social_icons( 'left' );
		break;
	case 'main_navigation':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-left">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'	 => 'nav left',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'header_menu':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-left">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'header-menu',
						'menu_class'	 => 'nav left',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	default:

		break;
}
break;
default:

break;
}
}

add_action( 'tha_header_top_left', 'circleflip_header_top_left' );

function circleflip_header_top_right() {
switch ( cr_get_option( 'header_style' ) ) {
case 'style1':

break;
case 'style2':

break;
case 'style3':
switch ( cr_get_option( 'top_right_area_settings' ) ) { // top right header part
	case 'contact':
		if ( cr_get_option( 'header_contact_link_settings' ) ) {
			printf( '<p><a href="%s">%s</a></p>', esc_url( cr_get_option( 'header_contact_link_settings' ) ), esc_html( cr_get_option( 'header_contact_settings' ) ));
		} else {
			printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
		}
		break;
	case 'social':
		circleflip_social_icons( 'right' );
		break;
	case 'main_navigation':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'	 => 'nav right',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'header_menu':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'header-menu',
						'menu_class'	 => 'nav right',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	default:

		break;
}
break;
case 'style4':
switch ( cr_get_option( 'top_right_area_settings' ) ) { // top right header part
	case 'contact':
		if ( cr_get_option( 'header_contact_link_settings' ) ) {
			printf( '<p><a href="%s">%s</a></p>', esc_url( cr_get_option( 'header_contact_link_settings' ) ), esc_html( cr_get_option( 'header_contact_settings' ) ));
		} else {
			printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
		}
		break;
	case 'social':
		circleflip_social_icons( 'right' );
		break;
	case 'main_navigation':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'	 => 'nav right',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'header_menu':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'header-menu',
						'menu_class'	 => 'nav right',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	default:

		break;
}
break;
case 'style9':
switch ( cr_get_option( 'top_right_area_settings' ) ) { // top right header part
	case 'contact':
		if ( cr_get_option( 'header_contact_link_settings' ) ) {
			printf( '<p><a href="%s">%s</a></p>', esc_url( cr_get_option( 'header_contact_link_settings' ) ), esc_html( cr_get_option( 'header_contact_settings' ) ));
		} else {
			printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
		}
		break;
	case 'social':
		circleflip_social_icons( 'right' );
		break;
	case 'main_navigation':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'	 => 'nav right',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'header_menu':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'header-menu',
						'menu_class'	 => 'nav right',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	default:

		break;
}
break;
case 'style5':
switch ( cr_get_option( 'top_right_area_settings' ) ) { // top right header part
	case 'contact':
		if ( cr_get_option( 'header_contact_link_settings' ) ) {
			printf( '<p><a href="%s">%s</a></p>', esc_url( cr_get_option( 'header_contact_link_settings' ) ), esc_html( cr_get_option( 'header_contact_settings' ) ));
		} else {
			printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
		}
		break;
	case 'social':
		circleflip_social_icons( 'right' );
		break;
	case 'main_navigation':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'	 => 'nav right',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'header_menu':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'header-menu',
						'menu_class'	 => 'nav right',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	default:

		break;
}
break;
case 'style6':
switch ( cr_get_option( 'top_right_area_settings' ) ) { // top right header part
	case 'contact':
		if ( cr_get_option( 'header_contact_link_settings' ) ) {
			printf( '<p><a href="%s">%s</a></p>', esc_url( cr_get_option( 'header_contact_link_settings' ) ), esc_html( cr_get_option( 'header_contact_settings' ) ));
		} else {
			printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
		}
		break;
	case 'social':
		circleflip_social_icons( 'right' );
		break;
	case 'main_navigation':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="nav-collapse navCollapse nav-collapse-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'	 => 'nav left',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'header_menu':
		?>
		<div <?php circleflip_navbar_class(); ?>>
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar">
					<span class="icon-menu"></span>
				</a>
				<div class="navCollapse navCollapse nav-collapse-right">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'header-menu',
						'menu_class'	 => 'nav left',
						'depth'			 => 13,
						'fallback_cb'	 => false,
						'walker'		 => new Circleflip_Nav_Walker,
					) );
					?>
				</div>
			</div>
		</div>
		<?php
		break;
	default:

		break;
}
break;
default:

break;
}
}

add_action( 'tha_header_top_right', 'circleflip_header_top_right' );

function circleflip_header_ad_area() {
switch ( cr_get_option( 'top_area_header_settings' ) ) { // top right header part
case 'contact':
		if ( cr_get_option( 'header_contact_link_settings' ) ) {
			printf( '<p><a href="%s">%s</a></p>', esc_url( cr_get_option( 'header_contact_link_settings' ) ), esc_html( cr_get_option( 'header_contact_settings' ) ));
		} else {
			printf( '<p>%s</p>', esc_html( cr_get_option( 'header_contact_settings' ) ) );
		}
break;
case 'social':
?>
<div class="blackSocial">
	<?php
	circleflip_social_icons( 'right' );
	?>
</div>
<?php
break;
case 'main_navigation':
?>
<div <?php circleflip_navbar_class(); ?> style="width: calc(100% - <?php echo cr_get_option( 'logo_wrapper_width' ) ?>px);">
	<div class="navbar-inner">
		<div class="container">
			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar">
				<span class="icon-menu"></span>
			</a>
			<div class="navCollapse navCollapse nav-collapse-main">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_class'	 => 'nav right',
					'depth'			 => 13,
					'fallback_cb'	 => false,
					'walker'		 => new Circleflip_Nav_Walker,
				) );
				?>
			</div>
		</div>
	</div>
</div>
<?php
break;
case 'header_menu':
?>
<div <?php circleflip_navbar_class(); ?> style="width: calc(100% - <?php echo cr_get_option( 'logo_wrapper_width' ) ?>px);">
	<div class="navbar-inner">
		<div class="container">
			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar">
				<span class="icon-menu"></span>
			</a>
			<div class="navCollapse navCollapse nav-collapse-main">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'header-menu',
					'menu_class'	 => 'nav right',
					'depth'			 => 13,
					'fallback_cb'	 => false,
					'walker'		 => new Circleflip_Nav_Walker,
				) );
				?>
			</div>
		</div>
	</div>
	<?php
	break;
case 'ad':
	?>
	<div class="right cr_ad" style="width: calc(100% - <?php echo cr_get_option( 'logo_wrapper_width' ) ?>px);">
<?php if ( cr_get_option( 'header_ad_link' ) ) { ?>
			<a href="<?php echo cr_get_option( 'header_ad_link' ) ?>" target="_blank">
				<img src="<?php echo cr_get_option( 'header_ad_area' ); ?>" />
			</a>
		<?php } else { ?>
			<img src="<?php echo cr_get_option( 'header_ad_area' ); ?>" />
	<?php } ?>
	</div>
	<?php
	break;
default:

	break;
}
}

add_action( 'tha_header_ad_area', 'circleflip_header_ad_area' );

function circleflip_header_after() {
switch ( cr_get_option( 'header_style' ) ) {
case 'style4':
	//Breaking Area start
	if ( cr_get_option( 'breaking_area' ) ) {
		$breakingTitle = circleflip_valid( cr_get_option( 'breaking_title' ) ) ? cr_get_option( 'breaking_title' ) : __( 'Breaking', 'circleflip' );

		switch ( cr_get_option( 'breaking_content' ) ) {
			case 'posts':

				$breakNumPosts = circleflip_valid( cr_get_option( 'number_breaking_posts' ) ) ? cr_get_option( 'number_breaking_posts' ) : 10;
				$cat_ids = circleflip_valid( cr_get_option( 'breaking_selected_category' ) ) ? implode( ',', cr_get_option( 'breaking_selected_category' ) ) : -1;
				$args = array(
					'showposts'	 => $breakNumPosts,
					'category'	 => $cat_ids,
					'order'		 => 'DESC',
				);
				$args['suppress_filters'] = false;
				$ticker_posts = get_posts( $args );

				if ( $ticker_posts ):
					?>

					<div class="slidingText full">
						<div class="container">
							<div class="movingHead left">
								<h2><?php echo esc_html($breakingTitle); ?></h2>
							</div>
							<div class="movingText left">
								<ul id="js-news" class="js-hidden">
				<?php foreach ( $ticker_posts as $post ) : setup_postdata( $post ); ?>
										<li class="news-item"><a href="<?php echo esc_url($post->guid) ?>"><h6><?php echo esc_html($post->post_title) ?></h6></a></li>
					<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
				<?php
				endif;
				break;
			case 'custom':
				$custome_breaking = explode( ',', cr_get_option( 'custome_breaking' ) );
				?>

				<div class="slidingText full">
					<div class="container">
						<div class="movingHead left">
							<h2><?php echo esc_html($breakingTitle); ?></h2>
						</div>
						<div class="movingText left">
							<ul id="js-news" class="js-hidden">
			<?php foreach ( $custome_breaking as $key => $text ) { ?>
									<li class="news-item"><h6><?php echo esc_html($text) ?></h6></li>
				<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<?php
				break;
			default:
				$breakNumPosts = circleflip_valid( cr_get_option( 'number_breaking_posts' ) ) ? cr_get_option( 'number_breaking_posts' ) : 10;
				$cat_ids = circleflip_valid( cr_get_option( 'breaking_selected_category' ) ) ? implode( ',', cr_get_option( 'breaking_selected_category' ) ) : -1;
				$args = array(
					'showposts'	 => $breakNumPosts,
					'category'	 => $cat_ids,
					'order'		 => 'DESC',
				);
				$args['suppress_filters'] = false;
				$ticker_posts = get_posts( $args );
				if ( $ticker_posts ):
					?>
					<div class="slidingText full">
						<div class="movingHead left">
							<h2><?php echo esc_html($breakingTitle); ?></h2>
						</div>
						<div class="movingText left">
							<ul id="js-news" class="js-hidden">
					<?php foreach ( $ticker_posts as $post ) : setup_postdata( $post ); ?>
									<li class="news-item"><a href="<?php the_permalink(); ?>"><h6><?php echo esc_html($post->post_title) ?></h6></a></li>
					<?php endforeach; ?>
							</ul>
						</div>
					</div>
				<?php
				endif;
				break;
		}
	}
	//Breaking Area End
	break;
case 'style9':
	//Breaking Area start
	if ( cr_get_option( 'breaking_area' ) ) {
		$breakingTitle = circleflip_valid( cr_get_option( 'breaking_title' ) ) ? cr_get_option( 'breaking_title' ) : 'Breaking';

		switch ( cr_get_option( 'breaking_content' ) ) {
			case 'posts':

				$breakNumPosts = circleflip_valid( cr_get_option( 'number_breaking_posts' ) ) ? cr_get_option( 'number_breaking_posts' ) : 10;
				$cat_ids = circleflip_valid( cr_get_option( 'breaking_selected_category' ) ) ? implode( ',', cr_get_option( 'breaking_selected_category' ) ) : -1;
				$args = array(
					'showposts'	 => $breakNumPosts,
					'category'	 => $cat_ids,
					'order'		 => 'DESC',
				);
				$args['suppress_filters'] = false;
				$ticker_posts = get_posts( $args );

				if ( $ticker_posts ):
					?>

					<div class="slidingText full">
						<div class="container">
							<div class="movingHead left">
								<h2><?php echo esc_html($breakingTitle); ?></h2>
							</div>
							<div class="movingText left">
								<ul id="js-news" class="js-hidden">
				<?php foreach ( $ticker_posts as $post ) : setup_postdata( $post ); ?>
										<li class="news-item"><a href="<?php echo esc_url($post->guid) ?>"><h6><?php echo esc_html($post->post_title) ?></h6></a></li>
					<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
				<?php
				endif;
				break;
			case 'custom':
				$custome_breaking = explode( ',', cr_get_option( 'custome_breaking' ) );
				?>

				<div class="slidingText full">
					<div class="container">
						<div class="movingHead left">
							<h2><?php echo esc_html($breakingTitle); ?></h2>
						</div>
						<div class="movingText left">
							<ul id="js-news" class="js-hidden">
			<?php foreach ( $custome_breaking as $key => $text ) { ?>
									<li class="news-item"><h6><?php echo esc_html($text) ?></h6></li>
				<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<?php
				break;
			default:
				$breakNumPosts = circleflip_valid( cr_get_option( 'number_breaking_posts' ) ) ? cr_get_option( 'number_breaking_posts' ) : 10;
				$cat_ids = circleflip_valid( cr_get_option( 'breaking_selected_category' ) ) ? implode( ',', cr_get_option( 'breaking_selected_category' ) ) : -1;
				$args = array(
					'showposts'	 => $breakNumPosts,
					'category'	 => $cat_ids,
					'order'		 => 'DESC',
				);
				$args['suppress_filters'] = false;
				$ticker_posts = get_posts( $args );
				if ( $ticker_posts ):
					?>
					<div class="slidingText full">
						<div class="movingHead left">
							<h2><?php echo esc_html($breakingTitle); ?></h2>
						</div>
						<div class="movingText left">
							<ul id="js-news" class="js-hidden">
					<?php foreach ( $ticker_posts as $post ) : setup_postdata( $post ); ?>
									<li class="news-item"><a href="<?php the_permalink(); ?>"><h6><?php echo esc_html($post->post_title) ?></h6></a></li>
					<?php endforeach; ?>
							</ul>
						</div>
					</div>
				<?php
				endif;
				break;
		}
	}
	//Breaking Area End
	break;
case 'style5':
	?>
	<div class="mainHeader headerStyle5 headerAfter">
		<div class="container">
			<div <?php circleflip_navbar_class(); ?>>
				<div class="navbar-inner">
					<div class="container">
						<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
						<a class="btn btn-navbar">
							<span class="icon-menu"></span>
						</a>
						<div class="navCollapse navCollapse nav-collapse-headerAfter">
							<?php
							wp_nav_menu( array(
								'theme_location' => 'primary',
								'menu_class'	 => 'nav center',
								'depth'			 => 13,
								'fallback_cb'	 => false,
								'walker'		 => new Circleflip_Nav_Walker,
							) );
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	if ( cr_get_option( 'sticky_header' ) == 1 ) {
		echo '</div>';
	}
	?>
	<?php
	break;
}
}

add_action( 'tha_header_after', 'circleflip_header_after' );

function circleflip_social_icons( $float ) {
foreach ( cr_get_option( 'social_urls', array() ) as $social ) {
circleflip_social_icons_rendering( $social['link'], $social['icon'], $float );
}
}

function circleflip_social_icons_rendering( $social_link, $class, $float ) {
?>
	<div class="animationFlip headerSocial <?php echo esc_attr($float) ?>">
		<a href="<?php echo esc_url( $social_link ); ?>" target="_blank">
			<div class="back">
				<i class="<?php echo esc_attr($class) ?>"></i>
			</div>
			<div class="front">
				<i class="<?php echo esc_attr($class) ?>"></i>
			</div>
		</a>
	</div>
<?php
}
