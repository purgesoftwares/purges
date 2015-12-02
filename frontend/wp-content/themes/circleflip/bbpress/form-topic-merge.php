<?php

/**
 * Merge Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div class="container">
	<div id="bbpress-forums">
	
		<?php if ( is_user_logged_in() && current_user_can( 'edit_topic', bbp_get_topic_id() ) ) : ?>
	
			<div id="merge-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-merge">
	
				<form id="merge_topic" name="merge_topic" method="post" action="<?php the_permalink(); ?>">
	
					<fieldset class="bbp-form">
	
						<h2><?php printf( __( 'Merge topic "%s"', 'bbpress' ), bbp_get_topic_title() ); ?></h2>
	
						<div>
	
							<div class="aq_alert bbpAlert info">
								<p><?php _e( 'Select the topic to merge this one into. The destination topic will remain the lead topic, and this one will change into a reply.', 'bbpress' ); ?></p>
								<p><?php _e( 'To keep this topic as the lead, go to the other topic and use the merge tool from there instead.', 'bbpress' ); ?></p>
							</div>
	
							<div class="aq_alert bbpAlert note">
								<?php _e( 'All replies within both topics will be merged chronologically. The order of the merged replies is based on the time and date they were posted. If the destination topic was created after this one, it\'s post date will be updated to second earlier than this one.', 'bbpress' ); ?>
							</div>
							
							<div class="aq_alert bbpAlert warn">
								<?php _e( '<strong>WARNING:</strong> This process cannot be undone.', 'bbpress' ); ?>
							</div>
							
							<fieldset class="bbp-form">
								<div class="mergeTopic grid3">
									<div>
										<?php if ( bbp_has_topics( array( 'show_stickies' => false, 'post_parent' => bbp_get_topic_forum_id( bbp_get_topic_id() ), 'post__not_in' => array( bbp_get_topic_id() ) ) ) ) : ?>
		
											<h5><?php _e( 'Merge with this topic:', 'bbpress' ); ?></h5>
		
											<?php
												bbp_dropdown( array(
													'post_type'   => bbp_get_topic_post_type(),
													'post_parent' => bbp_get_topic_forum_id( bbp_get_topic_id() ),
													'selected'    => -1,
													'exclude'     => bbp_get_topic_id(),
													'select_id'   => 'bbp_destination_topic',
													'none_found'  => __( 'No topics were found to which the topic could be merged to!', 'bbpress' )
												) );
											?>
		
										<?php else : ?>
		
											<label><?php _e( 'There are no other topics in this forum to merge with.', 'bbpress' ); ?></label>
		
										<?php endif; ?>
		
									</div>
									<div>
		
										<?php if ( bbp_is_subscriptions_active() ) : ?>
		
											<input name="bbp_topic_subscribers" id="bbp_topic_subscribers" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
											<label for="bbp_topic_subscribers"><p><?php _e( 'Merge topic subscribers', 'bbpress' ); ?></p></label>
		
										<?php endif; ?>
		
										<input name="bbp_topic_favoriters" id="bbp_topic_favoriters" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
										<label for="bbp_topic_favoriters"><p><?php _e( 'Merge topic favoriters', 'bbpress' ); ?></p></label>
		
										<?php if ( bbp_allow_topic_tags() ) : ?>
		
											<input name="bbp_topic_tags" id="bbp_topic_tags" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
											<label for="bbp_topic_tags"><p><?php _e( 'Merge topic tags', 'bbpress' ); ?></p></label>
		
										<?php endif; ?>
		
									</div>
								</div>
							</fieldset>
	
							<div class="bbp-submit-wrapper">
								<button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_merge_topic_submit" name="bbp_merge_topic_submit" class="button btnStyle1 red withIcon submit"><div class="btnIcon icon-paper-plane"></div><span><?php _e( 'Submit', 'bbpress' ); ?></span><span class="btnBefore"></span><span class="btnAfter"></span></button>
							</div>
						</div>
	
						<?php bbp_merge_topic_form_fields(); ?>
	
					</fieldset>
				</form>
			</div>
	
		<?php else : ?>
	
			<div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
				<div class="entry-content"><?php is_user_logged_in() ? _e( 'You do not have the permissions to edit this topic!', 'bbpress' ) : _e( 'You cannot edit this topic.', 'bbpress' ); ?></div>
			</div>
	
		<?php endif; ?>
	
	</div>
</div>