jQuery(document).ready(function($){
	$('.dropcapText').each(function(index,element) {
		
		var dropcapped_letter = $(element).text().charAt(0).slice(0);
		var custom_css = $(element).attr('style');
		$(element).text($(element).text().substring(1));
		$(element).prepend('<span class="dropcap" style="'+custom_css+'">'+dropcapped_letter+'</span>');
	});
	$('.dropcapLight').each(function(index,element) {
		var dropcapped_letter = $(element).text().charAt(0).slice(0);
		$(element).text($(element).text().substring(1));
		$(element).prepend('<span class="colored left drop">'+dropcapped_letter+'</span>');
	});
});
