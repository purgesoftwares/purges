<?php
/**
 * Template Name: Site Map
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file 
 *
 * Please see /external/starkers-utilities.php for info on Creiden_Utilities::get_template_parts()
 *
 * @package     WordPress
 * @subpackage  Starkers
 * @since       Starkers 4.0
 */
?>
<?php get_header(); 
$page_title_select = get_post_meta($post->ID,'page_title_select',TRUE);

	switch ($page_title_select) {
		case 'default_page_title':
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
		case 'coloured_page_title':
			?>
			<div class="mainPageTitle">
				<div class="colorContainer" style="background:<?php echo get_post_meta($post->ID,'_color_field',TRUE)?>">
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
				<div class="mainPageTitle">
					<?php echo do_shortcode(get_post_meta($post->ID,'_revolutionID',TRUE)); ?>
				</div>
				<?php
			break;
			case 'no_title':?>
				<div style="height: 20px;"></div>
		<?php 
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
?>
	<div class="container">
		<div class="row">
			<div class="siteMapContainer grid3">
				<?php 
				// Pages Section
				if(cr_get_option('show_pages_sitemap','1') == '1'){ 
				$pages = cr_get_option('site_map_selected_pages','');
				if( isset($pages) && !empty($pages) && is_array($pages)){ ?>
				<div class="singleMap span3">
					<h3><?php esc_html_e('Pages','circleflip'); ?></h3>
					<ul class="mapLinks">
					<?php 
					foreach ( $pages as  $page ) {
						if(isset($page) && !empty($page)){
							$get_page = get_post($page);?>
							<li>
								<h6><a href="<?php echo esc_url( get_permalink( $page ) ); ?>"><?php echo esc_html( $get_page->post_title ) ?></a></h6>
							</li>
						<?php } 
					}?>
					</ul>
				</div>
				<?php }
				}
				
				// Categories Section
				
				if(cr_get_option('show_categories_sitemap','1') == '1'){
				$saved_categories = cr_get_option('site_map_selected_categories',''); 
					if( isset($saved_categories) && !empty($saved_categories) && is_array($saved_categories)){
						?>
						<div class="singleMap span3">
							<h3><?php esc_html_e('Categories','circleflip'); ?></h3>
							<ul class="mapLinks">
								<?php  
									foreach ( $saved_categories as $cat ) { ?>
										<li>
											<h6><a href="<?php echo esc_url( get_category_link( $cat ) ); ?> "><?php echo esc_html( get_cat_name( $cat ) ); ?> </a></h6> 
										</li>										
									<?php }
								?>
							</ul>
				</div>
					<?php 
						}
					} 
				// Posts Section
				
				if(cr_get_option('show_posts_sitemap','1') == '1'){
				$saved_posts = cr_get_option('site_map_selected_posts',''); 
				$selectedPosts = isset($saved_posts) && !empty($saved_posts) && is_array($saved_posts)  ? implode(",", $saved_posts) : '' ;
				if(isset($selectedPosts) && !empty($selectedPosts)){
				$args = array(
	                'include' => $selectedPosts,
	                'orderby' => 'date',
	            	'order' => 'DESC'
	                );
				 $posts =  get_posts($args);	?>
				<div class="singleMap span3">
					<h3><?php esc_html_e('Posts','circleflip'); ?></h3>
					<ul class="mapLinks">
					<?php  
					foreach ( $posts as $post ) {
						if(isset($page) && !empty($page)){ ?>
							<li>
								<h6><a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( $post->post_title ); ?></a></h6>
					 		</li>
					 	<?php } 
					}?>
					</ul>
				</div>
				<?php } 
				} ?>
				
				<div id="siteMapBg"></div>
			</div>
		</div>
	</div>
</div>
<?php get_footer()?>