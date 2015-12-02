<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
	<?php while( have_posts() ) : the_post() ?>
<div class="mainPageTitle singlePortfolioTitle">
	<div class="colorContainer">
		<div class="container">
			<h1><?php esc_html_e( 'Portfolio', 'circleflip' ) ?></h1>
			<div class="links right clearfix">
				<?php if (get_next_post()): ?>
					<div class="nextPost right"><?php next_post_link('%link', __('Next','circleflip')); ?></div>
				<?php else: ?>
					<div class="nextPost right disabled"><a><?php esc_html_e('Next','circleflip') ?></a></div>
				<?php endif ?>
				
				<?php if (get_previous_post()): ?>
					<div class="prevPost right"><?php previous_post_link('%link', __('Prev','circleflip')); ?></div>
				<?php else: ?>
					<div class="prevPost right disabled"><a><?php esc_html_e('Prev','circleflip') ?></a></div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="singlePortfolio">
					<?php get_template_part( 
							'partials/single',
							apply_filters( 'circleflip-portfolio-single-template', 'portfolio-layout1' )
						); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>