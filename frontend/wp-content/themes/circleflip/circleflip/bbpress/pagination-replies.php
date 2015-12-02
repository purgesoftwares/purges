<?php

/**
 * Pagination for pages of replies (when viewing a topic)
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="bbp-pagination">
	<div class="bbp-pagination-count replyCount">

		<p><?php bbp_topic_pagination_count(); ?></p>

	</div>

	<div class="bbp-pagination-links">

		<p><?php bbp_topic_pagination_links(); ?></p>

	</div>
</div>

<?php do_action( 'bbp_template_after_pagination_loop' ); ?>
