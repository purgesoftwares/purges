<?php

/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_topics_loop' ); ?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" class="bbp-topics grid2">

	<li class="bbp-header">

		<ul class="forum-titles">
			<li class="bbp-topic-title"><h5><?php _e( 'Topic', 'bbpress' ); ?></h5></li>
			<li class="bbp-topic-voice-count"><h5><?php _e( 'Voices', 'bbpress' ); ?></h5></li>
			<li class="bbp-topic-reply-count"><h5><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></h5></li>
			<li class="bbp-topic-freshness"><h5><?php _e( 'Freshness', 'bbpress' ); ?></h5></li>
		</ul>

	</li>

	<li class="bbp-body">

		<?php while ( bbp_topics() ) : bbp_the_topic(); ?>

			<?php bbp_get_template_part( 'loop', 'single-topic' ); ?>

		<?php endwhile; ?>

	</li>
</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->

<?php do_action( 'bbp_template_after_topics_loop' ); ?>
