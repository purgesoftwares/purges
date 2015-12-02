<!-- ITEM -->
<?php tha_entry_before() ?>
<li <?php post_class( array('item','grid-one-col') ) ?>>
	<?php tha_entry_top() ?>
	<?php
		//Hanlde sidebar or no sidebar cases
		global $wp_the_query;
		if ( $wp_the_query->is_page() ) {
			$portfolio_page_sidebar = circleflip_get_portfolio_page_meta( $wp_the_query->post->ID, 'sidebar' );
		}
		$one_col_inner_image = 'span6';
		$one_col_inner_text = 'span6';
		if(isset($portfolio_page_sidebar) && $portfolio_page_sidebar!='none'){
			$one_col_inner_image = 'span4';
			$one_col_inner_text = 'span5';
		}
	?>
	<!-- IMAGE -->
	<div class="<?php echo esc_attr($one_col_inner_image); ?> grid2 imgCont_new_style">
		<a href="<?php the_permalink() ?>">
			<?php echo circleflip_get_post_format_media(); ?>
			<?php // the_post_thumbnail(); ?>
		</a>
	</div>
	<!-- Details CONTAINER -->
	<div class="portfolioOneDetails <?php echo esc_attr($one_col_inner_text); ?>">
		<!-- TITLE -->
		<p class="portOneAuthor grid2"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></p>
		<!-- CATEGORIES -->
		<div class="portOneCategories grid2">
			
			<div class="date_cat">
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
				<p class="date"><?php echo get_the_date( 'M d, Y' ) ?></p>
				<?php if ( $options_categories ) : ?>
					<span> | </span>
					<?php echo implode( '<span> | </span>', $options_categories ); ?>
				<?php endif; ?>
			</div>
		</div>
		<!-- POST CONTENT -->
		<div class="grid2 portOneContent">
			<?php the_excerpt() ?>
		</div>
		<!-- MORE BUTTON -->
	</div>
	<?php tha_entry_bottom() ?>
</li>
<?php tha_entry_after() ?>