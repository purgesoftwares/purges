<?php
/**
 * 
 */
class header_builder {
	
	function __construct($id_base = false, $block_options = array()) {
 		$this->id_base = isset($id_base) ? strtolower($id_base) : strtolower(get_class($this));
 		$this->name = isset($block_options['name']) ? $block_options['name'] : ucwords(preg_replace("/[^A-Za-z0-9 ]/", '', $this->id_base));
		$this->image = isset($block_options['image']) ? $block_options['image'] : '';
 		$this->class = isset($block_options['class']) ? $block_options['class'] : '';
 		$this->block_options = $this->parse_block($block_options);
		
 	}
	/**
	 * Display blocks of header
	 *
	 * @since	1.0.0
	 */
	function render_blocks($header_name) {
		global $header_registered_blocks;
		foreach ($header_registered_blocks as $key => $block) { ?>
			<li class="<?php echo ($block->block_options['id_base'] == 'header_row') ? 'hbHeaderRowWrapper' :'' ?>">
				<p class="hbBtn"><span class="<?php echo esc_attr($block->block_options['class']) ?>"></span><?php echo esc_html($block->block_options['name']) ?></p>
				<div class="hbBlockWrapper">
					<div id="header-block__i__"  class="hbBlock <?php echo ($block->block_options['id_base'] == 'header_row') ? 'hbHeaderRow' : 'hbLeft'; ?>">
						<?php if($block->block_options['id_base'] == 'header_row') {?><div class="hbBlockTitle clearfix"><?php } ?>
						<p>
							<?php echo esc_html($block->block_options['name']) ?>
						</p>
						<div class="hbBlockSettings">
							<div class="hbBlockEdit" data-toggle="modal" data-target="#hb_block_modal__i__">
								<span class="hbSprite-edit icon-pencil"></span>
							</div>
							<div class="hbBlockDelete">
								<span class="hbSprite-delete icon-trash"></span>
							</div>
						</div>
						<?php if($block->block_options['id_base'] == 'header_row') {?></div> <?php } ?>
						<?php if($block->block_options['id_base'] == 'header_row') {?> 
							<div class="hbRowBlocks clearfix">
								
							</div>
						<?php }  ?>
						<div class="hbSettings">
							<input type="hidden" class="id_base" 	name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block->block_options['number']) ?>][id_base]"	 value="<?php echo esc_attr($block->block_options['id_base']) ?>">
							<input type="hidden" class="name" 	 	name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block->block_options['number']) ?>][name]"		 value="<?php echo esc_attr($block->block_options['name']) ?>">
							<input type="hidden" class="class"		name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block->block_options['number']) ?>][class]" 	 value="<?php echo esc_attr($block->block_options['class']) ?>">
							<input type="hidden" class="order"   	name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block->block_options['number']) ?>][order]"	 value="1">
							<input type="hidden" class="is_row"  	name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block->block_options['number']) ?>][is_row]" 	 value="0">
							<input type="hidden" class="parent_id"  name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block->block_options['number']) ?>][parent_id]" value="0">
							<input type="hidden" class="is_left"	name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block->block_options['number']) ?>][is_left]" 	 value="0">
						</div>
						<?php $this->block_form($header_name,$block->block_options);?> 
					</div>
				</div>
			</li>
			<?php
		}
	}
	/**
	 * Display blocks of header in the header builder page
	 *
	 * @since	1.0.0
	 */
	function render_blocks_admin($header_blocks,$header_name) {
		global $header_registered_blocks;
		foreach ($header_blocks as $key => $block) {
			if($key !== 'settings' && isset($block['name'])) { ?>
				<div class="hbBlockWrapper">
					<div id="header-block<?php echo esc_attr($block['order']); ?>"  class="hbBlock <?php echo ($block['id_base'] == 'header_row') ? 'hbHeaderRow' : 'hbLeft'; /*echo ($block['is_left'] == 1) ? '' : ' hbLeft'; */?>">
						<?php if(isset($block['id_base']) && $block['id_base'] == 'header_row') {?><div class="hbBlockTitle clearfix"><?php } ?>
						<p>
							<?php echo esc_html($block['name']) ?>
						</p>
						<div class="hbBlockSettings">
							<div class="hbBlockEdit" data-toggle="modal" data-target="#hb_block_modal<?php echo esc_attr($block['order']); ?>">
								<span class="hbSprite-edit icon-pencil"></span>
							</div>
							<div class="hbBlockDelete">
								<span class="hbSprite-delete icon-trash"></span>
							</div>
						</div>
						<?php if($block['id_base'] == 'header_row') { ?></div>
							<div class="hbRowBlocks clearfix">
								
								<?php
								if(isset($block['children']) && !empty($block['children'])) {
									$this->render_blocks_admin($block['children'],$header_name);
									
								}
								?>
							</div>
						 <?php } ?>
						<div class="hbSettings">
							<input type="hidden" class="id_base" 	name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block['order']) ?>][id_base]"	 value="<?php echo esc_attr($block['id_base']);   ?>">
							<input type="hidden" class="name" 	 	name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block['order']) ?>][name]"		 value="<?php echo esc_attr($block['name']); 	   ?>">
							<input type="hidden" class="order"   	name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block['order']) ?>][order]"	 value="<?php echo esc_attr($block['order']); 	   ?>">
							<input type="hidden" class="is_row"  	name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block['order']) ?>][is_row]" 	 value="<?php echo esc_attr($block['is_row']);    ?>">
							<input type="hidden" class="parent_id"  name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block['order']) ?>][parent_id]" value="<?php echo esc_attr($block['parent_id']); ?>">
							<input type="hidden" class="is_left"	name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block['order']) ?>][is_left]" 	 value="<?php echo esc_attr($block['is_left']);   ?>">
							<input type="hidden" class="class"		name="<?php echo esc_attr($header_name) ?>[hb_block_<?php echo esc_attr($block['order']) ?>][class]" 	 value="<?php echo esc_attr($block['class']);     ?>">
						</div>
						<?php 
						$this->block_form($header_name,$block);?> 
					</div>
				</div>
			<?php
			}
		}
	}

	/*
	 * This function renders the settings of each block 
	 */
	function block_form($header_name,$block) {
		global $header_registered_blocks; 
		add_thickbox();
		?>
		<!-- Modal Wrapper For jquery selection purposes -->
		<div class="modalWrapper">
			<!-- Main Modal -->
			<div class="modal fade hbModal" id="hb_block_modal<?php echo esc_attr($block['order']) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">&times;</span><span class="sr-only"></span>
							</button>
							<h4 class="modal-title" id="myModalLabel"><?php echo esc_attr($block['name']) ?></h4>
						</div>
						<div class="modal-body">
							<?php $header_registered_blocks[$block['id_base']]->form($block,$header_name); ?>
						</div>
						<div class="modal-footer">
							<p>
								Add custom class
							</p>
							<input id="customClass" type="text"/>
							<button type="button" class="btn btn-primary" data-dismiss="modal">
								Done
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Main Modal End -->
		<?php
	}
	
	function icon_selector_modal() { ?>
		<!-- Icon Selector Modal -->
		<div class="modal fade" id="crdn-icon-selector-modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="icons-box">
							<?php $icons = circleflip_get_entypo_icons() ?>
							<?php foreach($icons as $icon) : ?>
								<?php
									if($icon == 'none'){
										echo '<span class="iconfontello none" data-icon="none">none</span>';
									}else{


								 ?>
								<i class="iconfontello <?php echo esc_attr($icon) ?>" data-icon="<?php echo esc_attr($icon) ?>"></i>
								<?php } ?>
							<?php endforeach; ?>
						</div>
						<div class="icon-preview">
							<i class="iconfontello"></i>
							<p class="icon-name"></p>
						</div>
					</div>
					<div class="modal-footer">
						<button class="crdn-icon-selector-done button-primary" type="button">Done</button>
						<button class="button-secondary"  type="button" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Icon Selector Modal End-->
		<?php
	}
	/**
	  * This function prepares the blocks array by combining all the children into their corresponding parents
	  * @param takes the unreversed array that is saved inside the option
	  *  
	  */ 
	function prepare_blocks_array($header_blocks,$header_name) {
		if($header_blocks) {
			$header_blocks = array_reverse($header_blocks);
			foreach ($header_blocks as $key => $block) {
				if($key !== 'settings') {
					// setting the header name for multiple headers feature.
					$header_blocks[$key]['header_name'] = $header_name;
					// it is a nested element either block inside the row or a row inside a row
					if(isset($block['parent_id']) && $block['parent_id'] != 0) {
						// insert this element inside the previous element in the array
						$header_blocks['hb_block_'.$block['parent_id']]['children'][] = $block;
						unset($header_blocks['hb_block_'.$block['order']]);
					}
				}
			}
			foreach ($header_blocks as $key => $block) {
				if($key !== 'settings') {
					if(isset($block['children']) && !empty($block['children'])) {
						$header_blocks[$key]['children'] = array_reverse($header_blocks[$key]['children']);
					}
				}
			}
			$header_blocks = array_reverse($header_blocks);
			return $header_blocks;
		}
	}
	
	/* assign default block options if not yet set */
 	function parse_block($block_options) {
 		$defaults = array(
 			'id_base' => $this->id_base,	//the classname
 			'image' => $this->image,		//icon image
 			'order' => 0, 					//block order
 			'name' => $this->name,			//block name
 			'title' => '',					//title field
 			'is_row' => 0,					//block parent (for blocks inside columns)
 			'parent_id' => 0,				//block parent (for blocks inside columns)
 			'number' => '__i__',			//block consecutive numbering
 			'resizable' => 1,				//whether block is resizable/not
 			'class' => '',					// Extra Class for styling
 		);

 		$block_options = is_array($block_options) ? wp_parse_args($block_options, $defaults) : $defaults;

 		return $block_options;
 	}
	
	function render_blocks_view($header_name,$blocks_children=array()) {
			global $header_registered_blocks;
			if(!circleflip_valid($blocks_children)) {
				$blocks = get_option($header_name,array());
				$blocks = $this->prepare_blocks_array($blocks,$header_name);	
			} else {
				$blocks = $blocks_children;
			}
			// circleflip_print_a($blocks);
			$settings = array();
			if(isset($blocks['settings'])) {
				$settings = $blocks['settings'];
				switch ($blocks['settings']['header_type']) {
					case 0:
						$header_type = 'defaultHeader ';
						break;
					case 1:
						$header_type = 'sideHeader ';
						break;
					case 2:
						$header_type = 'overlayedHeader ';
						break;
					default:
						
						break;
				}
				switch ($settings['header_content_color']) {
					case 0:
						$content_color_settings = 'lightContent ';
						break;
					case 1:
						$content_color_settings = 'darkContent ';
						break;
					default:
						$content_color_settings = 'lightContent ';
						break;
				}
				$bgColor = $this->hex2RGB($settings['bgColor']);
				$rgba = 'rgba('.$bgColor['red'].','.$bgColor['green'].','.$bgColor['blue'].','. ($settings['opacity'] / 100) .')';
			?>
			<header class="<?php echo esc_attr($header_type); if ( is_user_logged_in() ) {echo 'adminTop';}; ?>" <?php echo 'style="background-color: '.esc_attr($rgba).'"';  //if ($settings['header_type'] == 2){echo 'style="background-color: '.$rgba.'"'; };?> content-color="<?php echo esc_attr($content_color_settings) ?>">
			<?php
			}
			if($blocks) {
				foreach ($blocks as $key => $block) {
					if(isset($block['id_base'])) {
						// circleflip_print_a($settings);
						if(!isset($block['is_row'])) {
							// renders the blocks
							echo $header_registered_blocks[$block['id_base']]->block($block);
						} else {
							// renders the row
							echo $header_registered_blocks[$block['id_base']]->block($block,$settings);	
						}					
					}
				}
			}
			
		if(isset($blocks['settings'])) {
		?>
		</header>
		<?php
		}
	}

	/**
	* Convert a hexa decimal color code to its RGB equivalent
	*
	* @param string $hexStr (hexadecimal color value)
	* @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
	* @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
	* @return array or string (depending on second parameter. Returns False if invalid hex color value)
	*/                                                                                                 
	function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
	    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
	    $rgbArray = array();
	    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
	        $colorVal = hexdec($hexStr);
	        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
	        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
	        $rgbArray['blue'] = 0xFF & $colorVal;
	    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
	        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
	        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
	        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
	    } else {
	        return false; //Invalid hex color code
	    }
	    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
	}
}

		
		
?>