<?php
/** A simple text block **/
class CR_SC_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'shortcode.png',
			'name' => 'Shortcode',
			'size' => 'span6',
                        'imagedesc' => 'shortcode.jpg',
                        'tab' => 'Content',
                        'desc' => 'A Block for your shortcodes, this example is for a revolution slider shortcode.'
		);

		//create the block
		parent::__construct('cr_sc_block', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'text' => '',
			'margin_bottom' => '20px'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('text') ) ?>">
					Content
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</span>
		</p>
		<p class="description">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('margin_bottom') ) ?>">
					Margin Bottom
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('margin_bottom', $block_id, $margin_bottom, 'min', 'number') ?>px
			</span>
		</p>
		<p class="description">
			<span class="leftHalf ">
				<label for="<?php echo esc_attr( $this->get_field_id('fullwidthSlider') ) ?>">
					Full Width Shortcode ?
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php
						$sliders_options = array(
							'normalwidth' => 'Normal Width',
							'fullwidth' => 'Full Width'
						);
					?>
					<?php echo circleflip_field_select('fullwidthSlider', $block_id, $sliders_options, isset($fullwidthSlider) ? $fullwidthSlider : 'normalwidth') ?>
				</span>
			</span>
		</p>
		<?php
	}

	function block($instance) {
		$defaults = array(
			'text' => '',
			'margin_bottom' => '20px'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		$class = '';
		if($fullwidthSlider == 'fullwidth') {
			$class = 'noContainer';
		}
		$this->scBlock_method();
		echo "<div class='".esc_attr($class)."' style='margin-bottom:".esc_attr($margin_bottom)."px'>";
			echo do_shortcode(htmlspecialchars_decode($text));
		echo "</div>";
	}
	function scBlock_method() {
		wp_register_style('SCCSS',get_template_directory_uri() . "/css/content-builder/shortcode_section.css",array('circleflip-style'),'2.0.3');
		wp_enqueue_style('SCCSS');
		wp_register_script('SCJS',get_template_directory_uri() . "/scripts/modules/builder_contact_form.js",array('jquery'),'2.0.3',true);
		wp_enqueue_script('SCJS');
	}
}