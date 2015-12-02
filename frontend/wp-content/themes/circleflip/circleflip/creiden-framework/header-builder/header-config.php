<?php 
	require_once 'classes/class-header-builder.php';
	require_once 'functions/header_functions.php';
	
	
	require_once 'blocks/header-row-block.php';
	require_once 'blocks/header-logo-block.php';
	require_once 'blocks/header-menu-block.php';
	require_once 'blocks/header-social-block.php';
	require_once 'blocks/header-text-block.php';
	require_once 'blocks/header-button-block.php';
	require_once 'blocks/header-ad-block.php';
	require_once 'blocks/header-spacer-block.php';
	require_once 'blocks/header-breaking-block.php';
	
	
	creiden_register_header_block('header_row');
	creiden_register_header_block('header_logo');
	creiden_register_header_block('header_menu');
	creiden_register_header_block('header_social');
	creiden_register_header_block('header_text');
	creiden_register_header_block('header_button');
	creiden_register_header_block('header_ad');
	creiden_register_header_block('header_spacer');
	creiden_register_header_block('header_breaking');
	
?>