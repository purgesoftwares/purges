<?php
/** page.php
 *
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0 - 07.02.2012
 */
get_header();
if ( have_posts() )
	the_post();
global $post;
$page_title_select = get_post_meta( $post->ID, 'page_title_select', TRUE );
$sidebar_position = get_post_custom_values( '_sidebar-position', $post->ID );
if ( is_array( $sidebar_position ) ) {
	$position_class = array_shift( $sidebar_position );
} else {
	$position_class = 'none';
}
$another_position = empty( $position_class ) || $position_class == 'right' ? 'left' : 'right';
if ( cr_get_option( 'rtl', 0 ) == '1' ) {
	if ( $position_class != 'none' ) {
		$tempRTL = $another_position;
		$another_position = $position_class;
		$position_class = $tempRTL;
	}
}
switch ( $page_title_select ) {
	case 'default_page_title':
		?>
		<div class="mainPageTitle">
			<div class="colorContainer">
				<div class="container">
					<div class="titlepage">
						<h1><?php the_title(); ?></h1>
						<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
							<?php
							if ( function_exists( 'bcn_display' ) ) {
								bcn_display();
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'coloured_page_title':
		?>
		<div class="mainPageTitle">
			<div class="colorContainer" style="background:<?php echo esc_attr( get_post_meta( $post->ID, '_color_field', TRUE ) ) ?>">
				<div class="container">
					<h1 style="color:<?php echo esc_attr( get_post_meta( $post->ID, '_color_field_text', TRUE ) ) ?>"><?php the_title(); ?></h1>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'image_page_title':
		?>
		<div class="mainPageTitle mainPageTitleImage">
			<div class="colorContainer" style="background:url(<?php echo esc_url( get_post_meta( $post->ID, '_upload_image', TRUE ) ) ?>)">
				<div class="container">
					<h1 style="color:<?php echo esc_attr( get_post_meta( $post->ID, '_color_text', TRUE ) ) ?>"><?php the_title(); ?></h1>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'revolution_page_title':
		?>
		<div class="mainPageTitle mptSlider">
		<?php echo do_shortcode( get_post_meta( $post->ID, '_revolutionID', TRUE ) ); ?>
		</div>
		<?php
		break;
	case 'no_title':

		break;
	default:
		?>
		<div class="mainPageTitle">
			<div class="colorContainer">
				<div class="container">
					<h1><?php the_title(); ?></h1>
				</div>
			</div>
		</div>
		<?php
		break;
}

$builder_data = do_shortcode( '[template id="' . $post->ID . '"]' );
?>

<?php if ( $position_class == 'left' || $position_class == 'right' ) { ?>
	<!-- Page Container -->
	<div class="container">
		<div id="primary" class="span9 <?php echo esc_attr( $another_position ); ?>">
			<?php
		} else {
			if ( ! circleflip_valid( $builder_data ) ) {
				echo '<div class="container">';
			}
			?>
			<div id="primary" class="">
			<?php } ?>
				<?php tha_content_before(); ?>
			<div id="content" role="main">
				<?php
				tha_content_top();

				if ( circleflip_valid( $builder_data ) ) {
					if ( post_password_required( $post ) )
						echo get_the_password_form( $post );
					else {
						echo $builder_data;
					}
				} else {
					?>
					<div class="cfEditor">
						<?php
						the_content();
						?>
					</div>
					<?php
				}
				tha_content_bottom();
				?>
			</div><!-- #content -->
		<?php tha_content_after(); ?>
		</div><!-- #primary -->
<?php if ( $position_class == 'left' || $position_class == 'right' ) { ?>
			<section class="span3">
				<aside class="sidebar <?php echo esc_attr( $position_class ); ?>">
					<ul>
						<?php
						if ( cr_get_option( 'post_sidebars_option' ) == 'global' ) {
							$sidebar = cr_get_option( 'post_sidebar' );
							$sidebars = cr_get_option( 'sidebars', array() );
							if ( circleflip_valid( $sidebar ) && in_array( $sidebar, $sidebars ) ) :
								dynamic_sidebar( $sidebar );
							endif;
						} else {
							$post_custom_values = get_post_custom_values( '_sidebar', $post->ID );
							if ( ! empty( $post_custom_values ) && isset( $post_custom_values ) ) {
								$sidebar = array_shift( $post_custom_values );
								$sidebars = cr_get_option( 'sidebars', array() );
								if ( circleflip_valid( $sidebar ) && in_array( $sidebar, $sidebars ) ) :
									dynamic_sidebar( $sidebar );
								endif;
							}
						}
						?>
					</ul>
				</aside>
			</section>
		<?php } ?>
<?php if ( ! circleflip_valid( $builder_data ) || $position_class == 'left' || $position_class == 'right' ) { ?>
		</div>
		<!-- Page Container -->
	<?php } ?>

	<?php
	get_footer();
	?>
<?php
/* End of file page.php */
/* Location: ./wp-content/themes/circleflip/page.php */
