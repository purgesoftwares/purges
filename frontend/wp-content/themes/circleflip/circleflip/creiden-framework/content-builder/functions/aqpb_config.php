<?php
/**
 * Aqua Page Builder Config
 *
 * This file handles various configurations
 * of the page builder page
 *
 */
function circleflip_page_builder_config() {

	$config = array(); //initialise array
	
	/* Page Config */
	$config['menu_title'] = __('Page Builder', 'circleflip-builder');
	$config['page_title'] = __('Page Builder', 'circleflip-builder');
	$config['page_slug'] = __('aq-page-builder', 'circleflip-builder');
	
	/* This holds the contextual help text - the more info, the better.
	 * HTML is of course allowed in all of its glory! */
	$config['contextual_help'] = 
		'<p>' . __('The page builder allows you to create custom page templates which you can later use for your pages.', 'circleflip-builder') . '<p>';
	
	/* Debugging */
	$config['debug'] = false;
	
	return $config;
	
}