/**
 * @author Creiden
 */
jQuery(document).ready(function($){
	//CONTACT PAGE
	//INPUTS PLACEHOLDER
	$('.wpcf7').find('input').each(function() {
		if (!($.browser.msie && parseInt($.browser.version, 10) < 10)) {
			if (($(this).attr('type') == 'text')||($(this).attr('type') == 'email')) {
				var value = $(this).attr('value');
				$(this).removeAttr('value');
				$(this).attr('placeholder', value);
			}
		}
	});

	//TEXTAREAS PLACEHOLDER
	$('.wpcf7').find('textarea').each(function() {
		if (!($.browser.msie && parseInt($.browser.version, 10) < 10)) {
			var value = $(this).attr('value');
			$(this).removeAttr('value');
			$(this).attr('placeholder', value);
		}
	});
})