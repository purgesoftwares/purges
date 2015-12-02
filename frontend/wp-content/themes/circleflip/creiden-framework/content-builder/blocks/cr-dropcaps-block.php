<?php


/** A simple text block **/
class CR_Dropcaps_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'dropcap.png',
			'name' => 'DropCap',
			'size' => 'span6',
                        'imagedesc' => 'dropcap.jpg',
                        'tab' => 'Content',
                        'desc' => 'A type of a text block, but adds cool style to the first letter of the paragraph.'
		);
		//create the block
		parent::__construct('cr_dropcaps_block', $block_options);
	}

	public function form($instance) {

		$defaults = array(
			'text' => '',
			'select' => '',
			'entrance_animation' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<div class="description">
			<div class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('text') ) ?>">
					<?php _e('Content', 'circleflip-builder') ?>
				</label>
			</div>
			<div class="rightHalf">
				<?php //echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
				<?php echo wp_editor($text, $block_id, array('textarea_name'=>'aq_blocks['.$block_id.'][text]','quicktags'=>false)); ?>
			</div>
		</div>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('shape') ) ?>">
					<?php _e('Color Scheme', 'circleflip-builder') ?>
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('shape', $block_id, array('With Circle','Without Circle'), isset($shape) ? $shape : 'solid') ?>
				</span>
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

	public function block($instance) {
		extract($instance);
		if($entrance_animation == 'default') {
			$entrance_animation = cr_get_option('block_animations');
		}
		$this->enqueue_view_Dropcap_script();
		if ($shape == '0') {
			echo '<div class="dropcapText animateCr '.esc_attr($entrance_animation).'">'.$text.'</div>';
		}
		else if ($shape == '1'){
			echo '<div class="dropcapLight animateCr '.esc_attr($entrance_animation).'">'.$text.'</div>';
		}
	}
	function enqueue_view_Dropcap_script(){
		$theme_version = _circleflip_version();
		wp_register_style('dropcaps-css',get_template_directory_uri() . "/css/content-builder/dropcaps.css",array(),$theme_version);
		wp_enqueue_style('dropcaps-css');
		wp_register_script('dropcaps-js',get_template_directory_uri() . "/scripts/modules/builder_dropcaps.js",array('jquery'),$theme_version,true);
		wp_enqueue_script('dropcaps-js');
	}
}