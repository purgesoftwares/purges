<?php
/** A simple text block **/
class AQ_Column_Block extends AQ_Block {
	/* PHP5 constructor */
	function __construct() {

		$block_options = array(
			'image'		 => 'column.png',
			'name'		 => 'Column',
			'size'		 => 'span6',
			'test_field' => '',
			'tab'		 => 'Layout',
			'background_color' => '',
			'center_blocks' => '',
			'background_image' => '',
			'background_video' => '',
			'padding_col' => '',
			'checkParallax' => '',
			'highlight' => '',
			'imagedesc' => 'column.jpg',
			'desc' => 'Used to group several blocks, to keep a well organized page.',
			'opacityBG' => '1'
		);

		//create the widget
		parent::__construct('aq_column_block', $block_options);

	}

	function form($instance) {
		echo '<p class="empty-column">',
		__('Drag block items into this box', 'circleflip-builder'),
		'</p>';
		echo '<ul class="blocks column-blocks cf"></ul>';
	}
	/**
	 * @param $importer: Boolean to check if data is being imported or not
	 */
	function form_callback($instance = array(), $saved_blocks = array(), $importer = false) {
		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;
		//insert the dynamic block_id & block_saving_id into the array
		$this->block_id = 'aq_block_' . $instance['number'];
		$instance['block_saving_id'] = 'aq_blocks[aq_block_'. $instance['number'] .']';
		extract($instance);
		//check if column has blocks inside it

		$col_order = $order;
		//column block header
		if(isset($template_id)) {
			echo '<li id="template-block-'.$number.'" class="block block-aq_column_block cr-columns '.$size.'">',
			'<dl class="block-bar">
				<ul class="block-controls">
					<li class="block-control-actions cf">
						<a href="#" class="delete" data-tooltip="tooltip" data-original-title="Remove Column"><span class="icon-trash"></span></a>
					</li>
					<li class="block-control-actions cf">
						<a href="#my-column-content-'.$number.'" class="block-edit" data-toggle="stackablemodal" data-tooltip="tooltip" data-original-title="Edit Column"><span class="icon-pencil"></span></a>
					</li>
					<li class="block-control-actions cf">
						<a href="#" class="export" data-tooltip="tooltip" data-original-title="Export Block"><span class="icon-upload"></span></a>
					</li>
				</ul>
				<dt class="block-handle">
					<div class="block-title">Column</div>
					<div class="block-size">',
						substr($size, 4).'/12',		
					'</div>
				</dt>
			</dl>',
			'<div class="block-settings-column cf" id="block-settings-'.$number.'">',
						'<p class="empty-column">',
							__('Drag block items into this column box', 'circleflip-builder'),
						'</p>',
						'<ul class="blocks column-blocks cf">';
						$blocks = circleflip_get_blocks($template_id,$saved_blocks, $importer);
			//outputs the blocks
			if($blocks) {
				foreach($blocks as $key => $child) {
					global $aq_registered_blocks;
					$child = unserialize($child[0]);
					if(is_array($child)) {
						extract($child);
						if(isset($aq_registered_blocks[$id_base])) {
							//get the block object
							$block = $aq_registered_blocks[$id_base];
							if($parent == $col_order) {
								$block->form_callback($child);
							}
						}
					}
				}
			}
			echo 		'</ul>';

		} else {
			$this->before_form($instance);
			$this->form($instance);
		}

		//form footer
		$this->after_form($instance);
	}
 
