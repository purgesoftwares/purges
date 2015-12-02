/**
 * AQPB js
 *
 * contains the core js functionalities to be used
 * inside AQPB
 */
jQuery.noConflict();
/** Fire up jQuery - let's dance! **/
jQuery(document).ready(function($){
	checkStack();
	function checkStack() {
		idStack = new Array;
		$('#blocks-to-edit .block').each(function(index,element) {
			idStack[index] = $(element).attr('id');
		});
		do {
			// There is a duplicate let's check it out
			var id = has_duplicates(idStack);
			console.log(has_duplicates(idStack));
			// id has the duplacates array
			for(i = 0; i< has_duplicates(idStack).length; i++) {
				// loop on the duplicates
				duplicate = id[i];
				// loop on each element with this id
				$("#"+duplicate).each(function(index,element) {
					// prepare the random key
					var randomKey = generateRandomKey();
					// change the whole id of the block
					$(element).attr('id',randomKey);
					// take the number only
					randomKey = randomKey.substr(9);
					duplicate = duplicate.substr(15);
					// Regex to replace all the duplicates with the new random value
			    	var s = $(element)[0].outerHTML;
                    var tagRegex = new RegExp('<\\w+((?:\\s[\\w-]+=(\'|")(?:[^\\2]*?)(?:\\2))+)[\\s\\/]*>', 'gim');
                        var attsRegex = new RegExp('(?:\\s[\\w-]+=(\'|")([^\\1]*?)(?:\\1))', 'gim');
                    var replaceSlugs = [ 'template-block-', 'my-content-', 'block-settings-', 'aq_block_' ];
                    var replacmentRegex = new RegExp( '((' + replaceSlugs.join( '|' ) + ')' + duplicate + ')', 'gim' );
					var ns = s.replace(tagRegex, function(match){
                        return match.replace( attsRegex, function( match ) {
                            return match.replace( replacmentRegex, function( match, p1, p2 ) {
                                //p2 is the slug without the id;
                                return p2 + randomKey;
                            } );
                        } );
                       });
                    $(element)[0].outerHTML = ns;
				});
				// empty the array and fill it again
				idStack = new Array;
				$('#blocks-to-edit .block').each(function(index,element) {
					idStack[index] = $(element).attr('id');
				});
			}
		} while( has_duplicates(idStack).length !== 0); // Loop till all the duplicates are solved
		return true;
	}
	function has_duplicates(idStack){
		var hash = [];
		for (var n=idStack.length; n--; ){
		   if (typeof hash[idStack[n]] === 'undefined') hash[idStack[n]] = [];
		   hash[idStack[n]].push(n);
		}

		var duplicates = [];
		for (var key in hash){
		    if (hash.hasOwnProperty(key) && hash[key].length > 1){
		        duplicates.push(key);
		    }
		}
		return duplicates;
	}
	$(document).cr_undo().on('undo.crdn redo.crdn', function(){
		$('ul.blocks li.block.ui-resizable').removeClass('ui-resizable');
		$('ul.blocks li.block .ui-resizable-handle').remove();
		resizable_blocks();
		columns_sortable();
	});
	tooltip_builder();
	$('#saveTemplatePopover').parent().popover( {
		html : true
	});
	$('#saveTemplatePopover').parent().on('shown.bs.popover', function () {
		saveTemplate();
	});
	$('#page-builder').on('click','.resizePlus',function(e) {
		resizePlus($(this),e);
	});
	$('#page-builder').on('click','.resizeMinus',function(e) {
		resizeMinus($(this),e);
	});
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
    $( document ).on( 'click', '[data-toggle="stackablemodal"]', function() {
        $( $( this ).attr( 'href' ) )
                .stackableModal()
                 .one( 'show.bs.modal', function() {
                    var $this = $( this );
                    $this.parents('.cr_popup').removeClass('cr_popup').addClass('addLater');
                  //  if(!global_creiden.wordpress_version){
						jQuery('.aq_block_' + $this.attr( 'id' ).substring( 15 )+'_tabs_editor_tabbed').each(function(index,element) {
										// Critical Part for handling and encoding the wrong data coming from the tabbed block database if it exists
										if(tinyMCE.get($(element).attr('id'))) {
											$(element).text($(element).html(tinyMCE.get($(element).attr('id')).getContent()).text());
										} else {
											tinyMCE.init( {selector: $(element).attr('id'),
									skin: "wp_theme",
									content_css : global_creiden.template_dir+"/css/fonts/fonts-admin.css",
									theme_advanced_fonts : 	"Andale Mono=andale mono,times;"+
															"Droid Kufi Regular=DroidArabicKufi,arial;"+"Droid Kufi Bold=DroidArabicKufiBold,arial;"+
															"Inika =inikaNormal,arial;"+
															"Arial=arial,helvetica,sans-serif;"+
															"Arial Black=arial black,avant garde;"+
															"Source Sans=sourceSans,arial;"+
															"Source Sans Semibold=sourceSansBold,arial;"+
															"Source Sans Light=sourceSansLight,arial;"+
															"Raleway regular=Raleway,arial;"+
															"Raleway Light=Raleway-light,arial;"+	
															"Book Antiqua=book antiqua,palatino;"+
															"Comic Sans MS=comic sans ms,sans-serif;"+
															"Courier New=courier new,courier;"+
															"Georgia=georgia,palatino;"+
															"Helvetica=helvetica;"+
															"Impact=impact,chicago;"+
															"Symbol=symbol;"+
															"Tahoma=tahoma,arial,helvetica,sans-serif;"+
															"Terminal=terminal,monaco;"+
															"Times New Roman=times new roman,times;"+
															"Trebuchet MS=trebuchet ms,geneva;"+
															"Verdana=verdana,geneva;"+
															"Webdings=webdings;"+
															"Wingdings=wingdings,zapf dingbats",
									theme_advanced_font_sizes : "9px,10px,11px,12px,13px,14px,16px,18px,20px,22px,24px,26px,28px,30px,32px,34px,36px,38px,40px,44px,48px,50px,54px",
									theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
									theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
									theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
									style_formats: [
								        {title: 'Line height 10px', inline: 'span', styles: {'line-height': '10px'}},
								        {title: 'Line height 11px', inline: 'span', styles: {'line-height': '11px'}},
								        {title: 'Line height 12px', inline: 'span', styles: {'line-height': '12px'}},
								        {title: 'Line height 13px', inline: 'span', styles: {'line-height': '13px'}},
								        {title: 'Line height 14px', inline: 'span', styles: {'line-height': '14px'}},
								        {title: 'Line height 15px', inline: 'span', styles: {'line-height': '15px'}},
								        {title: 'Line height 16px', inline: 'span', styles: {'line-height': '16px'}},
								        {title: 'Line height 17px', inline: 'span', styles: {'line-height': '17px'}},
								        {title: 'Line height 18px', inline: 'span', styles: {'line-height': '18px'}},
								        {title: 'Line height 19px', inline: 'span', styles: {'line-height': '19px'}},
								        {title: 'Line height 20px', inline: 'span', styles: {'line-height': '20px'}},
								        {title: 'Line height 21px', inline: 'span', styles: {'line-height': '21px'}},
								        {title: 'Line height 22px', inline: 'span', styles: {'line-height': '22px'}},
								        {title: 'Line height 23px', inline: 'span', styles: {'line-height': '23px'}},
								        {title: 'Line height 24px', inline: 'span', styles: {'line-height': '24px'}},
								        {title: 'Line height 25px', inline: 'span', styles: {'line-height': '25px'}},
								        {title: 'Line height 26px', inline: 'span', styles: {'line-height': '26px'}},
								        {title: 'Line height 27px', inline: 'span', styles: {'line-height': '27px'}},
								        {title: 'Line height 28px', inline: 'span', styles: {'line-height': '28px'}},
								        {title: 'Line height 29px', inline: 'span', styles: {'line-height': '29px'}},
								        {title: 'Line height 30px', inline: 'span', styles: {'line-height': '30px'}},
								        {title: 'Line height 31px', inline: 'span', styles: {'line-height': '31px'}},
								        {title: 'Line height 32px', inline: 'span', styles: {'line-height': '32px'}},
								        {title: 'Line height 33px', inline: 'span', styles: {'line-height': '33px'}},
								        {title: 'Line height 34px', inline: 'span', styles: {'line-height': '34px'}},
								        {title: 'Line height 35px', inline: 'span', styles: {'line-height': '35px'}},
								        {title: 'Line height 36px', inline: 'span', styles: {'line-height': '36px'}},
								        {title: 'Line height 37px', inline: 'span', styles: {'line-height': '37px'}},
								        {title: 'Line height 38px', inline: 'span', styles: {'line-height': '38px'}},
								        {title: 'Line height 39px', inline: 'span', styles: {'line-height': '39px'}},
								        {title: 'Line height 40px', inline: 'span', styles: {'line-height': '40px'}},
								    ]
									} );
																							 setTimeout(function() {
												tinyMCE.execCommand( 'mceAddControl', true, $(element).attr('id') );
												setTimeout(function() {
													$(element).text($(element).html(tinyMCE.get($(element).attr('id')).getContent()).text());
												},1000);
											},500);
										}
									});
													 $this.find( 'table.mceLayout' ).css( 'visibility', 'hidden' );
							   tinyMCE.execCommand( 'mceRemoveControl', false, 'aq_block_' + $this.attr( 'id' ).substring( 15 ) );
							jQuery('.aq_block_' + $this.attr( 'id' ).substring( 15 )+'_tabs_editor_tabbed').each(function(index,element) {
							   tinyMCE.execCommand( 'mceRemoveControl', false, $(element).attr('id'));
							});
					//	}

		                $this.crdnFieldDependency();
	                    $this.off( 'change.crdnfd' );
	                    $this.on('click', '.sortable-head', function(){
	                    	var closest = $(this).closest('.sortable-item, .modal-body');
                    		if ( closest.length > 0 && closest.is('.sortable-item') ) {
                    			closest.crdnFieldDependency();
                    		}
	                    });
	                    $this.on( 'change.crdnfd', '[data-fd-handle]', function() {
	                    	var closest = $(this).closest('.sortable-item, .modal-body');
                    		if ( closest.length > 0 && closest.is('.sortable-item') ) {
                    			closest.crdnFieldDependency('run');
                    		} else {
                    			$this.crdnFieldDependency( 'run' );
                    		}
	                    } );
		              })
                .one( 'shown.bs.modal', function() {
                    var $this = $( this );
                   // if(!global_creiden.wordpress_version){
                    tinyMCE.init( {selector: '#aq_block_' + $this.attr( 'id' ).substring( 15 ), skin: "wp_theme",
                                        // plugins: "wordpress,wpeditimage",
                                        content_css : global_creiden.template_dir+"/css/fonts/fonts-admin.css",
                                        theme_advanced_fonts : 	"Andale Mono=andale mono,times;"+
                                        						"Droid Kufi Regular=DroidArabicKufi,arial;"+"Droid Kufi Bold=DroidArabicKufiBold,arial;"+
                                                                "Inika =inikaNormal,arial;"+
                                                                "Arial=arial,helvetica,sans-serif;"+
                                                                "Arial Black=arial black,avant garde;"+
                                                                "Source Sans=sourceSans,arial;"+
                                                                "Source Sans Semibold=sourceSansBold,arial;"+
                                                                "Source Sans Light=sourceSansLight,arial;"+
                                                                "Raleway regular=Raleway,arial;"+
																"Raleway Light=Raleway-light,arial;"+
                                                                "Book Antiqua=book antiqua,palatino;"+
                                                                "Comic Sans MS=comic sans ms,sans-serif;"+
                                                                "Courier New=courier new,courier;"+
                                                                "Georgia=georgia,palatino;"+
                                                                "Helvetica=helvetica;"+
                                                                "Impact=impact,chicago;"+
                                                                "Symbol=symbol;"+
                                                                "Tahoma=tahoma,arial,helvetica,sans-serif;"+
                                                                "Terminal=terminal,monaco;"+
                                                                "Times New Roman=times new roman,times;"+
                                                                "Trebuchet MS=trebuchet ms,geneva;"+
                                                                "Verdana=verdana,geneva;"+
                                                                "Webdings=webdings;"+
                                                                "Wingdings=wingdings,zapf dingbats",
                                        theme_advanced_font_sizes : "9px,10px,11px,12px,13px,14px,16px,18px,20px,22px,24px,26px,28px,30px,32px,34px,36px,38px,40px,44px,48px,50px,54px",
                                        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
                                        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
										style_formats: [
									        {title: 'Line height 10px', inline: 'span', styles: {'line-height': '10px'}},
									        {title: 'Line height 11px', inline: 'span', styles: {'line-height': '11px'}},
									        {title: 'Line height 12px', inline: 'span', styles: {'line-height': '12px'}},
									        {title: 'Line height 13px', inline: 'span', styles: {'line-height': '13px'}},
									        {title: 'Line height 14px', inline: 'span', styles: {'line-height': '14px'}},
									        {title: 'Line height 15px', inline: 'span', styles: {'line-height': '15px'}},
									        {title: 'Line height 16px', inline: 'span', styles: {'line-height': '16px'}},
									        {title: 'Line height 17px', inline: 'span', styles: {'line-height': '17px'}},
									        {title: 'Line height 18px', inline: 'span', styles: {'line-height': '18px'}},
									        {title: 'Line height 19px', inline: 'span', styles: {'line-height': '19px'}},
									        {title: 'Line height 20px', inline: 'span', styles: {'line-height': '20px'}},
									        {title: 'Line height 21px', inline: 'span', styles: {'line-height': '21px'}},
									        {title: 'Line height 22px', inline: 'span', styles: {'line-height': '22px'}},
									        {title: 'Line height 23px', inline: 'span', styles: {'line-height': '23px'}},
									        {title: 'Line height 24px', inline: 'span', styles: {'line-height': '24px'}},
									        {title: 'Line height 25px', inline: 'span', styles: {'line-height': '25px'}},
									        {title: 'Line height 26px', inline: 'span', styles: {'line-height': '26px'}},
									        {title: 'Line height 27px', inline: 'span', styles: {'line-height': '27px'}},
									        {title: 'Line height 28px', inline: 'span', styles: {'line-height': '28px'}},
									        {title: 'Line height 29px', inline: 'span', styles: {'line-height': '29px'}},
									        {title: 'Line height 30px', inline: 'span', styles: {'line-height': '30px'}},
									        {title: 'Line height 31px', inline: 'span', styles: {'line-height': '31px'}},
									        {title: 'Line height 32px', inline: 'span', styles: {'line-height': '32px'}},
									        {title: 'Line height 33px', inline: 'span', styles: {'line-height': '33px'}},
									        {title: 'Line height 34px', inline: 'span', styles: {'line-height': '34px'}},
									        {title: 'Line height 35px', inline: 'span', styles: {'line-height': '35px'}},
									        {title: 'Line height 36px', inline: 'span', styles: {'line-height': '36px'}},
									        {title: 'Line height 37px', inline: 'span', styles: {'line-height': '37px'}},
									        {title: 'Line height 38px', inline: 'span', styles: {'line-height': '38px'}},
									        {title: 'Line height 39px', inline: 'span', styles: {'line-height': '39px'}},
									        {title: 'Line height 40px', inline: 'span', styles: {'line-height': '40px'}},
									    ]
                                        } );

                    _.delay(function(){
                        tinyMCE.execCommand( 'mceAddControl', true, 'aq_block_' + $this.attr( 'id' ).substring( 15 ) );
                        setTimeout(function() {
							if(tinyMCE.get('aq_block_' + $this.attr( 'id' ).substring( 15 ))) {
								console.log($('#aq_block_' + $this.attr( 'id' ).substring( 15 )).text());
								tinyMCE.get('aq_block_' + $this.attr( 'id' ).substring( 15 )).setContent($('#aq_block_' + $this.attr( 'id' ).substring( 15 )).text());
								//tinyMCE.get('aq_block_' + $this.attr( 'id' ).substring( 15 )).save();
							}
							$( 'table.mceLayout' ).css( {
								width: '100%',
								'visibility': 'visible'
							} );
						}, 1000);
                    }, 500);

					jQuery('.aq_block_' + $this.attr( 'id' ).substring( 15 )+'_tabs_editor_tabbed').each(function(index,element) {
						tinyMCE.init( {selector: $(element).attr('id'),
						skin: "wp_theme",
						content_css : global_creiden.template_dir+"/css/fonts/fonts-admin.css",
						theme_advanced_fonts : 	"Andale Mono=andale mono,times;"+
												"Droid Kufi Regular=DroidArabicKufi,arial;"+"Droid Kufi Bold=DroidArabicKufiBold,arial;"+
												"Inika =inikaNormal,arial;"+
												"Arial=arial,helvetica,sans-serif;"+
												"Arial Black=arial black,avant garde;"+
												"Source Sans=sourceSans,arial;"+
												"Source Sans Semibold=sourceSansBold,arial;"+
												"Source Sans Light=sourceSansLight,arial;"+
												"Raleway regular=Raleway,arial;"+
												"Raleway Light=Raleway-light,arial;"+
												"Book Antiqua=book antiqua,palatino;"+
												"Comic Sans MS=comic sans ms,sans-serif;"+
												"Courier New=courier new,courier;"+
												"Georgia=georgia,palatino;"+
												"Helvetica=helvetica;"+
												"Impact=impact,chicago;"+
												"Symbol=symbol;"+
												"Tahoma=tahoma,arial,helvetica,sans-serif;"+
												"Terminal=terminal,monaco;"+
												"Times New Roman=times new roman,times;"+
												"Trebuchet MS=trebuchet ms,geneva;"+
												"Verdana=verdana,geneva;"+
												"Webdings=webdings;"+
												"Wingdings=wingdings,zapf dingbats",
						theme_advanced_font_sizes : "9px,10px,11px,12px,13px,14px,16px,18px,20px,22px,24px,26px,28px,30px,32px,34px,36px,38px,40px,44px,48px,50px,54px",
						theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
						theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
						theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
						style_formats: [
					        {title: 'Line height 10px', inline: 'span', styles: {'line-height': '10px'}},
					        {title: 'Line height 11px', inline: 'span', styles: {'line-height': '11px'}},
					        {title: 'Line height 12px', inline: 'span', styles: {'line-height': '12px'}},
					        {title: 'Line height 13px', inline: 'span', styles: {'line-height': '13px'}},
					        {title: 'Line height 14px', inline: 'span', styles: {'line-height': '14px'}},
					        {title: 'Line height 15px', inline: 'span', styles: {'line-height': '15px'}},
					        {title: 'Line height 16px', inline: 'span', styles: {'line-height': '16px'}},
					        {title: 'Line height 17px', inline: 'span', styles: {'line-height': '17px'}},
					        {title: 'Line height 18px', inline: 'span', styles: {'line-height': '18px'}},
					        {title: 'Line height 19px', inline: 'span', styles: {'line-height': '19px'}},
					        {title: 'Line height 20px', inline: 'span', styles: {'line-height': '20px'}},
					        {title: 'Line height 21px', inline: 'span', styles: {'line-height': '21px'}},
					        {title: 'Line height 22px', inline: 'span', styles: {'line-height': '22px'}},
					        {title: 'Line height 23px', inline: 'span', styles: {'line-height': '23px'}},
					        {title: 'Line height 24px', inline: 'span', styles: {'line-height': '24px'}},
					        {title: 'Line height 25px', inline: 'span', styles: {'line-height': '25px'}},
					        {title: 'Line height 26px', inline: 'span', styles: {'line-height': '26px'}},
					        {title: 'Line height 27px', inline: 'span', styles: {'line-height': '27px'}},
					        {title: 'Line height 28px', inline: 'span', styles: {'line-height': '28px'}},
					        {title: 'Line height 29px', inline: 'span', styles: {'line-height': '29px'}},
					        {title: 'Line height 30px', inline: 'span', styles: {'line-height': '30px'}},
					        {title: 'Line height 31px', inline: 'span', styles: {'line-height': '31px'}},
					        {title: 'Line height 32px', inline: 'span', styles: {'line-height': '32px'}},
					        {title: 'Line height 33px', inline: 'span', styles: {'line-height': '33px'}},
					        {title: 'Line height 34px', inline: 'span', styles: {'line-height': '34px'}},
					        {title: 'Line height 35px', inline: 'span', styles: {'line-height': '35px'}},
					        {title: 'Line height 36px', inline: 'span', styles: {'line-height': '36px'}},
					        {title: 'Line height 37px', inline: 'span', styles: {'line-height': '37px'}},
					        {title: 'Line height 38px', inline: 'span', styles: {'line-height': '38px'}},
					        {title: 'Line height 39px', inline: 'span', styles: {'line-height': '39px'}},
					        {title: 'Line height 40px', inline: 'span', styles: {'line-height': '40px'}},
					    ]} );
						_.delay(function(){
							tinyMCE.execCommand( 'mceAddControl', true, $(element).attr('id') );
							setTimeout(function() {
								if(tinyMCE.get($(element).attr('id'))) {
									tinyMCE.get($(element).attr('id')).setContent($(element).text());
									// tinyMCE.get($(element).attr('id')).save();
								}
								$( 'table.mceLayout' ).css( {
									width: '100%',
									'visibility': 'visible'
								} );
								$this.find( '.wp-editor-container iframe' ).css('height','170px');
								$this.find('.mceToolbar').show();
								$('span.mceEditor').show();
							},1000);
						}, 500);
					});



                    $( 'table.mceLayout' ).css( {
                        width: '100%',
                        'visibility': 'visible'
                    } );
                    $this.find( '.wp-editor-container iframe' ).height( 170 );

                //    }
                } )
                .one( 'hide.bs.modal', function() {
                    var $this = $( this );
                    $this.parents('.addLater').removeClass('addLater').addClass('cr_popup');
				//	if(!global_creiden.wordpress_version){
							if(tinyMCE.get('aq_block_' + $this.attr( 'id' ).substring( 15 ))) {
								//tinyMCE.get('aq_block_' + $this.attr( 'id' ).substring( 15 )).save();
								$('#aq_block_' + $this.attr( 'id' ).substring( 15 )).text(tinyMCE.get('aq_block_' + $this.attr( 'id' ).substring( 15 )).getContent());
								tinyMCE.execCommand( 'mceRemoveControl', false, 'aq_block_' + $this.attr( 'id' ).substring( 15 ) );
							}
							jQuery('.aq_block_' + $this.attr( 'id' ).substring( 15 )+'_tabs_editor_tabbed').each(function(index,element) {
								$(element).text(tinyMCE.get($(element).attr('id')).getContent());
								//tinyMCE.get($(element).attr('id')).save();
								tinyMCE.execCommand( 'mceRemoveControl', false, $(element).attr('id') );
							});
				//	}
                } )
                .one( 'hidden.bs.modal', function() {
                    var $this = $( this );
                } )
                .modal( 'show', this );
    } );
	$('.importToggle').click(function(e) {
		e.preventDefault();
		$('.importWrapper').toggle();
		$('.exportWrapper').hide();
	});
	$('.exportToggle').click(function(e) {
		e.preventDefault();
		$('.exportWrapper').toggle();
		$('.importWrapper').hide();
	});
	$('.icons .radioButtonIcon i.iconfontello').click(function(){
		$(this).parent().children('input').attr('checked','checked');
		$(this).parents('.icons').find('i.iconfontello').removeClass('click checked');
		$(this).addClass('click');
	});
	$('.icons .radioButtonIcon input[checked="checked"]').each(function(){
		$(this).parent().children('i').addClass('checked');
	});

	$('.list .radioButtonIcon i.iconfontello').click(function() {
		$(this).parent().children('input').attr('checked','checked');
		$(this).parents('.list').find('i.iconfontello').removeClass('click').removeClass("checked");
		$(this).addClass('click');
	});
	$('.list .radioButtonIcon input[checked="checked"]').each(function(){
		$(this).parent().children('i').addClass('checked');
	});


	/** Variables
	------------------------------------------------------------------------------------**/
	var steps = new Array(191,259,397,554,608,791);
	var current_step = steps[0];

	//var column_steps = new Array(85,152,219,286,353,420,487,554,621,688,755);
	// var regular_steps = new Array(124,191,259,326,397,463,524,608,662,727,791);
	var regular_steps = new Array(16.66667,25,33.3333,41.66667,50,58.33333,66.66667,75,83.3333,91.66667,100);
	// var regular_steps = new Array(124,191,259,326,397,463,524,608,662,87.08333%,95%);
	// var regular_steps = new Array(138,205,272,334,401,465,553,595,657,724,791);
	var current_regular_step = regular_steps[0];

	// var column_steps = new Array(118,183,249,312,378,444,503,570,634,700,766);
    var column_steps = new Array(
    			[],
    			[],
				[98,98,98,98,98,98,98,98,98,98,98],
				[65.33333333333333,98,98,98,98,98,98,98,98,98,98],
				[49,73.5,98,98,98,98,98,98,98,98,98],
				[39.2,58.8,78.4,98,98,98,98,98,98,98,98],
				[32.666666666666664,49,65.33333333333333,81.66666666666667,98,98,98,98,98,98,98],
				[28,42,56,70,84,98,98,98,98,98,98],
				[24.5,36.75,49,61.25,73.5,85.75,98,98,98,98,98],
				[21.777777777777775,32.666666666666664,43.55555555555555,54.44444444444445,65.33333333333333,76.22222222222223,87.1111111111111,98,98,98,98],
				[19.6,29.4,39.2,49,58.8,68.6,78.4,88.2,98,98,98],
				[17.81818181818182,26.727272727272727,35.63636363636364,44.54545454545455,53.45454545454545,62.36363636363636,71.27272727272728,80.18181818181819,89.0909090909091,98,98],
				[16.333333333333332,24.5,32.666666666666664,40.833333333333336,49,57.16666666666667,65.33333333333333,73.5,81.66666666666667,89.83333333333333,98]
			);
	var current_column_step = column_steps[12][0];

	var column_home_steps = new Array(183,249,378,503,570,766);
	var current_column_home_step = column_home_steps[0];


	var block_archive,
		block_number,
		parent_id,
		block_id,
		intervalId,
		resizable_args = {
			handles: 'e',
			minWidth: 85,
			start: function(event, ui) {
				crdn.undo.prototype.setStorage();
				if($(ui.helper).hasClass('cr-columns')) {
					$(ui.helper).find('li.block').each(function(index,element) {
						$(element).width($(element).width());
					});
				}
			},
			resize: function(event, ui) {
			    ui.helper.css("height", "inherit");
			    var ui_size = ui.size.width/$('#blocks-to-edit').width()*100;
			    if(ui_size <= regular_steps[0]) {
		            $(this).css('width',regular_steps[0]+'%');
		            current_regular_step = regular_steps[0];
		        } else if(ui_size >= regular_steps[0] && ui_size <= regular_steps[1]) {
		            $(this).css('width',regular_steps[1]+'%');
		            current_regular_step = regular_steps[1];
		        } else if(ui_size >= regular_steps[1] && ui_size <= regular_steps[2]) {
		            $(this).css('width',regular_steps[2]+'%');
		            current_regular_step = regular_steps[2];
		        } else if(ui_size >= regular_steps[2] && ui_size <= regular_steps[3]) {
		            $(this).css('width',regular_steps[3]+'%');
		            current_regular_step = regular_steps[3];
		        } else if(ui_size >= regular_steps[3] && ui_size <= regular_steps[4]) {
		            $(this).css('width',regular_steps[4]+'%');
		            current_regular_step = regular_steps[4];
		        } else if(ui_size >= regular_steps[4] && ui_size <= regular_steps[5]) {
		            $(this).css('width',regular_steps[5]+'%');
		            current_regular_step = regular_steps[5];
		        } else if(ui_size >= regular_steps[5] && ui_size <= regular_steps[6]) {
		            $(this).css('width',regular_steps[6]+'%');
		            current_regular_step = regular_steps[6];
		        } else if(ui_size >= regular_steps[6] && ui_size <= regular_steps[7]) {
		            $(this).css('width',regular_steps[7]+'%');
		            current_regular_step = regular_steps[7];
		        } else if(ui_size >= regular_steps[7] && ui_size <= regular_steps[8]) {
		            $(this).css('width',regular_steps[8]+'%');
		            current_regular_step = regular_steps[8];
		        } else if(ui_size >= regular_steps[8] && ui_size <= regular_steps[9]) {
		            $(this).css('width',regular_steps[9]+'%');
		            current_regular_step = regular_steps[9];
		        } else if(ui_size >= regular_steps[9] && ui_size <= regular_steps[10]) {
		            $(this).css('width',regular_steps[10]+'%');
		            current_regular_step = regular_steps[10];
		        } else {
		            $(this).css('width',regular_steps[10]+'%');
		            current_regular_step = regular_steps[10];
		        }
			},
			stop: function(event, ui) {
				ui.helper.css('left', ui.originalPosition.left);
				$(ui.helper).toggleClass( function (index, css) {
				    return (css.match (/\bspan\S+/g) || []).join(' ') + ' ' + block_size( $(ui.helper).width());
				});
				if($(ui.helper).hasClass('cr-columns')) {
					$(ui.helper).find('.block-settings-column').find('.size').first().val(block_size( $(ui.helper).width() ));
					// $('.size[name*='+$(ui.helper).attr('id').substring('15')+']').val(block_size( $(ui.helper).width() ));
					// if there is some blocks inside the column and you are resizing it
					if($(ui.helper).find('li.block').length) {
						$(ui.helper).find('li.block').each(function (count,element) {
							$(element).css('width','');
							if(parseInt($(ui.helper).find('.size').last().val().substring(4)) <= parseInt($(element).find('.size').val().substring(4))) {
								//var parent_span = $(ui.helper).children('.block-settings-column').find('.size').first().val();
								var parent_span = $('.size[name*='+$(ui.helper).attr('id').substring('15')+']').val();
								$(element).toggleClass (function (index, css) {
								    return (css.match (/\bspan\S+/g) || []).join(' ') + ' ' + parent_span ;
								});
								$(element).find('.block-settings').find('.size').val(parent_span);
							}
						});

					}
				} else {
					$(ui.helper).find('.block-settings').find('.size').val(block_size( $(ui.helper).width() ));
					var parent_span = $(ui.helper).find('.size').val();
				}
				$(ui.helper).css('width','');
				handleSize($(ui.helper).children('div'));
			}
		},
		resizable_args_Home = {
			// grid: 186,
			handles: 'e',
			minWidth: 104,
			start: function() {
				crdn.undo.prototype.setStorage();
			},
			resize: function(event, ui) {
			    ui.helper.css("height", "inherit");
			    if(ui.size.width <= steps[0]) {
		            $(this).width(steps[0]);
		            current_step = steps[0];
		        } else if(ui.size.width >= steps[0] && ui.size.width <= steps[1]) {
		            $(this).width(steps[1]);
		            current_step = steps[1];
		        } else if(ui.size.width >= steps[1] && ui.size.width <= steps[2]) {
		            $(this).width(steps[2]);
		            current_step = steps[2];
		        } else if(ui.size.width >= steps[2] && ui.size.width <= steps[3]) {
		            $(this).width(steps[3]);
		            current_step = steps[3];
		        } else if(ui.size.width >= steps[3] && ui.size.width <= steps[4]) {
		            $(this).width(steps[4]);
		            current_step = steps[4];
		        } else if(ui.size.width >= steps[4] && ui.size.width <= steps[5]) {
		            $(this).width(steps[5]);
		            current_step = steps[5];
		        } else if(ui.size.width > steps[5]) {
		            $(this).width(steps[5]);
		            current_step = steps[5];
		        }
			},
			stop: function(event, ui) {
				ui.helper.css('left', ui.originalPosition.left);
				$(ui.helper).toggleClass( function (index, css) {
				    return (css.match (/\bspan\S+/g) || []).join(' ') + ' ' + block_size( $(ui.helper).width());
				});
				if($(ui.helper).hasClass('cr-columns')) {
					$(ui.helper).find('.block-settings-column').find('.size').first().val(block_size( $(ui.helper).width() ));
					// if it there is some blocks inside the column and you are resizing it
					if($(ui.helper).find('li.block').length) {
						$(ui.helper).find('li.block').each(function (count,element) {
							if($(element).width() == $(ui.helper).width() - 21) {
								// var parent_span = $(ui.helper).children('.block-settings-column').find('.size').first().val();
								var parent_span = $('.size[name*='+$(ui.helper).attr('id').substring('15')+']').val();
								$(element).toggleClass (function (index, css) {
								    return (css.match (/\bspan\S+/g) || []).join(' ') + ' ' + parent_span;
								});
								$(element).find('.block-settings').find('.size').val(parent_span );
							}
						});

					}
				} else {
					$(ui.helper).find('.block-settings').find('.size').val(block_size( $(ui.helper).width() ));
					var parent_span = $(ui.helper).find('.size').val();
				}
				$(ui.helper).css('width','');
				handleSize($(ui.helper).children('div'));
			}
		},
		resizable_args_column = {
			handles: 'e',
			minWidth: 95,
			start: function() {
				crdn.undo.prototype.setStorage();
			},
			resize: function(event, ui) {
			    ui.helper.css("height", "inherit");
				var column_size = ui.element.parents('.cr-columns').find('.block-settings-column').find('.size').last().val();
				switch (column_size){
					case 'span12':
						update_column_step($(this),12,ui);
					break;
					case 'span11':
						update_column_step($(this),11,ui);
					break;
					case 'span10':
						update_column_step($(this),10,ui);
					break;
					case 'span9':
						update_column_step($(this),9,ui);
					break;
					case 'span8':
						update_column_step($(this),8,ui);
					break;
					case 'span7':
						update_column_step($(this),7,ui);
					break;
					case 'span6':
						update_column_step($(this),6,ui);
					break;
					case 'span5':
						update_column_step($(this),5,ui);
					break;
					case 'span4':
						update_column_step($(this),4,ui);
					break;
					case 'span3':
						update_column_step($(this),3,ui);
					break;
					case 'span2':
						update_column_step($(this),2,ui);
					break;
					default:
						update_column_step($(this),2,ui);
					break;
				}


			},
			stop: function(event, ui) {
				ui.helper.css('left', ui.originalPosition.left);
				ui.helper.removeClass (function (index, css) {
				    return (css.match (/\bspan\S+/g) || []).join(' ');
				}).addClass(block_size_incolumn( $(ui.helper).width(), $(ui.helper).parents('.cr-columns')));
				if($(ui.helper).hasClass('cr-columns')) {
					ui.helper.find('.block-settings-column').find('.size').first().val(block_size_incolumn( $(ui.helper).width(), $(ui.helper).parents('.cr-columns') ));
				} else {
					ui.helper.find('.block-settings').find('.size').val(block_size_incolumn( $(ui.helper).width(), $(ui.helper).parents('.cr-columns') ));
				}
				$(ui.helper).css('width','');
				handleSize($(ui.helper).children('div'));
			}
		},
		resizable_args_home_column = {
			handles: 'e',
			minWidth: 95,
			start: function() {
				crdn.undo.prototype.setStorage();
			},
			resize: function(event, ui) {
			    ui.helper.css("height", "inherit");
			    if(ui.size.width <= column_home_steps[0]) {
		            $(this).width(column_home_steps[0]);
		            current_column_home_step = column_home_steps[0];
		        } else if(ui.size.width >= column_home_steps[0] && ui.size.width <= column_home_steps[1]) {
		            $(this).width(column_home_steps[1]);
		            current_column_home_step = column_home_steps[1];
		        } else if(ui.size.width >= column_home_steps[1] && ui.size.width <= column_home_steps[2]) {
		            $(this).width(column_home_steps[2]);
		            current_column_home_step = column_home_steps[2];
		        } else if(ui.size.width >= column_home_steps[2] && ui.size.width <= column_home_steps[3]) {
		            $(this).width(column_home_steps[3]);
		            current_column_home_step = column_home_steps[3];
		        } else if(ui.size.width >= column_home_steps[3] && ui.size.width <= column_home_steps[4]) {
		            $(this).width(column_home_steps[4]);
		            current_column_home_step = column_home_steps[4];
		        } else if(ui.size.width >= column_home_steps[4] && ui.size.width <= column_home_steps[5]) {
		            $(this).width(column_home_steps[5]);
		            current_column_home_step = column_home_steps[5];
		        } else if(ui.size.width >= column_home_steps[5] && ui.size.width <= column_home_steps[6]) {
		            $(this).width(column_home_steps[6]);
		            current_column_home_step = column_home_steps[6];
		        } else if(ui.size.width >= column_home_steps[6] && ui.size.width <= column_home_steps[7]) {
		            $(this).width(column_home_steps[7]);
		            current_column_home_step = column_home_steps[7];
		        } else if(ui.size.width >= column_home_steps[7] && ui.size.width <= column_home_steps[8]) {
		            $(this).width(column_home_steps[8]);
		            current_column_home_step = column_home_steps[8];
		        } else if(ui.size.width >= column_home_steps[8] && ui.size.width <= column_home_steps[9]) {
		            $(this).width(column_home_steps[9]);
		            current_column_home_step = column_home_steps[9];
		        } else if(ui.size.width >= column_home_steps[9] && ui.size.width <= column_home_steps[10]) {
		            $(this).width(column_home_steps[10]);
		            current_column_home_step = column_home_steps[10];
		        } else {
		            $(this).width(column_home_steps[10]);
		            current_column_home_step = column_home_steps[10];
		        }
			},
			stop: function(event, ui) {
				crdn.undo.prototype.setStorage();
				ui.helper.css('left', ui.originalPosition.left);
				ui.helper.removeClass (function (index, css) {
				    return (css.match (/\bspan\S+/g) || []).join(' ');
				}).addClass(block_size_incolumn( $(ui.helper).width(), $(ui.helper).parents('.cr-columns') ));
				if($(ui.helper).hasClass('cr-columns')) {
					ui.helper.find('.block-settings-column').find('.size').first().val(block_size_incolumn( $(ui.helper).width(), $(ui.helper).parents('.cr-columns') ));
				} else {
					ui.helper.find('.block-settings').find('.size').val(block_size_incolumn( $(ui.helper).width(), $(ui.helper).parents('.cr-columns') ));
				}
				$(ui.helper).css('width','');
				handleSize($(ui.helper).children('div'));
			}
		},
		tabs_width = $('.aqpb-tabs').outerWidth(),
		mouseStilldown = false,
		max_marginLeft = 720 - Math.abs(tabs_width),
		activeTab_pos = $('.aqpb-tab-active').next().position(),
		act_mleft,
		$parent,
		$clicked;

	/** Functions
	------------------------------------------------------------------------------------**/
	function update_column_step(elementy,span,ui) {

		var column_width = ui.element.parents('.cr-columns').width();
		var ui_width = ui.size.width/column_width*100;
		if(ui_width <= column_steps[span][0]) {
			elementy.css('width',column_steps[span][0]+'%');
			current_column_step = column_steps[span][0];
			handleSize($(ui.helper).children('div'));
		} else if(ui_width >= column_steps[span][0] && ui_width <= column_steps[span][1]) {
			elementy.css('width',column_steps[span][1]+'%');
			current_column_step = column_steps[span][1];
			handleSize($(ui.helper).children('div'));
		} else if(ui_width >= column_steps[span][1] && ui_width <= column_steps[span][2]) {
			elementy.css('width',column_steps[span][2]+'%');
			current_column_step = column_steps[span][2];
			handleSize($(ui.helper).children('div'));
		} else if(ui_width >= column_steps[span][2] && ui_width <= column_steps[span][3]) {
			elementy.css('width',column_steps[span][3]+'%');
			current_column_step = column_steps[span][3];
			handleSize($(ui.helper).children('div'));
		} else if(ui_width >= column_steps[span][3] && ui_width <= column_steps[span][4]) {
			elementy.css('width',column_steps[span][4]+'%');
			current_column_step = column_steps[span][4];
			handleSize($(ui.helper).children('div'));
		} else if(ui_width >= column_steps[span][4] && ui_width <= column_steps[span][5]) {
			elementy.css('width',column_steps[span][5]+'%');
			current_column_step = column_steps[span][5];
			handleSize($(ui.helper).children('div'));
		} else if(ui_width >= column_steps[span][5] && ui_width <= column_steps[span][6]) {
			elementy.css('width',column_steps[span][6]+'%');
			current_column_step = column_steps[span][6];
			handleSize($(ui.helper).children('div'));
		} else if(ui_width >= column_steps[span][6] && ui_width <= column_steps[span][7]) {
			elementy.css('width',column_steps[span][7]+'%');
			current_column_step = column_steps[span][7];
			handleSize($(ui.helper).children('div'));
		} else if(ui_width >= column_steps[span][7] && ui_width <= column_steps[span][8]) {
			elementy.css('width',column_steps[span][8]+'%');
			current_column_step = column_steps[span][8];
			handleSize($(ui.helper).children('div'));
		} else if(ui_width >= column_steps[span][8] && ui_width <= column_steps[span][9]) {
			elementy.css('width',column_steps[span][9]+'%');
			current_column_step = column_steps[span][9];
			handleSize($(ui.helper).children('div'));
		} else if(ui_width >= column_steps[span][9] && ui_width <= column_steps[span][10]) {
			elementy.css('width',column_steps[span][10]+'%');
			current_column_step = column_steps[span][10];
			handleSize($(ui.helper).children('div'));
		} else {
			elementy.css('width',column_steps[span][10]+'%');
			current_column_step = column_steps[span][10];
			handleSize($(ui.helper).children('div'));
		}
	}
	/** create unique id **/
	function makeid()
	{

		// var text = "";
	    // var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		   // for( var i=0; i < 5; i++ )
			   // text += possible.charAt(Math.floor(Math.random() * possible.length));
		do {
			id = _.uniqueId('dynamic_');
		} while ( $('#template-block-' + id).length !== 0 );

	   return id;
	}

	function generateRandomKey() {
		var text = "aq_block_";
	    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		   for( var i=0; i < 5; i++ )
			   text += possible.charAt(Math.floor(Math.random() * possible.length));

		return text;
	}
	/** Get correct class for block size **/
	function block_size(width) {
		var span = "span12";
		width = parseInt(width);
		var ui_size = width/$('#blocks-to-edit').width()*100;

			 if (ui_size <= regular_steps[0]) { span = "span2"; }
		else if (ui_size > regular_steps[0] && ui_size <= regular_steps[1]){ span = "span3"; }
		else if (ui_size > regular_steps[1] && ui_size <= regular_steps[2]){ span = "span4"; }
		else if (ui_size > regular_steps[2] && ui_size <= regular_steps[3]){ span = "span5"; }
		else if (ui_size > regular_steps[3] && ui_size <= regular_steps[4]){ span = "span6"; }
		else if (ui_size > regular_steps[4] && ui_size <= regular_steps[5]){ span = "span7"; }
		else if (ui_size > regular_steps[5] && ui_size <= regular_steps[6]){ span = "span8"; }
		else if (ui_size > regular_steps[6] && ui_size <= regular_steps[7]){ span = "span9"; }
		else if (ui_size > regular_steps[7] && ui_size <= regular_steps[8]){ span = "span10"; }
		else if (ui_size > regular_steps[8] && ui_size <= regular_steps[9]){ span = "span11"; }
		else if (ui_size > regular_steps[9] && ui_size <= regular_steps[10]){ span = "span12"; }
		return span;
	}
	function block_size_incolumn(width,parent) {
		var span = "span12";
		width = parseInt(width);
		var parent_width = parent.width();
		var ui_width = width/parent_width*100; // width in percentage
		var size = parent.find('.block-settings-column').find('.size').last().val().substring(4);

		if(ui_width <= column_steps[size][0])
			span = "span2";
		else if(ui_width >= column_steps[size][0] && ui_width <= column_steps[size][1])
			span = "span3";
		else if(ui_width >= column_steps[size][1] && ui_width <= column_steps[size][2])
			span = "span4";
		else if(ui_width >= column_steps[size][2] && ui_width <= column_steps[size][3])
			span = "span5";
		else if(ui_width >= column_steps[size][3] && ui_width <= column_steps[size][4])
			span = "span6";
		else if(ui_width >= column_steps[size][4] && ui_width <= column_steps[size][5])
			span = "span7";
		else if(ui_width >= column_steps[size][5] && ui_width <= column_steps[size][6])
			span = "span8";
		else if(ui_width >= column_steps[size][6] && ui_width <= column_steps[size][7])
			span = "span9";
		else if(ui_width >= column_steps[size][7] && ui_width <= column_steps[size][8])
			span = "span10";
		else if(ui_width >= column_steps[size][8] && ui_width <= column_steps[size][9])
			span = "span11";
		else if(ui_width >= column_steps[size][9] && ui_width <= column_steps[size][10])
			span = "span12";
		return span;

			/*
			 if (width > 0      && width < 122) { span = "span2"; }
					else if (width >= 123   && width < 190) { span = "span3"; } //183
					else if (width >= 190   && width < 260) { span = "span4"; } // 249
					else if (width >= 260   && width < 330) { span = "span5"; } // 312
					else if (width >= 330   && width < 380) { span = "span6"; } // Handling Equality Case 378 368
					else if (width >= 380   && width < 460) { span = "span7"; } // 444
					else if (width >= 460   && width < 520) { span = "span8"; } //503
					else if (width >= 520   && width < 590) { span = "span9"; } // 570
					else if (width >= 590   && width < 660) { span = "span10"; } //634
					else if (width >= 660   && width < 720) { span = "span11"; } // 700
					else if (width >= 720   && width < 790) { span = "span12"; } // 766
					return span;*/

	}
	/** Blocks resizable dynamic width **/
	function resizable_dynamic_width(blockID) {
		var blockPar = $('#' + blockID).parent(),
			maxWidth = parseInt($(blockPar).parent().parent().css('width'));

		//set maxWidth for blocks inside columns
		// if($(blockPar).hasClass('column-blocks')) {
			// $('#' + blockID + '.ui-resizable').resizable( "option", "maxWidth", maxWidth );
		// }

		//set widths when the parent resized
		$('#' + blockID).bind( "resizestop", function(event, ui) {
			if($('#' + blockID).hasClass('block-aq_column_block') || $('#' + blockID).hasClass('block-cr_team_wrapper_block') || $('#' + blockID).hasClass('block-cr_joinus_wrapper_block')) {
				var $blockColumn = $('#' + blockID),
					new_maxWidth = parseInt($blockColumn.css('width'));
					child_maxWidth = new Array();

				//reset maxWidth for child blocks
				// child_blockID = $(this).attr('id');
				// $('#' + child_blockID + '.ui-resizable').resizable( "option", "maxWidth", new_maxWidth );
				// child_maxWidth.push(parseInt($('#' + child_blockID).css('width')));

				//get maxWidth of child blocks, use it to set the minWidth for column
				var minWidth = Math.max.apply( Math, child_maxWidth );
				$('#' + blockID + '.ui-resizable').resizable( "option", "minWidth", minWidth );
			}

			$('#' + blockID + '.ui-resizable').css({"position":"","top":"auto","left":"0px"});

		});

	}

	/** Update block order **/
	function update_block_order() {
		$('ul.blocks').each( function() {
			$(this).children('li.block').each( function(index, el) {
				$(el).find('.order').last().val(index + 1);

				if($(el).parent().hasClass('column-blocks')) {
					parent_order = $(el).parent().siblings('.order').val();
					$(el).find('.parent').last().val(parent_order);
				} else {
					$(el).find('.parent').last().val(0);
					if($(el).hasClass('block-aq_column_block') || $(el).hasClass('block-cr_team_wrapper_block') || $(el).hasClass('block-cr_joinus_wrapper_block')) {
						block_order = $(el).find('.order').last().val();
						$(el).find('li.block').each(function(index,elem) {
							$(elem).find('.parent').val(block_order);
						});
					}
				}

			});
		});
	}

	/** Update block number **/
	function update_block_number() {
		$('ul.blocks li.block').each( function(index, el) {
			$(el).find('.number').last().val(index + 1);
		});
	}

	function columns_sortable() {
		$('#page-builder .column-blocks').sortable({
			placeholder: 'placeholder',
			connectWith: '#blocks-to-edit, .column-blocks',
			items: 'li.block',
                        cancel: 'ul.block-controls, .modal'
		});
	}

	/** Menu functions **/
	function moveTabsLeft() {
		if(max_marginLeft < $('.aqpb-tabs').css('margin-left').replace("px", "") ) {
			$('.aqpb-tabs').animate({'marginLeft': ($('.aqpb-tabs').css('margin-left').replace("px", "") - 7) + 'px' },
			1,
			function() {
				if(mouseStilldown) {
					moveTabsLeft();
				}
			});
		}
	}

	function moveTabsRight() {
		if($('.aqpb-tabs').css('margin-left').replace("px", "") < 0) {
			$('.aqpb-tabs').animate({'marginLeft': Math.abs($('.aqpb-tabs').css('margin-left').replace("px", ""))*(-1) + 7 + 'px' },
			1,
			function() {
				if(mouseStilldown) {
					moveTabsRight();
				}
			});
		}
	}

	function centerActiveTab() {
		if($('.aqpb-tab-active').hasClass('aqpb-tab-add')) {
			act_mleft = 690 - $('.aqpb-tab-active').position().left - $('.aqpb-tab-active').width();
			$('.aqpb-tabs').css('margin-left' , act_mleft + 'px');
		} else
		if(720 < activeTab_pos.left) {
			act_mleft = 730 - activeTab_pos.left;
			$('.aqpb-tabs').css('margin-left' , act_mleft + 'px');
		}
	}

	/** Actions
	------------------------------------------------------------------------------------**/
	/** Apply CSS float:left to blocks **/
	$('li.block').css('float', 'none');


	/** Blocks resizable **/
	resizable_blocks();
	function resizable_blocks() {
		$('ul.blocks li.block').each(function() {
			var blockID = $(this).attr('id'),
				blockPar = $(this).parent();

			//blocks resizing
			if($("#" + blockID).parents('li').hasClass('cr-columns')) {
				if($('#' + blockID).hasClass('homePage')) {
					$('#' + blockID).resizable(resizable_args_home_column);
				} else {
					$('#' + blockID).resizable(resizable_args_column);
				}
			} else {
				if($('#' + blockID).hasClass('homePage')) {
					$('#' + blockID).resizable(resizable_args_Home);
				} else {
					$('#' + blockID).resizable(resizable_args);
				}
			}


			//set dynamic width for blocks inside columns
			resizable_dynamic_width(blockID);

			//trigger resize
			$('#' + blockID).trigger("resize");
			$('#' + blockID).trigger("resizestop");

			//disable resizable on .not-resizable blocks
			$(".ui-resizable.not-resizable").resizable("destroy");
		});
	}

	function resizable_certain_block(element) {
			var blockID = $(element).attr('id'),
				blockPar = $(element).parent();

			//blocks resizing
			if($("#" + blockID).parents('li').hasClass('cr-columns')) {
				if($('#' + blockID).hasClass('homePage')) {
					$('#' + blockID).resizable(resizable_args_home_column);
				} else {
					$('#' + blockID).resizable(resizable_args_column);
				}
			} else {
				if($('#' + blockID).hasClass('homePage')) {
					$('#' + blockID).resizable(resizable_args_Home);
				} else {
					$('#' + blockID).resizable(resizable_args);
				}
			}


			//set dynamic width for blocks inside columns
			resizable_dynamic_width(blockID);

			//trigger resize
			$('#' + blockID).trigger("resize");
			$('#' + blockID).trigger("resizestop");

			//disable resizable on .not-resizable blocks
			$(".ui-resizable.not-resizable").resizable("destroy");
	}

	$('#blocks-archive').tabs();
	/** Blocks draggable (archive) **/
	$('#blocks-archive li.block').each(function() {
		$(this).draggable({
			connectToSortable: "#blocks-to-edit",
			helper: 'clone',
			revert: 'invalid',
			start: function(event, ui) {
				block_archive = $(this).attr('id');
			}


		});
	});

	/** Blocks sorting (settings) **/
	$('#blocks-to-edit').sortable({
		placeholder: "placeholder",
		handle: '.block-handle, .block-settings-column',
		connectWith: '#blocks-archive, .column-blocks',
		items: 'li.block',
                cancel: 'ul.block-controls, .modal'
	});

	/** Columns Sortable **/
	columns_sortable();

	/** Sortable bindings **/
	$( "ul.blocks" ).bind( "sortstart", function(event, ui) {
		ui.placeholder.css('width', ui.helper.css('width'));
		$('.empty-template').remove();
	});

	$( "#blocks-archive .block" ).bind( "mousedown", beforeSortStart);
	$( "#blocks-to-edit .block" ).bind( "mousedown", beforeSortStart);

	function beforeSortStart() {
		crdn.undo.prototype.setStorage();
	}

	$( "ul.blocks" ).bind( "sortstop", onSortStop);
	function onSortStop(event, ui) {
		$('.block-popup').hide();
		//if coming from archive
		if (ui.item.hasClass('ui-draggable')) {
			//remove draggable class
		    ui.item.removeClass('ui-draggable');

		    //set random block id
		    block_number = makeid();
		    //replace id
		    ui.item.html(ui.item.html().replace(/<[^<>]+>/g, function(obj) {
		        return obj.replace(/__i__|%i%/g, block_number);
		    }));

		    ui.item.attr("id", block_archive.replace("__i__", block_number));
		    //if column, remove handle bar
		    if(ui.item.hasClass('block-aq_column_block') || ui.item.hasClass('block-cr_team_wrapper_block') || ui.item.hasClass('block-cr_joinus_wrapper_block')) {
		    	ui.item.addClass('cr-columns');
		    	ui.item.find('.clone').first().parent('li').remove();
		    	ui.item.find('.block-settings').removeClass('block-settings').addClass('block-settings-column');
		    }

		    //open on drop
		    var blockID = ui.item.find('a.block-edit').parents('li').attr('id');

			//icon Radio Button
			$('.icons .radioButtonIcon i.iconfontello').click(function(){
				$(this).parent().children('input').attr('checked','checked');
				$(this).parents('.icons').find('i.iconfontello').removeClass('click checked');
				$(this).addClass('click');
			});
			$('.icons .radioButtonIcon input[checked="checked"]').each(function(){
				$(this).parent().children('i').addClass('checked');
			});

			$('.list .radioButtonIcon i.iconfontello').click(function() {
				$(this).parent().children('input').attr('checked','checked');
				$(this).parents('.list').find('i.iconfontello').removeClass('click').removeClass("checked");
				$(this).addClass('click');
			});
			$('.list .radioButtonIcon input[checked="checked"]').each(function(){
				$(this).parent().children('i').addClass('checked');
			});

				/* divder display 	 select option */
		}

		//if moving column inside column, cancel it
		if(ui.item.hasClass('block-aq_column_block') || ui.item.hasClass('block-cr_team_wrapper_block') || ui.item.hasClass('block-cr_joinus_wrapper_block')) {
			if(ui.item.parent().hasClass('column-blocks')) {
				$(this).sortable('cancel');
				return false;
			}
			columns_sortable();
		}

		if(ui.item.parents().hasClass('cr-columns')) {
			// was a larger width and resized
				if( parseInt(ui.item.parents('.cr-columns').find('.size').last().val().substring(4)) <= parseInt(ui.item.find('.size').val().substring(4))) {
					var parent_span = jQuery('.size[name*='+ui.item.parents('.cr-columns').attr('id').substring('15')+']').val();
					ui.item.toggleClass (function (index, css) {
					    return (css.match (/\bspan\S+/g) || []).join(' ')+' '+parent_span;
					});
					ui.item.find('.block-settings').find('.size').val(parent_span );
				} else {
					ui.item.toggleClass (function (index, css) {
					    return (css.match (/\bspan\S+/g) || []).join(' ')+' '+block_size_incolumn( ui.item.width(),ui.item.parents('.cr-columns') );
					});
					ui.item.find('.block-settings').find('.size').val(block_size_incolumn( ui.item.width(), ui.item.parents('.cr-columns') ));
				}
				ui.item.css('width', '');
		}
		//update order & parent ids
		update_block_order();

		//update number
		update_block_number();


			var id_name = ui.item[0].id.substring(15);
			$("#aq_block_"+id_name).insertBefore($("#aq_block_"+id_name).parents('.wp-editor-wrap .wp-editor-container > span'));
			$("#aq_block_"+id_name).show().next('.wp-editor-wrap .wp-editor-container > span').remove();

			var checked_radio_tab = new Array;
		    ui.item.find('.iconselector').each(function(index,element) {
				$(this).find('input:radio:checked').each(function(index1,element1) {
					checked_radio_tab[index1,index] = $(element1).val();
				});
			});
			ui.item.find('.iconselector').each(function(index,element){
				$(this).find('input:radio').each(function(index1,element1){
					for (var i=0; i < checked_radio_tab.length; i++) {
						if($(element1).val() == checked_radio_tab[i,index]) {
							$(element1).attr('checked','checked');
						}
					}
				});
			});
			var checked_radio_tab = new Array;
			ui.item.find('.radioBtnWrapper').each(function(index,element) {
				$(this).find('input:radio:checked').each(function(index1,element1) {
					checked_radio_tab[index1,index] = $(element1).val();
				});
			});
			ui.item.find('.radioBtnWrapper').each(function(index,element){
				$(this).find('input:radio').each(function(index1,element1){
					for (var i=0; i < checked_radio_tab.length; i++) {
						if($(element1).val() == checked_radio_tab[i,index]) {
							$(element1).attr('checked','checked');
						}
					}
				});
			});


			ui.item.find('input[type="number"]').each(function(index,element) {
				$(this).attr('value',$(element).val());
			});

			//init resize on newly added block
		    resizable_certain_block(ui.item);
			aqpb_colorpicker();
			$('.justAppended').removeClass('justAppended');
			ui.item.addClass('justAppended');
			$('.justAppended').addClass('animate_CF cr_popup');
			setTimeout(function() {
		    	$('.justAppended').find('.mceEditor').remove();
		    	$(document.body).on( 'click', '.insert-media', function( event ) {
		    		if($(this).data('editor') !== 'content')
						wpActiveEditor = $(this).data('editor');
				});
		    },500);

			handleSize(ui.item.children('div'));

			tooltip_builder();
			$('select[id*="entrance_animation"]').change(function() {
				var class_added=$(this).val();
				$(this).parents('.select').find('.entrance_animation_sim').removeClass().addClass('entrance_animation_sim');
				$('.entrance_animation_sim').addClass(class_added);
			});
		}


	/** Template Select **/
	function templateChange() {
	$("#template-templates").change(function() {
		if($("#template-templates option:selected").hasClass('manuallySaved')) {
			$.ajax({
				url: global_creiden.ajax_url,
				type: "POST",
				data : {
					postID : $(".saveTemplates").data('postid'),
					getTemp : $(this).val(),
					action : 'content_builder_get_templates'
				},
				success: function(data) {
					$("#blocks-to-edit").html(data);
					resizable_blocks();
					$('#page-builder').on('click','.resizePlus',function(e) {
						resizePlus($(this),e);
					});
					$('#page-builder').on('click','.resizeMinus',function(e) {
						resizeMinus($(this),e);
					});
					$( "ul.blocks" ).each(function(index, element) {
						$(element).find('.block-aq_column_block').addClass('cr-columns');
						// $(element).find('.block-aq_column_block').find('.block-edit').first().parent('li').remove();
						$(element).find('.block-aq_column_block').find('.block-settings').removeClass('block-settings').addClass('block-settings-column');

						$(element).find('.block-cr_team_wrapper_block').addClass('cr-columns');
						// $(element).find('.block-cr_team_wrapper_block').find('.block-edit').first().parent('li').remove();
						$(element).find('.block-cr_team_wrapper_block').find('.block-settings').removeClass('block-settings').addClass('block-settings-column');

						$(element).find('.block-cr_joinus_wrapper_block').addClass('cr-columns');
						// $(element).find('.block-cr_joinus_wrapper_block').find('.block-edit').first().parent('li').remove();
						$(element).find('.block-cr_joinus_wrapper_block').find('.block-settings').removeClass('block-settings').addClass('block-settings-column');
					});
				}
			});
		} else {
				$template = $(this).val();
				if($(this).val() == '') {
					return 0;
				}
				$.ajax({
					url: global_creiden.ajax_url,
					type: "POST",
					data : {
						template : $template,
						action : 'content_builder_templates'
					},
					success: function(data) {
						crdn.undo.prototype.setStorage();
						$("#blocks-to-edit").html(data);
						$('ul.blocks li.block.ui-resizable').removeClass('ui-resizable');
						$('ul.blocks li.block .ui-resizable-handle').remove();
						resizable_blocks();
						/*
						$('#page-builder').on('click','.resizePlus',function(e) {
							resizePlus($(this),e);
						});
						$('#page-builder').on('click','.resizeMinus',function(e) {
							resizeMinus($(this),e);
						});*/
					}
				});
			}
		});
		resizable_blocks();
	}
	templateChange();
	/** Blocks droppable (removing blocks) **/
	$('#page-builder-archive').droppable({
		accept: "#blocks-to-edit .block",
		tolerance: "pointer",
		over : function(event, ui) {
			$(this).find('#removing-block').fadeIn('slow');
			ui.draggable.parent().find('.placeholder').hide();
		},
		out : function(event, ui) {
			$(this).find('#removing-block').fadeOut('Slow');
			ui.draggable.parent().find('.placeholder').show();
		},
		drop: function(ev, ui) {
	        ui.draggable.remove();
	        $(this).find('#removing-block').fadeOut('slow');
		}
	});
	/** Delete Block (via "Delete" anchor) **/
	$(document).on('click', '.block-control-actions a', function() {
		$clicked = $(this);
		$parentChild = $(this).parents('li.sortable-item').first();
		$parent = $(this).parents('li.block').first();
		if($clicked.hasClass('delete')) {
			crdn.undo.prototype.setStorage();
			$parent.find('> .block-bar .block-handle').css('background', 'red');
			$parent.removeClass('cr_popup').addClass('animate_CF cr_popout');
			setTimeout(function() {
				$parent.remove();
				update_block_order();
				update_block_number();
			},500);
			$(this).tooltip('hide');
		} else if($clicked.hasClass('closeTab')) {
			$parent.find('> .block-bar a.block-edit').click();
		} else if($clicked.hasClass('export')) {
			$('.exportWrapper').show();
			$.ajax({
				url: global_creiden.ajax_url,
				type: "POST",
				data : {
					exportedData : $clicked.parents('li.block')[0].outerHTML,
					action : 'content_builder_export_certain_block'
				},
				success: function(data) {
					$("#exportedBlock").html(data);
				}
			});
		} else if($clicked.hasClass('clone')) {
			crdn.undo.prototype.setStorage();
			if($('.justAppended').length == 0) {
				$('li.block').last().addClass('justAppended');
			}
			if(isNaN($('.justAppended').attr('id').substring(15))) {
				var parent_id = $parent.attr('id').substring(15);
				// var last_id = $('.justAppended').attr('id').substring(15);
			} else {
				var parent_id = parseInt($parent.attr('id').substring(15));
				// var last_id = parseInt($('.justAppended').attr('id').substring(15));
			}
			// parent_id_cloned = last_id + 1;
			parent_id_cloned = makeid();
			$parent.find('input:text').each(function() {
			    $(this).attr('value', $(this).val());
			});
			$parent.find('input[type="number"]').each(function() {
				$(this).attr('value',$(this).val());
			});
			$parent.find('input:checkbox').each(function() {
				if($(this).attr('checked')) {
					$(this).attr('checked','checked');
				}
			});
			$parent.find('select').each(function(index,element) {
				$(element).children('option').each(function(indexy,elementy) {
					if($(elementy).val() == $(element).val()) {
						$(elementy).attr('selected','selected');
					}
				});
			});
			$parent.find('textarea').each(function() {
				$(this).text($(this).val());
			});


			var checked_radio_tab = new Array;
				$parent.find('.iconselector').each(function(index,element) {
					$(this).find('input:radio:checked').each(function(index1,element1) {
						checked_radio_tab[index1,index] = $(element1).val();
					});
				});
			var checked_radio_tab = new Array;
			$parent.find('.radioBtnWrapper').each(function(index,element) {
				$(this).find('input:radio:checked').each(function(index1,element1) {
					checked_radio_tab[index1,index] = $(element1).val();
				});
			});
				var $cloned_element = $parent.clone();
				$('.justAppended').removeClass('justAppended');
				$cloned_element.addClass('justAppended');

				$('.justAppended').find('.aq_block_' + parent_id_cloned+'_tabs_editor_tabbed').each(function(index,element) {
				   tinyMCE.execCommand( 'mceRemoveControl', true, $(element).attr('id'));
			    });
			    setTimeout(function() {
			    	$('.justAppended').find('.mceEditor').remove();
			    },500);
			    $('.justAppended').find('.mceEditor').remove();
				$cloned_element.appendTo($parent.parent('ul.blocks'));
				$parent.find('.iconselector').each(function(index,element){
					$(this).find('input:radio').each(function(index1,element1){
						for (var i=0; i < checked_radio_tab.length; i++) {
							if($(element1).val() == checked_radio_tab[i,index]) {
								$(element1).attr('checked','checked');
							}
						}
					});
				});
				$parent.find('.radioBtnWrapper').each(function(index,element){
					$(this).find('input:radio').each(function(index1,element1){
						for (var i=0; i < checked_radio_tab.length; i++) {
							if($(element1).val() == checked_radio_tab[i,index]) {
								$(element1).attr('checked','checked');
							}
						}
					});
				});
				/*$parent.find('input:radio:checked').each(function(index,element) {
					checked_radio[index] = $(element).val();
				});
				$parent.clone().appendTo($parent.parent('ul.blocks'));
				$parent.find('input:radio').each(function(index,element) {
					for (var i=0; i < checked_radio.length; i++) {
						if($(element).val() == checked_radio[i]) {
							$(element).attr('checked','checked');
						}
					};

				});*/

			var s = $parent.parent('ul.blocks').children('li').last()[0].outerHTML;
						//			var re = new RegExp("(['\"].*?[-_])(" + parent_id + ")(.*?['\"])", "gim");
                        /*
                         * start out by parsing html opening tags with
                         *  <\w+((?:\s\w+=('|")(?:[^\2]*?)(?:\2))+)[\s\/]*>
                         * then parse the attributes on each tag with
                         *  (?:\s\w+=('|")([^\1]*?)(\1))
                         * after that, just replace the strings we want ( defined in replaceSlugs )
                         *  ((slug-one-|slug-two-|slug-three-)parent_id)
                         *
                         */
                        var tagRegex = new RegExp('<\\w+((?:\\s[\\w-]+=(\'|")(?:[^\\2]*?)(?:\\2))+)[\\s\\/]*>', 'gim');
                        var attsRegex = new RegExp('(?:\\s[\\w-]+=(\'|")([^\\1]*?)(?:\\1))', 'gim');
                        var replaceSlugs = [ 'template-block-', 'my-content-', 'block-settings-', 'aq_block_' ];
                        var replacmentRegex = new RegExp( '((' + replaceSlugs.join( '|' ) + ')' + parent_id + ')', 'gim' );
						var ns = s.replace(tagRegex, function(match){
                            return match.replace( attsRegex, function( match ) {
                                return match.replace( replacmentRegex, function( match, p1, p2 ) {
                                    //p2 is the slug without the id;
                                    return p2 + parent_id_cloned;
                                } );
                            } );
			});

			$parent.parent('ul.blocks').children('li').last()[0].outerHTML = ns;
			$parent.parent('ul.blocks').children('li').last().removeClass('ui-resizable');
			$parent.parent('ul.blocks').children('li').last().find('.ui-resizable-handle').remove();
			resizable_certain_block($('.justAppended'));
			$this = $clicked;
			var id_name = parent_id_cloned;
			$("#aq_block_"+id_name).insertBefore($("#aq_block_"+id_name).parents('.wp-editor-wrap .wp-editor-container > span'));
			$("#aq_block_"+id_name).show().next('.wp-editor-wrap .wp-editor-container > span').remove();
			var cloned_number = parseInt($('.justAppended').prev().find('.number').val()) + 1;
			$parent.closest('ul.blocks').children('li').last().children('.block-settings').find('.number').val(cloned_number);
			$('li.block').last().find('.order').val($('ul.blocks li.block').length);
			$('.icons .radioButtonIcon i.iconfontello').click(function(){
				$(this).parent().children('input').attr('checked','checked');
				$(this).parents('.icons').find('i.iconfontello').removeClass('click checked');
				$(this).addClass('click');
			});
			aqpb_colorpicker();
			if($('.justAppended').find('.wp-picker-container').find('.wp-picker-container').length !== 0 ) {
				$('.justAppended').find('.rightHalf > .aqpb-color-picker > .wp-picker-container').each(function(index,element) {
					$(element).find('.wp-color-result').first().remove();
				});
			}
			handleSize($cloned_element.children('div'));
			$('.justAppended').addClass('animate_CF cr_popup');
			tooltip_builder();
			$('select[id*="entrance_animation"]').change(function() {
				var class_added=$(this).val();
				$(this).parents('.select').find('.entrance_animation_sim').removeClass().addClass('entrance_animation_sim');
				$('.entrance_animation_sim').addClass(class_added);
			});
		}
		return false;
	});

	/** Disable blocks archive if no template **/
	$('#page-builder-column.metabox-holder-disabled').click( function() { return false; });
	$('#page-builder-column.metabox-holder-disabled #blocks-archive .block').draggable("destroy");

	/** Confirm delete template **/
	$('a.template-delete').click( function() {
		var agree = confirm('You are about to permanently delete this template. \'Cancel\' to stop, \'OK\' to delete.');
		if(agree) { return } else { return false; }
	});

	/** Cancel template save/create if no template name **/
	$('#save_template_header, #save_template_footer').click(function() {
		var template_name = $('#template-name').val().trim();
		if(template_name.length === 0) {
			$('.major-publishing-actions .open-label').addClass('form-invalid');
			return false;
		}
	});

	/** Nav tabs scrolling **/
	if(720 < tabs_width) {
		$('.aqpb-tabs-arrow').show();
		centerActiveTab();
		$('.aqpb-tabs-arrow-right a').mousedown(function() {
			mouseStilldown = true;
		    moveTabsLeft();
		}).bind('mouseup mouseleave', function() {
		    mouseStilldown = false;
		});

		$('.aqpb-tabs-arrow-left a').mousedown(function() {
			mouseStilldown = true;
		    moveTabsRight();
		}).bind('mouseup mouseleave', function() {
		    mouseStilldown = false;
		});
	}

	/** Sort nav order **/
	$('.aqpb-tabs').sortable({
		items: '.aqpb-tab-sortable',
		axis: 'x',
	});

	/** Apply CSS float:left to blocks **/
	$('li.block').css('float', '');

	$('.emptyTemplates').click(function(e) {
		e.preventDefault();
		crdn.undo.prototype.setStorage();
		$("#blocks-to-edit").html('');
	});
	saveTemplate();
	function saveTemplate() {
		$('#saveBuilderTemplates').off('click');
		$('#saveBuilderTemplates').on('click',function(e) {
			$this = $(this);
			e.preventDefault();
			if($('#saveTemplateName').val() == ''){
				$('#saveTemplateName').val('New Template');
			}
			$.ajax({
				url: global_creiden.ajax_url,
				type: "POST",
				data: $("#post").serialize() + '&action=content_builder_save_templates&saveTempName='+$('#saveTemplateName').val(),
				success: function(data) {
					$('#template-templates').append("<option value='"+$('#saveTemplateName').val()+"' class='manuallySaved'>"+$('#saveTemplateName').val()+"</option>");
					templateChange();
					$('#saveTemplateName').val('');
					$('#saveTemplatePopover').parent().popover('hide');
				}
			});
		});
	}


	$('.deleteTemplates').click(function(e) {
			$this = $(this);
			e.preventDefault();
			if($('#template-templates option:selected').hasClass('manuallySaved')) {
				$.ajax({
					url: global_creiden.ajax_url,
					type: "POST",
					data : {
						getTemp : $('#template-templates').val(),
						action : 'content_builder_delete_templates'
					},
					success: function(data) {
						$("#blocks-to-edit").html('');
						$('#template-templates option:selected').remove();
					}
				});
			} else {
				alert("This Template is from the defaults and cannot be deleted");
			}
		});
		$('#retrievePosts').click(function(e) {
			$this = $(this);
			e.preventDefault();
			$.ajax({
				url: global_creiden.ajax_url,
				type: "POST",
				data: {
					pageBlocks:  $('#blocks-to-edit').html(),
					action: 'content_builder_retrieve_blocks'
				},
				success: function(data) {
					$("#retrieveBuilderTemplate").text(data);
				}
			});
		});
		var importing_ajax_done = false;
		$('#publish').click(function(e) {
			$('#publishing-action .spinner').show();
			if($("#post_type").val() == 'page') {
				if($("#importBuilderTemplate").val() !== '') {
					if (importing_ajax_done == true) {
				        importing_ajax_done = false; // reset flag
				        return; // let the event bubble away
				    }
				    e.preventDefault();
					$.ajax({
						url: global_creiden.ajax_url,
						type: "POST",
						data : {
							importedData : $("#importBuilderTemplate").val(),
							action : 'content_builder_import_templates'
						},
						success: function(data) {
							importing_ajax_done = true;
							 $('#publish').trigger('click');
							 // $('#publishing-action .spinner').hide();
						}
					});
				} else if($("#importPageBlocks").val() !== '' && !$("#importPageBlocks").hasClass('publishPost') && $("#importPageBlocks").val() !== undefined) {
					e.preventDefault();
					var confirmthis = confirm("Please note that you will overwrite the page blocks with the imported ones");
					if(confirmthis) {
						$.ajax({
							url: global_creiden.ajax_url,
							type: "POST",
							data : {
								blocks : $("#importPageBlocks").val(),
								postID : $(".saveTemplates").data('postid'),
								action : 'content_builder_save_blocks'
							},
							success: function(data) {
								$("#importPageBlocks").addClass("publishPost");
								$('.blocks').html(data);
								$("#publish").click();
								// $('#publishing-action .spinner').hide();
							}
						});
					}

				} else {
					/*
					if(global_creiden.activate_revisions == 'Yes') {
											if (importing_ajax_done == true) {
												importing_ajax_done = false; // reset flag
												return; // let the event bubble away
											}
											var check = checkStack();
											e.preventDefault();
											$.ajax({
												url: global_creiden.ajax_url,
												type: "POST",
												data : {
													history : $("#blocks-to-edit").html(),
													postID  : $("#post_ID").val(),
													action  : 'content_builder_save_history'
												},
												success: function(data) {
													importing_ajax_done = true;
													if(check) {
														$('#publish').trigger('click');
														// $('#publishing-action .spinner').hide();
													}
												}
											});
										}	*/

				}
			}
		});

		// Get a saved Revision History
		$("#cr_revisions").change(function() {
			var requested_history = $(this).find('option:selected').data('revision');
			if(requested_history !== undefined) {
				$.ajax({
						url: global_creiden.ajax_url,
						type: "POST",
						data : {
							history : requested_history,
							postID  : $("#post_ID").val(),
							action  : 'content_builder_get_history'
						},
						beforeSend : function() {
							$('.loaderOverlay, .preloader').removeClass('hide');
							$("#page-builder .preloader").css('top',$(window).scrollTop() - 350);
						},
						success: function(data) {
							crdn.undo.prototype.setStorage();
							$("#blocks-to-edit").html(data);
							$('ul.blocks li.block.ui-resizable').removeClass('ui-resizable');
							$('ul.blocks li.block .ui-resizable-handle').remove();
							resizable_blocks();
							$('.loaderOverlay, .preloader').addClass('hide');
						}
					});
			}
		});
	$("#blocks-archive .ui-tabs-panel li").click(function() {
		block_archive = $(this).attr('id');
		$(this).clone().appendTo($("#blocks-to-edit"));
		$cloned_element = $("#blocks-to-edit > li").last();
		$cloned_element.removeAttr( 'style' );
		$cloned_element.addClass("ui-draggable");

		onSortStop(null, {item: $cloned_element});
		$cloned_element.addClass('animate_CF cr_popup');
		$('.empty-template').remove();
	});

	var timeOut;
	$('#blocks-archive li.block').hover(function() {
		$this = $(this);
		timeOut = setTimeout(function() {
			$this.find('.block-popup').stop(true,true).fadeIn(500);
		},1000);
		var height = parseInt($this.find('.block-popup').height(),10)+50;
		$this.find('.block-popup').css('margin-top',-height);
	},function() {
		$('.block-popup').fadeOut(500);
		clearTimeout(timeOut);
	});

	function aqpb_colorpicker() {
		$('#page-builder .input-color-picker').each(function(){
			var $this	= $(this),
				parent	= $this.parent();
				$this.wpColorPicker();
		});
	}
	function resizePlus(element,e) {
		// remove the current class and increase it by one
		e.preventDefault();
		crdn.undo.prototype.setStorage();
		if(element.parents('li.block').hasClass('cr-columns')) {
			if(element.parents('.cr-columns').find('.size').last().val() !== element.parents('li.block').first().find('.size').val()) {
				var currentSpan = block_size_incolumn( element.parents('li.block').first().width(), element.parents('.cr-columns'));
				var currentSpanNum = parseInt(currentSpan.substring(4)) + 1;
				if(currentSpanNum <= 12) {
					element.parents('li.block').first().toggleClass( function (index, css) {
						return (css.match (/\bspan\S+/g) || []).join(' ') + ' span' + currentSpanNum;
					});
					element.parents('li.block').first().find('.block-settings').find('.size').val('span'+currentSpanNum );
				}
				// Call the function to write the number on the block
				handleSize(element);
			}
		}
		else {
			var currentSpan = block_size( element.parents('li.block').first().width());
			var currentSpanNum = parseInt(currentSpan.substring(4)) + 1;
				if(currentSpanNum <= 12) {
					element.parents('li.block').first().toggleClass( function (index, css) {
						return (css.match (/\bspan\S+/g) || []).join(' ') + ' span' + currentSpanNum;
					});
					element.parents('li.block').first().find('.block-settings').find('.size').val('span'+currentSpanNum );
				}
				// Call the function to write the number on the block
				handleSize(element);
		}
	}
	function resizeMinus(element,e) {
		e.preventDefault();
		crdn.undo.prototype.setStorage();

		if(element.parents('li.block').hasClass('cr-columns'))
				var currentSpan = block_size_incolumn( element.parents('li.block').first().width(), element.parents('.cr-columns'));
		else
				var currentSpan = block_size( element.parents('li.block').first().width());

		var currentSpanNum = parseInt(currentSpan.substring(4)) - 1;
		if(currentSpanNum >= 2) {
			element.parents('li.block').first().toggleClass( function (index, css) {
				return (css.match (/\bspan\S+/g) || []).join(' ') + ' span' + currentSpanNum;
			});
			element.parents('li.block').first().find('.block-settings').find('.size').val('span'+currentSpanNum );
		}
		// Call the function to write the number on the block
		handleSize(element);
		// Prepare for undo and redo
	}

	function handleSize(element) {
		// it is a column
		if(element.parents('li.block').hasClass('cr-columns')) {
			element.parents('.cr-columns').find('.block-size').first().text(parseInt(element.parents('.cr-columns').find('.size').last().val().substring(4)) + '/12');
			// check for an elements inside it
			if(element.parents('li.block').find('li.block').length) {
				// there are some elements inside it
				element.parents('li.block').find('li.block').each(function (count,small_element) {
					$(small_element).find('.block-size').first().text($(small_element).find('.size').last().val().substring(4)+'/12');
				});
			} else {
				// it is a column but with no blocks inside it
				element.parents('.cr-columns').find('.block-size').first().text(parseInt(element.parents('.cr-columns').find('.size').last().val().substring(4)) + '/12');
			}
		} else {
			element.parents('li.block').find('.block-size').text(parseInt(element.parents('li.block').find('.size').last().val().substring(4)) + '/12');
		}


		/*
		if(element.parents('li.block').first().hasClass('cr-columns')) {
					// check for an elements inside it
					if(element.parents('li.block').find('li.block').length) {
						// there are some elements inside it
						element.find('li.block').each(function (count,small_element) {
							if(parseInt(element.parents('.cr-columns').find('.size').last().val().substring(4)) <= parseInt($(small_element).find('.size').last().val().substring(4))) {
								// they are equal in size so take the size of the large Column
								var currentSpan = block_size( element.parents('li.block').first().width());
								var currentSpanNum = parseInt(currentSpan.substring(4));
								element.parents('li.block').first().find('.block-size').first().text(currentSpanNum + '/12');
							} else {
								// they are not equal in size so keep each size as it is

								// handle the elements inside the column case
								var currentSpan = block_size_incolumn( $(small_element).width(), $(small_element).parents('.cr-columns'));
								var currentSpanNum = parseInt(currentSpan.substring(4));
								$(small_element).find('.block-size').text(currentSpanNum + '/12');

								// handle the column case
								var currentSpan = block_size( element.parents('li.block').first().width());
								var currentSpanNum = parseInt(currentSpan.substring(4));
								element.parents('li.block').first().find('.block-size').first().text(currentSpanNum + '/12');
							}
						});
					} else {
						// it is a column but with no blocks inside it
						var currentSpan = block_size( element.parents('li.block').first().width());
						var currentSpanNum = parseInt(currentSpan.substring(4));
						element.parents('li.block').first().find('.block-size').first().text(currentSpanNum + '/12');
					}
				}
				// it is not a column i.e normal block
				else {
					// normal block inside a column
					if(element.parents('li.block').hasClass('cr-columns')) {
						var currentSpan = block_size_incolumn( element.parents('li.block').first().width(), element.parents('.cr-columns'));
					}
					else {
					// normal block outside a column
						var currentSpan = block_size( element.parents('li.block').first().width());
					}
					var currentSpanNum = parseInt(currentSpan.substring(4));
						element.parents('li.block').first().find('.block-size').first().text(currentSpanNum + '/12');
				}
			}*/
}
		$('.crdn-expanded-fullscreen').click(function(e) {
			if($("#page-builder-frame").hasClass('crdn-expanded')) {
				$("#page-builder-frame").removeClass('crdn-expanded');
			} else {
				$("#page-builder-frame").addClass('crdn-expanded');
			}
		});

		$(document).keyup(function(e) {
			// esc closes the modal, Solves a bad bug in the bootstrap modal
		  	  if (e.keyCode == 27) {
			  	$('.modal.fade.in').modal('hide');
			  	$('.crdn-expanded').removeClass('crdn-expanded');
			  }
			  /*
			  else if( e.which === 90 && e.ctrlKey ){
									$('.cr_undo').click();
							}
							else if( e.which === 89 && e.ctrlKey ){
									$('.cr_redo').click();
							}    */

		});

		function tooltip_builder() {
			$('a[data-tooltip="tooltip"]').tooltip({
			   animated : 'fade',
			   placement : 'top',
			   container: 'body'
			});
		}

		$('select[id*="entrance_animation"]').change(function() {
				var class_added=$(this).val();
				$(this).parents('.select').find('.entrance_animation_sim').removeClass().addClass('entrance_animation_sim');
				$('.entrance_animation_sim').addClass(class_added);
			});

		$(window).scroll(function() {
			$("#page-builder .preloader").css('top',$(window).scrollTop() - 350);
		});
		$('body').append('<div class="loaderOverlay hide"></div>');

		$('#crdn-importCertainBlock button').click(function() {
			$(this).find('div').show();
			$.ajax({
				url: global_creiden.ajax_url,
				type: "POST",
				data : {
					importedData : $('#crdn-importCertainBlock textarea').val(),
					action : 'content_builder_import_certain_block'
				},
				success: function(data) {
					crdn.undo.prototype.setStorage();
					$("#blocks-to-edit").append(data);
					if($('.block').last().find('.id_base').val() == 'cr_icon_box')
					{
						$('.block').last().find('.id_base').val('cr_features_home');
					}
					checkStack();
					update_block_order();
					update_block_number();
					$('ul.blocks li.block.ui-resizable').removeClass('ui-resizable');
					$('ul.blocks li.block .ui-resizable-handle').remove();
					resizable_blocks();
					columns_sortable();
					$('#crdn-importCertainBlock textarea').html('');
					$('#crdn-importCertainBlock').modal('hide');

				}
			});
		});
		$.expr[":"].contains = $.expr.createPseudo(function(arg) {
		    return function( elem ) {
		        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
		    };
		});
		$('#cr_builder_search').keyup(function(e) {
			$("#blocks-archive li.block").hide();
			$("#blocks-archive > .ui-tabs-panel").hide();
			// $("#blocks-archive > ul").css({'display':'block'});
			// $("#blocks-archive > ul:first-child").css({'margin-bottom':'10px'});
			$("#blocks-archive > ul:first-child .ui-state-default").addClass('hide');
			$( ".block-title:contains('"+$(this).val()+"')" ).parents('.block').show().parents('.ui-tabs-panel').show();

			// $("#blocks-archive > .ui-tabs-panel").css('padding', '0px').first().css({'float':'left'});
			// $("#blocks-archive").css('padding-bottom', '10px');

			var title = $('.ui-tabs-nav a').text();
			$('.searchTitles').remove();
			$('.ui-tabs-nav li.ui-state-default').each(function(index,element) {
				$("<li class='searchTitles "+$(element).find('a').attr('href').slice(1)+"' style='background: #f8f8f8;display:none;'><h3 style='margin: 0 auto;display: table;background: none;'>"+$(element).find('a').text()+"</h3></li>").insertBefore("#"+$(element).find('a').attr('href').slice(1));
			});
			$( ".block-title:contains('"+$(this).val()+"')" ).parents('.ui-tabs-panel').each(function(index,element) {
				$('.'+$(element).attr('id')).show();
			});


			if($(this).val() == '') {
				$("#blocks-archive li.block").show();
				// $("#blocks-archive > ul:first-child").css({'margin-bottom':'0'});
				$("#blocks-archive > ul:first-child .ui-state-default").removeClass('hide');
				$("#blocks-archive > ul.ui-tabs-panel").hide();
				$("#blocks-archive > .ui-tabs-panel").first().show();
				$('#blocks-archive > .ui-tabs-nav').css('display','');
				// $("#blocks-archive > .ui-tabs-panel").css({'padding':''});
				// $("#blocks-archive").css('padding-bottom', '');
				// $("#blocks-archive > ul").css('float','');
				$('.searchTitles').remove();
			}
		});
		$('.modal.block-settings').on('shown.bs.modal', function (e) {
			  $('#post').bind("keyup keypress", function(e) {
			  var code = e.keyCode || e.which;
			  if (code  == 13) {
			    e.preventDefault();
			    return false;
			  }
			});
		}).on('hidden.bs.modal', function (e) {
			  $('#post').bind("keyup keypress", function(e) {
			  	return true;
			});
		});
});
jQuery(window).load(function() {
	jQuery("#content_woocommerce_shortcodes_button").click(function() {
			jQuery("#content_ifr").focus();
	});
});

	/** prompt save on page change **
	var aqpb_html = $('#update-page-template').html();
	$(window).bind('beforeunload', function(e) {
		var aqpb_html_new = $('#update-page-template').html();
		if(aqpb_html_new != aqpb_html) {
			return "The changes you made will be lost if you navigate away from this page.";
		}
	}); */

// what fish?