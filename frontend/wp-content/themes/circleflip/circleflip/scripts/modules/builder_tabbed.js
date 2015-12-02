/**
 * @author Creiden
 */
jQuery(document).ready(function($){
	// Tabs
	if(jQuery().tabs) {
		$(".aq_block_tabs").tabs({ 
			show: true 
		});
			$(".aq_block_tabs li a ").click(function(){
				$(".aq_block_tabs li").removeClass('ui-tabs-active');
				$(this).parent().addClass('ui-tabs-active');
			}); 
	}
})