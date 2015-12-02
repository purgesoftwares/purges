<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_replies_loop' ); ?>
<div class="bbp-reply-content replyLinks">

	<?php if ( !bbp_show_lead_topic() ) : ?>

		<?php // _e( 'Posts', 'bbpress' ); ?>
		
		<p class="color"><?php bbp_user_subscribe_link(); ?></p>

		<p class="color"><?php bbp_user_favorites_link(); ?></p>

	<?php else : ?>

		<?php _e( 'Replies', 'bbpress' ); ?>

	<?php endif; ?>

</div>
<div class="clear"></div>
<hr class="replyPagination">
<ul id="topic-<?php bbp_topic_id(); ?>-replies" class="forums bbp-replies">

	<li class="bbpSingleReply">
		
		<?php if ( bbp_thread_replies() ) : ?>

			<?php bbp_list_replies(); ?>

		<?php else : ?>

			<?php while ( bbp_replies() ) : bbp_the_reply(); ?>

				<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</li><!-- .bbp-body -->

</ul><!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action( 'bbp_template_after_replies_loop' ); ?>
