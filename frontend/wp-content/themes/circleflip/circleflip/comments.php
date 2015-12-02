<?php
/** comments.php
 *
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by callbacks which are located in the functions.php file.
 *
 * @author		Creiden
 * @package		Circleflip
 * @since		1.0.0 - 05.02.2012
 */

tha_comments_before();
$aria_req = isset($aria_req) && !empty($aria_req) ? $aria_req : '';
$html5 = isset($html5) && !empty($html5) ? $html5 : '';
$fields   =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'circleflip' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'circleflip' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
	);
$defaults = array(
    'fields' => apply_filters('comment_form_default_fields', $fields),
    'label_submit' => __('Submit', 'circleflip'),
	'reply_text' => __('Reply', 'circleflip')
);
comment_form($defaults);

tha_comments_after();


/* End of file comments.php */
/* Location: ./wp-content/themes/circleflip/comments.php */