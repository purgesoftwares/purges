<!-- ITEM -->
<?php tha_entry_before() ?>
<?php global $wp_query; ?>
<?php $odd_even = $wp_query->current_post % 2 ? 'post-odd' : 'post-even'?>
<li <?php post_class( array('item','item-checker', $odd_even) ) ?>>
	<?php tha_entry_top() ?>
	<?php
		//Hanlde sidebar or no sidebar cases
		global $wp_the_query;
		if ( $wp_the_query->is_page() ) {
			$portfolio_page_sidebar = circleflip_get_portfolio_page_meta( $wp_the_query->post->ID, 'sidebar' );
		}
		$checker_full = 'span12';
		$checker_inner_small = 'span4';
		$checker_inner_big = 'span8';
		if ( isset($portfolio_page_sidebar) && $portfolio_page_sidebar != 'none' ) {
			$checker_full = 'span9';
			$checker_inner_small = 'span3';
			$checker_inner_big = 'span6';
		}
	?>
	<!-- IMAGE -->
	<div class="<?php echo esc_attr($checker_inner_big); ?> grid2 imgCont_new_style">
			<?php echo circleflip_get_post_format_media(null); ?>
			<?php // the_post_thumbnail(); ?>
	</div>
	<!-- Details CONTAINER -->
	<?php
	$options_categories = array();
	$port_cats = circleflip_get_portfolio_categories( get_the_ID() );
	if ( $port_cats ) {
		foreach ( $port_cats as $cat ) {
			$options_categories[$cat->term_id] = '<a href="'
											. get_term_link( $cat )
											. '" class="circleflip-portfolio-filter" data-dimension="category" data-filter=".category-' . $cat->term_id . '">'.$cat->name.'</a>';
		}
	}
	?>
	<div class="text_under_post clearfix <?php echo esc_attr($checker_inner_small); ?>">
		<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
		<div class="date_cat">
		<p class="date"><?php echo get_the_date( 'M d, Y' ) ?></p>
		<?php if ( $options_categories ) : ?>
			<span> | </span>
			<?php echo implode( '<span> | </span>', $options_categories ); ?>
		<?php endif; ?>
		</div>
		<p class="excerpt">
		<?php echo circleflip_string_limit_characters(get_the_content(),200); ?>
		</p>
		<br />
		<a href="<?php echo get_permalink(); ?>" class="readmore"> Read More <span class="icon-right-open"></span></a>
	</div>
	
	<?php tha_entry_bottom() ?>
	<div class="checker_separator <?php echo esc_attr($checker_full); ?>"></div>
</li>
<?php tha_entry_after() ?>