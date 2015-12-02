<?php
/**
 * Aqua Page Builder functions
 *
 * This holds the external functions which can be used by the theme
 * Requires the AQ_Page_Builder class
 *
 * @todo - multicheck, image checkbox, better colorpicker
**/

if(class_exists('AQ_Page_Builder')) {

	/**
	 * Core functions
	*******************/

	/* Register a block */
	function circleflip_register_block($block_class) {
		global $aq_registered_blocks;
		$aq_registered_blocks[strtolower($block_class)] = new $block_class;
	}

	/** Un-register a block **/
	function circleflip_unregister_block($block_class) {
		global $aq_registered_blocks;
		$block_class = strtolower($block_class);
		foreach($aq_registered_blocks as $block) {
			if($block->id_base == $block_class) unset($aq_registered_blocks[$block_class]);
		}
	}

	/**
	 * Get list of all blocks
	 * @param $importer: Boolean to check if data is being imported or not
	 */
	function circleflip_get_blocks($template_id,$saved_blocks, $importer = false) {
		global $aq_page_builder;
		$aqpb_config = circleflip_page_builder_config();
		$aq_page_builder = new AQ_Page_Builder($aqpb_config);
		$blocks = $aq_page_builder->retrieve_blocks($template_id,$saved_blocks, $importer);
		return $blocks;
	}

	/**
	 * Form Field Helper functions
	 *
	 * Provides some default fields for use in the blocks
	 *
	 * @todo build this into a separate class instead!
	********************************************************/

	/* Input field - Options: $size = min, small, full */
	function circleflip_field_input($field_id, $block_id, $input, $size = 'full', $type = 'text') {
		$output = '<input type="'.$type.'" id="'. $block_id .'_'.$field_id.'" class="input-'.$size.'" value="'.$input.'" name="aq_blocks['.$block_id.']['.$field_id.']">';

		return $output;
	}

	/* Textarea field */
	function circleflip_field_textarea($field_id, $block_id, $text, $size = 'full') {
		$output = '<textarea id="'. $block_id .'_'.$field_id.'" class="textarea-'.$size.'" name="aq_blocks['.$block_id.']['.$field_id.']" rows="5">'.$text.'</textarea>';

		return $output;
	}


	/* Select field */
	function circleflip_field_select( $field_id, $block_id, $options, $selected, $extra = array() ) {
		$options = is_array($options) ? $options : array();
		$output = '<select id="' . $block_id . '_' . $field_id . '" name="aq_blocks[' . $block_id . '][' . $field_id . ']"' . implode( ' ', $extra ) . '>';
		foreach($options as $key=>$value) {
			$output .= '<option value="'.$key.'" '.selected( $selected, $key, false ).'>'.htmlspecialchars($value).'</option>';
		}
		$output .= '</select>';

		return $output;
	}

	/* Multiselect field */
	function circleflip_field_multiselect($field_id, $block_id, $options, $selected_keys = array()) {
		$output = '<select id="'. $block_id .'_'.$field_id.'" multiple="multiple" class="select of-input" name="aq_blocks['.$block_id.']['.$field_id.'][]">';
		foreach ($options as $key => $option) {
			$selected = (is_array($selected_keys) && in_array($key, $selected_keys)) ? $selected = 'selected="selected"' : '';
			$output .= '<option id="'. $block_id .'_'.$field_id.'_'. $key .'" value="'.$key.'" '. $selected .' />'.$option.'</option>';
		}
		$output .= '</select>';

		return $output;
	}

	/* Color picker field */
	function circleflip_field_color_picker($field_id, $block_id, $color, $default = '') {
		$output = '<span class="aqpb-color-picker">';
			$output .= '<input type="text" id="'. $block_id .'_'.$field_id.'" class="input-color-picker" value="'. $color .'" name="aq_blocks['.$block_id.']['.$field_id.']" data-default-color="'. $default .'"/>';
		$output .= '</span>';

		return $output;
	}

	/* Single Checkbox */
	function circleflip_field_checkbox( $field_id, $block_id, $check, $extra = array() ) {
		
		$output = '<input type="hidden" name="aq_blocks['.$block_id.']['.$field_id.']" value="0" />';
		$output .= '<input type="checkbox" id="'. $block_id .'_'.$field_id.'" class="input-checkbox" name="aq_blocks['.$block_id.']['.$field_id.']" '. checked( 1, $check, false ) 
				.' value="1"'
				. implode( ' ', $extra ) . '/>';
		return $output;
	}

	/* Multi Checkbox */
	function circleflip_field_radioButtonIcon($field_id, $block_id, $fields = array(), $selected) {
		return circleflip_builder_icon_selector( "aq_blocks[{$block_id}][{$field_id}]", $selected );
	}
	
	function circleflip_builder_icon_selector( $field_id, $selected = '' ) {
		ob_start(); ?>
		<div class="crdn-icon-selector">
			<a href="#crdn-icon-selector-modal" data-toggle="stackablemodal"><?php _e( 'Pick an icon', 'circleflip-builder' ) ?></a>
			<input type="hidden" class="crdn-selected-icon" name="<?php echo esc_attr($field_id) ?>" value="<?php echo esc_attr($selected) ?>">
			<i class="iconfontello preview <?php echo esc_attr($selected) ?>"></i>
		</div>
		<?php
		return ob_get_clean();
	}

	/* Media Uploader */
	function circleflip_field_upload($field_id, $block_id, $media, $media_type = 'image', $default = '') {
		if(!isset($media) || empty($media))
			$media = $default;
		$output  = '<input type="text" readonly id="'. $block_id .'_'.$field_id.'" class="input-full input-upload" value="'.$media.'" name="aq_blocks['.$block_id.']['.$field_id.']">';
		$output .= '<a href="#" class="aq_upload_button button" rel="'.$media_type.'">Upload</a>';
		$output .= '<a class="remove_image button" style="float:right;">Remove</a>';

		return $output;
	}
	
	/**/
	function circleflip_field_upload_new($field_id, $block_id, $media, $image_id, $media_type = 'image', $default = '') {
		if(!isset($media) || empty($media))
			$media = $default;
		$output = '<img class="screenshot" src="'.$media.'" alt=""/>
				<input type="hidden" id="'.$block_id.'_'.$field_id.'_imageid" name="aq_blocks['.$block_id.']['.$field_id.'id]" value="'.$image_id.'" />';
		$output  .= '<input type="text" readonly id="'. $block_id .'_'.$field_id.'" class="input-full input-upload" value="'.$media.'" name="aq_blocks['.$block_id.']['.$field_id.']">';
		$output .= '<a href="#" class="aq_upload_button button" rel="'.$media_type.'">Upload</a><a class="remove_image button" style="float:right;">Remove</a><p></p>';
	
		return $output;
	}
	/**
	 * Misc Helper Functions
	**************************/

	/** Get column width
	 * @parameters - $size (column size), $grid (grid size e.g 940), $margin
	 */
	function circleflip_get_column_width($size, $grid = 940, $margin = 20) {

		$columns = range(1,12);
		$widths = array();
		foreach($columns as $column) {
			$width = (( $grid + $margin ) / 12 * $column) - $margin;
			$width = round($width);
			$widths[$column] = $width;
		}

		$column_id = absint(preg_replace("/[^0-9]/", '', $size));
		$column_width = $widths[$column_id];
		return $column_width;
	}

	/** Recursive sanitize
	 * For those complex multidim arrays
	 * Has impact on server load on template save, so use only where necessary
	 */
	function circleflip_recursive_sanitize($value) {
		if(is_array($value)) {
			$value = array_map('circleflip_recursive_sanitize', $value);
		} else {
			$value = htmlspecialchars(stripslashes($value));
		}
		return $value;
	}

}

