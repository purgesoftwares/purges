$ = jQuery;

	function optionsframework_add_file(event, selector,upload_button) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( frame ) {
			frame.open();
			return;
		}

		// Create the media frame.
		frame = wp.media({
			// Set the title of the modal.
			title: $el.data('choose'),

			// Customize the submit button.
			button: {
				// Set the text of the button.
				text: $el.data('update'),
				// Tell the button not to close the modal, since we're
				// going to refresh the page when the image is selected.
				close: false
			}
		});

		// When an image is selected, run a callback.
		frame.on( 'select', function() {
			// Grab the selected attachment.
			var attachment = frame.state().get('selection').first();
			frame.close();
			selector.find(upload_button).prev('.upload').val(attachment.attributes.url);
			if ( attachment.attributes.type == 'image' ) {
				selector.find(upload_button).next('.screenshot').empty().hide().append('<img src="' + attachment.attributes.url + '"><a class="remove-image">Remove</a>').slideDown('fast');
				// generate the builder image if available
				if(selector.parents('.section').next().hasClass('builder'))
				{
					selector.parents('.section').next('.builder').find('.containmentLogo').empty().hide().append('<img class="logo" src="' + attachment.attributes.url + '">').slideDown('fast');
					 setTimeout(function() {
						if(selector.parents('.section').find('.screenshot').width() > $("#logo_wrapper_width").val()) {
							$('.logo').width($('#logowrapper').width());
							$("#logo_width").val($("#logo_wrapper_width").val());
						}
						else {
							$('.logo').width(selector.find('.screenshot img').width());
							$("#logo_width").val(selector.parents('.section').find('.screenshot img').width());
						}
						if(selector.parents('.section').find('.screenshot').height() > $("#header_height").val()) {
							$('.logo').height($('#logowrapper').height());
							$("#logo_height").val($("#header_height").val());
						}
						else {
							$('.logo').height(selector.parents('.section').find('.screenshot img').height());
							$("#logo_height").val(selector.parents('.section').find('.screenshot img').height());
						}
						 manage_logo();
					 },500);

				}
			}
			selector.find(upload_button).unbind().addClass('remove-file').removeClass('upload-button').val(optionsframework_l10n.remove);
			selector.find('.of-background-properties').slideDown();
			optionsframework_file_bindings();
		});

		// Finally, open the modal.
		frame.open();
	}

	function optionsframework_remove_file(selector,remove_button) {
		selector.find(remove_button).next('.screenshot').find('.remove-image').hide();
		selector.find(remove_button).prev('.upload').val('');
		selector.find('.of-background-properties').hide();
		selector.find(remove_button).next('.screenshot').slideUp();
		// Remove the builder image if available
		if(selector.parents('.section').next().hasClass('builder'))
		{
			selector.parents('.section').next('.builder').find('.containmentLogo').slideUp();
		}
		remove_button.unbind().addClass('upload-button').removeClass('remove-file').val(optionsframework_l10n.upload);
		// We don't display the upload button if .upload-notice is present
		// This means the user doesn't have the WordPress 3.5 Media Library Support
		if ( $('.section-upload .upload-notice').length > 0 ) {
			$('.upload-button').remove();
		}
		optionsframework_file_bindings();
	}

	function optionsframework_file_bindings() {
		$('.remove-image, .remove-file').off('click');
		$('.upload-button').off('click');
		$('.remove-image, .remove-file').on('click', function() {
			if($(this).parents('.option_container').length != 0) {
				optionsframework_remove_file( $(this).parents('.option_container'),$(this) );
        	}
        	else {
        		optionsframework_remove_file( $(this).parents('.slide_container'),$(this) );
        	}
        });

        $('.upload-button').on('click', function( event ) {
        	if($(this).parents('.option_container').length != 0) {
				optionsframework_add_file(event, $(this).parents('.option_container'),$(this));
        	}
        	else {
        		optionsframework_add_file(event, $(this).parents('.slide_container'),$(this));
        	}
        });
    }
$(document).ready(function() {
   optionsframework_file_bindings();
});