	//form footer
	function after_form($instance) {
		extract($instance);
		$blockID = isset($blockID) ? $blockID : '';
		$block_saving_id = 'aq_blocks[aq_block_'.$number.']';
			echo '<div id="my-column-content-' . $number . '" class="modal fade" style="display: none;">';
			?>
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					  <div class="modal-header">
					  <div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
						  <h4 class="modal-title"><?php echo esc_html($this->name) ?></h4>
						  <label for="blockID">Block ID</label><input type="text" name="<?php echo esc_attr($block_saving_id) ?>[blockID]" value="<?php echo sanitize_title_with_dashes($blockID) ?>" id="blockID"/>
					  </div>
					<div class="modal-body">
							  <?php
				$this->extra_column_fields( $instance );
			echo '</div><div class="modal-footer"><button class="button-primary" type="button" data-dismiss="modal">Done</button></div></div></div></div>';
			echo '<input type="hidden" class="id_base" name="'.$this->get_field_name('id_base').'" value="'.$id_base.'" />';
			echo '<input type="hidden" class="name" name="'.$this->get_field_name('name').'" value="'.$name.'" />';
			echo '<input type="hidden" class="order" name="'.$this->get_field_name('order').'" value="'.$order.'" />';
			echo '<input type="hidden" class="size" name="'.$this->get_field_name('size').'" value="'.$size.'" />';
			echo '<input type="hidden" class="parent" name="'.$this->get_field_name('parent').'" value="'.$parent.'" />';
			echo '<input type="hidden" class="number" name="'.$this->get_field_name('number').'" value="'.$number.'" />';
		?>
				</div>
			</li>
		<?php
	}

