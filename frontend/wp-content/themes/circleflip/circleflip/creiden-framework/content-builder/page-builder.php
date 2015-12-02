<?php
/** بسم الله الرحمن الرحيم **

This project is based on the plugin Aqua page builder but modified a lot to match creiden requirements

Plugin Name: Aqua Page Builder
Plugin URI: http://aquagraphite.com/page-builder
Description: Easily create custom page templates with intuitive drag-and-drop interface. Requires PHP5 and WP3.5
Version: 1.0.6
Author: Syamil MJ
Author URI: http://aquagraphite.com
*/

//definitions
if(!defined('AQPB_PATH')) define( 'AQPB_PATH', plugin_dir_path(__FILE__) );
if(!defined('AQPB_DIR')) define( 'AQPB_DIR', plugin_dir_path(__FILE__) );

//required functions & classes
require_once 'functions/aqpb_config.php';
require_once 'functions/aqpb_blocks.php';
require_once 'classes/class-aq-page-builder.php';
require_once 'classes/class-aq-block.php';
require_once 'functions/aqpb_functions.php';
require_once 'saved-blocks.php';
//some default blocks
require_once 'blocks/aq-column-block.php';
require_once 'blocks/aq-clear-block.php';
require_once 'blocks/aq-widgets-block.php';
require_once 'blocks/aq-alert-block.php';
require_once 'blocks/aq-tabs-block.php';
require_once 'blocks/cr-list-block.php';
require_once 'blocks/cr-text-block.php';
require_once 'blocks/cr-buttons-block.php';
require_once 'blocks/cr-dropcaps-block.php';
require_once 'blocks/cr-heading-block.php';
require_once 'blocks/cr-sc-block.php';
require_once 'blocks/cr-image-block.php';
require_once 'blocks/cr-progress-block.php';
require_once 'blocks/cr-team-block.php';
require_once 'blocks/cr-qoute-block.php';
require_once 'blocks/cr-boxedtext-block.php';
require_once 'blocks/cr-slider-block.php';
require_once 'blocks/cr-pricingtables-block.php';
require_once 'blocks/cr-text-sliders-block.php';
require_once 'blocks/cr-announcment-block.php';
require_once 'blocks/cr-contact-details.php';
require_once 'blocks/cr-gmap-block.php';
require_once 'blocks/cr-advertisement-block.php';
require_once 'blocks/cr-carousel-block.php';
require_once 'blocks/cr-post-block.php';
require_once 'blocks/cr-features-home.php';
require_once 'blocks/cr-clients-logos.php';
require_once 'blocks/cr-testimonials-section.php';
require_once 'blocks/cr-image-slider.php';
require_once 'blocks/cr-twitter-block.php';
require_once 'blocks/cr-faq-block.php';
require_once 'blocks/cr-gallery.php';
require_once 'blocks/cr-pricingtablessmall-block.php';
require_once 'blocks/cr-media-block.php';
require_once 'blocks/cr-content.php';
require_once 'blocks/cr-counter-block.php';
if(  class_exists('Cflip_Offer_Manager')){
require_once 'blocks/cr-offers-block.php';
}

//register default blocks
circleflip_register_block('AQ_Column_Block');
circleflip_register_block('AQ_Clear_Block');
circleflip_register_block('AQ_Widgets_Block');
circleflip_register_block('AQ_Alert_Block');
circleflip_register_block('AQ_Tabs_Block');
circleflip_register_block('CR_List_Block');
circleflip_register_block('CR_Text_Block');
circleflip_register_block('CR_Buttons_Block');
circleflip_register_block('CR_Dropcaps_Block');
circleflip_register_block('CR_Heading_Block');
circleflip_register_block('CR_SC_Block');
circleflip_register_block('CR_Image_Block');
circleflip_register_block('CR_Progress_Block');
circleflip_register_block('CR_Team_Block');
circleflip_register_block('CR_Qoute_Block');
circleflip_register_block('CR_BoxedText_Block');
circleflip_register_block('CR_Slider_Block');
circleflip_register_block('CR_PricingTables_Block');
circleflip_register_block('CR_PricingTablesSmall_Block');
circleflip_register_block('CR_Text_Sliders_Block');
circleflip_register_block('CR_Contact_Details');
//circleflip_register_block('CR_GMap_Block');
circleflip_register_block('CR_GMap_Block');
circleflip_register_block('CR_Advertisement_Block');
circleflip_register_block('CR_Announcment_Block');
circleflip_register_block('CR_Carousel_Block');
circleflip_register_block('CR_Post_Block');
circleflip_register_block('CR_Features_Home');
circleflip_register_block('CR_Clinets_Logos');
circleflip_register_block('CR_Testimonials_Section');
circleflip_register_block('CR_Image_Slider_Block');
circleflip_register_block('CR_Twitter_Block');
circleflip_register_block('CR_Gallery');
circleflip_register_block('CR_Media_Block');
circleflip_register_block('cr_counter_block');
if(  class_exists('Cflip_Offer_Manager')){
circleflip_register_block('CR_Offers_Block');
}
circleflip_register_block('CR_Faq_Block');
circleflip_register_block('CR_Content_Block');
//fire up page builder
$aqpb_config = circleflip_page_builder_config();
$aq_page_builder = new AQ_Page_Builder($aqpb_config);
if(!is_network_admin()) $aq_page_builder->init();

function circleflip_builder_button( $post ) {
	$post_type = ! empty($post) ? $post->post_type : get_current_screen()->post_type;
	if ( 'page' !== $post_type )
		return;
	?>
	<div style='margin-bottom: 10px'>
		<button type="button" id="creiden-switch-builder" class="button button-primary" data-hide-editor="true">
			Content Builder
		</button>
	</div>
	<script>
		jQuery( document ).ready( function($) {
			var localData = window.localStorage && window.localStorage.getItem('circleflip');
			localData = JSON.parse(localData);
			//w2s -> what 2 show
			if ( localData && 'content-builder' === localData.w2s ) {
				$('#postdivrich').toggleClass('hidden', true);
				$('#aq-page-builder').toggleClass('hidden', false);
				$('#creiden-switch-builder').data('hideEditor', false).text('Editor');
			}

			$('#creiden-switch-builder').on('click', function(){
				var hideEditor = $(this).data('hideEditor');
				$(this).data('hideEditor', ! hideEditor);
				$('#postdivrich').toggleClass('hidden', hideEditor );
				$('#aq-page-builder').toggleClass('hidden', ! hideEditor );
				$(this).text( hideEditor ? 'Editor' : 'Content Builder');
				window.localStorage && window.localStorage.setItem('circleflip', JSON.stringify({w2s: hideEditor ? 'content-builder' : 'editor'}))
			});
		} );
	</script>
	<?php
}

add_action( 'edit_form_after_title', 'circleflip_builder_button' );