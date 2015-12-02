<?php
/** A simple text block **/
class CR_Media_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'tab'    => 'media',
			'image' => 'text.png',
			'name'  => 'Media',
			'size'  => 'span6',
                        'imagedesc' => 'media.jpg',
                        'desc' => 'Used for Media content as videos and audios.'
		);

		//create the block
		parent::__construct('cr_media_block', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'text' => '',
			'entrance_animation' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		?>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('text') ) ?>">
					<?php _e('Embed URL', 'circleflip-builder') ?>
				</label>
				<span class="description_text">Enter your embed url here, ex: https://www.youtube.com/watch?v=2yS6HfMM7KY</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('text', $block_id, $text, $size = 'full') ?>
			</span>
		</p>
		</p>
		<p class="description half">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('entrance_animation') ) ?>">
					<?php _e('Animation', 'circleflip-builder') ?>
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php
					$animation_options = array(
						'default' => 'Default',
						'noanimation' => 'no animation',
						'cr_left' => 'Fade To Left',
						'cr_right' => 'Fade To Right',
						'cr_top' => 'Fade To Up',
						'cr_bottom' => 'Fade To Down',
						'cr_popup' => 'Popout',
						'cr_fade' => 'Fade in',
					);
					echo circleflip_field_select('entrance_animation', $block_id, $animation_options, $entrance_animation); ?>
				</span>
				<span class="entrance_animation_sim"></span>
			</span>
		</p>
		<?php
	}
	function block($instance) {
		extract($instance);
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
		echo  '<div class="animateCr '.esc_attr($entrance_animation).'"><div class="embedBlock iframe_container">'.apply_filters('the_content', $text).'</div></div>';?>
		<?php
	}
}