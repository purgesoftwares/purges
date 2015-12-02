<?php

/**
 * Pagination for pages of topics (when viewing a forum)
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="bbp-pagination clearfix">
	<div class="bbp-pagination-count">

		<p><?php bbp_forum_pagination_count(); ?></p>

	</div>

	<div class="bbp-pagination-links">

		<p><?php bbp_forum_pagination_links(); ?></p>

	</div>
</div>

<?php do_action( 'bbp_template_after_pagination_loop' ); ?>
