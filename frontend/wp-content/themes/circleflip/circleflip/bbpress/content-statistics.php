<?php

/**
 * Statistics Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Get the statistics
$stats = bbp_get_statistics(); ?>

<ul role="main">
	<?php do_action( 'bbp_before_statistics' ); ?>
	<li><p><?php _e( 'Registered Users', 'bbpress' ); ?><span><?php echo esc_html( $stats['user_count'] ); ?></span></p></li>
	<li><p><?php _e( 'Forums', 'bbpress' ); ?><span><?php echo esc_html( $stats['forum_count'] ); ?></span></p></li>
	<li><p><?php _e( 'Topics', 'bbpress' ); ?><span><?php echo esc_html( $stats['topic_count'] ); ?></span></p></li>
	<li><p><?php _e( 'Replies', 'bbpress' ); ?><span><?php echo esc_html( $stats['reply_count'] ); ?></span></p></li>
	<li><p><?php _e( 'Topic Tags', 'bbpress' ); ?><span><?php echo esc_html( $stats['topic_tag_count'] ); ?></span></p></li>
	<?php if ( !empty( $stats['empty_topic_tag_count'] ) ) : ?>
		<li><p><?php _e( 'Empty Topic Tags', 'bbpress' ); ?><span><?php echo esc_html( $stats['empty_topic_tag_count'] ); ?></span></p></li>
	<?php endif; ?>
	<?php if ( !empty( $stats['topic_count_hidden'] ) ) : ?>
		<li><p><?php _e( 'Hidden Topics', 'bbpress' ); ?><span><abbr title="<?php echo esc_attr( $stats['hidden_topic_title'] ); ?>"><?php echo esc_html( $stats['topic_count_hidden'] ); ?></abbr></span></p></li>
	<?php endif; ?>
	<?php if ( !empty( $stats['reply_count_hidden'] ) ) : ?>
		<li><p><?php _e( 'Hidden Replies', 'bbpress' ); ?><span><abbr title="<?php echo esc_attr( $stats['hidden_reply_title'] ); ?>"><?php echo esc_html( $stats['reply_count_hidden'] ); ?></abbr></span></p></li>
	<?php endif; ?>
	<?php do_action( 'bbp_after_statistics' ); ?>

</ul>

<?php unset( $stats );