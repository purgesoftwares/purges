<?php
/* Registered Sidebars Blocks */
class AQ_Widgets_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'image' => 'widgets.png',
			'name' => 'Sidebars',
			'size' => 'span4',
                        'tab' => 'Layout',
                        'imagedesc' => 'sidebars.jpg',
                        'desc' => 'Adds your selected sidebar exactly where you want it to be.'
		);

		parent::__construct('AQ_Widgets_Block', $block_options);
	}

	function form($instance) {


		//get all registered sidebars
		global $wp_registered_sidebars;
		$sidebar_options = array(); $default_sidebar = '';
		foreach ($wp_registered_sidebars as $registered_sidebar) {
			$default_sidebar = empty($default_sidebar) ? $registered_sidebar['id'] : $default_sidebar;
			$sidebar_options[$registered_sidebar['id']] = $registered_sidebar['name'];
		}

		$defaults = array(
			'sidebar' => $default_sidebar,
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		?>
		<p class="description half">
			<span class="leftHalf">
				<label for="<?php echo esc_attr($block_id) ?>_title">
					<?php _e( 'Title', 'circleflip-builder' ) ?>
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('title', $block_id, $title, $size = 'full') ?>
			</span>
		</p>
		<p class="description half last">
			<span class="leftHalf">
				<label for="">
					<?php _e('Pick a sidebar to display', 'circleflip-builder') ?>
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('sidebar', $block_id, $sidebar_options, $sidebar); ?>
				</span>
			</span>
		</p>
		<?php
	}

	function block($instance) {
		extract($instance);
		dynamic_sidebar($sidebar);
	}

}