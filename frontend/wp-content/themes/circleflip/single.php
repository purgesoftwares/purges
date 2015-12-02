<?php
/** single.php
 *
 * The Template for displaying all single posts.
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0 - 05.02.2012
 */

get_header();?>
<?php 
	global $post,$content_width;
	if(cr_get_option('post_sidebars_option') == 'global'){
		if(cr_get_option('post_layout') == 'none') {
		$position_class = 'none';
		}else if(cr_get_option('post_layout') == 'left'){
		$position_class = 'left';	
		}else if(cr_get_option('post_layout') == 'right'){
		$position_class = 'right';
		}
	}
	else {
		$sidebar_position = get_post_custom_values('_sidebar-position', $post->ID);
		if(is_array($sidebar_position)){
			$position_class = array_shift($sidebar_position);
			$content_width = $content_width - 400;
		}
		else{
			$position_class = 'none';
		}
	}
	$another_position = empty($position_class) || $position_class == 'right' ? 'left' : 'right';
?>


<div class="container">
<div class="row singlePost">
	<?php if($position_class == 'left' || $position_class == 'right') { ?>
	<section class=" span9 <?php echo esc_attr( $another_position ); ?> withSidebar">
	<?php  } else { ?>
		<section class="span12">
	<?php  } ?>
		<?php tha_content_before(); ?>
		<div id="content" role="main">
			<?php tha_content_top();
			while ( have_posts() ) {
				the_post();
				get_template_part( '/partials/content', cr_get_option('style_posts','singlestyle1'));
			}
			?>
			<?php if(cr_get_option('post_comments_section') == 1 || cr_get_option('post_facebook_comments_section') == 1){ ?>
			<ul class="clearfix" id="singleCommentsTabbed">
            	<?php if(cr_get_option('post_comments_section') == 1){ ?>
			  		<li class="active wpComments"><a><span></span><?php esc_html_e( 'Wordpress Comments', 'circleflip' );?></a></li>
				<?php } ?>
				<?php if(cr_get_option('post_facebook_comments_section') == 1){ ?>
	  				<li class="fbComments"><a><span></span><?php esc_html_e( 'Facebook Comments', 'circleflip' );?></a></li>
			  	<?php } ?>
			</ul>
			<div class="tab-content">
				<?php
                    if(cr_get_option('post_comments_section') == 1){ ?>
				  		<div class="wp_comments active">
				  			<?php comments_template(); ?>
			  			</div>
                    <?php } ?>
                    <?php if(cr_get_option('post_facebook_comments_section') == 1){ ?>
						<div class="facebook_comments">
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=643221389029631";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
							<div class="fb-comments" data-href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" data-width="100%" data-num-posts="10"></div>
						</div>
			   <?php } ?>
			</div>
			<?php } ?>
			<nav id="nav-single" class="pager">
				<h3 class="assistive-text"><?php esc_html_e( 'Post navigation', 'circleflip' ); ?></h3>
				<span class="next"><?php next_post_link( '%link', sprintf( '%1$s <span class="meta-nav">&rarr;</span>', __( 'Next Post', 'circleflip' ) ) ); ?></span>
				<span class="previous"><?php previous_post_link( '%link', sprintf( '<span class="meta-nav">&larr;</span> %1$s', __( 'Previous Post', 'circleflip' ) ) ); ?></span>
			</nav><!-- #nav-single -->
	
			<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
	</section><!-- #primary -->
	<?php if($position_class == 'left' || $position_class == 'right') { ?>
	<section class="span3"> 
		<aside class="sidebar <?php echo esc_attr( $position_class ); ?>">
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
/* End of file index.php */
/* Location: ./wp-content/themes/circleflip/single.php */