<?php $categories = circleflip_get_portfolio_categories( get_the_ID() ) ?>
<?php $tags = circleflip_get_portfolio_tags( get_the_ID() ) ?>
<?php $project_details = circleflip_get_portfolio_meta(get_the_ID(), 'project_details', array()) ?>
<div class="portfolioImage span8 grid3">
	<?php echo circleflip_get_post_format_media() ?>
	<?php // the_post_thumbnail() ?>
</div>
<div class="span4">
	<div class="portfolioText">
		<h3><?php the_title() ?></h3>
		<?php if ( ! empty( $categories ) ) : ?>
		<h6>
			<strong class="singlePortCat">
				<?php esc_html_e('Category','circleflip')?>: 
				<span class="color">
					<dfn>
						<?php 
							$counter = 1;
							foreach ( $categories as $category ) : ?>
								<a href="<?php echo esc_url( get_term_link( $category ) ) ?>"><?php echo esc_html($category->name) ?></a> <?php echo ($counter < sizeof($categories)) ? ',':''; ?>
							<?php 
							$counter++;
							endforeach; ?>
					</dfn>
				</span>
			</strong>
		</h6>
		<?php endif; ?>
		<?php if ( ! empty( $tags ) ) : ?>
		<h6>
			<strong class="singlePortTag">
				Tags: 
				<span class="color">
					<dfn>
						<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url(get_term_link( $tag )) ?>"><?php echo esc_html($tag->name) ?></a>
						<?php //echo implode( ', ', circleflip_get_portfolio_categories( get_the_ID(), array('fields' => 'names') ) ) ?>
						<?php endforeach; ?>
					</dfn>
				</span>
			</strong>
		</h6>
		<?php endif; ?>
		<?php the_content() ?>
	</div>
	<?php if ( ! empty( $project_details ) ) : ?>
	<div class="portfolioDetails">
		<h3><?php echo circleflip_get_portfolio_meta( get_the_ID(), 'project_details_title', '' ) ?></h3>
		<ul>
				<?php foreach( $project_details as $detail) : ?>
			<li>
				<p><strong><?php echo esc_html($detail['key']) ?>:</strong> <?php echo esc_html($detail['value']) ?></p>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
</div>