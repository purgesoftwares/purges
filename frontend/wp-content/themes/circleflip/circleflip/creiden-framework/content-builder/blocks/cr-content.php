<?php
/** A simple text block **/
class CR_Content_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
			'image' => 'text.png',
			'name' => 'Content',
			'size' => 'span6',
                        'tab' => 'Content',
                        'imagedesc' => 'text.jpg',
                        'desc' => 'Used to add the default wordpress content'
		);

		//create the block
		parent::__construct('cr_content_block', $block_options);
	}
	function form($instance) {

	}

	function block($instance) {
		the_content();
	}

}