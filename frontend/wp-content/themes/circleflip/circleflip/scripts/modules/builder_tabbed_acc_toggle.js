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
	
	// Toggles
	$('.aq_block_toggle .tab-head, .aq_block_toggle .arrow').each( function() {
		var toggle = $(this).parent();
		$(this).click(function() {
			toggle.find('.tab-body').slideToggle();
			return false;
		});
		
	});
	var x = 0;
	$('.aq_block_toggle .tab-head').children().addClass('icon-plus-1');
	$('.aq_block_toggle .tab-head').click(function() {
		$parent = $(this).parents('.aq_block_toggles_wrapper');
		if($(this).children().hasClass('icon-plus-1')){
			$(this).children().removeClass('icon-plus-1');
			$(this).children().addClass('icon-minus');
			$(this).addClass('colored');
		}else if($(this).children().hasClass('icon-minus')){
			$(this).children().removeClass('icon-minus');
			$(this).children().addClass('icon-plus-1');
			$(this).removeClass('colored');
		}
	});
	 
	
	// Accordion
	$('.aq_block_accordion_wrapper').each(function() {
		var $this = $(this);
		
		$this.find('.tab-head').eq(0).addClass('colored');
		$this.find('.aq_block_accordion .tab-head').children().addClass('icon-plus-1');
		$this.find('.aq_block_accordion .tab-head').eq(0).children().removeClass('icon-plus-1').addClass('icon-minus');
	});
	
	$(document).on('click', '.aq_block_accordion_wrapper .tab-head, .aq_block_accordion_wrapper .arrow', function() {
		var $clicked = $(this);
		var $parent = $(this).parents('.aq_block_accordion_wrapper');
		$clicked.addClass('clicked');
		
		$clicked.parents('.aq_block_accordion_wrapper').find('.tab-body').each(function(i, el) {
			if($(el).is(':visible') && ( $(el).prev().hasClass('clicked') || $(el).prev().prev().hasClass('clicked') ) == false ) {
				$(el).slideUp();
			}
		});
		
		$clicked.parent().children('.tab-body').slideToggle();
		
		$clicked.removeClass('clicked');
			if($(this).children().hasClass('icon-plus-1')){
				$parent.find('.aq_block_accordion .tab-head').children().addClass('icon-plus-1').removeClass('icon-minus');
				$(this).children().removeClass('icon-plus-1').addClass('icon-minus');
				$parent.find('.aq_block_accordion .tab-head').removeClass('colored');
				$(this).addClass('colored');
				x = 1;
			} else if($(this).children().hasClass('icon-minus')){
				$(this).children().removeClass('icon-minus');
				$(this).children().addClass('icon-plus-1');
				$parent.find('.aq_block_accordion .tab-head').removeClass('colored');
			}
			
	
		
		return false;
	});
	
});