/*
 * Add Custom Buttons to page builder tinymce
 */
// Add New Document Button
if ( ! function_exists( 'circleflip_mce_buttons_first_row' ) ) {
	function circleflip_mce_buttons_first_row( $buttons ) {
		array_unshift( $buttons, 'newdocument' ); // Add New Document Button
		return $buttons;
	}
}

// Enable font size & font family selects in the editor, Removes the forecolor from the second row
if ( ! function_exists( 'circleflip_mce_buttons' ) ) {
	function circleflip_mce_buttons( $buttons,$editor_id ) {
		if ( 'content' === $editor_id ) {
			return $buttons;
		}
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		array_unshift( $buttons, 'styleselect' );
		$remove_key = array_search('forecolor', $buttons);
		unset($buttons[$remove_key]);
		return $buttons;
	}
}


if ( ! function_exists( 'circleflip_mce_buttons2' ) ) {
	function circleflip_mce_buttons2( $buttons,$editor_id ) {
		if ( 'content' === $editor_id ) {
			return $buttons;
		}
		array_push( $buttons, 'cut' ); // Add Font Select
		array_push( $buttons, 'copy' ); // Add Font Size Select
		array_push( $buttons, 'paste');
		array_push($buttons, 'backcolor');
		array_push($buttons, 'forecolor');
		return $buttons;
	}
}
// Customize mce editor font sizes
if ( ! function_exists( 'circleflip_mce_text_sizes' ) ) {
	function circleflip_mce_text_sizes( $initArray,$editor_id ){
		if ( 'content' === $editor_id ) {
			return $initArray;
		}
			$initArray['fontsize_formats'] = "9px 10px 11px 12px 13px 14px 16px 18px 20px 22px 24px 26px 28px 30px 32px 34px 36px 38px 40px 44px 48px 50px 54px";
			$initArray['font_formats'] = "Andale Mono=andale mono,times;Droid Kufi Regular=DroidArabicKufi,arial;Inika =inikaNormal,arial;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Source Sans=sourceSans,arial;Source Sans Semibold=sourceSansBold,arial;Source Sans Light=sourceSansLight,arial;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats";	
		return $initArray;
	}
}