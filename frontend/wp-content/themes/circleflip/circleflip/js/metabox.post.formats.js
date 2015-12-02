(function( $ ) {
	jQuery(document).ready(function($){
		var $mb = $('#circleflip-post-formats-metabox'),
			panels = $mb.find('.circleflip-post-formats'),
			revShortcode = $mb.find('.circleflip-rev-shortcode'),
			title = $mb.children('h3.hndle').find('span');
		$mb.toggle('0' != $('.post-format:checked').val());
		// hide/show panels when post format changes
		$('.post-format').on('change', function(){
			var format = $(this).val();
			// replace 0 with standard
			format = '0' == format ? 'standard' : format;

			panels.hide().removeClass('active');
			// find .circleflip-pf-{format} panel and show it
			if ( 'standard' == format ) {
				$mb.hide();
			} else {
				$mb.show();
				panels.filter('.circleflip-pf-' + format).show().addClass('active');
			}
			// change title to represent current post format
			title.text('Post Format: ' + format.charAt(0).toUpperCase() + format.substr(1));
		});
		// display shortcode box for rev slider
		$mb.find('#circleflip-pf-slider-input').on('change', function(){
				revShortcode.toggle('rev' === $(this).val());
		});

		$mb.find('.circleflip-media').each(function(){
			$(this).circleflip_MediaFrame({
				title: 'Select a ' + $(this).data('type'),
				multiple: false,
				library: {
					type: $(this).data('type').toLowerCase()
				},
				onSelect: function( attachment ) {
					attachment = attachment.shift();
					$(this)
						// change `Upload` to `Change`
						.text('Change')
						// set the media id
						.siblings('.circleflip-media-target')
							.val(attachment.id)
						// set the media title
						.siblings('.circleflip-media-target-text')
							.val(attachment.title)
						// allow user to remove media
						.siblings('.circleflip-media-remove')
							.show()
						.closest(panels)
						.find('.circleflip-media-embed').addClass('circleflip-disabled')
							.find('textarea').prop('disabled', true);
				}
			});
		});

		$mb.find('.circleflip-media-remove').on('click', function(){
			$(this)
				// hide remove, user no longer needs us
				.hide()
				// clear id and title
				.siblings('.circleflip-media-target')
					.val('')
				.siblings('.circleflip-media-target-text')
					.val('')
				// change media button text back to Upload
				.siblings('.circleflip-media')
					.text('Upload')
				.closest(panels)
						.find('.circleflip-media-embed')
						.removeClass('circleflip-disabled')
						.find('textarea').prop('disabled', false);
		});
		var gal_ids = $('#gallery-ids');
		$( '#gallery-button' ).on( 'click', function() {
			var options = {
				state: 'gallery-library',
				editing: false,
				multiple: false
			},
			selection = (function( ids, options ) {
				var idsArray = ids.split( ',' ),
					args = {
						orderby: 'post__in',
						order: 'ASC',
						type: 'image',
						perPage: - 1,
						post__in: idsArray
					},
					attachments = wp.media.query( args ),
					selection = new wp.media.model.Selection( attachments.models, {
							props: attachments.props.toJSON(),
							multiple: true
						} );

				if ( options.state == 'gallery-library' && idsArray.length && ! isNaN( parseInt( idsArray[0], 10 ) ) ) {
					options.state = 'gallery-edit';
					options.editing = true;
					options.multiple = true;
				}
				return selection;
			}( gal_ids.val(), options ));
			var frame = wp.media.frames.circleflip_gallery = wp.media( {
						frame: 'post',
						state: options.state,
						title: wp.media.view.l10n.editGalleryTitle,
						editing: options.editing,
						library: {
							type: 'image'
						},
						selection: selection,
						multiple: options.multiple  // Set to true to allow multiple files to be selected
					} );
					
			frame.on( 'select update insert', function( selection ) {
				var vals = selection.map( function( attachment ) {
							return attachment.toJSON().id;
					} ) || [];
				gal_ids.val( vals.join( ',' ) );
			} );
					
			frame.open();
		} );
	});
}( jQuery ));