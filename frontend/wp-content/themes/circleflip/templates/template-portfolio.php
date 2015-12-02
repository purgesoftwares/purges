<?php
/**
 * Template Name: Portfolio
 *
 * @author 	Creiden
 * @package Circle Flip
 * @since	1.0
 */
?>
<?php
global $circleflip_page_id,$wp_query;
$circleflip_page_id = get_the_ID();
$portfolio_page_meta = circleflip_get_portfolio_page_meta( get_the_ID() );
// hack for archive requests, as there is no page
$portfolio_page_meta = wp_parse_args( $portfolio_page_meta, array(
	'hover-style'	 => 1,
	'sidebar'		 => 'none',
	'which_sidebar'	 => '',
	'style'			 => 'checkers',
	'columns'		 => 3,
	'text_position'	 => '',
		) );
$reverse_classes = array(
	'none'	 => array( 'content' => ''     , 'sidebar' => ''      ),
	'left'	 => array( 'content' => 'right', 'sidebar' => 'left'  ),
	'right'	 => array( 'content' => 'left' , 'sidebar' => 'right' ),
);
//sidebar conditions
$port_content_width = 'span12';
$port_sidebar_width = '';
if($portfolio_page_meta['sidebar']!='none'){
	if($portfolio_page_meta['columns']== '3' || $portfolio_page_meta['style'] =='checkers'){
		$port_content_width = 'span9';
		$port_sidebar_width = 'span3';
	}
	else{
		$port_content_width = 'span9';
		$port_sidebar_width = 'span3';
	}
}
?>
<?php get_header(); ?>
<?php
$page_title_select = get_post_meta( $circleflip_page_id, 'page_title_select', TRUE );
switch ( $page_title_select ) {
	case 'default_page_title':
		?>
		<div class="mainPageTitle">
			<div class="colorContainer">
				<div class="container">
				<div class="titlepage">
					<h1><?php echo get_the_title(); ?></h1>
				</div>
			</div>
			</div>
		</div>
		<?php
		break;
	case 'coloured_page_title':
		?>
		<div class="mainPageTitle">
			<div class="colorContainer" style="background:<?php echo get_post_meta( $circleflip_page_id, '_color_field', TRUE ) ?>">
				<div class="container">
					<h1 style="color:<?php echo get_post_meta( $circleflip_page_id, '_color_field_text', TRUE ) ?>"><?php echo get_the_title(); ?></h1>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'image_page_title':
		?>
		<div class="mainPageTitle mainPageTitleImage">
			<div class="colorContainer" style="background:url(<?php echo get_post_meta( $circleflip_page_id, '_upload_image', TRUE ) ?>)">
				<div class="container">
					<h1 style="color:<?php echo get_post_meta( $circleflip_page_id, '_color_text', TRUE ) ?>"><?php echo get_the_title(); ?></h1>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'revolution_page_title':
		?>
		<div class="mainPageTitle mptSlider">
			<?php echo do_shortcode( get_post_meta( $circleflip_page_id, '_revolutionID', TRUE ) ); ?>
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
					<h1><?php echo get_the_title(); ?></h1>
				</div>
			</div>
		</div>
		<?php
		break;
}
?>
<div class="container">
	<div class="row">
		<div id="content" role="main">
			<div class="<?php echo esc_attr($port_content_width.' '.$reverse_classes[$portfolio_page_meta['sidebar']]['content']) ?>">
				<div class="row">
					<!-- FILTERS CONTAINER -->
					<div id="circleflip-filters">
						<!-- CATEGORY FILTERS -->
						<ul class="span12 clearfix">
							<li class="active" data-dimension="category" data-filter="*"><?php _e( 'All', 'circleflip' ) ?></li>
							<?php foreach ( circleflip_get_portfolio_categories() as $category ) : ?>
								<li data-dimension="category" data-filter=".category-<?php echo esc_attr($category->term_id) ?>">
									<?php echo esc_html($category->name) ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<!-- ITEMS CONTAINER -->
					 <div class="loader loading_portfolio"><span class="topLoader"></span><span class="bottomLoader"></span></div>
						<?php
						$tmp_wp_query = $wp_query;
						$portfolio_query = new WP_Query( array(
							'post_type' => 'circleflip-portfolio',
							'post_status' => 'publish',
							'posts_per_page' => -1,
						) );
						$wp_query = $portfolio_query;
						?>
						<?php if($portfolio_page_meta['style'] == 'masonry') {
							 ?>
							<div class="ourHolder">
								<div class="masonryContainer clearfix">
						<?php
							circleflip_portfolio_loop($portfolio_query);
						}
						else if($portfolio_page_meta['style'] == 'grid') {
							echo '<ul class="ourHolder">';
								circleflip_portfolio_loop($portfolio_query);
							echo '</ul>';
						}
						else if($portfolio_page_meta['style'] == 'checkers') {
							echo '<ul class="ourHolder">';
								circleflip_portfolio_loop($portfolio_query);
							echo '</ul>';
						} ?>
						<?php if($portfolio_page_meta['style'] == 'masonry') { ?>
								</div>
							</div>
						<?php } ?>
						<?php
						function circleflip_portfolio_loop($portfolio_query) {
								if ( $portfolio_query->have_posts() ) :
								 	while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
								 		get_template_part(
											'partials/content',
											apply_filters( 'circleflip-portfolio-columns-template', 'portfolio-single-column' )
										);
									endwhile;
								endif;
						}
						$wp_query = $tmp_wp_query;
						$portfolio_query = null;
						circleflip_end_query();
						?>
				</div>
			</div>
			<?php  ?>
			<?php if ( 'none' !== $portfolio_page_meta['sidebar'] && ! empty( $portfolio_page_meta['which_sidebar'] ) ) { ?>
				<section class="span3">
						<aside class="sidebar <?php echo esc_attr($port_sidebar_width.' '.$reverse_classes[$portfolio_page_meta['sidebar']]['sidebar']) ?>">
							<ul>
								<?php dynamic_sidebar( $portfolio_page_meta['which_sidebar'] ) ?>
							</ul>
						</aside>
				</section>
			<?php } ?>
		</div><!-- #content -->
	</div>
</div>
<?php
get_footer();