	function extra_column_fields( $instance ) {
		extract( $instance );
		?>
			<div class="description half">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('center_blocks') ) ?>">
						Center Blocks
					</label>
					<span class="description_text">
						Center the Blocks inside it, mainly used to wrap and center the pricing tables
					</span>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_checkbox('center_blocks', 'aq_block_'.$number, (isset($center_blocks))? $center_blocks : 0); ?>
				</span>
			</div>
			<div class="description half last clearLineColor">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('background_color') ) ?>">
						Background Color
					</label>
					<span class="description_text">
						Choose background color section <b>Note: This color makes the background applied to the whole row and doesn't depend on the size of the block</b>
					</span>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_color_picker('background_color', 'aq_block_'.$number, $background_color); ?>
				</span>
			</div>
			<div class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('background_image') ) ?>">
						Background Image
					</label>
				</span>
				<span class="rightHalf">
					<?php 
					$image_id = isset($image_uploadid) ? $image_uploadid : '';
					$image_value = isset($image_upload) ? $image_upload : '';echo circleflip_field_upload_new('image_upload', 'aq_block_'.$number, $image_value,$image_id) ?>
				</span>
			</div>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('background_video') ) ?>">
						Background Video
					</label>
					<span class="description_text">
						Enter Video link
					</span>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_input('background_video', 'aq_block_'.$number, $background_video, $size = 'full') ?>
				</span>
			</p>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('opacityBG') ) ?>">
						Background opacity
					</label>
					<span class="description_text">
						Enter opacity for background color/image/video as a number between (0 and 1), <br />
						Example: 0.8, default value is 1
					</span>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_input('opacityBG', 'aq_block_'.$number, $opacityBG, $size = 'full') ?>
				</span>
			</p>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('padding_col') ) ?>">
						Padding Size
					</label>
				</span>
				<span class="rightHalf">
					<span class="rightHalf select">
						<?php echo circleflip_field_select('padding_col', 'aq_block_'.$number, array('None','small','medium','large'), isset($padding_col) ? $padding_col : 'None') ?>
					</span>
				</span>
			</p>
			<p class="description AnnouncementCheckIcon">
				<span class="leftHalf ">
					<label for="<?php echo esc_attr( $this->get_field_id('checkParallax') ) ?>">
						Enable Parallax
					</label>
				</span>
				<span class="rightHalf">
					<?php echo circleflip_field_checkbox('checkParallax', 'aq_block_'.$number, (isset($checkParallax))? $checkParallax : 0) ?>
				</span>
			</p>
			<p class="description">
				<span class="leftHalf">
					<label for="<?php echo esc_attr( $this->get_field_id('highlight') ) ?>">
						Map
					</label>
					<span class="description_text">
						use the first map block inside the column as a background
					</span>
				</span>
				<span class="rightHalf">
					<span class="rightHalf">
						<?php echo circleflip_field_checkbox( 'map_background', 'aq_block_' . $number, isset( $map_background ) ? $map_background : false ) ?>
					</span>
				</span>
			</p>
		<?php
	}

	function block_callback($instance,$saved_blocks = array()) {
		global $aq_registered_blocks;
		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;
		extract($instance);
		$col_order = $order;
		$col_size = absint(preg_replace("/[^0-9]/", '', $size));
		$this->column_enqueue();
		//column block header
		if(isset($template_id)) {
			$this->before_block( $instance, $saved_blocks );
			//define vars
			$overgrid = 0; $span = 0; $first = false;

			//check if column has blocks inside it
			$blocks = circleflip_get_blocks($template_id,$saved_blocks);
			if ( ! empty( $instance['map_background'] ) ) {
				// re-call this to remove the map used as background
				// to lazy to figure out a better way :P
				$this->get_first_map( $blocks );
			}
			//outputs the blocks ?>
			<?php 
				$image_cut = wp_get_attachment_image_src($image_uploadid,'full');
			?>
			<?php
			if($blocks) {
				$rows = $this->_wrap_children( $this->_get_children( $blocks, $instance ), $col_size );
				foreach($rows as $row) {
					echo '<div class="row">';
					if($instance['center_blocks'] == 1) {
						echo '<div class="center_pricing_blocks">';
					}
					foreach($row as $key => $child) {
//						$child = unserialize($child[0]);
						extract($child);

						if(class_exists($id_base)) {
							//get the block object
							$block = $aq_registered_blocks[$id_base];

							//insert template_id into $child
							$child['template_id'] = $template_id;

							//display the block
							if($parent == $col_order) {

								$child_col_size = absint(preg_replace("/[^0-9]/", '', $size));

								$overgrid = $span + $child_col_size;

								if($overgrid > $col_size || $span == $col_size || $span == 0) {
									$span = 0;
									$first = true;
								}

								if($first == true) {
									$child['first'] = true;
								}

								$block->block_callback($child,$saved_blocks);

								$span = $span + $child_col_size;

								$overgrid = 0; //reset $overgrid
								$first = false; //reset $first
							}
						}
					}
					if($instance['center_blocks'] == 1) {
						echo '</div>';
					}
					echo '</div><!-- end .row in column -->';
				}
			}
			$this->after_block($instance);
			?>
	<?php
		} else {
			//show nothing
		}
	}
	
	public function get_first_map( &$blocks ) {
		$unserialized_blocks = array_map( 'maybe_unserialize', wp_list_pluck( $blocks, 0 ) );
		$maps = wp_filter_object_list( $unserialized_blocks, array( 'id_base' => 'cr_gmap_block' ) );
		if ( ! empty( $maps ) ) {
			$map = array_shift( $maps );
			$index = array_search( $map, $unserialized_blocks );
			unset( $blocks[$index] );
			return $map;
		}
		return null;
	}
	
	public function update( $new_instance, $old_instance ) {
		// this check can be done for other cases where a "row-fluid" class is needed
		if ( isset( $new_instance['map_background'] ) && '1' == $new_instance['map_background'] ) {
			//re-using a prehandled case for full-width sliders
			$new_instance['fullwidthSlider'] = 'full-width-column';
		} else if ( ! empty ( $new_instance['background_color'] ) 
					|| ! empty ( $new_instance['image_upload'] )
					|| ! empty ( $new_instance['checkParallax'] )
					|| ! empty ( $new_instance['highlight'] )
					|| ! empty ( $new_instance['center_blocks'])
					|| ! empty ( $new_instance['background_video'])
		) {
			$new_instance['fullwidthSlider'] = 'full-width-column';
		} else if ( isset( $new_instance['fullwidthSlider'] ) ) {
			// make sure to unset it if we don't need it
			unset( $new_instance['fullwidthSlider'] );
		}
		return parent::update( $new_instance, $old_instance );
	}

	public function background_before( $instance, $saved_blocks = array() ) {
		$defaults = array(
			'highlight' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		ob_start();
		if ( ! empty( $instance['map_background'] ) ) {
			$blocks = circleflip_get_blocks( $instance['template_id'], $saved_blocks );
			$mapBlock = $this->get_first_map( $blocks );
			if ( ! empty( $mapBlock ) ) {
				global $aq_registered_blocks;
				$instance_options = $aq_registered_blocks['cr_gmap_block']->parse_args( $mapBlock );
				$min_height = '100%' == $instance_options['_data']['settings']['height'] ? '' : "min-height: {$instance_options['_data']['settings']['height']};";
				?><div style="z-index: 1; position: relative; <?php echo esc_attr($min_height) ?>"><?php
				$aq_registered_blocks['cr_gmap_block']->block($mapBlock);
			}
		} elseif ( ! empty ( $instance['background_color'] ) 
				|| ! empty ( $instance['image_upload'] )
				|| ! empty ( $instance['checkParallax'] )
				|| ! empty ( $instance['highlight'] )
				|| ! empty ( $instance['center_blocks'])
				|| ! empty ( $instance['background_video'])
		) {
				$highLightClass = '';
				$classCol = '';
				$parallaxClass = '';
				$stellar = '';
				$videoClass = '';
				$opacityBG = isset($instance['opacityBG']) ? $instance['opacityBG'] : 1;
				switch ($instance['center_blocks']) {
					case '0':
							$center_blocks = '';
						break;
					case '1':
							$center_blocks = 'center';
						break;
					default:
							$center_blocks = '';
						break;
				}
				switch ( $instance['highlight'] ) {
					case '0': $highLightClass = '';
						break;
					case '1': $highLightClass = ' highLightLeft';
						break;
					case '2': $highLightClass = ' highLightRight';
						break;
					default : $highLightClass = '';
				}
				$backgroundStyle = '';
				//print_a($instance);
				if ( ! empty( $instance['background_color'] ) ) {
					$backgroundStyle = 'background-color:' . $instance['background_color'] . ';';
				}
				if ( ! empty( $instance['image_upload'] ) && empty($instance['background_color']) ) {
					$backgroundStyle = 'background-image:url(' . $instance['image_upload'] . '); background-size : cover;background-position: center top;';
					if ( $instance['checkParallax'] == 1 ) {
						
						$backgroundStyle .= 'background-attachment : fixed';
						$stellar .= 'data-stellar-background-ratio="0.5"';
						$parallaxClass = 'parallaxSection';
					}
				}
				if ( ! empty( $instance['background_video'] ) && empty($instance['image_upload'] ) && empty($instance['background_color'] ) ) {
					
					$videoClass = 'background_video';
				}
				echo '<div class="backgroundBlock ' . esc_attr($highLightClass) . ' ' . esc_attr($videoClass) . ' ">';
				echo '<div class="backgroundBlock separateBG ' . esc_attr($parallaxClass) . ' " '.$stellar.' style="' . esc_attr($backgroundStyle) . '; opacity:'. floatval($opacityBG) .';filter: alpha(opacity='. floatval($opacityBG)*100 .') "></div>';
				if ( ! empty( $instance['background_video'] ) && empty($instance['image_upload'] ) && empty($instance['background_color'] ) ) {
					?>
					<div class="videoContainer" style="opacity:<?php echo floatval($opacityBG);?>;filter: alpha(opacity=<?php echo floatval($opacityBG)*100; ?>)">
						<?php
						 $video_link = parse_url($instance['background_video']);
						 $video_link['host'];
						 if($video_link['host']=='www.youtube.com'){
						 	$video_id=$video_link['query'];
							$video_id=substr($video_id,2);
						?>
						<div class="wallpapered bar" data-wallpaper-options='{"source":{"video":"//www.youtube.com/embed/<?php echo esc_attr($video_id);?>"}}'></div>
						<?php }else{ ?>
							<div class="wallpapered bar" data-wallpaper-options='{"source":{"webm":"<?php echo esc_attr($instance['background_video']);?>"}}'></div>
						<?php } ?>
					</div>
				<?php }
			}
		?>
			<div class="container">
		<?php
		return ob_get_clean();
	}

	public function background_after() {
		ob_start();
		?>
			</div><!-- End div.container -->
		</div><!-- End div[style="z-index: 1; position: relative;"] -->
		<?php
		return ob_get_clean();
	}
	
	public function get_background( $instance, $saved_blocks = array() ) {
		return array( $this->background_before( $instance, $saved_blocks ), $this->background_after() );
	}

	public function _wrap_children( $blocks, $col_size = 12 ) {
		$rows = array();
		$running_total = 0;
		$row = array();
		foreach ( $blocks as $block ) {
			$size = absint( preg_replace( '#[^\d]#', '', $block['size'] ) );
			if ( $col_size < ($running_total + $size ) ) {
				$rows[] = $row;
				$row = array();
				$running_total = 0;
			}
			$row[] = $block;
			$running_total += $size;
		}
		if ( ! empty( $row ) ) {
			$rows[] = $row;
		}
		return $rows;
	}
	
	public function _get_children( $blocks, $instance ) {
		$blocks = array_map( 'maybe_unserialize', wp_list_pluck( $blocks, 0 ) );
		return wp_list_filter( $blocks, array( 'parent' => $instance['order'] ) );
	}

	private function _test_wrap_children() {
		$test_1 = array(
			'blocks'	 => array( array('size' => 'span1'), array('size' => 'span2'), array('size' => 'span3'), array('size' => 'span6'), array('size' => 'span12'), array('size' => 'span5'), array('size' => 'span5'), array('size' => 'span6'), array('size' => 'span2'), ),
			'expected'	 => array( array( array('size' => 'span1'), array('size' => 'span2'), array('size' => 'span3'), array('size' => 'span6'), ), array( array('size' => 'span12'), ), array( array('size' => 'span5'), array('size' => 'span5'), ), array( array('size' => 'span6'), array('size' => 'span2'), ) )
		);
		$test_2 = array(
			'blocks'	 => array( array('size' => 'span1'), array('size' => 'span11'), array('size' => 'span9'), array('size' => 'span2'), array('size' => 'span3'), array('size' => 'span6'), array('size' => 'span5'), ),
			'expected'	 => array( array( array('size' => 'span1'), array('size' => 'span11'), ), array( array('size' => 'span9'), array('size' => 'span2'), ), array( array('size' => 'span3'), array('size' => 'span6'), ), array( array('size' => 'span5'), ) )
		);

		$res_1 = array(
			'data'	 => $test_1,
			'exec'	 => _wrap_children( $test_1['blocks'] ),
			'pass'	 => $test_1['expected'] == _wrap_children( $test_1['blocks'] )
		);

		$res_2 = array(
			'data'	 => $test_2,
			'exec'	 => _wrap_children( $test_2['blocks'] ),
			'pass'	 => $test_2['expected'] == _wrap_children( $test_2['blocks'] )
		);
		return $res_1 && $res_2;
	}
	public function column_enqueue(){
		wp_register_script('circleflip-stellar',get_template_directory_uri().'/js/jquery.stellar.js',array('jquery'),'',true);
		wp_enqueue_script('circleflip-stellar');
		wp_register_script('circleflip-wallpaper-js',get_template_directory_uri().'/js/jquery.fs.wallpaper.js',array('jquery'),'',true);
		wp_enqueue_script('circleflip-wallpaper-js');
	}

}
