<?php
/**
 * Core functions
 */
if(class_exists('header_builder')) {
	/* Register a block */
	function creiden_register_header_block($header_block_class) {
		global $header_registered_blocks;
		$header_registered_blocks[strtolower($header_block_class)] = new $header_block_class;
	}
	
	function creiden_hb_select($header_name,$id_base ='',$order = '',$options  = array(),$name = '',$selected  = '') {
			$options = is_array($options) ? $options : array();
			$output = '<div class="col-sm-5">
							<select id="' . $id_base . '_' . $order . '" name="'.$header_name.'[hb_block_' . $order . '][' . $name . ']">';
								foreach($options as $key=>$value) {
									$output .= '<option value="'.$key.'" '.selected( $selected, $key, false ).'>'.htmlspecialchars($value).'</option>';
								}
			$output .= 		'</select>
						</div>';
		return $output;
	}
	
	function creiden_hb_select_multiple($header_name,$id_base ='',$order = '',$options  = array(),$name = '',$selected_keys  = array()) {
			$options = is_array($options) ? $options : array();
			$output = '<div class="col-sm-5">
							<select id="' . $id_base . '_' . $order . '" name="'.$header_name.'[hb_block_' . $order . '][' . $name . '][]" multiple>';
								foreach($options as $key=>$value) {
									$selected = (is_array($selected_keys) && in_array($key, $selected_keys)) ? $selected = 'selected="selected"' : '';
									$output .= '<option value="'.$key.'" '.$selected.'>'.htmlspecialchars($value).'</option>';
								}
			$output .= 		'</select>
						</div>';
		return $output;
	}
	
	/* Single Checkbox */
	function creiden_hb_checkbox( $header_name,$id_base, $order, $name, $check) {
			$output = '<div class="col-sm-5">
							<input type="hidden" name="'.$header_name.'[hb_block_'.$order.']['.$name.']" value="0" />
							<input type="checkbox" id="'. $id_base .'_'.$order.'" class="input-checkbox" name="'.$header_name.'[hb_block_' . $order . '][' . $name . ']" '. checked( 1, $check, false ) .' value="1"/>
						</div>';
		return $output;
	}
	
	/* Media Uploader */
	function creiden_hb_upload($header_name,$id_base, $order, $name, $media, $image_id, $default = '') {
		if(!isset($media) || empty($media))
			$media = $default;
		$output = "<div class='col-sm-5'>";
		
			$output .=  '<img class="screenshot" src="'.$media.'" style="max-width: 100%;" alt=""/>
						<input type="hidden" id="'.$id_base.'_'.$order.'_imageid" name="'.$header_name.'[hb_block_' . $order . '][' . $name . 'id]" value="'.$image_id.'" />';
			$output .= '<input type="text" readonly id="'. $id_base .'_'.$order.'_uploader" class="input-full input-upload" value="'.$media.'" name="'.$header_name.'[hb_block_' . $order . '][' . $name . ']">';
			$output .= '<a href="#" class="aq_upload_button button" rel="image">Upload</a><a class="remove_image button" style="float:right;">Remove</a><p></p>';
			
		$output .= "</div>";
		return $output;
	}
	
	/* Input Field */
	function creiden_hb_input( $header_name,$id_base, $order, $name, $input, $size = 'full', $type = 'text') {
			$output = '<div class="col-sm-5">
							<input type="'.$type.'" class="input-'.$size.'" value="'.$input.'" name="'.$header_name.'[hb_block_' . $order . '][' . $name . ']">
					   </div>';
		return $output;
	}

	/* Color picker field */
	function creiden_hb_color_picker($header_name,$id_base, $order, $name, $color, $default = '') {
		$output = '<div class="col-sm-5">
						<span class="aqpb-color-picker">
							<input type="text" class="input-color-picker" value="'. $color .'" name="'.$header_name.'[hb_block_' . $order . '][' . $name . ']" data-default-color="'. $default .'"/>
						</span>
				   </div>';

		return $output;
	}
	
	/* Input Field */
	function creiden_hb_iconselector_input( $header_name,$id_base, $order, $name, $input, $number, $size = 'full', $type = 'text') {
			$output = '<div class="col-sm-6">
							<input type="'.$type.'" class="input-'.$size.'" value="'.$input.'" name="'.$header_name.'[hb_block_' . $order . '][' . $name . '][' . $number . ']">
					   </div>';
		return $output;
	}
	function creiden_hb_icon_selector( $header_name,$order, $selected = '', $name, $number ) {
		ob_start(); ?>
		<button type="button" class="btn btn-danger removeSocial pull-right">
			<span class="icon-trash"></span>
		</button>
		<div class="crdn-icon-selector pull-right">
			<a href="#crdn-icon-selector-modal" class="btn btn-default" data-toggle="stackablemodal"><?php _e( 'Pick an icon', 'circleflip-builder' ) ?></a>
			<input type="hidden" class="crdn-selected-icon" name="<?php echo esc_attr($header_name.'[hb_block_'.$order.']['.$name.']['.$number.']') ?>" value="<?php echo esc_attr($selected) ?>">
			<i class="iconfontello preview <?php echo esc_attr($selected) ?>"></i>
		</div>
		<?php
		return ob_get_clean();
	}
	
	// Ajax Function to remove the header
	function remove_header() {
		$header_name = $_POST['headerName'];
		$hb_names = get_option('hb_names');
		$key = array_search($header_name, $hb_names);
		unset($hb_names[$key]);
		update_option('hb_names',$hb_names);
		delete_option($header_name);
		die;
	}
	add_action('wp_ajax_remove_header','remove_header');
	
}