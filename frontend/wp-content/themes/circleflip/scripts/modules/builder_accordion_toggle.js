/**
 * @author Creiden
 */
jQuery(document).ready(function($){
	// Toggles
	$('.aq_block_toggle .tab-head, .aq_block_toggle .arrow').each( function() {
		var toggle = $(this).parent();
		$(this).click(function() {
			toggle.find('.tab-body').slideToggle();
			return false;
		});
		
	});
	var x = 0;
	$('.aq_block_toggle .tab-head').children().addClass('ui-icon-plus');
	$('.aq_block_toggle .tab-head').click(function() {
		$parent = $(this).parents('.aq_block_toggles_wrapper');
		if($(this).children().hasClass('ui-icon-plus')){
			$(this).children().removeClass('ui-icon-plus');
			$(this).children().addClass('ui-icon-minus');
			$(this).addClass('colored');
		}else if($(this).children().hasClass('ui-icon-minus')){
			$(this).children().removeClass('ui-icon-minus');
			$(this).children().addClass('ui-icon-plus');
			$(this).removeClass('colored');
		}
	});
	 
	
	// Accordion
	$('.aq_block_accordion_wrapper').each(function() {
		var $this = $(this);
		
		$this.find('.tab-head').eq(0).addClass('colored');
		$this.find('.aq_block_accordion .tab-head').children().addClass('ui-icon-plus');
		$this.find('.aq_block_accordion .tab-head').eq(0).children().removeClass('ui-icon-plus').addClass('ui-icon-minus');
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
			if($(this).children().hasClass('ui-icon-plus')){
				$parent.find('.aq_block_accordion .tab-head').children().addClass('ui-icon-plus').removeClass('ui-icon-minus');
				$(this).children().removeClass('ui-icon-plus').addClass('ui-icon-minus');
				$parent.find('.aq_block_accordion .tab-head').removeClass('colored');
				$(this).addClass('colored');
				x = 1;
			} else if($(this).children().hasClass('ui-icon-minus')){
				$(this).children().removeClass('ui-icon-minus');
				$(this).children().addClass('ui-icon-plus');
				$parent.find('.aq_block_accordion .tab-head').removeClass('colored');
			}
			
	
		
		return false;
	});
})