<?php

function content_builder_save_template() {
	$blocks = array();
	if(isset($_POST['aq_blocks']) && !empty($_POST['aq_blocks'])) {
	$all = $_POST['aq_blocks'];//get_post_custom($template_id);
	foreach($all as $key => $block) {
		if(substr($key, 0, 9) == 'aq_block_' && substr($key, 8, 14) != '___i__') {
			$block_instance = $all[$key];//get_post_meta($template_id, $key);
			if(is_array($block_instance)) $blocks[$key] = $block_instance;
		}
	}
		//sort by order
		$sort = array();
		foreach($blocks as $block) {
			$sort[] = $block['order'];
		}
		array_multisort($sort, SORT_NUMERIC, $blocks);
	}

	if(circleflip_valid($_POST['saveTempName'])) {
		$opt = get_option( 'builderSavedTemp' );
		$opt[$_POST['saveTempName']] = $blocks;
		update_option('builderSavedTemp', $opt);
	}
	die;
}
add_action('wp_ajax_content_builder_save_templates','content_builder_save_template');

function content_builder_retrieve_blocks_export() {
	$blocks = array();
	parse_str($_POST['pageBlocks'], $output);
	if(isset($output['aq_blocks']) && !empty($output['aq_blocks'])) {
		$all = $output['aq_blocks'];//get_post_custom($template_id);
		foreach($all as $key => $block) {
			if(substr($key, 0, 9) == 'aq_block_' && substr($key, 8, 14) != '___i__') {
				$block_instance = $all[$key];//get_post_meta($template_id, $key);
				if(is_array($block_instance)) $blocks[$key] = $block_instance;
			}
		}
	
		//sort by order
		$sort = array();
		foreach($blocks as $block) {
			$sort[] = $block['order'];
		}
		array_multisort($sort, SORT_NUMERIC, $blocks);
	}
	
	echo base64_encode(serialize($blocks));
	die;
}
add_action('wp_ajax_content_builder_retrieve_blocks', 'content_builder_retrieve_blocks_export');

function content_builder_get_template() {
	$template_id = $_POST['postID'];
	$blocks = get_option( 'builderSavedTemp');
	if(array_key_exists($_POST['getTemp'],$blocks)) {
		$blocks = $blocks[$_POST['getTemp']];
	}
	else {
		$blocks = array();
	}
	$saved_blocks = $blocks;
	if(empty($blocks)) {
		echo '<p class="empty-template">';
		echo __('Drag block items from the left into this area to begin building your template.', 'circleflip-builder');
		echo '</p>';
		return;

	} else {
		//sort by order
		$sort = array();

		foreach($blocks as $block) {
			if(isset($block['order']))
				$sort[] = $block['order'];
			else
				$sort[] = '';
		}
		array_multisort($sort, SORT_NUMERIC, $blocks);
		//outputs the blocks
		foreach($blocks as $key => $instance) {
			global $aq_registered_blocks;
			if(isset($instance) && !empty($instance) && $instance !=FALSE && is_array($instance)) {
			extract($instance);
			if(isset($aq_registered_blocks[$id_base])) {
				//get the block object
				$block = $aq_registered_blocks[$id_base];
				$instance['template_id'] = $template_id;
				//display the block
				if($parent == 0) {
					$block->form_callback($instance,$saved_blocks);
				}
			}
			}
		}
	}
	die;
}
add_action('wp_ajax_content_builder_get_templates','content_builder_get_template');

function content_builder_delete_template() {
	$blocks = get_option( 'builderSavedTemp' );
	if(array_key_exists($_POST['getTemp'],$blocks)) {
		$blocks[$_POST['getTemp']] = '';
		update_option('builderSavedTemp', $blocks);
	}
die;
}
add_action('wp_ajax_content_builder_delete_templates','content_builder_delete_template');
function content_builder_import_template() {
	if(circleflip_valid($_POST['importedData'])) {
		$blocks = unserialize(base64_decode($_POST['importedData']));
		update_option('builderSavedTemp', $blocks);
	}
die;
}
add_action('wp_ajax_content_builder_import_templates','content_builder_import_template');

function content_builder_save_block() {
	if(circleflip_valid($_POST['blocks'])) {
		echo stripslashes(base64_decode($_POST['blocks']));
	}
die;
}

