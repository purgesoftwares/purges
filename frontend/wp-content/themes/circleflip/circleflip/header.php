<?php
/** header.php
 *
 * Displays all of the <head> section and everything up till </header>
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0 - 05.02.2012
 */

?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<?php tha_head_top(); 
		if( !function_exists('wp_site_icon') ) { ?>
			<link rel="shortcut icon" href="<?php echo esc_url( cr_get_option( 'favicon' ) ); ?>">
		<?php } ?>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!--[if lt IE 9]
		    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]-->

		<?php tha_head_bottom(); ?>
		<?php wp_head();?> 
	</head>

	<body <?php body_class(); ?>>
		<?php if ( cr_get_option( 'boxedlayout' ) ) {
			echo '<div class="boxedLayout">';
		} ?>
		<?php if ( cr_get_option( 'boxedlayout' ) ) {
			echo '<div class="boxedLayout">';
		} ?>
		<?php 			
			if(cr_get_option('header_builder')) {
				tha_header_before();
				get_header_builder();	
			} else {
		switch (cr_get_option('header_style','style1')) {
				case 'style1':
					
				if(cr_get_option('search_area',true)) { ?>
					<div class="row-fluid searchbar style1 closed">
						<?php tha_header_top();
						circleflip_navbar_searchform();
						?>
					</div>
				<?php
				}
					break;
					case 'style3': ?>
						<div class="row-fluid top_header_style3">
							<div class="container">
								<div class="header_top_right">
									<p>
										<?php tha_header_top_right(); ?>
									</p>
								</div>
								<div class=" header_top_left">
									<p>
										<?php tha_header_top_left(); ?>
									</p>
								</div>
							</div>
						</div>
					<?php
					break;
					case 'style4': ?>
					<div class="row-fluid top_header_style4 main-top-headerStyle4 smallHeader">
						<div class="container">
							<div class="header_top_right">
								<?php tha_header_top_right(); ?>
							</div>
							<div class=" header_top_left">
								<?php tha_header_top_left(); ?>
							</div>

						</div>
					</div>
					<?php
					break;
					case 'style5': ?>
					<div class="row-fluid top_header_style4 top_header_style5 smallHeader">
						<div class="container">
							<div class="header_top_right">
								<p>
									<?php tha_header_top_right(); ?>
								</p>
							</div>
							<div class=" header_top_left">
								<p>
									<?php tha_header_top_left(); ?>
								</p>
							</div>
						</div>
					</div>
					<?php
					break;
					case 'style6': ?>
					<?php if(cr_get_option('sticky_header') == 1){
						echo '<div class="headerWrapper">';
					} ?>
					<div class="row-fluid top_header_style4 header6 smallHeader">
						<div class="container">
							<div class="header_top_right">
									<?php tha_header_top_right(); ?>
							</div>
							<div class=" header_top_left">
									<?php tha_header_top_left(); ?>
							</div>
						</div>
					</div>
					<?php
					break;
					case 'style9': ?>
					<div class="row-fluid top_header_style4 top_header_style9 main-top-headerStyle4 main-top-headerStyle9 smallHeader">
						<div class="container">
							<div class="header_top_right">
								<?php tha_header_top_right(); ?>
							</div>
							<div class=" header_top_left">
								<?php tha_header_top_left(); ?>
							</div>

						</div>
					</div>
					<?php
					break;
				default:

					break;
			}
			
			tha_header_before(); 
					switch (cr_get_option('header_style','style1')) {
						case 'style1':
							get_template_part( '/partials/headers/header', 'style1' );
							break;
						case 'style2':
							get_template_part( '/partials/headers/header', 'style2' );
							break;
						case 'style3':
							get_template_part( '/partials/headers/header', 'style3' );
							break;
						case 'style4':
							get_template_part( '/partials/headers/header', 'style4' );
							break;
						case 'style5':
							get_template_part( '/partials/headers/header', 'style5' );
							break;
						case 'style6':
							get_template_part( '/partials/headers/header', 'style6' );
							break;
						case 'style7':
							get_template_part( '/partials/headers/header', 'style7' );
							break;
						case 'style8':
							get_template_part( '/partials/headers/header', 'style8' );
							break;
						case 'style9':
							get_template_part( '/partials/headers/header', 'style9' );
							break;
						default:

							break;
					}
			}

/* End of file header.php */
/* Location: ./wp-content/themes/circleflip/header.php */