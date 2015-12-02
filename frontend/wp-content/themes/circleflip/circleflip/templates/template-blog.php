<?php
/**
 * Template Name: Blog Page
 *
 * @author 	Creiden
 * @package Circle Flip
 * @since	1.0
 */
?>
<?php get_header(); ?>
<?php
$args = array(
	'posts_per_page'		 => cr_get_option( 'blog_posts_per_page', 5 ),
	'cat'					 => implode( ',', cr_get_option( 'blog_selected_cat', '' ) ),
	'post_type'				 => 'post',
	'orderby'				 => 'date',
	'order'					 => cr_get_option('blog_posts_order_direction','DESC'),
	'paged'					 => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
	'post_status'			 => 'publish',
	'posts_per_archive_page' => cr_get_option( 'blog_posts_per_page', 5 )
);
$_query = new WP_Query();
$output = $_query->query( $args );
$layout = get_post_meta( get_the_ID(), '_circleflip_blog_layout', true );
$layout = $layout ? $layout : 'layout-one';
$page_title_select = get_post_meta($post->ID,'page_title_select',TRUE);


global $post,$content_width;
	$sidebar_position = get_post_custom_values('_sidebar-position', $post->ID);
	if(is_array($sidebar_position)){
		$position_class = array_shift($sidebar_position);
		$content_width = $content_width - 400;
	}
	else{
		$position_class = 'none';
	}
$another_position = empty($position_class) || $position_class == 'right' ? 'left' : 'right';
if(cr_get_option('rtl',0) == '1') {
        	if($position_class != 'none') {
        		$tempRTL = $another_position;
				$another_position =  $position_class;
				$position_class = $tempRTL;
        	}
	}
	switch ($page_title_select) {
		case 'default_page_title':
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
		case 'coloured_page_title':
			?>
			<div class="mainPageTitle">
				<div class="colorContainer" style="background:<?php echo get_post_meta($post->ID,'_color_field',TRUE)?>">
					<div class="container">
						<h1 style="color:<?php echo get_post_meta($post->ID,'_color_field_text',TRUE)?>"><?php echo get_the_title(); ?></h1>
					</div>
				</div>
			</div>
			<?php
			break;
			case 'image_page_title':
			?>
			<div class="mainPageTitle mainPageTitleImage">
				<div class="colorContainer" style="background:url(<?php echo get_post_meta($post->ID,'_upload_image',TRUE)?>)">
					<div class="container">
						<h1 style="color:<?php echo get_post_meta($post->ID,'_color_text',TRUE)?>"><?php echo get_the_title(); ?></h1>
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
		<?php if($position_class == 'left' || $position_class == 'right') { ?>
			<div class=" span9 <?php echo esc_attr($another_position);?> withSidebar">
		<?php  } else { ?>
			<div class="span12">
		<?php  } ?>
			<div id="content" role="main">
				<?php if ( $output ) : ?>
					<?php foreach ( $output as $post ) : setup_postdata( $post ); ?>
						<?php get_template_part( 'partials/blog', $layout ); ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<?php circleflip_end_query() ?>
				<?php circleflip__pagination( $args ); ?>
			</div><!-- #content -->
		</div><!-- #primary -->
		<?php if($position_class == 'left' || $position_class == 'right') { ?>
		<section class="span3">
	
		<aside class="sidebar <?php echo esc_attr($position_class); ?>">
			<ul>
			<?php if(cr_get_option('post_sidebars_option') == 'global') {
				$sidebar = cr_get_option('post_sidebar'); 
				$sidebars = cr_get_option('sidebars', array());
				if (circleflip_valid($sidebar) && in_array($sidebar, $sidebars)) :
					dynamic_sidebar($sidebar);
				endif;
			} else {
				$post_custom_values = get_post_custom_values('_sidebar', $post->ID);
				if(!empty($post_custom_values) && isset($post_custom_values)) {
					$sidebar = array_shift($post_custom_values);
					$sidebars = cr_get_option('sidebars', array());
					if (circleflip_valid($sidebar) && in_array($sidebar, $sidebars)) :
						dynamic_sidebar($sidebar);
					endif;
				}
			}
			
				?>
			</ul>
		</aside>
	</section>
	<?php } ?>
	</div>
</div>
<?php
get_footer();
/* End of file template-blog.php */
/* Location: ./wp-content/themes/circleflip/_full_width.php */