<?php

/** A simple text block **/
class CR_BoxedText_Block extends AQ_Block {
	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'boxedText.png',
			'name' => 'Boxed Text',
			'size' => 'span6',
                        'imagedesc' => 'boxed-text.jpg',
                        'tab' => 'Content',
                	'desc' => 'Adds a text box styled to be different from ordinary text blocks.'
		);
		//create the block
		parent::__construct('cr_boxedtext_block', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'text' => '',
			'entrance_animation' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<div class="description">
			<div class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('text') ) ?>">
					Text
				</label>
			</div>
			<div class="rightHalf">
				<?php //echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
				<?php echo wp_editor($text, $block_id, array('textarea_name'=>'aq_blocks['.$block_id.'][text]','quicktags'=>false)); ?>
			</div>
		</div>
		<p class="description half">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('entrance_animation') ) ?>">
					On-Scroll Animation
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php
					$animation_options = array(
						'default' => 'Default',
						'noanimation' => 'no animation',
						'cr_left' => 'Fade To Left',
						'cr_right' => 'Fade To right',
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
		echo '<div class="blockquote '.esc_attr($entrance_animation).' animateCr">' . wpautop(do_shortcode(htmlspecialchars_decode($text))). '</div>';
	}
}