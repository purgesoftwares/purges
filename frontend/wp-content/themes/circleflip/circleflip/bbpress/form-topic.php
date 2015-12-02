<?php

/**
 * New/Edit Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php if ( !bbp_is_single_forum() ) : ?>
<div class="container">
			<div id="bbpress-forums">

		<?php endif; ?>
		
		<?php if ( bbp_is_topic_edit() ) : ?>
		
			<?php //bbp_topic_tag_list( bbp_get_topic_id() ); ?>
		
			<?php bbp_single_topic_description( array( 'topic_id' => bbp_get_topic_id() ) ); ?>
		
		<?php endif; ?>
		
		<?php if ( bbp_current_user_can_access_create_topic_form() ) : ?>
		
			<div id="new-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-form">
		
				<form id="new-post" name="new-post" method="post" action="<?php the_permalink(); ?>">
		
					<?php do_action( 'bbp_theme_before_topic_form' ); ?>
					<fieldset class="bbp-form">
						<h2>
							<?php
								if ( bbp_is_topic_edit() )
									printf( __( 'Edit &ldquo;%s&rdquo;', 'bbpress' ), bbp_get_topic_title() );
								else
									bbp_is_single_forum() ? printf( __( 'Create New Topic in &ldquo;%s&rdquo;', 'bbpress' ), bbp_get_forum_title() ) : _e( 'Create New Topic', 'bbpress' );
							?>
		
						</h2>
		
						<?php do_action( 'bbp_theme_before_topic_form_notices' ); ?>
		
						<?php if ( !bbp_is_topic_edit() && bbp_is_forum_closed() ) : ?>
		
							<div class="aq_alert bbpAlert note">
								<?php _e( 'This forum is marked as closed to new topics, however your posting capabilities still allow you to do so.', 'bbpress' ); ?>
							</div>
		
						<?php endif; ?>
		
						<?php if ( current_user_can( 'unfiltered_html' ) ) : ?>
		
							<div class="aq_alert bbpAlert note">
								<?php _e( 'Your account has the ability to post unrestricted HTML content.', 'bbpress' ); ?>
							</div>
		
						<?php endif; ?>
		
						<?php do_action( 'bbp_template_notices' ); ?>
		
						<div class="newTopic clearfix">
		
							<?php bbp_get_template_part( 'form', 'anonymous' ); ?>
		
							<?php do_action( 'bbp_theme_before_topic_form_title' ); ?>
		
							<input type="text" id="bbp_topic_title" value="<?php bbp_form_topic_title(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_title" maxlength="<?php bbp_title_max_length(); ?>" placeholder="Topic Title" />
		
							<?php do_action( 'bbp_theme_after_topic_form_title' ); ?>
		
							<?php do_action( 'bbp_theme_before_topic_form_content' ); ?>
		
							<?php bbp_the_content( array( 'context' => 'topic' ) ); ?>
		
							<?php do_action( 'bbp_theme_after_topic_form_content' ); ?>
		
							<?php if ( ! ( bbp_use_wp_editor() || current_user_can( 'unfiltered_html' ) ) ) : ?>
		
								<p class="form-allowed-tags">
									<label><?php _e( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:','bbpress' ); ?></label><br />
									<code><?php bbp_allowed_tags(); ?></code>
								</p>
		
							<?php endif; ?>
		
							<?php if ( bbp_allow_topic_tags() && current_user_can( 'assign_topic_tags' ) ) : ?>
		
								<?php do_action( 'bbp_theme_before_topic_form_tags' ); ?>
		
								<input type="text" placeholder="Topic Tags" value="<?php bbp_form_topic_tags(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_tags" id="bbp_topic_tags" <?php disabled( bbp_is_topic_spam() ); ?> />
		
								<?php do_action( 'bbp_theme_after_topic_form_tags' ); ?>
		
							<?php endif; ?>
		
							<?php if ( !bbp_is_single_forum() ) : ?>
		
								<?php do_action( 'bbp_theme_before_topic_form_forum' ); ?>
		
								<div class="row-fluid">
									<div class="span12">
										<?php
											bbp_dropdown( array(
												'show_none' => __( '(No Forum)', 'bbpress' ),
												'selected'  => bbp_get_form_topic_forum()
											) );
										?>
									</div>
								</div>
		
								<?php do_action( 'bbp_theme_after_topic_form_forum' ); ?>
		
							<?php endif; ?>
		
							<?php if ( current_user_can( 'moderate' ) ) : ?>
								<div class="row-fluid">
									<?php do_action( 'bbp_theme_before_topic_form_type' ); ?>
			
									<div class="span6">
										<?php bbp_form_topic_type_dropdown(); ?>
									</div>
			
									<?php do_action( 'bbp_theme_after_topic_form_type' ); ?>
			
									<?php do_action( 'bbp_theme_before_topic_form_status' ); ?>
			
									<div class="span6">
										<?php bbp_form_topic_status_dropdown(); ?>
									</div>
			
									<?php do_action( 'bbp_theme_after_topic_form_status' ); ?>
								</div>
		
							<?php endif; ?>
		
							<?php if ( bbp_is_subscriptions_active() && !bbp_is_anonymous() && ( !bbp_is_topic_edit() || ( bbp_is_topic_edit() && !bbp_is_topic_anonymous() ) ) ) : ?>
		
								<?php do_action( 'bbp_theme_before_topic_form_subscriptions' ); ?>
		
								<div class="subscribeTopic clearfix">
									<input name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox" value="bbp_subscribe" <?php bbp_form_topic_subscribed(); ?> tabindex="<?php bbp_tab_index(); ?>" />
		
									<?php if ( bbp_is_topic_edit() && ( bbp_get_topic_author_id() !== bbp_get_current_user_id() ) ) : ?>
		
										<label for="bbp_topic_subscription"><p><?php _e( 'Notify the author of follow-up replies via email', 'bbpress' ); ?></p></label>
		
									<?php else : ?>
		
										<label for="bbp_topic_subscription"><p><?php _e( 'Notify me of follow-up replies via email', 'bbpress' ); ?></p></label>
		
									<?php endif; ?>
								</div>
		
								<?php do_action( 'bbp_theme_after_topic_form_subscriptions' ); ?>
		
							<?php endif; ?>
		
							<?php if ( bbp_allow_revisions() && bbp_is_topic_edit() ) : ?>
		
								<?php do_action( 'bbp_theme_before_topic_form_revisions' ); ?>
		
								<fieldset class="bbp-form">
									<div class="newTopic clearfix">
										<div class="subscribeTopic clearfix">
											<input name="bbp_log_topic_edit" id="bbp_log_topic_edit" type="checkbox" value="1" <?php bbp_form_topic_log_edit(); ?> tabindex="<?php bbp_tab_index(); ?>" />
											<label for="bbp_log_topic_edit"><p><?php _e( 'Keep a log of this edit', 'bbpress' ); ?></p></label>
										</div>
										<input type="text" placeholder="Reason for editing (Optional)" value="<?php bbp_form_topic_edit_reason(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_edit_reason" id="bbp_topic_edit_reason" />
									</div>
								</fieldset>
		
								<?php do_action( 'bbp_theme_after_topic_form_revisions' ); ?>
		
							<?php endif; ?>
		
							<?php do_action( 'bbp_theme_before_topic_form_submit_wrapper' ); ?>
		
							<div class="bbp-submit-wrapper">
		
								<?php do_action( 'bbp_theme_before_topic_form_submit_button' ); ?>
		
								<button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_topic_submit" name="bbp_topic_submit" class="button btnStyle1 red withIcon submit"><div class="btnIcon icon-paper-plane"></div><span><?php _e( 'Submit', 'bbpress' ); ?></span><span class="btnBefore"></span><span class="btnAfter"></span></button>
		
								<?php do_action( 'bbp_theme_after_topic_form_submit_button' ); ?>
		
							</div>
		
							<?php do_action( 'bbp_theme_after_topic_form_submit_wrapper' ); ?>
		
						</div>
		
						<?php bbp_topic_form_fields(); ?>
		
					</fieldset>
		
					<?php do_action( 'bbp_theme_after_topic_form' ); ?>
		
				</form>
			</div>
		
		<?php elseif ( bbp_is_forum_closed() ) : ?>
		
			<div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
				<div class="aq_alert bbpAlert note">
					<?php printf( __( 'The forum &#8216;%s&#8217; is closed to new topics and replies.', 'bbpress' ), bbp_get_forum_title() ); ?>
				</div>
			</div>
		
		<?php else : ?>
		
			<div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
				<div class="aq_alert bbpAlert note">
					<?php is_user_logged_in() ? _e( 'You cannot create new topics.', 'bbpress' ) : _e( 'You must be logged in to create new topics.', 'bbpress' ); ?>
				</div>
			</div>
		
		<?php endif; ?>
		
		<?php if ( !bbp_is_single_forum() ) : ?>

			</div>
</div>

<?php endif; ?>
