<?php
 	/* ========================================================================================================================

	Creiden Framework include

	======================================================================================================================== */
	require_once trailingslashit( get_template_directory() ) . 'plugins/creiden_plugins.php';
	if (!function_exists('circleflip_optionsframework_init')) {
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/creiden-framework/inc/');
		require_once trailingslashit( get_template_directory() ) . 'creiden-framework/inc/options-framework.php';
	}
	require_once trailingslashit( get_template_directory() ) . 'creiden-framework/content-builder/page-builder.php';

	add_action('save_post', 'circleflip_save_post_content_builder');
	function circleflip_save_post_content_builder() {
		$aqpb_config = circleflip_page_builder_config();
		$aq_page_builder = new AQ_Page_Builder($aqpb_config);
		$blocks = $aq_page_builder->post_content_builder_mb_save();
	};
?>