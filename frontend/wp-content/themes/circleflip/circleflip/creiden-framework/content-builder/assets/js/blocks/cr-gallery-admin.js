( function( $, _, window, document, undefined ) {

	/* summary
	 * 
	 * wait for edit button to be clicked
	 *	add event listeners to TB_window ( gallery click )
	 *	on gallery click :
	 *		remove current edit Thickbox
	 *		build media frame then show
	 *		listene for mediaframe update, insert, select, close
	 *		on mediaFrame close:
	 *			invoke tb_click with the block as context to show thickbox
	 *			reinstantiate tb_window listeners
	 * 
	 */
	var blocksList, currentBlock,
		galleryButtonSelector = '.cr-gallery',
		galleryIDsSelector = '.cr-gallery-ids',
		galleryListSelector = '.cr-gallery-list',
		editBlockSelector = 'a.block-edit',
		blockSelector = '.block-cr_gallery';

	$( document ).ready( function() {
		blocksList = $( 'ul.blocks' );
		// wait for edit panel
		blocksList.on( 'click', editBlockSelector, function() {
			var $this = $( this ),
				block = $this.closest( blockSelector );
			// cache current block
			currentBlock = {
				block: block,
				edit: $this,
				list: block.find( galleryListSelector )
			};
		} );
		galleryEdit();

	} );

	function galleryEdit() {
		$( document ).on( 'click.cr-gallery', galleryButtonSelector, function() {
			var $this = $( this ),
				idsField = $this.siblings( galleryIDsSelector );
			buildFrame( {ids: idsField.val()} )
				.on( 'select update insert', function( selection ) {
					// clear preview
					currentBlock.list.empty();
					var attachments = selection.map( function( attachment ) {
						attachment = attachment.toJSON();
						// if we have thumb get it, otherwise get full
						var src = ( attachment.sizes && attachment.sizes['thumbnail'] && attachment.sizes['thumbnail'].url ) || attachment.url;
						currentBlock.list.append( '<li><img src="' + src + '" width="150" height="150"></li>' );
						return attachment;
					} ) || [ ];
					idsField.val( _.pluck( attachments, 'id' ) );
				} )
				.open();
		} );
	}

	function buildFrame( options ) {
		var args = _.defaults( options, {
			frame: 'post',
			state: 'gallery-library',
			title: wp.media.view.l10n.editGalleryTitle,
			editing: false,
			library: {type: 'image'},
			multiple: false,
			ids: ''
		} );

		args.selection = ( function( ids, options ) {
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
		}( args.ids, args ) );

		return wp.media( _.omit( args, 'ids' ) );
	}
}( jQuery, _, window, document ) );