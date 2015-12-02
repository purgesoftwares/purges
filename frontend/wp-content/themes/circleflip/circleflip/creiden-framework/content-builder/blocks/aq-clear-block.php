<?php
/** "Clear" block
 *
 * Clear the floats vertically
 * Optional to use horizontal lines/images
**/
class AQ_Clear_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'divider.png',
			'name' => 'Divider',
			'size' => 'span6',
			'tab' => 'Layout',
			'imagedesc' => 'divider.jpg',
			'desc' => 'Used as a spacer between blocks OR for adding styled dividers.'
		);

		//create the block
		parent::__construct('aq_clear_block', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'horizontal_line' => 'none',
			'line_color' => '#353535',
			'pattern' => '1',
			'height' => '20',
			'height_line' => '2',
			'Number of lines' =>'1',
			'divider_image' => ''
		);

		$line_options = array(
			'none' => 'None',
			'line' => 'line',
			'dotted' => 'Dotted',
			'image' => 'Use Image',
		);

		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$line_color = isset($line_color) ? $line_color : '#353535';
		$number_lines = isset($number_lines) ? $number_lines : '1';
		$height_line = isset($height_line) ? $height_line : '2';
		?>

		<p class="description note">
			<?php _e('Use this block to clear the floats between two or more separate blocks vertically.', 'circleflip-builder') ?>
		</p>
		<p class="description fourth ClearType">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('line_color') ) ?>">
					<!--Pick a horizontal line-->
					<?php _e( 'Divider style', 'circleflip-builder' ) ?>
				</label>
			</span>
			<span class="rightHalf">
				<span class="rightHalf select">
					<?php echo circleflip_field_select('horizontal_line', $block_id, $line_options, $horizontal_line, array('data-fd-handle="line_type"')); ?>
				</span>
			</span>
		</p>
		<p class="description fourth ClearNumberOfLine" data-fd-rules='["line_type:regex:line|dotted"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('number_lines') ) ?>">
					<?php _e('How many Lines ?', 'circleflip-builder') ?>
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('number_lines', $block_id, $number_lines, 'min', 'number') ?> Line(s)
			</span>
		</p>

		<div class="description fourth ClearHeight">
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('height') ) ?>">
					<?php _e( 'Height', 'circleflip-builder' ) //TODO: better text ?>
				</label>
				<span class="description_text">
					<?php _e( 'How much spacing around the divider, the value is split between up & bottom', 'circleflip-builder' ) ?>
				</span>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('height', $block_id, $height, 'min', 'number') ?> px
			</span>
		</div>
		<div class="description fourth ClearHeightLine" data-fd-rules='["line_type:regex:line|dotted"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('height_line') ) ?>">
					<?php _e( 'Divider Thickness', 'circleflip-builder' ) ?>
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_input('height_line', $block_id, $height_line, 'min', 'number') ?> px
			</span>
		</div>
		<div class="description half last clearLineColor" data-fd-rules='["line_type:regex:line|dotted"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('line_color') ) ?>">
					Pick a line color
				</label>
			</span>
			<span class="rightHalf">
				<?php echo circleflip_field_color_picker('line_color', $block_id, $line_color, $defaults['line_color']) ?>
			</span>
		</div>
		<div class="description half last clearLineImage" data-fd-rules='["line_type:equal:image"]'>
			<span class="leftHalf">
				<label for="<?php echo esc_attr( $this->get_field_id('divider_image') ) ?>">
					Choose your image
				</label>
			</span>
			<span class="rightHalf">
				<?php 
				$image_id = isset($divider_imageid) ? $divider_imageid : '';
				$image_value = isset($divider_image) ? $divider_image : '';echo circleflip_field_upload_new('divider_image', $block_id, $image_value,$image_id) ?>
			</span>
		</div>
		<?php

	}


	function block($instance) {
		extract($instance);
		if($height == ''){
			$height = 1;
		}
		if($height_line == ''){
			$height_line = 1;
		}
		if($number_lines == ''){
			$number_lines = 1;
		}
		switch($horizontal_line) {
			case 'none':
				echo '<div class="cf divider" style="height:'.esc_attr($height).'px"></div>';
				break;
			case 'line':
				$marginTop = (($height/2)-20);
				if($marginTop < 0){
					$marginTop = 0;
				}
				echo '<div style="margin:'.esc_attr($marginTop).'px 0 '.esc_attr((($height/2))).'px;">';
				for($i=0; $i<$number_lines; $i++){
					echo '<div class="cf line divider" style="height:'.esc_attr($height_line).'px; background :'.esc_attr($line_color).' "></div>';
				}
				echo '</div>';
				break;
			case 'dotted' :
				$marginTop = (($height/2)-20);
				if($marginTop < 0){
					$marginTop = 0;
				}
				echo '<div style="margin:'.esc_attr($marginTop).'px 0 '.esc_attr((($height/2))).'px;">';
				for($i=0; $i<$number_lines; $i++){
					echo '<div class="cf dotted divider" style="height:'.esc_attr($height_line).'px; border-top : '.esc_attr($height_line).'px dotted '.esc_attr($line_color).' "></div>';
				}
				echo '</div>';
				break;
			case 'image':
				?>
				<div class="dividerImg" style="height:<?php echo esc_attr($height); ?>px">
				<?php 
				echo wp_get_attachment_image( $divider_imageid, 'full' );
					break;
				?>
				</div>
				<?php
		}
	}

}