add_action('wp_ajax_content_builder_save_blocks','content_builder_save_block');
function content_builder_save_history() {
	if(circleflip_valid($_POST['history'])) {
		parse_str($_POST['history'], $output);
		if(isset($output['aq_blocks']) && !empty($output['aq_blocks'])) {
			$all = $output['aq_blocks'];
			foreach($all as $key => $block) {
				if(substr($key, 0, 9) == 'aq_block_' && substr($key, 8, 14) != '___i__') {
					$block_instance = $all[$key];//get_post_meta($template_id, $key);
					if(is_array($block_instance)) $blocks[$key] = $block_instance;
				}
			}
		
			//sort by order
			$sort = array();
			foreach($blocks as $block) {
				$sort[] = $block['order'];
			}
			array_multisort($sort, SORT_NUMERIC, $blocks);
		}
		
		$historyData = base64_encode(serialize($blocks));
		$historyNumber 		= get_post_meta($_POST['postID'],'_cr_history_number',true);
		$historyTotalNumber = get_post_meta($_POST['postID'], '_cr_history_total_number',true);
		if(empty($historyNumber)) {
			$historyNumber = 0;
			if(empty($historyTotalNumber))
				$historyTotalNumber = 0;
			
			update_post_meta   ( $_POST['postID'], '_cr_history_number', $historyNumber);
			update_post_meta   ( $_POST['postID'], '_cr_history_total_number', $historyTotalNumber);
		}
		if($historyTotalNumber >= 10) {
			$historyTotalNumber = 10;
		} 
		else {
			$historyTotalNumber++;
			update_post_meta( $_POST['postID'], '_cr_history_total_number',$historyTotalNumber);	
		} 
			update_post_meta( $_POST['postID'], '_cr_history_'.$historyNumber, $historyData );
			$historyNumber++;
			update_post_meta( $_POST['postID'], '_cr_history_number', 	  $historyNumber);
	}
	die;
}
add_action('wp_ajax_content_builder_save_history','content_builder_save_history');

function content_builder_get_history() {
	$history = get_post_meta($_POST['postID'], $_POST['history']);
	$all =  unserialize(base64_decode($history[0]));
	 foreach($all as $key => $block) {
				if(substr($key, 0, 9) == 'aq_block_' && substr($key, 8, 14) != '___i__') {
					$block_instance = $all[$key];
					if(is_array($block_instance)) $blocks[$key] = $block_instance;
				}
			}

			//sort by order
			$sort = array();
			$block_mod_array = array();

			foreach($blocks as $key => $block) {
				if(isset($block[0])) {
					$saving_template = false;
					$temp = unserialize($block[0]);
				} else {
					$saving_template = true;
					if(is_array($block)) {
						$temp = $block;
						$blocks[$key] = array(serialize($block));
					} else {
						$temp = unserialize($block);
					}
				}
				if(isset($temp['order']))
					$sort[] = $temp['order'];
				else
					$sort[] = '';
			}
			array_multisort($sort, SORT_NUMERIC, $blocks);
			
			
			$saved_blocks = $blocks;
			foreach ($blocks as $keys => $values) {
				foreach ($values as $key => $value) {
					$blocks[$keys] = unserialize($value);
				}
			}
			
			foreach($blocks as $key => $instance) {
				global $aq_registered_blocks;
				if(isset($instance) && !empty($instance) && $instance !=FALSE && is_array($instance)) {
				extract($instance);
				if(isset($id_base) && isset($aq_registered_blocks[$id_base])) {
					//get the block object
					$block = $aq_registered_blocks[$id_base];
					//insert template_id into $instance
					$instance['template_id'] = $_POST['postID'];

					//display the block
					if($parent == 0) {
						$block->form_callback($instance,$saved_blocks, true);
					}
				}
				}
			}
	die;	
}
add_action('wp_ajax_content_builder_get_history','content_builder_get_history');

