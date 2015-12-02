<?php
/** A simple text block **/
class CR_Qoute_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'quote.png',
			'name' => 'Quote',
			'size' => 'span6',
                        'imagedesc' => 'quote.jpg',
                        'tab' => 'Content',
                        'desc' => 'Displays text in a different style than the text block, used for quotes.'
		);

		//create the block
		parent::__construct('cr_qoute_block', $block_options);
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
					Quote
				</label>
			</div>
			<div class="rightHalf">
				<?php echo circleflip_field_textarea('text', $block_id, $text, $size = 'full') ?>
				<?php //echo wp_editor($text, $block_id, array('textarea_name'=>'aq_blocks['.$block_id.'][text]','quicktags'=>false)); ?>
			</div>
		</div>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('weight') ) ?>">
					Align
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php $align_style = array('left','center','right'); ?>
					<?php echo circleflip_field_select('align', $block_id, $align_style , isset($align) ? $align : 'left') ?>
				</span>
			</span>
		</p>
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
		$align_style = array('textLeft','textCenter','textRight');
		$align_class = '';
		if(isset($align)){
			$align_class = $align_style[$align];
		}
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
		echo '<div class="quote animateCr '.esc_attr($entrance_animation).' '.esc_attr($align_class).'"><div class="doublequotes1"></div> ' . do_shortcode(htmlspecialchars_decode($text)). '<div class="right doublequotes2"></div></div>';
	}

}