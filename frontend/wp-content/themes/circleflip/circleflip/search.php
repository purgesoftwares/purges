<?php
	/** search.php
	 *
	 * The template for displaying Search Results pages.
	 *
	 * @author		Creiden
	 * @package		Circleflip
	 * @since		1.0.0 - 07.02.2012
	 */

get_header(); 
if ( have_posts() ) { 
	$sideBarPos = cr_get_option('search_layout','right');
	if(cr_get_option('rtl',0) == '1') {
		switch ($sideBarPos) {
			case 'left':
				$contentPos = 'left';
				$sideBarPos = 'right';
				break;
			case 'right':
				$contentPos = 'right';
				$sideBarPos = 'left';
				break;
			case 'none':
				$contentPos = '';
				break;
			default:
				$contentPos = 'right';
				$sideBarPos = 'left';
				break;
		}
	}else{
		switch ($sideBarPos) {
			case 'left':
				$contentPos = 'right';
				break;
			case 'right':
				$contentPos = 'left';
				break;
			case 'none':
				$contentPos = '';
				break;
			default:
				$contentPos = 'left';
				break;
	}
}
 
	if($sideBarPos == 'right' || $sideBarPos== 'left'){
		?>
		<div class="mainPageTitle">
		<div class="colorContainer">
			<div class="container">
			<div class="titlepage">
				<h1><?php printf( __( 'Search Results for: %s', 'circleflip' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</div>
		</div>
		</div>
	</div>
	<div class="container">
	<div class="row">
		<div class="span9 <?php echo esc_attr( $contentPos ); ?>">
			<div id="content" role="main">
				<?php
	}else{ ?>
		<div class="mainPageTitle">
		<div class="colorContainer">
			<div class="container">
			<div class="titlepage">
				<h1><?php printf( __( 'Search Results for: %s', 'circleflip' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</div>
		</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="span12">
				<div id="content" role="main"> 
				<?php
	}

	while ( have_posts() ) :
		the_post();
		get_template_part( 'partials/blog', 'layout-one' );
	endwhile;
	circleflip_content_nav( 'nav-below' );
	 ?>
			</div><!-- #content -->
		</div><!-- #primary -->
		<?php if($sideBarPos == 'left' || $sideBarPos == 'right') { ?>
		<section class="span3"> 
			<aside class="sidebar <?php echo esc_attr( $sideBarPos ); ?>">
				<ul>
				    <?php dynamic_sidebar(cr_get_option('search_sidebar')); ?>
				</ul>
			</aside>
		</section>
		<?php } ?>
		</div><!-- #row -->
	</div> <!-- #container -->
	<?php
}else{
	get_template_part( '/partials/content', 'not-found' );
}
get_footer();
/* End of file search.php */
/* Location: ./wp-content/themes/circleflip/search.php */