function export_certain_block() {
	$blocks = array();
		parse_str($_POST['exportedData'], $output);
		if(isset($output['aq_blocks']) && !empty($output['aq_blocks'])) {
			$all = $output['aq_blocks'];
			foreach($all as $key => $block) {
				if(substr($key, 0, 9) == 'aq_block_' && substr($key, 8, 14) != '___i__') {
					$block_instance = $all[$key];
					if(is_array($block_instance)) $blocks[$key] = $block_instance;
				}
			}
		
			//sort by order
			$sort = array();
			foreach($blocks as $block) {
				$sort[] = $block['order'];
			}
			array_multisort($sort, SORT_NUMERIC, $blocks);
		}
		
		echo base64_encode(serialize($blocks));
	die;
}
add_action('wp_ajax_content_builder_export_certain_block','export_certain_block');

function import_certain_block() {
	 $all = unserialize(base64_decode($_POST['importedData']));
	 foreach($all as $key => $block) {
				if(substr($key, 0, 9) == 'aq_block_' && substr($key, 8, 14) != '___i__') {
					$block_instance = $all[$key];
					if(is_array($block_instance)) $blocks[$key] = $block_instance;
				}
			}

			//sort by order
			$sort = array();
			$block_mod_array = array();

			foreach($blocks as $key => $block) {
				if(isset($block[0])) {
					$saving_template = false;
					$temp = unserialize($block[0]);
				} else {
					$saving_template = true;
					if(is_array($block)) {
						$temp = $block;
						$blocks[$key] = array(serialize($block));
					} else {
						$temp = unserialize($block);
					}
				}
				if(isset($temp['order']))
					$sort[] = $temp['order'];
				else
					$sort[] = '';
			}
			array_multisort($sort, SORT_NUMERIC, $blocks);
			
			
			$saved_blocks = $blocks;
			foreach ($blocks as $keys => $values) {
				foreach ($values as $key => $value) {
					$blocks[$keys] = unserialize($value);
				}
			}
			
			foreach($blocks as $key => $instance) {
				global $aq_registered_blocks;
				if(isset($instance) && !empty($instance) && $instance !=FALSE && is_array($instance)) {
				extract($instance);
				if(isset($id_base) && isset($aq_registered_blocks[$id_base])) {
					//get the block object
					$block = $aq_registered_blocks[$id_base];
					//insert template_id into $instance
					$instance['template_id'] = $_POST['postID'];

					//display the block
					if($parent == 0) {
						$block->form_callback($instance,$saved_blocks, true);
					}
				}
				}
			}
	die;	
}
add_action('wp_ajax_content_builder_import_certain_block','import_certain_block');

function content_builder_template() {
	$valid_template_files = array(
		'cafeflip',
        'onepage',
		'medical',
		'mechanic',
		'school',
		'hotel',
		'lawyer',
        'tours',
        'magazine',
        'host',
		'homeStyle1',
		'homeStyle2',
		'homeStyle3',
		'homeStyle4',
		'homeStyle5',
		'homeStyle6',
		'homeStyle8',
		'homeStyle9',
		'homeStyle10',
		'homeStyle11',
		'homeStyle12',
		'homeStyle13',
		'homeStyle14',
		'homeStyle15',
		'homeStyle16',
		'homeStyle17',
		'homeStyle17',
		'AboutUsStyle1',
		'AboutUsStyle2',
		'AboutUsStyle3',
		'AboutUsStyle4',
		'AboutUsStyle5',
		'AboutUsStyle6',
		'OurTeamStyle1',
		'OurTeamStyle2',
		'OurTeamStyle3',
		'ServicesStyle1',
		'ServicesStyle2',
		'ContactUsStyle1',
		'ContactUsStyle2',
		'ContactUsStyle3',
		'ContactUsStyle4',
		'ContactUsStyle5',
		'ContactUsStyle6',
		'ContactUsStyle7',
		'ContactUsStyle8',
		'PageLayoutsStyle1',
		'PageLayoutsStyle2',
		'PageLayoutsStyle3',
		'PageLayoutsStyle4',
		'PageLayoutsStyle5',
		'PageLayoutsStyle6',
	);
	$file = get_template_directory() . '/creiden-framework/content-builder/saved_blocks/' . strtolower( $_POST['template'] ) . '.cbtmpl';
	if ( 0 === validate_file( $_POST['template'], $valid_template_files ) && is_file( $file ) ) {
		$tmpl = include $file;
		echo stripslashes( base64_decode( $tmpl ) );
	}

	die;
}

add_action( 'wp_ajax_content_builder_templates', 'content_builder_template' );
