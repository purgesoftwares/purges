<?php
/**
 * The class to register, update and display blocks
 *
 * It provides an easy API for people to add their own blocks
 * to the Aqua Page Builder
 *
 * @package Aqua Page Builder
 */

$aq_registered_blocks = array();

if(!class_exists('AQ_Block')) {
	class AQ_Block {

	 	//some vars
	 	var $id_base;
	 	var $block_options;
	 	var $instance;

	 	/* PHP5 constructor */
	 	function __construct($id_base = false, $block_options = array()) {
	 		$this->id_base = isset($id_base) ? strtolower($id_base) : strtolower(get_class($this));
	 		$this->name = isset($block_options['name']) ? $block_options['name'] : ucwords(preg_replace("/[^A-Za-z0-9 ]/", '', $this->id_base));
	 		$this->block_options = $this->parse_block($block_options);
	 	}

	 	/**
	 	 * Block - display the block on front end
	 	 *
	 	 * Sub-class MUST override this or it will output an error
	 	 * with the class name for reference
	 	 */
	 	function block($instance) {
	 		extract($instance);
	 		echo __('function AQ_Block::block should not be accessed directly. Output generated by the ', 'circleflip-builder') . strtoupper($id_base). ' Class';
	 	}

	 	/**
	 	 * The callback function to be called on blocks saving
	 	 *
	 	 * You should use this to do any filtering, sanitation etc. The default
	 	 * filtering is sufficient for most cases, but nowhere near perfect!
	 	 */
	 	function update($new_instance, $old_instance) {

	 		$new_instance = array_map('stripslashes_deep', $new_instance);
	 		return $new_instance;
	 	}

		function stripslashes_deep($value)
		{
		    $value = is_array($value) ?
		                array_map('stripslashes_deep', $value) :
		                stripslashes($value);

		    return $value;
		}
	 	/**
	 	 * The block settings form
	 	 *
	 	 * Use subclasses to override this function and generate
	 	 * its own block forms
	 	 */
	 	function form($instance) {
	 		echo '<p class="no-options-block">' . __('There are no options for this block.', 'circleflip-builder') . '</p>';
	 		return 'noform';
	 	}

	 	/**
	 	 * Form callback function
	 	 *
	 	 * Sets up some default values and construct the basic
	 	 * structure of the form. Unless you know exactly what you're
	 	 * doing, DO NOT override this function
	 	 */
	 	function form_callback($instance = array()) {
	 		//insert block options into instance
	 		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;

	 		//insert the dynamic block_id
	 		$this->block_id = 'aq_block_' . $instance['number'];
	 		$instance['block_id'] = $this->block_id;
	 		//display the block
	 		$this->before_form($instance);
	 		$this->form($instance);
	 		$this->after_form($instance);
	 	}

	 	/**
	 	 * Block callback function
	 	 *
	 	 * Sets up some default values. Unless you know exactly what you're
	 	 * doing, DO NOT override this function
	 	 */
	 	function block_callback($instance,$saved_blocks) {
	 		//insert block options into instance
	 		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;

	 		//insert the dynamic block_id
	 		$this->block_id = 'aq_block_' . $instance['number'];
	 		$instance['block_id'] = $this->block_id;

	 		//display the block
	 		$this->before_block($instance);
	 		$this->block($instance);
	 		$this->after_block($instance);
	 	}

	 	/* assign default block options if not yet set */
	 	function parse_block($block_options) {
	 		$defaults = array(
	 			'id_base' => $this->id_base,	//the classname
	 			'order' => 0, 					//block order
	 			'name' => $this->name,			//block name
	 			'size' => 'span12',				//default size
	 			'title' => '',					//title field
	 			'parent' => 0,					//block parent (for blocks inside columns)
	 			'number' => '__i__',			//block consecutive numbering
	 			'first' => false,				//column first
	 			'resizable' => 1,				//whether block is resizable/not
	 		);

	 		$block_options = is_array($block_options) ? wp_parse_args($block_options, $defaults) : $defaults;

	 		return $block_options;
	 	}


	 	//form header
	 	function before_form($instance) {
	 		extract($instance);
			add_thickbox();
	 		$title = isset($title) ? '' : '';
			$blockID = isset($blockID) ? $blockID : '';
			$imagedesc = isset($imagedesc) ? $imagedesc : '';
			$desc = isset($desc) ? $desc : '';
	 		$resizable = $resizable ? '' : 'not-resizable';
			$home = isset( $home ) ? $home : '';
//		if(isset($home) && !empty($home)){
	 		echo '<li id="template-block-'.$number.'" class="block block-'.$id_base.' '. $size .' '.$resizable.' '. $home .'">',
					'<dl class="block-bar">';
					if (!empty($imagedesc) || !empty($desc)) {
						echo '<div class="block-popup stillOut">';
						if (!empty($imagedesc)) {
 						echo '<div class="block-imagedesc">',
	 							 '<img src="'.get_template_directory_uri().'/creiden-framework/content-builder/assets/images/blocks/'.$imagedesc.'" alt=""/>',
	 						'</div>';
						}
						if (!empty($desc)) {
 						echo	'<div class="block-desc">',
		 							'<p>'.$desc.'</p>',
		 						'</div>';
						}
 						echo '</div>';
					}
					echo '<ul class="block-controls">',
	 							'<li class="block-control-actions cf"><a href="#" class="delete" data-tooltip="tooltip" data-original-title="Remove"><span class="icon-trash"></span></a></li>
								 <li class="block-control-actions cf"><a href="#" class="clone" data-tooltip="tooltip" data-original-title="Duplicate"><span class="icon-docs"></span></a></li>';
								if($instance['name'] != 'Column' && $instance['name'] != 'Team Wrapper') {
									echo '<li class="block-control-actions cf"><a href="#block-settings-' . $number . '" class="block-edit" data-toggle="stackablemodal" data-tooltip="tooltip" data-original-title="Edit" data-keyboard="true"><span class="icon-pencil"></span></a></li>';
								} else {
									echo '<li class="block-control-actions cf"><a href="#my-column-content-'.$number.'" class="block-edit" data-toggle="stackablemodal" data-tooltip="tooltip" data-original-title="Edit Column"><span class="icon-pencil"></span></a></li>';
								}
								echo '<li class="block-control-actions cf"><a href="#" class="export" data-tooltip="tooltip" data-original-title="Export Block"><span class="icon-upload"></span></a></li>';
							echo '</ul>';
	 				echo	'<dt class="block-handle">',
	 						'<div class="block-image">',
	 							'<img src="'.get_template_directory_uri().'/creiden-framework/content-builder/assets/images/'.$image.'" alt=""/>',
	 						'</div>';
							if($instance['name'] != 'Column' && $instance['name'] != 'Team Wrapper') {
	 						echo '<ul class="resizeButtons">
		 							<li>
				 						<a href="#" class="resizePlus icon-plus-1"></a>
				 						<a href="#" class="resizeMinus icon-minus"></a>
	  								</li>
  								</ul>';
  								}
	 						echo '<div class="block-title">',
	 							$name;
	 							echo ($blockID) ? ' - ' . sanitize_title_with_dashes($blockID) : '',
	 						'</div>
	 						<div class="block-size">',
	 							substr($size, 4).'/12',		
	 						'</div>',
	 					'</dt>',
	 				'</dl>';
					if($instance['name'] == 'Column' || $instance['name'] == 'Team Wrapper')
	 					echo '<div class="block-settings cf" id="block-settings-'.$number.'">';
					else
						echo '<div class="block-settings cf modal fade" id="block-settings-'.$number.'">';
	 				if($instance['name'] == 'Column' || $instance['name'] == 'Team Wrapper')
	 					echo '<div id="my-content-'.$number.'">';
					else {
						?>
						  <div class="modal-dialog modal-lg" tabindex='-1'>
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title"><?php echo esc_html($this->name) ?></h4>
								<div style="display: inline">
									<label for="blockID">#</label><input type="text" name="aq_blocks[<?php echo esc_attr($block_id) ?>][blockID]" value="<?php echo sanitize_title_with_dashes($blockID) ?>" class="blockID" placeholder="block-id"/>
								</div>
								<span type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></span>
							  </div>
							  <div class="modal-body" id="my-content-<?php echo esc_attr($number) ?>">
						<?php
					}
	 	}
 
	 	//form footer
	 	function after_form($instance) {
	 		extract($instance);

	 		$block_saving_id = 'aq_blocks[aq_block_'.$number.']';

	 			echo '<input type="hidden" class="id_base" name="'.$this->get_field_name('id_base').'" value="'.$id_base.'" />';
	 			echo '<input type="hidden" class="name" name="'.$this->get_field_name('name').'" value="'.$name.'" />';
	 			echo '<input type="hidden" class="order" name="'.$this->get_field_name('order').'" value="'.$order.'" />';
	 			echo '<input type="hidden" class="size" name="'.$this->get_field_name('size').'" value="'.$size.'" />';
	 			echo '<input type="hidden" class="parent" name="'.$this->get_field_name('parent').'" value="'.$parent.'" />';
	 			echo '<input type="hidden" class="number" name="'.$this->get_field_name('number').'" value="'.$number.'" />';
				?>
				</div>
				<div class="modal-footer">
					<button class="button-primary" type="button" data-dismiss="modal">Done</button>
				</div>
				</div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		  <?php
	 		echo '</li>';
	 	}

	 	/* block header */
	 	function before_block($instance) {
	 		extract($instance);
	 		$column_class = $first ? 'aq-first' : '';
			$blockID = isset($blockID) ? $blockID : '';
			$classCol = '';
			if($instance['id_base'] == 'aq_column_block'){
				$padding_column = $instance['padding_col'];
				switch($padding_column){
					case '0': $classCol = 'none';
						break;
					case '1': $classCol = 'small';
						break;
					case '2': $classCol = 'medium';
						break;
					case '3': $classCol = 'large';
						break;
					default : $classCol = 'none';
				}
			}
			 $blockIDTitle = sanitize_title_with_dashes($blockID);
			 		if(isset($blockIDTitle) && !empty($blockIDTitle)) {
						?>
							<div id="<?php echo sanitize_title_with_dashes($blockID) ?>">
						<?php
						}
		 					echo '<div id="aq-block-'.$number.'" class="aq-block aq-block-'.$id_base.' '.$size.' '.$column_class.' '. $classCol .' cf" data-width="'.substr($size, 4).'">';
						?>
				<?php
	 	}

	 	/* block footer */
	 	function after_block($instance) {
	 		extract($instance);
	 		echo '</div>';
			$blockID = isset($blockID) ? $blockID : '';
			$blockIDTitle = sanitize_title_with_dashes($blockID);
	 		if(isset($blockIDTitle) && !empty($blockIDTitle)) {
	 			echo '</div>';
			}
	 	}

	 	function get_field_id($field) {
	 		$field_id = isset($this->block_id) ? $this->block_id . '_' . $field : '';
	 		return $field_id;
	 	}

	 	function get_field_name($field) {
	 		$field_name = isset($this->block_id) ? 'aq_blocks[' . $this->block_id. '][' . $field . ']': '';
	 		return $field_name;
	 	}

	}
}