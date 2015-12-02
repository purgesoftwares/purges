<?php
/* -------------------------------------------------------------------------------------
 *
* 										Custom Sidebars
*
------------------------------------------------------------------------------------- */

if (!function_exists('register_page_custom_sidebar_mb')) {

    function register_page_custom_sidebar_mb() {
        $options = array(
            'id' => 'circleflip-custom-sidebar-page',
            'title' => 'Custom Sidebar',
            'callback' => 'render_page_custom_sidebar_mb',
            'screen' => 'page',
            'context' => 'normal',
            'priority' => 'high',
            'callback_args' => NULL
        );
        extract($options);
        add_meta_box($id, $title, $callback, $screen, $context, $priority, $callback_args);
    }

    add_action('add_meta_boxes_page', 'register_page_custom_sidebar_mb');
	
    function register_bb_custom_sidebar_mb() {
		if ( ! function_exists( 'bbp_get_topic_post_type') 
				|| ! function_exists( 'bbp_get_forum_post_type')
				|| ! function_exists( 'bbp_get_reply_post_type')
		) {
			return;
		}
        $options = array(
            'id' => 'circleflip-custom-sidebar-page',
            'title' => 'Custom Sidebar',
            'callback' => 'render_page_custom_sidebar_mb',
            'context' => 'normal',
            'priority' => 'high',
            'callback_args' => NULL
        );
        extract($options);
        add_meta_box($id, $title, $callback, bbp_get_topic_post_type(), $context, $priority, $callback_args);
        add_meta_box($id, $title, $callback, bbp_get_forum_post_type(), $context, $priority, $callback_args);
        add_meta_box($id, $title, $callback, bbp_get_reply_post_type(), $context, $priority, $callback_args);
    }

    add_action('add_meta_boxes', 'register_bb_custom_sidebar_mb');
    
	function register_post_custom_sidebar_mb() {
        $options = array(
            'id' => 'circleflip-custom-sidebar',
            'title' => 'Custom Sidebar',
            'callback' => 'render_page_custom_sidebar_mb',
            'screen' => 'page',
            'context' => 'normal',
            'priority' => 'high',
            'callback_args' => NULL
        );
        extract($options);
		add_meta_box($id, $title, $callback, 'post', $context, $priority, $callback_args);
    }
	
    add_action('add_meta_boxes_post', 'register_post_custom_sidebar_mb');

    function render_page_custom_sidebar_mb($post) {
        echo '<input type="hidden" name="nonce-custom_sidebars" value="' . wp_create_nonce("circleflip-custom-sidebars") . '" />';
        echo '<table class="form-table">';
        $positions = array(
            'left' => 'Left',
            'right' => 'Right',
            'none' => 'None'
        );
        $pos = get_post_meta($post->ID, '_sidebar-position', TRUE);
        $checked_pos = $pos !== '' ? $pos : 'none';
		$images = array( 0 => '2cl.png', 1 => '2cr.png', 2 => '1col.png');
		$counter = 0;
        ?>
<div id="sidebar-positions">
	<ul>
		<?php foreach ($positions as $slug => $label): ?>
		<li><?php $checked = $checked_pos === $slug ? 'checked="checked"' : '' ?>
			<label class="sidebar-position">
				<input type="radio" name="crdn[_sidebar-position]" id="<?php echo $label ?>"	value="<?php echo $slug ?>" <?php echo $checked ?>> <?php echo $label ?>
			</label>
			<img src="<?php echo get_template_directory_uri() ?>/creiden-framework/images/<?php echo $images[$counter]; ?>" class="of-radio-img-img" onclick="document.getElementById('<?php echo $label ?>').checked=true;" style="display: inline;">
		</li>
		<?php $counter++;endforeach; ?>
	</ul>
</div>
<?php
echo '<label for="select_sidebar" style="
    float: left;
    display: block;
    margin-top: 10px;
    margin-right: 10px;
">
Select Sidebar : </label> <select class = "of-input" name="crdn[_sidebar]" id="select_sidebar">';
echo '<option value="0">select sidebar</option>';
$selected_sidebar = get_post_meta($post->ID, '_sidebar', TRUE);
foreach (cr_get_option('sidebars', array()) as $sidebar) {
            $selected = $selected_sidebar === $sidebar ? "selected='selected'" : '';
            echo "<option value='$sidebar' $selected>$sidebar</option>";
        }

        echo '</select>';
        echo '</table>';
    }

    function save_page_custom_sidebar_mb($post_id) {
        if (
                (!isset($_POST['nonce-custom_sidebars']) || !wp_verify_nonce($_POST['nonce-custom_sidebars'], 'circleflip-custom-sidebars'))
                || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                || ('page' == $_POST['post_type'] && !current_user_can('edit_page', $post_id))
				|| ('post' == $_POST['post_type'] && !current_user_can('edit_post', $post_id))
        )
            return $post_id;
        foreach ($_POST['crdn'] as $field => $value) {
            $old = get_post_meta($post_id, $field, true);
            $new = $value;
            if ($new && $new != $old) {
                update_post_meta($post_id, $field, $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field, $old);
            }
        } // end foreach
        return $post_id;
    }

    add_action('save_post', 'save_page_custom_sidebar_mb');
}
