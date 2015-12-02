/**
 * header-builder js
 *
 * contains the core js functionalities to be used
 * inside the header builder
 */
jQuery.noConflict();
/** Let's start building **/
jQuery(document).ready(function($){
	var headerBuilder = function(element, options) {
		this.$element = $(element);
		this.init();
		this.ready();
		this.colorPicker();
		this.iconSelector();
		this.hbNamesForm();
	};
	headerBuilder.prototype.init = function() {
		var self = this;
		this.prepEventListeners();
	};
	headerBuilder.prototype.prepEventListeners = function() {
		this.$element.on('click',".hbBlockDelete",jQuery.proxy(this.removeBlock, this));
		this.$element.on('click',".clear_headers",jQuery.proxy(this.clearAll, this));
		this.$element.on('click',".aq_upload_button",jQuery.proxy(this.uploadImage, this));
		this.$element.on('click',".remove_image",jQuery.proxy(this.removeImage, this));
		this.$element.on('click',"[data-toggle='stackablemodal']",jQuery.proxy(this.stackableModal, this));
		this.$element.on('click',".hb_names_delete",jQuery.proxy(this.deleteNames, this));
		this.$element.on('click',".addSocial",jQuery.proxy(this.addSocial, this));
		this.$element.on('click',".removeSocial",jQuery.proxy(this.removeSocial, this));
		this.$element.on('click',".delete_header",jQuery.proxy(this.deleteHeader, this));
		this.$element.on('click',".hbItems > ul > li",jQuery.proxy(this.appendBlock, this));
		this.$element.on('click',".checkBoxSwitcherField .input-checkbox",jQuery.proxy(this.checkBoxSwitcherField, this));
		this.$element.on('change',".selectSwitcherField select",jQuery.proxy(this.selectSwitcherField, this));
		this.$element.on('change',".menuAlign select",jQuery.proxy(this.menuAlign, this));
		this.$element.on('click',".input-checkbox",jQuery.proxy(this.checkBoxClick, this));
	};
	headerBuilder.prototype.ready = function() {
		
		this.initializeSortable();
		
		this.initializeDraggable();
		
		this.initializeDroppable();
		
		$( "#tabs" ).tabs();
		
		this.creidenHBIconSelector();
		
		$('.hbModal').each(function(counter,that) {
			$(that).find('.socialWrapper').each(function(index,element) {
				if(index >= 1) {
					$(element).find('.removeSocial').show();					
				}
			});
		});
		
		this.adjustOrderingAll();
		$this = this;
		$(".menuAlign").each(function(index,element) {
			$this.menuAlign($(element).find('select'));
		});
		$that = this;
		$('.checkBoxSwitcherField').each(function(index,element) {
			if($(element).find('.input-checkbox').length) {
				$that.checkBoxSwitcherField($(element).find('.input-checkbox'));	
			}
		});
		$select = this;
		$('.selectSwitcherField').each(function(index,element) {
			if($(element).find('select').length) {
				$select.selectSwitcherField($(element).find('select'));	
			}
		});
	};
	
	headerBuilder.prototype.appendBlock = function(event) {
		event.preventDefault();
		var $this = $(event.currentTarget);
		if($this.hasClass('hbHeaderRowWrapper')) {
			var cloned_element = $this.find('.hbBlockWrapper').clone().appendTo($this.parents('.ui-tabs-panel').find('.hbDropArea'));	
		} else {
			var cloned_element = $this.find('.hbBlockWrapper').clone().appendTo($this.parents('.ui-tabs-panel').find('.hbDropArea').find('.hbRowBlocks').last()).addClass('clonedElement');
			if($('.clonedElement').children().hasClass('hbHeaderRow')) {
				$('.clonedElement').remove();
				return true;
			}
			$('.clonedElement').removeClass('.clonedElement');
		
			this.creidenHBIconSelector();
		
			$('.hbModal').each(function(counter,that) {
				$(that).find('.socialWrapper').each(function(index,element) {
					if(index >= 1) {
						$(element).find('.removeSocial').show();					
					}
				});
			});
			event.target = $this.parents('.ui-tabs-panel').find('.hbDropArea').find('.hbRowBlocks').last();
		}
		
		/*
		 * Adjust Orders
		 */
		this.adjustOrdering(event,cloned_element);
		/*
		 * Adjust Parents
		 */
		this.adjustParents(event,cloned_element);
		/*
		 * Reinitialize Dropable
		 */
		this.initializeDroppable();
		/*
		 * Reinitialize the sortable
		 */
		this.initializeSortable();	
		/*
		 * Initialize the Color Picker 
		 */
		this.colorPicker();
		
		$('.hbModal .input-color-picker').each(function(index,element){
			if(!$(element).parents('.selectSwitcher').hasClass('settingsColorPicker')) {
				$(element).parents('.wp-picker-container').last().find('.wp-color-result').addClass('remove').last().removeClass('remove');
				$(element).parents('.wp-picker-container').last().find('.wp-color-result.remove').remove();
			}	
		});
		
		this.creidenHBIconSelector();
		this.iconSelector();
	};
	headerBuilder.prototype.deleteHeader = function(event) {
		event.preventDefault();
		var $this = $(event.currentTarget);
		var confirmAction = confirm("Are you sure you want to Delete this header ?");
		if(confirmAction) {
			$.ajax({
				url: global_creiden.ajax_url,
				type: "POST",
				data : {
					headerName : $this.attr('rel'),
					action : 'remove_header'
				},
				success: function(data) {
					var id = $this.parents('div.ui-tabs-panel').attr('id');
					$('a[href="#'+id+'"]').remove();
					$this.parents('div.ui-tabs-panel').remove();
					$('.hb_names[value="'+$this.attr('rel')+'"]').remove();
					$('.headerSelectors a').first().click();
					alert("Header Successfully Deleted");
				}
			});
		}
	};
	headerBuilder.prototype.creidenHBIconSelector = function(event) {
		var $this ,  _relatedTarget, that, container, oldIcon;
		$(".crdn-icon-selector a[href='#crdn-icon-selector-modal']").on('click',function(e) {
			$this = $(this);
				$('#crdn-icon-selector-modal')
		            .one( 'show.bs.modal', function(e) {
		               		_relatedTarget = $(e.relatedTarget), that = $this.parent('.crdn-icon-selector'), $_this = $(this);
			                if ( _relatedTarget ) {
			                        container = _relatedTarget.closest( '.crdn-icon-selector' );
			                        oldIcon =  that.find( '.crdn-selected-icon' ).val();
			                    $_this.find('.icon-preview')
			                            .find( '.iconfontello' ).removeClass().addClass( 'iconfontello ' + $_this.find( '.icons-box .selectedIcon' ).data( 'icon' ) )
			                            .end().find( '.icon-name' ).text( $_this.find( '.icons-box .selectedIcon' ).data( 'icon' ) );
			                    $_this.one( 'click.iconselector', '.crdn-icon-selector-done', function() {
			                        var selectedIcon = $_this.find( '.selectedIcon' ).data( 'icon' );
			                        that.find( '.crdn-selected-icon' )
			                                .val( selectedIcon )
			                                .end()
			                                .find( '.iconfontello.preview' )
			                                .removeClass( oldIcon ).addClass( selectedIcon );
			                                console.log(selectedIcon);
                                			console.log(that.html());
            								console.log(that.find( '.crdn-selected-icon' ).end().find( '.iconfontello.preview' ).attr('class'));
			                        that.modal( 'hide' );
			                    } );
			                }
			        	   that.on( 'click', '.iconfontello', function() {
			                    if ( $( this ).hasClass( 'selectedIcon' ) ) {
			                        return;
			                    }
			                    that.find('.icons-box').find( '.selectedIcon' ).removeClass( 'selectedIcon' );
			                    $( this ).addClass( 'selectedIcon' );
			                    that.find( '.icon-preview' ).find( '.iconfontello' ).removeClass().addClass( 'iconfontello ' + $( this ).data( 'icon' ) );
			                    that.find( '.icon-preview' ).find( '.icon-name' ).text( $( this ).data( 'icon' ) );
			                } );
		                } )
		           .one( 'shown.bs.modal', function(e) {
		           			$(this).find( '.icons-box' ).find( '.selectedIcon' ).removeClass( 'selectedIcon' );
		                    $(this).find( '.icons-box' ).find( '.' + ( oldIcon || 'iconfontello:first' ) ).addClass( 'selectedIcon' );
		            });
            	});
	};
	headerBuilder.prototype.removeSocial = function(event) {
		event.preventDefault();
		var $this = $(event.currentTarget);
		var modalBody = $this.parents('.modal-body');
		$this.parents('.modalRow').remove();
		modalBody.find('.socialWrapper').each(function(index,element) { 
			$(element).find('input[type="text"]').attr('name',$(element).find('input[type="text"]').attr('name').replace(/social_.*]/g,'social_'+index+']'));
			$(element).find('input[type="hidden"]').attr('name',$(element).find('input[type="hidden"]').attr('name').replace(/social_.*]/g,'social_'+index+']'));
			$(element).find('.crdn-selected-icon').attr('name',$(element).find('.crdn-selected-icon').attr('name').replace(/link_name]\[.*]/g,'link_name]['+index+']'));
			$(element).find('input[type="text"]').attr('name',$(element).find('input[type="text"]').attr('name').replace(/link_text]\[.*]/g,'link_text]['+index+']'));
			$('.hbModal').each(function(counter,that) {
				$(that).find('.socialWrapper').each(function(index,element) {
					if(index >= 1) {
						$(element).find('.removeSocial').show();					
					}
				});
			});
		});
	};
	headerBuilder.prototype.addSocial = function(event) {
		event.preventDefault();
		var $this = $(event.currentTarget);
		var clonedElement = $this.prev('.modalRow').clone().insertBefore($this);
		clonedElement.find('.iconfontello.preview').removeClass().addClass('iconfontello preview');
		clonedElement.find('.input-full').val('#');
		$this.parents('.modal-body').find('.socialWrapper').each(function(index,element) { 
			$(element).find('input[type="text"]').attr('name',$(element).find('input[type="text"]').attr('name').replace(/social_.*]/g,'social_'+index+']'));
			$(element).find('input[type="hidden"]').attr('name',$(element).find('input[type="hidden"]').attr('name').replace(/social_.*]/g,'social_'+index+']'));
			$(element).find('.crdn-selected-icon').attr('name',$(element).find('.crdn-selected-icon').attr('name').replace(/link_name]\[.*]/g,'link_name]['+index+']'));
			$(element).find('input[type="text"]').attr('name',$(element).find('input[type="text"]').attr('name').replace(/link_text]\[.*]/g,'link_text]['+index+']'));
			$('.hbModal').each(function(counter,that) {
				$(that).find('.socialWrapper').each(function(index,element) {
					if(index >= 1) {
						$(element).find('.removeSocial').show();					
					}
				});
			});
		});
		this.creidenHBIconSelector();
	};
	headerBuilder.prototype.hbNamesForm = function(event) {
		$("#hbNamesForm").submit(function(e) {
			var isFormValid = true;
			var names_array = [];
			$('.hb_names').each(function(index,element) {
				var nospaces = $(element).val().replace(/\s+/g, '');
				$(element).val(nospaces);
				if($(element).val() == '') {
					isFormValid = false;
					$(element).addClass('highlight');
				}
				names_array.push($(element).val());
			});
			names_array.pop();
			// update the names of the headers
			/*
			$.ajax({
							url: global_creiden.ajax_url,
							type: "POST",
							data : {
								newValues : names_array,
								action : 'edit_name'
							},
							success: function(data) {
								console.log(data);
								isFormValid = true;
							}
						});*/
			
			
			if($('.highlight').length == 1 && $('.hb_names').hasClass('highlight')) {
				isFormValid = true;
				$('.highlight').attr('name','');
			}
			$('.hb_names').last().removeClass('highlight');
			if (!isFormValid) alert("Please fill in all the required fields (indicated by *)");

   			 return isFormValid;
		});
	};
	headerBuilder.prototype.deleteNames = function(event) {
		event.preventDefault();
		var $this = $(event.currentTarget);
		var rel = $this.attr( 'rel' );
		$("#hb_names_input_"+rel).parent('div').remove();
		this.populateNames();
	};
	headerBuilder.prototype.populateNames = function(event) {
		$('.hb_names').each(function(index,element) {
			$(element).attr('id','hb_names_input_'+index).attr('name','hb_names['+index+']');
		});
		$('.hb_names_delete').each(function(index,element) {
			$(element).attr('rel',index);
		});
	};
	headerBuilder.prototype.stackableModal = function(event) {
		event.preventDefault();
		var $this = $(event.currentTarget);
    	$( $this.attr( 'href' ) ).stackableModal().modal( 'show', this );;
	};
	headerBuilder.prototype.initializeSortable = function() {
		$this = this;
		// Main Blocks
		$('.hbItems ul').sortable({
			connectWith: '.hbDropArea .hbRowBlocks',
			cancel: '.modal, .hbBlockSettings',
            stop: function( event, ui ) {
            	$this.onSortStop(event,ui);
            }
		});
		// Row Blocks
		$('.hbDropArea > .hbBlockWrapper').sortable({
			connectWith: '.hbDropArea',
			cancel: '.modal , .hbBlockSettings',
            stop: function( event, ui ) {
            	$this.onSortStop(event,ui);
            }
		});
		// Blocks inside the row
		$('.hbRowBlocks').sortable({
			connectWith: '.hbRowBlocks',
			cancel: '.modal , .hbBlockSettings',
			start: function( event, ui ) {
				
			},
			stop: function( event, ui ) {
				$this.onSortStop(event,ui);
			}
		});
	};
	
	headerBuilder.prototype.initializeDraggable = function() {
		$('.hbItems li').draggable({
			connectToSortable: ".hbDropArea .hbBlock",
			helper: 'clone',
			revert: 'invalid',
			start: function(event, ui) {
				//block_archive = $(this).attr('id');
			}
		});
	};
	headerBuilder.prototype.initializeDroppable = function() {
		var $this = this; 
		/*
		 * Inside the Column Droppable
		 */
		$('.hbDropArea .hbRowBlocks').droppable({
			accept: ".hbItems li",
			tolerance: "pointer",
			over : function(event, ui) {
				
			},
			out : function(event, ui) {
				
			},
			drop: function(event, ui) {
				$this.onDropInColumn(event,ui);
			}
		});
		/*
		 * Main Area Droppable
		 */
		$('.hbDropArea').each(function(index,element) {
			$(element).droppable({
				accept: ".hbHeaderRowWrapper",
				tolerance: "pointer",
				over : function(event, ui) {
					
				},
				out : function(event, ui) {
					
				},
				drop: function(event, ui) {
					$this.onDropInArea(event,ui,element);
				}
			});
		});
	};
	headerBuilder.prototype.onSortStop = function(event,ui) {
			if(!ui.item.hasClass('hbHeaderRow') && !ui.item.parents('.hbRowBlocks').length) {
				$('.hbDropArea').sortable('cancel');
			}
			if(ui.item.hasClass('hbHeaderRow') && ui.item.parents('.hbRowBlocks').length) {
				$('.hbRowBlocks').sortable('cancel');
			}
			element = {target:ui.item[0]};
			/*
			 * Adjust Parents
			 */
			this.adjustParents(element,ui.item);
			
			this.adjustOrdering(event,ui.item);
			/*
		 	* Reinitialize Dropable
		 	*/
			this.initializeDroppable();
		
			this.colorPicker();
			$('.hbModal .input-color-picker').each(function(index,element){
				if(!$(element).parents('.selectSwitcher').hasClass('settingsColorPicker')) {
					$(element).parents('.wp-picker-container').last().find('.wp-color-result').addClass('remove').last().removeClass('remove');
					$(element).parents('.wp-picker-container').last().find('.wp-color-result.remove').remove();
				}
			});
			/*
			 * Reinitialize the sortable
			 */
			this.initializeSortable();
			
			
	};

	headerBuilder.prototype.onDropInColumn = function(event,ui) {
		var cloned_element = $(ui.draggable).find('.hbBlock').parent().clone().appendTo($(event.target)).addClass('clonedElement');	
		if($('.clonedElement').children().hasClass('hbHeaderRow')) {
			$('.clonedElement').remove();
			return true;
		}
		$('.clonedElement').removeClass('.clonedElement');
		/*
		 * Adjust Orders
		 */
		this.adjustOrdering(event,cloned_element);
		/*
		 * Adjust Parents
		 */
		this.adjustParents(event,cloned_element);
		/*
		 * Reinitialize Dropable
		 */
		this.initializeDroppable();
		this.creidenHBIconSelector();
		this.iconSelector();
		$('.hbModal').each(function(counter,that) {
			$(that).find('.socialWrapper').each(function(index,element) {
				if(index >= 1) {
					$(element).find('.removeSocial').show();					
				}
			});
		});
		/*
		 * Reinitialize the sortable
		 */
		this.initializeSortable();
		/*
		 * Initialize the Color Picker 
		 */
		this.colorPicker();
		
		$('.hbModal .input-color-picker').each(function(index,element){
			if(!$(element).parents('.selectSwitcher').hasClass('settingsColorPicker')) {
				$(element).parents('.wp-picker-container').last().find('.wp-color-result').addClass('remove').last().removeClass('remove');
				$(element).parents('.wp-picker-container').last().find('.wp-color-result.remove').remove();
			}
		});
	};
	headerBuilder.prototype.onDropInArea = function(event,ui,element) {
		var cloned_element = $(ui.draggable).find('.hbBlockWrapper').clone().appendTo(element);
		/*
		 * Adjust Orders
		 */
		this.adjustOrdering(event,cloned_element);
		/*
		 * Adjust Parents
		 */
		this.adjustParents(event,cloned_element);
		/*
		 * Reinitialize Dropable
		 */
		this.initializeDroppable();
		/*
		 * Reinitialize the sortable
		 */
		this.initializeSortable();	
		/*
		 * Initialize the Color Picker 
		 */
		this.colorPicker();
		
		$('.hbModal .input-color-picker').each(function(index,element){
			if(!$(element).parents('.selectSwitcher').hasClass('settingsColorPicker')) {
				$(element).parents('.wp-picker-container').last().find('.wp-color-result').addClass('remove').last().removeClass('remove');
				$(element).parents('.wp-picker-container').last().find('.wp-color-result.remove').remove();
			}	
		});
	};
	headerBuilder.prototype.adjustOrdering = function(event,ui) {
		
		// if the block is a normal block select its parent
		if(ui.attr('class') != 'hbBlockWrapper') {
			ui = ui.parent();
		}
		//set random block id
	    block_number = this.generateRandomNumber();
	    //replace id
	    ui.html(ui.html().replace(/<[^<>]+>/g, function(obj) {
	        return obj.replace(/__i__|%i%/g, block_number);
	    }));
	    ui.find('.order').first().attr('data-block_number',block_number);
	    
	    this.adjustOrderingAll();
	};
	
	headerBuilder.prototype.adjustOrderingAll = function() {
		/*
		 * Long way to do the ordering but safer
		 */
		var counter = 1;
		$('.hbDropArea .hbHeaderRow > .hbSettings').each(function(index,element) {
			 $(element).html($(element).html().replace(/hb_block_.*?]\[/g,'hb_block_'+counter+']['));
			 // Replace the order with the real value
			 $(element).find('.order').val(counter);
			 $(element).find('.order').attr('data-block_number',counter);

	 		 $(element).prevAll('.hbBlockTitle').html($(element).prevAll('.hbBlockTitle').html().replace(/hb_block_modal."*/g,'hb_block_modal'+counter+'"'));
	 		 $(element).next('.modalWrapper').html($(element).next('.modalWrapper').html().replace(/hb_block_.*?]\[/g,'hb_block_'+counter+']['));	
		 	 $(element).next('.modalWrapper').html($(element).next('.modalWrapper').html().replace(/hb_block_modal."*/g,'hb_block_modal'+counter+'"'));	
			 counter++;
		});
		
		$('.hbDropArea .hbRowBlocks .hbSettings').each(function(index,element) {
			 $(element).html($(element).html().replace(/hb_block_.*?]\[/g,'hb_block_'+counter+']['));
			 // Replace the order with the real value
			 $(element).find('.order').val(counter);
			 $(element).find('.order').attr('data-block_number',counter);

		 	 $(element).prev().html($(element).prev().html().replace(/hb_block_modal."*/g,'hb_block_modal'+counter+'"'));
		 	 $(element).next('.modalWrapper').html($(element).next('.modalWrapper').html().replace(/hb_block_.*?]\[/g,'hb_block_'+counter+']['));
		 	 $(element).next('.modalWrapper').html($(element).next('.modalWrapper').html().replace(/hb_block_modal."*/g,'hb_block_modal'+counter+'"'));	
			 counter++;
		});
	};
	
	headerBuilder.prototype.generateRandomNumber = function(event,ui) {
		do {
			id = _.uniqueId();
		} while ( $('.hbDropArea').find('#header-block' + id).length !== 0 );

	   return id;
	};
	
	headerBuilder.prototype.adjustParents = function(event,ui) {
			if($(event.target).hasClass('hbRowBlocks')) {
				$(event.target).siblings('.hbSettings').find('.is_row').val(1);
				//make the parent id equals the id of the parent row
				$(event.target).find('.parent_id').val($(event.target).siblings('.hbSettings').find('.order').val());
			} 
			if($(event.target).hasClass('hbBlockWrapper')) {
				$(event.target).parents('.hbRowBlocks').siblings('.hbSettings').find('.is_row').val(1);
				//make the parent id equals the id of the parent row
				$(event.target).find('.parent_id').val($(event.target).parents('.hbRowBlocks').siblings('.hbSettings').find('.order').val());
				
			} 
	};
	headerBuilder.prototype.clearAll = function(event) {
			var self = this;
			event.preventDefault();
			var $this = $(event.currentTarget);
			var confirmAction = confirm("Are you sure you want to clear all the blocks in this header ?");
			if(confirmAction) {
				$this.parents('form').find('.hbDropArea > div').addClass('removeBlock');
				setTimeout(function() {
					$this.parents('form').find('.hbDropArea > div').remove();	
				},500);	
			}
	};
	headerBuilder.prototype.removeBlock = function(event) {
			var self = this;
			event.preventDefault();
			var $this = $(event.currentTarget);
			if($this.parents('.hbRowBlocks').length) {
				$this.closest('.hbBlock').addClass('removeBlock');
			} else {
				$this.closest('.hbBlockWrapper').addClass('removeBlock');
			}
			$('.removeBlock').css('background', '#d9534f').removeClass('cr_popup').addClass('animate_CF cr_popout');;
			setTimeout(function() {
				$('.removeBlock').remove();	
			},500);
	};
	
	/** Media Uploader
	----------------------------------------------- */
	headerBuilder.prototype.uploadImage = function(event) {
			var self = this;
			event.preventDefault();
			var $this = $(event.currentTarget);
			var $clicked = $this, frame,
			input_id = $clicked.prev().attr('id'),
			media_type = $clicked.attr('rel');

			event.preventDefault();
	
			// If the media frame already exists, reopen it.
			if ( frame ) {
				frame.open();
				return;
			}
	
			// Create the media frame.
			frame = wp.media.frames.customHeader = wp.media({
				// Set the media type
				library: {
					type: media_type
				},
			});
	
			// When an image is selected, run a callback.
			frame.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = frame.state().get('selection').first();
					$('.hbDropArea #' + input_id).val(attachment.attributes.url);
					$('.hbDropArea #' + input_id).prevAll('.screenshot').attr('src', attachment.attributes.url);
					$('.hbDropArea #' + input_id).prev().val(attachment.id);
					$('.hbDropArea #' + input_id).parents('.modal-body').find('.logoWidth').find('input').val(attachment.attributes.width + 'px');
					$('.hbDropArea #' + input_id).parents('.modal-body').find('.logoHeight').find('input').val(attachment.attributes.height + 'px');
			});
	
			frame.open();
	};
	
	headerBuilder.prototype.removeImage = function(event) {
			var self = this;
			event.preventDefault();
			var $this = $(event.currentTarget);
		var $clicked = $this,
			input_id = $clicked.prev().prev().attr('id');

		event.preventDefault();
		//Clear
		$('.hbDropArea #' + input_id).val('');
		$('.hbDropArea #' + input_id).prevAll('.screenshot').attr('src', '');
		$('.hbDropArea #' + input_id).prev().val('');
	};
	
	headerBuilder.prototype.colorPicker = function() {
		$('.hbDropArea .input-color-picker').each(function(){
			var $this	= $(this),
				parent	= $this.parent();
				$this.wpColorPicker();		
		});
		$('.hbModal .input-color-picker').each(function(){
			var $this	= $(this),
				parent	= $this.parent();
				$this.wpColorPicker();		
		});
	};
	
	headerBuilder.prototype.iconSelector = function() {
		$('#crdn-icon-selector-modal')
            .on( 'show.bs.modal', function(e) {
                var _relatedTarget = $(e.relatedTarget), that = $( this );
                if ( _relatedTarget ) {
                        var container = _relatedTarget.closest( '.crdn-icon-selector' );
                        var oldIcon = container.find( '.crdn-selected-icon' ).val();
                    that.find( '.icons-box' )
                            .find( '.selectedIcon' ).removeClass( 'selectedIcon' ).end()
                            .find( '.' + ( oldIcon || 'iconfontello:first' ) ).addClass( 'selectedIcon' );
                    that.find('.icon-preview')
                            .find( '.iconfontello' ).removeClass().addClass( 'iconfontello ' + that.find( '.icons-box .selectedIcon' ).data( 'icon' ) )
                            .end().find( '.icon-name' ).text( that.find( '.icons-box .selectedIcon' ).data( 'icon' ) );
                    that.one( 'click.iconselector', '.crdn-icon-selector-done', function() {
                        var selectedIcon = that.find( '.selectedIcon' ).data( 'icon' );
                        container.find( '.crdn-selected-icon' )
                                .val( selectedIcon )
                                .end()
                                .find( '.iconfontello.preview' )
                                .removeClass( oldIcon ).addClass( selectedIcon );
                        that.modal( 'hide' );
                    } )
                    .one( 'hide', function() {
                        that.off( '.iconselector' );
                    } );
                }
                that.on( 'click', '.iconfontello', function() {
                    if ( $( this ).hasClass( 'selectedIcon' ) ) {
                        return;
                    }
                    that.find('.icons-box').find( '.selectedIcon' ).removeClass( 'selectedIcon' );
                    $( this ).addClass( 'selectedIcon' );
                    that.find( '.icon-preview' ).find( '.iconfontello' ).removeClass().addClass( 'iconfontello ' + $( this ).data( 'icon' ) );
                    that.find( '.icon-preview' ).find( '.icon-name' ).text( $( this ).data( 'icon' ) );
                } );
            } );
	};
	headerBuilder.prototype.checkBoxClick = function(event) {
		if($(event.target).is(':checked')) {
			$(event.target).attr('value',1).attr('checked','checked');
		} else {
			$(event.target).attr('value',0).removeAttr('checked');
		}
	};
	headerBuilder.prototype.checkBoxSwitcherField = function(event) {
		if(event[0]) {
			if($(event).attr('checked') == 'checked') {
				if($(event).parents('.checkBoxSwitcherField').hasClass('inverse'))	{
					$(event).parents('.hbModal').find('.checkBoxSwitcher').hide();
					$(event).parents('.hbModal').find('.checkBoxSwitcher.inverse').show();	
				} else {
					$(event).parents('.hbModal').find('.checkBoxSwitcher').show();
					$(event).parents('.hbModal').find('.checkBoxSwitcher.inverse').hide();
				}
			} else {
				if($(event).parents('.checkBoxSwitcherField').hasClass('inverse'))	{
					$(event).parents('.hbModal').find('.checkBoxSwitcher').show();	
					$(event).parents('.hbModal').find('.checkBoxSwitcher.inverse').hide();
				} else {
					$(event).parents('.hbModal').find('.checkBoxSwitcher').hide();
					$(event).parents('.hbModal').find('.checkBoxSwitcher.inverse').show();
				}
			}			
		} else {
			$this = $(event.currentTarget);
			if($this.attr('checked') == 'checked') {
				if($this.parents('.checkBoxSwitcherField').hasClass('inverse'))	{
					$this.parents('.hbModal').find('.checkBoxSwitcher').hide();	
					$this.parents('.hbModal').find('.checkBoxSwitcher.inverse').show();	
				} else {
					$this.parents('.hbModal').find('.checkBoxSwitcher').show();
					$this.parents('.hbModal').find('.checkBoxSwitcher.inverse').hide();
				}
			} else {
				console.log($this.parents('.checkBoxSwitcher').attr('class'));
				if($this.parents('.checkBoxSwitcherField').hasClass('inverse'))	{
					$this.parents('.hbModal').find('.checkBoxSwitcher').show();	
					$this.parents('.hbModal').find('.checkBoxSwitcher.inverse').hide();
				} else {
					$this.parents('.hbModal').find('.checkBoxSwitcher').hide();
					$this.parents('.hbModal').find('.checkBoxSwitcher.inverse').show();
				}
			}
		}
	};
	
	headerBuilder.prototype.selectSwitcherField = function(event) {
		if(event[0]) {
			$(event).parents('.modal').find('.selectSwitcher').hide();
			$(event).parents('.modal').find('.selectSwitcher_'+$(event).val()).show();
		} else {
			
			$this = $(event.currentTarget);
			$this.parents('.modal').find('.selectSwitcher').hide();
			$this.parents('.modal').find('.selectSwitcher_'+$this.val()).show();
		}
	};
	headerBuilder.prototype.menuAlign = function(event) {
		if(!event.target) {
			if($(event).val() == 1) {
				$(event).parents('.hbModal').find('.toggleMenu').hide();			
			} else {
				$(event).parents('.hbModal').find('.toggleMenu').show();
			}	
		} else {
			if($(event.target).val() == 1) {
				$(event.target).parents('.hbModal').find('.toggleMenu').hide();			
			} else {
				$(event.target).parents('.hbModal').find('.toggleMenu').show();
			}	
		}
		
	};
	$.fn.headerBuilder = function(option, args) {
		return this.each(function() {
			var $this = $(this), data = $this.data('headerBuilder'), options = typeof option == 'object' && option;
			if (!data)
				$this.data('headerBuilder', ( data = new headerBuilder(this, options)));
			if ( typeof option == 'string')
				data[option](args);
		});
	};

	$.fn.headerBuilder.Constructor = headerBuilder;
	$(document).headerBuilder();
});