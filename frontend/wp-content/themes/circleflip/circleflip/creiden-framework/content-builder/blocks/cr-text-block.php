<?php
/** A simple text block **/
class CR_Text_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'text.png',
			'name' => 'Text',
			'size' => 'span6',
                        'tab' => 'Content',
                        'imagedesc' => 'text.jpg',
                        'desc' => 'Used to add text blocks into your page.'
		);

		//create the block
		parent::__construct('cr_text_block', $block_options);
	}
	function form($instance) {

		$defaults = array(
			'text' => '',
			'entrance_animation' => '',
			'textMarginBottom' => '20'
		);

		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<div class="description">
			<div class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('text') ) ?>">
					<?php _e('Text', 'circleflip-builder') ?>
				</label>
			</div>
			<div class="rightHalf">
				<?php echo wp_editor($text, $block_id, array('textarea_name'=>'aq_blocks['.$block_id.'][text]','quicktags' => false)); ?>
			</div>
		</div>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('textMarginBottom') ) ?>">
					Block Margin Bottom
				</label>
				<span class="description_text">
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('textMarginBottom', $block_id, $textMarginBottom, 'min', 'number') ?> px
			</span>
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
		$defaults = array(
			'text' => '',
			'entrance_animation' => '',
			'textMarginBottom' => '20'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
		echo  wpautop('<div class="animateCr '.esc_attr($entrance_animation).'" style="margin-bottom:'. esc_attr($textMarginBottom) .'px;">'.do_shortcode(htmlspecialchars_decode($text)).'</div>');
	}

}